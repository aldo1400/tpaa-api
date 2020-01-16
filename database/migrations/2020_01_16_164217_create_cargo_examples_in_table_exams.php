<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargoExamplesInTableExams extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('areas')->insert([
            [
            //     'id'=>1,
            //     'nombre'=>'Area 1',
            //     'padre_id' => null,
            //     'tipo_area_id'=>1,
            //     'estado' => 1,
            //     // 'created_at' => date('Y-m-d H:i:s'),
            //     // 'updated_at' => date('Y-m-d H:i:s'),
            // ],
            // [
            //     'nombre'=>'Area 2',
            //     'padre_id' => 1,
            //     'tipo_area_id'=>2,
            //     'estado' => 1,
            //     // 'created_at' => date('Y-m-d H:i:s'),
            //     // 'updated_at' => date('Y-m-d H:i:s'),
            // ],
            [
                'nombre'=>'Area 3',
                'padre_id' => 1,
                'tipo_area_id'=>3,
                'estado' => 1,
                // 'created_at' => date('Y-m-d H:i:s'),
                // 'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cargos', function (Blueprint $table) {
        });
    }
}
