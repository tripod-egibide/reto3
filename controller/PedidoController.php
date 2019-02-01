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
        require_once __DIR__ . "/../core/email/Exception.php";
        require_once __DIR__ . "/../core/email/PHPMailer.php";
        require_once __DIR__ . "/../core/email/SMTP.php";
        require_once __DIR__ . "/../model/Pedido.php";
        require_once __DIR__ . "/../model/Plato.php";
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
            case 'ver':
                $this->ver();
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
        $email = "";
        $titulo = "Hola Jon";
        $mensaje = "Probando el cuerpo del mensaje";

        $this->enviarEmail($email,$titulo,$mensaje);
        // envía un mensaje a todos los administradores de que hay un pedido que deben autorizar
        enviarEmailAdministrador($mensaje);
    }

    private function enviarEmailAdministrador($idPedido, $nombre){
        $mensaje = "";
        $admines = Admin::getAll();
        foreach ($admines as $admin){
            $this->enviarEmail($admin->email,"Aviso de pedido entrante",$mensaje);
        }
    }

    private function pedidoConfirmado(){

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
        $mail->Body    = $mensaje;
        $mail->AddAddress($toAddress);
        if (!$mail->Send()) {
            return "fallido";

        } else {
            return "ok";
        }
    }
}