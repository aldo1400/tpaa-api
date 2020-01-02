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
        'tipo' => $faker->company,
    ];
});
