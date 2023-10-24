-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2023 at 02:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyecto_iglesia2`
--

-- --------------------------------------------------------

--
-- Table structure for table `bitacora`
--

CREATE TABLE `bitacora` (
  `id_operacion` int NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tabla_change` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `hora_fecha` datetime DEFAULT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `bitacora`
--

INSERT INTO `bitacora` (`id_operacion`, `descripcion`, `tabla_change`, `hora_fecha`, `id_usuario`) VALUES
(1, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-07-21 21:31:00', 1),
(2, 'REGISTRO DE NUEVO MARCA: FASDFASDFASDF', 'MARCA', '2023-07-21 21:34:50', 1),
(3, 'REGISTRO DE NUEVO MARCA: FASDFASDF', 'MARCA', '2023-07-21 21:36:05', 1),
(4, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-07-21 21:37:36', 1),
(5, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-08-06 12:29:26', 1),
(6, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-08-06 13:03:55', 1),
(7, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-08-06 13:30:49', 1),
(8, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-08-06 13:44:41', 1),
(9, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-08-06 13:44:43', 1),
(10, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-08-06 13:52:36', 1),
(11, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-15 16:27:08', 1),
(12, 'REGISTRO DE NUEVO MARCA: GDFGDF', 'MARCA', '2023-10-15 16:32:03', 1),
(13, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-15 16:32:31', 1),
(14, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-16 21:44:02', 1),
(15, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-16 22:02:05', 1),
(16, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-16 22:58:56', 1),
(17, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-16 22:59:12', 1),
(18, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-21 15:51:50', 1),
(19, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-21 15:52:44', 1),
(20, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-21 15:53:10', 1),
(21, 'REGISTRO DE NUEVO MARCA: FSDFDF', 'MARCA', '2023-10-21 16:43:44', 1),
(22, 'REGISTRO DE NUEVO MARCA: DDDD', 'MARCA', '2023-10-21 16:46:42', 1),
(23, 'REGISTRO DE NUEVO CARGO: FDFDDDDDDDDDDDDD', 'CARGO', '2023-10-21 17:08:12', 1),
(24, 'REGISTRO DE NUEVO PRODUCTO: DDDDDDDDDDD, UNIDAD: KL, VALOR: 100, STOCK MAXIMO: 30', 'PRODUCTOS', '2023-10-21 17:11:02', 1),
(25, 'TRANSACIÓN DE REGISTRO DEL MENÚ: FGFGFGFG, ID DEL MENÚ: 1', 'MENU - MENU_DETALE', '2023-10-21 17:11:25', 1),
(26, 'REGISTRO DE NUEVO PRODUCTO: GFGFGFGFGFGFGF, UNIDAD: ML, VALOR: 1000, STOCK MAXIMO: 1000', 'PRODUCTOS', '2023-10-21 21:35:33', 1),
(27, 'ACTUALIZACIÓN DE MENÚ Y DETALLES DEL MENÚ: FGFGFGFG, ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-21 21:35:49', 1),
(28, 'ACTUALIZACIÓN DE MENÚ Y DETALLES DEL MENÚ: FGFGFGFG, ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-21 21:35:56', 1),
(29, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-23 03:10:42', 1),
(30, 'REGISTRO DE NUEVA JORNADA: GDFGDFGFD, DESCRIPCIÓN: FASFSAFSAFSF, CANTIDAD APROXIMADA DE BENEFICIADOS: 10', 'JORNADA', '2023-10-23 03:11:57', 1),
(31, 'ACTUALIZACIÓN DE JORNADA: , DESCRIPCIÓN: , CANTIDAD APROXIMADA DE BENEFICIADOS: 10, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 03:28:57', 1),
(32, 'ACTUALIZACIÓN DE JORNADA: NUEVO TITULOFASDFASDFASFSD, DESCRIPCIÓN: FASFSAFSAFSF, CANTIDAD APROXIMADA DE BENEFICIADOS: 10, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 03:29:52', 1),
(33, 'ACTUALIZACIÓN DE JORNADA: NUEVO TITULOFASDFASDFASFSD, DESCRIPCIÓN: FASFSAFSAFSF, CANTIDAD APROXIMADA DE BENEFICIADOS: 2, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 03:30:03', 1),
(34, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-23 03:39:55', 1),
(35, 'INICIO DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-23 20:05:54', 1),
(36, 'ACTUALIZACIÓN DE JORNADA: GDFGDFGFD, DESCRIPCIÓN: FASFSAFSAFSF, CANTIDAD APROXIMADA DE BENEFICIADOS: 10, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 20:49:29', 1),
(37, 'ACTUALIZACIÓN DE JORNADA -CANTIDAD APROXIMADA DE BENEFICIADOS: 2, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 20:50:18', 1),
(38, 'ACTUALIZACIÓN DETALLES DEL MENÚ => ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 20:50:47', 1),
(39, 'ACTUALIZACIÓN DE JORNADA -CANTIDAD APROXIMADA DE BENEFICIADOS: 1, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 20:51:06', 1),
(40, 'ACTUALIZACIÓN DETALLES DEL MENÚ => ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 20:52:58', 1),
(41, 'TRANSACCIÓN DE ENTRADA DE PRODUCTOS| ID INVENTARIO: E-00000006, CANTIDAD: 20, OBSERVACIÓN: ', 'INVENTARIO-DETALLE_INVENTARIO', '2023-10-23 22:14:29', 1),
(42, 'TRANSACCIÓN DE SALIDA DE PRODUCTOS| ID INVENTARIO: S-00000001, CANTIDAD: 0, OBSERVACIÓN: ', 'INVENTARIO - DETALLE_INVENTARIO', '2023-10-23 22:22:04', 1),
(43, 'TRANSACCIÓN DE SALIDA DE PRODUCTOS| ID INVENTARIO: S-00000002, CANTIDAD: 1, OBSERVACIÓN: FSDFSDFDSFD', 'INVENTARIO - DETALLE_INVENTARIO', '2023-10-23 22:24:00', 1),
(44, 'ACTUALIZACIÓN DE MENÚ Y DETALLES DEL MENÚ: FGFGFGFG, ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 22:24:54', 1),
(45, 'ACTUALIZACIÓN DE JORNADA: GDFGDFGFD, DESCRIPCIÓN: FASFSAFSAFSF, CANTIDAD APROXIMADA DE BENEFICIADOS: 100, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 22:25:37', 1),
(46, 'ACTUALIZACIÓN DE MENÚ Y DETALLES DEL MENÚ: FGFGFGFG, ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 22:25:54', 1),
(47, 'ACTUALIZACIÓN DETALLES DEL MENÚ => ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 22:26:15', 1),
(48, 'ACTUALIZACIÓN DETALLES DEL MENÚ => ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 22:26:28', 1),
(49, 'ACTUALIZACIÓN DE JORNADA -CANTIDAD APROXIMADA DE BENEFICIADOS: 2, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 22:26:44', 1),
(50, 'ACTUALIZACIÓN DE JORNADA: GDFGDFGFD, DESCRIPCIÓN: FASFSAFSAFSF, CANTIDAD APROXIMADA DE BENEFICIADOS: 100, ID DEL MENÚ => 1', 'JORNADA', '2023-10-23 22:27:00', 1),
(51, 'ACTUALIZACIÓN DETALLES DEL MENÚ => ID DEL MENU: 1', 'MENU - MENU_DETALLE', '2023-10-23 22:29:51', 1),
(52, 'SALIDA DE SESION DEL USUARIO: V-26587969, ALFREDO MENDEZZ', 'USUARIOS', '2023-10-23 22:31:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int NOT NULL,
  `des_cargo` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `estatus_cargo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `cargo`
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
(12, 'ALONSO', 1),
(13, 'FSDFSDF', 1),
(14, 'FDFDDDDDDDDDDDDD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `codigos_recuperacion`
--

CREATE TABLE `codigos_recuperacion` (
  `id_cod` int NOT NULL,
  `date_cod` datetime NOT NULL,
  `status_code` tinyint(1) NOT NULL,
  `char_code` char(8) COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `codigos_recuperacion`
--

INSERT INTO `codigos_recuperacion` (`id_cod`, `date_cod`, `status_code`, `char_code`, `id_user`) VALUES
(1, '2023-08-15 11:49:45', 0, 'LatwXTpJ', 8),
(2, '2023-10-16 22:56:08', 0, 'oLFl7Ywe', 8),
(3, '2023-10-16 22:57:04', 0, '95PZfsBG', 8),
(4, '2023-10-16 22:58:08', 1, 'vMqbHLfw', 8);

-- --------------------------------------------------------

--
-- Table structure for table `comedor`
--

CREATE TABLE `comedor` (
  `id_comedor` int NOT NULL,
  `nom_comedor` varchar(40) COLLATE utf8mb3_spanish_ci NOT NULL,
  `encargado_comedor` int NOT NULL,
  `direccion_comedor` varchar(120) COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_comedor` tinyint NOT NULL,
  `if_sede` tinyint(1) NOT NULL,
  `created_comedor` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `comedor`
--

INSERT INTO `comedor` (`id_comedor`, `nom_comedor`, `encargado_comedor`, `direccion_comedor`, `status_comedor`, `if_sede`, `created_comedor`) VALUES
(1, 'comedor1', 21, 'comedor1', 1, 1, '2023-10-23 07:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_inventario`
--

CREATE TABLE `detalle_inventario` (
  `product_id_ope` int NOT NULL,
  `invent_id_ope` char(10) COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_vencimiento_ope` datetime DEFAULT NULL,
  `precio_product_ope` double DEFAULT NULL,
  `detalle_cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `detalle_inventario`
--

INSERT INTO `detalle_inventario` (`product_id_ope`, `invent_id_ope`, `fecha_vencimiento_ope`, `precio_product_ope`, `detalle_cantidad`) VALUES
(1, 'E-00000001', NULL, 0, 25),
(2, 'E-00000006', NULL, 0, 20),
(2, 'S-00000001', NULL, NULL, 1),
(2, 'S-00000002', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `id_invent` char(10) COLLATE utf8mb3_spanish_ci NOT NULL,
  `orden_invent` varchar(20) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `cantidad_invent` int NOT NULL,
  `status_invent` tinyint NOT NULL,
  `created_invent` datetime DEFAULT NULL,
  `type_operacion_invent` enum('E','S') COLLATE utf8mb3_spanish_ci NOT NULL,
  `concept_invent` enum('C','D','O','V','R') COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `if_credito` tinyint(1) DEFAULT NULL,
  `jornada_id_invent` int DEFAULT NULL,
  `person_id_invent` int DEFAULT NULL,
  `recibe_person_id_invent` int DEFAULT NULL,
  `comedor_id_invent` int NOT NULL,
  `user_id_invent` int NOT NULL,
  `observacion_invent` varchar(120) COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `inventario`
--

INSERT INTO `inventario` (`id_invent`, `orden_invent`, `cantidad_invent`, `status_invent`, `created_invent`, `type_operacion_invent`, `concept_invent`, `if_credito`, `jornada_id_invent`, `person_id_invent`, `recibe_person_id_invent`, `comedor_id_invent`, `user_id_invent`, `observacion_invent`) VALUES
('E-00000001', '465465', 25, 1, '2023-10-23 20:05:00', 'E', 'C', 0, NULL, 2, 6, 1, 1, 'FASDFASDFASDFASDFASF'),
('E-00000002', '', 14, 1, '2023-10-23 22:06:00', 'E', 'C', 0, NULL, 1, 3, 1, 1, ''),
('E-00000003', '', 11, 1, '2023-10-23 22:08:00', 'E', 'C', 0, NULL, 1, 6, 1, 1, ''),
('E-00000004', '', 20, 1, '2023-10-23 22:09:00', 'E', 'C', 0, NULL, 1, 3, 1, 1, ''),
('E-00000005', '', 20, 1, '2023-10-23 22:11:00', 'E', 'C', 0, NULL, 1, 3, 1, 1, ''),
('E-00000006', '', 20, 1, '2023-10-23 22:12:00', 'E', 'C', 0, NULL, 1, 3, 1, 1, ''),
('S-00000001', NULL, 0, 1, '2023-10-23 22:21:00', 'S', 'O', NULL, 27, NULL, 1, 1, 1, NULL),
('S-00000002', NULL, 1, 1, '2023-10-23 22:23:00', 'S', 'O', NULL, 27, NULL, 3, 1, 1, 'FSDFSDFDSFD');

-- --------------------------------------------------------

--
-- Table structure for table `jornada`
--

CREATE TABLE `jornada` (
  `id_jornada` int NOT NULL,
  `titulo_jornada` varchar(30) COLLATE utf8mb3_spanish_ci NOT NULL,
  `des_jornada` varchar(120) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `cant_aproximada` int NOT NULL,
  `estatus_jornada` tinyint(1) NOT NULL,
  `fecha_jornada` date NOT NULL,
  `menu_id_jornada` int DEFAULT NULL,
  `person_id_responsable` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `jornada`
--

INSERT INTO `jornada` (`id_jornada`, `titulo_jornada`, `des_jornada`, `cant_aproximada`, `estatus_jornada`, `fecha_jornada`, `menu_id_jornada`, `person_id_responsable`) VALUES
(25, 'fsdfsdf', 'sdfsdfsdf', 12, 1, '2023-12-05', 1, 18),
(26, 'NUEVO TITULOFASDFASDFASFSD', 'FASFSAFSAFSF', 2, 1, '2023-10-31', 1, 2),
(27, 'GDFGDFGFD', 'FASFSAFSAFSF', 100, 1, '2023-10-23', 1, 2),
(28, 'GDFGDFGFD', 'FASFSAFSAFSF', 10, 1, '2023-10-31', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `id_marca` int NOT NULL,
  `nom_marca` varchar(40) COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_marca` tinyint NOT NULL,
  `created_marca` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `marca`
--

INSERT INTO `marca` (`id_marca`, `nom_marca`, `status_marca`, `created_marca`) VALUES
(1, 'FASDFASDFASDF', 1, '2023-07-21 21:34:50'),
(2, 'Mavesa', 1, '2023-07-21 21:36:05'),
(3, 'Polar', 1, '2023-07-21 21:34:50'),
(4, 'GDFGDF', 1, '2023-10-15 16:32:03'),
(5, 'FSDFDF', 1, '2023-10-21 16:43:44'),
(6, 'DDDD', 1, '2023-10-21 16:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int NOT NULL,
  `des_menu` varchar(30) COLLATE utf8mb3_spanish_ci NOT NULL,
  `des_procedimiento` varchar(200) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `status_menu` tinyint(1) NOT NULL,
  `created_menu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `des_menu`, `des_procedimiento`, `status_menu`, `created_menu`) VALUES
(1, 'FGFGFGFG', 'FSDFSDFSDDS', 1, '2023-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `menu_detalle`
--

CREATE TABLE `menu_detalle` (
  `menu_id_detalle` int NOT NULL,
  `product_id_menu_detalle` int NOT NULL,
  `consumo` int NOT NULL,
  `med_comida_detalle` char(2) COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `menu_detalle`
--

INSERT INTO `menu_detalle` (`menu_id_detalle`, `product_id_menu_detalle`, `consumo`, `med_comida_detalle`) VALUES
(1, 1, 1, 'KL');

-- --------------------------------------------------------

--
-- Table structure for table `permiso_vista`
--

CREATE TABLE `permiso_vista` (
  `id_per` int NOT NULL,
  `user_id` int NOT NULL,
  `modulo_name` varchar(30) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

CREATE TABLE `personas` (
  `id_person` int NOT NULL,
  `cedula_person` varchar(9) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo_person` char(1) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nom_person` varchar(60) COLLATE utf8mb3_spanish_ci NOT NULL,
  `sexo_person` enum('F','M') COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono_movil_person` varchar(12) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono_casa_person` varchar(12) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `direccion_person` varchar(120) COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo_person` varchar(130) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `cargo_id` int DEFAULT NULL,
  `if_proveedor` tinyint(1) NOT NULL,
  `if_user` tinyint(1) NOT NULL,
  `status_person` tinyint(1) NOT NULL,
  `created_person` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `personas`
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
(20, '12341234', 'V', 'MESSI RONALDO', 'M', '1231 3231312', '', 'ADSFFAFAFA', 'CEORMUSICPRODUCER@GMAIL.COM', 1, 0, 1, 1, '2023-04-10 19:13:11'),
(21, '2131231', 'V', 'SADASDCSDACA', 'M', '2131 2312312', '1232 1312312', 'DAFKLJDFKLJASDFDS', 'ADDFDAFADSFSDA@GMAIL.COM', 1, 0, 1, 1, '2023-05-15 13:52:17'),
(22, '32132134', 'V', 'CASKLHDLKJASD', 'M', '2134 2141343', '2131 2412412', 'DFADSFAFA', 'DSAFAFADFADFFF@GMAIL.COM', 1, 0, 1, 1, '2023-05-15 13:53:37'),
(23, '214124124', 'V', 'ACASCACASCAC', 'M', '1323 1231231', '2321 3123123', 'AFDSFADSFDSF', 'ASDADASDAFDSA@GMAIL.COM', 1, 0, 0, 1, '2023-05-15 13:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregun` int NOT NULL,
  `des_pregun` varchar(30) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`id_pregun`, `des_pregun`) VALUES
(1, 'Color favorito'),
(2, 'Animal favorito'),
(3, 'SSSSSSSSSS'),
(4, 'EQUIPO FAVORITO DE FUTBOL'),
(5, 'MESSI O CRISTIANO?'),
(6, 'ASDASD'),
(7, 'AAAAAAA');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_product` int NOT NULL,
  `nom_product` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `med_product` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `valor_product` double NOT NULL,
  `status_product` tinyint NOT NULL,
  `created_product` datetime NOT NULL,
  `stock_product` int NOT NULL,
  `stock_maximo_product` int NOT NULL,
  `marca_id_product` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_product`, `nom_product`, `med_product`, `valor_product`, `status_product`, `created_product`, `stock_product`, `stock_maximo_product`, `marca_id_product`) VALUES
(1, 'DDDDDDDDDDD', 'KL', 100, 1, '2023-10-21 17:11:02', 25, 30, 1),
(2, 'GFGFGFGFGFGFGF', 'ML', 1000, 1, '2023-10-21 21:35:33', 18, 1000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `proveedor_marca`
--

CREATE TABLE `proveedor_marca` (
  `pro_id_persona` int NOT NULL,
  `pro_id_marca` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_usuario`
--

CREATE TABLE `roles_usuario` (
  `id` int NOT NULL,
  `nom_rol` varchar(12) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nivel_permisos_rol` int NOT NULL,
  `status_rol` tinyint(1) NOT NULL,
  `created_rol` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `roles_usuario`
--

INSERT INTO `roles_usuario` (`id`, `nom_rol`, `nivel_permisos_rol`, `status_rol`, `created_rol`) VALUES
(1, 'SUPER ADMIN', 3, 1, '2021-12-02 00:00:00'),
(2, 'ADMIN', 2, 1, '2021-12-02 00:00:00'),
(3, 'GENERAL', 1, 1, '2021-12-05 16:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int NOT NULL,
  `person_id_user` int NOT NULL,
  `password_user` varchar(120) COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_user` tinyint(1) NOT NULL,
  `id_rol` int NOT NULL,
  `created_user` datetime NOT NULL,
  `pregun1_user` int NOT NULL,
  `pregun2_user` int NOT NULL,
  `respuesta1_user` varchar(60) COLLATE utf8mb3_spanish_ci NOT NULL,
  `respuesta2_user` varchar(60) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `person_id_user`, `password_user`, `status_user`, `id_rol`, `created_user`, `pregun1_user`, `pregun2_user`, `respuesta1_user`, `respuesta2_user`) VALUES
(1, 1, '$2y$12$ubs1WYLLAOCXirDYRzOF4.6a9UQvWx8jWET0ii9Kr0/gC8OzIZysK', 1, 1, '2021-11-23 02:08:10', 1, 2, 'NADA', 'NADA'),
(2, 3, '$2y$12$AGxghVHoNWTdArAy2NxoKuCRk6B74xAr9Wi.E1MUF3WAdTufZ6VC.', 1, 3, '2021-12-05 11:08:09', 2, 1, 'NADA', 'NADA'),
(4, 2, '$2y$12$D7e0XgYow5KmL.aQb5akGuOjzJt2/ZzURUPH.YarhL5VlXGwB8U.C', 1, 2, '2021-12-14 21:43:29', 1, 2, 'NADA', 'NADA'),
(7, 7, '$2y$12$7IgPN.1MtDRnZsJghBdObePaDgepj1xCaGLmKtsbtAYmNKBg8B3w2', 1, 3, '2022-01-10 17:30:30', 1, 2, 'NADA', 'NADA'),
(8, 19, '$2y$12$938Bagi2rVlHRHI6.x6cqOQS0FQJ28Hv2vtD2HhAVDr9S4P2Yy9Hu', 1, 3, '2023-03-28 10:21:47', 1, 2, 'NADA', 'NADA'),
(9, 20, '$2y$12$9.6VUrf.eyTE65zUqxO7z.YksNB5pukfDnkmD5Njpt.mYYiekHN1u', 1, 3, '2023-04-10 19:14:03', 4, 5, 'BARCELONA', 'MESSI'),
(10, 22, '$2y$12$ksh4u9NOg6lWSoIq/qCqxeRErLCDhZQKRdYTEGFPMIMNpfxoDR9ke', 1, 3, '2023-10-16 22:29:29', 1, 2, 'NADA', 'NADA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_operacion`),
  ADD KEY `fk_usuarios` (`id_usuario`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  ADD PRIMARY KEY (`id_cod`),
  ADD UNIQUE KEY `char_code` (`char_code`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `comedor`
--
ALTER TABLE `comedor`
  ADD PRIMARY KEY (`id_comedor`),
  ADD KEY `encargado_comedor` (`encargado_comedor`);

--
-- Indexes for table `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD KEY `product_id_ope` (`product_id_ope`),
  ADD KEY `detalle_inventario_ibfk_2` (`invent_id_ope`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_invent`),
  ADD KEY `person_id_invent` (`person_id_invent`),
  ADD KEY `comedor_id_invent` (`comedor_id_invent`),
  ADD KEY `user_id_invent` (`user_id_invent`),
  ADD KEY `recibe_person_id_invent` (`recibe_person_id_invent`),
  ADD KEY `jornada_id_invent` (`jornada_id_invent`);

--
-- Indexes for table `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id_jornada`),
  ADD KEY `menu_id_jornada` (`menu_id_jornada`),
  ADD KEY `person_id_responsable` (`person_id_responsable`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `menu_detalle`
--
ALTER TABLE `menu_detalle`
  ADD KEY `menu_id_detalle` (`menu_id_detalle`),
  ADD KEY `product_id_menu_detalle` (`product_id_menu_detalle`);

--
-- Indexes for table `permiso_vista`
--
ALTER TABLE `permiso_vista`
  ADD PRIMARY KEY (`id_per`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_person`),
  ADD UNIQUE KEY `cedula_person` (`cedula_person`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indexes for table `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregun`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `marca_id_product` (`marca_id_product`);

--
-- Indexes for table `proveedor_marca`
--
ALTER TABLE `proveedor_marca`
  ADD KEY `pro_id_marca` (`pro_id_marca`),
  ADD KEY `pro_id_persona` (`pro_id_persona`);

--
-- Indexes for table `roles_usuario`
--
ALTER TABLE `roles_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `person_id_user` (`person_id_user`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `usuarios_preguntas1` (`pregun1_user`),
  ADD KEY `usuarios_preguntas2` (`pregun2_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_operacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  MODIFY `id_cod` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comedor`
--
ALTER TABLE `comedor`
  MODIFY `id_comedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id_jornada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permiso_vista`
--
ALTER TABLE `permiso_vista`
  MODIFY `id_per` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id_person` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles_usuario`
--
ALTER TABLE `roles_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `fk_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_user`);

--
-- Constraints for table `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  ADD CONSTRAINT `codigos_recuperacion_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`);

--
-- Constraints for table `comedor`
--
ALTER TABLE `comedor`
  ADD CONSTRAINT `encargado_comedor` FOREIGN KEY (`encargado_comedor`) REFERENCES `personas` (`id_person`);

--
-- Constraints for table `detalle_inventario`
--
ALTER TABLE `detalle_inventario`
  ADD CONSTRAINT `detalle_inventario_ibfk_1` FOREIGN KEY (`product_id_ope`) REFERENCES `productos` (`id_product`),
  ADD CONSTRAINT `detalle_inventario_ibfk_2` FOREIGN KEY (`invent_id_ope`) REFERENCES `inventario` (`id_invent`);

--
-- Constraints for table `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`person_id_invent`) REFERENCES `personas` (`id_person`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`comedor_id_invent`) REFERENCES `comedor` (`id_comedor`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`user_id_invent`) REFERENCES `usuarios` (`id_user`),
  ADD CONSTRAINT `inventario_ibfk_4` FOREIGN KEY (`jornada_id_invent`) REFERENCES `jornada` (`id_jornada`),
  ADD CONSTRAINT `persona_quien_recibe` FOREIGN KEY (`recibe_person_id_invent`) REFERENCES `personas` (`id_person`);

--
-- Constraints for table `jornada`
--
ALTER TABLE `jornada`
  ADD CONSTRAINT `id_responsables` FOREIGN KEY (`person_id_responsable`) REFERENCES `personas` (`id_person`),
  ADD CONSTRAINT `jornada_ibfk_1` FOREIGN KEY (`menu_id_jornada`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `menu_detalle`
--
ALTER TABLE `menu_detalle`
  ADD CONSTRAINT `menu_detalle_ibfk_1` FOREIGN KEY (`menu_id_detalle`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_detalle_ibfk_2` FOREIGN KEY (`product_id_menu_detalle`) REFERENCES `productos` (`id_product`) ON DELETE CASCADE;

--
-- Constraints for table `permiso_vista`
--
ALTER TABLE `permiso_vista`
  ADD CONSTRAINT `permiso_vista_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id_user`);

--
-- Constraints for table `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id_cargo`) ON UPDATE CASCADE;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`marca_id_product`) REFERENCES `marca` (`id_marca`);

--
-- Constraints for table `proveedor_marca`
--
ALTER TABLE `proveedor_marca`
  ADD CONSTRAINT `pro_marca` FOREIGN KEY (`pro_id_marca`) REFERENCES `marca` (`id_marca`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pro_persona` FOREIGN KEY (`pro_id_persona`) REFERENCES `personas` (`id_person`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
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
