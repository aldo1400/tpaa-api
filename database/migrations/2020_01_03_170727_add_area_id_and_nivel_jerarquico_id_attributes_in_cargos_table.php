<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAreaIdAndNivelJerarquicoIdAttributesInCargosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropColumn('nivel_jerarquico');
            $table->unsignedInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->unsignedInteger('nivel_jerarquico_id')->nullable();
            $table->foreign('nivel_jerarquico_id')->references('id')->on('niveles_jerarquico');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->enum('nivel_jerarquico', ['Estratégico Táctico', 'Operativo Supervisión', 'Táctico Operativo', 'Táctico', 'Ejecución']);
            $table->dropForeign('cargos_area_id_foreign');
            $table->dropColumn('area_id');
            $table->dropForeign('cargos_nivel_jerarquico_id_foreign');
            $table->dropColumn('nivel_jerarquico_id');
            $table->dropColumn('estado');
        });
    }
}
