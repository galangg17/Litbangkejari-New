<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_form_id',
        'category',
        'field_label',
        'field_name',
        'field_type',
        'options',
        'has_reason',
        'reason_label',
        'reason_trigger',
        'help_text',
        'is_required',
        'order_index',
    ];

    protected $casts = [
        'options' => 'array',
        'has_reason' => 'boolean',
        'is_required' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'custom_form_id');
    }

    public function getFormattedFieldLabelAttribute(): string
    {
        return \App\Helpers\FormTextHelper::format($this->field_label);
    }

    public function getFormattedHelpTextAttribute(): string
    {
        return \App\Helpers\FormTextHelper::format($this->help_text);
    }
}
