<?php

use Faker\Generator as Faker;
use Freshwork\ChileanBundle\Rut;

$factory->define(App\Colaborador::class, function (Faker $faker) {
    $random_number = rand(1000000, 25000000);

    //We create a new RUT wihtout verification number (the second paramenter of Rut constructor)
    $rut = new Rut($random_number);

    //The fix method calculates the
    // echo $rut->fix()->format();
    return [
        'rut' => $rut->fix()->format(),
        'usuario' => $faker->userName,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'nombres' => $faker->name,
        'apellidos' => $faker->lastName,
        'sexo' => $faker->randomElement([
            'Femenino',
            'Masculino',
        ]),
        'nacionalidad' => $faker->country,
        'estado_civil' => $faker->randomElement([
                'Casado (a)',
                'Soltero (a)',
                'Divorciado (a)',
                'Unión Civil',
            ]),
        'fecha_nacimiento' => $faker->dateTime($max = 'now', $timezone = null),
        'edad' => $faker->numberBetween($min = 17, $max = 90),
        'email' => $faker->safeEmail,
        'nivel_educacion' => $faker->company,
        'domicilio' => $faker->address,
        'licencia_b' => $faker->randomElement([
                'SI', 'NO', 'N/A',
            ]),
        'vencimiento_licencia_b' => $faker->dateTime($max = 'now', $timezone = null),
        'licencia_d' => $faker->randomElement([
            'SI', 'NO', 'N/A',
        ]),
        'vencimiento_licencia_d' => $faker->dateTime($max = 'now', $timezone = null),
        'carnet_portuario' => $faker->randomElement([
            'SI', 'NO', 'N/A',
        ]),
        'vencimiento_carnet_portuario' => $faker->dateTime($max = 'now', $timezone = null),
        'talla_calzado' => $faker->company,
        'talla_chaleco' => $faker->company,
        'talla_polera' => $faker->company,
        'talla_pantalon' => $faker->company,
        'fecha_ingreso' => $faker->dateTime($max = 'now', $timezone = null),
        'telefono' => $faker->tollFreePhoneNumber,
        'celular' => $faker->tollFreePhoneNumber,
        'anexo' => $faker->company,
        'contacto_emergencia_nombre' => $faker->name,
        'contacto_emergencia_telefono' => $faker->tollFreePhoneNumber,
        'estado' => $faker->randomElement([
            'Activo (a)',
            'Desvinculado (a)',
            'Renuncia',
        ]),
        'fecha_inactividad' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
