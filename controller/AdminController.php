<?php

if(session_id()==''){
    session_start();
}

class AdminController
{

    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Admin.php";
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'add':
                $this->add();
                break;
            case 'remove':
                $this->remove();
                break;
            case 'edit':
                $this->edit();
                break;
            case 'getAll':
                $this->getAll();
                break;
            default:
                $this->index();
                break;
        }
    }

    private function login()
    {
        if(isset($_POST["usuario"]))
        {
            $usuario=$_POST["usuario"];
            $contrasenna=$_POST["contrasenna"];

            $validar=Admin::validar($usuario, $contrasenna);

            if($validar)
            {
                $_SESSION["administrador"]=$validar["idAdministrador"];
                header("Location: /reto3/");
            }
            else
            {
                echo twig()->render('loginView.twig', array("error"=>1,"usuario"=>$usuario, "contrasenna"=>$contrasenna));
            }
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function logout()
    {
        session_destroy();
        header("Location: /reto3/");
    }

    private function add()
    {
        if(isset($_SESSION["administrador"]) && isset($_POST["usuario"]))
        {
            $usuario = $_POST["usuario"];
            $contrasenna = $_POST["contrasenna"];

            $admin = new Admin("", $usuario, $contrasenna);
            $admin->insert();
        }
        header("Location: /reto3/");
    }

    private function remove()
    {
        if(isset($_SESSION["administrador"]))
        {
            Admin::delete($_GET["administrador"]);
        }
    }

    private function edit()
    {
        if(isset($_SESSION["administrador"]))
        {
            $idAdministrador=$_POST["idAdministrador"];
            $usuario=$_POST["usuario"];
            $contrasenna=$_POST["contrasenna"];

            $admin=new Admin("", $usuario, $contrasenna);
            $admin->update($idAdministrador);
        }
        header("Location: /reto3/");
    }

    private function index()
    {
        if(isset($_SESSION["administrador"]))
        {
            header("Location: /reto3/");
        }
        else
        {
            echo twig()->render("loginView.twig");
        }
    }

    private function getAll()
    {
        echo json_encode(Admin::getAll());
    }
}