<?php

require_once __DIR__ . "/../core/database.php";

class Admin
{
    private $idAdministrador, $usuario, $contrasenna;

    /**
     * administrador constructor.
     * @param $idAdministrador
     * @param $usuario
     * @param $contrasenna
     */
    public function __construct($idAdministrador, $usuario, $contrasenna)
    {
        $this->idAdministrador = $idAdministrador;
        $this->usuario = $usuario;
        $this->contrasenna = $contrasenna;
    }

    public function validar($usuario, $contrasenna) {
        return preparedStatement("SELECT idAdministrador FROM Administrador WHERE usuario = :usuario AND contrasenna = :contrasenna", 
            ["usuario" => $usuario, "contrasenna" => $contrasenna])->fetch(0);
    }

    /**
     * @return mixed
     */
    public function getIdAdministrador()
    {
        return $this->idAdministrador;
    }

    /**
     * @param mixed $idAdministrador
     */
    public function setIdAdministrador($idAdministrador): void
    {
        $this->idAdministrador = $idAdministrador;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getContrasenna()
    {
        return $this->contrasenna;
    }

    /**
     * @param mixed $contrasenna
     */
    public function setContrasenna($contrasenna): void
    {
        $this->contrasenna = $contrasenna;
    }

}