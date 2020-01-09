<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCredencialVigilanteAttributeInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('credencial_vigilante')->nullable();
            $table->dateTime('vencimiento_credencial_vigilante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('credencial_vigilante');
            $table->dropColumn('vencimiento_credencial_vigilante');
        });
    }
}
