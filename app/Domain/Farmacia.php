<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 20/02/18
 * Time: 21:31
 */

namespace App\Domain;


use App\Traits\Conversion;

class Farmacia
{

    use Conversion;

    private $id;
    private $nombre;
    private $direccion;
    private $localidad;
    private $latitude;
    private $longitude;
    private $telefono;

    /**
     * Farmacia constructor.
     * @param $id
     * @param $nombre
     * @param $direccion
     * @param $localidad
     * @param $latitude
     * @param $longitude
     * @param $telefono
     */
    public function __construct($id, $nombre, $direccion, $localidad, $latitude, $longitude, $telefono)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->localidad = $localidad;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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