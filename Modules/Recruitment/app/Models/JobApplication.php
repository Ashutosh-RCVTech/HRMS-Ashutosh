<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'job_id',
        'status',
        'resume_path',
        'cover_letter'
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }

    public function job()
    {
        return $this->belongsTo(JobOpening::class, 'job_id');
    }

    // Query scope for active applications
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'closed');
    }
}
