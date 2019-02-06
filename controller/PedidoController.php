<?php

if(session_id()==''){
    session_start();
}



class PedidoController
{

    public function run($action = "")
    {
        include_once __DIR__ . "/../core/email/email.php";
        require_once __DIR__ . "/../model/Categoria.php";
        require_once __DIR__ . "/../model/Pedido.php";
        require_once __DIR__ . "/../model/Plato.php";
        require_once __DIR__ . "/../model/Admin.php";
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
            case 'ver':
                $this->ver();
                break;

            case 'getAll':
                $this->getAll();
                break;

            case 'getDetallePedido':
                $this->getDetallePedido();
                break;

            case 'eliminar':
                $this->eliminar();
                break;

            case 'pedidoConfirmado':
                pedidoConfirmado();
                break;

            case 'addPedido':
                $this->addPedido();
                break;

            case 'search':
                $this->search();
                break;
        }
    }

    private function ver()
    {
        if(isset($_SESSION["administrador"]))
        {
            $pedidos = Pedido::getAll();

            echo twig()->render("pedidoView.twig", ["pedidos" => $pedidos]);
        }

    }

    private function getAll()
    {
        if(isset($_SESSION["administrador"]))
        {
            $pedidos = Pedido::getAll();
            header('Content-type: application/json');
            echo json_encode($pedidos);
        }

    }

    private function getDetallePedido()
    {
        if(isset($_SESSION["administrador"]))
        {
            $platos=Pedido::getDetallePedidoByIdPedido($_GET["idPedido"]);
            $data=Array();
            foreach ($platos as $plato) {
                $platosSeleccionado=Plato::getAllById($plato["idPlato"]);
                $data[] = [
                    "nombre" => $platosSeleccionado["nombre"],
                    "precio" => $platosSeleccionado["precio"],
                    "cantidad" => $plato["cantidad"]
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    private function eliminar()
    {
        if(isset($_SESSION["administrador"]))
        {
            Pedido::delete($_GET["idPedido"]);
        }

    }

    private function addPedido(){
        $cliente = $_POST["cliente"];
        $pedido = new Pedido(null, $cliente["nombre"], $cliente["apellidos"], $cliente["email"], $cliente["telefono"], $cliente["fechaEntrega"], $cliente["total"], 0);
        $clave = $pedido->insert();
        if($clave !=null){
            if($pedido->insertDetallePedido($clave[0],$_POST["carrito"]) == "Ok"){
                $estado = "Ok";
                pedidoRecibido($clave[0]["idPedido"], $cliente);
            }else{
                $estado = "Error";
            }

        }else{
            $estado = "Error";
        }
        echo $estado;
    }

    private function search()
    {
        if(isset($_SESSION["administrador"]))
        {
            $pedidos = Array();
            switch ($_GET["tipo"]) {
                case "nombre":
                    $pedidos = Pedido::getByNombre($_GET["nombre"]);
                    break;
                case "apellido":
                    $pedidos = Pedido::getByApellidos($_GET["apellido"]);
                    break;
                case "email":
                    $pedidos = Pedido::getByEmail($_GET["email"]);
                    break;
                case "telefono":
                    $pedidos = Pedido::getByTelf($_GET["telefono"]);
                    break;
                case "fecha":
                    $pedidos = Pedido::getByDate($_GET["fecha1"], $_GET["fecha2"]);
                    break;
                case "estado":
                    $pedidos = Pedido::getByConfirmado($_GET["estado"]);
                    break;
            }
            header('Content-type: application/json');
            echo json_encode($pedidos);
        }

    }
}