
// CRUD PLATO --------------------------------------------------------------------------------------------------------->

var plato = null;

$(document).ready(function(){
    habilitarBotones();
});

function habilitarBotones(){
    //editar plato con modal
    $(".botonEditar").click(function (){
        readPlato($(this).val());
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
    // leemos los datos del plato por su id
    try{
        // comprobamos si existe las unidades de medida, en caso contrario lo cargamos
        cargarUnidadesMedida();
        // buscamos el plato
        let json = null;
        $.post("/reto3/?c=plato&a=findById", {"idPlato": idPlato}, (res) => {
            json = res[0];
            if(json!=null){
                plato = new Plato(json.idPlato, json.nombre, json.precio, json.unidadesMinimas, json.notas, json.imagen);
                $("#uni"+json.idTipoVenta).prop('selected', 'selected').change();
                $("#cat"+json.idCategoria).prop('selected', 'selected').change();
            }
            else
                throw new Error("Plato no encontrado...");
            // cargamos los datos en vista
            cargarDatos();
        }, "JSON");
    }catch(err){
        alert(err);
    }
}

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



function cargarDatos(){
    //cargamos los datos de un plato al modal
    $("#imagen").attr("src",plato.imagen);
    $("#nombre").attr("value",plato.nombre);
    $("#descripcion").attr("value",plato.descripcion);
    $("#precio").attr("value",plato.precio);
    $("#cantidad").attr("value",plato.cantidad);
    $("#modalModificarPlato").modal();
}

function editPlato(){
    //rellenamos con los nuevos datos del form
    plato = new Plato();
    //mandamos el objeto
    let json = null;
    $.post("/reto3/?c=plato&a=editar", {"idPlato": idPlato}, (res) => {
        json = jQuery.parseJSON(res);
    }, "JSON");
    //cerramos modal
    $('#modalModificarPlato').modal('toggle');
}

function deletePlato(){
    //abre modal para confirmar la eliminacion de un plato
    $("#atencion").attr("value","¿Seguro que desea eliminar el plato '" + plato.nombre + "'?");
    $("#modalEliminarPlato").modal();
}

function confirmDeletePlato(){
    //mandamos el id a eliminar
    $.post("reto3/?c=plato;a=eliminar",{idPlato});
    $('#modalEliminarPlato').modal('toggle');
}

// FIN CRUD PLATO <-----------------------------------------------------------------------------------------------------
