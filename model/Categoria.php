<?php
/**
 * Created by PhpStorm.
 * User: v6222
 * Date: 21/01/2019
 * Time: 8:40
 */

class Categoria
{
    private $conexion, $bbdd;
    private $idCategoria,$nombre, $emailDepartamento;

    /**
     * Categoria constructor.
     * @param $idCategoria
     * @param $nombre
     * @param $emailDepartamento
     */
    public function __construct($idCategoria, $nombre, $emailDepartamento)
    {
        $this->idCategoria = $idCategoria;
        $this->nombre = $nombre;
        $this->emailDepartamento = $emailDepartamento;
    }


    /**
     * @return mixed
     */
    public function getConexion()
    {
        return $this->conexion;
    }

    /**
     * @param mixed $conexion
     */
    public function setConexion($conexion): void
    {
        $this->conexion = $conexion;
    }

    /**
     * @return mixed
     */
    public function getBbdd()
    {
        return $this->bbdd;
    }

    /**
     * @param mixed $bbdd
     */
    public function setBbdd($bbdd): void
    {
        $this->bbdd = $bbdd;
    }

    /**
     * @return mixed
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * @param mixed $idCategoria
     */
    public function setIdCategoria($idCategoria): void
    {
        $this->idCategoria = $idCategoria;
    }

    /**
     * @return mixed
     */
    public function getEmailDepartamento()
    {
        return $this->emailDepartamento;
    }

    /**
     * @param mixed $emailDepartamento
     */
    public function setEmailDepartamento($emailDepartamento): void
    {
        $this->emailDepartamento = $emailDepartamento;
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
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }
    
}