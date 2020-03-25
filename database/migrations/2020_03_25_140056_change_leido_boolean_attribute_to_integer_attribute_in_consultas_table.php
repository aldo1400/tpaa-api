<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLeidoBooleanAttributeToIntegerAttributeInConsultasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->integer('leido')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->boolean('leido')->default(0)->change();
        });
    }
}
