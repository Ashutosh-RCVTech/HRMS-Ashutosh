<?php

namespace Modules\Recruitment\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_categories';
    protected $fillable = [
        'quiz_id',
        'name',
        'active_status'
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestions::class, 'category_id');
    }
}
