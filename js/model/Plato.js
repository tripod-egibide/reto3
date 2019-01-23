class Plato{
    constructor(idPlato, nombre, precio, unidadesMinimas, notas, imagen, categoria, tipoVenta){
        this._idPlato = idPlato;
        this._nombre = nombre;
        this._precio = precio;
        this._unidadesMinimas = unidadesMinimas;
        this._notas = notas;
        this._imagen = imagen;
        this._categoria = categoria;
        this._tipoVenta = tipoVenta;
    }

    get idPlato() {
        return this._idPlato;
    }

    set idPlato(value) {
        this._idPlato = value;
    }

    get nombre() {
        return this._nombre;
    }

    set nombre(value) {
        this._nombre = value;
    }

    get precio() {
        return this._precio;
    }

    set precio(value) {
        this._precio = value;
    }

    get unidadesMinimas() {
        return this._unidadesMinimas;
    }

    set unidadesMinimas(value) {
        this._unidadesMinimas = value;
    }

    get notas() {
        return this._notas;
    }

    set notas(value) {
        this._notas = value;
    }

    get imagen() {
        return this._imagen;
    }

    set imagen(value) {
        this._imagen = value;
    }

    get categoria() {
        return this._categoria;
    }

    set categoria(value) {
        this._categoria = value;
    }

    get tipoVenta() {
        return this._tipoVenta;
    }

    set tipoVenta(value) {
        this._tipoVenta = value;
    }
}