-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 11-01-2022 a las 23:40:59
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_iglesia`
--
CREATE DATABASE IF NOT EXISTS `proyecto_iglesia2` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `proyecto_iglesia2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comedor`
--

CREATE TABLE `comedor` (
  `id_comedor` int(11) NOT NULL,
  `nom_comedor` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `encargado_comedor` int(11) NOT NULL,
  `direccion_comedor` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `status_comedor` tinyint(4) NOT NULL,
  `created_comedor` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_inventario`
--

CREATE TABLE `detalle_inventario` (
  `product_id_ope` int(11) NOT NULL,
  `invent_id_ope` char(10) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_vencimiento_ope` datetime DEFAULT NULL,
  `precio_product_ope` double DEFAULT NULL,
  `detalle_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_invent` char(10) COLLATE utf8_spanish_ci NOT NULL,
  `orden_invent` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cantidad_invent` int(11) NOT NULL,
  `status_invent` tinyint(4) NOT NULL,
  `created_invent` datetime DEFAULT NULL,
  `type_operacion_invent` enum('E','S') COLLATE utf8_spanish_ci NOT NULL,
  `concept_invent` enum('C','D','O','V','R') COLLATE utf8_spanish_ci DEFAULT NULL,
  `person_id_invent` int(11) DEFAULT NULL,
  `recibe_person_id_invent` int(11) DEFAULT NULL,
  `comedor_id_invent` int(11) NOT NULL,
  `user_id_invent` int(11) NOT NULL,
  `observacion_invent` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nom_marca` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `status_marca` tinyint(4) NOT NULL,
  `created_marca` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_person` int(11) NOT NULL,
  `cedula_person` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_person` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nom_person` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `sexo_person` enum('F','M') COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono_movil_person` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono_casa_person` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion_person` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `correo_person` varchar(130) COLLATE utf8_spanish_ci DEFAULT NULL,
  `if_proveedor` tinyint(1) NOT NULL,
  `if_user` tinyint(1) NOT NULL,
  `status_person` tinyint(1) NOT NULL,
  `created_person` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_person`, `cedula_person`, `tipo_person`, `nom_person`, `sexo_person`, `telefono_movil_person`, `telefono_casa_person`, `direccion_person`, `correo_person`, `if_proveedor`, `if_user`, `status_person`, `created_person`) VALUES
