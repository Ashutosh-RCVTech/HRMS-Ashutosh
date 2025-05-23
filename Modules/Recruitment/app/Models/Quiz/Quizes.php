<?php

namespace Modules\Recruitment\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\McqTestCandidate;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Quizes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quizes';
    protected $fillable = [
        'course_id',
        'name',
        'marks',
        'duration',
        'passing_marks',
        'schedule_date',
        'start_time',
        'timezone'
    ];

    public function categories()
    {
        return $this->hasMany(QuizCategories::class, 'quiz_id');
    }

    /**
     * Get the candidates assigned to this quiz.
     */
    public function assignedCandidates()
    {
        return $this->belongsToMany(CandidateUser::class, 'mcq_test_candidates', 'quiz_id', 'candidate_id')
            ->withPivot('status', 'assigned_at', 'completed_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the quiz-candidate assignments for this quiz.
     */
    public function assignments()
    {
        return $this->hasMany(McqTestCandidate::class, 'quiz_id');
    }
}
