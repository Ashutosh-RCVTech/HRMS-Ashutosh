<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\SkillsFactory;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'skills';
    protected $fillable = ['name'];

    public function jobOpenings()
    {
        return $this->belongsToMany(JobOpening::class, 'job_opening_skill', 'skill_id', 'job_opening_id');
    }
}
