<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreAttributesInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('nombres');
            $table->dropColumn('apellidos');
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->binary('imagen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('nombres');
            $table->string('apellidos');
            $table->dropColumn('primer_nombre')->nullable();
            $table->dropColumn('segundo_nombre')->nullable();
            $table->dropColumn('apellido_paterno')->nullable();
            $table->dropColumn('apellido_materno')->nullable();
            $table->dropColumn('imagen')->nullable();
        });
    }
}
