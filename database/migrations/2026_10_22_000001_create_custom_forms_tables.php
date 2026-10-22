<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Tabel Formulir / Event Kuesioner
        Schema::create('custom_forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('deadline_at')->nullable();
            $table->text('success_message')->nullable();
            $table->boolean('allow_multiple_responses')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Bidang / Kolom Pertanyaan Formulir
        Schema::create('custom_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_form_id')->constrained('custom_forms')->onDelete('cascade');
            $table->string('field_label');
            $table->string('field_name');
            $table->enum('field_type', ['text', 'textarea', 'select', 'radio', 'checkbox', 'file', 'date', 'number'])->default('text');
            $table->json('options')->nullable(); // Pilihan untuk select, radio, checkbox
            $table->text('help_text')->nullable();
            $table->boolean('is_required')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        // 3. Tabel Respons / Tanggapan Responden
        Schema::create('custom_form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_form_id')->constrained('custom_forms')->onDelete('cascade');
            $table->string('respondent_name')->nullable();
            $table->string('respondent_identifier')->nullable(); // NIP/NRP/Email jika ada
            $table->json('answers'); // Format: { "field_name": "jawaban / array / url file" }
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_form_responses');
        Schema::dropIfExists('custom_form_fields');
        Schema::dropIfExists('custom_forms');
    }
};
