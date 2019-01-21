<?php
require_once __DIR__ . "/../core/database.php";

class Categoria
{
    private $conexion, $bbdd;
    private $idCategoria, $emailDepartamento;

    /**
     * Categoria constructor.
     * @param $idCategoria
     * @param $emailDepartamento
     */
    public function __construct($idCategoria, $emailDepartamento)
    {
        $this->idCategoria = $idCategoria;
        $this->emailDepartamento = $emailDepartamento;
    }

    /**
     * Pedido constructor.
     * @param $conexion
     * @param $bbdd
     * @param $idCategoria
     * @param $emailDepartamento
     */


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
}