<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateCareerProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'current_industry',
        'department',
        'desired_job_type',
        'desired_employment_type',
        'preferred_shift',
        'preferred_work_location',
        'expected_salary'
    ];

    protected $casts = [
        'expected_salary' => 'decimal:2'
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }
}
