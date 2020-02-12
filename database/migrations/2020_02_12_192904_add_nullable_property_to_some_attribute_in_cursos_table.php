<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablePropertyToSomeAttributeInCursosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('titulo')->nullable()->change();
            $table->string('anio')->nullable()->change();
            $table->dateTime('fecha_inicio')->nullable()->change();
            $table->dateTime('fecha_termino')->nullable()->change();
            $table->boolean('interno')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('titulo')->nullable(false)->change();
            $table->string('anio')->nullable(false)->change();
            $table->dateTime('fecha_inicio')->nullable(false)->change();
            $table->dateTime('fecha_termino')->nullable(false)->change();
            $table->boolean('interno')->nullable(false)->change();
        });
    }
}
