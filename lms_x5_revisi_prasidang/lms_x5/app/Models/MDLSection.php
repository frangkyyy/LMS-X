<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLSection extends Model
{
    use HasFactory;

    protected $table = 'mdl_section';


    protected $fillable = [
        'course_id',
        'title',
        'description',
        'visible',
        'sort_order',
        'sub_cpmk',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    // Relasi ke mdl_course
    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id', 'id');
    }

    public function sub_topic()
    {
        return $this->hasMany(CourseSubtopik::class, 'section_id');
    }


    public function referensi()
    {
        return $this->hasMany(Referensi::class, 'section_id');
    }
}
