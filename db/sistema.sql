-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-01-2023 a las 18:25:01
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alto_caucho`
--

CREATE TABLE `alto_caucho` (
  `id_alto_caucho` varchar(10) NOT NULL,
  `alto_numero` int NOT NULL,
  `estado_alto_caucho` tinyint NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ancho_caucho`
--

CREATE TABLE `ancho_caucho` (
  `id_ancho_caucho` varchar(10) NOT NULL,
  `ancho_numero` int NOT NULL,
  `estado_ancho_caucho` tinyint NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `identificacion` varchar(10) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `identificacion` varchar(10) NOT NULL,
  `categoria` varchar(200) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `identificacion` varchar(12) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `identificacion` varchar(10) NOT NULL,
  `proveedor` varchar(12) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `id_pedido` varchar(10) NOT NULL,
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_configuracion` varchar(10) NOT NULL,
  `nom_configuracion` varchar(45) NOT NULL,
  `valor_configuracion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `nom_configuracion`, `valor_configuracion`) VALUES
('CONF-00001', 'sistema_nombre', 'DIGENCA'),
('CONF-00002', 'moneda_principal', ''),
('CONF-00003', 'moneda_nacional', ''),
('CONF-00004', 'empresa_nombre', 'DIGENCA'),
('CONF-00005', 'empresa_rif', 'J-435435654'),
('CONF-00006', 'empresa_direccion', 'Av. Venezuela con calle 37'),
('CONF-00007', 'empresa_telefono', '02515467466');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `producto` varchar(10) NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `compra` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `cod_producto` varchar(10) NOT NULL,
  `cant_producto` int NOT NULL,
  `precio_producto` decimal(13,2) NOT NULL,
  `id_pedido` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `producto` varchar(10) NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `venta` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `identificacion` varchar(10) NOT NULL,
  `impuesto` varchar(50) NOT NULL,
  `porcentaje` int NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `identificacion` varchar(10) NOT NULL,
  `marca` varchar(200) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodo_pago` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado_metodo_pago` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `identificacion` varchar(10) NOT NULL,
  `moneda` varchar(50) NOT NULL,
  `simbolo` varchar(5) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` varchar(10) NOT NULL,
  `ci_rif_proveedor` varchar(11) NOT NULL,
  `ci_usuario` varchar(8) NOT NULL,
  `id_tipo_documento` varchar(10) NOT NULL,
  `id_moneda` varchar(10) NOT NULL,
  `estado_pedido` int NOT NULL DEFAULT '2',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_monedas`
--

