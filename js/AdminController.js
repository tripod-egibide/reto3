// Relacionado con PLATO ----------------------------------------------------------------------------------------------->

$(document).ready(function () {
    habilitarBotonesEstaticos();
});

function habilitarBotonesEditarOcultar() {
    //editar plato con modal
    $(".botonEditar").click(function () {
        $("#modificarPlato").prop("value", "Confirmar");
        readPlato($(this));
    });
    $('#modalModificarPlato').on('hidden.bs.modal', limpiar);
    //ocultar un plato
    $(".botonOcultar").click(function () {
        readPlato($(this));
    });
    $('#modalModificarPlato').on('hidden.bs.modal', limpiar);
}

function limpiar() {
    $("form")[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
    $("#imagen").prop("src", "/reto3/img/logo-restaurant.png");
    $("#idPlatoModal").prop("value","");
    $("#labelPrecio").text("Precio:");
    $("#labelPrecio").css("color","black");
    $("#precio").css("color","black");
    $("#precio").css("border-color","black");
}

function habilitarBotonesEstaticos() {
    //Agregar plato
    $("#nuevo-plato").click(function () {
        limpiar();
        $("#modificarPlato").prop("value", "Alta Plato");
        $("#EliminarPlato").hide();
        // comprobamos si existe las unidades de medida, en caso contrario lo cargamos
        cargarUnidadesMedida();
        $("#modalModificarPlato").modal();
    });
    //editar plato con modal
    $("#idPlatoModal").submit(function( event ) {
        event.preventDefault();
        comprobarCampos();
    });
    //ocultar un plato
    $("#ocultarPlato").click(function () {
        confirmHiddenPlato();
    });
    //preguntar si elimina el plato
    $("#EliminarPlato").click(function () {
        deletePlato($("#nombre").val(), $("#idPlatoModal").val());
        $("#modalEliminarPlato").modal();
    });
    //Eliminar el plato
    $("#confirmarEliminarPlato").click(function () {
        confirmDeletePlato();
    });
    $("#precio").on("focusout", function(){
        if($("#precio").val()<1){
           $("#labelPrecio").text("Precio: (Ojo, el precio de venta es inferior a 1€)");
           $("#labelPrecio").css("color","red");
            $("#precio").css("color","red");
            $("#precio").css("border-color","red");
        }else{
            $("#labelPrecio").text("Precio:");
            $("#labelPrecio").css("color","black");
            $("#precio").css("color","black");
            $("#precio").css("border-color","black");
        }
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
                    hiddenPlato(json);
                }
            }
            else
                throw "Plato no encontrado...";
        }, "JSON");
    } catch (er) {
        $("#textoError").text(er.toString());
        $("#modalError").modal();
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

//comprobar si se puede eliminar un plato
function comprobarSiEliminable(idPlato) {

    $.post("/reto3/?c=plato&a=findQty", {"idPlato": idPlato}, (res) => {
        if(res[0].pedidos == null){
            $("#EliminarPlato").show();
            $("#modalModificarPlato").modal();
        }else{
            $("#EliminarPlato").hide();
            $("#modalModificarPlato").modal();
        }
    }, "JSON");
}

function cargarDatos(plato) {
    //aseguramos de borrar posibles archivos que se han quedado en el input
    $("#modificarImagen").val("");
    //cargamos los datos de un plato al modal
    $("#idPlatoModal").prop("value", plato.idPlato);
    $("#imagen").prop("src", plato.imagen);
    $("#imagen").prop("alt", plato.nombre);
    $("#nombre").val(plato.nombre);
    $("#descripcion").val(plato.notas);
    $("#precio").val(plato.precio);
    $("#cantidad").val(plato.unidadesMinimas);
    $("#estado").prop("checked", (plato.estado ==1)?true:false);
    comprobarSiEliminable(plato.idPlato);
}

function rellenar(){

}
// para que funcione sin recargar la página, usamos ajax y anulamos submit
//supone unas líneas adicionales, asi como extraer los datos del form y meterlos a mano en un FormData
function comprobarCampos(){
    //try{
    //entendemos que pueden ofrecer algun producto de forma gratuita,
    //pero por si acaso hay un aviso de venta inferior a 1 euro
        if($("#cantidad").val()>0 && $.isNumeric($("#precio").val()) && $("#nombre").val().length > 0){
            editPlato();
        }
        // PREGUNTAR A NIEVES SI ES VIABLE----------------------------------------------------------------------------------------------------------
        /*else{
            throw "Los campos marcados en rojo, son Obligatorios.";
        }
    }catch(er){
        $("#textoError").text(er.toString());
        $("#modalError").modal();
    }*/
}

function editPlato() {
    try{
    //mandamos el objeto
    let opcion;
    let formData = new FormData();
    if ($("#modificarPlato").val() == "Confirmar") {
        opcion = "edit";
        formData.append("idPlato", $("#idPlatoModal").prop("value"));
        formData.append("nombre", $("#nombre").val());
        formData.append("notas", $("#descripcion").val());
        formData.append("precio", $("#precio").val());
        formData.append("unidadesMinimas", $("#cantidad").val());
        if($("#modificarImagen")[0].files[0]!= null) {
            formData.append("file", $("#modificarImagen")[0].files[0]);
        }
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
            $("#modalModificarPlato").modal("hide");
            cargarPaginaPlato();
        },
        error: function() {
            throw "Hubo un error al insertar los datos.";
        }
    });
    }catch(er){
        $("#textoError").text(er.toString());
        $("#modalError").modal();
    }
}

