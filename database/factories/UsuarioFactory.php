<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 18:12
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Illuminate\Support\Facades\Hash::make("1"),
        'id_perfil' => 1,
    ];
});