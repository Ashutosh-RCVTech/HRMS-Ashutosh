<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\CollegeCandidateFactory;
use Modules\Recruitment\Models\CandidateUser;
class CollegeCandidate extends Model
{
    use HasFactory;

    protected $table = "college_candidates";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'candidate_id',
        'college_id'

    ];


    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    // protected static function newFactory(): CollegeCandidateFactory
    // {
    //     // return CollegeCandidateFactory::new();
    // }

    /**
     * Get the candidate user associated with this college candidate.
     */
    public function candidateInfo()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }

    
    public function candidateUser()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }

}
