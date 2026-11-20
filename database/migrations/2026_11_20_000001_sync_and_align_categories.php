<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Kajian;
use App\Models\InnovationProposal;
use App\Models\Curriculum;
use App\Models\PublicProposal;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Standarisasi dan Pemulihan Kategori Resmi Kejaksaan RI
        $standardCategories = [
            'Pidana' => [
                'icon' => '⚖️',
                'description' => 'Kajian & Inovasi bidang Pidana Khusus, Pidana Umum, Restorative Justice, dan Penuntutan.',
            ],
            'Perdata' => [
                'icon' => '🏛️',
                'description' => 'Kajian & Inovasi bidang Hukum Perdata, Pertanahan, dan Jaksa Pengacara Negara (JPN).',
            ],
            'TUN' => [
                'icon' => '📜',
                'description' => 'Kajian & Inovasi bidang Tata Usaha Negara, Kebijakan Publik, dan Keputusan Administrasi.',
            ],
            'Pidsus & Ekonomi' => [
                'icon' => '🛡️',
                'description' => 'Tindak Pidana Khusus, Korupsi, TPPU, Kepabeanan, Perpajakan & Kejahatan Keuangan Negara.',
            ],
            'Pengawasan' => [
                'icon' => '🔍',
                'description' => 'Kajian & Inovasi bidang Kepatuhan Kode Etik, Integritas Pegawai, Eksaminasi, dan Pengawasan Fungsional.',
            ],
            'Pembinaan' => [
                'icon' => '💼',
                'description' => 'Kajian & Inovasi bidang Manajemen SDM, Keuangan, Sarana Prasarana, SPBE, dan Tata Kelola Birokrasi.',
            ],
            'Pidana Militer' => [
                'icon' => '⚔️',
                'description' => 'Kajian & Inovasi bidang Penanganan Perkara Koneksitas, Kerjasama Oditurat Militer, dan Hukum Pidana Militer.',
            ],
            'Badan Pemulihan Aset' => [
                'icon' => '💎',
                'description' => 'Kajian & Inovasi bidang Penelusuran Aset (Asset Tracing), Sita Eksekusi, dan Pengelolaan Benda Rampasan Negara.',
            ],
            'Pengembangan Kompetensi' => [
                'icon' => '🎓',
                'description' => 'Modul Pembelajaran Diklat PPPJ, Kepemimpinan Jaksa, Uji Kompetensi, dan Pelatihan Teknis Fungsional.',
            ],
        ];

        foreach ($standardCategories as $name => $data) {
            $cat = Category::where('name', $name)->first();
            if ($cat) {
                // Perbarui deskripsi jika masih default kosong/tumpul
                if ($cat->description === 'Kategori domain hukum.' || empty($cat->description)) {
                    $cat->update([
                        'icon' => $data['icon'] ?? $cat->icon,
                        'description' => $data['description'],
                    ]);
                }
            } else {
                Category::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'icon' => $data['icon'],
                    'description' => $data['description'],
                ]);
            }
        }

        // 2. Harmonisasikan data lama / tumburan yang menggunakan nama legacy:
        // A. 'Hukum & Tata Kelola' -> selaraskan ke 'Pembinaan'
        Kajian::where('category', 'Hukum & Tata Kelola')->update(['category' => 'Pembinaan']);
        InnovationProposal::where('category', 'Hukum & Tata Kelola')->update(['category' => 'Pembinaan']);
        Curriculum::where('subject_category', 'Hukum & Tata Kelola')->update(['subject_category' => 'Pembinaan']);
        PublicProposal::where('category', 'Hukum & Tata Kelola')->update(['category' => 'Pembinaan']);

        // B. 'SPBE' / 'SPBE & Digitalisasi' -> selaraskan ke 'Pembinaan'
        Kajian::whereIn('category', ['SPBE', 'SPBE & Digitalisasi'])->update(['category' => 'Pembinaan']);
        InnovationProposal::whereIn('category', ['SPBE', 'SPBE & Digitalisasi'])->update(['category' => 'Pembinaan']);
        Curriculum::whereIn('subject_category', ['SPBE', 'SPBE & Digitalisasi'])->update(['subject_category' => 'Pembinaan']);
        PublicProposal::whereIn('category', ['SPBE', 'SPBE & Digitalisasi'])->update(['category' => 'Pembinaan']);

        // C. 'Intelijen' jika ada di kurikulum tapi belum di categories
        if (Curriculum::where('subject_category', 'Intelijen')->exists() || PublicProposal::where('category', 'Intelijen')->exists()) {
            Category::firstOrCreate(
                ['name' => 'Intelijen'],
                [
                    'slug' => 'intelijen',
                    'icon' => '🕵️‍♂️',
                    'description' => 'Kajian & Modul bidang Operasi Intelijen Yustisial, Pengamanan Pembangunan Strategis (PPS), dan PAM SDO.'
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse needed
    }
};
