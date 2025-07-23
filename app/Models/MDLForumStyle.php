<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLForumStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_forum_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'forum_id',
        'created_at',
        'updated_at'

    ];


    public function forums()
    {
        return $this->belongsTo(MDLForum::class, 'forum_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
