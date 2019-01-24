<?php

if(session_id()==''){
    session_start();
}

class TipoVentaController{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/TipoVenta.php";
        require_once __DIR__ . "/../core/twig.php";
        switch ($action) {
            case 'add':
                $this->add();
                break;

            case 'remove':
                $this->remove();
                break;

            case 'edit':
                $this->edit();
                break;

            case 'view':
                $this->view();
                break;

            case 'findById':
                $this->findById();
                break;

            default:
                $this->getAll();
                break;
        }
    }

    private function add()
    {
        if(isset($_SESSION["administrador"]))
        {
            $tipoVenta = $_POST["tipoVenta"];

            $tipoVenta = new TipoVenta("", $tipoVenta);
            $tipoVenta->insert();
            header("Location: /reto3/index.php?c=tipoventa&a=view");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function remove()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idTipoVenta = $_GET["tipoVenta"];

            $tipoVenta = new TipoVenta("", "");
            $tipoVenta->delete($idTipoVenta);

            header("Location: /reto3/index.php?c=tipoventa&a=view");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function edit()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idTipoVenta=$_POST["idTipoVenta"];
            $tipoVenta = $_POST["tipoVenta"];

            $tipoVenta=new TipoVenta("", $tipoVenta);
            $tipoVenta->update($idTipoVenta);

            header("Location: /reto3/index.php?c=tipoventa&a=view");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function view()
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

    private function findById()
    {
        $tipoVentas = TipoVenta::getAll();
        $data = [];
        foreach ($tipoVentas as $tipoVenta) {
            $data[$tipoVenta["idTipoVenta"]] = [
                "tipoVenta" => $tipoVenta["tipoVenta"]
            ];
        }
        return $data;
    }

    private function getAll()
    {
        echo json_encode(TipoVenta::getAll());
    }
}