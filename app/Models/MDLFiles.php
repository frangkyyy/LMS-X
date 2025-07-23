<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDLFiles extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'mdl_files';

    public $timestamps = false;

    // Primary Key
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'name',
        'description',
        'file_path',
        'sub_topic_id',
    ];

    // Relasi ke tabel MDLCourse
    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

    public function options()
    {
        return $this->belongsToMany(DimensionOption::class, 'mdl_files_style', 'files_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function getFilePathAttribute($value)
    {
        return asset($value);
    }
}
