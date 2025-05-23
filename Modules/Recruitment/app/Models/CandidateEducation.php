<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateEducation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'candidate_educations';
    protected $fillable = [
        'candidate_id',
        'degree',
        'institution',
        'year',
        'grade'
    ];

    protected $casts = [
        'year' => 'integer'
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateUser::class, 'candidate_id');
    }
}
