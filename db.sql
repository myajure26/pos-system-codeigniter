-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-10-2022 a las 20:19:20
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
-- Base de datos: `pos_system`
--
CREATE DATABASE IF NOT EXISTS `pos_system` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci;
USE `pos_system`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audits`
--

CREATE TABLE `audits` (
  `id` int NOT NULL,
  `user` int NOT NULL,
  `module` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `action` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `audits`
--

INSERT INTO `audits` (`id`, `user`, `module`, `action`, `description`, `created_at`) VALUES
(1, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-10-14 17:52:21'),
(2, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-10-14 18:44:09'),
(3, 2, 'Compras', 'Crear compra', 'Se ha creado la compra con ID #1 exitosamente.', '2022-10-14 18:49:37'),
(4, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #2 exitosamente.', '2022-10-14 18:58:34'),
(5, 2, 'Clientes', 'Crear proveedor', 'Se ha creado al proveedor con ID #6 exitosamente.', '2022-10-14 19:40:10'),
(6, 2, 'Proveedores', 'Eliminar proveedor', 'Se ha eliminado al proveedor con ID #6 exitosamente.', '2022-10-14 19:41:34'),
(7, 2, 'Clientes', 'Crear cliente', 'Se ha creado al cliente con ID #1 exitosamente.', '2022-10-14 19:42:17'),
(8, 2, 'Clientes', 'Crear cliente', 'Se ha creado al cliente con ID #1 exitosamente.', '2022-10-14 19:47:14'),
(9, 2, 'Clientes', 'Actualizar cliente', 'Se ha actualizado al cliente con ID #1 exitosamente.', '2022-10-14 20:17:31'),
(10, 2, 'Clientes', 'Actualizar cliente', 'Se ha actualizado al cliente con ID #1 exitosamente.', '2022-10-14 20:17:41'),
(11, 2, 'Clientes', 'Crear cliente', 'Se ha creado al cliente con ID #2 exitosamente.', '2022-10-14 20:18:07'),
(12, 2, 'Clientes', 'Eliminar cliente', 'Se ha eliminado al cliente con ID #2 exitosamente.', '2022-10-14 20:18:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `brand` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `brands`
--

INSERT INTO `brands` (`id`, `brand`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Firestone', '2022-09-26 21:26:45', NULL, '2022-09-11 21:44:08'),
(2, 'Pirelli', '2022-10-14 17:58:34', NULL, '2022-09-11 21:44:19'),
(3, 'Fire', '2022-09-12 23:14:28', '2022-09-12 23:14:28', '2022-09-12 01:17:35'),
(4, 'Cauchos', '2022-09-14 21:36:41', '2022-09-14 21:36:41', '2022-09-14 21:35:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `category`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Camiones', '2022-09-12 22:46:07', NULL, '2022-09-11 17:25:19'),
(2, 'Cauchos de invierno', '2022-09-14 21:24:56', '2022-09-14 21:24:56', '2022-09-11 17:28:40'),
(3, 'Cauchos de verano', '2022-09-12 02:05:48', '2022-09-12 02:05:48', '2022-09-11 17:29:52'),
(4, 'Carros', '2022-09-11 19:05:23', '2022-09-11 19:05:23', '2022-09-11 18:55:43'),
(5, 'Cauchos de otoño', '2022-09-14 21:25:20', NULL, '2022-09-14 21:25:20'),
(6, 'Caucho rin 17', '2022-09-26 21:39:02', NULL, '2022-09-18 19:16:26'),
(7, 'Cauchos caros', '2022-10-07 00:39:46', '2022-10-07 00:39:46', '2022-10-07 00:39:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coins`
--

