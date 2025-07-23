<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLUrlStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_url_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'url_id',
        'created_at',
        'updated_at'
    ];


    public function urls()
    {
        return $this->belongsTo(MDLUrl::class, 'url_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
