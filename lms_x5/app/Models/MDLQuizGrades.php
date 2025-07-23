<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLQuizGrades extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz_grades';

    protected $fillable = [
        'quiz_id', 'user_id', 'grade', 'attempt_number', 'completed_at'
    ];

    public function quiz()
    {
        return $this->belongsTo(MDLQuiz::class, 'quiz_id');
    }

    public function attempt()
    {
        return $this->belongsTo(MDLQuizAttempts::class, 'attempt_id');
    }

    protected $dates = ['completed_at'];
}
