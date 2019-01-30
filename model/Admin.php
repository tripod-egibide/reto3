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

    public function toArray()
    {
        $data = [
            "usuario" => $this->usuario,
            "contrasenna" => $this->contrasenna
        ];

        return $data;
    }

    public static function validar($usuario, $contrasenna) {
        return preparedStatement("SELECT idAdministrador FROM Administrador WHERE usuario = :usuario AND contrasenna = :contrasenna", 
            ["usuario" => $usuario, "contrasenna" => $contrasenna])->fetch(0);
    }

    public function insert()
    {
        preparedStatement("INSERT INTO Administrador (usuario, contrasenna) 
            VALUES (:usuario, :contrasenna)", $this->toArray());
    }

    public static function delete($id)
    {
        preparedStatement("DELETE FROM Administrador WHERE idAdministrador = :idAdministrador", ["idAdministrador" => $id]);
    }

    public function update($id)
    {
        $data = $this->toArray();
        $data['idAdministrador'] = $id;

        preparedStatement("UPDATE Administrador
            SET usuario = :usuario,
                contrasenna = :contrasenna
            WHERE idAdministrador = :idAdministrador", $data);
    }

    public static function getAll()
    {
        return connection()->query("SELECT * FROM Administrador")->fetchAll();
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