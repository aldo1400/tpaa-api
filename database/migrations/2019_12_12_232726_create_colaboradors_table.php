<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColaboradorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut')->unique();

            $table->unsignedInteger('gerencia_id')->nullable();
            $table->foreign('gerencia_id')->references('id')->on('departamentos');
            $table->unsignedInteger('subgerencia_id')->nullable();
            $table->foreign('subgerencia_id')->references('id')->on('departamentos');
            $table->unsignedInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('departamentos');
            $table->unsignedInteger('subarea_id')->nullable();
            $table->foreign('subarea_id')->references('id')->on('departamentos');

            $table->string('usuario')->nullable();
            $table->string('password')->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('sexo')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->enum('estado_civil', ['Casado (a)', 'Soltero (a)', 'Divorciado (a)', 'Unión Civil'])->nullable();
            $table->dateTime('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('email')->nullable();
            $table->string('nivel_educacion')->nullable();
            $table->string('domicilio')->nullable();
            $table->enum('licencia_b', ['SI', 'NO', 'N/A'])->nullable();
            $table->dateTime('vencimiento_licencia_b')->nullable();
            $table->enum('licencia_d', ['SI', 'NO', 'N/A'])->nullable();
            $table->dateTime('vencimiento_licencia_d')->nullable();
            $table->enum('carnet_portuario', ['SI', 'NO', 'N/A'])->nullable();
            $table->dateTime('vencimiento_carnet_portuario')->nullable();
            $table->string('talla_calzado')->nullable();
            $table->string('talla_chaleco')->nullable();
            $table->string('talla_polera')->nullable();
            $table->string('talla_pantalon')->nullable();
            $table->dateTime('fecha_ingreso')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('anexo')->nullable();
            $table->string('contacto_emergencia_nombre')->nullable();
            $table->string('contacto_emergencia_telefono')->nullable();
            $table->enum('estado', ['Activo (a)', 'Desvinculado (a)', 'Renuncia'])->nullable();
            $table->dateTime('fecha_inactividad')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
}
