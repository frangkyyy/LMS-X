<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLFeedbackComments extends Model
{
    use HasFactory;

    protected $table = 'mdl_assignfeedback_comments';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'assign_id',
        'user_id',
        'comment',
        'created_at',
    ];

    // Relasi ke Submission
    public function submission()
    {
        return $this->belongsTo(MDLAssignSubmission::class, 'assign_id');
    }

    // Relasi ke User (pemberi komentar)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Assignment melalui submission
    public function assignment()
    {
        return $this->hasOneThrough(
            MDLAssign::class,
            MDLAssignSubmission::class,
            'id', // FK pada submissions
            'id', // FK pada assignments
            'assign_id', // PK comments
            'assign_id' // PK submissions
        );
    }
}
