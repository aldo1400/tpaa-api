<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCapacitacionTableToCursoColaborador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('capacitaciones', 'cursos_colaborador');
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            $table->string('tipo_archivo');
            $table->boolean('estado')->default(1);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            $table->dropColumn('tipo_archivo');
            $table->dropColumn('estado');
            $table->dropSoftDeletes();
        });
        Schema::rename('cursos_colaborador','capacitaciones');
    }
}
