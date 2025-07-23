<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MDLQuizAttempts;
use App\Models\MDLQuizQuestion;

class MDLQuizAnswer extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz_answers';

    protected $fillable = [
        'attempt_id',
        'question_id',
        'answer'
    ];

    public function attempt()
    {
        return $this->belongsTo(MDLQuizAttempts::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(MDLQuizQuestion::class, 'question_id');
    }
}
