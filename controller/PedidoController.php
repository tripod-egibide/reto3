<?php
class PedidoController
{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Pedido.php";
        require_once __DIR__ . "/../core/twig.php";
        switch ($action) {
            case 'detalles':
                $this->detalles();
                break;

            default:
                $this->realizar();
                break;
        }
    }

    private function detalles()
    {
        // temp
    }

    private function login()
    {
        // temp
    }

}