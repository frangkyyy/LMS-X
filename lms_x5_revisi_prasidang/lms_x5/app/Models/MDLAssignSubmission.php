<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDLAssignSubmission extends Model
{
    use HasFactory;

    protected $table = 'mdl_assign_submission';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['assign_id', 'user_id', 'file_path', 'status'];

    public function assign()
    {
        return $this->belongsTo(MDLAssign::class, 'assign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
