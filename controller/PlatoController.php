<?php

if(session_id()==''){
    session_start();
}

class PlatoController
{
    public function run($action = "")
    {
        require_once __DIR__ . "/../model/Plato.php";
        require_once __DIR__ . "/../core/twig.php";
        switch ($action) {
            case 'nuevo':
                $this->nuevo();
                break;

            case 'edit':
                $this->edit();
                break;

            case 'insert':
                $this->insert();
                break;

            case 'catalogo':
                $this->catalogo();
                break;
            
            case 'findById':
                $this->findById();
                break;

            case 'delete':
                $this->delete();
                break;

            default:
                $this->index();
                break;
        }
    }

    private function index()
    {
        // estos datos solo se usan para el nav de categorias
        // en práctica tal vez sería mejor cargar eso por el cliente también, pero debemos usar twig en el servidor en alguna parte
        require_once __DIR__ . "/../model/Categoria.php";;
        $categorias = Categoria::getAll();

        $data = [];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"], 
            ];            
        }

        echo twig()->render("indexView.twig", ["categorias" => $data]);
    }

    private function edit()
    {
        $uploadedFile = '';
        if(!empty($_FILES["file"]["type"])){
            $fileName = $_FILES['file']['name'];
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "img/".$fileName;
                if(move_uploaded_file($sourcePath,$targetPath)){
                    $uploadedFile = $fileName;
                }
        }else{
            $uploadedFile = "logo-restaurant.png";
        }
        $plato = new Plato($_POST['idPlato'], $_POST['nombre'], $_POST['precio'], $_POST['unidadesMinimas'], $_POST['notas'], "/reto3/img/".$uploadedFile,
            $_POST['idCategoria'], $_POST['idTipoVenta'], $_POST['estado']);
        $plato->update();

    }

    private function catalogo() 
    {
        require_once __DIR__ . "/../model/Categoria.php";
        $categorias = Categoria::getAll();

        $data = ["administrador" => $_SESSION["administrador"] ?? 0];
        foreach ($categorias as $categoria) {
            $data[$categoria["idCategoria"]] = [
                "nombre" => $categoria["nombre"], 
                "platos" => Plato::getByCategoria($categoria["idCategoria"]),
            ];            
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }


    private function nuevo()
    {
        // temp
        // éste sería el que carga la página del formulario
    }

    private function insert()
    {
        if(isset($_SESSION["administrador"]) && isset($_POST["titulo"]))
        {
            if(!Plato::getByNombre($_POST["titulo"])) // Título del plato único
            {
                $nombre = $_POST["titulo"];
                $precio = $_POST["precio"];
                $unidadesMinimas = $_POST["cantidad"];
                $notas = $_POST["notas"];
                $idCategoria = $_POST["categoria"];
                $idTipoVenta = $_POST["tipoVenta"];

                $imagen="img/logo-restaurant.png";
                if($_FILES['imagen']['error']==0)
                {
                    $sourcePath = "img/platos/";
                    $fichero_subido = __DIR__ . "/../". $sourcePath . basename($_FILES['imagen']['name']);

                    if(move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                        $imagen = $sourcePath . basename($_FILES['imagen']['name']);
                    }
                }

                $plato = new Plato("", $nombre, $precio, $unidadesMinimas, $notas, $imagen, $idCategoria, $idTipoVenta, 1);
                $plato->insert();
            }
        }
        header("Location: /reto3/");
    }

    private function findById()
    {
        echo json_encode(Plato::getById($_POST["idPlato"]));
    }

    private function delete(){
        Plato::delete($_POST["idPlato"]);
    }

}