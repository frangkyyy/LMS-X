<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLFolder extends Model
{
    use HasFactory;

    protected $table = 'mdl_folder';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['course_id', 'name', 'folder_path', 'file_name'];

    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }
}
