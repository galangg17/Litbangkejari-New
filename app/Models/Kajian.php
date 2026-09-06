<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_proposal_id',
        'title',
        'doc_no',
        'category',
        'access_type',
        'status',
        'urgency',
        'score',
        'pic_team',
        'pic_researcher',
        'show_researcher_name',
        'summary',
        'content',
        'bab1_pendahuluan',
        'bab2_tinjauan_yuridis',
        'bab3_metodologi_audit',
        'bab4_rekomendasi_brief',
        'bab5_juknis_sop',
        'impact_score',
        'hashtags',
        'downloads_count',
        'read_time',
        'tag',
        'infographic_points',
        'file_path',
        'review_substansi',
        'review_metodologi',
        'review_legal',
        'signed_by_ketua',
        'is_published',
    ];

    protected $casts = [
        'show_researcher_name' => 'boolean',
        'review_substansi' => 'boolean',
        'review_metodologi' => 'boolean',
        'review_legal' => 'boolean',
        'signed_by_ketua' => 'boolean',
        'is_published' => 'boolean',
        'hashtags' => 'array',
        'infographic_points' => 'array',
    ];

    public function proposal()
    {
        return $this->belongsTo(PublicProposal::class, 'public_proposal_id');
    }
}
