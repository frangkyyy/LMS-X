<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLAssignSubmission extends Model
{
    use HasFactory;

    protected $table = 'mdl_assign_submission';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'assign_id',
        'user_id',
        'file_path',
        'status',
        'submitted_at',
        'created_at',
    ];

    protected $dates = ['submitted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'file_path' => 'array',
        'submitted_at' => 'datetime'
    ];

    // Helper method untuk mengakses files
    public function getFilesAttribute()
    {
        if (is_array($this->file_path)) {
            return collect($this->file_path);
        }

        try {
            return collect(json_decode($this->file_path, true));
        } catch (\Exception $e) {
            return collect();
        }
    }

    // Relasi ke Assignment
    public function assignment()
    {
        return $this->belongsTo(MDLAssign::class, 'assign_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Grade
    public function grade()
    {
        return $this->hasOne(MDLAssignGrades::class, 'submission_id');
    }

    // Relasi ke Feedback Comments
    public function feedback_comments()
    {
        return $this->hasMany(MDLFeedbackComments::class, 'assign_id');
    }

    // Relasi ke Learning Style melalui user
    public function learning_style()
    {
        return $this->hasOneThrough(
            DimensionOption::class,
            User::class,
            'id', // FK pada users
            'id', // FK pada learning_styles
            'user_id', // PK submissions
            'learning_style_id' // PK users
        );
    }
}
