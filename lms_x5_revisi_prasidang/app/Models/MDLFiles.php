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

    // Primary Key
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'name',
        'description',
        'learning_style_id',
        'file_path',
        'sub_topik_id',
        'created_at',
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
}
