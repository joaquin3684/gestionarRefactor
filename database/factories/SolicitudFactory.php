<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 22:58
 */
$factory->define(App\Solicitud::class, function (Faker\Generator $faker) {

    return [
        'FECHAS' => '2017-02-03',
        'DNISOLICITANTE' => 1,
        'IDAFILIADO' => 1,
        'IDCLIMED' => 1,
        'ESPECIALIDAD' => 1,
        'MEDICO' => 23,
        'ESTADO' => 'Pendiente',
        'TIPO' => 1,
    ];
});