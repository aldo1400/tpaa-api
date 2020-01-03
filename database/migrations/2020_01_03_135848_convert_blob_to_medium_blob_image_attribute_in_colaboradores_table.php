<?php

use Illuminate\Database\Migrations\Migration;

class ConvertBlobToMediumBlobImageAttributeInColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('ALTER TABLE colaboradores MODIFY imagen MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('ALTER TABLE colaboradores MODIFY imagen BLOB NULL');
    }
}
