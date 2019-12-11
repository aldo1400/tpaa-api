<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->enum('nivel_jerarquico', ['Estratégico Táctico,Operativo Supervisión,Táctico Operativo,Táctico,Ejecución']);
            $table->unsignedInteger('supervisor_id')->nullable();
            $table->foreign('supervisor_id')->references('id')->on('cargos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cargos');
    }
}
