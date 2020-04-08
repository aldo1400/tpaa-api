<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicadoAttributeInPeriodosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('periodos', function (Blueprint $table) {
            $table->integer('publicado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('periodos', function (Blueprint $table) {
            $table->dropColumn('publicado');
        });
    }
}
