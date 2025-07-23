<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLQuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz_question';

    protected $fillable = [
        'quiz_id',
        'question_text',
        'options_a',
        'options_b',
        'options_c',
        'options_d',
        'correct_answer',
        'poin',
    ];

    public $timestamps = false;

    public function quizs()
    {
        return $this->belongsTo(MDLQuiz::class, 'quiz_id');
    }

}
