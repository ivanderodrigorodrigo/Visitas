-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2024 a las 14:44:01
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_navs` (IN `id_rol` INT)   SELECT
	m.id_modulo as id,
    m.nombre_modulo AS nav_principal,
    m.url_modulo AS url_principal,
    CASE
        WHEN ms.id_modulo IS NOT NULL THEN GROUP_CONCAT(ms.id_modulo SEPARATOR ',')
        ELSE NULL
    END AS nav_secundaria,
    n.iconos
FROM
    modulos m
INNER JOIN
    navs n ON n.id_modulo = m.id_modulo AND id_nav_parent IS NULL
INNER JOIN
    modulos_roles mrp ON m.id_modulo = mrp.id_modulo AND mrp.id_rol = id_rol
LEFT JOIN
    navs ns ON ns.id_nav_parent = n.id_nav
LEFT JOIN
    modulos ms ON ns.id_modulo = ms.id_modulo
LEFT JOIN
    modulos_roles mrs ON ms.id_modulo = mrs.id_modulo
WHERE
    (ms.id_modulo IS NULL AND mrp.id_rol = id_rol)
    OR (ms.id_modulo IS NOT NULL AND mrs.id_rol = id_rol)
GROUP BY
    m.nombre_modulo, m.url_modulo, n.iconos
ORDER BY
    n.id_nav ASC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_logs`
--

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

CREATE TABLE `empleados` (
  `id_emp` int(11) NOT NULL,
  `dni_emp` varchar(9) NOT NULL,
  `nombre_emp` varchar(50) NOT NULL,
  `apellido_emp` varchar(100) NOT NULL,
  `email_emp` varchar(150) DEFAULT NULL,
  `contrasenya_emp` varchar(250) DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `activo_emp` char(1) DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_emp`, `dni_emp`, `nombre_emp`, `apellido_emp`, `email_emp`, `contrasenya_emp`, `rol_id`, `activo_emp`) VALUES
(1, '12345678P', 'Admin', 'Administrador', 'admin@gmail.com', '$2y$10$G05GbSSEuAqPobMWp3EFkOORlSSxL9uyr4yii7ocaX7xNrMrONtxS', 1, 'S'),
(4, '87687178Z', 'Juan', 'Garcia', 'jgarcia@example.com', '$2y$10$vXH4zhzYfI63pIcwCNMEV.4p.0XRuQVlimT3Rw3wM5QydYgx5QdQC', 2, ''),
(5, '35854895M', 'Ana', 'Fernandez Gimenez', 'afernandez@examples.com', NULL, 3, 'U'),
(6, '37983440F', 'Pedro', 'Lopez', 'plopez@examples.com', NULL, 1, 'N'),
(7, '35809797D', 'Luisa', 'Martinez', 'lmartinez@examples.com', NULL, 2, 'S'),
(8, '89075515L', 'Carlos', 'Sanchez', 'csanchez@example.com', NULL, 1, 'S'),
(9, '87844489I', 'Maria', 'Rodriguez', 'mrodriguez@example.com', NULL, 1, 'S'),
(10, '29958370O', 'Jorge', 'Perez', 'jperez@example.com', NULL, 1, 'S'),
(11, '45871133S', 'Elena', 'Gomez', 'egomez@example.com', NULL, 1, 'S'),
(13, '27829812Q', 'Sofia', 'Diaz', 'sdiaz@example.com', NULL, 1, 'S'),
(14, '83780618X', 'Jorge', 'Fernandez', 'jfernandez@example.com', NULL, 3, 'S'),
(15, '42978275T', 'Elena', 'Fernandez', 'efernandez@example.com', NULL, 2, 'S'),
(16, '16201746G', 'Carlos', 'Rodriguez', 'crodriguez@example.com', NULL, 3, 'S'),
(17, '33624953F', 'Sofia', 'Martinez', 'smartinez@example.com', NULL, 3, 'S'),
(18, '91283320C', 'Ana', 'Lopez', 'alopez@example.com', NULL, 2, 'S'),
(19, '89358767Y', 'Jorge', 'Sanchez', 'jsanchez@example.com', NULL, 2, 'S'),
(21, '30806719P', 'Pedro', 'Garcia', 'pgarcia@example.com', NULL, 2, 'S'),
(22, '08684829C', 'Roberto', 'Sanchez', 'rsanchez@example.com', NULL, 2, 'S'),
(23, '57697950I', 'Roberto', 'Ruiz', 'rruiz@example.com', '$2y$10$UrVdDQC54ceclaF4.0QJwOvvH3D1tnzv1uXIQCejeR96P5cMepbEC', 3, 'S'),
(24, '0', 'test', 'test', 'test@test', '$2y$10$exOxSOsiqQpHS.Gmxh1dF.VbBdwOYnXIAmH8UBdiFfLSLcXGxS5Ui', 1, 'S');

--
-- Disparadores `empleados`
--
DELIMITER $$
CREATE TRIGGER `EMPLEADOS_AFTER_INSERT` AFTER INSERT ON `empleados` FOR EACH ROW BEGIN
 UPDATE empresa SET num_empleados = num_empleados + 1;
END
$$
DELIMITER ;
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
(1, 'PresentiaL SL', '08:00:00', '18:00:00', 100, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_visita`
--

CREATE TABLE `estados_visita` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

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

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(50) DEFAULT NULL,
  `url_modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`, `url_modulo`) VALUES
