<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLUserLearningStyles extends Model
{
    use HasFactory;

    protected $table = 'mdl_user_learning_styles';

    protected $fillable = [
        'user_id',
        'dimension',
        'a_count',
        'b_count',
        'learning_style_id',
        'final_score',
        'category',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    public function learningStyle()
    {
        return $this->belongsTo(MDLLearningStyles::class, 'dimension', 'dimension');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function optionStyle()
    {
        return $this->belongsTo(DimensionOption::class, 'learning_style_id');
    }

    public function getLearningStyleAttribute()
    {
        return preg_replace('/^\d+/', '', $this->final_score);
    }
}
