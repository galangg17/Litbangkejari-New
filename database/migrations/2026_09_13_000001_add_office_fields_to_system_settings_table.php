<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->string('office_title')->nullable()->default('Posko Penelitian & Riset Hukum Angkatan');
            $table->string('office_name')->nullable()->default('Badiklat Kejaksaan RI Kampus A');
            $table->string('office_address')->nullable()->default('Jl. Ragunan No. 6, Pasar Minggu, Jakarta Selatan');
            $table->string('office_phone')->nullable()->default('(021) 780-0012 / Ext. 832026');
            $table->string('office_email')->nullable()->default('litbang.mada@kejaksaan.go.id');
            $table->text('office_map_url')->nullable()->default('https://maps.google.com/maps?q=Badiklat+Kejaksaan+RI+Pasar+Minggu&t=&z=15&ie=UTF8&iwloc=&output=embed');
            $table->string('office_stat_badge')->nullable()->default('500+ Peserta');
            $table->string('office_stat_subtext')->nullable()->default('PPPJ LXXXIII/II Tahun 2026');
        });
    }

    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn([
                'office_title',
                'office_name',
                'office_address',
                'office_phone',
                'office_email',
                'office_map_url',
                'office_stat_badge',
                'office_stat_subtext',
            ]);
        });
    }
};
