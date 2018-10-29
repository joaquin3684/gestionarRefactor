<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 22:46
 */

namespace App\Domain;


use App\Traits\Conversion;

class Afiliado
{
    use Conversion;

    private $id;
    private $nombre;
    private $dni;
    private $apellido;
    private $email;
    private $celular;
    private $telefono;
    private $direccion;
    private $piso;
    private $departamento;
    private $nacimiento;
    private $cuil;
    private $obs;
    private $grupof;
    private $nafiliado;
    private $plan;
    private $obra_social;
    private $familiares;
    private $idnotif;

    /**
     * Afiliado constructor.
     * @param $id
     * @param $nombre
     * @param $dni
     * @param $apellido
     * @param $email
     * @param $celular
     * @param $telefono
     * @param $direccion
     * @param $piso
     * @param $departamento
     * @param $nacimiento
     * @param $cuil
     * @param $obs
     * @param $grupof
     * @param $nafiliado
     */
    public function __construct($id, $nombre, $dni, $apellido, $email, $celular, $telefono, $direccion, $piso, $departamento, $nacimiento, $cuil, $obs, $grupof, $nafiliado, $plan, $localidad, $cp, $idnotif)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->celular = $celular;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->piso = $piso;
        $this->departamento = $departamento;
        $this->nacimiento = $nacimiento;
        $this->cuil = $cuil;
        $this->obs = $obs;
        $this->grupof = $grupof;
        $this->nafiliado = $nafiliado;
        $this->plan = $plan;
        $this->cp = $cp;
        $this->localidad = $localidad;
        $this->idnotif = $idnotif;
    }




    /**
     * @return mixed
     */
    public function getObraSocial()
    {
        return $this->obra_social;
    }

    /**
     * @param mixed $obra_social
     */
    public function setObraSocial($obra_social)
    {
        $this->obra_social = $obra_social;
    }

    /**
     * @return mixed
     */
    public function getFamiliares()
    {
        return $this->familiares;
    }

    /**
     * @param mixed $familiares
     */
    public function setFamiliares($familiares)
    {
        $this->familiares = $familiares;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
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
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * @param mixed $piso
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;
    }

    /**
     * @return mixed
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
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
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param mixed $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    /**
     * @return mixed
     */
    public function getGrupof()
    {
        return $this->grupof;
    }

    /**
     * @param mixed $grupof
     */
    public function setGrupof($grupof)
    {
        $this->grupof = $grupof;
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




}