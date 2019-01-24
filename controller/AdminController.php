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
            case 'insertar':
                $this->insertar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'actualizar':
                $this->actualizar();
                break;
            case 'ver':
                $this->ver();
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
        if(isset($_SESSION["administrador"]) /*&& $_SESSION["administrador"]*/)
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
        if(isset($_POST["usuario"]))
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
        else
        {
            header("Location: /reto3/");
        }
    }

    private function insertar()
    {
        if(isset($_SESSION["administrador"]) && isset($_POST["usuario"]))
        {
            $usuario = $_POST["usuario"];
            $contrasenna = $_POST["contrasenna"];

            $admin = new Admin("", $usuario, $contrasenna);
            $admin->insert();
            header("Location: /reto3/index.php?c=admin&a=ver");
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
            $idAdministrador = $_GET["administrador"];

            $admin = new Admin("", "", "");
            $admin->delete($idAdministrador);

            header("Location: /reto3/index.php?c=admin&a=ver");
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
            $idAdministrador=$_POST["idAdministrador"];
            $usuario=$_POST["usuario"];
            $contrasenna=$_POST["contrasenna"];

            $admin=new Admin("", $usuario, $contrasenna);
            $admin->update($idAdministrador);

            header("Location: /reto3/index.php?c=admin&a=ver");
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function ver()
    {
        if(isset($_SESSION["administrador"]))
        {
            $admin = new Admin("", "", "");
            $administradores = $admin->getAll();

            echo twig()->render('adminView.twig', array("administradores" => $administradores));
        }
        else
        {
            header("Location: /reto3/");
        }
    }

    private function salir()
    {
        session_destroy();
        /*$_SESSION["administrador"] = false;*/
        header("Location: /reto3/");
    }
}