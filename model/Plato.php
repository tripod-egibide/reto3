<?php
require_once __DIR__ . "/../core/database.php";

class Plato
{

    private $conexion, $bbdd;
    private $idPlato, $nombre, $precio, $unidadesMinimas, $notas, $imagen, $idCategoria, $idTipoVenta;

    /**
     * Plato constructor.
     * @param $idPlato
     * @param $nombre
     * @param $precio
     * @param $unidadesMinimas
     * @param $notas
     * @param $imagen
     * @param $idCategoria
     * @param $idTipoVenta
     */
    public function __construct($idPlato, $nombre, $precio, $unidadesMinimas, $notas, $imagen, $idCategoria, $idTipoVenta)
    {
        $this->idPlato = $idPlato;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->unidadesMinimas = $unidadesMinimas;
        $this->notas = $notas;
        $this->imagen = $imagen;
        $this->idCategoria = $idCategoria;
        $this->idTipoVenta = $idTipoVenta;
    }

    public function toArray()
    {
        $data = [
            "nombre" => $this->nombre,
            "precio" => $this->precio,
            "unidadesMinimas" => $this->unidadesMinimas,
            "notas" => $this->notas,
            "imagen" => $this->imagen,
            "idCategoria" => $this->idCategoria,
            "idTipoVenta" => $this->idTipoVenta
        ];

        if (isset($this->idPlato)) {
            $data["idPlato"] = $this->idPlato;
        }

        return $data;
    }

    public function insert()
    {
        preparedStatement("INSERT INTO Plato (nombre, precio, unidadesMinimas, notas, imagen, idCategoria, idTipoventa) 
            VALUES (:nombre, :precio, :unidadesMinimas, :notas, :imagen, :idCategoria, :idTipoventa)", $this->toArray());
    }

    public static function delete($id)
    {
        preparedStatement("DELETE FROM Plato WHERE idPlato = :idPlato", ["idPlato" => $id]);
    }

    public function update($id)
    {
        $data = $this->toArray();
        $data['idPlato'] = $id;

        preparedStatement("UPDATE Plato
            SET nombre = :nombre,
                precio = precio,
                unidadesMinimas = unidadesMinimas,
                notas = :notas,
                imagen = :imagen,
                idCategoria = :idCategoria,
                idTipoVenta = :idTipoVenta
            WHERE idPlato = :idPlato", $data);
    }

    public static function getAll()
    {
        // esta función, como las otras get, seguramente tendrán que ser modificadas luego para paginar
        // si no, podríamos estar cargando cientos de platos a la vez
        // (aunque realísticamente el restaurante querría tener todos sus platos visibles, y no tendrían tantos en primer lugar)
        return connection()->query("SELECT * FROM Plato")->fetchAll();
    }

    public static function getByString($string)
    {
        return preparedStatement("SELECT * FROM Plato WHERE nombre like :string or notas like :string", ["string" => $string])->fetchAll();
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
    public function setConexion($conexion) : void
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
    public function setBbdd($bbdd) : void
    {
        $this->bbdd = $bbdd;
    }

    /**
     * @return mixed
     */
    public function getIdPlato()
    {
        return $this->idPlato;
    }

    /**
     * @param mixed $idPlato
     */
    public function setIdPlato($idPlato) : void
    {
        $this->idPlato = $idPlato;
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
    public function setNombre($nombre) : void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio) : void
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getUnidadesMinimas()
    {
        return $this->unidadesMinimas;
    }

    /**
     * @param mixed $unidadesMinimas
     */
    public function setUnidadesMinimas($unidadesMinimas) : void
    {
        $this->unidadesMinimas = $unidadesMinimas;
    }

    /**
     * @return mixed
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * @param mixed $notas
     */
    public function setNotas($notas) : void
    {
        $this->notas = $notas;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen) : void
    {
        $this->imagen = $imagen;
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
    public function setIdCategoria($idCategoria) : void
    {
        $this->idCategoria = $idCategoria;
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
    public function setIdTipoVenta($idTipoVenta) : void
    {
        $this->idTipoVenta = $idTipoVenta;
    }


}