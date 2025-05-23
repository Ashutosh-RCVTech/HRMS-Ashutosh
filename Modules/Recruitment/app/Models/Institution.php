<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Recruitment\Database\Factories\ExamAttemptFactory;

class Institution extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'institutions';

    protected $fillable = [
        'name',
        'location',
        'lat',
        'long',
        'type',
    ];
}
