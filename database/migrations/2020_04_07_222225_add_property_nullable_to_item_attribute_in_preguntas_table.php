<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyNullableToItemAttributeInPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('preguntas', function (Blueprint $table) {
            $table->string('item')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('preguntas', function (Blueprint $table) {
            $table->string('item')->nullable(false)->change();
        });
    }
}
