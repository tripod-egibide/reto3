<?php

require_once __DIR__ . "/../core/database.php";

class Admin
{
    private $idAdministrador, $usuario, $contrasenna, $email;

    /**
     * administrador constructor.
     * @param $idAdministrador
     * @param $usuario
     * @param $contrasenna
     * @param $email
     */
    public function __construct($idAdministrador, $usuario, $contrasenna, $email)
    {
        $this->idAdministrador = $idAdministrador;
        $this->usuario = $usuario;
        $this->contrasenna = $contrasenna;
        $this->email = $email;
    }

    public function toArray()
    {
        $data = [
            "usuario" => $this->usuario,
            "contrasenna" => $this->contrasenna,
            "email" => $this->email
        ];

        return $data;
    }

    public static function validar($usuario, $contrasenna) {
        return preparedStatement("SELECT idAdministrador FROM Administrador WHERE usuario = :usuario AND contrasenna = :contrasenna", 
            ["usuario" => $usuario, "contrasenna" => $contrasenna])->fetch(0);
    }

    public function insert()
    {
        preparedStatement("INSERT INTO Administrador (usuario, contrasenna, email) 
            VALUES (:usuario, :contrasenna, :email)", $this->toArray());
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
                contrasenna = :contrasenna,
                email = :email
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

}