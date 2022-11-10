-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2022 a las 22:06:50
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seguros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `ip` varchar(100) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id`, `id_usuario`, `ip`, `fecha_hora`, `descripcion`) VALUES
(1, 1234567890, '::1', '2022-11-10 20:51:04', 'admin@gmail.com se registro en el sistema'),
(2, 1234567811, '::1', '2022-11-10 20:51:45', 'usuario@gmail.com se registro en el sistema'),
(3, 1234567811, '::1', '2022-11-10 20:53:37', 'usuario@gmail.com se logueo en el sistema'),
(4, 1234567811, '::1', '2022-11-10 20:54:59', 'Se registro un nuevo cliente'),
(5, 1234567811, '::1', '2022-11-10 20:54:59', 'Lleno formulario de vida con ref N°1865867427'),
(6, 1234567811, '::1', '2022-11-10 20:56:12', 'Realizo el pago del seguro con ref N°1865867427'),
(7, 1234567811, '::1', '2022-11-10 20:56:14', 'Solicito su registro de seguros'),
(8, 1234567811, '::1', '2022-11-10 20:56:34', 'Ha solicitado reclamar su seguro con ref N°1865867427'),
(9, 1234567811, '::1', '2022-11-10 20:56:36', 'Solicito su registro de seguros'),
(10, 1234567811, '::1', '2022-11-10 20:58:20', 'Lleno formulario de vida con ref N°320172887'),
(11, 1234567811, '::1', '2022-11-10 20:58:24', 'Solicito su registro de seguros'),
(12, 1234567811, '::1', '2022-11-10 20:59:36', 'Lleno formulario de vida con ref N°1308699153'),
(13, 1234567811, '::1', '2022-11-10 21:00:15', 'Realizo el pago del seguro con ref N°1308699153'),
(14, 1234567811, '::1', '2022-11-10 21:00:17', 'Solicito su registro de seguros'),
(15, 1234567811, '::1', '2022-11-10 21:00:26', 'Solicito su registro de seguros'),
(16, 1234567811, '::1', '2022-11-10 21:00:28', 'Solicito detalles de su seguro con ref N°1865867427'),
(17, 1234567811, '::1', '2022-11-10 21:00:34', 'Solicito su registro de seguros'),
(18, 1234567811, '::1', '2022-11-10 21:00:48', 'Salio del sistema'),
(19, 1234567890, '::1', '2022-11-10 21:00:58', 'admin@gmail.com se logueo en el sistema'),
(20, 1234567890, '::1', '2022-11-10 21:01:07', 'Solicito usuarios del sistema'),
(21, 1234567890, '::1', '2022-11-10 21:01:12', 'Solicito las solicitudes de los usuarios'),
(22, 1234567890, '::1', '2022-11-10 21:01:23', 'Aprovo el seguro con ref N°: 1865867427'),
(23, 1234567890, '::1', '2022-11-10 21:01:25', 'Solicito las solicitudes de los usuarios'),
(24, 1234567890, '::1', '2022-11-10 21:01:28', 'Solicito usuarios del sistema'),
(25, 1234567890, '::1', '2022-11-10 21:01:36', 'Solicito las solicitudes de los usuarios'),
(26, 1234567890, '::1', '2022-11-10 21:01:38', 'Solicito usuarios del sistema'),
(27, 1234567890, '::1', '2022-11-10 21:02:16', 'Modifico los precios del plan con id: 1'),
(28, 1234567890, '::1', '2022-11-10 21:02:25', 'Solicito usuarios del sistema'),
(29, 1234567890, '::1', '2022-11-10 21:02:25', 'Solicito las solicitudes de los usuarios'),
(30, 1234567890, '::1', '2022-11-10 21:02:26', 'Solicito usuarios del sistema'),
(31, 1234567890, '::1', '2022-11-10 21:02:28', 'Salio del sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `tipo_documento` varchar(50) NOT NULL,
  `names` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_documento`, `names`, `email`, `created_at`, `update_at`) VALUES
