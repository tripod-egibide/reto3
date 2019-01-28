// lamentablemente no hay forma de hacer que este churro de código se vea bien en el editor de texto
// pero funciona!
let catalogoTwig = `
    <div class="card">
        {% for categoria in categorias %}
        <span id="categoria-{{ categoria.nombre }}" class="categoria"></span>
        <div class="card-body bg-light">
            <h1 class="card-title text-center">{{ categoria.nombre }}</h1>
        </div>
        <ul class="list-group list-group-flush container-fluid px-0">
            {% for plato in categoria.platos %}
            <li class="list-group-item list-group-item-action row d-flex align-items-center p-0 mx-0">
                <img src="{{ plato.imagen }}" class="imagen-plato col-3 border-right px-0 d-none d-md-block">
                <div class="col-6">
                    <h3 class="mb-1">{{ plato.nombre }}</h3>
                    <p class="mb-1">{{ plato.notas }}</p>
                    <small class="text-muted">Mínimo {{ plato.unidadesMinimas }} {{ plato.tipoVenta }}.</small>
                </div>
                <div class="col-6 col-md-3 d-flex align-items-center justify-content-end">
                    {% if administrador %}
                    <button class="btn btn-primary botonEditar" type="button" value={{ plato.idPlato }}><i class="material-icons align-bottom">edit</i></button>
                    <button class="btn {% if plato.estado == 1 %} btn-success {% else %} btn-danger {% endif %} botonEliminar ml-1"
                        type="button" value={{ plato.idPlato }}><i class="material-icons align-bottom">{% if
                            plato.estado == 1 %} visibility {% else %} visibility_off {% endif %}</i></button>
                    {% else %}
                    <form class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text prepend-min"><strong class="mx-auto">{{ plato.precio }}€</strong></span>
                        </div>
                        <input type="number" class="form-control text-right" min={{ plato.unidadesMinimas }} value={{ plato.unidadesMinimas }}
                            aria-describedby="inputGroup-sizing-lg">
                        <input type="hidden" value={{ plato.idPlato }}>
                        <div class="input-group-append">
                            <button class="btn btn-primary py-0 px-1" type="submit"><i class="material-icons align-bottom">add</i></button>
                        </div>
                    </form>
                    {% endif %}
                </div>

            </li>
            {% endfor %}
        </ul>
        {% endfor %}
    </div>
`;

let categorias;
let administrador;
let recargar = false;

$("#categoria-collapse>*").click(()=>{
    $("#categoria-collapse").collapse("toggle");
});


$.getJSON("/reto3/?a=busqueda", (res) => {
    administrador = res.administrador;
    delete res.administrador;
    categorias = Object.values(res);
    cargarCatalogo(categorias);
    console.log(res);
});

$("#search").keyup(delay((evento)=> {
    let input = $("#search").val();
    if (input) {
        let resultados = JSON.parse(JSON.stringify(categorias));
        resultados.map((categoria) => {
            categoria.platos = categoria.platos.filter((plato) => (plato.nombre.includes(input) || plato.notas.includes(input)));
            return resultados;
        });
        resultados = resultados.filter((categoria) => {
            return categoria.platos.length;
        });
        cargarCatalogo(resultados);
        recargar = true;
    } else {
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
    console.log({ "categorias": datos, "adminstrador": administrador});
    $("#catalogo").html(template.render({ "categorias": datos, "administrador": administrador}));
}

function delay(callback) {
    var timer = 0;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, 250);
    };
}
