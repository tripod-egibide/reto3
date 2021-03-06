<?php
require_once __DIR__ . "/../core/database.php";

class Plato
{
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
     * @param $estado
     */
    public function __construct($idPlato, $nombre, $precio, $unidadesMinimas, $notas, $imagen, $idCategoria, $idTipoVenta, $estado)
    {
        $this->idPlato = $idPlato;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->unidadesMinimas = $unidadesMinimas;
        $this->notas = $notas;
        $this->imagen = $imagen;
        $this->idCategoria = $idCategoria;
        $this->idTipoVenta = $idTipoVenta;
        $this->estado = $estado;
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
            "idTipoVenta" => $this->idTipoVenta,
            "estado" => $this->estado
        ];

        if (isset($this->idPlato)) {
            $data["idPlato"] = $this->idPlato;
        }

        return $data;
    }

    public function insert()
    {
        $dato = $this->toArray();
        unset($dato["idPlato"]);
        var_dump($dato);
        preparedStatement("INSERT INTO plato (nombre, precio, unidadesMinimas, notas, imagen, idCategoria, idTipoventa, estado) 
            VALUES (:nombre, :precio, :unidadesMinimas, :notas, :imagen, :idCategoria, :idTipoVenta, :estado)", $dato);
    }

    public static function hidden($id)
    {
        preparedStatement("UPDATE plato SET estado = NOT estado WHERE idPlato = :idPlato;", ["idPlato" => $id]);
    }

    public function update()
    {
        $data = $this->toArray();
        if($data["imagen"]==null){
            unset($data["imagen"]);
            preparedStatement("UPDATE plato
            SET nombre = :nombre,
                precio = :precio,
                unidadesMinimas = :unidadesMinimas,
                notas = :notas,
                idCategoria = :idCategoria,
                idTipoVenta = :idTipoVenta,
                estado = :estado
            WHERE idPlato = :idPlato", $data);
        }else{
            preparedStatement("UPDATE plato
            SET nombre = :nombre,
                precio = :precio,
                unidadesMinimas = :unidadesMinimas,
                notas = :notas,
                imagen = :imagen,
                idCategoria = :idCategoria,
                idTipoVenta = :idTipoVenta,
                estado = :estado
            WHERE idPlato = :idPlato", $data);
        }

    }

    public static function delete($idPlato)
    {
        preparedStatement("DELETE FROM plato WHERE idPlato = :idPlato ", ["idPlato" => $idPlato]);
    }

    public static function getAll()
    {
        // esta función, como las otras get, seguramente tendrán que ser modificadas luego para paginar
        // si no, podríamos estar cargando cientos de platos a la vez
        // (aunque realísticamente el restaurante querría tener todos sus platos visibles, y no tendrían tantos en primer lugar)
        return connection()->query("SELECT * FROM plato as p " . ((isset($_SESSION["administrador"]) ? " WHERE estado = 1" : "")))->fetchAll();
    }

    public static function getAllById($idPlato)
    {
        return preparedStatement("SELECT * FROM plato WHERE idPlato = :idPlato", ["idPlato" => $idPlato])->fetch();
    }

    public static function getAllByListIdPlato($idPedido, $idCategoria)
    {
        return preparedStatement("SELECT * FROM plato INNER JOIN detallepedido on detallepedido.idPlato = plato.idPlato 
               WHERE detallepedido.idPedido = :idPedido && plato.idCategoria = :idCategoria", ["idPedido" => $idPedido, "idCategoria" => $idCategoria])->fetchAll();
    }

    public static function getByNombre($nombre)
    {
        return preparedStatement("SELECT * FROM plato WHERE nombre = :nombre", ["nombre" => $nombre])->fetchAll();
    }

    public static function getByString($string)
    {
        return preparedStatement("SELECT * FROM plato WHERE nombre like :string or notas like :string", ["string" => $string])->fetchAll();
    }

    public static function getByCategoria($idCategoria)
    {
        return preparedStatement("SELECT *, (SELECT tipoVenta from tipoventa where idTipoVenta = p.idTipoVenta) as 'tipoVenta' 
            FROM plato as p WHERE idCategoria = :idCategoria " . (isset($_SESSION["administrador"]) ? "" : " and estado = 1 ") , ["idCategoria" => $idCategoria])->fetchAll();
    }

    public static function findQty($idPlato)
    {
        return preparedStatement("SELECT sum(idPedido) as pedidos
            FROM detallepedido WHERE idPlato = :idPlato", ["idPlato" => $idPlato])->fetchAll();
    }

    public static function getById($idPlato)
    {
        return preparedStatement("SELECT *, 
            (SELECT tipoVenta from tipoventa where idTipoVenta = p.idTipoVenta) as 'tipoVenta', 
            (SELECT nombre from categoria where idCategoria = p.idCategoria) as 'categoria' 
            FROM plato as p WHERE idPlato = :idPlato", ["idPlato" => $idPlato])->fetchAll();
    }

    public static function getByIdCategoria($idCategoria)
    {
        return preparedStatement("SELECT idPlato
            FROM plato WHERE idCategoria = :idCategoria", ["idCategoria" => $idCategoria])->fetchAll();
    }

    public static function getByIdTipoVenta($idTipoVenta)
    {
        return preparedStatement("SELECT idPlato
            FROM plato WHERE idTipoVenta = :idTipoVenta", ["idTipoVenta" => $idTipoVenta])->fetchAll();
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