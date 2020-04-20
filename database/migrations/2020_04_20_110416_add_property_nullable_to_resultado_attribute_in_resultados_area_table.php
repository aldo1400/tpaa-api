<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyNullableToResultadoAttributeInResultadosAreaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('resultado_areas', function (Blueprint $table) {
            $table->integer('resultado')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('resultado_areas', function (Blueprint $table) {
            $table->integer('resultado')->nullable(false)->change();
        });
    }
}
