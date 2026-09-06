<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Seed Users (Admin & Peserta)
        User::create([
            'name' => 'Tim Riset & Inovasi (Admin Utama)',
            'email' => 'admin@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Tim Riset & Inovasi (Admin)',
            'team' => 'Sekretariat Utama',
        ]);

        User::create([
            'name' => 'Dr. Sdr. Andi, S.H., M.H.',
            'email' => 'andi.pidsus@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Tim Riset & Inovasi (Admin)',
            'team' => 'Tim Riset 1 (Pidsus & Ekonomi)',
        ]);

        User::create([
            'name' => 'Peserta / Anggota Angkatan Gajah Mada',
            'email' => 'peserta@mada-adhyaksa.go.id',
            'password' => Hash::make('secret123'),
            'role' => 'Anggota / Peserta',
            'team' => 'Angkatan Gajah Mada (PPPJ 2026)',
        ]);

        // 1. System Setting (Includes Passcode PIN Angkatan)
        SystemSetting::create([
            'institution_name' => 'Litbang Gajah Mada Adhyaksa',
            'tagline' => 'Portal Sistem Informasi Manajemen Riset, Inovasi, dan Kurikulum — Litbang Gajah Mada Adhyaksa',
            'period' => '2025/2026',
            'ketua_tim_riset' => 'Dr. Sdr. Pratama, S.H., M.H.',
            'batch_passcode' => 'GAJAHMADA2026',
            'max_file_size_mb' => '10',
            'vault_encryption' => 'AES-256 Enabled',
        ]);

        // 2. Initial Categories
        Category::create(['name' => 'Pidana', 'slug' => 'pidana', 'description' => 'Kajian & Inovasi bidang Pidana Khusus, Pidana Umum, dan Kejahatan Keuangan.', 'icon' => '⚖️']);
        Category::create(['name' => 'Perdata', 'slug' => 'perdata', 'description' => 'Kajian & Inovasi bidang Hukum Perdata, Pertanahan, dan Pemulihan Aset.', 'icon' => '🏛️']);
        Category::create(['name' => 'TUN', 'slug' => 'tun', 'description' => 'Kajian & Inovasi bidang Tata Usaha Negara, SPBE, dan Birokrasi.', 'icon' => '📜']);
        Category::create(['name' => 'Pidsus & Ekonomi', 'slug' => 'pidsus-ekonomi', 'description' => 'Tindak Pidana Khusus, Korupsi, & Kejahatan Keuangan Negara.', 'icon' => '🛡️']);

        // 3. Custom Dynamic Form Fields
        FormField::create([
            'field_label' => 'Target Efisiensi Dampak / Output',
            'field_name' => 'target_impact',
            'field_type' => 'text',
            'is_required' => false,
            'order_index' => 1,
        ]);

        // 4. Policy Briefs (PILAR 1)
        $k1 = Kajian::create([
            'title' => 'Pedoman Perampasan Aset Kejahatan Lintas Batas Tanpa Pemidanaan (Non-Conviction Based Asset Forfeiture)',
            'doc_no' => 'PB-01/LITBANG-MADA/2026',
            'category' => 'Pidsus & Ekonomi',
            'access_type' => 'Internal Angkatan',
            'status' => 'Publish & Vault',
            'urgency' => 'Kritis',
            'score' => '98/100',
            'pic_team' => 'Tim Riset 1 (Pidsus & Ekonomi)',
            'pic_researcher' => 'Dr. Sdr. Andi, S.H., M.H.',
            'show_researcher_name' => true,
            'summary' => 'Naskah kebijakan perumusan instrumen perampasan aset perdata tanpa dipersyaratkan vonis pidana pokok atas kasus korupsi lintas negara.',
            'file_path' => '/documents/pb_01.pdf',
            'impact_score' => 'Rp 4.2 Triliun Pemulihan Aset',
            'hashtags' => ['#Pidana', '#NCBAssetForfeiture', '#PemulihanAset'],
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
            'is_published' => true,
        ]);

        $k2 = Kajian::create([
            'title' => 'Formulasi Perlindungan Hukum Korban Penipuan Digital & Rekayasa Sosial Perbankan',
            'doc_no' => 'PB-02/LITBANG-MADA/2026',
            'category' => 'Pidana',
            'access_type' => 'Publik & Terbuka',
            'status' => 'Dalam Kajian Studio',
            'urgency' => 'Tinggi',
            'score' => '92/100',
            'pic_team' => 'Tim Riset 2 (Pidum & SPBE)',
            'pic_researcher' => 'Dr. Hendra Wijaya, S.H.',
            'show_researcher_name' => true,
            'summary' => 'Mengevaluasi jaminan ganti rugi korban kejahatan perbankan digital berbasis rekayasa sosial dan pembekuan rekening bank.',
            'file_path' => '/documents/pb_02.pdf',
            'impact_score' => 'Per Perlindungan Korban Cyber',
            'hashtags' => ['#CyberCrime', '#RekayasaSosial', '#PerlindunganKorban'],
            'downloads_count' => '850 Download',
            'read_time' => '12 Halaman Dokumen',
            'tag' => 'REKOMENDASI REGULASI',
            'infographic_points' => [
                'Pembekuan Rekening Penampung Otomatis dalam 1x24 Jam',
                'Mekanisme Ganti Rugi Korban via Dana Penjaminan SPBE'
            ],
            'review_substansi' => true,
            'review_metodologi' => true,
            'review_legal' => false,
            'signed_by_ketua' => false,
            'is_published' => true,
        ]);

        // 5. Inovasi Teruji & Ide Inovasi (PILAR 2)
        InnovationProposal::create([
            'innovation_no' => 'INOV-2026-001',
            'innovator_name' => 'Tim Inovasi Angkatan Gajah Mada',
            'title' => 'Sistem Pemantauan Aset Disita Berbasis QR Code & Geo-Tagging Real-Time',
            'category' => 'TUN',
            'status' => 'Inovasi Teruji',
            'summary' => 'Platform digital otomatis pencatatan dan lokasi barang bukti barang sitaan berbasis sensor QR Code untuk mencegah depresiasi nilai barang bukti.',
            'impact_description' => 'Efisiensi waktu audit barang bukti hingga 85% & eliminasi potensi risiko pencatatan ganda.',
            'sop_file_path' => '/documents/pb_01.pdf',
            'signed_by_ketua' => true,
            'is_published' => true,
            'downloads_count' => 450,
        ]);

        InnovationProposal::create([
            'innovation_no' => 'INOV-2026-002',
            'innovator_name' => 'Dr. Hendra Wijaya, S.H.',
            'title' => 'Bot AI Asisten Penelusuran Dokumen Putusan Yurisprudensi Penuntutan',
            'category' => 'Pidana',
            'status' => 'Proses Inkubasi',
            'summary' => 'Asisten kecerdasan buatan terenkripsi internal untuk mempercepat penyusunan analisis dakwaan penuntut umum.',
            'impact_description' => 'Memotong waktu analisa yurisprudensi dari 3 hari menjadi 15 menit.',
            'sop_file_path' => '/documents/pb_02.pdf',
            'signed_by_ketua' => false,
            'is_published' => true,
            'downloads_count' => 210,
        ]);

        // 6. Kurikulum & Vault Arsip Materi (PILAR 3)
        Curriculum::create([
            'title' => 'Modul Utama Hukum Pidana Khusus & Pembuktian Terbalik',
            'subject_category' => 'Pidana',
            'file_type' => 'Modul PDF',
            'batch_year' => 'PPPJ LXXXIII/II Tahun 2026',
            'uploader_name' => 'Admin Sekretariat',
            'status' => 'Publish & Vault',
            'is_verified' => true,
            'description' => 'Bahan ajar materi perkuliahan PPPJ 2026 komprehensif penanganan kasus tindak pidana korupsi & pencucian uang.',
            'file_path' => '/documents/pb_01.pdf',
            'downloads_count' => '340 Download',
        ]);

        Curriculum::create([
            'title' => 'Slide Presentasi: Legal Audit & Gugatan Perdata Pemulihan Aset Negara',
            'subject_category' => 'Perdata',
            'file_type' => 'Slide PPT',
            'batch_year' => 'PPPJ LXXXIII/II Tahun 2026',
            'uploader_name' => 'Admin Sekretariat',
            'status' => 'Publish & Vault',
            'is_verified' => true,
            'description' => 'Panduan visual teknik penyusunan gugatan perdata ganti rugi kerugian keuangan negara.',
            'file_path' => '/documents/pb_02.pdf',
            'downloads_count' => '512 Download',
        ]);

        Curriculum::create([
            'title' => 'Draf Ringkasan Yurisprudensi SPBE & Penanganan Bukti Digital',
            'subject_category' => 'TUN',
            'file_type' => 'Modul PDF',
            'batch_year' => 'PPPJ LXXXIII/II Tahun 2026',
            'uploader_name' => 'Budi Santoso (Peserta PPPJ)',
            'status' => 'Menunggu Verifikasi',
            'is_verified' => false,
            'description' => 'Ringkasan materi perkuliahan mandiri peserta angkatan mengenai bukti transaksi elektronik.',
            'file_path' => '/documents/pb_01.pdf',
            'downloads_count' => '0 Download',
        ]);

        // 7. Seed Public Proposals across all 4 stages
        
        // STAGE 1: PENGAJUAN BARU (MENUNGGU SKRINING)
        PublicProposal::create([
            'ticket_no' => 'USUL-2026-101',
            'name' => 'Dr. Hendra Wijaya, S.H.',
            'institution' => 'Kejati Jawa Barat',
            'category' => 'Pidana',
            'type' => 'Policy Brief',
            'title' => 'Formulasi Perlindungan Hukum Korban Penipuan Digital & Rekayasa Sosial',
            'urgency' => 'Kritis',
            'description' => 'Mengevaluasi jaminan ganti rugi korban kejahatan perbankan digital berbasis rekayasa sosial dan pembekuan rekening bank.',
            'file_name' => 'Usulan_Regulasi_Penipuan_Digital.pdf',
            'file_path' => '/documents/pb_01.pdf',
            'status' => 'Pengajuan (Menunggu Skrining)',
            'timeline_step' => 1,
            'last_update_note' => 'Usulan baru diterima oleh sistem. Menunggu proses skrining oleh Admin.',
        ]);

        PublicProposal::create([
            'ticket_no' => 'USUL-2026-102',
            'name' => 'Ahmad Subagyo, S.H.',
            'institution' => 'Kejari Jakarta Pusat',
            'category' => 'TUN',
            'type' => 'Ide Inovasi',
            'title' => 'Digitalisasi Sistem Integrasi Data Tilang Online E-Kejaksaan',
            'urgency' => 'Tinggi',
            'description' => 'Gagasan otomatisasi sistem konfirmasi pembatalan tilang berbasis API terintegrasi dengan Korlantas Polri.',
            'file_name' => 'Ide_Sistem_Tilang_Integrasi.pdf',
            'file_path' => '/documents/pb_02.pdf',
            'status' => 'Pengajuan (Menunggu Skrining)',
            'timeline_step' => 1,
            'last_update_note' => 'Usulan baru diterima oleh sistem. Menunggu skrining Admin.',
        ]);

        // STAGE 2: DIPELAJARI & DISPOSISI TIM RISET
        PublicProposal::create([
            'ticket_no' => 'USUL-2026-201',
            'name' => 'Maya Indah, S.H., M.H.',
            'institution' => 'Kejati Jawa Timur',
            'category' => 'Pidsus & Ekonomi',
            'type' => 'Policy Brief',
            'title' => 'Pembuktian Audit Forensic Crypto Asset dalam Tindak Pidana Korupsi',
            'urgency' => 'Kritis',
            'description' => 'Metodologi audit lacak jejak transaksi pencucian uang korupsi berbasis jaringan blockchain.',
            'file_name' => 'Kajian_Crypto_Forensic.pdf',
            'file_path' => '/documents/pb_01.pdf',
            'status' => 'Diterima & Didisposisikan ke Tim Riset 1 (Pidsus & Ekonomi)',
            'disposition_team' => 'Tim Riset 1 (Pidsus & Ekonomi)',
            'official_response' => '💬 TANGGAPAN RESMI: Usulan disetujui. Tim Riset 1 mulai mengkaji metodologi audit blockchain.',
            'timeline_step' => 2,
            'last_update_note' => 'Usulan diterima & sedang dipelajari oleh Tim Riset 1 (Pidsus & Ekonomi)',
        ]);

        PublicProposal::create([
            'ticket_no' => 'USUL-2026-202',
            'name' => 'Dr. Budi Santoso, S.H.',
            'institution' => 'Kejati Bali',
            'category' => 'Pidana',
            'type' => 'Policy Brief',
            'title' => 'Evaluasi Mekanisme Restorative Justice Berbasis Adat Hukum Pidana',
            'urgency' => 'Sedang',
            'description' => 'Penguatan kelembagaan Rumah Restorative Justice di tingkat Kejaksaan Negeri seluruh Indonesia.',
            'file_name' => 'Kajian_RJ_Adat.pdf',
            'file_path' => '/documents/pb_02.pdf',
            'status' => 'Diterima & Didisposisikan ke Tim Riset 2 (Pidum & SPBE)',
            'disposition_team' => 'Tim Riset 2 (Pidum & SPBE)',
            'official_response' => '💬 TANGGAPAN RESMI: Usulan didisposisikan ke Tim Riset 2 untuk analisis lapangan.',
            'timeline_step' => 2,
            'last_update_note' => 'Usulan diterima & sedang dipelajari oleh Tim Riset 2',
        ]);

        // STAGE 3: REVIEW 3-PINTU & NASKAH STUDIO
        PublicProposal::create([
            'ticket_no' => 'USUL-2026-301',
            'name' => 'Agus Harimurti, S.H.',
            'institution' => 'Kejati DKI Jakarta',
            'category' => 'Perdata',
            'type' => 'Policy Brief',
            'title' => 'Kerangka Hukum Pengembalian Kerugian Negara Luar Negeri via UNODC',
            'urgency' => 'Kritis',
            'description' => 'Harmonisasi regulasi perampasan aset luar negeri dalam kerjasama Mutual Legal Assistance (MLA).',
            'file_name' => 'Draft_MLA_Asset_Recovery.pdf',
            'file_path' => '/documents/pb_01.pdf',
            'admin_file_path' => '/documents/pb_01.pdf',
            'status' => 'Penyusunan Naskah & Review 3-Pintu',
            'disposition_team' => 'Tim Riset 3 (Datun & Asset Recovery)',
            'official_response' => '💬 TANGGAPAN RESMI: Draft Naskah Akademis sedang dalam pemeriksaan Validasi 3-Pintu.',
            'timeline_step' => 3,
            'last_update_note' => 'Naskah dalam tahap validasi 3-Pintu (Substansi, Metodologi, Legal).',
            'kajian_id' => $k2->id,
        ]);

        // STAGE 4: TERBIT IN VAULT PUBLIK
        PublicProposal::create([
            'ticket_no' => 'USUL-2026-401',
            'name' => 'Dr. Sdr. Andi, S.H., M.H.',
            'institution' => 'Litbang Gajah Mada Adhyaksa',
            'category' => 'Pidsus & Ekonomi',
            'type' => 'Policy Brief',
            'title' => 'Pedoman Perampasan Aset Kejahatan Lintas Batas Tanpa Pemidanaan',
            'urgency' => 'Kritis',
            'description' => 'Naskah kebijakan perumusan instrumen perampasan aset perdata tanpa dipersyaratkan vonis pidana pokok.',
            'file_name' => 'Pedoman_NCB_Asset_Forfeiture.pdf',
            'admin_file_path' => '/documents/pb_01.pdf',
            'status' => 'Terbit in Vault Publik',
            'disposition_team' => 'Tim Riset 1 (Pidsus & Ekonomi)',
            'official_response' => '💬 TANGGAPAN RESMI: Naskah Policy Brief telah resmi diterbitkan di Vault Publik.',
            'timeline_step' => 4,
            'last_update_note' => 'Policy Brief telah resmi diterbitkan dan dapat diunduh di Katalog Publik.',
            'kajian_id' => $k1->id,
        ]);

        // STAGE 0: REJECTED PROPOSAL
        PublicProposal::create([
            'ticket_no' => 'USUL-2026-901',
            'name' => 'Rian Hidayat',
            'institution' => 'Masyarakat Umum',
            'category' => 'Perdata',
            'type' => 'Policy Brief',
            'title' => 'Permohonan Bantuan Hukum Kasus Sengketa Tanah Pribadi Sengketa Keluarga',
            'urgency' => 'Rendah',
            'description' => 'Meminta kejaksaan membantu penyelesaian sengketa pembagian waris tanah keluarga.',
            'file_name' => 'Surat_Permohonan.pdf',
            'status' => 'Ditolak',
            'rejection_reason' => '[DI LUAR WEWENANG LITBANG] Permohonan sengketa pribadi tidak termasuk dalam wewenang Pokja Riset & Formulasi Kebijakan Litbang.',
            'official_response' => '❌ TANGGAPAN RESMI: Usulan ditolak karena sengketa perorangan di luar wewenang Pokja Riset Litbang.',
            'timeline_step' => 0,
            'last_update_note' => 'Usulan ditolak oleh Admin. Alasan: Di luar wewenang Litbang.',
        ]);

        // 8. Audit Logs
        AuditLog::create([
            'user_name' => 'Admin Sekretariat',
            'action' => 'ACCEPT_DISPOSITION',
            'target_ticket' => 'USUL-2026-201',
            'details' => 'Menerima & mendisposisikan usulan ke Tim Riset 1 (Pidsus & Ekonomi)',
        ]);

        AuditLog::create([
            'user_name' => 'Admin Sekretariat',
            'action' => 'REJECT_PROPOSAL',
            'target_ticket' => 'USUL-2026-901',
            'details' => 'Menolak usulan. Alasan: Di luar wewenang Litbang.',
        ]);

        AuditLog::create([
            'user_name' => 'Admin Sekretariat',
            'action' => 'CREATE_STUDIO_KAJIAN',
            'target_ticket' => 'USUL-2026-301',
            'details' => 'Membuat draft Policy Brief Studio: PB-02/LITBANG-MADA/2026',
        ]);

        AuditLog::create([
            'user_name' => 'Admin Sekretariat',
            'action' => 'VERIFY_CURRICULUM',
            'target_ticket' => 'CURR-1',
            'details' => 'Memverifikasi berkas modul kurikulum: Modul Utama Hukum Pidana Khusus',
        ]);

        AuditLog::create([
            'user_name' => 'Admin Sekretariat',
            'action' => 'EXPORT_CSV',
            'target_ticket' => 'ALL_PROPOSALS',
            'details' => 'Mengunduh berkas spreadsheet rekapitulasi seluruh usulan.',
        ]);

        AuditLog::create([
            'user_name' => 'Admin Sekretariat',
            'action' => 'UPDATE_PIN',
            'target_ticket' => 'SYSTEM_SETTINGS',
            'details' => 'Memperbarui Kode PIN Akses Angkatan menjadi GAJAHMADA2026.',
        ]);
    }
}
