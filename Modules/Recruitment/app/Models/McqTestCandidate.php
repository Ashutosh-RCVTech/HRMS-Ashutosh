<?php

namespace Modules\Recruitment\Models;
use Modules\Recruitment\Models\ExamAttempt;
use Illuminate\Database\Eloquent\Model;
use Modules\Recruitment\Models\Quiz\Quizes;
use Modules\Recruitment\Models\CandidateUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Modules\Recruitment\Database\Factories\McqTestCandidateFactory;

class McqTestCandidate extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $guard = 'mcq_test_candidates';

    protected $fillable = [
        'email',
        'password',
        'candidate_id',
        'quiz_id',
        'placement_id',
        'college_id'
 ,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function candidateUser()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }

    public function candidateInfo()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }



    public function quiz()
    {
        return $this->belongsTo(Quizes::class, 'quiz_id');
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class,'mcq_test_candidate_id');
    }
}
