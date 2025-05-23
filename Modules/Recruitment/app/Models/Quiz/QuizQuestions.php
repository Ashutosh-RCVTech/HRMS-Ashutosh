<?php

namespace Modules\Recruitment\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizQuestions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_questions';
    protected $fillable = [
        'category_id',
        'question_text',
        'quiz_id'
    ];

    protected $casts = [
        'ordered' => 'integer',
    ];

    public function options()
    {
        return $this->hasMany(QuizOptions::class, 'question_id');
    }

    public function category()
    {
        return $this->belongsTo(QuizCategories::class);
    }

    public function correctOption()
    {
        return $this->hasOne(QuizOptions::class)->where('is_correct', true);
    }

    /**
     * Scope a query to only include active questions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include questions of a specific category.
     */
    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to only include questions of a specific difficulty level.
     */
    public function scopeDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Get the category name.
     */
    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    /**
     * Get the difficulty level name.
     */
    public function getDifficultyLevelNameAttribute()
    {
        $levels = [
            'easy' => 'Easy',
            'medium' => 'Medium',
            'hard' => 'Hard'
        ];

        return $levels[$this->difficulty_level] ?? $this->difficulty_level;
    }
}