CREATE TABLE `coins` (
  `id` int NOT NULL,
  `coin` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `symbol` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `coins`
--

INSERT INTO `coins` (`id`, `coin`, `symbol`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Dólar', '$', '2022-09-14 20:24:37', NULL, '2022-09-14 20:08:40'),
(2, 'Bolívar Digital', 'Bsd.', '2022-09-26 21:21:06', NULL, '2022-09-14 20:09:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coin_prices`
--

CREATE TABLE `coin_prices` (
  `id` int NOT NULL,
  `primary_coin` int NOT NULL,
  `secondary_coin` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `identification` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `address` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb3_spanish_ci NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `name`, `identification`, `address`, `phone`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Mariangel Yajure', 'V-28454829', 'Las tunitas', '04121538387', '2022-10-14 19:17:41', NULL, '2022-10-14 18:47:14'),
(2, 'Francisco', 'V-28454123', 'Marte', '04245458695', '2022-10-14 19:18:12', '2022-10-14 19:18:12', '2022-10-14 19:18:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory`
--

CREATE TABLE `inventory` (
  `id` int NOT NULL,
  `product` int NOT NULL,
  `quantity` int NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `brand` int NOT NULL,
  `category` int NOT NULL,
  `coin` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `tax` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `brand`, `category`, `coin`, `price`, `tax`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'C100', 'Caucho algo', 1, 6, 1, '15000.00', 3, '2022-09-28 20:27:06', NULL, '2022-09-18 19:19:06'),
(2, 'C101', 'Cauchos de verano', 1, 1, 1, '1.00', 3, '2022-09-18 19:20:05', NULL, '2022-09-18 19:20:05'),
(3, 'C102', 'Caucho otro', 1, 5, 1, '13.00', 3, '2022-09-18 20:43:42', '2022-09-18 20:43:42', '2022-09-18 19:32:01'),
(4, 'C200', 'Caucho ', 1, 1, 1, '320.00', 3, '2022-09-18 20:41:51', NULL, '2022-09-18 19:33:02'),
(5, 'C201', 'Cauchitos', 1, 5, 1, '120.00', 3, '2022-10-07 00:38:23', '2022-10-07 00:38:23', '2022-09-18 19:36:03'),
(6, 'C205', 'Producto', 1, 1, 1, '324.53', 3, '2022-09-27 21:41:36', '2022-09-27 21:41:27', '2022-09-27 01:17:26'),
(7, 'C105', 'Cauchitos', 1, 1, 1, '100.00', 3, '2022-10-07 00:41:59', NULL, '2022-10-07 00:41:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `id` int NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `rif` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`id`, `code`, `name`, `rif`, `address`, `phone`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'A-001', 'Javier Alvarez', 'V-284558290', 'Las tunitas', '04245118022', '2022-10-06 01:28:56', NULL, '2022-09-21 23:21:28'),
(2, 'A-002', 'Ana González', 'V-284548290', 'Las tunitas', '04245118022', '2022-10-06 01:28:41', NULL, '2022-09-21 23:30:10'),
(3, 'C200', 'Mariangel Yajure', 'J-284544829', 'Las tunitas', '04245118022', '2022-09-26 15:14:25', '2022-09-26 15:14:25', '2022-09-26 01:13:04'),
(4, 'A-003', 'Mariangel Yajure', 'J-284548290', 'Las tunitas', '04245118022', '2022-10-07 00:49:33', NULL, '2022-09-26 14:41:40'),
(5, 'C222', 'Mariangel Yajure', 'J-248454829', 'Las tunitas', '04245118022', '2022-09-26 15:14:18', '2022-09-26 15:14:18', '2022-09-26 14:43:34'),
(6, '', 'Mariangel Yajure', '', 'Las tunitas', '04121538387', '2022-10-14 18:41:34', '2022-10-14 18:41:34', '2022-10-14 18:40:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE `purchases` (
  `id` int NOT NULL,
  `provider` int NOT NULL,
  `user` int NOT NULL,
  `date` date NOT NULL,
  `receipt` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `reference` varchar(150) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tax` int NOT NULL,
  `coin` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `purchases`
--

INSERT INTO `purchases` (`id`, `provider`, `user`, `date`, `receipt`, `reference`, `tax`, `coin`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 4, 2, '2022-10-08', 'deliveryNote', '5345435454', 3, 1, NULL, NULL, '2022-10-14 18:49:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int NOT NULL,
  `product` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchase` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `product`, `quantity`, `price`, `purchase`) VALUES
(1, 4, 1, '100.00', 1),
(2, 2, 1, '95.50', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `customer` int NOT NULL,
  `seller` int NOT NULL,
  `date` date NOT NULL,
  `receipt` int NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales_details`
--

CREATE TABLE `sales_details` (
  `id` int NOT NULL,
  `product` int NOT NULL,
  `quantity` int NOT NULL,
  `sale` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taxes`
--

CREATE TABLE `taxes` (
  `id` int NOT NULL,
  `tax` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `percentage` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `taxes`
--

INSERT INTO `taxes` (`id`, `tax`, `percentage`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Ninguno', 0, '2022-09-26 16:46:53', NULL, '2022-09-14 23:21:31'),
(2, 'IVA 10%', 10, '2022-09-14 23:33:17', '2022-09-14 23:33:17', '2022-09-14 23:33:06'),
(3, 'IVA 16%', 16, '2022-09-26 17:25:27', NULL, '2022-09-16 20:00:27'),
(4, 'IVA 14%', 14, '2022-10-07 01:21:13', '2022-10-07 01:21:13', '2022-10-07 01:20:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `ci` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `privilege` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `photo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `last_session` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `ci`, `name`, `email`, `password`, `privilege`, `photo`, `last_session`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, '10000000', 'Administrador', 'admin@example.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'admin', '', '2022-09-10 20:57:27', '2022-09-12 21:06:01', NULL, '2022-08-14 15:08:27'),
(2, '28454829', 'Mariangel Yajure', 'mariangel.yajure@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'admin', 'http://pos-system-codeigniter.test/uploads/users/28454829.jpeg', '2022-09-11 12:08:09', '2022-09-11 16:38:09', NULL, '2022-09-10 00:58:04'),
(10, '13603033', 'Miriangel Noguera', 'miriangeln123@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', NULL, NULL, '2022-09-10 19:38:33', '2022-09-10 19:38:33', '2022-09-10 19:20:52'),
(11, '30044334', 'William Yajure', 'william@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'admin', NULL, NULL, '2022-10-06 01:28:10', '2022-10-06 01:28:10', '2022-09-11 01:05:11'),
(12, '30044335', 'William Yajure', 'william2@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'special', NULL, NULL, '2022-09-11 02:00:21', '2022-09-11 02:00:21', '2022-09-11 01:11:03'),
(13, '30044336', 'William Yajure', 'william1@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', '', NULL, '2022-09-11 16:25:17', '2022-09-11 16:25:17', '2022-09-11 01:25:46'),
(14, '15647634', 'Ana', 'ana1@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', '', NULL, '2022-09-11 16:42:34', '2022-09-11 16:42:34', '2022-09-11 16:27:41'),
(15, '12345678', 'Pedro', 'pedro@gmail.com', '', 'special', NULL, NULL, '2022-10-06 01:26:26', '2022-10-06 01:26:26', '2022-09-11 17:05:09'),
(16, '23546546', 'Pedro', 'pedro2@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', '', NULL, '2022-09-14 21:09:54', '2022-09-14 21:09:54', '2022-09-11 17:05:53'),
(17, '25546546', 'Pedro', 'pedro7@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'special', '', NULL, '2022-09-11 17:18:28', '2022-09-11 17:18:28', '2022-09-11 17:10:00'),
(18, '28604179', 'Luis Triana', 'luisdtriana2001@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'special', 'http://pos-system-codeigniter.test/uploads/users/28604179.jpeg', NULL, '2022-10-07 00:54:19', NULL, '2022-10-07 00:54:19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_audit` (`user`);

--
-- Indices de la tabla `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coin_prices`
--
ALTER TABLE `coin_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coin_prices_ibfk_1` (`primary_coin`),
  ADD KEY `coin_prices_ibfk_2` (`secondary_coin`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_ibfk_1` (`product`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand` (`brand`),
  ADD KEY `category` (`category`),
  ADD KEY `coin` (`coin`),
  ADD KEY `tax` (`tax`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_ibfk_1` (`provider`),
  ADD KEY `purchases_ibfk_2` (`tax`),
  ADD KEY `purchases_ibfk_3` (`coin`),
  ADD KEY `purchases_ibfk_4` (`user`);

--
-- Indices de la tabla `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_ibfk_1` (`product`),
  ADD KEY `purchase_details_ibfk_2` (`purchase`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_ibfk_1` (`customer`),
  ADD KEY `sales_ibfk_2` (`seller`);

--
-- Indices de la tabla `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_details_ibfk_1` (`product`),
  ADD KEY `sales_details_ibfk_2` (`sale`);

--
-- Indices de la tabla `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `audits`
--
ALTER TABLE `audits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `coin_prices`
--
ALTER TABLE `coin_prices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `audits`
--
ALTER TABLE `audits`
  ADD CONSTRAINT `audits_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `coin_prices`
--
ALTER TABLE `coin_prices`
  ADD CONSTRAINT `coin_prices_ibfk_1` FOREIGN KEY (`primary_coin`) REFERENCES `coins` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coin_prices_ibfk_2` FOREIGN KEY (`secondary_coin`) REFERENCES `coins` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`coin`) REFERENCES `coins` (`id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`tax`) REFERENCES `taxes` (`id`);

--
-- Filtros para la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`provider`) REFERENCES `providers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`tax`) REFERENCES `taxes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`coin`) REFERENCES `coins` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchases_ibfk_4` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `purchase_details_ibfk_2` FOREIGN KEY (`purchase`) REFERENCES `purchases` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`seller`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sales_details_ibfk_2` FOREIGN KEY (`sale`) REFERENCES `sales` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
