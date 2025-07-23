<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimensionOption extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opsi_dimensi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_opsi_dimensi',
        'mdl_learning_styles_id',
        'description',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define the relationship with the LearningStyle model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function learningStyle()
    {
        return $this->belongsTo(MDLLearningStyles::class, 'mdl_learning_styles_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'mdl_user_learning_styles', 'mdl_learning_styles_id', 'user_id')
            ->withPivot(['dimension', 'a_count', 'b_count', 'final_score', 'category', 'description','created_at'])
            ->withTimestamps();
    }
}
