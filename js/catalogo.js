// lamentablemente no hay forma de hacer que este churro de código se vea bien en el editor de texto
// pero funciona!
let catalogoTwig = `
<div class="card border-top-0 mb-5">
    {% for categoria in categorias if categoria.platos %}
    <span class="categoria">
        <span id="categoria-{{ categoria.nombre }}" class="categoria-anchor"></span>
        <div class="card-body bg-light border-top">
            <h1 class="card-title text-center text-primary">{{ categoria.nombre }}</h1>
        </div>
        <ul class="platos list-group list-group-flush container-fluid px-0">
            {% for plato in categoria.platos %}
            <li class="plato list-group-item list-group-item-action row d-flex align-items-center p-0 mx-0" id="plato{{ plato.idPlato }}">
                <img src="{{ plato.imagen }}" class="imagen-plato col-3 border-right px-0 d-none d-md-block">
                <div class="col-6">
                    <h3 class="mb-1 text-dark">{{ plato.nombre }}</h3>
                    <p class="mb-1">{{ plato.notas }}</p>
                    <small class="text-muted">
                        {% if plato.unidadesMinimas > 1 %}
                            Mínimo {{ plato.unidadesMinimas }} {{ plato.tipoVenta }}.
                        {% else %}    
                            Vendido por {{ plato.tipoVenta }}.
                        {% endif%}                    
                    </small>
                </div>
                <div class="col-6 col-md-3 d-flex flex-wrap align-items-center justify-content-end">
                    {% if administrador %}
                        <button class="btn btn-oldprimary botonEditar" type="button" value={{ plato.idPlato }}><i class="material-icons align-bottom">edit</i></button>
                        <button class="btn {% if plato.estado == 1 %} btn-success {% else %} btn-danger {% endif %} botonOcultar ml-1" type="button" value={{ plato.idPlato }}><i class="material-icons align-bottom">{% if plato.estado == 1 %} visibility {% else %} visibility_off {% endif %}</i></button>
                    {% else %}
                    <div>
                        <span class="text-center d-block">
                            {{ plato.precio }}€ por unidad.
                        </span>
                        <form class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text prepend-min">Cant. </span>
                            </div>
                            <input type="number" class="form-control text-right" min={{ plato.unidadesMinimas }} value={{ plato.unidadesMinimas }}
                            aria-describedby="inputGroup-sizing-lg">
                            <input type="hidden" value={{ plato.idPlato }}>
                            <div class="input-group-append">
                                <button class="btn btn-primary py-0 px-1" type="submit"><i class="material-icons align-bottom">add_shopping_cart</i></button>
                            </div>
                        </form>
                    </div>
                    {% endif %}
                </div>
            </li>
            {% endfor %}
        </ul>
    </span>
    {% endfor %}
</div>
`;

let categorias;
let administrador;
let recargar = false;

$("#categoria-collapse>*").click(()=>{
    $("#categoria-collapse").collapse("toggle");
});


$.getJSON("/reto3/?a=catalogo", (res) => {
    administrador = res.administrador;
    delete res.administrador;
    categorias = Object.values(res);
    cargarCatalogo(categorias);
});

$("#search").keyup(delay((evento)=> {
    let input = $("#search").val();
    if (input) {
        $('nav.sticky').css({"transform": "translate(-100%, -30%)"});
        $('#catalogo').removeClass("offset-lg-2 col-lg-7");
        $('#catalogo').addClass("col-lg-9");
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
        $('#catalogo').removeClass("col-lg-9");
        $('#catalogo').addClass("offset-lg-2 col-lg-7");
        if (recargar) {
            cargarCatalogo(categorias);
            recargar = false;
        }
    }
}));

function cargarCatalogo(datos) {
    let template = Twig.twig({
        data: catalogoTwig
    });
    $("#catalogo").html(template.render({ "categorias": datos, "administrador": administrador}));
    //esta función viene de carrito.js, y afecta a las funcionalidades asociadas con ese fichero
    //preguntarle a nieves si es mejor que esto de error, o meter un if a ver si el usuario es administrador o no
    //habilitarBotonCompra();
    // función del fichero AdminController
    habilitarBotonesEditarOcultar()
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
