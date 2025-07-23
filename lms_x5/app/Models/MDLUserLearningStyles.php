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
        'description'
    ];

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    public function learningStyle()
    {
        return $this->belongsTo(MDLLearningStyles::class, 'dimension', 'dimension');
    }

    public function getLearningStyleAttribute()
    {
        return preg_replace('/^\d+/', '', $this->final_score);
    }
}
