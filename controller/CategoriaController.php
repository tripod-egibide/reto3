<?php

if(session_id()==''){
    session_start();
}

class CategoriaController
{

    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Categoria.php";
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
            case 'insertar':
                $this->insertar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'actualizar':
                $this->actualizar();
                break;
            default:
                $this->principal();
                break;
        }
    }

    private function principal()
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

    private function insertar()
    {
        if(isset($_SESSION["administrador"]))
        {
            $nombre = $_POST["nombre"];
            $emailDepartamento = $_POST["emailDepartamento"];

            $categoria = new Categoria("", $nombre, $emailDepartamento);
            $categoria->insert();
            header("Location: /reto3/index.php?c=categoria");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function eliminar()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idCategoria = $_GET["categoria"];

            $categoria = new Categoria("", "", "");
            $categoria->delete($idCategoria);

            header("Location: /reto3/index.php?c=categoria");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function actualizar()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idCategoria=$_POST["idCategoria"];
            $nombre = $_POST["nombre"];
            $emailDepartamento = $_POST["emailDepartamento"];

            $categoria=new Categoria("", $nombre, $emailDepartamento);
            $categoria->update($idCategoria);

            header("Location: /reto3/index.php?c=categoria");
        }
        else
        {
            header("Location: /reto3/");
        }
    }
}