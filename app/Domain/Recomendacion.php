<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 22:32
 */

namespace App\Domain;


use App\Traits\Conversion;

class Recomendacion
{
    use Conversion;

    private $id;
    private $nombre;
    private $apellido;
    private $nro;
    private $fecha;
    private $contactado;
    private $comentario;

    /**
     * Recomendacion constructor.
     * @param $id
     * @param $nombre
     * @param $apellido
     * @param $nro
     * @param $fecha
     * @param $contactado
     * @param $comentario
     */
    public function __construct($id, $nombre, $apellido, $nro, $fecha, $contactado, $comentario)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nro = $nro;
        $this->fecha = $fecha;
        $this->contactado = $contactado;
        $this->comentario = $comentario;
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
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * @param mixed $nro
     */
    public function setNro($nro)
    {
        $this->nro = $nro;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getContactado()
    {
        return $this->contactado;
    }

    /**
     * @param mixed $contactado
     */
    public function setContactado($contactado)
    {
        $this->contactado = $contactado;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }


}