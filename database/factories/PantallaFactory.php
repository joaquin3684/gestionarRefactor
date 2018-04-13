<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 18:12
 */
$factory->define(App\Pantalla::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'nombre' => $faker->name,
    ];
});