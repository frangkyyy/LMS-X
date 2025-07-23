<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLLearningStyles extends Model
{
    use HasFactory;

    protected $table = 'mdl_learning_styles';

    protected $fillable = [
        'id',
        'style_name',
        'dimension',
        'description'
    ];

    protected $primaryKey = 'id';

    public function options()
    {
        return $this->hasMany(DimensionOption::class, 'mdl_learning_styles_id', 'id');
    }

    public function quizs()
    {
        return $this->hasMany(MDLQuiz::class, 'learning_styles_id', 'id');
    }

}
