<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLPage extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'mdl_page';

    public $timestamps = false;


    // Primary Key
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [

        'name',
        'description',
        'content',
        'sub_topic_id',

    ];

// Relasi ke tabel MDLCourse
    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

    public function options()
    {
        return $this->belongsToMany(DimensionOption::class, 'mdl_page_style', 'page_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }
}
