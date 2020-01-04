<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtToTipoAreasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tipo_areas', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tipo_areas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
