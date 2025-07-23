<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSubtopik extends Model
{
    use HasFactory;

    protected $table = 'mdl_course_subtopik';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'section_id',
        'title',
        'description',
        'content',
        'visible',
        'sortorder',
    ];

    /**
     * Relasi ke model MDLSection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(MDLSection::class, 'section_id', 'id');
    }
    public function labels()
    {
        return $this->hasMany(MDLLabel::class, 'sub_topic_id', 'id');
    }

    public function pages()
    {
        return $this->hasMany(MDLPage::class, 'sub_topic_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(MDLFiles::class, 'sub_topic_id', 'id');
    }

    public function infografis()
    {
        return $this->hasMany(MDLInfografis::class, 'sub_topic_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(MDLAssign::class, 'sub_topic_id', 'id');
    }

    public function forums()
    {
        return $this->hasMany(MDLForum::class, 'sub_topic_id', 'id');
    }

    public function lessons()
    {
        return $this->hasMany(MDLLesson::class, 'sub_topic_id', 'id');
    }

    public function urls()
    {
        return $this->hasMany(MDLUrl::class, 'sub_topic_id', 'id');
    }

    public function quizs()
    {
        return $this->hasMany(MDLQuiz::class, 'sub_topic_id', 'id');
    }

    public function folders()
    {
        return $this->hasMany(MDLFolder::class, 'sub_topic_id', 'id');
    }
}

