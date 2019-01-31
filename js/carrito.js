let carrito = {};

Twig.twig({
    href: "/reto3/view/carrito.twig",
    id: "carrito",
    async: false
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

        cargarCarrito();
        evento.preventDefault();
    });
}

function cargarCarrito() {
    $("#carrito").html(Twig.twig({ "ref": "carrito" }).render({ "carrito": carrito }));
    habilitarCambiosAutomaticos();
    calcularCosteTotal();
}

function habilitarCambiosAutomaticos() {
    $(".cantidad-carrito").change((evento) => {
        let target = $(evento.target);
        let id = (target.parent().prevAll("input").val());
        target.parent().next().children(".carrito-coste").html(carrito[id].precio * target.val());
        calcularCosteTotal();
    });
}

function calcularCosteTotal() {
    let total = 0;
    $('.carrito-coste').each(function () {
        total += +($(this).text());
    });
    $("#carrito-total").html(total + "€");
}