<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLLesson extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'mdl_lesson';

    public $timestamps = false;


    // Primary Key
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'sub_topic_id',
        'updated_at',
        'learning_style_id',
    ];

    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

    public function learning_style()
    {
        return $this->belongsTo(DimensionOption::class, 'mdl_learning_style_id','id');
    }
}
