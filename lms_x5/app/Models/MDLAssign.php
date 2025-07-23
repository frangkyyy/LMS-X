<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLAssign extends Model
{
    use HasFactory;

    protected $table = 'mdl_assign';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['course_id', 'name', 'learning_style', 'topik', 'description', 'due_date'];

    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }

    public function section()
    {
        return $this->belongsTo(MDLSection::class, 'section_id');
    }

    public function submission()
    {
        return $this->hasOne(MDLAssignSubmission::class, 'assign_id', 'id');
    }

    // In your MDLAssign model
    protected $dates = ['due_date'];

    protected $casts = [
        'due_date' => 'datetime'
    ];
}
