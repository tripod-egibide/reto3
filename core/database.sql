SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema EgibideHosteleriaPedidos
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `EgibideHosteleriaPedidos` ;

-- -----------------------------------------------------
-- Schema EgibideHosteleriaPedidos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `EgibideHosteleriaPedidos` DEFAULT CHARACTER SET utf8 ;
USE `EgibideHosteleriaPedidos` ;

-- -----------------------------------------------------
-- Table `EgibideHosteleriaPedidos`.`Administrador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `EgibideHosteleriaPedidos`.`Administrador` ;

CREATE TABLE IF NOT EXISTS `EgibideHosteleriaPedidos`.`Administrador` (
  `idAdministrador` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(16) NOT NULL,
  `contraseña` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`idAdministrador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EgibideHosteleriaPedidos`.`Pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `EgibideHosteleriaPedidos`.`Pedido` ;

CREATE TABLE IF NOT EXISTS `EgibideHosteleriaPedidos`.`Pedido` (
  `idPedido` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(9) NULL,
  `fechaEntrega` DATE NULL,
  PRIMARY KEY (`idPedido`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EgibideHosteleriaPedidos`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `EgibideHosteleriaPedidos`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `EgibideHosteleriaPedidos`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `emailDepartamento` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EgibideHosteleriaPedidos`.`TipoVenta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `EgibideHosteleriaPedidos`.`TipoVenta` ;

CREATE TABLE IF NOT EXISTS `EgibideHosteleriaPedidos`.`TipoVenta` (
  `idTipoVenta` INT NOT NULL AUTO_INCREMENT,
  `tipoVenta` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoVenta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EgibideHosteleriaPedidos`.`Plato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `EgibideHosteleriaPedidos`.`Plato` ;

CREATE TABLE IF NOT EXISTS `EgibideHosteleriaPedidos`.`Plato` (
  `idPlato` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `precio` INT NOT NULL,
  `unidadesMinimas` INT NOT NULL DEFAULT 1,
  `notas` VARCHAR(255) NULL,
  `imagen` VARCHAR(45) NULL,
  `idCategoria` INT NOT NULL,
  `idtipoVenta` INT NOT NULL,
  PRIMARY KEY (`idPlato`),
  INDEX `fk_Plato_Categoria_idx` (`idCategoria` ASC),
  INDEX `fk_Plato_tipoVenta_idx` (`idtipoVenta` ASC),
  CONSTRAINT `fk_Plato_Categoria`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `EgibideHosteleriaPedidos`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Plato_tipoVenta`
    FOREIGN KEY (`idtipoVenta`)
    REFERENCES `EgibideHosteleriaPedidos`.`TipoVenta` (`idTipoVenta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EgibideHosteleriaPedidos`.`DetallePedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `EgibideHosteleriaPedidos`.`DetallePedido` ;

CREATE TABLE IF NOT EXISTS `EgibideHosteleriaPedidos`.`DetallePedido` (
  `idPedido` INT NOT NULL,
  `idPlato` INT NOT NULL,
  PRIMARY KEY (`idPedido`, `idPlato`),
  INDEX `fk_DetallePedido_Plato_idx` (`idPlato` ASC),
  INDEX `fk_DetallePedido_Pedido_idx` (`idPedido` ASC),
  CONSTRAINT `fk_DetallePedido_Pedido`
    FOREIGN KEY (`idPedido`)
    REFERENCES `EgibideHosteleriaPedidos`.`Pedido` (`idPedido`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_DetallePedido_Plato`
    FOREIGN KEY (`idPlato`)
    REFERENCES `EgibideHosteleriaPedidos`.`Plato` (`idPlato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;