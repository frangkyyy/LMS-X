<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLUrl extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'mdl_url';

    public $timestamps = false;


    // Primary Key
    protected $primaryKey = 'id';

    protected $fillable = [
        'course_id',
        'name',
        'url_link',
        'description',
        'learning_style',
        'topik',
        'created_at',
    ];

    // Relasi ke tabel MDLCourse
    public function course()
    {
        return $this->belongsTo(MDLCourse::class, 'course_id');
    }
}
