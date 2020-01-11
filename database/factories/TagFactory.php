<?php

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'descripcion' => $faker->company,
        'permisos' => $faker->word,
        'estado' => $faker->randomElement([
            0,
            1,
        ]),
        'tipo' => $faker->randomElement([
            Tag::NEGATIVO,
            Tag::POSITIVO,
        ]),
    ];
});

$factory->state(Tag::class, 'activo', function (Faker $faker) {
    return [
        'estado' => 1,
    ];
});

$factory->state(Tag::class, 'inactivo', function (Faker $faker) {
    return [
        'estado' => 0,
    ];
});
