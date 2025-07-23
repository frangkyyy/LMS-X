<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLFolderStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_folder_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'folder_id',
        'created_at',
        'updated_at'

    ];


    public function folders()
    {
        return $this->belongsTo(MDLFolder::class, 'folder_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }
}
