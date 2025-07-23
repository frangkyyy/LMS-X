<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLAssign extends Model
{
    use HasFactory;

    protected $table = 'mdl_assign';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'sub_topic_id',
        'name',
        'learning_style_id',
        'description',
        'content',
        'due_date',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'due_date' => 'datetime'
    ];

    // Relasi ke Subtopik
    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id');
    }

    // Relasi ke Learning Style
    public function learning_style()
    {
        return $this->belongsTo(DimensionOption::class, 'learning_style_id');
    }

    // Relasi ke Submissions (satu assignment bisa banyak submission)
    public function submissions()
    {
        return $this->hasMany(MDLAssignSubmission::class, 'assign_id');
    }

    // Relasi ke Grades (satu assignment bisa banyak grade)
    public function grades()
    {
        return $this->hasMany(MDLAssignGrades::class, 'assign_id');
    }

    // Relasi ke Feedback Comments melalui submission
    public function feedback_comments()
    {
        return $this->hasManyThrough(
            MDLFeedbackComments::class,
            MDLAssignSubmission::class,
            'assign_id', // FK pada submissions
            'assign_id', // FK pada comments
            'id', // PK assignments
            'id' // PK submissions
        );
    }

    // // Helper untuk mendapatkan section melalui subtopic
    // public function section()
    // {
    //     return $this->hasOneThrough(
    //         MDLSection::class,
    //         CourseSubtopik::class,
    //         'id',
    //         'id',
    //         'sub_topic_id',
    //         'section_id'
    //     );
    // }

    // // Helper untuk mendapatkan course melalui section
    // public function course()
    // {
    //     return $this->hasOneThrough(
    //         MDLCourse::class,
    //         CourseSubtopik::class,
    //         'id',
    //         'id',
    //         'sub_topic_id',
    //         'course_id'
    //     );
    // }
}
