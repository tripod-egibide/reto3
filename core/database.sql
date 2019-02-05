SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `Administrador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Administrador` ;

CREATE TABLE IF NOT EXISTS `Administrador` (
  `idAdministrador` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(16) NOT NULL,
  `contrasenna` VARCHAR(32) NOT NULL,
  `email` VARCHAR(255) NULL,
  PRIMARY KEY (`idAdministrador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Pedido` ;

CREATE TABLE IF NOT EXISTS `Pedido` (
  `idPedido` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(9) NULL,
  `fechaEntrega` DATE NULL,
  `total` DOUBLE NULL,
  `confirmado` BOOLEAN NOT NULL,
  PRIMARY KEY (`idPedido`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Categoria` ;

CREATE TABLE IF NOT EXISTS `Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `emailDepartamento` VARCHAR(255) NOT NULL,
  `preferencia` INT NOT NULL,
  PRIMARY KEY (`idCategoria`),
  CONSTRAINT `uk_nombre_Categoria`
    UNIQUE KEY (`nombre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TipoVenta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `TipoVenta` ;

CREATE TABLE IF NOT EXISTS `TipoVenta` (
  `idTipoVenta` INT NOT NULL AUTO_INCREMENT,
  `tipoVenta` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoVenta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Plato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Plato` ;

CREATE TABLE IF NOT EXISTS `Plato` (
  `idPlato` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `precio` DOUBLE NOT NULL,
  `unidadesMinimas` INT NOT NULL DEFAULT 1,
  `notas` VARCHAR(255) NULL,
  `imagen` VARCHAR(255) NULL,
  `idCategoria` INT NOT NULL,
  `idTipoVenta` INT NOT NULL,
  `estado` BOOLEAN NOT NULL,
  PRIMARY KEY (`idPlato`),
  INDEX `fk_Plato_Categoria_idx` (`idCategoria` ASC),
  INDEX `fk_Plato_tipoVenta_idx` (`idTipoVenta` ASC),
  CONSTRAINT `fk_Plato_Categoria`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Plato_tipoVenta`
    FOREIGN KEY (`idTipoVenta`)
    REFERENCES `TipoVenta` (`idTipoVenta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uk_nombre_Plato`
    UNIQUE KEY (`nombre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DetallePedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DetallePedido` ;

CREATE TABLE IF NOT EXISTS `DetallePedido` (
  `idPedido` INT NOT NULL,
  `idPlato` INT NOT NULL,
  `cantidad` INT NOT NULL,
  PRIMARY KEY (`idPedido`, `idPlato`),
  INDEX `fk_DetallePedido_Plato_idx` (`idPlato` ASC),
  INDEX `fk_DetallePedido_Pedido_idx` (`idPedido` ASC),
  CONSTRAINT `fk_DetallePedido_Pedido`
    FOREIGN KEY (`idPedido`)
    REFERENCES `Pedido` (`idPedido`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_DetallePedido_Plato`
    FOREIGN KEY (`idPlato`)
    REFERENCES `Plato` (`idPlato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
