<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOpening extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'job_openings';
    protected $fillable = [
        'title',
        'description',
        'client',
        'no_of_openings',
        'experience_required',
        'required_skills',
        'location_type',
        'min_salary',
        'max_salary',
        'education_level',
        'degree',
        'status',
        'application_deadline',
        'user_id',
        'posted_by',
        'company_id',
        'department_id',
        'designation_id',
        'education_id',
        'job_type_id',
        'skill_id',
        'location_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'required_skills' => 'array',
        'application_deadline' => 'date',
        'experience_required' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_opening_skills', 'job_opening_id', 'skill_id');
    }

    public function jobTypes()
    {
        return $this->belongsToMany(JobType::class, 'job_opening_job_types', 'job_opening_id', 'job_type_id');
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'job_opening_schedules', 'job_opening_id', 'schedule_id');
    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class, 'job_opening_benefits', 'job_opening_id', 'benefit_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_opening_locations', 'job_opening_id', 'location_id');
    }

    public function isAppliedByCandidate($candidateId)
    {
        return JobApplication::where('candidate_id', $candidateId)
            ->where('job_id', $this->id)
            ->exists();
    }

    public function bookmarks()
    {
        return $this->belongsToMany(CandidateUser::class, 'job_bookmarks', 'job_id', 'candidate_id')
            ->withTimestamps();
    }

    public function toggleBookmark($candidateId)
    {
        if ($this->bookmarks()->where('candidate_id', $candidateId)->exists()) {
            $this->bookmarks()->detach($candidateId);
            return false;
        }

        $this->bookmarks()->attach($candidateId);
        return true;
    }

    public function isBookmarkedByCandidate($candidateId)
    {
        return $this->bookmarks()->where('candidate_id', $candidateId)->exists();
    }

    // Query scope for upcoming deadlines
    public function scopeUpcomingDeadlines($query)
    {
        return $query->whereBetween('application_deadline', [now(), now()->addDays(7)]);
    }

    /* Scope a query to only include active job openings
    *
    * @param Builder $query
    * @return Builder
    */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'open');
    }

    public function organizationUser()
    {
        return $this->belongsTo(OrganizationUser::class);
    }

    public function application()
    {
        return $this->hasOne(JobApplication::class, 'job_id')
            ->where('candidate_id', auth('candidate')->id());
    }

    public static function getExperienceRanges()
    {
        return [
            '0-1' => '0-1 Year',
            '1-3' => '1-3 Years',
            '3-5' => '3-5 Years',
            '5-8' => '5-8 Years',
            '8-10' => '8-10 Years',
            '10+' => '10+ Years'
        ];
    }

    public static function rules($id = null)
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'experience_required' => [
                'required',
                'string',
                'in:' . implode(',', array_keys(self::getExperienceRanges())),
            ],
            'location_type' => 'required|string|in:remote,hybrid,onsite',
            'min_salary' => 'required|numeric|min:0',
            'max_salary' => 'required|numeric|min:0|gte:min_salary',
            'status' => 'required|string|in:active,inactive',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'education_id' => 'required|exists:education,id',
            'job_type_id' => 'required|exists:job_types,id',
            'skill_id' => 'required|exists:skills,id',
            'location_id' => 'required|exists:locations,id',
        ];
    }
}
