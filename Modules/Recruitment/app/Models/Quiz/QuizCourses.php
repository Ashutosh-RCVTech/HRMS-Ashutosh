<?php

namespace Modules\Recruitment\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizCourses extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_courses';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'duration', 
    ];

    public function quizes()
    {
        return $this->hasMany(Quizes::class, 'course_id', 'id');
    }
}
