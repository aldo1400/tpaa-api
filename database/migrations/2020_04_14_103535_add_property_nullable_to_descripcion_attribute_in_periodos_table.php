<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyNullableToDescripcionAttributeInPeriodosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('periodos', function (Blueprint $table) {
            $table->string('descripcion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('periodos', function (Blueprint $table) {
            $table->string('descripcion')->nullable(false)->change();
        });
    }
}
