<?php

namespace Modules\Recruitment\Models\Placement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Recruitment\Models\Degree;
class PlacementDegrees extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'placement_degree';
    protected $fillable = [
        'placement_id',
        'degree_id',
        
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
