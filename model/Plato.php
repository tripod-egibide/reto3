<?php

class Plato{

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
    public function setConexion($conexion): void
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
    public function setBbdd($bbdd): void
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
    public function setIdPlato($idPlato): void
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
    public function setNombre($nombre): void
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
    public function setPrecio($precio): void
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
    public function setUnidadesMinimas($unidadesMinimas): void
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
    public function setNotas($notas): void
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
    public function setImagen($imagen): void
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
    public function setIdCategoria($idCategoria): void
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
    public function setIdTipoVenta($idTipoVenta): void
    {
        $this->idTipoVenta = $idTipoVenta;
    }


}