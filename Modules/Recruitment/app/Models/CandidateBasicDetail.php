<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Recruitment\Models\CandidateUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateBasicDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        // 'name',
        'location',
        'mobile',
        'mobile_verified',
        'availability',
        'resume_path',
        'profile_image_path',
        'resume_headline',
        'key_skills',
        'it_skills',
        'projects',
        'profile_summary'
    ];

    protected $casts = [
        'mobile_verified' => 'boolean',
        'availability' => 'date',
        'key_skills' => 'array',
        'it_skills' => 'array'
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }
}
