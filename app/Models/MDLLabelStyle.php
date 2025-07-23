<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLLabelStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_label_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'label_id',
        'created_at',
        'updated_at'

    ];


    public function labels()
    {
        return $this->belongsTo(MDLLabel::class, 'label_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
