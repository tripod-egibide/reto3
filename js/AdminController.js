
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
    });
});

$(document).ready(function(){
    // CRUD Admin - Modificar usuario
    $(document).on('click', '.editarAdmin', function(){
        let id=$(this).val();
        let usuario=$('#usuario'+id).text();
        let contrasenna=$('#contrasenna'+id).text();

        $('#editarAdmin').modal('show');
        $('#editarAdminId').val(id);
        $('#editarAdminUsuario').val(usuario);
        $('#editarAdminContrasenna').val(contrasenna);

    });
    // CRUD Categoria - Modificar categoria
    $(document).on('click', '.editarCategoria', function(){
        let id=$(this).val();
        let nombre=$('#nombre'+id).text();
        let emailDepartamento=$('#emailDepartamento'+id).text();

        $('#editarCategoria').modal('show');
        $('#editarCategoriaId').val(id);
        $('#editarCategoriaNombre').val(nombre);
        $('#editarCategoriaEmail').val(emailDepartamento);

    });
    // CRUD Tipo de Venta - Modificar tipo de venta
    $(document).on('click', '.editarTipoVenta', function(){
        let id=$(this).val();
        let tipoVenta=$('#tipoVenta'+id).text();

        $('#editarTipoVenta').modal('show');
        $('#editarTipoVentaId').val(id);
        $('#editarTipoVentaNombre').val(tipoVenta);

    });
});

