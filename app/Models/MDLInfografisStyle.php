<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLInfografisStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_infografis_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'infografis_id',
        'created_at',
        'updated_at'

    ];


    public function infografis()
    {
        return $this->belongsTo(MDLInfografis::class, 'infografis_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
