<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToMdlFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdl_files', function (Blueprint $table) {
            // Menambahkan kolom `deleted_at`
            $table->softDeletes(); // Kolom deleted_at bertipe timestamp
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mdl_files', function (Blueprint $table) {
            // Menghapus kolom `deleted_at`
            $table->dropSoftDeletes();
        });
    }
}
