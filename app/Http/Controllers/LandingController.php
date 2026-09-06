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

        $randomNo = 'USUL-2026-' . rand(100, 999);
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
            'ticket_no' => $randomNo,
            'name' => $validated['name'],
            'institution' => $validated['institution'] ?? 'Angkatan Gajah Mada',
            'category' => $validated['category'],
            'type' => $validated['type'] ?? 'Policy Brief',
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
            'ticket_no' => $randomNo,
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
            'ticket_no' => 'MODUL-PPPJ-2026',
            'title' => $validated['title'],
            'name' => $validated['uploader_name'],
            'file_name' => 'Modul PPPJ Berhasil Diunggah & Menunggu Verifikasi Admin'
        ]);
    }

    public function downloadDocument($type, $id)
    {
        if ($type === 'kajian') {
            $item = Kajian::findOrFail($id);
            // Parse numeric count if string or increment
            $current = is_numeric($item->downloads_count) ? (int)$item->downloads_count : 1420;
            $item->downloads_count = ($current + 1) . ' Download';
            $item->save();

            $filePath = public_path($item->file_path);
            if (!empty($item->file_path) && file_exists($filePath)) {
                return response()->download($filePath);
            }
            return redirect()->to($item->file_path ?? '/documents/pb_01.pdf');
        }

        if ($type === 'innovation') {
            $item = InnovationProposal::findOrFail($id);
            $item->increment('downloads_count');

            if (!empty($item->sop_file_path) && file_exists(public_path($item->sop_file_path))) {
                return response()->download(public_path($item->sop_file_path));
            }
            return redirect()->to($item->sop_file_path ?? '/documents/pb_01.pdf');
        }

        if ($type === 'curriculum') {
            $item = Curriculum::findOrFail($id);
            if (!empty($item->file_path) && file_exists(public_path($item->file_path))) {
                return response()->download(public_path($item->file_path));
            }
            return redirect()->to($item->file_path ?? '/documents/pb_01.pdf');
        }

        return redirect()->back();
    }
}
