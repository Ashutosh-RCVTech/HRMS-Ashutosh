<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_types';
    protected $fillable = ['name'];



    public function jobOpenings()
    {
        return $this->belongsToMany(JobOpening::class);
    }
}
