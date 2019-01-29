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

            case 'catalogo':
                $this->catalogo();
                break;
            
            case 'findById':
                $this->findById();
                break;

            case 'delete':
                $this->delete();
                break;

            default:
                $this->index();
                break;
        }
    }

    private function index()
    {
        // estos datos solo se usan para el nav de categorias
        // en práctica tal vez sería mejor cargar eso por el cliente también, pero debemos usar twig en el servidor en alguna parte
        require_once __DIR__ . "/../model/Categoria.php";;
        $categorias = Categoria::getAll();

        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"], 
            ];            
        }
        echo twig()->render("indexView.twig", ["categorias" => $data]);
    }

    private function edit()
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

    private function findById()
    {
        echo json_encode(Plato::getById($_POST["idPlato"]));
    }

    private function delete(){
        Plato::delete($_POST["idPlato"]);
    }

}