<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLReflective extends Model
{
    use HasFactory;
    protected $table = 'mdl_reflective';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['course_id', 'section_id', 'title', 'description', 'content_type'];

    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }

    public function section()
    {
        return $this->belongsTo(MDLSection::class, 'section_id');
    }
}
