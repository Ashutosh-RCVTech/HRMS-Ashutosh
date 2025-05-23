<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'locations';
    protected $fillable = ['name'];

    public function jobOpenings()
    {
        return $this->belongsToMany(JobOpening::class, 'job_opening_locations', 'location_id', 'job_opening_id');
    }
}
