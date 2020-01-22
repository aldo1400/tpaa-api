<?php

use Faker\Generator as Faker;

$factory->define(App\Administrador::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'username' => $faker->unique()->safeEmail,
        'estado'=>$faker->randomElement([
                0,
                1
        ]),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        // 'remember_token' => str_random(10),
    ];
});
