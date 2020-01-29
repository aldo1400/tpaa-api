<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositivoAttributeInComentariosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->boolean('positivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropColumn('positivo');
        });
    }
}
