<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 18:12
 */
$factory->define(App\Ruta::class, function (Faker\Generator $faker) {

    return [
        'ruta' => $faker->name,
    ];
});