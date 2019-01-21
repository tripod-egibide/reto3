<?php
function twig()
{
    require_once __DIR__ . "/../vendor/autoload.php";

    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../view/');
    $twig =  new Twig_Environment($loader);
    if (isset($_SESSION["administrador"])) {
        $twig->addGlobal('administrador', $_SESSION["administrador"]);
    }
    return $twig;
}