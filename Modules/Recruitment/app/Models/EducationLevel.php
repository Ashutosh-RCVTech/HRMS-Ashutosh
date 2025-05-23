<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\EducationLevelFactory;

class EducationLevel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'education_levels';
    protected $fillable = ['name'];

    public function jobOpenings()
    {
        return $this->hasMany(JobOpening::class);
    }

    public function candidates()
    {
        return $this->hasMany(CandidateUser::class);
    }
}
