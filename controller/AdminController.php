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
            default:
                $this->principal();
                break;
        }
    }

    private function principal()
    {
        if(!isset($_SESSION["administrador"]))
        {
            echo twig()->render("loginView.twig");
        }
        else
        {
            echo twig()->render("indexView.twig");
        }
    }

    private function login(){
        $usuario=$_POST["usuario"];
        $contrasenna=$_POST["contrasenna"];

        // Crear el objeto Admin
        $admin=new Admin("", $usuario, $contrasenna);
        // Ejercutar la sentencia
        $resultado=$admin->validar($usuario, $contrasenna);

        // Si el usuario es correcto, inicia sesión, Sino, vuelve a la pantalla de inicio de sesión.

        if($resultado)
        {
            $_SESSION["administrador"]=$resultado["idAdministrador"];

            echo twig()->render("indexView.twig");
        }
        else
        {
            echo twig()->render('loginView.twig', array("error"=>1,"usuario"=>$usuario, "contrasenna"=>$contrasenna));
        }
    }

}