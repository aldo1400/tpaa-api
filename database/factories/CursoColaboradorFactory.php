<?php

use App\Curso;
use App\Colaborador;
use App\CursoColaborador;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(CursoColaborador::class, function (Faker $faker) {
    return [
        'diploma' => UploadedFile::fake()->image('curso123.jpg', 1200, 750),
        'url_diploma'=>'aldo',
        'colaborador_id' => function () {
            return factory(Colaborador::class)->create()->id;
        },
        'curso_id' => function () {
            return factory(Curso::class)->create()->id;
        },
    ];
});
