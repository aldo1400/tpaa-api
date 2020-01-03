<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDepartamentosTableToAreasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::rename('departamentos', 'areas');

        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('tipo');
            $table->unsignedInteger('tipo_area_id')->nullable();
            $table->foreign('tipo_area_id')->references('id')->on('tipo_areas');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::rename('areas', 'departamentos');

        Schema::table('departamentos', function (Blueprint $table) {
            $table->enum('tipo', ['Gerencia General', 'Gerencia', 'Subgerencia', 'Área', 'Subarea']);
            $table->dropForeign('areas_tipo_area_id_foreign');
            $table->dropColumn('tipo_area_id');
            $table->dropColumn('estado');
        });
    }
}
