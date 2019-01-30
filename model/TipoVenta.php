<?php
require_once __DIR__ . "/../core/database.php";

class TipoVenta
{
    private $idTipoVenta, $tipoVenta;

    /**
     * tipoventa constructor.
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
        preparedStatement("INSERT INTO tipoventa (tipoVenta) 
            VALUES (:tipoVenta)", $this->toArray());
    }

    public static function delete($id)
    {
        preparedStatement("DELETE FROM tipoventa WHERE idTipoVenta = :idTipoVenta", ["idTipoVenta" => $id]);
    }

    public function update($id)
    {
        $data = $this->toArray();
        $data['idTipoVenta'] = $id;
        preparedStatement("UPDATE tipoventa SET tipoVenta = :tipoVenta WHERE idTipoVenta = :idTipoVenta", $data);
    }

    public static function findById($id)
    {
        $data = ["idTipoVenta" => $id];
        return connection()->query("SELECT * FROM tipoventa WHERE idTipoVenta = :idTipoVenta", $data)->fetchAll();
    }

    public static function getAll()
    {
        return connection()->query("SELECT * FROM tipoventa ")->fetchAll();
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