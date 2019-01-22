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
            case 'salir':
                $this->salir();
                break;
            default:
                $this->principal();
                break;
        }
    }

    private function principal()
    {
        if(isset($_SESSION["administrador"]) && $_SESSION["administrador"])
        {
            header("Location: /reto3/");
        }
        else
        {
            echo twig()->render("loginView.twig");
        }
    }

    private function login()
    {
        $usuario=$_POST["usuario"];
        $contrasenna=$_POST["contrasenna"];

        // Crear el objeto Admin
        $admin=new Admin("", $usuario, $contrasenna);
        // Ejercutar la sentencia
        $resultado=$admin->validar($usuario, $contrasenna);

        // Si el usuario es correcto, inicia sesión, si no, vuelve a la pantalla de inicio de sesión.

        if($resultado)
        {
            $_SESSION["administrador"]=$resultado["idAdministrador"];
            header("Location: /reto3/");
        }
        else
        {
            echo twig()->render('loginView.twig', array("error"=>1,"usuario"=>$usuario, "contrasenna"=>$contrasenna));
        }
    }

    private function salir()
    {
        $_SESSION["administrador"] = false;
        header("Location: /reto3/");
    }
}