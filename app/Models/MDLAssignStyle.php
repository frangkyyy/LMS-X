<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLAssignStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_assign_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'assign_id',
        'created_at',
        'updated_at'

    ];


    public function assign()
    {
        return $this->belongsTo(MDLAssign::class, 'assign_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
