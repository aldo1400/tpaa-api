<?php

use App\Colaborador;
use App\Notificacion;
use Faker\Generator as Faker;

$factory->define(App\Notificacion::class, function (Faker $faker) {
    return [
        'colaborador_id' => function () {
            return factory(Colaborador::class)->create()->id;
        },
        'tipo' => $faker->randomElement([
            Notificacion::LICENCIA_B,
            Notificacion::LICENCIA_D,
            Notificacion::CARNET,
            Notificacion::CREDENCIAL,
        ]),
        'mensaje' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
