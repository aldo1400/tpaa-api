<?php

use App\EstadoCivil;
use App\NivelEducacion;
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
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'primer_nombre' => $faker->name,
        'segundo_nombre' => $faker->name,
        'apellido_paterno' => $faker->lastName,
        'apellido_materno' => $faker->lastName,
        'sexo' => $faker->randomElement([
            'Femenino',
            'Masculino',
        ]),
        'nacionalidad' => $faker->country,
        'fecha_nacimiento' => $faker->dateTime($max = 'now', $timezone = null),
        'edad' => $faker->numberBetween($min = 17, $max = 90),
        'email' => $faker->safeEmail,
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
            '1',
            '0',
        ]),
        'fecha_inactividad' => $faker->dateTime($max = 'now', $timezone = null),
        'credencial_vigilante' => $faker->randomElement([
            'SI', 'NO', 'N/A',
        ]),
        'vencimiento_credencial_vigilante' => $faker->dateTime($max = 'now', $timezone = null),
        'nivel_educacion_id' => function () {
            return factory(NivelEducacion::class)->create()->id;
        },
        'estado_civil_id' => function () {
            return factory(EstadoCivil::class)->create()->id;
        },
    ];
});
