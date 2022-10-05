-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-10-2022 a las 11:51:21
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.30

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
CREATE DATABASE IF NOT EXISTS `pos_system` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `pos_system`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audits`
--

CREATE TABLE `audits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `action` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `audits`
--

INSERT INTO `audits` (`id`, `user_id`, `module`, `action`, `description`, `created_at`) VALUES
(4, 2, 'Usuarios', 'Inicio de sesión', 'El usuario con ID #2 ha iniciado sesión exitosamente', '2022-09-10 22:03:55'),
(5, 2, 'Usuarios', 'Inicio de sesión', 'El usuario con ID #2 ha iniciado sesión exitosamente', '2022-09-10 22:04:36'),
(6, 1, 'Usuarios', 'Inicio de sesión', 'El usuario con ID #1 ha iniciado sesión exitosamente', '2022-09-10 22:06:40'),
(7, 1, 'Usuarios', 'Inicio de sesión', 'El usuario con ID #1 ha iniciado sesión exitosamente', '2022-09-11 01:12:22'),
(8, 1, 'Usuarios', 'Crear usuario', 'El usuario con ID #1 ha creado al usuario con cedula 30044335', '2022-09-11 01:41:03'),
(9, 1, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con cedula 30044335 exitosamente', '2022-09-11 01:45:37'),
(10, 1, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula <strong>30044335</strong> exitosamente', '2022-09-11 01:53:34'),
(11, 1, 'Usuarios', 'Crear usuario', 'Se ha creado al usuario con cédula 30044336 exitosamente', '2022-09-11 01:55:46'),
(12, 1, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 01:57:28'),
(13, 1, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula 30044335 exitosamente.', '2022-09-11 02:30:21'),
(14, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 15:52:34'),
(15, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 15:53:40'),
(16, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 15:54:28'),
(17, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 15:56:14'),
(18, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con cédula 30044336 exitosamente.', '2022-09-11 16:50:35'),
(19, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula 30044336 exitosamente.', '2022-09-11 16:51:02'),
(20, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con cédula 30044336 exitosamente.', '2022-09-11 16:55:04'),
(21, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula 30044336 exitosamente.', '2022-09-11 16:55:17'),
(22, 2, 'Usuarios', 'Crear usuario', 'Se ha creado al usuario con cédula 15647634 exitosamente.', '2022-09-11 16:57:41'),
(23, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con cédula 15647634 exitosamente.', '2022-09-11 16:57:55'),
(24, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 16:59:23'),
(25, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula 15647634 exitosamente.', '2022-09-11 17:07:28'),
(26, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-11 17:08:09'),
(27, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula 15647634 exitosamente.', '2022-09-11 17:09:45'),
(28, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con cédula 15647634 exitosamente.', '2022-09-11 17:12:34'),
(29, 2, 'Usuarios', 'Crear usuario', 'Se ha creado al usuario con ID #17 exitosamente.', '2022-09-11 17:40:00'),
(30, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID # exitosamente.', '2022-09-11 17:46:16'),
(31, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #17 exitosamente.', '2022-09-11 17:48:15'),
(32, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con ID #17 exitosamente.', '2022-09-11 17:48:28'),
(33, 2, 'Usuarios', 'Crear categoría', 'Se ha creado la categoría con ID #1 exitosamente.', '2022-09-11 17:55:20'),
(34, 2, 'Usuarios', 'Crear categoría', 'Se ha creado la categoría con ID #2 exitosamente.', '2022-09-11 17:58:40'),
(35, 2, 'Usuarios', 'Crear categoría', 'Se ha creado la categoría con ID #3 exitosamente.', '2022-09-11 17:59:52'),
(36, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:09:23'),
(37, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #3 exitosamente.', '2022-09-11 19:16:29'),
(38, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #3 exitosamente.', '2022-09-11 19:16:47'),
(39, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #3 exitosamente.', '2022-09-11 19:17:00'),
(40, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #1 exitosamente.', '2022-09-11 19:25:12'),
(41, 2, 'Categorías', 'Crear categoría', 'Se ha creado la categoría con ID #4 exitosamente.', '2022-09-11 19:25:43'),
(42, 2, 'Categorías', 'Eliminar categoía', 'Se ha eliminado la categoía con ID #4 exitosamente.', '2022-09-11 19:35:24'),
(43, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-11 19:41:33'),
(44, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #1 exitosamente.', '2022-09-11 19:42:08'),
(45, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:44:07'),
(46, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:45:51'),
(47, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:46:09'),
(48, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:53:28'),
(49, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:54:11'),
(50, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:54:28'),
(51, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-11 19:57:14'),
(52, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #3 exitosamente.', '2022-09-11 19:58:51'),
(53, 2, 'Marcas', 'Crear marca', 'Se ha creado la marca con ID #1 exitosamente.', '2022-09-11 22:14:08'),
(54, 2, 'Marcas', 'Crear marca', 'Se ha creado la marca con ID #2 exitosamente.', '2022-09-11 22:14:19'),
(55, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #2 exitosamente.', '2022-09-11 22:14:44'),
(56, 2, 'Marcas', 'Eliminar marca', 'Se ha eliminado la marca con ID #2 exitosamente.', '2022-09-11 22:15:14'),
(57, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-12 01:46:34'),
(58, 2, 'Marcas', 'Crear marca', 'Se ha creado la marca con ID #3 exitosamente.', '2022-09-12 01:47:35'),
(59, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #3 exitosamente.', '2022-09-12 01:47:50'),
(60, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #3 exitosamente.', '2022-09-12 01:48:00'),
(61, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-12 01:49:26'),
(62, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-12 01:49:44'),
(63, 2, 'Categorías', 'Eliminar categoría', 'Se ha eliminado la categoría con ID #3 exitosamente.', '2022-09-12 02:35:49'),
(64, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-12 19:52:47'),
(65, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-12 19:54:03'),
(66, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #1 exitosamente.', '2022-09-12 21:36:01'),
(67, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-12 23:15:34'),
(68, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #1 exitosamente.', '2022-09-12 23:16:08'),
(69, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-12 23:18:15'),
(70, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #2 exitosamente.', '2022-09-12 23:18:37'),
(71, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #3 exitosamente.', '2022-09-12 23:19:00'),
(72, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-12 23:39:37'),
(73, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #3 exitosamente.', '2022-09-12 23:40:09'),
(74, 2, 'Marcas', 'Eliminar marca', 'Se ha eliminado la marca con ID #3 exitosamente.', '2022-09-12 23:44:28'),
(75, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-14 19:43:34'),
(76, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-14 19:53:47'),
(77, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #1 exitosamente.', '2022-09-14 20:07:15'),
(78, 2, 'Monedas', 'Crear moneda', 'Se ha creado la moneda con ID #2 exitosamente.', '2022-09-14 20:39:20'),
(79, 2, 'Monedas', 'Crear moneda', 'Se ha creado la moneda con ID #3 exitosamente.', '2022-09-14 20:48:47'),
(80, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #3 exitosamente.', '2022-09-14 20:52:58'),
(81, 2, 'Monedas', 'Eliminar moneda', 'Se ha eliminado la moneda con ID #3 exitosamente.', '2022-09-14 20:53:14'),
(82, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #1 exitosamente.', '2022-09-14 20:54:37'),
(83, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-14 20:54:53'),
(84, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #16 exitosamente.', '2022-09-14 21:23:59'),
(85, 2, 'Usuarios', 'Eliminar usuario', 'Se ha eliminado al usuario con ID #16 exitosamente.', '2022-09-14 21:39:54'),
(86, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #2 exitosamente.', '2022-09-14 21:54:46'),
(87, 2, 'Categorías', 'Eliminar categoría', 'Se ha eliminado la categoría con ID #2 exitosamente.', '2022-09-14 21:54:56'),
(88, 2, 'Categorías', 'Crear categoría', 'Se ha creado la categoría con ID #5 exitosamente.', '2022-09-14 21:55:20'),
(89, 2, 'Marcas', 'Crear marca', 'Se ha creado la marca con ID #4 exitosamente.', '2022-09-14 22:05:43'),
(90, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #4 exitosamente.', '2022-09-14 22:06:33'),
(91, 2, 'Marcas', 'Eliminar marca', 'Se ha eliminado la marca con ID #4 exitosamente.', '2022-09-14 22:06:41'),
(92, 2, 'Monedas', 'Crear moneda', 'Se ha creado la moneda con ID #4 exitosamente.', '2022-09-14 22:10:32'),
(93, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #4 exitosamente.', '2022-09-14 22:10:46'),
(94, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #4 exitosamente.', '2022-09-14 22:11:02'),
(95, 2, 'Monedas', 'Eliminar moneda', 'Se ha eliminado la moneda con ID #4 exitosamente.', '2022-09-14 22:11:14'),
(96, 2, 'Impuestos', 'Crear impuesto', 'Se ha creado el impuesto con ID #1 exitosamente.', '2022-09-14 23:51:31'),
(97, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impueto con ID #1 exitosamente.', '2022-09-15 00:02:34'),
(98, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impueto con ID #1 exitosamente.', '2022-09-15 00:02:46'),
(99, 2, 'Impuestos', 'Crear impuesto', 'Se ha creado el impuesto con ID #2 exitosamente.', '2022-09-15 00:03:06'),
(100, 2, 'Impuestos', 'Eliminar impuesto', 'Se ha eliminado el impuesto con ID #2 exitosamente.', '2022-09-15 00:03:17'),
(101, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impueto con ID #1 exitosamente.', '2022-09-15 00:11:22'),
(102, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impueto con ID #1 exitosamente.', '2022-09-15 00:11:35'),
(103, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impueto con ID #1 exitosamente.', '2022-09-15 00:12:32'),
(104, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-15 00:13:38'),
(105, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-15 00:13:51'),
(106, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-15 00:14:01'),
(107, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-16 20:29:30'),
(108, 2, 'Impuestos', 'Crear impuesto', 'Se ha creado el impuesto con ID #3 exitosamente.', '2022-09-16 20:30:27'),
(109, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-17 23:06:38'),
(110, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-18 16:49:22'),
(111, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-18 17:24:07'),
(112, 2, 'Centro de control', 'Establecer monedas', 'Se han establecido las monedas Bolívar Soberano y  como monedas principal y secundaria', '2022-09-18 18:29:28'),
(113, 2, 'Centro de control', 'Establecer monedas', 'Se han establecido las monedas Bolívar Soberano y  como monedas principal y secundaria', '2022-09-18 18:30:07'),
(114, 2, 'Centro de control', 'Establecer monedas', 'Se han establecido las monedas Bolívar Soberano y  como monedas principal y secundaria', '2022-09-18 18:31:28'),
(115, 2, 'Centro de control', 'Establecer monedas', 'Se han establecido las monedas Dólar y  como monedas principal y secundaria', '2022-09-18 18:33:10'),
(116, 2, 'Centro de control', 'Establecer monedas', 'Se han establecido las monedas Dólar y Dólar como monedas principal y secundaria', '2022-09-18 18:33:37'),
(117, 2, 'Categorías', 'Crear categoría', 'Se ha creado la categoría con ID #6 exitosamente.', '2022-09-18 19:46:27'),
(118, 2, 'Productos', 'Crear producto', 'Se ha creado el producto con ID #1 exitosamente.', '2022-09-18 19:49:06'),
(119, 2, 'Productos', 'Crear producto', 'Se ha creado el producto con ID #2 exitosamente.', '2022-09-18 19:50:05'),
(120, 2, 'Productos', 'Crear producto', 'Se ha creado el producto con ID #3 exitosamente.', '2022-09-18 20:02:01'),
(121, 2, 'Productos', 'Crear producto', 'Se ha creado el producto con ID #4 exitosamente.', '2022-09-18 20:03:02'),
(122, 2, 'Productos', 'Crear producto', 'Se ha creado el producto con ID #5 exitosamente.', '2022-09-18 20:06:03'),
(123, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #5 exitosamente.', '2022-09-18 21:11:02'),
(124, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #5 exitosamente.', '2022-09-18 21:11:23'),
(125, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #4 exitosamente.', '2022-09-18 21:11:51'),
(126, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #5 exitosamente.', '2022-09-18 21:12:02'),
(127, 2, 'Productos', 'Eliminar producto', 'Se ha eliminado el producto con ID #3 exitosamente.', '2022-09-18 21:13:42'),
(128, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-20 00:09:12'),
(129, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-20 00:09:13'),
(130, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-21 20:24:02'),
(131, 2, 'Centro de control', 'Establecer monedas', 'Se han establecido las monedas Dólar y Bolívar Soberano como monedas principal y secundaria', '2022-09-21 20:37:20'),
(132, 2, 'Proveedores', 'Crear proveedor', 'Se ha creado el proveedor con ID #1 exitosamente.', '2022-09-21 23:51:28'),
(133, 2, 'Proveedores', 'Crear proveedor', 'Se ha creado el proveedor con ID #2 exitosamente.', '2022-09-22 00:00:10'),
(134, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado el proveedor con ID #2 exitosamente.', '2022-09-22 00:22:47'),
(135, 2, 'Proveedores', 'Eliminar proveedor', 'Se ha eliminado al proveedor con ID #2 exitosamente.', '2022-09-22 00:23:01'),
(136, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-25 14:02:35'),
(137, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 14:03:13'),
(138, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 14:03:46'),
(139, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 14:10:32'),
(140, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 14:11:01'),
(141, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-25 15:37:42'),
(142, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impueto con ID #3 exitosamente.', '2022-09-25 15:40:33'),
(143, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-25 15:41:50'),
(144, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impuesto con ID #3 exitosamente.', '2022-09-25 15:46:13'),
(145, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-25 20:56:15'),
(146, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 21:27:57'),
(147, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 21:34:51'),
(148, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 21:36:20'),
(149, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-25 21:46:37'),
(150, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #1 exitosamente.', '2022-09-25 21:46:55'),
(151, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #1 exitosamente.', '2022-09-25 21:57:54'),
(152, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-26 01:32:58'),
(153, 2, 'Proveedores', 'Crear proveedor', 'Se ha creado al proveedor con ID #3 exitosamente.', '2022-09-26 01:43:05'),
(154, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-26 14:32:32'),
(155, 2, 'Proveedores', 'Crear proveedor', 'Se ha creado al proveedor con ID #4 exitosamente.', '2022-09-26 15:11:41'),
(156, 2, 'Proveedores', 'Crear proveedor', 'Se ha creado al proveedor con ID #5 exitosamente.', '2022-09-26 15:13:34'),
(157, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #3 exitosamente.', '2022-09-26 15:22:14'),
(158, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #2 exitosamente.', '2022-09-26 15:24:47'),
(159, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #1 exitosamente.', '2022-09-26 15:25:10'),
(160, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #3 exitosamente.', '2022-09-26 15:25:26'),
(161, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #4 exitosamente.', '2022-09-26 15:25:39'),
(162, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #5 exitosamente.', '2022-09-26 15:25:53'),
(163, 2, 'Proveedores', 'Eliminar proveedor', 'Se ha eliminado al proveedor con ID #5 exitosamente.', '2022-09-26 15:44:18'),
(164, 2, 'Proveedores', 'Eliminar proveedor', 'Se ha eliminado al proveedor con ID #3 exitosamente.', '2022-09-26 15:44:25'),
(165, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:00:44'),
(166, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:01:15'),
(167, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:22:11'),
(168, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:27:58'),
(169, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:28:30'),
(170, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:32:31'),
(171, 2, 'Usuarios', 'Actualizar usuario', 'Se ha actualizado al usuario con ID #15 exitosamente.', '2022-09-26 16:58:52'),
(172, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impuesto con ID #3 exitosamente.', '2022-09-26 17:16:33'),
(173, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impuesto con ID #1 exitosamente.', '2022-09-26 17:16:43'),
(174, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impuesto con ID #1 exitosamente.', '2022-09-26 17:16:53'),
(175, 2, 'Impuestos', 'Actualizar impuesto', 'Se ha actualizado el impuesto con ID #3 exitosamente.', '2022-09-26 17:55:28'),
(176, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-26 18:02:04'),
(177, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-26 18:02:17'),
(178, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-26 21:49:29'),
(179, 2, 'Monedas', 'Actualizar moneda', 'Se ha actualizado la moneda con ID #2 exitosamente.', '2022-09-26 21:51:06'),
(180, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #1 exitosamente.', '2022-09-26 21:56:34'),
(181, 2, 'Marcas', 'Actualizar marca', 'Se ha actualizado la marca con ID #1 exitosamente.', '2022-09-26 21:56:45'),
(182, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #6 exitosamente.', '2022-09-26 22:02:15'),
(183, 2, 'Categorías', 'Actualizar categoría', 'Se ha actualizado la categoría con ID #6 exitosamente.', '2022-09-26 22:09:02'),
(184, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-27 01:16:49'),
(185, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #5 exitosamente.', '2022-09-27 01:33:03'),
(186, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #5 exitosamente.', '2022-09-27 01:37:07'),
(187, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #5 exitosamente.', '2022-09-27 01:37:34'),
(188, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #1 exitosamente.', '2022-09-27 01:39:56'),
(189, 2, 'Productos', 'Crear producto', 'Se ha creado el producto con ID #6 exitosamente.', '2022-09-27 01:47:26'),
(190, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #1 exitosamente.', '2022-09-27 01:48:16'),
(191, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-27 21:25:56'),
(192, 2, 'Productos', 'Eliminar producto', 'Se ha eliminado el producto con ID #6 exitosamente.', '2022-09-27 22:11:28'),
(193, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #6 exitosamente.', '2022-09-27 22:11:36'),
(194, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-28 20:55:35'),
(195, 2, 'Productos', 'Actualizar producto', 'Se ha actualizado el producto con ID #1 exitosamente.', '2022-09-28 20:57:06'),
(196, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-09-30 21:52:07'),
(197, 2, 'Proveedores', 'Actualizar proveedor', 'Se ha actualizado al proveedor con ID #4 exitosamente.', '2022-09-30 21:53:17'),
(198, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-10-01 18:38:57'),
(199, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-10-02 10:44:29'),
(200, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-10-02 16:15:05'),
(201, 2, 'Usuarios', 'Inicio de sesión', 'El usuario ha iniciado sesión exitosamente.', '2022-10-03 20:12:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `brands`
--

INSERT INTO `brands` (`id`, `brand`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Firestone', '2022-09-26 21:26:45', NULL, '2022-09-11 21:44:08'),
(2, 'Bridgestone', '2022-09-11 21:45:14', '2022-09-11 21:45:14', '2022-09-11 21:44:19'),
(3, 'Fire', '2022-09-12 23:14:28', '2022-09-12 23:14:28', '2022-09-12 01:17:35'),
(4, 'Cauchos', '2022-09-14 21:36:41', '2022-09-14 21:36:41', '2022-09-14 21:35:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `category`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Camiones', '2022-09-12 22:46:07', NULL, '2022-09-11 17:25:19'),
(2, 'Cauchos de invierno', '2022-09-14 21:24:56', '2022-09-14 21:24:56', '2022-09-11 17:28:40'),
(3, 'Cauchos de verano', '2022-09-12 02:05:48', '2022-09-12 02:05:48', '2022-09-11 17:29:52'),
(4, 'Carros', '2022-09-11 19:05:23', '2022-09-11 19:05:23', '2022-09-11 18:55:43'),
(5, 'Cauchos de otoño', '2022-09-14 21:25:20', NULL, '2022-09-14 21:25:20'),
(6, 'Caucho rin 17', '2022-09-26 21:39:02', NULL, '2022-09-18 19:16:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coins`
--

CREATE TABLE `coins` (
  `id` int(11) NOT NULL,
  `coin` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `symbol` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `coins`
--

INSERT INTO `coins` (`id`, `coin`, `symbol`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Dólar', '$', '2022-09-14 20:24:37', NULL, '2022-09-14 20:08:40'),
(2, 'Bolívar Digital', 'Bsd.', '2022-09-26 21:21:06', NULL, '2022-09-14 20:09:20'),
(3, 'Euro', 'a', '2022-09-14 20:23:14', '2022-09-14 20:23:14', '2022-09-14 20:18:47'),
(4, 'Yen', 'Yenes', '2022-09-14 21:41:14', '2022-09-14 21:41:14', '2022-09-14 21:40:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `brand` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `coin` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `tax` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `brand`, `category`, `coin`, `price`, `tax`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'C100', 'Caucho algo', 1, 6, 1, '15000.00', 3, '2022-09-28 20:27:06', NULL, '2022-09-18 19:19:06'),
(2, 'C101', 'Cauchos de verano', 1, 1, 1, '1.00', 3, '2022-09-18 19:20:05', NULL, '2022-09-18 19:20:05'),
(3, 'C102', 'Caucho otro', 1, 5, 1, '13.00', 3, '2022-09-18 20:43:42', '2022-09-18 20:43:42', '2022-09-18 19:32:01'),
(4, 'C200', 'Caucho ', 1, 1, 1, '320.00', 3, '2022-09-18 20:41:51', NULL, '2022-09-18 19:33:02'),
(5, 'C201', 'Cauchos', 1, 5, 1, '120.00', 3, '2022-09-27 01:07:34', NULL, '2022-09-18 19:36:03'),
(6, 'C205', 'Producto', 1, 1, 1, '324.53', 3, '2022-09-27 21:41:36', '2022-09-27 21:41:27', '2022-09-27 01:17:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `rif` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `address` text COLLATE utf8_spanish_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `phone2` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `type` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`id`, `code`, `name`, `rif`, `address`, `phone`, `phone2`, `type`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'A-001', 'Mariangel Yajure', 'V-284558290', 'Las tunitas', '04245118022', '', 'normal', '2022-09-26 14:55:10', NULL, '2022-09-21 23:21:28'),
(2, 'A-002', 'Mariangel Yajure', 'V-284548290', 'Las tunitas', '04245118022', '04121538387', 'normal', '2022-09-26 14:54:46', NULL, '2022-09-21 23:30:10'),
(3, 'C200', 'Mariangel Yajure', 'J-284544829', 'Las tunitas', '04245118022', '', 'normal', '2022-09-26 15:14:25', '2022-09-26 15:14:25', '2022-09-26 01:13:04'),
(4, 'A-003', 'Mariangel Yajure', 'J-284548290', 'Las tunitas', '04245118022', '', 'normal', '2022-09-30 21:23:17', NULL, '2022-09-26 14:41:40'),
(5, 'C222', 'Mariangel Yajure', 'J-248454829', 'Las tunitas', '04245118022', '', 'normal', '2022-09-26 15:14:18', '2022-09-26 15:14:18', '2022-09-26 14:43:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `value` text COLLATE utf8_spanish_ci NOT NULL,
  `table_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `type`, `name`, `value`, `table_id`, `updated_at`) VALUES
(1, 'system', 'systemName', 'POS System', 0, NULL),
(2, 'coin', 'principalCoin', 'Dólar', 0, '2022-09-21 20:07:20'),
(3, 'coin', 'secondaryCoin', 'Bolívar Soberano', 0, '2022-09-21 20:07:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `tax` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `percentage` int(2) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `taxes`
--

INSERT INTO `taxes` (`id`, `tax`, `percentage`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, 'Ninguno', 0, '2022-09-26 16:46:53', NULL, '2022-09-14 23:21:31'),
(2, 'IVA 10%', 10, '2022-09-14 23:33:17', '2022-09-14 23:33:17', '2022-09-14 23:33:06'),
(3, 'IVA 16%', 16, '2022-09-26 17:25:27', NULL, '2022-09-16 20:00:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ci` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `privilege` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `photo` text COLLATE utf8_spanish_ci,
  `last_session` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `ci`, `name`, `email`, `password`, `privilege`, `photo`, `last_session`, `updated_at`, `deleted_at`, `created_at`) VALUES
(1, '10000000', 'Administrador', 'admin@example.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'admin', '', '2022-09-10 20:57:27', '2022-09-12 21:06:01', NULL, '2022-08-14 15:08:27'),
(2, '28454829', 'Mariangel Yajure', 'mariangel.yajure@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'admin', 'http://pos-system-codeigniter.test/uploads/users/28454829.jpeg', '2022-09-11 12:08:09', '2022-09-11 16:38:09', NULL, '2022-09-10 00:58:04'),
(10, '13603033', 'Miriangel Noguera', 'miriangeln123@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', NULL, NULL, '2022-09-10 19:38:33', '2022-09-10 19:38:33', '2022-09-10 19:20:52'),
(11, '30044334', 'William Yajure', 'william@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'admin', NULL, NULL, '2022-09-11 01:05:11', NULL, '2022-09-11 01:05:11'),
(12, '30044335', 'William Yajure', 'william2@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'special', NULL, NULL, '2022-09-11 02:00:21', '2022-09-11 02:00:21', '2022-09-11 01:11:03'),
(13, '30044336', 'William Yajure', 'william1@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', '', NULL, '2022-09-11 16:25:17', '2022-09-11 16:25:17', '2022-09-11 01:25:46'),
(14, '15647634', 'Ana', 'ana1@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', '', NULL, '2022-09-11 16:42:34', '2022-09-11 16:42:34', '2022-09-11 16:27:41'),
(15, '12345678', 'Pedro', 'pedro@gmail.com', '', 'special', NULL, NULL, '2022-09-26 16:28:52', NULL, '2022-09-11 17:05:09'),
(16, '23546546', 'Pedro', 'pedro2@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'seller', '', NULL, '2022-09-14 21:09:54', '2022-09-14 21:09:54', '2022-09-11 17:05:53'),
(17, '25546546', 'Pedro', 'pedro7@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'special', '', NULL, '2022-09-11 17:18:28', '2022-09-11 17:18:28', '2022-09-11 17:10:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_audit` (`user_id`);

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
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT de la tabla `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `audits`
--
ALTER TABLE `audits`
  ADD CONSTRAINT `audits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`coin`) REFERENCES `coins` (`id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`tax`) REFERENCES `taxes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
