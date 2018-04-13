<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 03/04/18
 * Time: 20:18
 */
$factory->define(App\Afiliado::class, function (Faker\Generator $faker) {

    return [
        'DNI' => 1,
        'NOMBRE' => 'required',
        'APELLIDO' => 'required',
        'EMAIL' => 'required',
        'TELEFONO' => 3,
        'CELULAR' => 3,
        'DIRECCION' => 'required',
        'NACIMIENTO' => '2017-02-03',
        'NAFILIADO' => 1,
        'CUIL' => 3,
        'IDOBRASOCIAL' => 1,
        'PLAN' => 'oro',
    ];
});