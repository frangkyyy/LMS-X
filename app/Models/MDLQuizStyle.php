<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLQuizStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_quiz_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'quiz_id',
        'created_at',
        'updated_at'

    ];


    public function quiz()
    {
        return $this->belongsTo(MDLQuiz::class, 'quiz_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
