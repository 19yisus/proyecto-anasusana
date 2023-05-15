-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2023 a las 01:20:05
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_iglesia2`
--
CREATE DATABASE IF NOT EXISTS `proyecto_iglesia2` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `proyecto_iglesia2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_operacion` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `tabla_change` varchar(30) NOT NULL,
  `hora_fecha` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_operacion`, `descripcion`, `tabla_change`, `hora_fecha`, `id_usuario`) VALUES
(1, 'REGISTRO DE NUEVO CARGO: ASASDFASDFA', 'CARGO', '2023-04-01 17:36:12', 1),
(2, 'REGISTRO DE NUEVO CARGO: ASASDFASDFA', 'CARGO', '2023-04-01 17:37:57', 1),
(3, 'REGISTRO DE NUEVO CARGO: JHJGHJGHJH', 'CARGO', '2023-04-01 17:39:22', 1),
(4, 'REGISTRO DE NUEVO PERSONAS: 12341234, NOMBRE: MESSI RONALDO, TELEFONO: 1231 3231312', 'PERSONAS', '2023-04-10 19:13:11', 1),
(5, 'REGISTRO NUEVO PROOVEDOR_MARCA: ID DE LA PERSONA => 20, 0 MARCAS', 'PROOVEDOR_MARCA', '2023-04-10 19:13:11', 1),
(6, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-06 09:08:15', 2),
(7, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-06 09:10:03', 2),
(8, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-06 09:10:09', 1),
(9, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-06 09:11:27', 1),
(10, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-06 09:14:58', 1),
(11, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-06 09:18:38', 1),
(12, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-06 09:21:35', 1),
(13, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-06 09:22:45', 1),
(14, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 03:04:01', 1),
(15, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 03:14:57', 1),
(16, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 03:15:05', 1),
(17, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 03:16:51', 1),
(18, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-08 03:17:47', 2),
(19, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-08 03:17:51', 2),
(20, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-08 03:18:40', 2),
(21, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-08 03:18:48', 2),
(22, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 03:18:53', 1),
(23, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 03:24:02', 1),
(24, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 09:37:19', 1),
(25, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 09:39:28', 1),
(26, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 09:47:24', 1),
(27, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 09:49:40', 1),
(28, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 09:49:44', 1),
(29, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-08 09:50:42', 1),
(30, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:04:51', 1),
(31, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:04:57', 1),
(32, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:05:03', 1),
(33, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:05:47', 1),
(34, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:05:55', 1),
(35, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:07:39', 1),
(36, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:07:43', 1),
(37, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:09:33', 1),
(38, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:09:40', 1),
(39, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:22:42', 1),
(40, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:22:46', 1),
(41, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:24:12', 1),
(42, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:26:21', 1),
(43, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:27:39', 1),
(44, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:28:04', 1),
(45, 'REGISTRO DE NUEVO PRODUCTO: MORTADELA, UNIDAD: KL, VALOR: 1, STOCK MINIMO: 1, STOCK MAXIMO: 100', 'PRODUCTOS', '2023-05-13 14:28:57', 1),
(46, 'REGISTRO DE NUEVO MARCA: SABOR', 'MARCA', '2023-05-13 14:29:42', 1),
(47, 'REGISTRO NUEVO PROOVEDOR_MARCA: ID DE LA PERSONA => , 0 MARCAS', 'PROOVEDOR_MARCA', '2023-05-13 14:31:38', 1),
(48, 'REGISTRO DE NUEVO COMEDOR: ANA SUSANA DE OUSSET, DIRECCIÓN: AFAFAFAF', 'COMEDOR', '2023-05-13 14:32:01', 1),
(49, 'TRANSACIÓN DE REGISTRO DEL MENÚ: MORTADELA CRUDA, ID DEL MENÚ: 1', 'MENU - MENU_DETALE', '2023-05-13 14:32:39', 1),
(50, 'REGISTRO DE NUEVA JORNADA: MORTADELA PUES, DESCRIPCIÓN: JORNADA DE HOY\r\n, CANTIDAD APROXIMADA DE BENEFICIADOS: 10', 'JORNADA', '2023-05-13 14:33:19', 1),
(51, 'TRANSACCIÓN DE ENTRADA DE PRODUCTOS| ID INVENTARIO: E-00000001, CANTIDAD: 40, OBSERVACIÓN: QUE LOCOOOOOOO\r\n', 'INVENTARIO - DETALLE_INVENTARI', '2023-05-13 14:34:02', 1),
(52, 'TRANSACCIÓN DE SALIDA DE PRODUCTOS| ID INVENTARIO: S-00000001, CANTIDAD: 5, OBSERVACIÓN: MORTADELA SE VA', 'INVENTARIO - DETALLE_INVENTARI', '2023-05-13 14:34:52', 1),
(53, 'TRANSACCIÓN DE SALIDA DE PRODUCTOS| ID INVENTARIO: S-00000002, CANTIDAD: 10, OBSERVACIÓN: SEE LLEVARON 10', 'INVENTARIO - DETALLE_INVENTARI', '2023-05-13 14:35:22', 1),
(54, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:38:01', 1),
(55, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:38:07', 1),
(56, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:43:13', 1),
(57, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:52:18', 1),
(58, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:54:02', 1),
(59, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:55:21', 1),
(60, 'REGISTRO DE NUEVO MARCA: HPPP', 'MARCA', '2023-05-13 14:56:26', 1),
(61, 'REGISTRO DE NUEVO MARCA: HOLA COMO', 'MARCA', '2023-05-13 14:56:34', 1),
(62, 'REGISTRO DE NUEVO CARGO: ALONSO', 'CARGO', '2023-05-13 14:56:58', 1),
(63, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:59:15', 1),
(64, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 14:59:45', 1),
(65, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:01:00', 1),
(66, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:14:13', 1),
(67, 'ACTUALIZACIÓN DE PRODUCTO: MORTADELA, UNIDAD: KL, VALOR: 1, STOCK MINIMO: 5, STOCK MAXIMO: 100', 'PRODUCTOS', '2023-05-13 15:14:29', 1),
(68, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:15:59', 1),
(69, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:27:32', 1),
(70, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:29:49', 1),
(71, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:31:28', 1),
(72, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-13 15:34:27', 1),
(73, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-14 17:19:41', 1),
(74, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-14 18:17:20', 1),
(75, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-14 18:17:25', 2),
(76, 'SALIDA DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-14 18:19:03', 2),
(77, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-14 18:19:10', 2),
(78, 'SALIDA DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-14 18:40:07', 2),
(79, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-14 18:40:13', 1),
(80, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-05-14 18:40:32', 1),
(81, 'INICIO DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-14 18:40:36', 2),
(82, 'SALIDA DE SESION DEL USUARIO: V-30400100, RONALDO PEREZ', 'USUARIOS', '2023-05-14 18:41:34', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `des_cargo` varchar(20) NOT NULL,
  `estatus_cargo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `des_cargo`, `estatus_cargo`) VALUES
(1, 'NUEVOO', 1),
(2, 'COCINERO', 1),
(3, 'CONTROLE', 1),
(4, 'FASDFASDFSDF', 1),
(5, 'FASDFSSSSSSS', 1),
(6, 'AAAAAAAA', 1),
(7, 'ASASDFASDFA', 1),
(8, 'ASASDFASDFA', 1),
(9, 'ASASDFASDFA', 1),
(10, 'ASASDFASDFA', 1),
(11, 'JHJGHJGHJH', 1),
(12, 'ALONSO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_recuperacion`
--

CREATE TABLE `codigos_recuperacion` (
  `id_cod` int(11) NOT NULL,
  `date_cod` datetime NOT NULL,
  `status_code` tinyint(1) NOT NULL,
  `char_code` char(8) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `codigos_recuperacion`
--

INSERT INTO `codigos_recuperacion` (`id_cod`, `date_cod`, `status_code`, `char_code`, `id_user`) VALUES
(1, '2023-04-03 23:26:25', 0, 'zL3ktmFG', 8),
(2, '2023-04-03 23:26:56', 0, 'y3ntgSWA', 8),
(3, '2023-04-04 00:09:40', 0, '5jqeJXv7', 8),
(4, '2023-04-04 00:11:41', 0, 'yENZ23vM', 8),
(5, '2023-04-04 00:12:13', 0, 'aM8dV1cb', 8),
(6, '2023-04-04 00:12:23', 0, '6z4Suhtd', 8),
(7, '2023-04-04 00:13:48', 0, 'hA7eUTgO', 8),
(8, '2023-04-04 00:20:25', 0, 'WDl9hZjN', 8),
(9, '2023-04-04 00:20:44', 0, 'VMd2jo3E', 8),
(10, '2023-04-04 00:22:09', 0, 'R8ZNbBHJ', 8),
(11, '2023-04-04 00:22:30', 0, '5Cvc6uhO', 8),
(12, '2023-04-04 00:27:49', 0, 'V6SDMcNv', 8),
(13, '2023-04-04 16:49:21', 0, 'MU0fc9yK', 8),
(14, '2023-04-04 17:01:41', 0, 'Y0OTpg3w', 8),
(15, '2023-04-10 18:42:17', 1, 'djnf8LXp', 8),
(16, '2023-04-10 19:15:42', 1, 'l9BAIiaz', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comedor`
--

CREATE TABLE `comedor` (
  `id_comedor` int(11) NOT NULL,
  `nom_comedor` varchar(40) NOT NULL,
  `encargado_comedor` int(11) NOT NULL,
  `direccion_comedor` varchar(120) NOT NULL,
  `status_comedor` tinyint(4) NOT NULL,
  `if_sede` tinyint(1) NOT NULL,
  `created_comedor` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comedor`
--

INSERT INTO `comedor` (`id_comedor`, `nom_comedor`, `encargado_comedor`, `direccion_comedor`, `status_comedor`, `if_sede`, `created_comedor`) VALUES
(1, 'PAN DE VIDA', 6, 'SDASDADADSDS', 1, 1, '2022-10-07 11:08:02'),
(2, 'ANA SUSANA DE OUSSET', 1, 'AFAFAFAF', 1, 0, '2023-05-13 14:32:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_inventario`
--

CREATE TABLE `detalle_inventario` (
  `product_id_ope` int(11) NOT NULL,
  `invent_id_ope` char(10) NOT NULL,
  `fecha_vencimiento_ope` datetime DEFAULT NULL,
  `precio_product_ope` double DEFAULT NULL,
  `detalle_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_inventario`
--

INSERT INTO `detalle_inventario` (`product_id_ope`, `invent_id_ope`, `fecha_vencimiento_ope`, `precio_product_ope`, `detalle_cantidad`) VALUES
(1, 'E-00000001', NULL, 0, 40),
(1, 'S-00000001', NULL, NULL, 5),
(1, 'S-00000002', NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_invent` char(10) NOT NULL,
  `orden_invent` varchar(20) DEFAULT NULL,
  `cantidad_invent` int(11) NOT NULL,
  `status_invent` tinyint(4) NOT NULL,
  `created_invent` datetime DEFAULT NULL,
  `type_operacion_invent` enum('E','S') NOT NULL,
  `concept_invent` enum('C','D','O','V','R') DEFAULT NULL,
  `if_credito` tinyint(1) DEFAULT NULL,
  `jornada_id_invent` int(11) DEFAULT NULL,
  `person_id_invent` int(11) DEFAULT NULL,
  `recibe_person_id_invent` int(11) DEFAULT NULL,
  `comedor_id_invent` int(11) NOT NULL,
  `user_id_invent` int(11) NOT NULL,
  `observacion_invent` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_invent`, `orden_invent`, `cantidad_invent`, `status_invent`, `created_invent`, `type_operacion_invent`, `concept_invent`, `if_credito`, `jornada_id_invent`, `person_id_invent`, `recibe_person_id_invent`, `comedor_id_invent`, `user_id_invent`, `observacion_invent`) VALUES
('E-00000001', '445646548', 40, 1, '2023-05-13 15:03:00', 'E', 'C', 0, NULL, 1, 1, 2, 1, 'QUE LOCOOOOOOO\r\n'),
('S-00000001', NULL, 5, 1, '2023-05-13 15:04:00', 'S', 'O', NULL, 1, NULL, 1, 2, 1, 'MORTADELA SE VA'),
('S-00000002', NULL, 10, 1, '2023-05-13 15:04:00', 'S', 'R', NULL, NULL, NULL, 1, 2, 1, 'SEE LLEVARON 10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `id_jornada` int(11) NOT NULL,
  `titulo_jornada` varchar(30) NOT NULL,
  `des_jornada` varchar(120) DEFAULT NULL,
  `cant_aproximada` int(11) NOT NULL,
  `estatus_jornada` tinyint(1) NOT NULL,
  `fecha_jornada` date NOT NULL,
  `menu_id_jornada` int(11) DEFAULT NULL,
  `person_id_responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `jornada`
--

INSERT INTO `jornada` (`id_jornada`, `titulo_jornada`, `des_jornada`, `cant_aproximada`, `estatus_jornada`, `fecha_jornada`, `menu_id_jornada`, `person_id_responsable`) VALUES
(1, 'MORTADELA PUES', 'JORNADA DE HOY\r\n', 10, 1, '2023-05-13', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nom_marca` varchar(40) NOT NULL,
  `status_marca` tinyint(4) NOT NULL,
  `created_marca` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nom_marca`, `status_marca`, `created_marca`) VALUES
(1, 'GUKJ,M ', 1, '2022-10-07 11:01:13'),
(2, 'POLAR', 1, '2022-10-17 09:39:24'),
(3, 'MACEITE', 1, '2022-11-28 07:44:55'),
(4, 'PAN', 1, '2022-12-02 13:58:32'),
(5, 'MARY', 1, '2022-12-02 14:01:18'),
(6, 'AGUA BLANCA', 1, '2022-12-02 14:21:56'),
(7, 'DEL MAR', 1, '2022-12-02 14:36:15'),
(8, 'GDFGSDFGSDFG', 1, '2023-03-28 09:24:40'),
(9, 'SABOR', 1, '2023-05-13 14:29:42'),
(10, 'HPPP', 1, '2023-05-13 14:56:26'),
(11, 'HOLA COMO', 1, '2023-05-13 14:56:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `des_menu` varchar(30) NOT NULL,
  `des_procedimiento` varchar(200) DEFAULT NULL,
  `status_menu` tinyint(1) NOT NULL,
  `created_menu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `des_menu`, `des_procedimiento`, `status_menu`, `created_menu`) VALUES
(1, 'MORTADELA CRUDA', 'MORTADELA CRUDA', 1, '2023-05-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_detalle`
--

CREATE TABLE `menu_detalle` (
  `menu_id_detalle` int(11) NOT NULL,
  `product_id_menu_detalle` int(11) NOT NULL,
  `consumo` int(11) NOT NULL,
  `med_comida_detalle` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menu_detalle`
--

INSERT INTO `menu_detalle` (`menu_id_detalle`, `product_id_menu_detalle`, `consumo`, `med_comida_detalle`) VALUES
(1, 1, 500, 'GM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_vista`
--

CREATE TABLE `permiso_vista` (
  `id_per` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `modulo_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permiso_vista`
--

INSERT INTO `permiso_vista` (`id_per`, `user_id`, `modulo_name`) VALUES
(11, 9, 'marcas'),
(12, 9, 'personas'),
(13, 9, 'jornada'),
(18, 2, 'marcas'),
(19, 2, 'personas'),
(20, 2, 'jornada'),
(21, 2, 'entradas'),
(22, 2, 'cargo'),
(23, 2, 'menu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_person` int(11) NOT NULL,
  `cedula_person` varchar(9) NOT NULL,
  `tipo_person` char(1) DEFAULT NULL,
  `nom_person` varchar(60) NOT NULL,
  `sexo_person` enum('F','M') DEFAULT NULL,
  `telefono_movil_person` varchar(12) DEFAULT NULL,
  `telefono_casa_person` varchar(12) DEFAULT NULL,
  `direccion_person` varchar(120) NOT NULL,
  `correo_person` varchar(130) DEFAULT NULL,
  `cargo_id` int(11) DEFAULT NULL,
  `if_proveedor` tinyint(1) NOT NULL,
  `if_user` tinyint(1) NOT NULL,
  `status_person` tinyint(1) NOT NULL,
  `created_person` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_person`, `cedula_person`, `tipo_person`, `nom_person`, `sexo_person`, `telefono_movil_person`, `telefono_casa_person`, `direccion_person`, `correo_person`, `cargo_id`, `if_proveedor`, `if_user`, `status_person`, `created_person`) VALUES
(1, '26587969', 'V', 'ALFREDO MENDEZZ', 'M', '0424 5198398', '', 'GASGSDFGSDFGSDFGSDFGSDFGSFGD', 'MENDEZ23_FASDFASD@GMAIL.COM', NULL, 1, 1, 1, '2021-11-18 22:38:38'),
(2, '14887889', 'V', 'ALFONSO MEDINA', 'M', '0424 5589669', '0255 6846698', 'FFASDFASDFASDFASDFASDFASDFASDFASDFASDF', 'ALFONSOMEDINA23@GMAIL.COM', NULL, 1, 1, 1, '2021-11-24 09:59:47'),
(3, '30400100', 'V', 'RONALDO PEREZ', 'M', '0424 5198396', '', 'FASDFASDFASDFASDFASDFASDFASDF', 'FASDFASDFASDFADS@GMAIL.COM', NULL, 0, 1, 1, '2021-12-05 10:58:34'),
(6, '29540849', 'V', 'JESUS RIVERO', 'F', '0424 4566646', '', 'FASDFASDFASDFASDFASDFASDF', 'FAFASFASDFASDFASDFASFADS@GMAIL.COM', NULL, 0, 0, 1, '2022-01-04 18:38:55'),
(7, '26674045', 'V', 'AAFAFAFFAFAF', 'M', '2342 3423422', '4242 4242442', 'KJKJFKJKJFKJKFJF', 'CAFKLFALFAQ@EJKLQJE.COM', NULL, 1, 1, 1, '2022-01-10 17:28:30'),
(9, '14542452', 'J', 'JOSESASDFASDFASDFASDF', 'M', '0424 5189965', '', 'FASDFADSFADSFASDF', 'FASDFADSFASDFASDFADSF@GMAIL.COM', NULL, 1, 0, 1, '2022-06-14 12:51:35'),
(12, '46456987', 'J', 'JOSEE MORAS', 'M', '0424 5198399', '', 'FASDFASDFASDFASDF', 'ASDFADFASDFADFADSF@GMAIL.COM', NULL, 1, 0, 1, '2022-06-14 13:12:27'),
(17, '26744045', 'V', 'CARLOS ORDO;EZ', 'M', '0424 5625680', '', 'AGUA LANCA', 'CARLOSORDONEZ@GMAIL.COM', 2, 0, 1, 1, '2022-10-17 09:43:42'),
(18, '8659318', 'V', 'JESUSSSSS', 'M', '3092 3523333', '3___ ___4234', 'AFWADVSV', 'KCASN34243KANC@GMAIL.COM', 2, 1, 1, 1, '2022-11-28 07:53:14'),
(19, '27132666', 'V', 'FASDFASDFASDFASDF', 'M', '0424 5616546', '', 'FASDFASDFASDFASDFASDFASDF', 'JESUSITOMORALES70@GMAIL.COM', 2, 0, 1, 1, '2023-03-28 09:28:13'),
(20, '12341234', 'V', 'MESSI RONALDO', 'M', '1231 3231312', '', 'ADSFFAFAFA', 'CEORMUSICPRODUCER@GMAIL.COM', 1, 0, 1, 1, '2023-04-10 19:13:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregun` int(11) NOT NULL,
  `des_pregun` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_pregun`, `des_pregun`) VALUES
(1, 'Color favorito'),
(2, 'Animal favorito'),
(3, 'SSSSSSSSSS'),
(4, 'EQUIPO FAVORITO DE FUTBOL'),
(5, 'MESSI O CRISTIANO?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_product` int(11) NOT NULL,
  `nom_product` varchar(50) NOT NULL,
  `med_product` varchar(20) NOT NULL,
  `valor_product` double NOT NULL,
  `status_product` tinyint(4) NOT NULL,
  `created_product` datetime NOT NULL,
  `stock_product` int(11) NOT NULL,
  `stock_maximo_product` int(11) NOT NULL,
  `marca_id_product` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_product`, `nom_product`, `med_product`, `valor_product`, `status_product`, `created_product`, `stock_product`, `stock_maximo_product`, `marca_id_product`) VALUES
(1, 'MORTADELA', 'KL', 1, 1, '2023-05-13 14:28:56', 25, 100, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_marca`
--

CREATE TABLE `proveedor_marca` (
  `pro_id_persona` int(11) NOT NULL,
  `pro_id_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuario`
--

CREATE TABLE `roles_usuario` (
  `id` int(11) NOT NULL,
  `nom_rol` varchar(12) NOT NULL,
  `nivel_permisos_rol` int(11) NOT NULL,
  `status_rol` tinyint(1) NOT NULL,
  `created_rol` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles_usuario`
--

INSERT INTO `roles_usuario` (`id`, `nom_rol`, `nivel_permisos_rol`, `status_rol`, `created_rol`) VALUES
(1, 'SUPER ADMIN', 3, 1, '2021-12-02 00:00:00'),
(2, 'ADMIN', 2, 1, '2021-12-02 00:00:00'),
(3, 'GENERAL', 1, 1, '2021-12-05 16:28:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `person_id_user` int(11) NOT NULL,
  `password_user` varchar(120) NOT NULL,
  `status_user` tinyint(1) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_user` datetime NOT NULL,
  `pregun1_user` int(11) NOT NULL,
  `pregun2_user` int(11) NOT NULL,
  `respuesta1_user` varchar(60) NOT NULL,
  `respuesta2_user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `person_id_user`, `password_user`, `status_user`, `id_rol`, `created_user`, `pregun1_user`, `pregun2_user`, `respuesta1_user`, `respuesta2_user`) VALUES
(1, 1, '$2y$12$ubs1WYLLAOCXirDYRzOF4.6a9UQvWx8jWET0ii9Kr0/gC8OzIZysK', 1, 1, '2021-11-23 02:08:10', 1, 2, 'NADA', 'NADA'),
(2, 3, '$2y$12$AGxghVHoNWTdArAy2NxoKuCRk6B74xAr9Wi.E1MUF3WAdTufZ6VC.', 1, 3, '2021-12-05 11:08:09', 2, 1, 'NADA', 'NADA'),
(4, 2, '$2y$12$D7e0XgYow5KmL.aQb5akGuOjzJt2/ZzURUPH.YarhL5VlXGwB8U.C', 1, 2, '2021-12-14 21:43:29', 1, 2, 'NADA', 'NADA'),
(7, 7, '$2y$12$7IgPN.1MtDRnZsJghBdObePaDgepj1xCaGLmKtsbtAYmNKBg8B3w2', 1, 3, '2022-01-10 17:30:30', 1, 2, 'NADA', 'NADA'),
(8, 19, '$2y$12$938Bagi2rVlHRHI6.x6cqOQS0FQJ28Hv2vtD2HhAVDr9S4P2Yy9Hu', 1, 3, '2023-03-28 10:21:47', 1, 2, 'NADA', 'NADA'),
(9, 20, '$2y$12$9.6VUrf.eyTE65zUqxO7z.YksNB5pukfDnkmD5Njpt.mYYiekHN1u', 1, 3, '2023-04-10 19:14:03', 4, 5, 'BARCELONA', 'MESSI');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_operacion`),
  ADD KEY `fk_usuarios` (`id_usuario`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  ADD PRIMARY KEY (`id_cod`),
  ADD UNIQUE KEY `char_code` (`char_code`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `comedor`
--
ALTER TABLE `comedor`
  ADD PRIMARY KEY (`id_comedor`),
  ADD KEY `encargado_comedor` (`encargado_comedor`);

--
-- Indices de la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD KEY `product_id_ope` (`product_id_ope`),
  ADD KEY `detalle_inventario_ibfk_2` (`invent_id_ope`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_invent`),
  ADD KEY `person_id_invent` (`person_id_invent`),
  ADD KEY `comedor_id_invent` (`comedor_id_invent`),
  ADD KEY `user_id_invent` (`user_id_invent`),
  ADD KEY `recibe_person_id_invent` (`recibe_person_id_invent`),
  ADD KEY `jornada_id_invent` (`jornada_id_invent`);

--
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id_jornada`),
  ADD KEY `menu_id_jornada` (`menu_id_jornada`),
  ADD KEY `person_id_responsable` (`person_id_responsable`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `menu_detalle`
--
ALTER TABLE `menu_detalle`
  ADD KEY `menu_id_detalle` (`menu_id_detalle`),
  ADD KEY `product_id_menu_detalle` (`product_id_menu_detalle`);

--
-- Indices de la tabla `permiso_vista`
--
ALTER TABLE `permiso_vista`
  ADD PRIMARY KEY (`id_per`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_person`),
  ADD UNIQUE KEY `cedula_person` (`cedula_person`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregun`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `marca_id_product` (`marca_id_product`);

--
-- Indices de la tabla `proveedor_marca`
--
ALTER TABLE `proveedor_marca`
  ADD KEY `pro_id_marca` (`pro_id_marca`),
  ADD KEY `pro_id_persona` (`pro_id_persona`);

--
-- Indices de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `person_id_user` (`person_id_user`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `usuarios_preguntas1` (`pregun1_user`),
  ADD KEY `usuarios_preguntas2` (`pregun2_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_operacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  MODIFY `id_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `comedor`
--
ALTER TABLE `comedor`
  MODIFY `id_comedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id_jornada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permiso_vista`
--
ALTER TABLE `permiso_vista`
  MODIFY `id_per` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `fk_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_user`);

--
-- Filtros para la tabla `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  ADD CONSTRAINT `codigos_recuperacion_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`);

--
-- Filtros para la tabla `comedor`
--
ALTER TABLE `comedor`
  ADD CONSTRAINT `encargado_comedor` FOREIGN KEY (`encargado_comedor`) REFERENCES `personas` (`id_person`);

--
-- Filtros para la tabla `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD CONSTRAINT `detalle_inventario_ibfk_1` FOREIGN KEY (`product_id_ope`) REFERENCES `productos` (`id_product`),
  ADD CONSTRAINT `detalle_inventario_ibfk_2` FOREIGN KEY (`invent_id_ope`) REFERENCES `inventario` (`id_invent`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`person_id_invent`) REFERENCES `personas` (`id_person`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`comedor_id_invent`) REFERENCES `comedor` (`id_comedor`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`user_id_invent`) REFERENCES `usuarios` (`id_user`),
  ADD CONSTRAINT `inventario_ibfk_4` FOREIGN KEY (`jornada_id_invent`) REFERENCES `jornada` (`id_jornada`),
  ADD CONSTRAINT `persona_quien_recibe` FOREIGN KEY (`recibe_person_id_invent`) REFERENCES `personas` (`id_person`);

--
-- Filtros para la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD CONSTRAINT `id_responsables` FOREIGN KEY (`person_id_responsable`) REFERENCES `personas` (`id_person`),
  ADD CONSTRAINT `jornada_ibfk_1` FOREIGN KEY (`menu_id_jornada`) REFERENCES `menu` (`id_menu`);

--
-- Filtros para la tabla `menu_detalle`
--
ALTER TABLE `menu_detalle`
  ADD CONSTRAINT `menu_detalle_ibfk_1` FOREIGN KEY (`menu_id_detalle`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_detalle_ibfk_2` FOREIGN KEY (`product_id_menu_detalle`) REFERENCES `productos` (`id_product`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permiso_vista`
--
ALTER TABLE `permiso_vista`
  ADD CONSTRAINT `permiso_vista_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id_user`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id_cargo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`marca_id_product`) REFERENCES `marca` (`id_marca`);

--
-- Filtros para la tabla `proveedor_marca`
--
ALTER TABLE `proveedor_marca`
  ADD CONSTRAINT `pro_marca` FOREIGN KEY (`pro_id_marca`) REFERENCES `marca` (`id_marca`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pro_persona` FOREIGN KEY (`pro_id_persona`) REFERENCES `personas` (`id_person`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `roles_fk` FOREIGN KEY (`id_rol`) REFERENCES `roles_usuario` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`person_id_user`) REFERENCES `personas` (`id_person`),
  ADD CONSTRAINT `usuarios_preguntas1` FOREIGN KEY (`pregun1_user`) REFERENCES `preguntas` (`id_pregun`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_preguntas2` FOREIGN KEY (`pregun2_user`) REFERENCES `preguntas` (`id_pregun`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
