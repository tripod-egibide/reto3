
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
