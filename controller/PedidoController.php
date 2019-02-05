<?php

if(session_id()==''){
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PedidoController
{

    public function run($action = "")
    {
        include_once __DIR__ . "/../core/email/mensajes.php";
        require_once __DIR__ . "/../core/email/Exception.php";
        require_once __DIR__ . "/../core/email/PHPMailer.php";
        require_once __DIR__ . "/../core/email/SMTP.php";
        require_once __DIR__ . "/../model/Categoria.php";
        require_once __DIR__ . "/../model/Pedido.php";
        require_once __DIR__ . "/../model/Plato.php";
        require_once __DIR__ . "/../model/admin.php";
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
            case 'ver':
                $this->ver();
                break;

            case 'getAll':
                $this->getAll();
                break;

            case 'getDetallePedido':
                $this->getDetallePedido();
                break;

            case 'eliminar':
                $this->eliminar();
                break;

            case 'detalles':
                $this->detalles();
                break;

            case 'pedidoRecibido':
                $this->pedidoRecibido();
                break;

            case 'pedidoConfirmado':
                $this->pedidoConfirmado();
                break;

            default:
                $this->realizar();
                break;
        }
    }

    private function ver()
    {
        if(isset($_SESSION["administrador"]))
        {
            $pedidos = Pedido::getAll();

            echo twig()->render("pedidoView.twig", ["pedidos" => $pedidos]);
        }

    }

    private function getAll()
    {
        $pedidos = Pedido::getAll();
        header('Content-type: application/json');
        echo json_encode($pedidos);

    }

    private function getDetallePedido()
    {
        if(isset($_SESSION["administrador"]))
        {
            $platos=Pedido::getAllDetallePedidoByIdPedido($_GET["idPedido"]);
            $data=Array();
            foreach ($platos as $plato) {
                $platosSeleccionado=Plato::getAllById($plato["idPlato"]);
                $data[] = [
                    "nombre" => $platosSeleccionado["nombre"],
                    "precio" => $platosSeleccionado["precio"],
                    "cantidad" => $plato["cantidad"]
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    private function eliminar()
    {
        if(isset($_SESSION["administrador"]))
        {
            Pedido::delete($_GET["idPedido"]);
        }

    }

    private function detalles()
    {
        // temp
    }

    private function realizar()
    {
        // temp
    }

    private function login()
    {
        // temp
    }

    private function pedidoRecibido(){
        $titulo = "Pedido " . $_POST["idPedido"] . " Recibido";

        $mensaje = emailRecibido();

        $this->enviarEmail($_POST["email"],$titulo,$mensaje);
        // envía un mensaje a todos los administradores de que hay un pedido que deben autorizar
        $mensaje = "Hay un nuevo pedido<br>Puede acceder sus pedidos pulsando <a href='" . $_SERVER[‘HTTP_HOST’]."/reto3/?c=admin'>Aqu&iacute;</a>";
        avisoAdmin("Nuevo pedido " . $_POST["idPedido"],$mensaje);
    }

    private function avisoAdmin($titulo,$mensaje){
        $listaAdmin = Admin::getAll();
        $estado = "Error";
        foreach ($listaAdmin as $admin){
            if($admin["email"] !=null){
                $this->enviarEmail($admin["email"],$titulo,$mensaje);
                $estado = "Ok";
            }
        }
        return $estado;
    }

    private function pedidoConfirmado(){
        $idPedido = $_POST["idPedido"];
        //marcamos el pedido como confirmado
        Pedido::confirmarPedido($idPedido);
        // cargamos el email del cliente
        $email = $_POST["email"];
        // cargamos el titulo del email
        $titulo = "Pedido " . $idPedido . " Confirmado";
        //cargamos el mensaje predefinido
        $mensaje = emailConfirmado();
        //enviamos email de confirmado al cliente
        $this->enviarEmail($email,$titulo,$mensaje);
        // envía un mensaje a todos los administradores de que hay un pedido que deben autorizar
        echo $this->enviarEmailAdministrador($idPedido);
    }

    private function enviarEmailAdministrador($idPedido){
        //obtenemos las categorias y platos
        $listaCategoria = Pedido::getAllDetallePedidoByIdPedido($idPedido);

        //guardamos el estado del envio de los emails
        $estados = "Estado de los emails para el pedido " . $idPedido . ":<br><br>";
        //recorremos las categorias para enviarles un email con los platos que tienen que preparar
        foreach ($listaCategoria as $categoria){
            $mensaje = "El pedido " . $idPedido . " tiene los siguientes platos:<br><table>
<tr>
    <th>Plato</th>
    <th>Cantidad</th>
  </tr>";

            $platos = Plato::getAllByListIdPlato($idPedido, $categoria["idCategoria"]);
            foreach ($platos as $plato){
                $mensaje .= "
<tr>
    <td>" . $plato["nombre"] . "</td>
    <td>" . $plato["cantidad"] . "</td>
  </tr>";
            }
            $mensaje .= "</table>";
            if($this->enviarEmail($categoria["emailDepartamento"],"Pedido " . $idPedido, $mensaje)){
                $estados .= $categoria["emailDepartamento"] . ".....Correcto<br>";
            }else{
                $estados .= $categoria["emailDepartamento"] . ".....Error<br>";
            }
        }
        return $this->avisoAdmin("Reporte de los emails",$estados);
    }
    private function enviarEmail($email, $titulo, $mensaje){
        //email del destinatario
        $toAddress = $email;
        // inicialización del email
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth    = true;
        // servidor smtp
        $mail->Host        = "smtp.gmail.com";
        // puerto
        $mail->Port        = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        // si el email es formato html
        // lo vamos a dejar en html por si se decide implementar un email con html, así enriquecer el email con
        // estructuras html
        $mail->IsHTML(true);
        // usuario del correo
        $mail->Username = "escueladehosteleriadeegibide@gmail.com";
        //contrasenna del correo
        // por seguridad, empleamos clase de aplicaciones
        $mail->Password = "xtojutxwusyxoidm";
        // desde la direccion
        $mail->SetFrom("escueladehosteleriadeegibide@gmail.com");
        // titulo
        $mail->Subject = $titulo;

        $mail->AddEmbeddedImage( "img/logo-restaurant.png",'logo');
        $mail->Body = $mensaje;
        $mail->AddAddress($toAddress);
        if (!$mail->Send()) {
            return false;

        } else {
            return true;
        }
    }
}