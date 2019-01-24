
// CRUD PLATO --------------------------------------------------------------------------------------------------------->

var plato;

$(document).ready(function(){
    habilitarBotones();
});

function habilitarBotones(){
    //editar plato con modal
    $(".botonEditar").click(function (){
        readPlato($(this).val());
        cargarDatos();
    });
    $("#modificarPlato").click(function(){
        editPlato();
    });
    //eliminar un plato
    $(".botonEliminar").click(function (){
        readPlato($(this).val());
        deletePlato();
    });
    $("#eliminarPlato").click(function(){
        confirmDeletePlato();
    });
}

function readPlato(idPlato) {
    try{
        let json = null;
        $.post("/reto3/?c=plato&a=editar", {"idPlato": idPlato}, (res) => {
            json = jQuery.parseJSON(res);
        }, "JSON");
        if(plato!=null)
            plato = new Plato(json.idPlato, json.nombre, json.precio, json.unidadesMinimas, json.notas, json.imagen);
        else
            throw new Error("Plato no encontrado...");
    }catch(err){
        alert(err);
    }
}

function cargarDatos(){
    $("#imagen").attr("src",plato.imagen);
    $("#nombre").attr("value",plato.nombre);
    $("#descripcion").attr("value",plato.descripcion);
    $("#precio").attr("value",plato.precio);
    $("#cantidad").attr("value",plato.cantidad);
    $("#modalModificarPlato").modal();
}

function editPlato(){
    $.post("reto3/?c=plato;a=eliminar",{idPlato});

    $('#modalModificarPlato').modal('toggle');
}

function deletePlato(){
    $("#atencion").attr("value","¿Seguro que desea eliminar el plato '" + plato.nombre + "'?");
    $("#modalEliminarPlato").modal();
}

function confirmDeletePlato(){
    $.post("reto3/?c=plato;a=eliminar",{idPlato});
    $('#modalEliminarPlato').modal('toggle');
}

// FIN CRUD PLATO <-----------------------------------------------------------------------------------------------------

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