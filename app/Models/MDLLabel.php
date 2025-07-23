<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLLabel extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'mdl_label';

    public $timestamps = false;


    // Primary Key
    protected $primaryKey = 'id';

    protected $fillable = [

        'konten',
        'sub_topic_id',

    ];

    // Relasi ke tabel MDLCourse
    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

    public function options()
    {
        return $this->belongsToMany(DimensionOption::class, 'mdl_label_style', 'label_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }
}
