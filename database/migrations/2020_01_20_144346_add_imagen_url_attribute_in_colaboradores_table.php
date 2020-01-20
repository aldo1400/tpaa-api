<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagenUrlAttributeInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('imagen_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('imagen_url');
        });
    }
}
