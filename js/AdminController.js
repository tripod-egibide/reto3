
// Relacionado con PLATO ----------------------------------------------------------------------------------------------->

$(document).ready(function(){
    habilitarBotones();
});

function habilitarBotones(){
    //editar plato con modal
    $(".botonEditar").click(function (){
        readPlato($(this));
    });
    $("#modificarPlato").click(function(){
        editPlato();
    });
    //eliminar un plato
    $(".botonEliminar").click(function (){
        readPlato($(this));
    });
    $("#eliminarPlato").click(function(){
        confirmDeletePlato();
    });
}

function readPlato(etiqueta) {
    // leemos los datos del plato por su id
    try{
        // buscamos el plato
        let json = null;
        $.post("/reto3/?c=plato&a=findById", {"idPlato": etiqueta.val()}, (res) => {
            json = res[0];
            if(json!=null){
                if(etiqueta.hasClass("botonEditar")){
                    // comprobamos si existe las unidades de medida, en caso contrario lo cargamos
                    cargarUnidadesMedida();
                    $("#uni"+json.idTipoVenta).prop('selected', 'selected').change();
                    $("#cat"+json.idCategoria).prop('selected', 'selected').change();
                    // cargamos los datos en vista
                    cargarDatos(json);
                }else{
                    deletePlato(json);
                }
            }
            else
                throw new Error("Plato no encontrado...");
        }, "JSON");
    }catch(err){
        alert(err);
    }
}
// al no estar cargado las unidades, pero sí la categoría en memoria, se precisa pedir las unidades al servidor por ajax
function cargarUnidadesMedida(){
    let unidades = $("#medida").children("option").length;
    if(unidades == 0){
        $.post("/reto3/?c=tipoventa&a=getAll",(res) => {
            res.forEach(function(dato){
                $("#medida").append("<option id='uni" + dato.idTipoVenta + "'>" + dato.tipoVenta + "</option>");
            });
        }, "JSON");
    }
}

function cargarDatos(plato){
    //aseguramos de borrar posibles archivos que se han quedado en el input
    $("#modificarImagen").val("");
    //cargamos los datos de un plato al modal
    $("#imagen").attr("src",plato.imagen);
    $("#nombre").attr("value",plato.nombre);
    $("#descripcion").attr("value",plato.notas);
    $("#precio").attr("value",plato.precio);
    $("#cantidad").attr("value",plato.unidadesMinimas);
    $("#modalModificarPlato").modal();
}

function editPlato(){
    //mandamos el objeto
    let json = null;
    $.post("/reto3/?c=plato&a=editar", {"idPlato": idPlato}, (res) => {
        json = jQuery.parseJSON(res);
    }, "JSON");
    //cerramos modal
    $('#modalModificarPlato').modal('toggle');
}

function deletePlato(plato){
    //abre modal para confirmar la eliminacion de un plato
    $("#atencion").attr("value", plato.idPlato);
    $("#atencion").text("¿Seguro que desea eliminar el plato '" + plato.nombre + "'?");
    $("#modalEliminarPlato").modal();
}

function confirmDeletePlato(){
    //mandamos el id a eliminar
    let idPlato = $("#atencion").attr("value");
    $.post("/reto3/?c=plato&a=delete",{idPlato});
    $('#modalEliminarPlato').modal('toggle');
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
            $("#imagen").attr("src",e.target.result);
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

