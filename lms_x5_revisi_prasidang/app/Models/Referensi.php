<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti pluralisasi default Laravel
    protected $table = 'mdl_referensi';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'section_id',
        'content',
    ];

    // Relasi ke MDLSection (asumsi satu referensi milik satu section)
    public function section()
    {
        return $this->belongsTo(MDLSection::class, 'section_id');
    }
}
