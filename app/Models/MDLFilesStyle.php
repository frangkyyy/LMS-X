<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLFilesStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_files_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'files_id',
        'created_at',
        'updated_at'

    ];


    public function pages()
    {
        return $this->belongsTo(MDLFiles::class, 'files_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }

}
