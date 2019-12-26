<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSomeAttributesInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropForeign('colaboradores_gerencia_id_foreign');
            $table->dropColumn('gerencia_id');

            $table->dropForeign('colaboradores_subgerencia_id_foreign');
            $table->dropColumn('subgerencia_id');

            $table->dropForeign('colaboradores_area_id_foreign');
            $table->dropColumn('area_id');

            $table->dropForeign('colaboradores_subarea_id_foreign');
            $table->dropColumn('subarea_id');

            $table->unsignedInteger('estado_civil_id')->nullable();
            $table->foreign('estado_civil_id')->references('id')->on('estado_civiles');
            $table->unsignedInteger('nivel_educacion_id')->nullable();
            $table->foreign('nivel_educacion_id')->references('id')->on('niveles_educacion');
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn(['estado', 'licencia_b', 'licencia_d', 'carnet_portuario']);
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('estado')->nullable();
            $table->string('licencia_b')->nullable();
            $table->string('licencia_d')->nullable();
            $table->string('carnet_portuario')->nullable();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->unsignedInteger('gerencia_id')->nullable();
            $table->foreign('gerencia_id')->references('id')->on('departamentos');
            $table->unsignedInteger('subgerencia_id')->nullable();
            $table->foreign('subgerencia_id')->references('id')->on('departamentos');
            $table->unsignedInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('departamentos');
            $table->unsignedInteger('subarea_id')->nullable();
            $table->foreign('subarea_id')->references('id')->on('departamentos');

            $table->dropForeign('colaboradores_estado_civil_id_foreign');
            $table->dropColumn('estado_civil_id');

            $table->dropForeign('colaboradores_nivel_educacion_id_foreign');
            $table->dropColumn('nivel_educacion_id');
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn(['estado', 'licencia_b', 'licencia_d', 'carnet_portuario']);
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->enum('estado', ['Activo (a)', 'Desvinculado (a)', 'Renuncia'])->nullable();
            $table->enum('licencia_b', ['SI', 'NO', 'N/A'])->nullable();
            $table->enum('licencia_d', ['SI', 'NO', 'N/A'])->nullable();
            $table->enum('carnet_portuario', ['SI', 'NO', 'N/A'])->nullable();
        });
    }
}
