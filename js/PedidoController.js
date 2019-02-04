$(document).ready(function(){

    // Ver pedidos
    $(document).on('click', '#ver-pedidos', function(){
        recargarListaPedidos();
    });

    // Ver detalle del pedido
    $(document).on('click', '.verPedido', function(){

        let idPedido =$(this).val();

        $.ajax({
            method: 'GET',
            url: 'index.php',
            data: {'c':'pedido', 'a': 'getDetallePedido', 'idPedido': idPedido},
            dataType: 'JSON'
        }).done(function(data){
            cargarPedido(data);
        });

        $('#verPedidoModal').modal('show');
    });

    // Eliminar pedido
    $(document).on('click', '.eliminarPedido', function(){
        let idPedido =$(this).val();
        $.ajax({
            method: 'GET',
            url: 'index.php',
            data: {'c':'pedido', 'a': 'eliminar', 'idPedido': idPedido}
        }).done(function(){
            location.reload();
        });
    });

    //confirmar pedido
    $(document).on('click', '.confirmarPedido', function(){
        $(this).text("Enviando email...");
        $(this).prop("disabled", true);
        let objeto = {
        "idPedido": $(this).val(),
        "nombre": $($(this).parents("tr").find("td")[0]).text(),
        "apellidos": $($(this).parents("tr").find("td")[1]).text(),
        "email": $($(this).parents("tr").find("td")[2]).text(),
        "fecha": $($(this).parents("tr").find("td")[4]).text()
        }
        confirmarPedido(objeto);
    });
});

function recargarListaPedidos(){
    $.ajax({
        method: 'GET',
        url: 'index.php',
        data: {'c':'pedido', 'a': 'getAll'},
        dataType: 'JSON'
    }).done(function(data){
        cargarPedidos(data);
    });
}

function cargarPedidos(pedidos) {
    let tabla=$('#verPedidosModalTabla');

    tabla.empty();
    if(pedidos.length>0)
    {
        tabla.append("<thead>\n" +
            "           <tr>\n" +
            "               <th scope='col'>Nombre</th>\n" +
            "               <th scope='col'>Apellidos</th>\n" +
            "               <th scope='col'>Correo electr&oacute;nico</th>\n" +
            "               <th scope='col'>Tel&eacute;fono</th>\n" +
            "               <th scope='col'>Fecha de entrega</th>\n" +
            "               <th scope='col' colspan='3' class='text-center'>Acciones</th>\n" +
            "           </tr>\n" +
            "         </thead>");

        tabla.append("<tbody>");

        for(let i=0;i<pedidos.length;i++){
            let confirmado="";
            if(pedidos[i]["confirmado"]==0)
            {
                confirmado="<button class='btn btn-outline-primary confirmarPedido' value='" + pedidos[i]["idPedido"] + "'>Confirmar</button>";
            }
            else
            {
                confirmado="<i class='material-icons align-bottom'>done</i>";
            }
            tabla.append("<tr>\n" +
                "           <td scope='row'>" + pedidos[i]["nombre"] + "</td>\n" +
                "           <td>" + pedidos[i]["apellidos"] + "</td>\n" +
                "           <td>" + pedidos[i]["email"] + "</td>\n" +
                "           <td>" + pedidos[i]["telefono"] + "</td>\n" +
                "           <td>" + pedidos[i]["fechaEntrega"] + "</td>\n" +
                "           <td>" + confirmado + "</td>\n" +
                "           <td><button class='btn btn-outline-primary verPedido' value='" + pedidos[i]["idPedido"] + "'>Ver pedido</button></td>\n" +
                "           <td><button class='btn btn-outline-danger eliminarPedido' value='" + pedidos[i]["idPedido"] + "'><i class='material-icons align-bottom'>delete</i></button></td>\n" +
                "         </tr>");
        }

        tabla.append("</tbody>");
    }
}

function confirmarPedido(objeto){
    try{

        $.post("/reto3/?c=pedido&a=pedidoConfirmado", objeto, (res) => {
            if (res == "Ok") {
                recargarListaPedidos();
            }else{
                $("#textoError").html("Hubo un error al grabar el Confirmar el pedido.");
                $("#modalError").modal();
            }
        });
    }catch(er){
        $("#textoError").text(er.toString());
        $("#modalError").modal();
    }
}

function cargarPedido(platos) {
    let tabla=$('#verPedidoModalTabla');

    tabla.empty();

    if(platos.length>0)
    {
        let total=0;
        tabla.append("<thead><tr><th scope='col' class='text-left'>Platos</th><th scope='col'>Cantidad</th><th scope='col'>Precio unitario</th><th scope='col'>Total</th></tr></thead>");

        tabla.append("<tbody>");

        for(let i=0;i<platos.length;i++){
            tabla.append("<tr><td scope='row' class='text-left'>" + platos[i]["nombre"] + "</td><td>" + platos[i]["cantidad"] + "</td><td>" + formatearPrecio(platos[i]["precio"]) + " &euro;</td><td>" + formatearPrecio(platos[i]["cantidad"]*platos[i]["precio"]) + " &euro;</td></tr>");

            let precio=platos[i]["cantidad"]*platos[i]["precio"];
            total=total+precio;
        }
        tabla.append("<tr><td scope='row' colspan='3'></td><td scope='row'>" + formatearPrecio(total) + " &euro;</td></tr>");

        tabla.append("</tbody>");
    }
}

function formatearPrecio(precio){
    return parseFloat(Math.round(precio * 100) / 100).toFixed(2);
}
