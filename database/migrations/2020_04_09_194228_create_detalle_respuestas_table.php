<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detalle_respuestas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('evaluador_id');
            $table->foreign('evaluador_id')->references('id')->on('colaboradores');
            $table->integer('cargo_evaluador_id')->nullable();
            $table->integer('gerencia_evaluador_id')->nullable();
            $table->integer('subgerencia_evaluador_id')->nullable();
            $table->integer('area_evaluador_id')->nullable();
            $table->integer('subarea_evaluador_id')->nullable();
            $table->unsignedInteger('evaluado_id')->nullable();
            $table->foreign('evaluado_id')->references('id')->on('colaboradores');
            $table->integer('cargo_evaluado_id')->nullable();
            $table->integer('gerencia_evaluado_id')->nullable();
            $table->integer('subgerencia_evaluado_id')->nullable();
            $table->integer('area_evaluado_id')->nullable();
            $table->integer('subarea_evaluado_id')->nullable();

            $table->integer('cargo_polifuncionalidad_id')->nullable();
            $table->integer('horas_turno_polifuncionalidad')->nullable();

            $table->dateTime('fecha');

            $table->unsignedInteger('encuesta_id');
            $table->foreign('encuesta_id')->references('id')->on('encuestas');

            $table->unsignedInteger('cargo_id')->nullable();
            $table->foreign('cargo_id')->references('id')->on('cargos');

            $table->unsignedInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');

            $table->unsignedInteger('tipo_area_id')->nullable();
            $table->foreign('tipo_area_id')->references('id')->on('tipo_areas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('detalle_respuestas');
    }
}
