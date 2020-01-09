<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoComentariosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tipos_comentario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tipos_comentario');
    }
}
