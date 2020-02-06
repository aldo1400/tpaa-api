<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTipoArchivoAttributeInCursoColaboradorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            $table->dropColumn('tipo_archivo');
            $table->dropColumn('estado');
            $table->dropColumn('fecha');
            $table->string('url_diploma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            $table->string('tipo_archivo');
            $table->string('estado');
            $table->dateTime('fecha');
            $table->dropColumn('url_diploma');
        });
    }
}
