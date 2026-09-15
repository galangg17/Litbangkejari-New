<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kajian;
use App\Models\PublicProposal;
use App\Models\SystemSetting;
use App\Models\Category;
use App\Models\InnovationProposal;
use App\Models\Curriculum;
use App\Models\FormField;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $setting = SystemSetting::first() ?? new SystemSetting();
        $categories = Category::all();
        $formFields = FormField::orderBy('order_index', 'asc')->get();
        
        // DISPLAY PUBLISHED POLICY BRIEFS, INNOVATIONS & VERIFIED CURRICULUM MATERIALS (WITH FALLBACK FOR DUMMY DATA)
        $policyBriefs = Kajian::where('is_published', true)->orderBy('updated_at', 'desc')->get();
        if ($policyBriefs->isEmpty()) {
            $policyBriefs = Kajian::orderBy('updated_at', 'desc')->get();
        }

        $innovations = InnovationProposal::where('is_published', true)->orderBy('updated_at', 'desc')->get();
        if ($innovations->isEmpty()) {
            $innovations = InnovationProposal::orderBy('updated_at', 'desc')->get();
        }

        $curriculums = Curriculum::where('is_verified', true)->orderBy('updated_at', 'desc')->get();
        if ($curriculums->isEmpty()) {
            $curriculums = Curriculum::orderBy('updated_at', 'desc')->get();
        }

        $trackedTicket = null;
        if ($request->has('ticket_no') && !empty($request->ticket_no)) {
            $ticketNo = strtoupper(trim($request->ticket_no));
            $trackedTicket = PublicProposal::where('ticket_no', $ticketNo)->first();

            if ($trackedTicket) {
                // Dynamically sync status and timeline_step with linked 3 Pillars document
                $kajian = $trackedTicket->kajian ?? Kajian::where('public_proposal_id', $trackedTicket->id)->first();
                $inov = InnovationProposal::where('public_proposal_id', $trackedTicket->id)->first();

                if (($kajian && $kajian->is_published) || ($inov && $inov->is_published)) {
                    $trackedTicket->timeline_step = 4;
                    $trackedTicket->status = 'Terbit in Vault Publik';
                    $trackedTicket->last_update_note = 'Naskah / SOP Inovasi resmi terbit di Vault Publik.';
                } elseif ($kajian || $inov) {
                    if ($trackedTicket->timeline_step < 3 && !str_contains($trackedTicket->status, 'Ditolak')) {
                        $trackedTicket->timeline_step = 3;
                        $trackedTicket->status = 'Penyusunan Naskah & Review 3-Pintu';
                        $trackedTicket->last_update_note = 'Usulan sedang dipelajari & disusun dalam 3 Pilar Manajemen Pengetahuan.';
                    }
                }
            }
        }

        return view('landing.index', compact('setting', 'policyBriefs', 'innovations', 'curriculums', 'formFields', 'trackedTicket', 'categories'));
    }

    public function submitProposal(Request $request)
    {
        $setting = SystemSetting::first();
        $expectedPin = $setting ? $setting->batch_passcode : 'GAJAHMADA2026';

        // Verify Solusi A - Passcode PIN Angkatan
        if ($request->input('batch_pin') !== $expectedPin) {
            return redirect()->back()->with('error_passcode', 'Gagal: Kode PIN Akses Angkatan yang Anda masukkan salah!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'category' => 'required|string',
            'type' => 'nullable|string',
            'title' => 'required|string|max:255',
            'urgency' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,docx,doc,jpg,png,pptx,ppt|max:10240',
            'additional_files.*' => 'nullable|file|mimes:pdf,docx,doc,xls,xlsx,pptx,ppt|max:10240',
        ]);

        $type = $validated['type'] ?? 'Policy Brief';
        $seqCount = PublicProposal::where('type', $type)->count() + 1;
        $seqStr = sprintf('%02d', $seqCount);

        if ($type === 'Ide Inovasi') {
            $ticketNo = 'INOV-' . $seqStr . '/LITBANG-MADA/2026';
        } elseif ($type === 'Kurikulum') {
            $ticketNo = 'MODUL-' . $seqStr . '/LITBANG-MADA/2026';
        } else {
            $ticketNo = 'PB-' . $seqStr . '/LITBANG-MADA/2026';
        }

        $fileName = null;
        $filePath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            $filePath = '/storage/' . $file->storeAs('proposals', time() . '_' . $fileName, 'public');
        }

        $additionalPaths = [];
        if ($request->hasFile('additional_files')) {
            foreach ($request->file('additional_files') as $addFile) {
                $origName = $addFile->getClientOriginalName();
                $storePath = '/storage/' . $addFile->storeAs('proposals', time() . '_add_' . $origName, 'public');
                $additionalPaths[] = [
                    'name' => $origName,
                    'path' => $storePath,
                ];
            }
        }

        $proposal = PublicProposal::create([
            'ticket_no' => $ticketNo,
            'name' => $validated['name'],
            'institution' => $validated['institution'] ?? 'Angkatan Gajah Mada',
            'category' => $validated['category'],
            'type' => $type,
            'title' => $validated['title'],
            'urgency' => $validated['urgency'],
            'description' => $validated['description'],
            'custom_attributes' => $request->except(['_token', 'batch_pin', 'name', 'institution', 'category', 'type', 'title', 'urgency', 'description', 'attachment', 'additional_files']),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'additional_attachments' => $additionalPaths,
            'status' => 'Pengajuan (Menunggu Skrining)',
            'timeline_step' => 1,
            'last_update_note' => 'Usulan baru diterima oleh sistem. Menunggu proses skrining & keputusan Admin Sekretariat.',
        ]);

        return redirect()->back()->with('success_ticket', [
            'ticket_no' => $ticketNo,
            'title' => $validated['title'],
            'name' => $validated['name'],
            'file_name' => $fileName
        ]);
    }

    public function uploadCurriculum(Request $request)
    {
        $setting = SystemSetting::first();
        $expectedPin = $setting ? $setting->batch_passcode : 'GAJAHMADA2026';

        // Verify Solusi A - Passcode PIN Angkatan
        if ($request->input('batch_pin') !== $expectedPin) {
            return redirect()->back()->with('error_passcode', 'Gagal: Kode PIN Akses Angkatan yang Anda masukkan salah!');
        }

        $validated = $request->validate([
            'uploader_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subject_category' => 'required|string',
            'file_type' => 'required|string',
            'description' => 'nullable|string',
            'external_link' => 'nullable|url|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,docx,doc,jpg,png,pptx,ppt|max:15360',
        ]);

        $currSeq = Curriculum::count() + 1;
        $ticketNo = 'MODUL-' . sprintf('%02d', $currSeq) . '/LITBANG-MADA/2026';

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = '/storage/' . $file->storeAs('curriculums', time() . '_' . $file->getClientOriginalName(), 'public');
        } elseif (empty($validated['external_link'])) {
            $filePath = '/documents/pb_01.pdf';
        }

        Curriculum::create([
            'title' => $validated['title'],
            'subject_category' => $validated['subject_category'],
            'file_type' => $validated['file_type'],
            'batch_year' => 'PPPJ LXXXIII/II Tahun 2026',
            'uploader_name' => $validated['uploader_name'],
            'status' => 'Menunggu Verifikasi',
            'is_verified' => false,
            'description' => $validated['description'] ?? 'Materi kurikulum diunggah oleh peserta.',
            'file_path' => $filePath,
            'external_link' => $validated['external_link'] ?? null,
        ]);

        return redirect()->back()->with('success_ticket', [
            'ticket_no' => $ticketNo,
            'title' => $validated['title'],
            'name' => $validated['uploader_name'],
            'file_name' => 'Modul PPPJ Berhasil Diunggah & Menunggu Verifikasi Admin'
        ]);
    }

    private function resolveFile($filePath)
    {
        if (empty($filePath)) {
            return $this->getFallbackSamplePath();
        }

        $relPath = preg_replace('/^\/?storage\//', '', $filePath);

        $paths = [
            storage_path('app/public/' . $relPath),
            public_path(ltrim($filePath, '/')),
            base_path('../public_html' . $filePath),
            base_path('../public_html/storage/' . $relPath),
        ];

        foreach ($paths as $p) {
            if (file_exists($p) && is_readable($p) && !is_dir($p)) {
                return $p;
            }
        }

        return $this->getFallbackSamplePath();
    }

    private function getFallbackSamplePath()
    {
        $samplePaths = [
            public_path('documents/pb_01.pdf'),
            storage_path('app/public/documents/pb_01.pdf'),
            base_path('../public_html/documents/pb_01.pdf'),
        ];

        foreach ($samplePaths as $sp) {
            if (file_exists($sp) && is_readable($sp)) {
                return $sp;
            }
        }

        return null;
    }

    public function downloadDocument($type, $id)
    {
        $filePath = null;
        $fileName = 'Dokumen_Litbang';

        if ($type === 'kajian') {
            $item = Kajian::find($id);
            if ($item) {
                $current = is_numeric($item->downloads_count) ? (int)$item->downloads_count : 1420;
                $item->downloads_count = ($current + 1) . ' Download';
                $item->save();
                $filePath = $item->file_path;
                $fileName = 'Policy_Brief_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $item->doc_no ?? 'Dokumen');
            }
        } elseif ($type === 'innovation') {
            $item = InnovationProposal::find($id);
            if ($item) {
                $item->increment('downloads_count');
                $filePath = $item->sop_file_path;
                $fileName = 'SOP_Inovasi_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $item->innovation_no ?? 'Dokumen');
            }
        } elseif ($type === 'curriculum') {
            $item = Curriculum::find($id);
            if ($item) {
                $filePath = $item->file_path;
                $cleanTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', substr($item->title ?? 'Kurikulum', 0, 35));
                $fileName = 'Modul_' . ($cleanTitle ?: 'Kurikulum');
            }
        }

        $targetFile = $this->resolveFile($filePath);
        if ($targetFile) {
            $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $finalName = $fileName . ($ext ? '.' . $ext : '.pdf');
            return response()->download($targetFile, $finalName);
        }

        return redirect()->back()->with('error', 'Berkas dokumen tidak ditemukan pada server.');
    }

    public function streamDocument($type, $id)
    {
        $filePath = null;
        if ($type === 'kajian') {
            $item = Kajian::find($id);
            $filePath = $item ? $item->file_path : null;
        } elseif ($type === 'innovation') {
            $item = InnovationProposal::find($id);
            $filePath = $item ? $item->sop_file_path : null;
        } elseif ($type === 'curriculum') {
            $item = Curriculum::find($id);
            $filePath = $item ? $item->file_path : null;
        }

        $targetFile = $this->resolveFile($filePath);
        if ($targetFile) {
            $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $mime = 'application/pdf';
            if ($ext === 'pptx') $mime = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
            elseif ($ext === 'ppt') $mime = 'application/vnd.ms-powerpoint';
            elseif ($ext === 'docx') $mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            elseif ($ext === 'doc') $mime = 'application/msword';
            elseif (in_array($ext, ['png', 'jpg', 'jpeg'])) $mime = 'image/' . $ext;

            return response()->file($targetFile, ['Content-Type' => $mime]);
        }

        return redirect()->back()->with('error', 'Pratinjau dokumen tidak tersedia.');
    }

    public function downloadProposal($id)
    {
        $proposal = PublicProposal::find($id);
        if ($proposal) {
            $targetFile = $this->resolveFile($proposal->file_path);
            if ($targetFile) {
                $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $fileName = 'Usulan_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $proposal->ticket_no ?? 'Original') . ($ext ? '.' . $ext : '.pdf');
                return response()->download($targetFile, $fileName);
            }
        }

        $fallback = $this->getFallbackSamplePath();
        if ($fallback) {
            return response()->download($fallback, 'Usulan_Original.pdf');
        }

        return redirect()->back()->with('error', 'Berkas usulan tidak ditemukan.');
    }

    public function streamProposal($id)
    {
        $proposal = PublicProposal::find($id);
        $filePath = $proposal ? $proposal->file_path : null;

        $targetFile = $this->resolveFile($filePath);
        if ($targetFile) {
            $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $mime = 'application/pdf';
            if ($ext === 'pptx') $mime = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
            elseif ($ext === 'ppt') $mime = 'application/vnd.ms-powerpoint';
            elseif ($ext === 'docx') $mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            elseif ($ext === 'doc') $mime = 'application/msword';
            elseif (in_array($ext, ['png', 'jpg', 'jpeg'])) $mime = 'image/' . $ext;

            return response()->file($targetFile, ['Content-Type' => $mime]);
        }

        return redirect()->back()->with('error', 'Pratinjau berkas usulan tidak tersedia.');
    }
}
