<?php

namespace Modules\Recruitment\Models\Placement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Recruitment\Models\Skill;

class PlacementSkills extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'placement_required_skills';
    protected $fillable = [
        'placement_id',
        'skill_id',
        
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
