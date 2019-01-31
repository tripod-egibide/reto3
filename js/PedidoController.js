$(document).ready(function(){

    // Ver Pedidos
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
});

function cargarPedido(platos) {
    let tabla=$('#verPedidoModalTabla');

    tabla.empty();
    tabla.append("<thead><tr><th scope='col' class='text-left'>Platos</th><th scope='col'>Cantidad</th><th scope='col'>Precio unitario</th><th scope='col'>Total</th></tr></thead>");
    let total=0;

    tabla.append("<tbody>");

    for(let i=0;i<platos.length;i++){
            tabla.append("<tr><td scope='row' class='text-left'>" + platos[i]["nombre"] + "</td><td>" + platos[i]["cantidad"] + "</td><td>" + platos[i]["precio"] + " &euro;</td><td>" + platos[i]["cantidad"]*platos[i]["precio"] + " &euro;</td></tr>");

            let precio=platos[i]["cantidad"]*platos[i]["precio"];
            total=total+precio;
    }
    tabla.append("<tr><td scope='row' colspan='3'></td><td scope='row'>" + total + " &euro;</td></tr>");

    tabla.append("</tbody>");
}