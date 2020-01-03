<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovilidadsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movilidades', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_termino')->nullable();
            $table->string('tipo')->default('Nuevo');
            $table->string('observaciones')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('movilidades');
    }
}
