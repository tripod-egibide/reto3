$(document).ready(function(){
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
    $(".confirmarPedido").click(function(){
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

function confirmarPedido(objeto){
    try{
        $.post("/reto3/?c=pedido&a=pedidoConfirmado", objeto, (res) => {
            console.log(res);
            if (res== "Ok") {
                location.reload();
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
    tabla.append("<thead><tr><th scope='col' class='text-left'>Platos</th><th scope='col'>Cantidad</th><th scope='col'>Precio unitario</th><th scope='col'>Total</th></tr></thead>");
    let total=0;

    tabla.append("<tbody>");

    for(let i=0;i<platos.length;i++){
            tabla.append("<tr><td scope='row' class='text-left'>" + platos[i]["nombre"] + "</td><td>" + platos[i]["cantidad"] + "</td><td>" + formatearPrecio(platos[i]["precio"]) + " &euro;</td><td>" + formatearPrecio(platos[i]["cantidad"]*platos[i]["precio"]) + " &euro;</td></tr>");

            let precio=platos[i]["cantidad"]*platos[i]["precio"];
            total=total+precio;
    }
    tabla.append("<tr><td scope='row' colspan='3'></td><td scope='row'>" + formatearPrecio(total) + " &euro;</td></tr>");

    tabla.append("</tbody>");
}

function formatearPrecio(precio){
    return parseFloat(Math.round(precio * 100) / 100).toFixed(2);
}