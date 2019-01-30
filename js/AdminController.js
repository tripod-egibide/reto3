// Relacionado con PLATO ----------------------------------------------------------------------------------------------->

$(document).ready(function () {
    habilitarBotonesEstaticos();

    //borramos los datos si cierran el modal


});


function habilitarBotonesEditarEliminar() {
    //editar plato con modal
    $(".botonEditar").click(function () {
        readPlato($(this));
    });
    //eliminar un plato
    $(".botonEliminar").click(function () {
        readPlato($(this));
    });
    $('#modalModificarPlato').on('hidden.bs.modal', limpiar);
    //ejecutamos limpiar por las altas y ediciones, que el reload no fuerza
    limpiar();
}

function limpiar() {
    $("form")[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
    $("#imagen").attr("src", "/reto3/img/logo-restaurant.png");
    $("#idPlatoModal").attr("value","");
    $("p").remove(".text-danger");
}

function habilitarBotonesEstaticos() {
    //Agregar plato
    $("#nuevo-plato").click(function () {
        $("#modificarPlato").attr("value", "Alta Plato");
        // comprobamos si existe las unidades de medida, en caso contrario lo cargamos
        cargarUnidadesMedida();
        $("#modalModificarPlato").modal();
    });
    //editar plato con modal
    $("#modificarPlato").click(function () {
        editPlato();
    });
    //eliminar un plato
    $("#eliminarPlato").click(function () {
        confirmDeletePlato();
    });
}

function readPlato(etiqueta) {
    // leemos los datos del plato por su id
    try {
        // buscamos el plato
        let json = null;
        $.post("/reto3/?c=plato&a=findById", {"idPlato": etiqueta.val()}, (res) => {
            json = res[0];
            if (json != null) {
                if (etiqueta.hasClass("botonEditar")) {
                    // comprobamos si existe las unidades de medida, en caso contrario lo cargamos
                    cargarUnidadesMedida();
                    $('#medida').val(json.idTipoVenta)
                    $('#categoria').val(json.idCategoria)
                    // cargamos los datos en vista
                    cargarDatos(json);
                } else {
                    deletePlato(json);
                }
            }
            else
                throw new Error("Plato no encontrado...");
        }, "JSON");
    } catch (err) {
        alert(err);
    }
}

// al no estar cargado las unidades, pero sí la categoría en memoria, se precisa pedir las unidades al servidor por ajax
function cargarUnidadesMedida() {
    let unidades = $("#medida").children("option").length;
    if (unidades == 0) {
        $.post("/reto3/?c=tipoventa&a=getAll", (res) => {
            res.forEach(function (dato) {
                $("#medida").append("<option class='uni' value='" + dato.idTipoVenta + "'>" + dato.tipoVenta + "</option>");
            });
        }, "JSON");
    }
}

function cargarDatos(plato) {
    //aseguramos de borrar posibles archivos que se han quedado en el input
    $("#modificarImagen").val("");
    //cargamos los datos de un plato al modal
    $("#idPlatoModal").attr("value", plato.idPlato);
    $("#imagen").attr("src", plato.imagen);
    $("#imagen").attr("alt", plato.nombre);
    $("#nombre").val(plato.nombre);
    $("#descripcion").val(plato.notas);
    $("#precio").val(plato.precio);
    $("#cantidad").val(plato.unidadesMinimas);
    $("#modalModificarPlato").modal();
}

function editPlato() {
    //mandamos el objeto
    let opcion;
    let formData = new FormData();
    if ($("#modificarPlato").val() == "Confirmar") {
        opcion = "edit";
        formData.append("idPlato", $("#idPlatoModal").attr("value"));
        formData.append("nombre", $("#nombre").val());
        formData.append("notas", $("#descripcion").val());
        formData.append("precio", $("#precio").val());
        formData.append("unidadesMinimas", $("#cantidad").val());
        formData.append("file", $("#modificarImagen")[0].files[0]);
        formData.append("idCategoria", $("#categoria").val());
        formData.append("idTipoVenta", $("#medida").val());
        formData.append("estado", ($("#estado").prop("checked")) ? 1 : 0);
    } else {
        opcion = "insert";
        formData.append("nombre", $("#nombre").val());
        formData.append("notas", $("#descripcion").val());
        formData.append("precio", $("#precio").val());
        formData.append("unidadesMinimas", $("#cantidad").val());
        formData.append("file", $("#modificarImagen")[0].files[0]);
        formData.append("idCategoria", $("#categoria").val());
        formData.append("idTipoVenta", $("#medida").val());
        formData.append("estado", ($("#estado").prop("checked")) ? 1 : 0);
    }

    $.ajax({
        type: 'POST',
        url: "/reto3/?c=plato&a=" + opcion,
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(){
            location.reload();
        },
        error: function() {
            $("#modificarPlato").before("<p class='text-danger'>Hubo un error al guardar los datos.</p>");
        }
    });

}

function deletePlato(plato) {
    if (plato.estado == 0) {
        $("#atencion").attr("value", plato.idPlato);
        $("#atencion").html("¿Seguro que quiere habilitar el plato " + plato.nombre + "?<br>El plato ser&aacute; visible para todos sus visitantes.");
    } else {
        $("#atencion").attr("value", plato.idPlato);
        $("#atencion").html("¿Seguro que quiere deshabilitar el plato " + plato.nombre + "?<br>El plato dejar&aacute; de estar visible para sus visitantes.");
    }
    //abre modal para confirmar la modificación del estado de un plato
    $("#modalEliminarPlato").modal();
}

function confirmDeletePlato() {
    //mandamos el id a ocultar
    let idPlato = $("#atencion").attr("value");
    $.post("/reto3/?c=plato&a=delete", {idPlato}, function () {
        // recargamos la página(lo vemos necesario por si otro administrador haya cambiado el estado de visibilidad)
        // y asi evitar conflicto en el cambio de visibilidad de un plato
        location.reload();
    });

}

// Cargar imagen al ser seleccionado
var fileUpload = document.getElementById('modificarImagen');
fileUpload.onchange = function (e) {
    readFile(e.srcElement);
}

function readFile(input) {
    if (input.files) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagen").attr("src", e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// FIN relacionado con PLATO <------------------------------------------------------------------------------------------

$(document).ready(function(){

    // Modal Nuevo Plato
    $(document).on('click', '#nuevo-plato', function(){
        let unidades = $("#tipoVenta").children("option").length;
        if(unidades == 0){
            $.post("/reto3/?c=tipoventa&a=getAll",(res) => {
                res.forEach(function(dato){
                    $("#tipoVenta").append("<option value='" + dato.idTipoVenta + "'>" + dato.tipoVenta + "</option>");
                });
            }, "JSON");
        }
    });

    // Modal CRUD Administradores
    $(document).on('click', '#admin-modal', function(){
        let administradores = $("#administradoresModal").children("option").length;
        if(administradores == 0){
            $.post("/reto3/?c=admin&a=getAll",(res) => {
                res.forEach(function(dato){
                    $("#administradoresModal").append("<option value='" +dato.idAdministrador + "' data-value='" +dato.contrasenna + "'>" + dato.usuario + "</option>");
                });
            }, "JSON");
        }
        $('#altaAdminForm').hide();
        $('#editarAdminForm').hide();
    });

    $(document).on('click', '#altaAdmin', function(){
        $('#altaAdminForm').show();
        $('#editarAdminForm').hide();
    });

    $(document).on('click', '#editarAdmin', function(){
        $('#altaAdminForm').hide();
        $('#editarAdminForm').show();

        $("#editarAdminUsuario").val($("#administradoresModal option:selected").text());
        $("#editarAdminContrasenna").val($("#administradoresModal option:selected").data("value"));
        $("#editarAdminId").val($("#administradoresModal option:selected").val());
    });

    $(document).on('click', '#borrarAdmin', function(){
        $('#altaAdminForm').hide();
        $('#editarAdminForm').hide();

        let id=$("#administradoresModal option:selected").val();

        $.ajax({
            method: 'GET',
            url: 'index.php',
            data: {'c':'admin','a':'remove', 'administrador':id}
        }).done(function() {
            location.reload();
        });
    });

    // Modal CRUD Categorías
    $(document).on('click', '#categoria-modal', function(){
        let categorias = $("#categoriasModal").children("option").length;
        if(categorias == 0){
            $.post("/reto3/?c=categoria&a=getAll",(res) => {
                res.forEach(function(dato){
                    $("#categoriasModal").append("<option value='" +dato.idCategoria + "' data-value='" +dato.emailDepartamento + "'>" + dato.nombre + "</option>");
                });
            }, "JSON");
        }
        $('#altaCategoriaForm').hide();
        $('#editarCategoriaForm').hide();
    });

    $(document).on('click', '#altaCategoria', function(){
        $('#altaCategoriaForm').show();
        $('#editarCategoriaForm').hide();
    });

    $(document).on('click', '#editarCategoria', function(){
        $('#altaCategoriaForm').hide();
        $('#editarCategoriaForm').show();

        $("#editarCategoriaNombre").val($("#categoriasModal option:selected").text());
        $("#editarCategoriaEmail").val($("#categoriasModal option:selected").data("value"));
        $("#editarCategoriaId").val($("#categoriasModal option:selected").val());
    });

    $(document).on('click', '#borrarCategoria', function(){
        $('#altaCategoriaForm').hide();
        $('#editarCategoriaForm').hide();

        let id=$("#categoriasModal option:selected").val();

        $.ajax({
            method: 'GET',
            url: 'index.php',
            data: {'c':'categoria','a':'remove', 'categoria':id}
        }).done(function() {
            location.reload();
        });
    });

    // Modal CRUD Tipos de Venta
    $(document).on('click', '#tipoVenta-modal', function(){
        let tiposVenta = $("#tiposVentaModal").children("option").length;
        if(tiposVenta == 0){
            $.post("/reto3/?c=tipoventa",(res) => {
                res.forEach(function(dato){
                    $("#tiposVentaModal").append("<option value='" + dato.idTipoVenta + "'>" + dato.tipoVenta + "</option>");
                });
            }, "JSON");
        }
        $('#altaTipoVentaForm').hide();
        $('#editarTipoVentaForm').hide();
    });

    $(document).on('click', '#altaTipoVenta', function(){
        $('#altaTipoVentaForm').show();
        $('#editarTipoVentaForm').hide();
    });

    $(document).on('click', '#editarTipoVenta', function(){
        $('#altaTipoVentaForm').hide();
        $('#editarTipoVentaForm').show();

        $("#editarTipoVentaNombre").val($("#tiposVentaModal option:selected").text());
        $("#editarTipoVentaId").val($("#tiposVentaModal option:selected").val());
    });

    $(document).on('click', '#borrarTipoVenta', function(){
        $('#altaTipoVentaForm').hide();
        $('#editarTipoVentaForm').hide();

        let id=$("#tiposVentaModal option:selected").val();

        $.ajax({
            method: 'GET',
            url: 'index.php',
            data: {'c':'tipoventa','a':'remove', 'tipoVenta':id}
        }).done(function() {
            location.reload();
        });
    });
});