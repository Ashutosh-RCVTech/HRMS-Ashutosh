<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\CollegeCandidatePlacementFactory;

class CollegeCandidatePlacement extends Model
{
    use HasFactory;
    protected $table = "college_candidate_placements";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'college_candidate_id',
        'placement_id',
    ];

    // protected static function newFactory(): CollegeCandidatePlacementFactory
    // {
    //     // return CollegeCandidatePlacementFactory::new();
    // }

    /**
     * Get the college candidate associated with this placement.
     */
    public function collegeCandidate()
    {
        return $this->belongsTo(CollegeCandidate::class, 'college_candidate_id');
    }

    /**
     * Get the college candidate associated with this placement, including soft-deleted records.
     */
    public function collegeCandidateWithTrashed()
    {
        return $this->belongsTo(CollegeCandidate::class, 'college_candidate_id')->withTrashed();
    }
}
