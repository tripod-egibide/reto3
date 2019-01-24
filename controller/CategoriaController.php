<?php
class CategoriaController{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Categoria.php";
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
                $this->index();
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
        $categorias = Categoria::getAll();
        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"],
                "emailDepartamento" => $categoria["emailDepartamento"],
                "orden" => $categoria["orden"]
            ];
        }
        return $data;
    }

    private function index()
    {
        $categorias = Categoria::getAll();
        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"],
                "emailDepartamento" => $categoria["emailDepartamento"],
                "orden" => $categoria["orden"]
            ];
        }
        return $data;
    }
}