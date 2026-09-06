<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no',
        'name',
        'institution',
        'category',
        'type',
        'title',
        'urgency',
        'description',
        'custom_attributes',
        'file_name',
        'file_path',
        'admin_file_path',
        'additional_attachments',
        'status',
        'disposition_team',
        'rejection_reason',
        'official_response',
        'timeline_step',
        'last_update_note',
        'kajian_id',
    ];

    protected $casts = [
        'custom_attributes' => 'array',
        'additional_attachments' => 'array',
    ];

    public function kajian()
    {
        return $this->belongsTo(Kajian::class, 'kajian_id');
    }
}
