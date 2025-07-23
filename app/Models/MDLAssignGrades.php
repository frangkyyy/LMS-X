<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLAssignGrades extends Model
{
    use HasFactory;

    protected $table = 'mdl_assign_grades';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'assign_id',  // Sesuaikan dengan nama kolom di database
        'user_id',
        'grade',
        'feedback',
        'created_at',
    ];

    // Relasi ke Assignment
    public function assignment()
    {
        return $this->belongsTo(MDLAssign::class, 'assign_id');
    }

    // Relasi ke Submission
    public function submission()
    {
        return $this->belongsTo(MDLAssignSubmission::class, 'submission_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Feedback Comments melalui submission
    public function feedback_comments()
    {
        return $this->hasManyThrough(
            MDLFeedbackComments::class,
            MDLAssignSubmission::class,
            'id', // FK pada submissions
            'assign_id', // FK pada comments
            'assign_id', // PK grades
            'id' // PK submissions
        );
    }
}
