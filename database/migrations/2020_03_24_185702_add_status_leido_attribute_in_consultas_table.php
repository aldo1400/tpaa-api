<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusLeidoAttributeInConsultasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->boolean('leido')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn('leido');
        });
    }
}
