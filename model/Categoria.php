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

    public function toArray()
    {
        $data = [
            "idCategoria" => $this->idCategoria,
            "nombre" => $this->nombre,
            "emailDepartamento" => $this->emailDepartamento
        ];

        if (isset($this->idCategoria)) {
            $data["idCategoria"] = $this->idCategoria;
        }

        return $data;
    }

    public function insert()
    {
        return connection()->query("INSERT INTO Categoria (nombre, emailDepartamento) VALUES(:nombre, :emailDepartamento)", $this->toArray());
    }

    public function delete($id)
    {
        preparedStatement("DELETE FROM Categoria WHERE idCategoria = :idCategoria", ["idCategoria" => $id]);
    }

    public function edit($id)
    {
        $data = $this->toArray();
        $data['idCategoria'] = $id;

        preparedStatement("UPDATE Categoria
            SET nombre = :nombre,
                emailDepartamento = :emailDepartamento
            WHERE idCategoria = :idCategoria", $data);
    }

    public function findById($id)
    {
        $data = ["idCategoria" => $id];
        return connection()->query("SELECT * FROM Categoria WHERE idCategoria = :idCategoria", $data)->fetchAll();
    }

    public static function getAll()
    {
        return connection()->query("SELECT * FROM Categoria")->fetchAll();
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