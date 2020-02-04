<?php

use App\Colaborador;
use App\TipoComentario;
use Faker\Generator as Faker;

$factory->define(App\Comentario::class, function (Faker $faker) {
    return [
        'texto_libre' => $faker->company,
            'publico' => $faker->randomElement([
                0,
                1,
            ]),
            'fecha' => $faker->dateTime($max = 'now', $timezone = null),
            'estado' => $faker->randomElement([
                0,
                1,
            ]),
            'colaborador_id' => function () {
                return factory(Colaborador::class)->create()->id;
            },
            'colaborador_autor_id' => function () {
                return factory(Colaborador::class)->create()->id;
            },
            'tipo_comentario_id' => function () {
                return factory(TipoComentario::class)->create()->id;
            },
            'positivo' => $faker->randomElement([
                0,
                1,
            ]),
    ];
});
