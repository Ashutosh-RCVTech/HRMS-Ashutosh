<?php

namespace Modules\Recruitment\Models\Placement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Recruitment\Models\College;


class PlacementColleges extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'placement_college';
    protected $fillable = [
        'placement_id',
        'college_id',
        'college_acceptance',
        'status'
    ];


    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }
    
}
