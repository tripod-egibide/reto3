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

            case 'insert':
                $this->insert();
                break;

            default:
                $this->index();
                break;
        }
    }

    private function index()
    {
        echo twig()->render("indexView.twig", ["platos" => Plato::getAll()]);
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