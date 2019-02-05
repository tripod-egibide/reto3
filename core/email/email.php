<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "Exception.php";
require_once "PHPMailer.php";
require_once "SMTP.php";

function enviarEmail($email, $titulo, $mensaje){
    try{
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
    } catch (Exception $e) {
        echo 'Error al enviar el email: ', $mail->ErrorInfo;
        return false;
    }
}

function emailConfirmado(){
    $mensaje = "
<div>
    <p>Estimado se&ntilde;or/a <b>" . $_POST["nombre"] . ", " . $_POST["apellidos"] . " </b></p>
    <p>Su pedido con n&uacute;mero <b>". $_POST["idPedido"] . "</b>, ha sido confirmado y pueden pasar a recogerlo a partir de la fecha <b> ". $_POST["fecha"] . "</b>,
    en la direcci&oacute;n <b>Amadeo Garcia de Salazar Plaza, 2</b>, recoger&aacute;n en la cafeter&iacute;a de la escuela entre las 11:30 y las 20:00 (de mi&eacute;rcoles a s&aacute;bado).</p>
        <p>Les recordamos que los pagos se realizar&aacute;n en efectivo en la cafeter&iacute;a.</p>
    <p>Gracias por su confianza.</p>
    <p><img src='cid:logo' alt='Escuela de Hostelería de Egibide Mendizorrotza'> </p>
    </div>
    ";
    return $mensaje;
}

function emailRecibido(){
    $mensaje = "
<div>
    <p>Estimado se&ntilde;or/a <b>" . $_POST["nombre"] . ", " . $_POST["apellidos"] . " </b></p>
    <p>Hemos recibido su pedido con n&uacute;mero <b>". $_POST["idPedido"] . "</b>, recibir&aacute; un email con la confirmaci&oacute;n de su pedido.</p>
    <p>Gracias por su confianza.</p>
    <p><img src='cid:logo' alt='Escuela de Hostelería de Egibide Mendizorrotza'> </p>
    </div>
    ";
    return $mensaje;
}

function pedidoRecibido(){
    $titulo = "Pedido " . $_POST["idPedido"] . " Recibido";

    $mensaje = emailRecibido();

    enviarEmail($_POST["email"],$titulo,$mensaje);
    // envía un mensaje a todos los administradores de que hay un pedido que deben autorizar
    $mensaje = "Hay un nuevo pedido<br>Puede acceder sus pedidos pulsando <a href='" . $_SERVER["HTTP_HOST"]."/reto3/?c=admin'>Aqu&iacute;</a>";
    avisoAdmin("Nuevo pedido " . $_POST["idPedido"],$mensaje);
}

function avisoAdmin($titulo,$mensaje){
    $listaAdmin = Admin::getAll();
    $estado = "Error";
    foreach ($listaAdmin as $admin){
        if($admin["email"] !=null){
            enviarEmail($admin["email"],$titulo,$mensaje);
            $estado = "Ok";
        }
    }
    return $estado;
}

function pedidoConfirmado(){
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
    enviarEmail($email,$titulo,$mensaje);
    // envía un mensaje a todos los administradores de que hay un pedido que deben autorizar
    echo enviarEmailAdministrador($idPedido);
}
// agregamos aqui las lineas para el mensaje, ya que son pocas lineas y depende de los arrays y asi se controla mejor
function enviarEmailAdministrador($idPedido){
    //obtenemos las categorias y platos
    $listaCategoria = Pedido::getAllDetallePedidoByIdPedido($idPedido);

    //guardamos el estado del envio de los emails
    $estados = "Reporte de los emails para el pedido " . $idPedido . ":<br><br>";
    //recorremos las categorias para enviarles un email con los platos que tienen que preparar
    foreach ($listaCategoria as $categoria){
        $mensaje = "El pedido " . $idPedido . " tiene los siguientes platos:<br><br><table>
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
        if(enviarEmail($categoria["emailDepartamento"],"Pedido " . $idPedido, $mensaje)){
            $estados .= "Departamento <b>" . $categoria["nombre"]  . "</b>: " . $categoria["emailDepartamento"] . ".....Correcto<br>";
        }else{
            $estados .= "Departamento <b>" . $categoria["nombre"]  . "</b>: " . $categoria["emailDepartamento"] . ".....Error<br>";
        }
    }
    return avisoAdmin("Reporte de los emails",$estados);
}