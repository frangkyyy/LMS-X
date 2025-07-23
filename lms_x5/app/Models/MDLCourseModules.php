<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLCourseModules extends Model
{
    use HasFactory;

    protected $table = 'mdl_course_modules';
    protected $fillable = ['course', 'module', 'instance', 'visible'];

    public function contentRecommendation()
    {
        return $this->hasMany(ContentRecommendation::class, 'content_id', 'id');
    }
}
