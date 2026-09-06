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
            $table->string('category')->default('Tindak Pidana Khusus & Ekonomi');
            $table->string('access_type')->default('Publik & Terbuka');
            $table->string('status')->default('Dalam Kajian');
            $table->string('urgency')->default('Tinggi');
            $table->string('score')->default('95/100');
            $table->string('pic_team')->default('Tim Riset 1 (Pidsus & Ekonomi)');
            $table->string('pic_researcher')->nullable();
            $table->boolean('show_researcher_name')->default(true);
            $table->text('summary')->nullable();
            
            $table->longText('content')->nullable();
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
            
            $table->boolean('review_substansi')->default(false);
            $table->boolean('review_metodologi')->default(false);
            $table->boolean('review_legal')->default(false);
            $table->boolean('signed_by_ketua')->default(false);
            $table->boolean('is_published')->default(true); // Control publish ke public catalog

            $table->timestamps();
        });

        // 3. Tabel Aspirasi & Usulan Internal
        Schema::create('public_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            $table->string('name');
            $table->string('institution')->nullable();
            $table->string('category');
            $table->string('type')->default('Policy Brief'); // 'Policy Brief' atau 'Ide Inovasi'
            $table->string('title');
            $table->string('urgency')->default('Tinggi');
            $table->text('description');
            $table->json('custom_attributes')->nullable(); // Menampung isian dinamis
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('admin_file_path')->nullable(); // BERKAS HASIL KAJIAN ADMIN
            $table->json('additional_attachments')->nullable(); // BERKAS PENDUKUNG LAINNYA
            $table->string('status')->default('Pengajuan (Menunggu Skrining)'); 
            $table->string('disposition_team')->nullable();
            $table->text('rejection_reason')->nullable(); // MANDATORY IF REJECTED
            $table->text('official_response')->nullable(); // RESPONS SAAT DIPELAJARI / DITERIMA
            $table->integer('timeline_step')->default(1);
            $table->text('last_update_note')->nullable();
            $table->unsignedBigInteger('kajian_id')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Inovasi & Ide Inovasi Teruji (PILAR 2)
        Schema::create('innovation_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('innovation_no')->unique();
            $table->unsignedBigInteger('public_proposal_id')->nullable();
            $table->string('innovator_name');
            $table->string('title');
            $table->string('category')->default('Digitalisasi Service & SPBE');
            $table->string('status')->default('Ide Usulan'); // 'Ide Usulan', 'Proses Inkubasi', 'Inovasi Teruji'
            $table->boolean('is_published')->default(true); // Control publish ke public catalog
            $table->text('summary');
            $table->text('impact_description')->nullable();
            $table->string('sop_file_path')->nullable();
            $table->boolean('signed_by_ketua')->default(false);
            $table->integer('downloads_count')->default(0);
            $table->timestamps();
        });

        // 5. Tabel Kurikulum & Vault Arsip Materi (PILAR 3)
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject_category');
            $table->string('file_type');
            $table->string('batch_year')->default('PPPJ LXXXIII/II Tahun 2026');
            $table->string('uploader_name')->default('Admin');
            $table->string('status')->default('Publish & Vault'); // 'Menunggu Verifikasi', 'Publish & Vault', 'Ditolak'
            $table->boolean('is_verified')->default(true);
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('downloads_count')->default('0 Download');
            $table->timestamps();
        });

        // 6. Tabel Audit Log Aktivitas Sekretariat & Admin
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->default('Admin');
            $table->string('action');
            $table->string('target_ticket')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });

        // 7. Tabel Dynamic Form Builder (Custom Input Fields)
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_label');
            $table->string('field_name');
            $table->string('field_type')->default('text'); // 'text', 'textarea', 'select', 'file'
            $table->json('options')->nullable(); // Pilihan dropdown jika type === 'select'
            $table->boolean('is_required')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        // 8. Tabel Konfigurasi Pengaturan Sistem
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name')->default('Litbang Gajah Mada Adhyaksa');
            $table->string('tagline')->default('Dari Kajian, Inovasi, & Kurikulum, Tumbuh Pengetahuan Strategis Berkelanjutan.');
            $table->string('period')->default('2025/2026');
            $table->string('ketua_tim_riset')->default('Dr. Sdr. Pratama, S.H., M.H.');
            $table->string('batch_passcode')->default('GAJAHMADA2026'); // Kode PIN Akses Angkatan (Solusi A)
            $table->string('max_file_size_mb')->default('10');
            $table->string('vault_encryption')->default('AES-256 Enabled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('curriculums');
        Schema::dropIfExists('innovation_proposals');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('public_proposals');
        Schema::dropIfExists('kajians');
        Schema::dropIfExists('categories');
    }
};
