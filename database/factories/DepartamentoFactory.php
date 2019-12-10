<?php

use App\Departamento;
use Faker\Generator as Faker;

$factory->define(App\Departamento::class, function (Faker $faker) {
    return [
        'tipo' => $faker->randomElement([
            Departamento::GERENCIAGENERAL,
            Departamento::GERENCIA,
            Departamento::SUBGERENCIA,
            Departamento::AREA,
            Departamento::SUBAREA,
        ]),
        'nombre' => $faker->company,
    ];
});
