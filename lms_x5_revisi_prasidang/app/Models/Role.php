<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_role'];

    /**
     * Get the users associated with the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
