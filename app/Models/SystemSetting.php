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
        'peneliti_pidsus',
        'peneliti_cyber',
        'max_file_size_mb',
        'vault_encryption',
    ];
}
