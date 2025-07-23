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


}

