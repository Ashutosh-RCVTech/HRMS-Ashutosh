<?php

namespace Modules\Recruitment\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizOptions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_options';
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct'
    ];
}