(1, 'Inicio sesión', 'login'),
(2, 'Empleados', 'empleados'),
(3, 'Detalles empleados', 'empleadosCRUD'),
(4, 'Visitas', 'visitas'),
(5, 'Roles y permisos', 'rolespermisos'),
(6, 'Informes', ''),
(7, 'Historial de visitas', 'historial'),
(8, 'Análisis estadístico', 'analisis'),
(9, 'Búsqueda empleados', 'empleadosSearch'),
(10, 'Cambiar contraseña', 'changePassword'),
(11, 'Inicio', 'home');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_roles`
--

CREATE TABLE `modulos_roles` (
  `id_modulo` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `modulo_default` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulos_roles`
--

INSERT INTO `modulos_roles` (`id_modulo`, `id_rol`, `modulo_default`) VALUES
(1, 1, 'N'),
(1, 2, 'N'),
(1, 3, 'N'),
(2, 1, 'N'),
(2, 3, 'N'),
(3, 1, 'N'),
(3, 2, 'N'),
(3, 3, 'N'),
(4, 1, 'N'),
(4, 2, 'N'),
(5, 1, 'N'),
(6, 1, 'N'),
(6, 2, 'N'),
(6, 3, 'N'),
(7, 1, 'N'),
(7, 2, 'N'),
(7, 3, 'N'),
(8, 1, 'N'),
(8, 3, 'N'),
(9, 1, 'N'),
(9, 3, 'N'),
(9, 4, 'N'),
(10, 1, 'N'),
(10, 2, 'N'),
(10, 3, 'N'),
(10, 4, 'N'),
(11, 1, 'S'),
(11, 2, 'S'),
(11, 3, 'S'),
(11, 4, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_visita`
--

CREATE TABLE `motivos_visita` (
  `id_motivo` int(11) NOT NULL,
  `descripcion_motivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `navs`
--

CREATE TABLE `navs` (
  `id_nav` int(11) NOT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `id_nav_parent` int(11) DEFAULT NULL,
  `iconos` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `navs`
--

INSERT INTO `navs` (`id_nav`, `id_modulo`, `id_nav_parent`, `iconos`) VALUES
(1, 2, NULL, 'fa-users'),
(2, 4, NULL, 'fa-calendar-alt'),
(3, 5, NULL, 'fa-tools'),
(4, 6, NULL, 'fa-chart-line'),
(5, 7, 4, ''),
(6, 8, 4, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`) VALUES
(1, 'Edicion Informes'),
(2, 'Edicion Empleados'),
(3, 'Edicion Visitas'),
(4, 'Registrar empleados'),
(6, 'Eliminar empleados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

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
(3, 'Seguridad'),
(4, 'Empleados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`id_rol`, `id_permiso`) VALUES
(2, 3),
(3, 1),
(4, 3),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `id_visitante` int(11) NOT NULL,
  `dni_visitante` varchar(9) NOT NULL,
  `nombre_visitante` varchar(50) NOT NULL,
  `apellido_visitante` varchar(100) NOT NULL,
  `email_visitante` varchar(100) NOT NULL,
  `verificado_visitante` char(1) DEFAULT 'N',
  `empresa_visitante` varchar(100) DEFAULT 'NA',
  `activo_visitante` char(1) DEFAULT 'S',
  `fecha_visita` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`id_visitante`, `dni_visitante`, `nombre_visitante`, `apellido_visitante`, `email_visitante`, `verificado_visitante`, `empresa_visitante`, `activo_visitante`, `fecha_visita`) VALUES
(2, '03030303', 'dsdfs', 'effs', 'sdfsf@cx', 'N', 'efsf', 'N', '2024-03-27 00:00:00'),
(3, '00434234', 'Paco', 'Pil', 'paco@sdfds', 'N', 'WESTCON INTERNATIONAL LTD', 'N', '2024-03-28 00:00:00'),
(4, '0034234', 'odsfsd', 'dsafas', 'odfa@sd', 'N', 'adfa', 'N', '2024-04-06 00:00:00'),
(5, 's', 's', 's', 's@s', 'N', 'sdfs', 'N', '2024-03-27 00:00:00'),
(7, '0000232', 'dafdf', 'safdf', 'dfd@dsfdsf', 'N', 'dfdsf', 'N', '2024-03-28 00:00:00'),
(9, '03030303s', 'ewrer', 'werewr', 'fsdfs@sdfsdf', 'N', 'sdfsdf', 'N', '2024-03-27 00:00:00'),
(10, '029', 'dsf', 'sd', 'sdf@s', 'N', 'sdfsdf3', 'N', '2024-03-29 00:00:00'),
(11, '03423', 'ffd', 'saff', 'dsff@sfsd', 'N', 'sfasdfsf', 'N', '2024-03-30 00:00:00'),
(12, '02343', 'sdfsdf', 'sfafsafw', 'aff@sfsd', 'N', 'sfsfaf', 'N', '2024-03-23 00:00:00'),
(13, '043532', 'gfdgds', 'dgsdg', 'dgdsg@sg', 'N', 'dgdg', 'S', '2024-03-28 00:00:00'),
(14, '4543', 'gdfg', 'dgdfggd', 'dgfdsgdsgf@af', 'N', 'sfgdf', 'N', '2024-03-30 00:00:00'),
(15, '030434ff', 'efr', 'ff', 'f@ds', 'N', 'd', 'N', '2024-03-15 00:00:00'),
(16, '242342314', 'ffdfdsg94l', 'egeg', 'fger@dgfdg', 'N', 'dgdgd', 'N', '2024-03-28 00:00:00'),
(17, '4243', 'fdgs', 'gdf', 'dgdf@d', 'N', 'dgfg', 'N', '2024-03-30 00:00:00'),
(18, '324234', 'fsfsd', 'sdgg', 'dgf@df', 'N', 'dgdfg', 'N', '2024-03-28 00:00:00'),
(19, '999', 'dfdf', 'sggre', 'ooo@oo', 'N', 'ldf', 'N', '2024-03-29 00:00:00'),
(20, '9909', 'fdf', 'sfsdf', 'sfsdf@sfs', 'N', 'sdfsdf', 'S', '2024-03-29 00:00:00'),
(21, '030434', 'ffdsfs', 'sfdsfdf', 'ivan.rodrigo@westcon.com', 'N', 'WESTCON INTERNATIONAL LTD', 'N', '2024-03-19 00:00:00'),
(23, '0303030', 'a', 'a', 'a@a', 'N', 'a', 'S', '2024-03-08 00:00:00'),
(24, '3232', 'sdfds', 'zz', 'z@a', 'N', 'a', 'S', '2024-04-05 00:00:00'),
(25, '3', 'd', 'd', 'd@s', 'N', 'd', 'N', '2024-03-30 00:00:00'),
(26, '33', 'd', 'd', 'd@d', 'N', 'd', 'N', '2024-03-29 00:00:00'),
(28, '333333', 'd', 'dd', 'dd@d', 'N', 'ddd', 'N', '2024-04-06 00:00:00'),
(29, '1', 'a', 'a', 'a@a', 'N', 'a', 'N', '2024-03-27 00:00:00'),
(30, '222', 'dddd', 'ere', 'ff@ff.com', 'N', 'e', 'S', '2024-03-29 00:00:00'),
(31, '2212', 'sdfds', 'sffs', 'sfs@sdf', 'N', 'asdfs', 'N', '2024-03-01 00:00:00'),
(32, '32432', 'sfsafs dsd', 'sfdsf', 'dsffs@sdf', 'N', 'sfsffs', 'N', '2024-04-06 00:00:00'),
(33, '2342', 'sf', 'a', 'a@a', 'N', 'af', 'N', '2024-03-28 00:00:00'),
(34, '0032434', 'iva', 'sdfasd', 'ooo@ss', 'N', 'dfsafdsaf', 'N', '2024-03-31 00:00:00'),
(35, '777', 'pepe', 'pepe', 'pepe@pepe', 'N', 'pepe', 'N', '2024-03-26 16:23:00'),
(36, '04343', 'Pepito', 'Perez', 'pepito@perez', 'N', 'pepepipito', 'N', '2024-04-03 14:36:00'),
(37, 'l04343', 'Luis', 'Perez', 'luis@perez', 'N', 'luisito', 'S', '2024-03-26 18:45:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_emp`),
  ADD UNIQUE KEY `dni_emp` (`dni_emp`),
  ADD UNIQUE KEY `email_emp` (`email_emp`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `estados_visita`
--
ALTER TABLE `estados_visita`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `modulos_roles`
--
ALTER TABLE `modulos_roles`
  ADD PRIMARY KEY (`id_modulo`,`id_rol`);

--
-- Indices de la tabla `motivos_visita`
--
ALTER TABLE `motivos_visita`
  ADD PRIMARY KEY (`id_motivo`);

--
-- Indices de la tabla `navs`
--
ALTER TABLE `navs`
  ADD UNIQUE KEY `id_nav` (`id_nav`);

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
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id_visitante`),
  ADD UNIQUE KEY `dni_visitante` (`dni_visitante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados_visita`
--
ALTER TABLE `estados_visita`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `motivos_visita`
--
ALTER TABLE `motivos_visita`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `navs`
--
ALTER TABLE `navs`
  MODIFY `id_nav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id_visitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
