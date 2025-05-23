<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlacementDrive extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'college_id',
        'title',
        'description',
        'drive_date',
        'start_time',
        'end_time',
        'venue',
        'max_students',
        'eligibility_criteria',
        'required_documents',
        'minimum_cgpa',
        'backlog_allowed',
        'is_active',
        'is_completed',
    ];

    protected $casts = [
        'drive_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'eligibility_criteria' => 'array',
        'required_documents' => 'array',
        'minimum_cgpa' => 'decimal:2',
        'is_active' => 'boolean',
        'is_completed' => 'boolean',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function getStatusAttribute()
    {
        if ($this->is_completed) {
            return 'Completed';
        }

        if (!$this->is_active) {
            return 'Cancelled';
        }

        if ($this->drive_date->isPast()) {
            return 'Past';
        }

        return 'Upcoming';
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'Completed' => 'green',
            'Cancelled' => 'red',
            'Past' => 'gray',
            'Upcoming' => 'blue',
            default => 'gray'
        };
    }
}
