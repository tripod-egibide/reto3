<?php
class PlatoController
{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Plato.php";
        require_once __DIR__ . "/../core/twig.php";
        switch ($action) {
            case 'nuevo':
                $this->nuevo();
                break;

            case 'edit':
                $this->edit();
                break;

            case 'insert':
                $this->insert();
                break;

            case 'findById':
                $this->findById();
                break;

            default:
                $this->index();
                break;
        }
    }

    private function index()
    {
        require_once __DIR__ . "/../model/Categoria.php";;
        $categorias = Categoria::getAll();

        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"], 
                "platos" => Plato::getByCategoria($categoria["idCategoria"])
            ];            
        }
        echo twig()->render("indexView.twig", ["categorias" => $data]);
    }

    private function edit()
    {
        echo json_encode(Plato::getById($_POST["idPlato"]));
    }

    private function nuevo()
    {
        // temp
        // éste sería el que carga la página del formulario
    }

    private function insert()
    {
        //temp
        // éste sería el que hace el insert a la base de datos
    }

    private function findById()
    {
        echo json_encode(Plato::getById($_POST["idPlato"]));
    }

    private function findAllTipoVenta()
    {

    }

}