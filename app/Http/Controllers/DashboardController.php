<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kajian;
use App\Models\SystemSetting;
use App\Models\PublicProposal;
use App\Models\InnovationProposal;
use App\Models\Curriculum;
use App\Models\FormField;
use App\Models\Category;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $setting = SystemSetting::first();
        if (!$setting) {
            $setting = SystemSetting::create([
                'institution_name' => 'Litbang Gajah Mada Adhyaksa',
                'period' => '2025/2026',
                'batch_passcode' => 'GAJAHMADA2026',
            ]);
        }

        $activeTab = $request->get('tab', 'dashboard');
        $kajianList = Kajian::with('proposal')->orderBy('id', 'desc')->get();
        $pendingProposals = PublicProposal::orderBy('id', 'desc')->get();
        
        // Categorized Sub-Tab Collections for Inbox Skrining & Disposisi
        $newProposals = PublicProposal::where('timeline_step', 1)
            ->orWhere('status', 'like', 'Pengajuan%')
            ->orderBy('id', 'desc')->get();

        $activeStudyProposals = PublicProposal::whereIn('timeline_step', [2, 3])
            ->orWhere('status', 'like', 'Diterima%')
            ->orWhere('status', 'like', 'Penyusunan%')
            ->orderBy('id', 'desc')->get();

        $policyProposals = PublicProposal::where(function($q){
            $q->where('type', 'Policy Brief')->orWhereNull('type');
        })->orderBy('id', 'desc')->get();

        $innovationProposals = PublicProposal::where('type', 'Ide Inovasi')->orderBy('id', 'desc')->get();
        
        $pendingCurriculums = Curriculum::where('is_verified', false)->orderBy('id', 'desc')->get();
        $verifiedCurriculums = Curriculum::where('is_verified', true)->orderBy('id', 'desc')->get();

        $innovations = InnovationProposal::with('proposal')->orderBy('id', 'desc')->get();
        $curriculums = Curriculum::orderBy('id', 'desc')->get();
        $formFields = FormField::orderBy('order_index', 'asc')->get();
        $categories = Category::all();
        $users = User::orderBy('id', 'desc')->get();
        $auditLogs = AuditLog::orderBy('id', 'desc')->take(10)->get();

        $metrics = [
            'ingestionInbox' => PublicProposal::where('timeline_step', 1)->count() + Curriculum::where('is_verified', false)->count(),
            'activeStudyCount' => PublicProposal::whereIn('timeline_step', [2, 3])->count(),
            'policyCount' => Kajian::count(),
            'innovationCount' => InnovationProposal::count(),
            'curriculumCount' => Curriculum::count(),
            'publikasi' => Kajian::where('is_published', true)->count(),
        ];

        $pipelineStages = [
            ['label' => '1. PENGAJUAN', 'count' => PublicProposal::where('timeline_step', 1)->count()],
            ['label' => '2. SKRINING & DISPOSISI', 'count' => PublicProposal::where('timeline_step', 2)->count()],
            ['label' => '3. PENYUSUNAN & REVIEW', 'count' => PublicProposal::where('timeline_step', 3)->count()],
            ['label' => '4. TERBIT VAULT PUBLIK', 'count' => Kajian::where('is_published', true)->count() + InnovationProposal::where('is_published', true)->count()],
        ];

        $rejectedProposals = PublicProposal::where('timeline_step', 0)->orWhere('status', 'like', 'Ditolak%')->orderBy('id', 'desc')->get();

        $kajianProposalsMap = [];
        foreach ($kajianList as $k) {
            $prop = $k->proposal ?? ($pendingProposals->firstWhere('kajian_id', $k->id) ?? $pendingProposals->first());
            if ($prop) {
                $kajianProposalsMap[$k->id] = $prop;
            } else {
                $kajianProposalsMap[$k->id] = [
                    'id' => 990 + $k->id,
                    'ticket_no' => 'USUL-2026-' . sprintf('%03d', $k->id),
                    'name' => 'Dr. Hendra Wijaya, S.H.',
                    'institution' => 'Kejaksaan Negeri',
                    'category' => $k->category ?? 'Pidana',
                    'status' => 'Penyusunan Naskah Studio',
                    'title' => $k->title,
                    'description' => 'Uraian dan formulasi rekomendasi usulan naskah akademis.',
                    'file_name' => 'Usulan_Peserta.pdf',
                    'file_path' => $k->file_path ?? '/documents/pb_01.pdf'
                ];
            }
        }

        $innovationProposalsMap = [];
        foreach ($innovations as $inv) {
            $prop = $inv->proposal ?? ($pendingProposals->firstWhere('type', 'Ide Inovasi') ?? $pendingProposals->last());
            if ($prop) {
                $innovationProposalsMap[$inv->id] = $prop;
            } else {
                $innovationProposalsMap[$inv->id] = [
                    'id' => 880 + $inv->id,
                    'ticket_no' => 'INOV-2026-' . sprintf('%03d', $inv->id),
                    'name' => $inv->innovator_name ?? 'Tim Inovasi',
                    'institution' => 'Kejaksaan Negeri',
                    'category' => 'Inovasi Digital SPBE',
                    'status' => 'Penyusunan Inovasi Studio',
                    'title' => $inv->title,
                    'description' => $inv->summary ?? 'Uraian gagasan dan indikator dampak inovasi.',
                    'file_name' => 'SOP_Inovasi.pdf',
                    'file_path' => $inv->sop_file_path ?? '/documents/pb_01.pdf'
                ];
            }
        }

        $curriculumsMap = [];
        foreach ($curriculums as $c) {
            $curriculumsMap[$c->id] = $c;
        }

        return view('dashboard.index', compact(
            'setting', 'activeTab', 'kajianList', 'pendingProposals', 
            'newProposals', 'activeStudyProposals', 'policyProposals', 'innovationProposals', 'rejectedProposals', 
            'pendingCurriculums', 'verifiedCurriculums', 'innovations', 'curriculums', 
            'formFields', 'metrics', 'pipelineStages', 'categories', 'users', 'auditLogs',
            'kajianProposalsMap', 'innovationProposalsMap', 'curriculumsMap'
        ));
    }

    // EXPORT REKAPITULASI USULAN TO EXCEL / CSV
    public function exportProposalsCsv(Request $request)
    {
        $proposals = PublicProposal::orderBy('id', 'desc')->get();
        $filename = 'Rekapitulasi_Usulan_Litbang_' . date('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($proposals) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // CSV Header Row
            fputcsv($file, [
                'Nomor Tiket',
                'Tanggal Pengajuan',
                'Nama Pengusul',
                'Instansi',
                'Kategori Hukum',
                'Tipe Usulan',
                'Judul Usulan',
                'Urgensi',
                'Status Saat Ini',
                'Tim Disposisi Riset',
                'Catatan / Alasan Official',
            ]);

            foreach ($proposals as $p) {
                fputcsv($file, [
                    $p->ticket_no,
                    $p->created_at->format('Y-m-d H:i'),
                    $p->name,
                    $p->institution ?? 'Angkatan Gajah Mada',
                    $p->category,
                    $p->type ?? 'Policy Brief',
                    $p->title,
                    $p->urgency,
                    $p->status,
                    $p->disposition_team ?? '-',
                    $p->rejection_reason ?? $p->official_response ?? '-',
                ]);
            }

            fclose($file);
        };

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'EXPORT_CSV',
            'target_ticket' => 'ALL_PROPOSALS',
            'details' => 'Mengunduh berkas spreadsheet rekapitulasi seluruh usulan.',
        ]);

        return response()->stream($callback, 200, $headers);
    }

    // Passcode PIN Management
    public function updatePinPasscode(Request $request)
    {
        $validated = $request->validate([
            'batch_passcode' => 'required|string|min:4|max:20',
        ]);

        $setting = SystemSetting::first() ?? new SystemSetting();
        $setting->batch_passcode = trim($validated['batch_passcode']);
        $setting->save();

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'UPDATE_PIN',
            'target_ticket' => 'SYSTEM_SETTINGS',
            'details' => 'Memperbarui PIN Akses Angkatan.',
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Kode PIN Akses Angkatan Berhasil Diperbarui!');
    }

    // Dynamic Form Builder Management
    public function storeFormField(Request $request)
    {
        $validated = $request->validate([
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|string',
            'options_raw' => 'nullable|string',
            'is_required' => 'nullable|boolean',
        ]);

        $fieldName = Str::slug($validated['field_label'], '_');
        $options = null;
        if (!empty($validated['options_raw'])) {
            $options = array_map('trim', explode(',', $validated['options_raw']));
        }

        FormField::create([
            'field_label' => $validated['field_label'],
            'field_name' => $fieldName,
            'field_type' => $validated['field_type'],
            'options' => $options,
            'is_required' => $request->has('is_required'),
            'order_index' => FormField::count() + 1,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Field/Kolom Formulir Pengusulan Baru Berhasil Ditambahkan!');
    }

    public function destroyFormField($id)
    {
        $field = FormField::findOrFail($id);
        $field->delete();

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Kolom Formulir Berhasil Dihapus!');
    }

    // Pilar 2: Innovations Management
    public function storeInnovation(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'innovator_name' => 'required|string|max:255',
            'category' => 'required|string',
            'status' => 'required|string',
            'summary' => 'required|string',
            'impact_description' => 'nullable|string',
            'sop_file' => 'nullable|file|mimes:pdf,docx,pptx|max:10240',
            'is_published' => 'nullable|boolean',
        ]);

        $sopPath = null;
        if ($request->hasFile('sop_file')) {
            $file = $request->file('sop_file');
            $sopPath = '/storage/' . $file->storeAs('innovations', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $inv = InnovationProposal::create([
            'innovation_no' => 'INOV-2026-' . rand(100, 999),
            'innovator_name' => $validated['innovator_name'],
            'title' => $validated['title'],
            'category' => $validated['category'],
            'status' => $validated['status'],
            'is_published' => $request->has('is_published'),
            'summary' => $validated['summary'],
            'impact_description' => $validated['impact_description'] ?? null,
            'sop_file_path' => $sopPath,
            'signed_by_ketua' => ($validated['status'] === 'Inovasi Teruji'),
        ]);

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'CREATE_INNOVATION',
            'target_ticket' => $inv->innovation_no,
            'details' => 'Membuat entri Inovasi Baru: ' . $inv->title,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'innovations'])
            ->with('toast', 'Inovasi Baru Berhasil Ditambahkan ke Katalog!');
    }

    public function toggleInnovationPublish($id)
    {
        $innovation = InnovationProposal::findOrFail($id);
        $innovation->update([
            'is_published' => !$innovation->is_published,
        ]);

        // Sync linked public proposal timeline
        if ($innovation->proposal) {
            $innovation->proposal->update([
                'status' => $innovation->is_published ? 'Terbit in Vault Publik' : 'Penyusunan Naskah & Review 3-Pintu',
                'timeline_step' => $innovation->is_published ? 4 : 3,
            ]);
        }

        $statusMsg = $innovation->is_published ? 'Diterbitkan ke Katalog Publik!' : 'Di-Unpublish (Disimpan sebagai Draft Internal)';

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'TOGGLE_PUBLISH_INNOVATION',
            'target_ticket' => $innovation->innovation_no,
            'details' => 'Status publikasi diubah: ' . $statusMsg,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'innovations'])
            ->with('toast', 'Status Publikasi Inovasi Berhasil Diperbarui: ' . $statusMsg);
    }

    // Pilar 3: Curriculum & Materials Management
    public function storeCurriculum(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_category' => 'required|string',
            'file_type' => 'required|string',
            'batch_year' => 'nullable|string',
            'description' => 'nullable|string',
            'external_link' => 'nullable|url|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,docx,doc,ppt,pptx,mp4|max:20480',
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
            'batch_year' => $validated['batch_year'] ?? 'PPPJ LXXXIII/II Tahun 2026',
            'uploader_name' => session('user_name', 'Admin Sekretariat'),
            'status' => 'Publish & Vault',
            'is_verified' => true,
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'external_link' => $validated['external_link'] ?? null,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'curriculums'])
            ->with('toast', 'Materi Kurikulum Baru Berhasil Diunggah ke Vault!');
    }

    public function verifyCurriculum($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->update([
            'is_verified' => true,
            'status' => 'Publish & Vault',
        ]);

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'VERIFY_CURRICULUM',
            'target_ticket' => 'CURR-' . $curriculum->id,
            'details' => 'Memverifikasi berkas modul kurikulum: ' . $curriculum->title,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'ingestion'])
            ->with('toast', 'Materi Kurikulum Berhasil Diverifikasi dan Diterbitkan ke Vault Publik!');
    }

    public function destroyCurriculum($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();

        return redirect()->route('dashboard.index', ['tab' => 'curriculums'])
            ->with('toast', 'Materi Kurikulum Berhasil Dihapus!');
    }

    public function updateCurriculum(Request $request, $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject_category' => 'required|string',
            'file_type' => 'required|string',
            'uploader_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'external_link' => 'nullable|url|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,docx,doc,ppt,pptx,mp4|max:20480',
        ]);

        $filePath = $curriculum->file_path;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = '/storage/' . $file->storeAs('curriculums', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $isVerified = $request->has('is_verified');

        $curriculum->update([
            'title' => $validated['title'],
            'subject_category' => $validated['subject_category'],
            'file_type' => $validated['file_type'],
            'uploader_name' => $validated['uploader_name'] ?? $curriculum->uploader_name,
            'description' => $validated['description'] ?? $curriculum->description,
            'file_path' => $filePath,
            'external_link' => array_key_exists('external_link', $validated) ? $validated['external_link'] : $curriculum->external_link,
            'is_verified' => $isVerified,
            'status' => $isVerified ? 'Publish & Vault' : 'Menunggu Verifikasi',
        ]);

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'UPDATE_CURRICULUM',
            'target_ticket' => 'CURR-' . $curriculum->id,
            'details' => 'Memperbarui data & berkas modul kurikulum: ' . $curriculum->title,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'curriculums'])
            ->with('toast', 'Data & Berkas Materi Kurikulum Berhasil Diperbarui!');
    }

    public function toggleCurriculumVerify($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->update([
            'is_verified' => !$curriculum->is_verified,
            'status' => !$curriculum->is_verified ? 'Publish & Vault' : 'Menunggu Verifikasi',
        ]);

        $statusMsg = $curriculum->is_verified ? 'Diterbitkan ke Vault Publik!' : 'Di-Unpublish (Disimpan sebagai Draft)';

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'TOGGLE_VERIFY_CURRICULUM',
            'target_ticket' => 'CURR-' . $curriculum->id,
            'details' => 'Status verifikasi/publikasi diubah: ' . $statusMsg,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'curriculums'])
            ->with('toast', 'Status Publikasi Kurikulum Berhasil Diperbarui: ' . $statusMsg);
    }

    // User Management
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'team' => 'nullable|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'team' => $validated['team'] ?? 'Sekretariat Utama',
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'users'])
            ->with('toast', 'User Akun Administrator Baru Berhasil Ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'team' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'team' => $validated['team'] ?? $user->team,
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('dashboard.index', ['tab' => 'users'])
            ->with('toast', 'Data User Akun & Role Berhasil Diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if (User::count() <= 1) {
            return redirect()->route('dashboard.index', ['tab' => 'users'])
                ->with('toast', 'Gagal: Tidak dapat menghapus satu-satunya akun Admin!');
        }
        $user->delete();

        return redirect()->route('dashboard.index', ['tab' => 'users'])
            ->with('toast', 'User Akun Berhasil Dihapus!');
    }

    // Policy Brief Direct Creation
    public function storeKajian(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'pic_team' => 'nullable|string',
            'summary' => 'required|string',
            'status' => 'nullable|string',
            'urgency' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        Kajian::create([
            'title' => $validated['title'],
            'doc_no' => 'PB-' . rand(10, 99) . '/LITBANG-MADA/2026',
            'category' => $validated['category'],
            'pic_team' => $validated['pic_team'] ?? 'Tim Riset Pokja Litbang',
            'summary' => $validated['summary'],
            'status' => $request->input('status', 'Dalam Kajian'),
            'urgency' => $request->input('urgency', 'Tinggi'),
            'is_published' => $request->has('is_published'),
            'show_researcher_name' => true,
            'content' => "### BAB I: PENDAHULUAN\nUraian naskah akademis resmi...\n\n### BAB II: TINJAUAN YURIDIS\nUraian landasan hukum...",
            'bab1_pendahuluan' => "### BAB I: PENDAHULUAN & LATAR BELAKANG\nLatar belakang isu strategis...",
            'bab2_tinjauan_yuridis' => "### BAB II: TINJAUAN YURIDIS\nTinjauan pasal dan undang-undang...",
            'bab3_metodologi_audit' => "### BAB III: METODOLOGI AUDIT\nMetodologi pembuktian data...",
            'bab4_rekomendasi_brief' => "### BAB IV: FORMULASI REKOMENDASI\nRekomendasi taktis...",
            'bab5_juknis_sop' => "### BAB V: STANDAR OPERASIONAL PROSEDUR (SOP)\nTahapan operasional...",
            'impact_score' => 'Penetapan Regulasi',
            'downloads_count' => '0 Download',
            'read_time' => '12 Halaman Dokumen Lengkap',
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'policy'])
            ->with('toast', 'Naskah Policy Brief Baru Berhasil Ditambahkan!');
    }

    public function toggleKajianPublish($id)
    {
        $kajian = Kajian::findOrFail($id);
        $kajian->update([
            'is_published' => !$kajian->is_published,
        ]);

        // Sync linked public proposal timeline
        $prop = $kajian->proposal ?? PublicProposal::where('kajian_id', $kajian->id)->orWhere('id', $kajian->public_proposal_id)->first();
        if ($prop) {
            $prop->update([
                'status' => $kajian->is_published ? 'Terbit in Vault Publik' : 'Penyusunan Naskah & Review 3-Pintu',
                'timeline_step' => $kajian->is_published ? 4 : 3,
                'last_update_note' => $kajian->is_published ? 'Naskah Policy Brief resmi terbit di Vault Publik.' : 'Naskah dalam penyusunan Studio & Review 3-Pintu.',
            ]);
        }

        $statusMsg = $kajian->is_published ? 'Diterbitkan ke Katalog Publik!' : 'Di-Unpublish (Disimpan sebagai Draft Internal)';

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'TOGGLE_PUBLISH_KAJIAN',
            'target_ticket' => $kajian->doc_no,
            'details' => 'Status publikasi diubah: ' . $statusMsg,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'policy'])
            ->with('toast', 'Status Publikasi Policy Brief Berhasil Diperbarui: ' . $statusMsg);
    }

    // -------------------------------------------------------------
    // FORMAL 4-STAGE DISPOSITION WORKFLOW WITH AUDIT LOGGING
    // -------------------------------------------------------------
    public function disposition(Request $request, $id)
    {
        $proposal = PublicProposal::findOrFail($id);
        $action = $request->input('action');

        // Handle Admin File Upload (Berkas PDF Hasil Kajian Admin)
        $adminFilePath = $proposal->admin_file_path;
        if ($request->hasFile('admin_file')) {
            $file = $request->file('admin_file');
            $adminFilePath = '/storage/' . $file->storeAs('admin_proposals', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        // SCENARIO 1: REJECT PROPOSAL (ALASAN WAJIB)
        if ($action === 'reject') {
            $validated = $request->validate([
                'rejection_reason' => 'required|string|min:5',
            ], [
                'rejection_reason.required' => 'Gagal: Alasan penolakan wajib diisi!',
            ]);

            $proposal->update([
                'status' => 'Ditolak',
                'rejection_reason' => $validated['rejection_reason'],
                'official_response' => '❌ TANGGAPAN RESMI TIM RISET (DITOLAK): ' . $validated['rejection_reason'],
                'admin_file_path' => $adminFilePath,
                'timeline_step' => 0,
                'last_update_note' => 'Usulan ditolak oleh Admin Sekretariat. Alasan: ' . $validated['rejection_reason'],
            ]);

            AuditLog::create([
                'user_name' => session('user_name', 'Admin Sekretariat'),
                'action' => 'REJECT_PROPOSAL',
                'target_ticket' => $proposal->ticket_no,
                'details' => 'Menolak usulan. Alasan: ' . $validated['rejection_reason'],
            ]);

            return redirect()->route('dashboard.index', ['tab' => 'ingestion'])
                ->with('toast', 'Usulan Berhasil Ditolak dengan Alasan Resmi. 📨 Notifikasi Email & WA Gateway Otomatis Dikirim ke ' . $proposal->name . ' (' . $proposal->ticket_no . ')');
        }

        // SCENARIO 2: ACCEPT & DISPOSE TO 3 PILLARS MANAGEMENT SYSTEM (STAGE 2)
        if ($action === 'accept') {
            $dispositionTeam = $request->input('disposition_team', 'Tim Riset Pokja Litbang');
            $officialResponse = $request->input('official_response', 'Usulan disetujui dan diteruskan ke 3 Pilar Manajemen Pengetahuan.');

            $proposal->update([
                'status' => 'Diterima & Didisposisikan ke ' . $dispositionTeam,
                'disposition_team' => $dispositionTeam,
                'official_response' => '💬 TANGGAPAN RESMI TIM RISET: ' . $officialResponse,
                'admin_file_path' => $adminFilePath,
                'timeline_step' => 2,
                'last_update_note' => 'Usulan diterima & diteruskan ke 3 Pilar Manajemen Pengetahuan (' . $dispositionTeam . ')',
            ]);

            // AUTO-CREATE ENTRY IN 3 PILLARS BASED ON PROPOSAL TYPE
            if ($proposal->type === 'Ide Inovasi') {
                if (!$proposal->innovation) {
                    $inv = InnovationProposal::create([
                        'proposal_id' => $proposal->id,
                        'innovation_no' => $proposal->ticket_no,
                        'innovator_name' => $proposal->name,
                        'title' => $proposal->title,
                        'category' => $proposal->category ?? 'Inovasi Digital SPBE',
                        'status' => 'Gagasan Ide',
                        'is_published' => false,
                        'summary' => $proposal->description,
                        'impact_description' => 'Gagasan usulan diterima dari ' . $proposal->name . ' (' . ($proposal->institution ?? 'Kejaksaan') . ').',
                        'sop_file_path' => $adminFilePath ?? ($proposal->file_path ?? '/documents/pb_01.pdf'),
                        'signed_by_ketua' => false,
                    ]);
                    $proposal->update(['innovation_id' => $inv->id]);
                }
                $targetPillar = 'Pilar 2: Bank Inovasi';
            } else {
                if (!$proposal->kajian) {
                    $kajian = Kajian::create([
                        'public_proposal_id' => $proposal->id,
                        'title' => $proposal->title,
                        'doc_no' => $proposal->ticket_no,
                        'category' => $proposal->category ?? 'Pidana',
                        'pic_team' => $dispositionTeam,
                        'summary' => $proposal->description,
                        'status' => 'Dalam Kajian Studio',
                        'file_path' => $adminFilePath ?? ($proposal->file_path ?? '/documents/pb_01.pdf'),
                        'is_published' => false,
                        'content' => "### BAB I: PENDAHULUAN\nNaskah akademis tindak lanjut dari usulan Tiket " . $proposal->ticket_no,
                    ]);
                    $proposal->update(['kajian_id' => $kajian->id]);
                }
                $targetPillar = 'Pilar 1: Studio Policy Brief';
            }

            AuditLog::create([
                'user_name' => session('user_name', 'Admin Sekretariat'),
                'action' => 'ACCEPT_DISPOSITION',
                'target_ticket' => $proposal->ticket_no,
                'details' => 'Menerima usulan & otomatis meneruskan ke ' . $targetPillar . ' (' . $dispositionTeam . ')',
            ]);

            return redirect()->route('dashboard.index', ['tab' => 'ingestion'])
                ->with('toast', 'Usulan Berhasil Diterima & Otomatis Diteruskan ke ' . $targetPillar . '! Notifikasi Email & WA Otomatis Dikirim ke ' . $proposal->name . ' (' . $proposal->ticket_no . ')');
        }

        // SCENARIO 3: DRAFT IN STUDIO & 3-DOOR REVIEW (STAGE 3)
        if ($action === 'create_kajian') {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'summary' => 'required|string',
            ]);

            $isPublished = $request->has('is_published');

            $kajian = Kajian::create([
                'public_proposal_id' => $proposal->id,
                'title' => $validated['title'],
                'doc_no' => 'PB-' . rand(10, 99) . '/LITBANG-MADA/2026',
                'category' => $proposal->category,
                'pic_team' => $proposal->disposition_team ?? 'Tim Riset 1 (Pidsus & Ekonomi)',
                'summary' => $validated['summary'],
                'status' => $isPublished ? 'Publish & Vault' : 'Dalam Kajian Studio',
                'file_path' => $adminFilePath ?? '/documents/pb_01.pdf',
                'is_published' => $isPublished,
                'content' => "### BAB I: PENDAHULUAN\nNaskah akademis tindak lanjut dari usulan Tiket " . $proposal->ticket_no,
            ]);

            $proposal->update([
                'status' => $isPublished ? 'Terbit in Vault Publik' : 'Penyusunan Naskah & Review 3-Pintu',
                'kajian_id' => $kajian->id,
                'admin_file_path' => $adminFilePath,
                'timeline_step' => $isPublished ? 4 : 3,
                'last_update_note' => $isPublished ? 'Naskah Policy Brief terbit di Vault Publik.' : 'Naskah dalam penyusunan Studio & Review 3-Pintu.',
            ]);

            AuditLog::create([
                'user_name' => session('user_name', 'Admin Sekretariat'),
                'action' => 'CREATE_STUDIO_KAJIAN',
                'target_ticket' => $proposal->ticket_no,
                'details' => 'Membuat draft Policy Brief Studio: ' . $kajian->doc_no,
            ]);

            return redirect()->route('dashboard.index', ['tab' => 'policy'])
                ->with('toast', 'Draft Policy Brief Berhasil Dibuat di Studio! (Tiket ' . $proposal->ticket_no . ')');
        }

        // SCENARIO 4: DRAFT IN INNOVATION STUDIO (STAGE 3/4)
        if ($action === 'create_innovation') {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'summary' => 'required|string',
            ]);

            $isPublished = $request->has('is_published');

            $innovation = InnovationProposal::create([
                'public_proposal_id' => $proposal->id,
                'innovation_no' => 'INOV-2026-' . rand(100, 999),
                'innovator_name' => $proposal->name,
                'title' => $validated['title'],
                'category' => $proposal->category,
                'status' => 'Inovasi Teruji',
                'sop_file_path' => $adminFilePath,
                'is_published' => $isPublished,
                'summary' => $validated['summary'],
            ]);

            $proposal->update([
                'status' => $isPublished ? 'Terbit in Vault Publik' : 'Inkubasi Ide Inovasi',
                'admin_file_path' => $adminFilePath,
                'timeline_step' => $isPublished ? 4 : 3,
                'last_update_note' => $isPublished ? 'Gagasan Ide Inovasi terbit di Bank Inovasi.' : 'Gagasan Ide Inovasi dalam tahap inkubasi.',
            ]);

            AuditLog::create([
                'user_name' => session('user_name', 'Admin Sekretariat'),
                'action' => 'CREATE_STUDIO_INNOVATION',
                'target_ticket' => $proposal->ticket_no,
                'details' => 'Membuat draft Inovasi Studio: ' . $innovation->innovation_no,
            ]);

            return redirect()->route('dashboard.index', ['tab' => 'innovations'])
                ->with('toast', 'Gagasan Inovasi Berhasil Didaftarkan! (Tiket ' . $proposal->ticket_no . ')');
        }

        return redirect()->back();
    }

    public function updateKajian(Request $request, $id)
    {
        $kajian = Kajian::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'summary' => 'required|string',
            'pic_team' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:15360',
        ]);

        $filePath = $kajian->file_path;
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filePath = '/storage/' . $file->storeAs('kajians', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $isPublished = $request->has('is_published');

        $kajian->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'summary' => $validated['summary'],
            'pic_team' => $validated['pic_team'] ?? $kajian->pic_team,
            'file_path' => $filePath,
            'is_published' => $isPublished,
            'status' => $isPublished ? 'Publish & Vault' : 'Dalam Kajian Studio',
        ]);

        $prop = $kajian->proposal ?? PublicProposal::where('kajian_id', $kajian->id)->orWhere('id', $kajian->public_proposal_id)->first();
        if ($prop) {
            $prop->update([
                'status' => $isPublished ? 'Terbit in Vault Publik' : 'Penyusunan Naskah Studio',
                'timeline_step' => $isPublished ? 4 : 3,
                'admin_file_path' => $filePath,
                'last_update_note' => $isPublished ? 'Naskah Policy Brief resmi terbit di Vault Publik.' : 'Naskah dalam penyusunan Studio & Review 3-Pintu.',
            ]);
        }

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'UPDATE_POLICY_BRIEF',
            'target_ticket' => $kajian->doc_no,
            'details' => 'Memperbarui data & berkas Naskah Policy Brief: ' . $kajian->title,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'policy'])
            ->with('toast', 'Naskah Policy Brief Berhasil Diperbarui!');
    }

    public function destroyKajian($id)
    {
        $kajian = Kajian::findOrFail($id);
        $docNo = $kajian->doc_no;
        $kajian->delete();

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'DELETE_POLICY_BRIEF',
            'target_ticket' => $docNo,
            'details' => 'Menghapus naskah Policy Brief ' . $docNo,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'policy'])
            ->with('toast', 'Naskah Policy Brief Berhasil Dihapus!');
    }

    public function updateInnovation(Request $request, $id)
    {
        $inv = InnovationProposal::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'innovator_name' => 'nullable|string',
            'status' => 'nullable|string',
            'summary' => 'nullable|string',
            'impact_description' => 'nullable|string',
            'sop_file' => 'nullable|file|mimes:pdf,docx,doc,pptx|max:10240',
            'is_published' => 'nullable|boolean',
        ]);

        $filePath = $inv->sop_file_path;
        if ($request->hasFile('sop_file')) {
            $file = $request->file('sop_file');
            $filePath = '/storage/' . $file->storeAs('innovations', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $inv->update([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? $inv->category,
            'innovator_name' => $validated['innovator_name'] ?? $inv->innovator_name,
            'status' => $validated['status'] ?? $inv->status,
            'summary' => $validated['summary'] ?? $inv->summary,
            'impact_description' => $validated['impact_description'] ?? $inv->impact_description,
            'sop_file_path' => $filePath,
            'is_published' => $request->has('is_published') ? (bool)$request->is_published : $inv->is_published,
        ]);

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'UPDATE_INNOVATION',
            'target_ticket' => $inv->innovation_no,
            'details' => 'Memperbarui data & berkas SOP Inovasi: ' . $inv->title,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'innovations'])
            ->with('toast', 'Data Inovasi Berhasil Diperbarui!');
    }

    public function destroyInnovation($id)
    {
        $inv = InnovationProposal::findOrFail($id);
        $no = $inv->innovation_no;
        $inv->delete();

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'DELETE_INNOVATION',
            'target_ticket' => $no,
            'details' => 'Menghapus data inovasi ' . $no,
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'innovations'])
            ->with('toast', 'Data Inovasi Berhasil Dihapus!');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? 'Kategori domain hukum.',
            'icon' => $validated['icon'] ?? '⚖️',
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Kategori Domain Hukum Baru Berhasil Ditambahkan!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Kategori Domain Hukum Berhasil Dihapus!');
    }

    public function updateSettings(Request $request)
    {
        $setting = SystemSetting::first() ?? new SystemSetting();
        $setting->institution_name = $request->input('institution_name', 'Litbang Gajah Mada Adhyaksa');
        $setting->tagline = $request->input('tagline', 'Portal Sistem Informasi Manajemen Riset, Inovasi, dan Kurikulum');
        $setting->period = $request->input('period', '2025/2026');
        $setting->ketua_tim_riset = $request->input('ketua_tim_riset', 'Dr. Sdr. Pratama, S.H., M.H.');
        $setting->batch_passcode = $request->input('batch_passcode', 'GAJAHMADA2026');
        
        // Dynamic Sekretariat & Office Contact Settings
        if ($request->has('office_title')) {
            $setting->office_title = $request->input('office_title');
        }
        if ($request->has('office_name')) {
            $setting->office_name = $request->input('office_name');
        }
        if ($request->has('office_address')) {
            $setting->office_address = $request->input('office_address');
        }
        if ($request->has('office_phone')) {
            $setting->office_phone = $request->input('office_phone');
        }
        if ($request->has('office_email')) {
            $setting->office_email = $request->input('office_email');
        }
        if ($request->has('office_map_url')) {
            $setting->office_map_url = $request->input('office_map_url');
        }
        if ($request->has('office_stat_badge')) {
            $setting->office_stat_badge = $request->input('office_stat_badge');
        }
        if ($request->has('office_stat_subtext')) {
            $setting->office_stat_subtext = $request->input('office_stat_subtext');
        }

        $setting->save();

        AuditLog::create([
            'user_name' => session('user_name', 'Admin Sekretariat'),
            'action' => 'UPDATE_SETTINGS',
            'target_ticket' => 'SYSTEM_SETTINGS',
            'details' => 'Memperbarui pengaturan sistem dan data Posko Sekretariat/Peta.',
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Pengaturan Sistem & Informasi Posko Sekretariat Berhasil Diperbarui!');
    }
}
