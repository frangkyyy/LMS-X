<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $table = 'course_user';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'course_id',
        'user_id',
        'participant_role',
    ];

    // Define participant roles to match the database enum values
    const PARTICIPANT_ROLES = ['Student', 'Teacher', 'Admin'];

    // Relationships
    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
