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
        
    });
});

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