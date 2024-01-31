-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2023 a las 06:30:31
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cultech`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `id` int(10) NOT NULL,
  `id_cultivo` int(10) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acciones`
--

INSERT INTO `acciones` (`id`, `id_cultivo`, `descripcion`, `codigo`, `fecha`) VALUES
(1, 1, 'ESTA ACCIÓN ES DE PRUEBA', '001', '2023-09-24 22:21:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(10) NOT NULL,
  `id_cultivo` int(10) NOT NULL,
  `tem_max` decimal(10,2) NOT NULL,
  `tem_min` decimal(10,2) NOT NULL,
  `humedad_max` decimal(10,2) NOT NULL,
  `humedad_min` decimal(10,2) NOT NULL,
  `stem_max` decimal(10,2) NOT NULL,
  `stem_min` decimal(10,2) NOT NULL,
  `shumedad_max` decimal(10,2) NOT NULL,
  `shumedad_min` decimal(10,2) NOT NULL,
  `altura` decimal(10,2) NOT NULL,
  `dias` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `id_cultivo`, `tem_max`, `tem_min`, `humedad_max`, `humedad_min`, `stem_max`, `stem_min`, `shumedad_max`, `shumedad_min`, `altura`, `dias`, `foto`) VALUES
(1, 1, '25.00', '10.00', '90.00', '50.00', '30.00', '15.00', '100.00', '60.00', '20.00', 21, '1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cultivos`
--

CREATE TABLE `cultivos` (
  `id` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `id_placa` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `estado` int(1) NOT NULL DEFAULT 0,
  `alerta` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cultivos`
--

INSERT INTO `cultivos` (`id`, `id_usuario`, `id_placa`, `nombre`, `fecha`, `estado`, `alerta`) VALUES
(1, 1, 12345678, 'Chiles Verdes', '2023-09-24', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitoreo`
--

CREATE TABLE `monitoreo` (
  `id` int(10) NOT NULL,
  `id_cultivo` int(10) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `tem` decimal(10,2) NOT NULL,
  `humendad` decimal(10,2) NOT NULL,
  `stem` decimal(10,2) NOT NULL,
  `shumendad` decimal(10,2) NOT NULL,
  `altura` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `monitoreo`
--

INSERT INTO `monitoreo` (`id`, `id_cultivo`, `fecha`, `tem`, `humendad`, `stem`, `shumendad`, `altura`) VALUES
(1, 1, '2023-09-24 15:15:55', '20.00', '70.00', '22.00', '80.00', '1.00'),
(2, 1, '2023-09-24 16:16:55', '29.00', '70.00', '22.40', '80.00', '1.50'),
(3, 1, '2023-09-24 17:17:55', '25.00', '80.00', '28.80', '90.00', '2.00'),
(4, 1, '2023-09-24 22:18:55', '22.00', '90.00', '28.00', '80.00', '2.50'),
(5, 1, '2023-09-24 22:19:55', '23.00', '100.00', '20.00', '70.00', '2.80'),
(6, 1, '2023-09-24 22:20:55', '26.00', '90.00', '22.00', '80.00', '3.00'),
(7, 1, '2023-09-24 22:21:55', '27.00', '80.00', '23.00', '90.00', '3.20'),
(8, 1, '2023-09-24 22:22:55', '25.00', '60.00', '25.00', '80.00', '3.80'),
(9, 1, '2023-09-24 22:23:55', '25.00', '50.00', '29.00', '70.00', '4.20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `relevancia` int(2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `placas`
--

CREATE TABLE `placas` (
  `id` int(10) NOT NULL,
  `id_placa` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0,
  `uso` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `placas`
--

INSERT INTO `placas` (`id`, `id_placa`, `id_usuario`, `nombre`, `estado`, `uso`) VALUES
(1, 12345678, 1, 'Placa Azul', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantillas`
--

CREATE TABLE `plantillas` (
  `id` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tem_max` decimal(10,2) NOT NULL,
  `tem_min` decimal(10,2) NOT NULL,
  `humedad_max` decimal(10,2) NOT NULL,
  `humedad_min` decimal(10,2) NOT NULL,
  `stem_max` decimal(10,2) NOT NULL,
  `stem_min` decimal(10,2) NOT NULL,
  `shumedad_max` decimal(10,2) NOT NULL,
  `shumedad_min` decimal(10,2) NOT NULL,
  `altura` decimal(10,2) NOT NULL,
  `dias` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `plantillas`
--

INSERT INTO `plantillas` (`id`, `id_usuario`, `nombre`, `tem_max`, `tem_min`, `humedad_max`, `humedad_min`, `stem_max`, `stem_min`, `shumedad_max`, `shumedad_min`, `altura`, `dias`, `foto`, `estado`) VALUES
(1, 1, 'Chiles Verdes', '25.00', '10.00', '90.00', '50.00', '30.00', '15.00', '100.00', '60.00', '20.00', 21, '1.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `perfil` varchar(100) NOT NULL DEFAULT 'undraw_profile.svg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `clave`, `perfil`) VALUES
(1, 'Miguel Jordán', 'Rodríguez Reyes', 'mrodriguez74@ucol.mx', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'undraw_profile.svg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_placa` (`id_cultivo`),
  ADD KEY `id_cultivo` (`id_cultivo`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cultivo` (`id_cultivo`);

--
-- Indices de la tabla `cultivos`
--
ALTER TABLE `cultivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_placa` (`id_placa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `monitoreo`
--
ALTER TABLE `monitoreo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_placa` (`id_cultivo`),
  ADD KEY `id_cultivo` (`id_cultivo`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `placas`
--
ALTER TABLE `placas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_usuario_2` (`id_usuario`),
  ADD KEY `id_placa` (`id_placa`);

--
-- Indices de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cultivos`
--
ALTER TABLE `cultivos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `monitoreo`
--
ALTER TABLE `monitoreo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `placas`
--
ALTER TABLE `placas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD CONSTRAINT `acciones_ibfk_1` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `configuracion_ibfk_1` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cultivos`
--
ALTER TABLE `cultivos`
  ADD CONSTRAINT `cultivos_ibfk_1` FOREIGN KEY (`id_placa`) REFERENCES `placas` (`id_placa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cultivos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `monitoreo`
--
ALTER TABLE `monitoreo`
  ADD CONSTRAINT `monitoreo_ibfk_1` FOREIGN KEY (`id_cultivo`) REFERENCES `cultivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `placas`
--
ALTER TABLE `placas`
  ADD CONSTRAINT `placas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD CONSTRAINT `plantillas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
