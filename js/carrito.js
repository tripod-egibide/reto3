Twig.twig({
    href: "/reto3/view/tablaCarrito.twig",
    id: "carrito",
    async: false
});

let carrito;

if (localStorage.carrito && !administrador) {
    carrito = JSON.parse(localStorage.carrito);
    cargarCarrito();
} else {
    carrito = {};
}
determinarAncho(); //catalogo.js

$("#carrito-navbar").popover({
    content: '<span class="text-muted">Añadido!</span>',
    html: true,
    placement: "bottom",
    trigger: "manual"
});


function habilitarBotonCompra() {
    $(".form-plato").submit((evento) => {
        let form = ($(evento.target)).serializeArray();
        let plato = {
            "cantidad": form[0].value,
            "nombre": form[2].value,
            "precio": +form[3].value,
            "unidadesMinimas": +form[4].value
        };
        let id = form[1].value;

        carrito[id] = {
            "cantidad": carrito[id] ? carrito[id].cantidad + +plato.cantidad : +plato.cantidad,
            "precio": plato.precio,
            "unidadesMinimas": plato.unidadesMinimas,
            "nombre": plato.nombre
        };

        if ($("#carrito-navbar").is(":visible")) {
            $("#carrito-navbar").popover("show");
            setTimeout(() => $("#carrito-navbar").popover("hide"), 2000);
        }

        cargarCarrito();
        almacenarCarrito();
        evento.preventDefault();
    });

}

function cargarCarrito() {
    $(".tabla-carrito").html(Twig.twig({"ref": "carrito"}).render({"carrito": carrito}));
    habilitarCambiosAutomaticos();
    calcularCosteTotal();

    if (!administrador) {
        if (jQuery.isEmptyObject(carrito)) {
            $('#carrito').css({"transform": "translate(100%, -30%)"});
        } else {
            $('#carrito').css({"transform": "translate(0%, -30%)"});
        }
    }

}

function habilitarCambiosAutomaticos() {
    $(".cantidad-carrito").change((evento) => {
        let target = $(evento.target);
        let id = (target.parent().prevAll("input").val());
        let linea = parseFloat((carrito[id].precio * target.val())).toFixed(2);
        target.parent().next().children(".carrito-coste").html(linea);

        carrito[id].cantidad = +target.val();
        almacenarCarrito();
        calcularCosteTotal();
    });

    $(".carrito-eliminar").click((evento) => {
        let target = $(evento.target);
        delete carrito[$(target).parent().prevAll("input").val()];

        almacenarCarrito();
        cargarCarrito();
    });
}

function calcularCosteTotal() {
    let total = 0;
    $('.carrito-coste').each(function () {
        total += +($(this).text());
    });
    total = parseFloat(Math.round(total)).toFixed(2);
    $(".carrito-total").html(total + "€");
}

function almacenarCarrito() {
    localStorage.carrito = JSON.stringify(carrito);
    determinarAncho(); //catalogo.js
}

$(document).ready(function(){
    $(".finalizarPedido").click(function () {
        $("#carrito-collapse").collapse("hide");
        $("#modalCliente").modal();
    });
    $("#formularioCliente").submit(function (ev) {
        ev.preventDefault();
        enviarPedido();
    });

    $("#clienteDespedida").click(function () {
        location.reload(true);
    });

    let fecha = new Date();
    fecha.setDate(fecha.getDate() + 4);
    fecha = fecha.toJSON().slice(0, 10)

    $("#fechaCliente").prop("min", fecha);

    $("#fechaCliente").change(function () {
        var dt = new Date($("#fechaCliente").val());
        try{
            if (dt.getUTCDay() == 0 || dt.getUTCDay() == 1 || dt.getUTCDay() == 2) {
                $("#fechaCliente").val("");
                throw "Ahora mismo s&oacute;lo aceptamos recogidas de mi&eacute;rcoles a s&aacute;bado.";
            }
        }catch(er){
            $("#textoError").html(er.toString());
            $("#modalError").modal();
        }

    });
});

function enviarPedido() {
    let pedido = {
        "cliente": {
            "nombre": $("#nombreCliente").val(),
            "apellidos": $("#apellidosCliente").val(),
            ["email"]: $("#emailCliente").val(),
            "fechaEntrega": $("#fechaCliente").val(),
            "total": $(".carrito-total").text().substring(0, $(".carrito-total").text().length - 1)
        },
        "carrito": carrito
    };
    //hemos pensado en annadir algo de expresion regular
    if (
        /^[6789][0-9]{8}$/.test($("#telefonoCliente").val())
    ) {
        pedido["cliente"]["telefono"] = $("#telefonoCliente").val();
    } else {
        pedido["cliente"]["telefono"] = "";
    }
    $.post("/reto3/?c=pedido&a=addPedido", pedido, (res) => {
        try {
            if (res == "Ok") {
                $("#modalCliente").modal("hide");
                $("#modalClienteFinalizado").modal();
                localStorage.removeItem("carrito");
            }
            else {
                throw "Ha habido un fallo al grabar el pedido.<br>Int&eacute;ntelo de nuevo pasados unos minutos.<br>Disculpen las molestias.";
            }
        }
        catch (er) {
            $("#textoError").html(er.toString());
            $("#modalError").modal();
        }
    });

}
