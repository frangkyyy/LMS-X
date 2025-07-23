<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MDLQuizAnswer;

class MDLQuizAttempts extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz_attempts';

    protected $fillable = [
        'quiz_id', 'user_id', 'attempt_number', 'start_time', 'end_time', 'score'
    ];

    public function quiz()
    {
        return $this->belongsTo(MDLQuiz::class, 'quiz_id');
    }

    public function answers()
    {
        return $this->hasMany(MDLQuizAnswer::class, 'attempt_id');
    }

    public function grade()
    {
        return $this->hasOne(MDLQuizGrades::class, 'attempt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $dates = ['start_time', 'end_time'];

}
