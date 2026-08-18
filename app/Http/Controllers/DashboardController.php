<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kajian;
use App\Models\SystemSetting;
use App\Models\PublicProposal;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $setting = SystemSetting::first();
        if (!$setting) {
            $setting = SystemSetting::create([
                'institution_name' => 'Senat Gajah Mada Adhyaksa',
                'period' => '2025/2026',
            ]);
        }

        $activeTab = $request->get('tab', 'dashboard');
        $kajianList = Kajian::orderBy('id', 'desc')->get();
        $pendingProposals = PublicProposal::orderBy('id', 'desc')->get();
        $categories = Category::all();
        $users = User::orderBy('id', 'desc')->get();

        $metrics = [
            'ingestionInbox' => PublicProposal::where('status', 'like', '%Pengajuan%')->count(),
            'isu' => Kajian::where('status', 'Isu Baru')->count() + PublicProposal::count(),
            'dalamKajian' => Kajian::where('status', 'Dalam Kajian')->count(),
            'dalamReview' => Kajian::where('status', 'Direspon')->count(),
            'publikasi' => Kajian::where('status', 'Publish & Vault')->count(),
        ];

        // Pipeline 4-Stage Summary
        $pipelineStages = [
            ['label' => '1. PENGAJUAN', 'count' => PublicProposal::count()],
            ['label' => '2. DIKAJI', 'count' => Kajian::where('status', 'Dalam Kajian')->count()],
            ['label' => '3. DIRESPON', 'count' => Kajian::where('status', 'Direspon')->count()],
            ['label' => '4. PUBLISH & VAULT', 'count' => Kajian::where('status', 'Publish & Vault')->count()],
        ];

        return view('dashboard.index', compact('setting', 'activeTab', 'kajianList', 'pendingProposals', 'metrics', 'pipelineStages', 'categories', 'users'));
    }

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

    public function storeKajian(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'pic_team' => 'required|string',
            'summary' => 'required|string',
            'status' => 'nullable|string',
            'urgency' => 'nullable|string',
            'show_researcher_name' => 'nullable|boolean',
        ]);

        Kajian::create([
            'title' => $validated['title'],
            'doc_no' => 'PB-' . rand(10, 99) . '/LITBANG-MADA/2026',
            'category' => $validated['category'],
            'pic_team' => $validated['pic_team'],
            'summary' => $validated['summary'],
            'status' => $request->input('status', 'Dalam Kajian'),
            'urgency' => $request->input('urgency', 'Tinggi'),
            'show_researcher_name' => $request->has('show_researcher_name') ? (bool)$request->input('show_researcher_name') : true,
            'content' => "### BAB I: PENDAHULIAN\nUraian naskah academis resmi...\n\n### BAB II: TINJAUAN YURIDIS\nUraian landasan hukum...",
            'bab1_pendahuluan' => "### BAB I: PENDAHULIAN & LATAR BELAKANG\nLatar belakang isu strategis...",
            'bab2_tinjauan_yuridis' => "### BAB II: TINJAUAN YURIDIS\nTinjauan pasal dan undang-undang...",
            'bab3_metodologi_audit' => "### BAB III: METODOLOGI AUDIT\nMetodologi pembuktian data...",
            'bab4_rekomendasi_brief' => "### BAB IV: FORMULASI REKOMENDASI\nRekomendasi taktis...",
            'bab5_juknis_sop' => "### BAB V: STANDAR OPERASIONAL PROSEDUR (SOP)\nTahapan operasional...",
            'impact_score' => 'Penetapan Regulasi',
            'downloads_count' => '0 Download',
            'read_time' => '12 Halaman Dokumen Lengkap',
            'infographic_points' => [
                'Point Rekomendasi 1',
                'Point Rekomendasi 2',
                'Point Rekomendasi 3',
            ],
        ]);

        return redirect()->route('dashboard.index', ['tab' => 'research'])
            ->with('toast', 'Naskah Kajian Baru Berhasil Ditambahkan ke Studio Kajian!');
    }

    public function disposition(Request $request, $id)
    {
        $proposal = PublicProposal::findOrFail($id);
        $action = $request->input('action', 'approve');

        if ($action === 'approve') {
            $proposal->update([
                'status' => 'Direspon & Dikaji',
                'disposition_team' => $request->input('disposition_team', 'Tim Riset 1 (Pidsus & Ekonomi)'),
                'official_response' => $request->input('official_response', 'TANGGAPAN RESMI TIM RISET: Usulan telah disetujui dan saat ini sedang dikaji oleh Tim Riset.'),
                'timeline_step' => 2,
                'last_update_note' => 'Disetujui Admin Sekretariat & Didisposisikan ke ' . $request->input('disposition_team'),
            ]);

            Kajian::create([
                'public_proposal_id' => $proposal->id,
                'title' => $proposal->title,
                'doc_no' => 'PB-' . rand(10, 99) . '/LITBANG-MADA/2026',
                'category' => $proposal->category,
                'pic_team' => $proposal->disposition_team,
                'summary' => $proposal->description,
                'status' => 'Dalam Kajian',
                'urgency' => $proposal->urgency,
                'content' => "### BAB I: PENDAHULIAN & LATAR BELAKANG\nTindak lanjut dari usulan publik Tiket " . $proposal->ticket_no,
                'bab1_pendahuluan' => "### BAB I: PENDAHULIAN\nTindak lanjut usulan publik " . $proposal->title,
            ]);

            return redirect()->route('dashboard.index', ['tab' => 'ingestion'])
                ->with('toast', 'Usulan Publik Berhasil Didisposisikan ke Tim Riset!');
        } else {
            $proposal->update([
                'status' => 'Ditolak',
                'official_response' => 'TANGGAPAN RESMI: Usulan ditolak karena berada di luar wewenang LITBANG Senat Adhyaksa.',
                'timeline_step' => 1,
                'last_update_note' => 'Usulan ditolak oleh Sekretariat Admin.',
            ]);

            return redirect()->route('dashboard.index', ['tab' => 'ingestion'])
                ->with('toast', 'Usulan Telah Ditandai Ditolak.');
        }
    }

    public function updateReview(Request $request, $id)
    {
        $kajian = Kajian::findOrFail($id);
        $kajian->update([
            'review_substansi' => $request->has('review_substansi'),
            'review_metodologi' => $request->has('review_metodologi'),
            'review_legal' => $request->has('review_legal'),
            'signed_by_ketua' => $request->has('signed_by_ketua'),
        ]);

        if ($kajian->signed_by_ketua && $kajian->review_substansi && $kajian->review_metodologi) {
            $kajian->update([
                'status' => 'Publish & Vault',
            ]);

            if ($kajian->proposal) {
                $kajian->proposal->update([
                    'status' => 'Terbit & Vault',
                    'timeline_step' => 4,
                    'last_update_note' => 'Policy Brief resmi telah diterbitkan dan tersimpan di Vault Repositori.',
                ]);
            }
        } else {
            $kajian->update([
                'status' => 'Direspon',
            ]);
        }

        return redirect()->route('dashboard.index', ['tab' => 'policy'])
            ->with('toast', 'Checklist Review 3-Pintu & Pengesahan Ketua Berhasil Diperbarui!');
    }

    // Category CRUD Management
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
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

    public function resetData()
    {
        PublicProposal::truncate();
        Kajian::truncate();

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Seluruh Data Usulan & Kajian Simulasi Berhasil Dikosongkan!');
    }

    public function updateSettings(Request $request)
    {
        $setting = SystemSetting::first();
        if (!$setting) {
            $setting = new SystemSetting();
        }

        $setting->institution_name = $request->input('institution_name', 'Senat Gajah Mada Adhyaksa');
        $setting->tagline = $request->input('tagline', 'Dari Kajian, Lahir Rekomendasi.');
        $setting->period = $request->input('period', '2025/2026');
        $setting->ketua_tim_riset = $request->input('ketua_tim_riset', 'Dr. Sdr. Pratama, S.H., M.H.');
        $setting->max_file_size_mb = $request->input('max_file_size_mb', '10');
        $setting->save();

        return redirect()->route('dashboard.index', ['tab' => 'settings'])
            ->with('toast', 'Pengaturan Sistem Berhasil Diperbarui!');
    }
}
