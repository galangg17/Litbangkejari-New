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
        'title',
        'urgency',
        'description',
        'file_name',
        'file_path',
        'status',
        'disposition_team',
        'rejection_reason',
        'official_response',
        'timeline_step',
        'last_update_note',
        'kajian_id',
    ];

    public function kajian()
    {
        return $this->belongsTo(Kajian::class, 'kajian_id');
    }
}
