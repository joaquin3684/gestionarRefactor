<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 19:43
 */
$factory->define(App\Especialidad::class, function (Faker\Generator $faker) {

    return [
        'NOMBRE' => $faker->name,
        'ESTUDIO' => 0,
        'DIRECTO' => 0
    ];
});