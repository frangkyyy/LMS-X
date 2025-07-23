<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MDLForumPost extends Model
{
    use HasFactory;

    protected $table = 'mdl_forum_posts';
    protected $fillable = [
        'forum_id',
        'user_id',
        'content',
    ];

    public function forum()
    {
        return $this->belongsTo(MDLForum::class, 'forum_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
