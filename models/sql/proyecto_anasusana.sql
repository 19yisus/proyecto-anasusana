-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2023 at 02:36 AM
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
-- Database: `proyecto_anasusana`
--
CREATE DATABASE IF NOT EXISTS `proyecto_anasusana` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci;
USE `proyecto_anasusana`;

-- --------------------------------------------------------

--
-- Table structure for table `bitacora`
--

CREATE TABLE `bitacora` (
  `id_operacion` int NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `tabla_change` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `hora_fecha` datetime DEFAULT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int NOT NULL,
  `des_cargo` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `estatus_cargo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `codigos_recuperacion`
--

CREATE TABLE `codigos_recuperacion` (
  `id_cod` int NOT NULL,
  `date_cod` datetime NOT NULL,
  `status_code` tinyint(1) NOT NULL,
  `char_code` char(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comedor`
--

CREATE TABLE `comedor` (
  `id_comedor` int NOT NULL,
  `nom_comedor` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `encargado_comedor` int NOT NULL,
  `direccion_comedor` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
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
  `invent_id_ope` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_vencimiento_ope` datetime DEFAULT NULL,
  `precio_product_ope` double DEFAULT NULL,
  `detalle_cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `id_invent` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `orden_invent` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `cantidad_invent` int NOT NULL,
  `status_invent` tinyint NOT NULL,
  `created_invent` datetime DEFAULT NULL,
  `type_operacion_invent` enum('E','S') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `concept_invent` enum('C','D','O','V','R') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `if_credito` tinyint(1) DEFAULT NULL,
  `jornada_id_invent` int DEFAULT NULL,
  `person_id_invent` int DEFAULT NULL,
  `recibe_person_id_invent` int DEFAULT NULL,
  `comedor_id_invent` int NOT NULL,
  `user_id_invent` int NOT NULL,
  `observacion_invent` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jornada`
--

CREATE TABLE `jornada` (
  `id_jornada` int NOT NULL,
  `titulo_jornada` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `des_jornada` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `cant_aproximada` int NOT NULL,
  `estatus_jornada` tinyint(1) NOT NULL,
  `fecha_jornada` date NOT NULL,
  `menu_id_jornada` int DEFAULT NULL,
  `person_id_responsable` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `id_marca` int NOT NULL,
  `nom_marca` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_marca` tinyint NOT NULL,
  `created_marca` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int NOT NULL,
  `des_menu` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `des_procedimiento` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `status_menu` tinyint(1) NOT NULL,
  `created_menu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_detalle`
--

CREATE TABLE `menu_detalle` (
  `menu_id_detalle` int NOT NULL,
  `product_id_menu_detalle` int NOT NULL,
  `consumo` int NOT NULL,
  `med_comida_detalle` char(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permiso_vista`
--

CREATE TABLE `permiso_vista` (
  `id_per` int NOT NULL,
  `user_id` int NOT NULL,
  `modulo_name` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

CREATE TABLE `personas` (
  `id_person` int NOT NULL,
  `cedula_person` varchar(9) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo_person` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nom_person` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `sexo_person` enum('F','M','N') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono_movil_person` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono_casa_person` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `direccion_person` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo_person` varchar(130) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
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
(1, '26587969', 'V', 'ALFREDO MENDEZZ', 'M', '0424 5198398', '', 'GASGSDFGSDFGSDFGSDFGSDFGSFGD', 'MENDEZ23_FASDFASD@GMAIL.COM', NULL, 1, 1, 1, '2021-11-18 22:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregun` int NOT NULL,
  `des_pregun` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`id_pregun`, `des_pregun`) VALUES
(1, 'Color favorito'),
(2, 'Animal favorito');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_product` int NOT NULL,
  `nom_product` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `med_product` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `valor_product` double NOT NULL,
  `status_product` tinyint NOT NULL,
  `created_product` datetime NOT NULL,
  `stock_product` int NOT NULL,
  `stock_maximo_product` int NOT NULL,
  `marca_id_product` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

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
  `nom_rol` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
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
  `password_user` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_user` tinyint(1) NOT NULL,
  `id_rol` int NOT NULL,
  `created_user` datetime NOT NULL,
  `pregun1_user` int NOT NULL,
  `pregun2_user` int NOT NULL,
  `respuesta1_user` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `respuesta2_user` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `person_id_user`, `password_user`, `status_user`, `id_rol`, `created_user`, `pregun1_user`, `pregun2_user`, `respuesta1_user`, `respuesta2_user`) VALUES
(1, 1, '$2y$12$ubs1WYLLAOCXirDYRzOF4.6a9UQvWx8jWET0ii9Kr0/gC8OzIZysK', 1, 1, '2021-11-23 02:08:10', 1, 2, 'NADA', 'NADA');

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
  MODIFY `id_operacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `codigos_recuperacion`
--
ALTER TABLE `codigos_recuperacion`
  MODIFY `id_cod` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comedor`
--
ALTER TABLE `comedor`
  MODIFY `id_comedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id_jornada` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permiso_vista`
--
ALTER TABLE `permiso_vista`
  MODIFY `id_per` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id_person` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles_usuario`
--
ALTER TABLE `roles_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