(1, '26587969', 'V', 'ALFREDO MENDEZZ', 'M', '0424 5198398', '', 'GASGSDFGSDFGSDFGSDFGSDFGSFGD', 'MENDEZ23_FASDFASD@GMAIL.COM', 1, 1, 1, '2021-11-18 22:38:38'),
(2, '14887889', 'V', 'ALFONSO MEDINA', 'M', '0424 5589669', '0255 6846698', 'FFASDFASDFASDFASDFASDFASDFASDFASDFASDF', 'ALFONSOMEDINA23@GMAIL.COM', 1, 1, 1, '2021-11-24 09:59:47'),
(3, '30400100', 'V', 'RONALDO PEREZ', 'M', '0424 5198396', '', 'FASDFASDFASDFASDFASDFASDFASDF', 'FASDFASDFASDFADS@GMAIL.COM', 0, 1, 1, '2021-12-05 10:58:34'),
(4, '27132642', 'V', 'JESUS MORALES', 'M', '0424 5198398', '', 'FASDFADSFADSFASDFASDFASDF', 'FASDFASDFASDF@GMAIL.COM', 1, 1, 1, '2021-12-14 21:56:01'),
(5, '30400110', 'V', 'CARLOS TORRES', 'M', '0424 5198398', '', 'FASDFASDFASDFASDFASDF', 'FASDFASFASDFA@GMAIL.COM', 0, 1, 1, '2021-12-15 12:53:11'),
(6, '29540849', 'V', 'JESUS RIVERO', 'F', '0424 4566646', '', 'FASDFASDFASDFASDFASDFASDF', 'FAFASFASDFASDFASDFASFADS@GMAIL.COM', 0, 0, 1, '2022-01-04 18:38:55'),
(7, '26674045', 'V', 'AAFAFAFFAFAF', 'M', '2342 3423422', '4242 4242442', 'KJKJFKJKJFKJKFJF', 'CAFKLFALFAQ@EJKLQJE.COM', 1, 1, 1, '2022-01-10 17:28:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregun` int(11) NOT NULL,
  `des_pregun` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_pregun`, `des_pregun`) VALUES
(1, 'Color favorito'),
(2, 'Animal favorito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_product` int(11) NOT NULL,
  `nom_product` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `med_product` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `valor_product` double NOT NULL,
  `status_product` tinyint(4) NOT NULL,
  `created_product` datetime NOT NULL,
  `stock_product` int(11) NOT NULL,
  `marca_id_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id_respues` int(11) NOT NULL,
  `des_respues` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `pregun_id_respues` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id_respues`, `des_respues`, `pregun_id_respues`) VALUES
(1, 'azul', 1),
(2, 'rojo', 1),
(3, 'perro', 2),
(4, 'gato', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuario`
--

CREATE TABLE `roles_usuario` (
  `id` int(11) NOT NULL,
  `nom_rol` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
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
  `password_user` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `status_user` tinyint(1) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_user` datetime NOT NULL,
  `pregun1_user` int(11) NOT NULL,
  `pregun2_user` int(11) NOT NULL,
  `respuesta1_user` int(11) NOT NULL,
  `respuesta2_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `person_id_user`, `password_user`, `status_user`, `id_rol`, `created_user`, `pregun1_user`, `pregun2_user`, `respuesta1_user`, `respuesta2_user`) VALUES
(1, 1, '$2y$12$tu6ib2eWHywHPEzQyDCjR.7R/Cfc6kb7f2ou8NDXf2Fer94BIQnqS', 1, 1, '2021-11-23 02:08:10', 1, 2, 1, 4),
(2, 3, '$2y$12$AGxghVHoNWTdArAy2NxoKuCRk6B74xAr9Wi.E1MUF3WAdTufZ6VC.', 1, 3, '2021-12-05 11:08:09', 2, 1, 3, 2),
(4, 2, '$2y$12$D7e0XgYow5KmL.aQb5akGuOjzJt2/ZzURUPH.YarhL5VlXGwB8U.C', 1, 2, '2021-12-14 21:43:29', 1, 2, 1, 3),
(5, 4, '$2y$12$si90t.l91IB4HFuaoWnsluU1sLxpu5yvoF5feoZnu2mKiIybgvuB.', 1, 3, '2021-12-14 21:56:41', 1, 2, 1, 4),
(6, 5, '$2y$12$QZj0K7DWxY84cIGEqUXvE.07GHWe7hiTkfhS2cj9aBvazK1eBJFnC', 1, 2, '2021-12-15 13:11:43', 2, 1, 3, 1),
(7, 7, '$2y$12$7IgPN.1MtDRnZsJghBdObePaDgepj1xCaGLmKtsbtAYmNKBg8B3w2', 1, 3, '2022-01-10 17:30:30', 1, 2, 1, 3);

--
-- Índices para tablas volcadas
--

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
  ADD KEY `recibe_person_id_invent` (`recibe_person_id_invent`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_person`),
  ADD UNIQUE KEY `cedula_person` (`cedula_person`);

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
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id_respues`),
  ADD KEY `pregun_id_respues` (`pregun_id_respues`);

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
  ADD KEY `usuarios_preguntas2` (`pregun2_user`),
  ADD KEY `usuarios_respuestas1` (`respuesta1_user`),
  ADD KEY `usuarios_respuestas2` (`respuesta2_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comedor`
--
ALTER TABLE `comedor`
  MODIFY `id_comedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id_respues` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles_usuario`
--
ALTER TABLE `roles_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

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
  ADD CONSTRAINT `persona_quien_recibe` FOREIGN KEY (`recibe_person_id_invent`) REFERENCES `personas` (`id_person`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`marca_id_product`) REFERENCES `marca` (`id_marca`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`pregun_id_respues`) REFERENCES `preguntas` (`id_pregun`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `roles_fk` FOREIGN KEY (`id_rol`) REFERENCES `roles_usuario` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`person_id_user`) REFERENCES `personas` (`id_person`),
  ADD CONSTRAINT `usuarios_preguntas1` FOREIGN KEY (`pregun1_user`) REFERENCES `preguntas` (`id_pregun`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_preguntas2` FOREIGN KEY (`pregun2_user`) REFERENCES `preguntas` (`id_pregun`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_respuestas1` FOREIGN KEY (`respuesta1_user`) REFERENCES `respuestas` (`id_respues`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_respuestas2` FOREIGN KEY (`respuesta2_user`) REFERENCES `respuestas` (`id_respues`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
