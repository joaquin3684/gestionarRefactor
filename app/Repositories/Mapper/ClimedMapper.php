<?php

namespace App\Repositories\Mapper;

use App\Climed;

class ClimedMapper
{

    private $especialidadesMapper;
    public function __construct()
    {
        $this->especialidadesMapper = new EspecialidadMapper();
    }

    public function map($objeto)
    {
        if(is_a($objeto, 'Illuminate\Support\Collection'))
        {
            $clinicas = $objeto->map(function($objeto){
                $clinica =  new \App\Domain\Climed($objeto->IDCLI, $objeto->NOMBRE, $objeto->DIRECCION, $objeto->LOCALIDAD, $objeto->ZONA, $objeto->PARTICULAR, $objeto->latitude, $objeto->longitude, $objeto->TELEFONO);
                if($objeto->relationLoaded('especialidades'))
                {
                    $especialidades = $objeto->especialidades->map(function($especialidad){
                        return $this->especialidadesMapper->map($especialidad);
                    });
                    $clinica->setEspecilidades($especialidades);
                    return $clinica;
                }
            });

            return $clinicas;
        }
        else
        {
            $clinica =  new \App\Domain\Climed($objeto->IDCLI, $objeto->NOMBRE, $objeto->DIRECCION, $objeto->LOCALIDAD, $objeto->ZONA, $objeto->PARTICULAR, $objeto->latitude, $objeto->longitude, $objeto->TELEFONO);
            if($objeto->relationLoaded('especialidades'))
            {
                $especialidades = $objeto->especialidades->map(function($especialidad){
                    return $this->especialidadesMapper->map($especialidad);
                });
                $clinica->setEspecilidades($especialidades);
            }
            return $clinica;
        }




    }
}