CREATE TABLE `precio_monedas` (
  `identificacion` varchar(10) NOT NULL,
  `moneda_principal` varchar(10) NOT NULL,
  `moneda_secundaria` varchar(10) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegios`
--

CREATE TABLE `privilegios` (
  `identificacion` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `privilegios`
--

INSERT INTO `privilegios` (`identificacion`, `nombre`, `estado`, `actualizado_en`, `creado_en`) VALUES
(1, 'Administrador', 1, '2022-11-01 00:54:58', '2022-11-01 00:52:51'),
(2, 'Vendedor', 1, '2022-11-01 00:57:15', '2022-11-01 00:57:15'),
(3, 'Almacenista', 1, '2022-11-01 00:58:41', '2022-11-01 00:57:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_ancho_caucho` varchar(10) NOT NULL,
  `id_alto_caucho` varchar(10) NOT NULL,
  `marca` varchar(10) NOT NULL,
  `categoria` varchar(10) NOT NULL,
  `precio` decimal(13,2) NOT NULL,
  `cant_producto` int NOT NULL DEFAULT '0',
  `stock_maximo` int NOT NULL,
  `stock_minimo` int NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_proveedor`
--

CREATE TABLE `producto_proveedor` (
  `ci_rif_proveedor` varchar(12) NOT NULL,
  `cod_producto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `identificacion` varchar(12) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `identificacion` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `identificacion` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` text NOT NULL,
  `privilegio` int NOT NULL,
  `foto` text,
  `ultima_sesion` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`identificacion`, `nombre`, `clave`, `privilegio`, `foto`, `ultima_sesion`, `estado`, `actualizado_en`, `creado_en`) VALUES
('10000000', 'Administrador', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 1, '', '0000-00-00 00:00:00', 1, '2023-01-01 18:14:58', '2022-10-27 20:28:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `identificacion` varchar(10) NOT NULL,
  `cliente` varchar(12) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `tipo_documento` varchar(10) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `tasa` decimal(10,2) NOT NULL,
  `impuesto` varchar(10) NOT NULL,
  `id_metodo_pago` varchar(10) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `actualizado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alto_caucho`
--
ALTER TABLE `alto_caucho`
  ADD PRIMARY KEY (`id_alto_caucho`);

--
-- Indices de la tabla `ancho_caucho`
--
ALTER TABLE `ancho_caucho`
  ADD PRIMARY KEY (`id_ancho_caucho`);

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`identificacion`),
  ADD KEY `audit_fk_1` (`usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`identificacion`),
  ADD KEY `purchases_ibfk_3` (`moneda`),
  ADD KEY `purchases_fk_1` (`proveedor`),
  ADD KEY `purchases_fk_2` (`usuario`),
  ADD KEY `purchases_fk_3` (`tipo_documento`),
  ADD KEY `purchases_fk_5` (`id_pedido`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD KEY `purchase_details_ibfk_2` (`compra`),
  ADD KEY `purchase_details_ibfk_1` (`producto`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD KEY `detalle_pedido_fk_1` (`cod_producto`),
  ADD KEY `detalle_pedido_fk_2` (`id_pedido`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD KEY `sales_details_ibfk_2` (`venta`),
  ADD KEY `sales_details_ibfk_1` (`producto`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodo_pago`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `pedido_fk_1` (`ci_rif_proveedor`),
  ADD KEY `pedido_fk_2` (`ci_usuario`),
  ADD KEY `pedido_fk_4` (`id_moneda`),
  ADD KEY `pedido_fk_3` (`id_tipo_documento`);

--
-- Indices de la tabla `precio_monedas`
--
ALTER TABLE `precio_monedas`
  ADD PRIMARY KEY (`identificacion`),
  ADD KEY `coin_prices_ibfk_1` (`moneda_principal`),
  ADD KEY `coin_prices_ibfk_2` (`moneda_secundaria`);

--
-- Indices de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `brand` (`marca`),
  ADD KEY `category` (`categoria`),
  ADD KEY `products_fk_3` (`id_ancho_caucho`),
  ADD KEY `products_fk_4` (`id_alto_caucho`);

--
-- Indices de la tabla `producto_proveedor`
--
ALTER TABLE `producto_proveedor`
  ADD KEY `producto_proveedor_fk_1` (`ci_rif_proveedor`),
  ADD KEY `producto_proveedor_fk_2` (`cod_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`identificacion`),
  ADD KEY `users_fk_1` (`privilegio`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`identificacion`),
  ADD KEY `sales_fk_1` (`cliente`),
  ADD KEY `sales_fk_2` (`usuario`),
  ADD KEY `sales_fk_3` (`tipo_documento`),
  ADD KEY `sales_fk_4` (`moneda`),
  ADD KEY `sales_fk_5` (`impuesto`),
  ADD KEY `sales_fk_6` (`id_metodo_pago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `identificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `audit_fk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`identificacion`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `purchases_fk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedores` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchases_fk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`identificacion`),
  ADD CONSTRAINT `purchases_fk_3` FOREIGN KEY (`tipo_documento`) REFERENCES `tipo_documento` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchases_fk_4` FOREIGN KEY (`moneda`) REFERENCES `monedas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchases_fk_5` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `purchase_details_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchase_details_ibfk_2` FOREIGN KEY (`compra`) REFERENCES `compras` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_fk_1` FOREIGN KEY (`cod_producto`) REFERENCES `productos` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detalle_pedido_fk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sales_details_ibfk_2` FOREIGN KEY (`venta`) REFERENCES `ventas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_fk_1` FOREIGN KEY (`ci_rif_proveedor`) REFERENCES `proveedores` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pedido_fk_2` FOREIGN KEY (`ci_usuario`) REFERENCES `usuarios` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pedido_fk_3` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pedido_fk_4` FOREIGN KEY (`id_moneda`) REFERENCES `monedas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `precio_monedas`
--
ALTER TABLE `precio_monedas`
  ADD CONSTRAINT `coin_prices_fk_1` FOREIGN KEY (`moneda_principal`) REFERENCES `monedas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coin_prices_fk_2` FOREIGN KEY (`moneda_secundaria`) REFERENCES `monedas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `products_fk_1` FOREIGN KEY (`marca`) REFERENCES `marcas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `products_fk_2` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `products_fk_3` FOREIGN KEY (`id_ancho_caucho`) REFERENCES `ancho_caucho` (`id_ancho_caucho`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `products_fk_4` FOREIGN KEY (`id_alto_caucho`) REFERENCES `alto_caucho` (`id_alto_caucho`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `producto_proveedor`
--
ALTER TABLE `producto_proveedor`
  ADD CONSTRAINT `producto_proveedor_fk_1` FOREIGN KEY (`ci_rif_proveedor`) REFERENCES `proveedores` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `producto_proveedor_fk_2` FOREIGN KEY (`cod_producto`) REFERENCES `productos` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `users_fk_1` FOREIGN KEY (`privilegio`) REFERENCES `privilegios` (`identificacion`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `sales_fk_1` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`identificacion`),
  ADD CONSTRAINT `sales_fk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`identificacion`),
  ADD CONSTRAINT `sales_fk_3` FOREIGN KEY (`tipo_documento`) REFERENCES `tipo_documento` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sales_fk_4` FOREIGN KEY (`moneda`) REFERENCES `monedas` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sales_fk_5` FOREIGN KEY (`impuesto`) REFERENCES `impuestos` (`identificacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sales_fk_6` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
