<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Recruitment\Models\McqTestCandidate;
use Modules\Recruitment\Models\Quiz\Quizes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class CandidateUser extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_data',
        'provider_id',
        'token',
        'refresh_token',
        'expires_in',
        'profile_completed',
        'email_verified_at',
        'is_verified'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'profile_data' => 'array',
        'profile_completed' => 'boolean'
    ];

    // Relationships
    public function basicDetail()
    {
        return $this->hasOne(CandidateBasicDetail::class, 'candidate_id');
    }

    public function basic_detail()
    {
        return $this->hasOne(CandidateBasicDetail::class, 'candidate_id');
    }

    public function educations()
    {
        return $this->hasMany(CandidateEducation::class, 'candidate_id');
    }

    public function employments()
    {
        return $this->hasMany(CandidateEmployment::class, 'candidate_id');
    }

    public function careerProfile()
    {
        return $this->hasOne(CandidateCareerProfile::class, 'candidate_id');
    }

    // Query scope for new candidates
    public function scopeNewCandidates($query)
    {
        return $query->where('created_at', '>', now()->subDays(30));
    }

    public function mcqTests()
    {
        return $this->hasMany(McqTestCandidate::class, 'candidate_id');
    }

    /**
     * Get the quizzes assigned to this candidate.
     */
    public function assignedQuizzes()
    {
        return $this->belongsToMany(Quizes::class, 'mcq_test_candidates', 'candidate_id', 'quiz_id')
            ->withPivot('status', 'assigned_at', 'completed_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the quiz-candidate assignments for this candidate.
     */
    public function quizAssignments()
    {
        return $this->hasMany(McqTestCandidate::class, 'candidate_id');
    }

    // Add this method to your CandidateUser model
    public function markEmailAsVerified()
    {

        $this->email_verified_at = $this->freshTimestamp();
        $this->is_verified = true;
        $this->save();
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return isset($this->email_verified_at) && $this->is_verified === 1;
    }
}
