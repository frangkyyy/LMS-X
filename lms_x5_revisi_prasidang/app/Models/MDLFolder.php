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

    protected $fillable = [
        'name',
        'description',
        'learning_style_id',
        'file_path',
        'sub_topic_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relasi ke tabel MDLCourse
    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

    public function learning_style()
    {
        return $this->belongsTo(DimensionOption::class, 'learning_style_id','id');
    }

    public function getFilePathAttribute($value)
    {
        return asset($value);
    }

    public function files_save()
    {
        return $this->hasMany(MDLFileSave::class, 'folder_id','id');
    }
}
