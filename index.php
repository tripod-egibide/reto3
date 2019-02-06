<?php

session_start();

# en principio esto ya está terminado, no habría que tocarlo más
$controller;

if (isset($_GET["c"])) {
    switch ($_GET["c"]) {
        case 'pedido':
            require_once __DIR__ . "/controller/PedidoController.php";
            $controller = new PedidoController;
            break;

        case 'admin':
            require_once __DIR__ . "/controller/AdminController.php";
            $controller = new AdminController;
            break;

        case 'categoria':
            require_once __DIR__ . "/controller/CategoriaController.php";
            $controller = new CategoriaController;
            break;

        case 'tipoventa':
            require_once __DIR__ . "/controller/TipoVentaController.php";
            $controller = new TipoVentaController;
            break;

        default:
            require_once __DIR__ . "/controller/PlatoController.php";
            $controller = new PlatoController;
            break;
    }
} else {
    require_once __DIR__ . "/controller/PlatoController.php";
    $controller = new PlatoController;
}

if (isset($_GET["a"])) {
    $controller->run($_GET["a"]);
} else {
    $controller->run();
}