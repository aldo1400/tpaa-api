<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaColaboradorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('colaborador_encuesta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('colaborador_id');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            $table->unsignedInteger('encuesta_id');
            $table->foreign('encuesta_id')->references('id')->on('encuestas');
            $table->string('estado');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('colaborador_encuesta');
    }
}
