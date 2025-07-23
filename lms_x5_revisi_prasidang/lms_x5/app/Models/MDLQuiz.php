<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLQuiz extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz';

    protected $fillable = [
        'course_id', 'name', 'description', 'learning_style', 'topik', 'time_open', 'time_close', 'time_limit', 'max_attempts'
    ];

    protected $casts = [
        'time_open' => 'datetime',
        'time_close' => 'datetime',
    ];

    public function attempts()
    {
        return $this->hasMany(MDLQuizAttempts::class, 'quiz_id');
    }

    public function grades()
    {
        return $this->hasMany(MDLQuizGrades::class, 'quiz_id');
    }
}
