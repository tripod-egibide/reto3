function llamadaAApi() {
    $.post("/reto3/?c=plato&a=editar", idPlato, (res) => {
        console.log(res); //para que veas que es un array con objetos dentro
        tuFuncionAqui(res);
    }, "JSON");
}