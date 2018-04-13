<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 18:13
 */
$factory->define(App\ObraSocial::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'NOMBRE' => $faker->name,
    ];
});