<?php
require_once __DIR__ . "/../core/database.php";

class TipoVenta
{
    private $idTipoVenta, $tipoVenta;

    /**
     * TipoVenta constructor.
     * @param $idTipoVenta
     * @param $tipoVenta
     */
    public function __construct($idTipoVenta, $tipoVenta)
    {
        $this->idTipoVenta = $idTipoVenta;
        $this->tipoVenta = $tipoVenta;
    }

    public function toArray()
    {
        $data = [
            "tipoVenta" => $this->tipoVenta
        ];

        return $data;
    }

    public function insert()
    {
        preparedStatement("INSERT INTO TipoVenta (tipoVenta) 
            VALUES (:tipoVenta)", $this->toArray());
    }

    public static function delete($id)
    {
        preparedStatement("DELETE FROM TipoVenta WHERE idTipoVenta = :idTipoVenta", ["idTipoVenta" => $id]);
    }

    public function update($id)
    {
        $data = $this->toArray();
        $data['idTipoVenta'] = $id;
        preparedStatement("UPDATE TipoVenta SET tipoVenta = :tipoVenta WHERE idTipoVenta = :idTipoVenta", $data);
    }

    public static function findById($id)
    {
        $data = ["idTipoVenta" => $id];
        return connection()->query("SELECT * FROM TipoVenta WHERE idTipoVenta = :idTipoVenta", $data)->fetchAll();
    }

    public static function getAll()
    {
        return connection()->query("SELECT * FROM TipoVenta ")->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getIdTipoVenta()
    {
        return $this->idTipoVenta;
    }

    /**
     * @param mixed $idTipoVenta
     */
    public function setIdTipoVenta($idTipoVenta): void
    {
        $this->idTipoVenta = $idTipoVenta;
    }

    /**
     * @return mixed
     */
    public function getTipoVenta()
    {
        return $this->tipoVenta;
    }

    /**
     * @param mixed $tipoVenta
     */
    public function setTipoVenta($tipoVenta): void
    {
        $this->tipoVenta = $tipoVenta;
    }


}