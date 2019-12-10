<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipo', ['Gerencia General', 'Gerencia', 'Subgerencia', 'Área', 'Subarea']);
            $table->string('nombre');
            $table->unsignedInteger('padre_id')->nullable();
            $table->foreign('padre_id')->references('id')->on('departamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}
