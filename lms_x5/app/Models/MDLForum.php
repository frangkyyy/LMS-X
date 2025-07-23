<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLForum extends Model
{
    use HasFactory;

    protected $table = 'mdl_forum';
    protected $fillable = ['course_id', 'section_id', 'learning_style', 'topik', 'name', 'description'];

    public function posts()
    {
        return $this->hasMany(MDLForumPost::class, 'forum_id');
    }

    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }

    public function section()
    {
        return $this->belongsTo(MDLSection::class, 'section_id');
    }

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
}