function hiddenPlato(plato) {
    if (plato.estado == 0) {
        $("#atencion").prop("value", plato.idPlato);
        $("#atencion").html("¿Seguro que quiere habilitar el plato " + plato.nombre + "?<br>El plato ser&aacute; visible para todos sus visitantes.");
    } else {
        $("#atencion").prop("value", plato.idPlato);
        $("#atencion").html("¿Seguro que quiere deshabilitar el plato " + plato.nombre + "?<br>El plato dejar&aacute; de estar visible para sus visitantes.");
    }
    //abre modal para confirmar la modificación del estado de un plato
    $("#modalOcultarPlato").modal();
}

function confirmHiddenPlato() {
    //mandamos el id a ocultar
    let idPlato = $("#atencion").prop("value");
    $.post("/reto3/?c=plato&a=hidden", {idPlato}, function () {
        $("#modalOcultarPlato").modal("hide");
        cargarPaginaPlato();
    });

}

function deletePlato(nombre, idPlato) {
    $("#atencionEliminar").prop("value", idPlato);
    $("#atencionEliminar").html("¿Seguro que quiere Eliminar el plato " + nombre + "?");
    $("#modalEliminarPlato").modal();
}

function confirmDeletePlato() {
    //mandamos el id a ocultar
    let idPlato = $("#atencionEliminar").prop("value");
    $.post("/reto3/?c=plato&a=delete", {idPlato}, function () {
        $("#modalModificarPlato").modal("hide");
        $("#modalEliminarPlato").modal("hide");
        cargarPaginaPlato();
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
            $("#imagen").prop("src", e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// FIN relacionado con PLATO <------------------------------------------------------------------------------------------

$(document).ready(function(){

    // Modal CRUD Administradores
    $(document).on('click', '#admin-modal', function(){
        let administradores = $("#administradoresModal").children("option").length;
        if(administradores == 0){
            $.post("/reto3/?c=admin&a=getAll",(res) => {
                res.forEach(function(dato){
                    $("#administradoresModal").append("<option value='" +dato.idAdministrador + "' data-value='" +dato.contrasenna + "' data-value2='" +dato.email + "'>" + dato.usuario + "</option>");
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
        $("#editarAdminEmail").val($("#administradoresModal option:selected").data("value2"));
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
                    $("#categoriasModal").append("<option value='" +dato.idCategoria + "' data-value='" +dato.emailDepartamento + "' data-value2='" +dato.preferencia + "'>" + dato.nombre + "</option>");
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
        $("#editarCategoriaPreferencia").val($("#categoriasModal option:selected").data("value2"));
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