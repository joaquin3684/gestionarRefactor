<?php

namespace App\Domain;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 20:15
 */
use App\Traits\Conversion;

class Climed
{
    use Conversion;

    private $id;
    private $nombre;
    private $domicilio;
    private $localidad;
    private $zona;
    private $particular;
    private $latitud;
    private $longitud;
    private $telefono;
    private $especialidades;
    private $obrasSociales;

    /**
     * Climed constructor.
     * @param $id
     * @param $nombre
     * @param $domicilio
     * @param $localidad
     * @param $zona
     * @param $particular
     * @param $latitud
     * @param $longitud
     * @param $telefono
     */
    public function __construct($id, $nombre, $domicilio, $localidad, $zona, $particular, $latitud, $longitud, $telefono)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->domicilio = $domicilio;
        $this->localidad = $localidad;
        $this->zona = $zona;
        $this->particular = $particular;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getEspecialidades()
    {
        return $this->especialidades;
    }

    /**
     * @param mixed $especialidades
     */
    public function setEspecialidades($especialidades)
    {
        $this->especialidades = $especialidades;
    }

    /**
     * @return mixed
     */
    public function getObrasSociales()
    {
        return $this->obrasSociales;
    }

    /**
     * @param mixed $obrasSociales
     */
    public function setObrasSociales($obrasSociales)
    {
        $this->obrasSociales = $obrasSociales;
    }

    /**
     * @return mixed
     */
    public function getEspecilidades()
    {
        return $this->especilidades;
    }

    /**
     * @param mixed $especilidad
     */
    public function setEspecilidades($especilidades)
    {
        $this->especilidades = $especilidades;
    }

    /**
     * @return array
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @param mixed $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * @return mixed
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @param mixed $localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * @return mixed
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * @param mixed $zona
     */
    public function setZona($zona)
    {
        $this->zona = $zona;
    }

    /**
     * @return mixed
     */
    public function getParticular()
    {
        return $this->particular;
    }

    /**
     * @param mixed $particular
     */
    public function setParticular($particular)
    {
        $this->particular = $particular;
    }

    /**
     * @return mixed
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param mixed $latitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    }

    /**
     * @return mixed
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param mixed $longitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

}
