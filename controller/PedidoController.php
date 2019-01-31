<?php
class PedidoController
{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Pedido.php";
        require_once __DIR__ . "/../model/Plato.php";
        require_once __DIR__ . "/../core/twig.php";
        switch ($action) {
            case 'ver':
                $this->ver();
                break;

            case 'getDetallePedido':
                $this->getDetallePedido();
                break;

            case 'detalles':
                $this->detalles();
                break;

            default:
                $this->realizar();
                break;
        }
    }

    private function ver()
    {
        $pedidos = Pedido::getAll();

        echo twig()->render("pedidoView.twig", ["pedidos" => $pedidos]);
    }

    private function getDetallePedido()
    {
        $platos=Pedido::getAllDetallePedidoByIdPedido($_GET["idPedido"]);
        $data=Array();
        foreach ($platos as $plato) {
            $platosSeleccionado=Plato::getAllById($plato["idPlato"]);
            $data[] = [
                "nombre" => $platosSeleccionado["nombre"],
                "precio" => $platosSeleccionado["precio"],
                "cantidad" => $plato["cantidad"]
            ];
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }

    private function detalles()
    {
        // temp
    }

    private function realizar()
    {
        // temp
    }

    private function login()
    {
        // temp
    }

}