<?php
require_once __DIR__ . "/../core/database.php";

class Categoria
{
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