(1234567811, 'Cedula de ciudadania', 'usuario', 'usuario@gmail.com', '2022-11-10 20:54:59', '2022-11-10 20:54:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizar`
--

CREATE TABLE `cotizar` (
  `id` int NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `basico` int NOT NULL,
  `estandar` int NOT NULL,
  `premiun` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cotizar`
--

INSERT INTO `cotizar` (`id`, `tipo`, `basico`, `estandar`, `premiun`) VALUES
(1, 'vida', 900, 1200, 1800),
(2, 'vivienda', 1800, 2300, 3000),
(3, 'vehiculo', 1700, 2200, 2800);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int NOT NULL,
  `ref_pago` int NOT NULL,
  `valor` int NOT NULL,
  `pago` tinyint(1) NOT NULL DEFAULT '0',
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `cancelado` tinyint(1) NOT NULL DEFAULT '0',
  `reclamado` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `ref_pago`, `valor`, `pago`, `activo`, `cancelado`, `reclamado`, `created_at`, `update_at`) VALUES
(1, 1865867427, 30000, 1, 1, 0, 2, '2022-11-10 20:54:59', '2022-11-10 21:01:23'),
(2, 320172887, 42000, 0, 0, 0, 0, '2022-11-10 20:58:20', '2022-11-10 20:58:20'),
(3, 1308699153, 91500, 1, 1, 0, 0, '2022-11-10 20:59:36', '2022-11-10 21:00:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int NOT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `ref_pago` int NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `fecha_solicitud`, `estado`, `ref_pago`, `update_at`) VALUES
(1, '2022-11-10 20:56:34', 1, 1865867427, '2022-11-10 21:01:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `tipo_documento` varchar(50) NOT NULL,
  `names` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo_documento`, `names`, `email`, `password`, `rol`, `active`, `created_at`, `update_at`) VALUES
(1234567811, 'Cedula de ciudadania', 'usuario', 'usuario@gmail.com', '$2y$15$Kel0S7ejSCWWitgxFDG4I.LkVfo0TFQdXyn1buGOM50v4jbSk7INS', 0, 1, '2022-11-10 20:51:45', '2022-11-10 20:51:45'),
(1234567890, 'Cedula de ciudadania', 'admin', 'admin@gmail.com', '$2y$15$NPlFMvOxDADhw/AQjXeniOgOWuA0QREvzoVlQugJTeIBavYSMqzc2', 1, 1, '2022-11-10 20:51:04', '2022-11-10 20:52:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vida`
--

CREATE TABLE `vida` (
  `ref_pago` int NOT NULL,
  `id_user` int NOT NULL,
  `id_beneficiario` int NOT NULL,
  `fecha_nacimineto` date NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `ingresos` int NOT NULL,
  `profesion` varchar(100) NOT NULL,
  `medicamento` varchar(20) NOT NULL,
  `cual` varchar(100) NOT NULL,
  `eps_ips` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `plan` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vida`
--

INSERT INTO `vida` (`ref_pago`, `id_user`, `id_beneficiario`, `fecha_nacimineto`, `sexo`, `estado_civil`, `celular`, `direccion`, `ciudad`, `ingresos`, `profesion`, `medicamento`, `cual`, `eps_ips`, `fecha_inicio`, `fecha_fin`, `tipo`, `plan`, `created_at`, `update_at`) VALUES
(320172887, 1234567811, 1234567811, '2001-12-12', 'Femenino', 'Soltero', '3001234567', 'Centro', 'lorica', 500000, 'ingeniera de sistemas', 'Si', 'Ramipril', 'nueva eps', '2022-11-10', '2022-12-01', 'Seguro de vida', 'premiun', '2022-11-10 20:58:20', '2022-11-10 20:58:20'),
(1308699153, 1234567811, 1234567811, '2001-12-12', 'Femenino', 'Soltero', '3001234567', 'Centro', 'lorica', 500000, 'ingeniera de sistemas', 'No', 'No aplica', 'nueva eps', '2022-11-10', '2023-01-10', 'Seguro de vida', 'estandar', '2022-11-10 20:59:36', '2022-11-10 20:59:36'),
(1865867427, 1234567811, 1234567811, '2001-08-12', 'Femenino', 'Soltero', '3001234567', 'Centro', 'lorica', 400000, 'ingeniera de sistemas', 'No', 'No aplica', 'nueva eps', '2022-11-10', '2022-12-10', 'Seguro de vida', 'basico', '2022-11-10 20:54:59', '2022-11-10 20:54:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cotizar`
--
ALTER TABLE `cotizar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_pago` (`ref_pago`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `ref_pago` (`ref_pago`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vida`
--
ALTER TABLE `vida`
  ADD PRIMARY KEY (`ref_pago`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_beneficiario` (`id_beneficiario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `cotizar`
--
ALTER TABLE `cotizar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `auditoria_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`ref_pago`) REFERENCES `vida` (`ref_pago`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`ref_pago`) REFERENCES `vida` (`ref_pago`);

--
-- Filtros para la tabla `vida`
--
ALTER TABLE `vida`
  ADD CONSTRAINT `vida_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `vida_ibfk_2` FOREIGN KEY (`id_beneficiario`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
