<?php

namespace Modules\Recruitment\Models\Placement;
use Modules\Recruitment\Models\Placement\Placements;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Recruitment\Models\Placement\Placement;
use Modules\Recruitment\Models\Quiz\Quizes;
use Modules\Recruitment\Models\Placement\PlacementColleges;

use Modules\Recruitment\Models\Quiz\QuizCourses;
class QuizSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_schedule';

    protected $fillable = [
        'placement_id',
        'college_id',
        'course_id',
        'quiz_id',
        'schedule_date',
        'start_time',
        'timezone',
    ];

    /**
     * Get the placement associated with the quiz schedule.
     */
    public function placement()
    {
        return $this->belongsTo(Placements::class, 'placement_id');
    }

    /**
     * Get the course associated with the quiz schedule.
     */
    public function course()
    {
        return $this->belongsTo(QuizCourses::class, 'course_id');
    }

    /**
     * Get the quiz associated with the quiz schedule.
     */
    public function quiz()
    {
        return $this->belongsTo(Quizes::class, 'quiz_id');
    }

    public function college()
{
    return $this->belongsTo(PlacementColleges::class, 'placement_college_id');
}
}
