<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'schedules';
    protected $fillable = ['name'];

    public function jobOpenings()
    {
        return $this->belongsToMany(JobOpening::class, 'job_opening_schedules');
    }
}
