class Categoria{
    constructor(idCategoria, nombre, emailDepartamento, orden){
        this._idCategoria = idCategoria;
        this._nombre = nombre;
        this._emailDepartamento = emailDepartamento;
        this._orden = orden;
    }


    get idCategoria() {
        return this._idCategoria;
    }

    set idCategoria(value) {
        this._idCategoria = value;
    }

    get nombre() {
        return this._nombre;
    }

    set nombre(value) {
        this._nombre = value;
    }

    get emailDepartamento() {
        return this._emailDepartamento;
    }

    set emailDepartamento(value) {
        this._emailDepartamento = value;
    }

    get orden() {
        return this._orden;
    }

    set orden(value) {
        this._orden = value;
    }
}