Twig.twig({
    href: "/reto3/view/tablaCarrito.twig",
    id: "carrito",
    async: false
});

let carrito;

if (localStorage.carrito) {
    carrito = JSON.parse(localStorage.carrito);
    cargarCarrito();
} else {
    carrito = {};
}

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

        $("#carrito-navbar").popover("show");
        setTimeout(() => $("#carrito-navbar").popover("hide"), 2000);

        cargarCarrito();
        almacenarCarrito();
        evento.preventDefault();
    });

}

function cargarCarrito() {
    $(".tabla-carrito").html(Twig.twig({ "ref": "carrito" }).render({ "carrito": carrito }));
    habilitarCambiosAutomaticos();
    calcularCosteTotal();
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
}