<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptorAndOrganigramaAttributeInCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->string('descriptor')->nullable();
            $table->string('descriptor_url')->nullable();
            $table->string('organigrama')->nullable();
            $table->string('organigrama_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropColumn('descriptor');
            $table->dropColumn('descriptor_url');
            $table->dropColumn('organigrama');
            $table->dropColumn('organigrama_url');
        });
    }
}
