<?php
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
                $this->vista();
                break;
        }
    }

    private function vista() 
    {
        echo twig()->render("adminView.twig");
    }

    private function login(){
        // temp
    }

}