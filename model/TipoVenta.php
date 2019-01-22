<?php

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