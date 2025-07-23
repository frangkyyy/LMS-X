<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLForum extends Model
{
    use HasFactory;

    protected $table = 'mdl_forum';

    protected $primaryKey = 'id';

    protected $fillable = [
        'sub_topic_id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ];
    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

//    public function learning_style()
//    {
//        return $this->belongsTo(DimensionOption::class, 'learning_style_id','id');
//    }

    public function options()
    {
        return $this->belongsToMany(DimensionOption::class, 'mdl_forum_style', 'forum_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(MDLForumPost::class, 'forum_id');
    }

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
}
