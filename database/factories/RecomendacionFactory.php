<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 16/04/18
 * Time: 17:37
 */
$factory->define(App\Recomendacion::class, function (Faker\Generator $faker) {

    return [
        'DNIAFILIADO' => 1,
        'NRO' => '65',
        'FECHA' => \Carbon\Carbon::today()->toDateString(),
        'NOMBRE' => 'required',
        'APELLIDO' => 'apellido',

    ];
});