<?php
function twig()
{
    require_once __DIR__ . "/../vendor/autoload.php";

    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../view/');
    return new Twig_Environment($loader);
}