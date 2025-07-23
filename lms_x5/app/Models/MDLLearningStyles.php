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

    public function userLearningStyles()
    {
        return $this->hasMany(MDLUserLearningStyles::class, 'dimension', 'dimension');
    }
}
