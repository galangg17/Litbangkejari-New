<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'banner_image',
        'status',
        'deadline_at',
        'success_message',
        'allow_multiple_responses',
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
        'allow_multiple_responses' => 'boolean',
    ];

    public function fields()
    {
        return $this->hasMany(CustomFormField::class)->orderBy('order_index', 'asc');
    }

    public function responses()
    {
        return $this->hasMany(CustomFormResponse::class)->orderBy('created_at', 'desc');
    }

    public function isOpen()
    {
        if ($this->status === 'closed') {
            return false;
        }
        if ($this->deadline_at && $this->deadline_at->isPast()) {
            return false;
        }
        return true;
    }
}
