<?php

if(session_id()==''){
    session_start();
}

class CategoriaController{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Categoria.php";
        require_once __DIR__ . "/../model/Plato.php";
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

            case 'getAll':
                $this->getAll();
                break;

            default:
                $this->index();
                break;
        }
    }

    private function add()
    {
        if(isset($_SESSION["administrador"]))
        {
            $nombre = $_POST["nombre"];
            $emailDepartamento = $_POST["emailDepartamento"];
            $preferencia = $_POST["preferencia"];

            $categoria = new Categoria("", $nombre, $emailDepartamento, $preferencia);
            $categoria->insert();
        }
        header("Location: /reto3/");
    }

    private function remove()
    {
        if(isset($_SESSION["administrador"])) {
            $idCategoria = $_GET["categoria"];

            $platos = Plato::getByIdCategoria($idCategoria);

            if ($platos == NULL) {
                Categoria::delete($idCategoria);
            }
        }
        header("Location: /reto3/");
    }

    private function edit()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idCategoria=$_POST["idCategoria"];
            $nombre = $_POST["nombre"];
            $emailDepartamento = $_POST["emailDepartamento"];
            $preferencia = $_POST["preferencia"];

            $categoria=new Categoria("", $nombre, $emailDepartamento, $preferencia);
            $categoria->edit($idCategoria);
        }
        header("Location: /reto3/");
    }

    private function findById()
    {
        $categorias = Categoria::getAll();
        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"],
                "emailDepartamento" => $categoria["emailDepartamento"]
            ];
        }
        return $data;
    }

    private function getAll()
    {
        echo json_encode(Categoria::getAll());
    }

    private function index()
    {
        $categorias = Categoria::getAll();
        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"],
                "emailDepartamento" => $categoria["emailDepartamento"]
            ];
        }
        return $data;
    }
}