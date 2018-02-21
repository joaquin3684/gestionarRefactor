<?php

namespace App\Repositories\Mapper;

use App\Afiliado;

class AfiliadoMapper
{

    private $obraSocialMapper;
    public function __construct()
    {
        $this->obraSocialMapper = new ObraSocialMapper();
    }

    public function map($objeto)
    {
        $afiliado = new \App\Domain\Afiliado($objeto->ID, $objeto->NOMBRE, $objeto->DNI, $objeto->APELLIDO, $objeto->EMAIL, $objeto->CELULAR, $objeto->TELEFONO, $objeto->DIRECCION, $objeto->PISO, $objeto->DEPARTAMENTO, $objeto->NACIMIENTO, $objeto->CUIL, $objeto->OBS, $objeto->GRUPOF, $objeto->NAFILIADO);
        if($objeto->realationLoaded('obraSocial'))
        {
            $obraSocial = $this->obraSocialMapper->map($objeto->obraSocial);
            $afiliado->setObraSocial($obraSocial);
        }

        return $afiliado;
    }
}