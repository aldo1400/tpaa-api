<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resultado');
            $table->integer('valor_respuesta')->nullable();
            $table->unsignedInteger('pregunta_id');
            $table->foreign('pregunta_id')->references('id')->on('preguntas');
            $table->unsignedInteger('detalle_respuesta_id');
            $table->foreign('detalle_respuesta_id')->references('id')->on('detalle_respuestas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
}
