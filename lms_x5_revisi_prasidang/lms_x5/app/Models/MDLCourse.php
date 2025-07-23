<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLCourse extends Model
{
    use HasFactory;

    protected $table = 'mdl_course';

    protected $fillable = [
       'full_name',
    'short_name',
    'summary',
    'cpmk',
    'course_image',
    'semester',
    'visible',
    'category',
    'start_date',
    'end_date',
    ];
    protected $dates = ['start_date', 'end_date'];

    protected $primaryKey = 'id';
//    public $timestamps = false; // Menonaktifkan timestamps jika tidak ada created_at dan updated_at

    protected $casts = [
        'visible' => 'boolean', // Mengubah kolom visible menjadi boolean
    ];



    public function sections()
        {
            return $this->hasMany(MDLSection::class, 'course_id', 'id');
        }

        public function users()
        {
            return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')
                        ->withPivot('participant_role')
                        ->withTimestamps();
        }
}

