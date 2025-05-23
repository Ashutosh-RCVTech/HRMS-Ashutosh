<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Benefit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'benefits';
    protected $fillable = ['name'];

    public function jobOpenings()
    {
        return $this->hasMany(JobOpening::class);
    }
}
