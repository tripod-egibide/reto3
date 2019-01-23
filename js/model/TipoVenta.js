class TipoVenta{

    constructor(idTipoVenta, tipoVenta){
        this.tipoVenta - tipoVenta;
        this._idTipoVenta = idTipoVenta;
        this._tipoVenta = tipoVenta;
    }


    get idTipoVenta() {
        return this._idTipoVenta;
    }

    set idTipoVenta(value) {
        this._idTipoVenta = value;
    }

    get tipoVenta() {
        return this._tipoVenta;
    }

    set tipoVenta(value) {
        this._tipoVenta = value;
    }
}