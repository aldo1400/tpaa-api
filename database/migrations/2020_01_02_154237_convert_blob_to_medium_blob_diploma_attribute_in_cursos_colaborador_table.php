<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertBlobToMediumBlobDiplomaAttributeInCursosColaboradorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('ALTER TABLE cursos_colaborador MODIFY diploma MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            DB::statement('ALTER TABLE cursos_colaborador MODIFY diploma BLOB NULL');
        });
    }
}
