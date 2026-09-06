<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InnovationProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'innovation_no',
        'public_proposal_id',
        'innovator_name',
        'title',
        'category',
        'status',
        'is_published',
        'summary',
        'impact_description',
        'sop_file_path',
        'signed_by_ketua',
        'downloads_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'signed_by_ketua' => 'boolean',
    ];

    public function proposal()
    {
        return $this->belongsTo(PublicProposal::class, 'public_proposal_id');
    }
}
