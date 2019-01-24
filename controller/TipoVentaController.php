<?php

if(session_id()==''){
    session_start();
}

class TipoVentaController
{

    public function run($action = "")
    {
        require_once __DIR__ . "/../model/TipoVenta.php";
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
            case 'insertar':
                $this->insertar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'actualizar':
                $this->actualizar();
                break;
            default:
                $this->principal();
                break;
        }
    }

    private function principal()
    {
        if(isset($_SESSION["administrador"]))
        {
            $tipoVenta = new TipoVenta("", "");
            $tiposVenta = $tipoVenta->getAll();

            echo twig()->render('tipoVentaView.twig', array("tiposVenta" => $tiposVenta));
        }
        else
        {
            echo twig()->render("loginView.twig");
        }
    }

    private function insertar()
    {
        if(isset($_SESSION["administrador"]))
        {
            $tipoVenta = $_POST["tipoVenta"];

            $tipoVenta = new TipoVenta("", $tipoVenta);
            $tipoVenta->insert();
            header("Location: /reto3/index.php?c=tipoVenta");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function eliminar()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idTipoVenta = $_GET["tipoVenta"];

            $tipoVenta = new TipoVenta("", "");
            $tipoVenta->delete($idTipoVenta);

            header("Location: /reto3/index.php?c=tipoVenta");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function actualizar()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idTipoVenta=$_POST["idTipoVenta"];
            $tipoVenta = $_POST["tipoVenta"];

            $tipoVenta=new TipoVenta("", $tipoVenta);
            $tipoVenta->update($idTipoVenta);

            header("Location: /reto3/index.php?c=tipoVenta");
        }
        else
        {
            header("Location: /reto3/");
        }
    }
}