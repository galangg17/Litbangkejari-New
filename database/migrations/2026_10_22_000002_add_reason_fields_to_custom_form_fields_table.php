<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custom_form_fields', function (Blueprint $table) {
            $table->boolean('has_reason')->default(false)->after('options');
            $table->string('reason_label')->nullable()->after('has_reason');
            $table->string('reason_trigger')->nullable()->default('all')->after('reason_label');
        });
    }

    public function down(): void
    {
        Schema::table('custom_form_fields', function (Blueprint $table) {
            $table->dropColumn(['has_reason', 'reason_label', 'reason_trigger']);
        });
    }
};
