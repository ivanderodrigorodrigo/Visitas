-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2024 a las 17:13:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_piis`
--
CREATE DATABASE IF NOT EXISTS `db_piis` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_piis`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_logs`
--

DROP TABLE IF EXISTS `app_logs`;
CREATE TABLE `app_logs` (
  `id_log` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `fecha_log` datetime DEFAULT NULL,
  `info_extra` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id_emp` int(11) NOT NULL,
  `dni_emp` varchar(9) NOT NULL,
  `nombre_emp` varchar(50) NOT NULL,
  `apellido_emp` varchar(100) NOT NULL,
  `email_emp` varchar(100) DEFAULT NULL,
  `contrasenya_emp` varchar(250) DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `activo_emp` char(1) DEFAULT 'S',
  `estado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_emp`, `dni_emp`, `nombre_emp`, `apellido_emp`, `email_emp`, `contrasenya_emp`, `rol_id`, `activo_emp`, `estado_id`) VALUES
(1, '12345678P', 'Admin', 'Admin', 'admin@gmail.com', '123456', 1, 'S', NULL);

--
-- Disparadores `empleados`
--
DROP TRIGGER IF EXISTS `EMPLEADOS_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `EMPLEADOS_AFTER_INSERT` AFTER INSERT ON `empleados` FOR EACH ROW BEGIN
 UPDATE empresa SET num_empleados = num_empleados + 1;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `EMPLEADOS_AFTER_UPDATE`;
DELIMITER $$
CREATE TRIGGER `EMPLEADOS_AFTER_UPDATE` AFTER UPDATE ON `empleados` FOR EACH ROW BEGIN
	DECLARE num_emp INT;
	set num_emp = (SELECT COUNT(*) FROM empleados WHERE activo_emp = 'S');
    
    UPDATE empresa SET num_empleados = num_emp;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nombre_empresa` varchar(100) DEFAULT NULL,
  `hora_ini_empresa` time DEFAULT NULL,
  `hora_fin_empresa` time DEFAULT NULL,
  `aforo_max_empresa` int(11) DEFAULT NULL,
  `num_empleados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre_empresa`, `hora_ini_empresa`, `hora_fin_empresa`, `aforo_max_empresa`, `num_empleados`) VALUES
(1, 'PresentiaL SL', '08:00:00', '18:00:00', 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_emp`
--

DROP TABLE IF EXISTS `estados_emp`;
CREATE TABLE `estados_emp` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_emp`
--

INSERT INTO `estados_emp` (`id_estado`, `nombre_estado`) VALUES
(1, 'Soltero/a'),
(2, 'Casado/a'),
(3, 'Divorciado/a'),
(4, 'Viudo/a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_visita`
--

DROP TABLE IF EXISTS `estados_visita`;
CREATE TABLE `estados_visita` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE `historico` (
  `id_historico` int(11) NOT NULL,
  `id_visita` int(11) NOT NULL,
  `fecha_alerta` datetime DEFAULT NULL,
  `acceso_denegado` char(1) DEFAULT 'N',
  `info_extra` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_roles`
--

DROP TABLE IF EXISTS `modulos_roles`;
CREATE TABLE `modulos_roles` (
  `id_modulo` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_visita`
--

DROP TABLE IF EXISTS `motivos_visita`;
CREATE TABLE `motivos_visita` (
  `id_motivo` int(11) NOT NULL,
  `descripcion_motivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Recepcionista'),
(3, 'Seguridad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

DROP TABLE IF EXISTS `roles_permisos`;
CREATE TABLE `roles_permisos` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

DROP TABLE IF EXISTS `visitantes`;
CREATE TABLE `visitantes` (
  `id_visitante` int(11) NOT NULL,
  `dni_visitante` varchar(9) NOT NULL,
  `nombre_visitante` varchar(50) NOT NULL,
  `apellido_visitante` varchar(100) NOT NULL,
  `email_visitante` varchar(100) NOT NULL,
  `verificado_visitante` char(1) DEFAULT 'N',
  `empresa_visitante` varchar(100) DEFAULT 'NA',
  `activo_visitante` char(1) DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

DROP TABLE IF EXISTS `visitas`;
CREATE TABLE `visitas` (
  `id_visita` int(11) NOT NULL,
  `id_visitante` int(11) NOT NULL,
  `fecha_visita` datetime DEFAULT NULL,
  `duracion_visita` int(11) DEFAULT NULL,
  `id_motivo` int(11) DEFAULT NULL,
  `invistacion` char(1) DEFAULT NULL,
  `id_emp_alta` int(11) NOT NULL,
  `fecha_entrada` datetime DEFAULT NULL,
  `fecha_salida` datetime DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `app_logs`
--
ALTER TABLE `app_logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_emp` (`id_emp`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_emp`),
  ADD UNIQUE KEY `dni_emp` (`dni_emp`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `estado_id` (`estado_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `estados_emp`
--
ALTER TABLE `estados_emp`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estados_visita`
--
ALTER TABLE `estados_visita`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id_historico`),
  ADD KEY `id_visita` (`id_visita`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `modulos_roles`
--
ALTER TABLE `modulos_roles`
  ADD PRIMARY KEY (`id_rol`,`id_modulo`);

--
-- Indices de la tabla `motivos_visita`
--
ALTER TABLE `motivos_visita`
  ADD PRIMARY KEY (`id_motivo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD PRIMARY KEY (`id_rol`,`id_permiso`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id_visitante`),
  ADD UNIQUE KEY `dni_visitante` (`dni_visitante`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_visitante` (`id_visitante`),
  ADD KEY `id_motivo` (`id_motivo`),
  ADD KEY `id_emp_alta` (`id_emp_alta`),
  ADD KEY `id_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `app_logs`
--
ALTER TABLE `app_logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados_emp`
--
ALTER TABLE `estados_emp`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados_visita`
--
ALTER TABLE `estados_visita`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historico`
--
ALTER TABLE `historico`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `motivos_visita`
--
ALTER TABLE `motivos_visita`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id_visitante` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `app_logs`
--
ALTER TABLE `app_logs`
  ADD CONSTRAINT `app_logs_ibfk_1` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estados_emp` (`id_estado`);

--
-- Filtros para la tabla `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visitas` (`id_visita`);

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `roles_permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `roles_permisos_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`);

--
-- Filtros para la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`id_visitante`) REFERENCES `visitantes` (`id_visitante`),
  ADD CONSTRAINT `visitas_ibfk_2` FOREIGN KEY (`id_motivo`) REFERENCES `motivos_visita` (`id_motivo`),
  ADD CONSTRAINT `visitas_ibfk_3` FOREIGN KEY (`id_emp_alta`) REFERENCES `empleados` (`id_emp`),
  ADD CONSTRAINT `visitas_ibfk_4` FOREIGN KEY (`id_estado`) REFERENCES `estados_visita` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
