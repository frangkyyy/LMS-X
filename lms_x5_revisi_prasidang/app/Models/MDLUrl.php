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
        'sub_topic_id',
        'name',
        'url_link',
        'description',
        'mdl_learning_style_id',
        'created_at',
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
