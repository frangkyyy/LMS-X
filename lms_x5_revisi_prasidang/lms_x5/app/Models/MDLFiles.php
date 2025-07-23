<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDLFiles extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Menentukan nama kolom deleted_at
    protected $dates = ['deleted_at'];

    // Nama tabel yang digunakan
    protected $table = 'mdl_files';

    // Primary Key
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'course_id',
        'name',
        'description',
        'learning_style',
        'topik',
        'type',
        'file_path',
        'created_at',
    ];

    // Relasi ke tabel MDLCourse
    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }
}
