Twig.twig({
    href: "/reto3/view/catalogo.twig",
    id: "catalogo",
    async: false
});

let categorias;
let administrador;
let recargar = false;

$("#categoria-collapse>*").click(()=>{
    $("#categoria-collapse").collapse("toggle");
});

cargarPaginaPlato();
// lo hacemos así para no recargar la pagina al modificar un plato
function cargarPaginaPlato(){
    $.getJSON("/reto3/?a=catalogo", (res) => {
        administrador = res.administrador;
        delete res.administrador;
        categorias = Object.values(res);
        cargarCatalogo(categorias);
    });
};



$("#search").keyup(delay((evento)=> {
    let input = $("#search").val();
    if (input) {
        $('nav.sticky').css({"transform": "translate(-100%, -30%)"});
        let resultados = JSON.parse(JSON.stringify(categorias));
        resultados.map((categoria) => {
            categoria.platos = categoria.platos.filter((plato) => 
                (plato.nombre.toLowerCase().includes(input.toLowerCase()) || plato.notas.toLowerCase().includes(input.toLowerCase()))
            );
            return resultados;
        });
        resultados = resultados.filter((categoria) => {
            return categoria.platos.length;
        });
        cargarCatalogo(resultados);
        recargar = true;
    } else {
        $('nav.sticky').css({ "transform": "translate(0, -30%)" });
        if (recargar) {
            cargarCatalogo(categorias);
            recargar = false;
        }
    }
    determinarAncho();
}));

function cargarCatalogo(datos) {
    $("#catalogo").html(Twig.twig({"ref": "catalogo"}).render({ "categorias": datos, "administrador": administrador}));
    //preguntarle a nieves si es mejor que esto de error, o meter un if a ver si el usuario es administrador o no
    if (administrador) {
        // función del fichero AdminController
        habilitarBotonesEditarEliminar();
    } else {
        //esta función viene de carrito.js, y afecta a las funcionalidades asociadas con ese fichero
        habilitarBotonCompra();
    }
}

function delay(callback) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, 200);
    };
}

function determinarAncho() {
    let ancho = 7;
    ancho += 2 * !!$("#search").val();
    ancho += 3 * (jQuery.isEmptyObject(carrito));

    console.log(ancho);
    
    $('#catalogo').removeClass(["col-lg-7", "col-lg-9", "col-lg-10", "col-lg-12"]);
    $('#catalogo').addClass("col-lg-" + ancho);

    if ($("#search").val()) {
        $('#catalogo').removeClass("offset-lg-2");
    } else {
        $('#catalogo').addClass("offset-lg-2");
    }

}