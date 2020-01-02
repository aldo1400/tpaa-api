<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagColaboradorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('colaborador_tag', function (Blueprint $table) {
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('colaborador_tag', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
