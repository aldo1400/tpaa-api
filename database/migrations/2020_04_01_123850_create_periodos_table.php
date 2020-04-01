<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('year');
            $table->string('detalle')->nullable();
            $table->string('descripcion');
            $table->unsignedInteger('encuesta_plantilla_id');
            $table->foreign('encuesta_plantilla_id')->references('id')->on('encuesta_plantillas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
    }
}
