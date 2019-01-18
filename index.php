<?php
$controller;

if (isset($_GET["c"])) {
    switch ($_GET["c"]) {
        case 'pedido':
            require_once __DIR__ . "/controller/PedidoController.php";
            $controller = new VinoController;
            break;

        default:
            require_once __DIR__ . "/controller/PlatoController.php";
            $controller = new BodegaController;
            break;
    }
} else {
    require_once __DIR__ . "/controller/PlatoController.php";
    $controller = new BodegaController;
}

if (isset($_GET["a"])) {
    $controller->run($_GET["a"]);
} else {
    $controller->run();
}

