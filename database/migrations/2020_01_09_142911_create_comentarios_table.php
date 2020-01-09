<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('texto_libre')->nullable();
            $table->boolean('publico');
            $table->dateTime('fecha');
            $table->unsignedInteger('tipo_comentario_id')->nullable();
            $table->foreign('tipo_comentario_id')->references('id')->on('tipos_comentario');
            $table->unsignedInteger('colaborador_autor_id')->nullable();
            $table->foreign('colaborador_autor_id')->references('id')->on('colaboradores');
            $table->unsignedInteger('colaborador_id')->nullable();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            $table->boolean('estado')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
