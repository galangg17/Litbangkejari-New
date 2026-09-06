<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_label',
        'field_name',
        'field_type',
        'options',
        'is_required',
        'order_index',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];
}
