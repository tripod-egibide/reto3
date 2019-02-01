<?php
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
        require_once __DIR__ . "/../core/twig.php";

        switch ($action) {
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

    private function detalles()
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