<?php

namespace Modules\Recruitment\Models\Placement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Recruitment\Models\Placement\PlacementDegrees;
use Modules\Recruitment\Models\Placement\PlacementSkills;
use Modules\Recruitment\Models\EducationLevel;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Models\Skill;
use Modules\Recruitment\Models\Degree;
class Placements extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'placement';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'no_of_openings',
        'education_level_id' ,
        'status'
    ];
    
    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }
    public function placementColleges()
    {
        return $this->hasMany(PlacementColleges::class, 'placement_id');
    }

    // 💡 Placement has many degree entries
    public function placementDegrees()
    {
        return $this->hasMany(PlacementDegrees::class, 'placement_id');
    }

    // 💡 Placement has many skill entries
    public function placementSkills()
    {
        return $this->hasMany(PlacementSkills::class, 'placement_id');
    }

    // Direct access to actual colleges
    public function colleges()
    {
        return $this->hasManyThrough(
            College::class,
            PlacementColleges::class,
            'placement_id',
            'id',
            'id',
            'college_id'
        );
    }

    // Direct access to actual degrees
    public function degrees()
    {
        return $this->hasManyThrough(
            Degree::class,
            PlacementDegrees::class,
            'placement_id',
            'id',
            'id',
            'degree_id'
        );
    }

    // Direct access to actual skills
    public function skills()
    {
        return $this->hasManyThrough(
            Skill::class,
            PlacementSkills::class,
            'placement_id',
            'id',
            'id',
            'skill_id'
        );
    }
    
}
