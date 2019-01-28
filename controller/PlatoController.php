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

            case 'editar':
                $this->editar();
                break;

            case 'insert':
                $this->insert();
                break;

            case 'catalogo':
                $this->catalogo();
                break;

            default:
                $this->index();
                break;
        }
    }

    private function index()
    {
        echo twig()->render("indexView.twig");
    }

    private function editar()
    {
        echo json_encode(Plato::getById($_POST["idPlato"]));
    }

    private function catalogo() 
    {
        require_once __DIR__ . "/../model/Categoria.php";
        $categorias = Categoria::getAll();

        $data = ["administrador" => $_SESSION["administrador"] ?? 0];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"], 
                "platos" => Plato::getByCategoria($categoria["idCategoria"]),
            ];            
        }
        header('Content-type: application/json');
        echo json_encode($data);
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

}