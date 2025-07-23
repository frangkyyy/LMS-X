<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLLessonStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_lesson_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'lesson_id',
        'created_at',
        'updated_at'

    ];


    public function lessons()
    {
        return $this->belongsTo(MDLLesson::class, 'lesson_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
