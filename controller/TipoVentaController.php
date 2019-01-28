<?php
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
        // temp
    }

    private function remove()
    {
        // temp
    }

    private function edit()
    {
        // temp
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