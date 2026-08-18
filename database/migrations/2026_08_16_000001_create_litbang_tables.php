<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kategori Domain Hukum Dinamis
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('⚖️');
            $table->timestamps();
        });

        // 2. Tabel Kajian & Policy Brief (Dokumen Panjang Word-Style White Paper)
        Schema::create('kajians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('public_proposal_id')->nullable();
            $table->string('title');
            $table->string('doc_no')->nullable();
            $table->string('category')->default('Pidana Khusus');
            $table->string('access_type')->default('Publik & Terbuka'); // 'Publik & Terbuka' atau 'Rekomendasi Internal Pimpinan'
            $table->string('status')->default('Dalam Kajian'); // 'Pengajuan', 'Dalam Kajian', 'Direspon', 'Publish & Vault'
            $table->string('urgency')->default('Tinggi'); // 'Kritis', 'Tinggi', 'Normal'
            $table->string('score')->default('95/100');
            $table->string('pic_team')->default('Tim Riset 1 (Pidsus & Ekonomi)');
            $table->string('pic_researcher')->nullable();
            $table->boolean('show_researcher_name')->default(true);
            $table->text('summary')->nullable();
            
            // Struktur Dokumen Panjang Word-Style Multi-Bab
            $table->longText('content')->nullable(); // Multi-chapter full text
            $table->longText('bab1_pendahuluan')->nullable();
            $table->longText('bab2_tinjauan_yuridis')->nullable();
            $table->longText('bab3_metodologi_audit')->nullable();
            $table->longText('bab4_rekomendasi_brief')->nullable();
            $table->longText('bab5_juknis_sop')->nullable();
            
            $table->string('impact_score')->nullable();
            $table->json('hashtags')->nullable();
            $table->string('downloads_count')->default('1,420 Download');
            $table->string('read_time')->default('15 Halaman');
            $table->string('tag')->default('POLICY BRIEF UTAMA');
            $table->json('infographic_points')->nullable();
            $table->string('file_path')->nullable();
            
            // Review 3-Pintu & Pengesahan Digital
            $table->boolean('review_substansi')->default(false);
            $table->boolean('review_metodologi')->default(false);
            $table->boolean('review_legal')->default(false);
            $table->boolean('signed_by_ketua')->default(false);

            $table->timestamps();
        });

        // 3. Tabel Aspirasi & Usulan Publik (Dengan Box Tanggapan Resmi)
        Schema::create('public_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            $table->string('name');
            $table->string('institution')->nullable();
            $table->string('category');
            $table->string('title');
            $table->string('urgency')->default('Tinggi');
            $table->text('description');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('Pengajuan (Menunggu Skrining)'); 
            $table->string('disposition_team')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('official_response')->nullable(); // Tanggapan/Respon Resmi dari Tim Riset
            $table->integer('timeline_step')->default(1); // 1: Pengajuan, 2: Dikaji, 3: Direspon, 4: Publish & Vault
            $table->text('last_update_note')->nullable();
            $table->unsignedBigInteger('kajian_id')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Konfigurasi Pengaturan Sistem
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name')->default('Senat Gajah Mada Adhyaksa');
            $table->string('tagline')->default('Dari Kajian, Lahir Rekomendasi. Dari Rekomendasi, Tumbuh Pengetahuan Berkelanjutan.');
            $table->string('period')->default('2025/2026');
            $table->string('ketua_tim_riset')->default('Dr. Sdr. Pratama, S.H., M.H.');
            $table->string('max_file_size_mb')->default('10');
            $table->string('vault_encryption')->default('AES-256 Enabled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('public_proposals');
        Schema::dropIfExists('kajians');
        Schema::dropIfExists('categories');
    }
};
