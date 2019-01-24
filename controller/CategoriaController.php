<?php

if(session_id()==''){
    session_start();
}

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

            case 'view':
                $this->view();
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
        if(isset($_SESSION["administrador"]))
        {
            $nombre = $_POST["nombre"];
            $emailDepartamento = $_POST["emailDepartamento"];

            $categoria = new Categoria("", $nombre, $emailDepartamento);
            $categoria->insert();
            header("Location: /reto3/index.php?c=categoria&a=view");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function remove()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idCategoria = $_GET["categoria"];

            $categoria = new Categoria("", "", "");
            $categoria->delete($idCategoria);

            header("Location: /reto3/index.php?c=categoria&a=view");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function edit()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idCategoria=$_POST["idCategoria"];
            $nombre = $_POST["nombre"];
            $emailDepartamento = $_POST["emailDepartamento"];

            $categoria=new Categoria("", $nombre, $emailDepartamento);
            $categoria->edit($idCategoria);

            header("Location: /reto3/index.php?c=categoria&a=view");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function view()
    {
        if(isset($_SESSION["administrador"]))
        {
            $categoria = new Categoria("", "", "");
            $categorias = $categoria->getAll();

            echo twig()->render('categoriaView.twig', array("categorias" => $categorias));
        }
        else
        {
            echo twig()->render("loginView.twig");
        }
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