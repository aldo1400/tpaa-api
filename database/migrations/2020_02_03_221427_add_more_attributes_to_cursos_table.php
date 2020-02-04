<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreAttributesToCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('titulo');
            $table->integer('horas_cronologicas')->nullable();
            $table->text('realizado')->nullable();
            $table->string('anio');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_termino');
            $table->boolean('interno');
            $table->unsignedInteger('tipo_curso_id');
            $table->foreign('tipo_curso_id')->references('id')->on('tipo_cursos');
            $table->dropColumn('tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('titulo');
            $table->dropColumn('horas_cronologicas');
            $table->dropColumn('realizado');
            $table->dropColumn('anio');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_termino');
            $table->dropColumn('interno');
            $table->dropForeign('cursos_tipo_curso_id_foreign');
            $table->dropColumn('tipo_curso_id');
            $table->boolean('tipo');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
