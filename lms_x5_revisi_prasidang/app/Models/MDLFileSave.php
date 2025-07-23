<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDLFileSave extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'mdl_files_save';

    // Primary Key
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'name',
        'description',
        'file_path',
        'folder_id',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Casts for type safety
    protected $casts = [

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relasi ke tabel MDLCourse
    public function folder_id()
    {
        return $this->belongsTo(MDLFolder::class, 'folder_id','id');
    }



    public function getFilePathAttribute($value)
    {
        return asset($value);
    }
}
