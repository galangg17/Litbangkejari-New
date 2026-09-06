<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'subject_category',
        'file_type',
        'batch_year',
        'uploader_name',
        'status',
        'is_verified',
        'description',
        'file_path',
        'external_link',
        'downloads_count',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];
}
