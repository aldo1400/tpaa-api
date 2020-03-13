<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAttributeEstadoVarcharToIntegerInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        Schema::table('colaboradores', function (Blueprint $table) {
            // $table->dropColumn('estado');
            $table->integer('estado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->string('estado')->nullable();
        });
    }
}
