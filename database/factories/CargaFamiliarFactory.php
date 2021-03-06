<?php

use App\TipoCarga;
use App\Colaborador;
use Faker\Generator as Faker;
use Freshwork\ChileanBundle\Rut;

$factory->define(App\CargaFamiliar::class, function (Faker $faker) {
    $random_number = rand(1000000, 25000000);

    $rut = new Rut($random_number);

    return [
        'rut' => $rut->fix()->format(),
        'nombres' => $faker->name,
        'apellidos' => $faker->lastName,
        'fecha_nacimiento' => $faker->dateTime($max = 'now', $timezone = null),
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
        'tipo_carga_id' => function () {
            return factory(TipoCarga::class)->create()->id;
        },
        'colaborador_id' => function () {
            return factory(Colaborador::class)->create()->id;
        },
    ];
});
