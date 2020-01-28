<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablePropertyToFechaNacimientoAttributeInCargasFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cargas_familiares', function (Blueprint $table) {
            $table->dateTime('fecha_nacimiento')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cargas_familiares', function (Blueprint $table) {
            $table->dateTime('fecha_nacimiento')->nullable('false')->change();
        });
    }
}
