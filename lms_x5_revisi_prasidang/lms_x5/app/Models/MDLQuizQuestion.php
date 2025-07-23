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
        'learning_style',
        'topik',
    ];

    public $timestamps = false;

    public function quiz()
    {
        return $this->belongsTo(MDLQuiz::class, 'quiz_id');
    }

}
