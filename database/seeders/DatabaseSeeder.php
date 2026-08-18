<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kajian;
use App\Models\SystemSetting;
use App\Models\PublicProposal;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Seed Users
        User::create([
            'name' => 'Administrator Sekretariat',
            'email' => 'admin@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Super Admin',
            'team' => 'Sekretariat Utama',
        ]);

        User::create([
            'name' => 'Dr. Sdr. Andi, S.H., M.H.',
            'email' => 'andi.pidsus@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Tim Riset Peneliti',
            'team' => 'Tim Riset 1 (Pidsus & Ekonomi)',
        ]);

        User::create([
            'name' => 'Dr. Hendra Wijaya, S.H.',
            'email' => 'hendra.cyber@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Tim Riset Peneliti',
            'team' => 'Tim Riset 2 (Cyber & Digital)',
        ]);

        User::create([
            'name' => 'Prof. Dr. Supratman, S.H., M.H.',
            'email' => 'supratman.review@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Reviewer Penguji',
            'team' => 'Dewan Pakar Akademis',
        ]);

        // 1. System Setting
        SystemSetting::create([
            'institution_name' => 'Senat Gajah Mada Adhyaksa',
            'tagline' => 'Transformasi Hasil Riset Akademis Menjadi Instrumen Kebijakan Strategis Penegakan Hukum.',
            'period' => '2025/2026',
            'ketua_tim_riset' => 'Dr. Sdr. Pratama, S.H., M.H.',
            'max_file_size_mb' => '10',
            'vault_encryption' => 'AES-256 Enabled',
        ]);

        // 2. Initial Categories
        Category::create(['name' => 'Tindak Pidana Khusus & Ekonomi', 'slug' => 'pidana-khusus', 'description' => 'Fokus penanganan korupsi, TPPU, dan perampasan aset kejahatan lintas batas.', 'icon' => '🏛️']);
        Category::create(['name' => 'Digitalisasi Hukum & Kripto', 'slug' => 'digitalisasi-hukum', 'description' => 'Audit forensik blockchain, bukti ITE, dan penanganan cyber crime.', 'icon' => '💻']);
        Category::create(['name' => 'Tata Kelola Birokrasi SPBE', 'slug' => 'spbe-birokrasi', 'description' => 'Akselerasi eksekusi putusan inkracht dan tata kelola birokrasi penegakan hukum.', 'icon' => '🌐']);
        Category::create(['name' => 'Pengawasan & Etik Aparatur', 'slug' => 'pengawasan-etik', 'description' => 'Kajian penguatan integritas dan etik aparat penegak hukum.', 'icon' => '🛡️']);

        // 3. Real Multi-Chapter Executive Document 1
        $k1 = Kajian::create([
            'title' => 'Pedoman Perampasan Aset Kejahatan Lintas Batas Tanpa Pemidanaan (Non-Conviction Based Asset Forfeiture)',
            'doc_no' => 'PB-01/LITBANG-MADA/2026',
            'category' => 'Tindak Pidana Khusus & Ekonomi',
            'access_type' => 'Publik & Terbuka',
            'status' => 'Publish & Vault',
            'urgency' => 'Kritis',
            'score' => '98/100',
            'pic_team' => 'Tim Riset 1 (Pidsus & Ekonomi)',
            'pic_researcher' => 'Dr. Sdr. Andi, S.H., M.H.',
            'show_researcher_name' => true,
            'summary' => 'Naskah kebijakan eksekutif perumusan instrumen perampasan aset perdata tanpa dipersyaratkan vonis pidana pokok atas kasus korupsi lintas negara.',
            'file_path' => '/documents/pb_01.pdf',
            'impact_score' => 'Rp 4.2 Triliun Pemulihan Aset',
            'hashtags' => ['#PidanaKhusus', '#NCBAssetForfeiture', '#PemulihanAset'],
            'downloads_count' => '1,420 Download',
            'read_time' => '15 Halaman PDF Resmi',
            'tag' => 'POLICY BRIEF UTAMA',
            'infographic_points' => [
                'Gugatan Perdata Independen Aset Kejahatan Tanpa Tunggu Sidang Pidana',
                'Mekanisme Beban Pembuktian Terbalik atas Unexplained Wealth',
                'Estimasi Pemulihan Kerugian Negara Hingga Rp 4.2 Triliun'
            ],
            'review_substansi' => true,
            'review_metodologi' => true,
            'review_legal' => true,
            'signed_by_ketua' => true,
        ]);

        // Document 2: Cyber & Digital Policy Brief
        Kajian::create([
            'title' => 'Formulasi Standard Operating Procedure (SOP) Penanganan Kejahatan Keuangan Kripto & DeFi',
            'doc_no' => 'PB-02/LITBANG-MADA/2026',
            'category' => 'Digitalisasi Hukum & Kripto',
            'access_type' => 'Publik & Terbuka',
            'status' => 'Publish & Vault',
            'urgency' => 'Kritis',
            'score' => '96/100',
            'pic_team' => 'Tim Riset 2 (Cyber & Digital)',
            'pic_researcher' => 'Dr. Hendra Wijaya, S.H.',
            'show_researcher_name' => true,
            'summary' => 'Naskah panduan penanganan pembuktian digital dan audit forensik transaksi aset kripto pada bursa terdesentralisasi (DeFi).',
            'file_path' => '/documents/pb_02.pdf',
            'impact_score' => 'Akselerasi Audit Forensik Kripto',
            'downloads_count' => '980 Download',
            'read_time' => '12 Halaman PDF Resmi',
            'tag' => 'POLICY BRIEF DIGITAL',
            'infographic_points' => [
                'Audit Forensik Rantai Blok (Blockchain Ledger)',
                'Pembekuan Dompet Digital Kripto Terindikasi Kejahatan',
                'Standar Pembuktian Bukti Elektronik di Persidangan'
            ],
            'review_substansi' => true,
            'review_metodologi' => true,
            'review_legal' => true,
            'signed_by_ketua' => true,
        ]);

        // Sample Public Proposal
        PublicProposal::create([
            'ticket_no' => 'USUL-2026-892',
            'name' => 'Dr. Hendra Wijaya, S.H.',
            'institution' => 'Fakultas Hukum Universitas Gadjah Mada',
            'category' => 'Digitalisasi Hukum & Kripto',
            'title' => 'Formulasi Perlindungan Hukum Korban Penipuan Digital & Rekayasa Sosial',
            'urgency' => 'Kritis',
            'description' => 'Mengevaluasi jaminan ganti rugi korban kejahatan perbankan digital berbasis rekayasa sosial dan mekanisme koordinasi pembekuan rekening bank.',
            'file_name' => 'Usulan_Regulasi_Penipuan_Digital.pdf',
            'status' => 'Direspon & Dikaji',
            'disposition_team' => 'Tim Riset 2 (Cyber & Digital)',
            'official_response' => "TANGGAPAN RESMI TIM RISET ADHYAKSA:\nUsulan Bapak Dr. Hendra Wijaya telah kami verifikasi dan dinilai SANGAT STRATEGIS. Tim Riset 2 telah menjadikan usulan ini sebagai prioritas Naskah Akademis 2026 dengan fokus pada perumusan SOP Pembekuan Rekening Bank Penipu dalam waktu maksimal 1x24 Jam.",
            'timeline_step' => 3,
            'last_update_note' => 'Usulan telah direspon resmi oleh Tim Riset 2 dan saat ini masuk ke dalam tahap penyusunan Naskah Akademis Dokumen Panjang.',
            'kajian_id' => $k1->id,
        ]);
    }
}
