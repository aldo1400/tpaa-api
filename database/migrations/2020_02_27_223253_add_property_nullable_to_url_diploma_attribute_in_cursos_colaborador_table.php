<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyNullableToUrlDiplomaAttributeInCursosColaboradorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            $table->string('url_diploma')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cursos_colaborador', function (Blueprint $table) {
            $table->string('url_diploma')->nullable(false)->change();
        });
    }
}
