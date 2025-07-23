<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLQuiz extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz';

    protected $fillable = [
        'sub_topic_id','name', 'description', 'time_open', 'time_close', 'time_limit', 'max_attempts','grade_to_pass','learning_style_id'
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

    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

//    public function learning_style()
//    {
//        return $this->belongsTo(DimensionOption::class, 'mdl_learning_style_id','id');
//    }

//     public function options()
//     {
//         return $this->belongsToMany(DimensionOption::class, 'mdl_quiz_style', 'quiz_id', 'dimensi_opsi_id')
//             ->withPivot( 'created_at','updated_at')
//             ->withTimestamps();
//     }


    public function dimensions()
    {
        return $this->belongsTo(MDLLearningStyles::class, 'learning_style_id','id');
    }
    public function questions()
    {
        return $this->hasMany(MDLQuizQuestion::class, 'quiz_id');
    }
}
