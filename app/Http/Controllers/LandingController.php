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

    public function downloadDocument($type, $id)
    {
        $filePath = null;
        $fileName = 'Dokumen_Litbang.pdf';

        if ($type === 'kajian') {
            $item = Kajian::find($id);
            if ($item) {
                $current = is_numeric($item->downloads_count) ? (int)$item->downloads_count : 1420;
                $item->downloads_count = ($current + 1) . ' Download';
                $item->save();
                $filePath = $item->file_path;
                $fileName = 'Policy_Brief_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $item->doc_no ?? 'Dokumen') . '.pdf';
            }
        } elseif ($type === 'innovation') {
            $item = InnovationProposal::find($id);
            if ($item) {
                $item->increment('downloads_count');
                $filePath = $item->sop_file_path;
                $fileName = 'SOP_Inovasi_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $item->innovation_no ?? 'Dokumen') . '.pdf';
            }
        } elseif ($type === 'curriculum') {
            $item = Curriculum::find($id);
            if ($item) {
                $filePath = $item->file_path;
                $fileName = 'Modul_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', substr($item->title ?? 'Kurikulum', 0, 30)) . '.pdf';
            }
        }

        // Try downloading target file directly via PHP stream
        if ($filePath) {
            $fullPath = public_path(ltrim($filePath, '/'));
            if (file_exists($fullPath) && is_readable($fullPath)) {
                return response()->download($fullPath, $fileName);
            }
        }

        // Fallback to sample document pb_01.pdf streamed via PHP
        $samplePath = public_path('documents/pb_01.pdf');
        if (file_exists($samplePath) && is_readable($samplePath)) {
            return response()->download($samplePath, $fileName);
        }

        return redirect()->back()->with('error', 'Berkas dokumen tidak ditemukan pada server.');
    }
}
