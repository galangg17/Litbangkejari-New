<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFormResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_form_id',
        'respondent_name',
        'respondent_identifier',
        'answers',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'custom_form_id');
    }
}
