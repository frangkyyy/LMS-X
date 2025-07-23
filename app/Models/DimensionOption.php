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

    public function pages()
    {
        return $this->belongsToMany(MDLPage::class, 'mdl_page_style', 'page_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function urls()
    {
        return $this->belongsToMany(MDLUrl::class, 'mdl_url_style', 'url_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function labels()
    {
        return $this->belongsToMany(MDLLabel::class, 'mdl_label_style', 'label_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function folders()
    {
        return $this->belongsToMany(MDLFolder::class, 'mdl_folder_style', 'folder_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function files()
    {
        return $this->belongsToMany(MDLFiles::class, 'mdl_files_style', 'files_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function infografis()
    {
        return $this->belongsToMany(MDLInfografis::class, 'mdl_infografis_style', 'infografis_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(MDLLesson::class, 'mdl_lesson_style', 'lesson_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function assign()
    {
        return $this->belongsToMany(MDLAssign::class, 'mdl_assign_style', 'assign_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function quiz()
    {
        return $this->belongsToMany(MDLQuiz::class, 'mdl_quiz_style', 'quiz_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function forums()
    {
        return $this->belongsToMany(MDLForum::class, 'mdl_forum_style', 'forum_id', 'dimensi_opsi_id')
            ->withPivot( 'created_at','updated_at')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'mdl_user_learning_styles', 'mdl_learning_styles_id', 'user_id')
            ->withPivot(['dimension', 'a_count', 'b_count', 'final_score', 'category', 'description','created_at'])
            ->withTimestamps();
    }



}
