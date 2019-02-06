<?php
require_once __DIR__ . "/../core/database.php";

class Categoria
{
    private $idCategoria,$nombre, $emailDepartamento, $preferencia;

    /**
     * Categoria constructor.
     * @param $idCategoria
     * @param $nombre
     * @param $emailDepartamento
     * @param $preferencia
     */
    public function __construct($idCategoria, $nombre, $emailDepartamento, $preferencia)
    {
        $this->idCategoria = $idCategoria;
        $this->nombre = $nombre;
        $this->emailDepartamento = $emailDepartamento;
        $this->preferencia = $preferencia;
    }

    public function toArray()
    {
        $data = [
            "nombre" => $this->nombre,
            "emailDepartamento" => $this->emailDepartamento,
            "preferencia" => $this->preferencia
        ];

        return $data;
    }

    public function insert()
    {
        preparedStatement("INSERT INTO categoria (nombre, emailDepartamento, preferencia) VALUES(:nombre, :emailDepartamento, :preferencia)", $this->toArray());
    }

    public static function delete($id)
    {
        preparedStatement("DELETE FROM categoria WHERE idCategoria = :idCategoria", ["idCategoria" => $id]);
    }

    public function edit($id)
    {
        $data = $this->toArray();
        $data['idCategoria'] = $id;

        preparedStatement("UPDATE categoria
            SET nombre = :nombre,
                emailDepartamento = :emailDepartamento,
                preferencia = :preferencia
            WHERE idCategoria = :idCategoria", $data);
    }

    public static function findById($id)
    {
        $data = ["idCategoria" => $id];
        return connection()->query("SELECT * FROM categoria WHERE idCategoria = :idCategoria", $data)->fetchAll();
    }

    public static function getAll()
    {
        return connection()->query("SELECT * FROM categoria ORDER BY preferencia")->fetchAll();
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

    /**
     * @return mixed
     */
    public function getPreferencia()
    {
        return $this->preferencia;
    }

    /**
     * @param mixed $preferencia
     */
    public function setPreferencia($preferencia)
    {
        $this->preferencia = $preferencia;
    }
    
}