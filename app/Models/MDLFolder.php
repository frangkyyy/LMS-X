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

    public function options()
    {
        return $this->belongsToMany(DimensionOption::class, 'mdl_folder_style', 'folder_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
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
