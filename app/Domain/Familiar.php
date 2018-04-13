<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 12/04/18
 * Time: 13:28
 */

namespace App\Domain;


use App\Traits\Conversion;

class Familiar
{
    use Conversion;

    private $nombre;
    private $apellido;
    private $nacimiento;
    private $cuil;
    private $nafiliado;
    private $dni;

    /**
     * Familiar constructor.
     * @param $nombre
     * @param $apellido
     * @param $nacimiento
     * @param $cuil
     * @param $nafiliado
     * @param $dni
     */
    public function __construct($nombre, $apellido, $nacimiento, $cuil, $nafiliado, $dni)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nacimiento = $nacimiento;
        $this->cuil = $cuil;
        $this->nafiliado = $nafiliado;
        $this->dni = $dni;
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
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return mixed
     */
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    /**
     * @param mixed $nacimiento
     */
    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;
    }

    /**
     * @return mixed
     */
    public function getCuil()
    {
        return $this->cuil;
    }

    /**
     * @param mixed $cuil
     */
    public function setCuil($cuil)
    {
        $this->cuil = $cuil;
    }

    /**
     * @return mixed
     */
    public function getNafiliado()
    {
        return $this->nafiliado;
    }

    /**
     * @param mixed $nafiliado
     */
    public function setNafiliado($nafiliado)
    {
        $this->nafiliado = $nafiliado;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }



}