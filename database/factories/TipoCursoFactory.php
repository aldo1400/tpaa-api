<?php

use Faker\Generator as Faker;

$factory->define(App\TipoCurso::class, function (Faker $faker) {
    return [
        'categoria' => $faker->company,
    ];
});
