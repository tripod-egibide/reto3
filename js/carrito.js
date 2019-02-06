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
        let plato = { "cantidad": form[0].value,
            "nombre": form[2].value,
            "precio": +form[3].value,
            "unidadesMinimas": +form[4].value };
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
    $(".tabla-carrito").html(Twig.twig({ "ref": "carrito" }).render({ "carrito": carrito }));
    habilitarCambiosAutomaticos();
    calcularCosteTotal();

    if (!administrador) {
        if (jQuery.isEmptyObject(carrito)) {
            $('#carrito').css({ "transform": "translate(100%, -30%)" });     
        } else {
            $('#carrito').css({ "transform": "translate(0%, -30%)" });
        }
    }
    $(".finalizarPedido").click(function(){
        $("#carrito-collapse").collapse("hide");
        $("#modalCliente").modal();
    });
    $("#confirmarCliente").click(function() {
        enviarPedido();
    });
}

function habilitarCambiosAutomaticos() {
    $(".cantidad-carrito").change((evento) => {
        let target = $(evento.target);
        let id = (target.parent().prevAll("input").val());
        target.parent().next().children(".carrito-coste").html(carrito[id].precio * target.val());

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
    $("#carrito-total").html(total + "€");
}

function almacenarCarrito() {
    localStorage.carrito = JSON.stringify(carrito);
    determinarAncho(); //catalogo.js
}

function enviarPedido(){
    try {
        let pedido = {
            "cliente" : {
                "nombre":$("#nombreCliente").val(), "apellidos":$("#apellidosCliente").val(), "email":$("#emailCliente").val(), "telefono":$("#telefonoCliente").val(),"fechaEntrega":$("#fechaCliente").val(), "total":$("#carrito-total").text().substring(0,$("#carrito-total").text().length-1)
            },
            "carrito":carrito
        };

        $.post("/reto3/?c=pedido&a=addPedido", pedido, (res) => {
            alert(res);
            if (res == null) {
                alert("Hola");
            }
            else
                alert("Hola");
                throw "Plato no encontrado...";
        }, "JSON");
    } catch (er) {
        $("#textoError").text(er.toString());
        $("#modalError").modal();
    }
}
