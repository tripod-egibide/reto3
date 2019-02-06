-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2019 a las 10:39:48
-- Versión del servidor: 10.1.33-MariaDB
-- Versión de PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reto3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idAdministrador` int(11) NOT NULL,
  `usuario` varchar(16) NOT NULL,
  `contrasenna` varchar(32) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idAdministrador`, `usuario`, `contrasenna`, `email`) VALUES
(1, 'admin1', 'admin1', 'mygoldxp@msn.com'),
(2, 'admin2', 'admin2', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `emailDepartamento` varchar(255) NOT NULL,
  `preferencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`, `emailDepartamento`, `preferencia`) VALUES
(1, 'Entrantes', 'mygoldxp@msn.com', 1),
(2, 'Pescados', 'mygoldxp@msn.com', 2),
(3, 'Postres', 'mygoldxp@msn.com', 10),
(4, 'Ensaladas', 'mygoldxp@msn.com', 4),
(5, 'Semifrios', 'mygoldxp@msn.com', 5),
(6, 'Tartas de bizcocho', 'mygoldxp@msn.com', 6),
(7, 'Tartas de hojaldre', 'mygoldxp@msn.com', 7),
(8, 'Tartas variadas', 'mygoldxp@msn.com', 8),
(9, 'Variedades', 'mygoldxp@msn.com', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idPedido` int(11) NOT NULL,
  `idPlato` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`idPedido`, `idPlato`, `cantidad`) VALUES
(1, 1, 4),
(1, 2, 6),
(1, 6, 2),
(2, 1, 5),
(2, 2, 5),
(2, 3, 7),
(2, 4, 5),
(2, 5, 6),
(2, 6, 2),
(3, 3, 3),
(3, 4, 7),
(3, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `total` double DEFAULT NULL,
  `confirmado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idPedido`, `nombre`, `apellidos`, `email`, `telefono`, `fechaEntrega`, `total`, `confirmado`) VALUES
(1, 'Sebas', 'Zawisza', 'sebas@sebas.com', '666666666', '2019-01-31', 150, 0),
(2, 'Jon', 'Xu Jin', 'v622277733@hotmail.com', '999999999', '2019-02-07', 200.5, 0),
(3, 'Imanol Luis', 'Hidalgo', 'imanol@imanol.com', '88888888', '2019-02-07', 105, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato`
--

CREATE TABLE `plato` (
  `idPlato` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` double NOT NULL,
  `unidadesMinimas` int(11) NOT NULL DEFAULT '1',
  `notas` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `idCategoria` int(11) NOT NULL,
  `idTipoVenta` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `plato`
--

INSERT INTO `plato` (`idPlato`, `nombre`, `precio`, `unidadesMinimas`, `notas`, `imagen`, `idCategoria`, `idTipoVenta`, `estado`) VALUES
(1, 'Setas a la plancha', 5, 1, 'Alérgenos Hongos', 'http://4.bp.blogspot.com/_iQCEs3lfzVQ/SOEa1YmXjoI/AAAAAAAAAF8/CvcPgjfz1a4/w1200-h630-p-k-no-nu/setasplancha+(2).JPG', 4, 2, 1),
(2, 'Entrecot con patatas', 15, 1, 'No apto para vegetarianos', 'https://www.hogarmania.com/archivos/201105/0692-entrecote-de-bistrot-xl-668x400x80xX.jpg', 1, 1, 1),
(3, 'Merluza al vapor', 10, 2, 'Alto omega3', 'https://www.hogarmania.com/archivos/201404/1443-merluza-al-vapor-con-vinagreta-de-tomate-y-aceite-de-trufa-blanca-627-xl-668x400x80xX.jpg', 2, 1, 1),
(4, 'Tarta de queso', 3, 4, 'Alto contenido de lactosa', 'https://unareceta.com/wp-content/uploads/2017/02/tarta-de-queso-sin-horno-facil-640x428.jpg', 3, 2, 1),
(5, 'Salmón con especias', 15, 2, 'No apto para alérgicos a los pescados', 'https://www.canalcocina.es/medias/images/1605CocinaDeFamiliaT4SalmonMarinadoSalsaMostaza2.jpg', 2, 1, 1),
(6, 'Paella tradicional', 5, 5, 'Contiene crustacios', 'http://recetaspaella.es/img/paella-mixta-665.jpg', 1, 1, 1),
(127, 'Croquetas de hongos', 5, 2, 'Ración 12 unidades', 'img/plato/croquetas-de-hongos.jpg', 1, 1, 1),
(128, 'Croquetas de jamón ibérico', 5, 2, 'Ración 12 unidades', 'img/plato/croquetas-de-jamon-iberico.jpg', 1, 1, 1),
(129, 'Tigres (mejillones rellenos)', 5.3, 2, 'Ración 12 unidades', 'img/plato/tigres.jpg', 1, 1, 1),
(130, 'Escalibada de verduras con ventresca de atún', 6.4, 2, '', 'img/plato/escalivada-con-ventresca-de-atun.jpg', 2, 1, 1),
(131, 'Ensalada César con virutas de pavo braseado', 3.5, 2, '', 'img/plato/ensalada-cesar-con-virutas-de-pavo-braseado.jpg', 2, 1, 1),
(132, 'Canelones rellenos de espinacas y hongos', 3.75, 2, '', 'img/plato/canelones-rellenos-de-espinacas-y-hongos.jpg', 2, 1, 1),
(133, 'Pencas de acelga rellenas de jamón y queso', 4.2, 2, '', 'img/plato/pencas-de-acelga-rellenas-de-jamon-y-queso.jpg', 2, 1, 1),
(134, 'Piquillos rellenos de merluza y gambas', 4.8, 2, '', 'img/plato/piquillos-rellenos-de-merluza-y-gambas.jpg', 3, 1, 1),
(135, 'Bacalao a la vizcaína', 8, 2, '', 'img/plato/bacalao-a-la-vizcaina.jpg', 3, 1, 1),
(136, 'Chipirones en su tinta', 6, 2, '', 'img/plato/chipirones-en-su-tinta.jpg', 3, 1, 1),
(137, 'Kokotxas de bacalao con gulas', 10.5, 2, '', 'img/plato/kokotxas-de-bacalao-con-gulas.jpg', 3, 1, 1),
(138, 'Albóndigas de pollo en salsa verde', 4.5, 2, '', 'img/plato/albondigas-de-pollo-en-salsa-verde.jpg', 4, 1, 1),
(139, 'Carrilleras ibéricas al Rioja Alavesa', 6, 2, '', 'img/plato/carrilleras-ibericas-al-rioja-alavesa.jpg', 4, 1, 1),
(140, 'Lengua rellena de Idiazabal y salsa agridulce', 4.7, 2, '', 'img/plato/lengua-rellena-de-idiazabal-y-salsa-agridulce.jpg', 4, 1, 1),
(141, 'Callos de ternera en salsa vizcaína', 4.7, 2, '', 'img/plato/callos-de-ternera-en-salsa-vizcaina.jpg', 4, 1, 1),
(142, 'Delicia de arroz y canela', 12, 1, '', 'img/plato/delicia-de-arroz-y-canela.jpg', 5, 2, 1),
(143, 'Mousse de chocolate', 13, 1, '', 'img/plato/mousse-de-chocolate.jpg', 5, 2, 1),
(146, 'Mousse de queso y frambuesa', 13, 1, '', 'img/plato/mousse-de-queso-y-frambuesa.jpg', 5, 2, 0),
(147, 'Delicia de yogur y chocolate blanco', 13, 1, '', 'img/plato/delicia-de-yogur-y-chocolate-blanco.jpg', 5, 2, 1),
(148, 'Tiramisú', 13, 1, '', 'img/plato/tiramisu.jpg', 5, 2, 1),
(149, 'Brazo de gitano de chocolate', 13, 1, '', 'img/plato/brazo-de-gitano-de-chocolate.jpg', 6, 2, 1),
(150, 'Brazo de gitano de yema', 13, 1, '', 'img/plato/brazo-de-gitano-de-yema.jpg', 6, 2, 1),
(151, 'Brazo de gitano de nata', 13, 1, '', 'img/plato/brazo-de-gitano-de-nata.jpg', 6, 2, 1),
(152, 'Brazo de gitano de crema', 13, 1, '', 'img/plato/brazo-de-gitano-de-crema.jpg', 6, 2, 1),
(153, 'Tarta San Marcos: yema', 13, 1, '', 'img/plato/tarta-san-marcos-yema.jpg', 6, 2, 1),
(154, 'Tarta Moka: mantequilla', 13, 1, '', 'img/plato/tarta moka-mantequilla.jpg', 6, 2, 1),
(155, 'Tarta Mascota: almendra', 13, 1, '', 'img/plato/tarta-mascota-almendra.JPG', 6, 2, 1),
(156, 'Tarta Imperial: merengue', 13, 1, '', 'img/plato/tarta-imperial-merengue.jpg', 6, 2, 1),
(157, 'Tarta Selva Negra: chocolate', 13, 1, '', 'img/plato/tarta-selva-negra-chocolate.jpg', 6, 2, 1),
(158, 'Milhojas de nata', 15, 1, '', 'img/plato/milhojas-de-nata.jpg', 7, 2, 1),
(159, 'Milhojas de crema', 15, 1, '', 'img/plato/milhojas-de-crema.jpg', 7, 2, 1),
(160, 'Tarta Gasteiz', 15, 1, '', 'img/plato/tarta-gasteiz.jpg', 7, 2, 1),
(161, 'Banda de manzana', 12, 1, '', 'img/plato/banda-de-manzana.jpg', 7, 2, 1),
(162, 'Banda de frutas rojas', 12, 1, '', 'img/plato/banda-de-frutas-rojas.jpg', 7, 2, 1),
(163, 'Banda de frutos secos', 12, 1, '', 'img/plato/banda-de-frutos-secos.jpg', 7, 2, 1),
(164, 'Tarta de manzana', 10, 1, '', 'img/plato/tarta-de-manzana.jpg', 8, 2, 1),
(165, 'Quiché de frutas variadas', 10, 1, '', 'img/plato/quiche-de-frutas-variadas.jpg', 8, 2, 1),
(166, 'Tatin de pera o manzana', 10, 1, '', 'img/plato/tatin-de-pera-o-manzana.jpg', 8, 2, 1),
(167, 'Pastel vasco', 10, 1, '', 'img/plato/pastel-vasco.jpg', 8, 2, 1),
(168, 'Tarta de queso cocida', 10, 1, '', 'img/plato/tarta-de-queso-cocida.jpg', 8, 2, 1),
(169, 'Tarta Santiago', 10, 1, '', 'img/plato/tarta-santiago.jpg', 8, 2, 1),
(170, 'Pastas', 15, 1, 'Cajas de 600 gramos', 'img/plato/pastas.jpg', 9, 2, 1),
(171, 'Galletas cookies', 13, 1, '', 'img/plato/galletas-cookies.jpg', 9, 2, 1),
(172, 'Polvorones', 13, 1, '', 'img/plato/polvorones.jpg', 9, 2, 1),
(173, 'Trufas', 25, 1, '', 'img/plato/trufas.JPG', 9, 2, 1),
(174, 'Plum cake de frutas', 11, 1, '8 raciones', 'img/plato/plum-cake-de-frutas.jpg', 9, 2, 1),
(175, 'Plum cake con perlitas de chocolate', 11, 1, '8 raciones', 'img/plato/plum-cake-con-perlitas-de-chocolate.jpg', 9, 2, 1),
(176, 'Bizcocho de nata', 11, 1, '', 'img/plato/bizcocho-de-nata.jpg', 9, 2, 1),
(177, 'Brownie', 11, 1, '', 'img/plato/brownie.jpg', 9, 2, 1),
(178, 'Goxua', 2, 6, '', 'img/plato/goxua.jpg', 9, 3, 1),
(179, 'Arroz con leche', 1.5, 6, '', 'img/plato/arroz-con-leche.jpg', 9, 3, 1),
(180, 'Natillas a la casera', 1.5, 6, '', 'img/plato/natillas-a-la-casera.jpg', 9, 3, 1),
(181, 'Flan de queso', 1.5, 6, '', 'img/plato/flan-de-queso.jpg', 9, 3, 1),
(182, 'Flan de huevo', 1.5, 6, '', 'img/plato/flan-de-huevo.jpg', 9, 3, 1),
(183, 'Canutillos rellenos', 10, 1, '', 'img/plato/canutillos-rellenos.jpg', 9, 2, 1),
(184, 'Crema frita', 10, 1, '', 'img/plato/crema-frita.jpg', 9, 2, 1),
(185, 'Torrijas', 10, 1, '', 'img/plato/torrijas.jpg', 9, 2, 1),
(186, 'Petit choux de nata y chocolate', 10, 1, '', 'img/plato/petit-choux-de-nata-y-chocolate.jpg', 9, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoventa`
--

CREATE TABLE `tipoventa` (
  `idTipoVenta` int(11) NOT NULL,
  `tipoVenta` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoventa`
--

INSERT INTO `tipoventa` (`idTipoVenta`, `tipoVenta`) VALUES
(1, 'kilos'),
(2, 'raciones'),
(3, 'magico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdministrador`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`),
  ADD UNIQUE KEY `uk_nombre_Categoria` (`nombre`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`idPedido`,`idPlato`),
  ADD KEY `fk_DetallePedido_Plato_idx` (`idPlato`),
  ADD KEY `fk_DetallePedido_Pedido_idx` (`idPedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `plato`
--
ALTER TABLE `plato`
  ADD PRIMARY KEY (`idPlato`),
  ADD UNIQUE KEY `uk_nombre_Plato` (`nombre`),
  ADD KEY `fk_Plato_Categoria_idx` (`idCategoria`),
  ADD KEY `fk_Plato_tipoVenta_idx` (`idTipoVenta`);

--
-- Indices de la tabla `tipoventa`
--
ALTER TABLE `tipoventa`
  ADD PRIMARY KEY (`idTipoVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdministrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `plato`
--
ALTER TABLE `plato`
  MODIFY `idPlato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT de la tabla `tipoventa`
--
ALTER TABLE `tipoventa`
  MODIFY `idTipoVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `fk_DetallePedido_Pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_DetallePedido_Plato` FOREIGN KEY (`idPlato`) REFERENCES `plato` (`idPlato`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `plato`
--
ALTER TABLE `plato`
  ADD CONSTRAINT `fk_Plato_Categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Plato_tipoVenta` FOREIGN KEY (`idTipoVenta`) REFERENCES `tipoventa` (`idTipoVenta`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
