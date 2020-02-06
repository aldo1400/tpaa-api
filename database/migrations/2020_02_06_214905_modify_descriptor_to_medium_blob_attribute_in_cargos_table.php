<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDescriptorToMediumBlobAttributeInCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE cargos MODIFY descriptor MEDIUMBLOB NULL');       
        DB::statement('ALTER TABLE cargos MODIFY organigrama MEDIUMBLOB NULL');       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE cargos MODIFY descriptor VARCHAR(255) NULL');
        DB::statement('ALTER TABLE cargos MODIFY organigrama VARCHAR(255) NULL');
    }
}
