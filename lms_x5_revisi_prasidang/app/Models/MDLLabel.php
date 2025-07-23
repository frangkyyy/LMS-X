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
        'learning_style_id',
        'sub_topic_id',

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
}
