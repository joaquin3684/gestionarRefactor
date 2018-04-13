<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 21:33
 */
$factory->define(App\Climed::class, function (Faker\Generator $faker) {

    return [
        'NOMBRE' => 'required',
        'LOCALIDAD' => 'required',
        'ZONA' => 'required',
        'PARTICULAR' => 1,
        'DIRECCION' => 'required',
        'latitude' => 2,
        'longitude' => 2,
        'TELEFONO' => 2,
    ];
});