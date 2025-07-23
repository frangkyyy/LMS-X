<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentRecommendation extends Model
{
    use HasFactory;

    protected $table = 'content_recommendation';
    protected $fillable = ['content_id', 'learning_style_id', 'priority'];

    public function content()
    {
        return $this->belongsTo(MDLCourseModules::class, 'content_id', 'id');
    }
}
