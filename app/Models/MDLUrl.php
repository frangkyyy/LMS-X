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
        'created_at',
    ];

    public function sub_topic()
    {
        return $this->belongsTo(CourseSubtopik::class, 'sub_topic_id','id');
    }

    public function options()
    {
        return $this->belongsToMany(DimensionOption::class, 'mdl_url_style', 'url_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }
}
