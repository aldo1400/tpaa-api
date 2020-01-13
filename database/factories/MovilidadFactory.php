<?php

use Faker\Generator as Faker;

$factory->define(App\Movilidad::class, function (Faker $faker) {
    return [
        'fecha_inicio'=>$faker->dateTime($max = 'now', $timezone = null),
        'fecha_termino'=>$faker->dateTime($max = 'now', $timezone = null),
    ];
});
