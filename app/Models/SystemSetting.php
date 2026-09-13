<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_name',
        'tagline',
        'period',
        'ketua_tim_riset',
        'batch_passcode',
        'peneliti_pidsus',
        'peneliti_cyber',
        'max_file_size_mb',
        'vault_encryption',
        'office_title',
        'office_name',
        'office_address',
        'office_phone',
        'office_email',
        'office_map_url',
        'office_stat_badge',
        'office_stat_subtext',
    ];
}
