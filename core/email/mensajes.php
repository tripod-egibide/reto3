<?php

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

