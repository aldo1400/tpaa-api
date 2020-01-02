<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreAttributesInTagsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->boolean('estado')->default(1)->nullable();
            $table->string('tipo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('tipo');
        });
    }
}
