<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 14/03/18
 * Time: 17:24
 */

namespace App\Repositories;


use App\Perfil;

class PerfilRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Perfil();
    }

    function model()
    {
        return 'App\Repositories\PerfilRepo';
    }


}