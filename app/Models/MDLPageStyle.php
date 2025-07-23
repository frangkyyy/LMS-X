<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLPageStyle extends Model
{
    use HasFactory;

    protected $table = 'mdl_page_style';
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'dimensi_opsi_id',
        'page_id',
        'created_at',
        'updated_at'

    ];


    public function pages()
    {
        return $this->belongsTo(MDLPage::class, 'page_id');
    }

    public function options()
    {
        return $this->belongsTo(DimensionOption::class, 'dimensi_opsi_id');
    }

}
