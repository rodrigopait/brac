-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2018 a las 15:43:06
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `brac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aerolinia`
--

CREATE TABLE `aerolinia` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `reputacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aeropuerto`
--

CREATE TABLE `aeropuerto` (
  `id` int(11) NOT NULL,
  `Nombre` int(11) NOT NULL,
  `Ciudad` int(11) NOT NULL,
  `Pais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auto`
--

CREATE TABLE `auto` (
  `id` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `concesionaria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auto`
--

INSERT INTO `auto` (`id`, `precio`, `modelo`, `capacidad`, `concesionaria_id`) VALUES
(1, 50000, 'Volkswagen Vento', 5, 0),
(2, 1234, 'Peugeot', 4, 0),
(3, 5555, 'Mini', 4, 0),
(4, 9999, 'Cobra', 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auto_alquiler`
--

CREATE TABLE `auto_alquiler` (
  `id` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `id_auto` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auto_alquiler`
--

INSERT INTO `auto_alquiler` (`id`, `desde`, `hasta`, `id_auto`, `compra_id`) VALUES
(6, '2017-12-30', '2017-12-31', 4, 35),
(7, '2017-12-30', '2017-12-31', 3, 36),
(8, '2017-12-08', '2017-12-09', 4, 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `fecha`, `total`, `usuario_id`) VALUES
(35, '2017-12-10 01:23:42', 11499, 1),
(36, '2017-12-10 01:35:50', 7055, 1),
(37, '2017-12-10 01:54:31', 1000, 1),
(38, '2017-12-10 01:55:46', 500, 1),
(39, '2017-12-10 01:56:15', 9999, 1),
(40, '2017-12-10 03:01:34', 1000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concesionaria`
--

CREATE TABLE `concesionaria` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Ciudad` varchar(255) NOT NULL,
  `Pais` varchar(255) NOT NULL,
  `reputacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id`, `capacidad`, `precio`, `hotel_id`) VALUES
(1, 10, 500, 4),
(2, 4, 500, 4),
(3, 5, 777, 5),
(4, 4, 1234, 5),
(5, 40, 4444, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion_alquiler`
--

CREATE TABLE `habitacion_alquiler` (
  `id` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `habitacion_alquiler`
--

INSERT INTO `habitacion_alquiler` (`id`, `desde`, `hasta`, `id_habitacion`, `compra_id`) VALUES
(8, '2017-12-16', '2017-12-17', 2, 35),
(9, '2017-12-30', '2017-12-31', 2, 36),
(10, '2017-12-13', '2017-12-14', 2, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Ciudad` varchar(255) NOT NULL,
  `Pais` varchar(255) NOT NULL,
  `reputacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `descripcion`) VALUES
(1, 'admin'),
(2, 'comerciante'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `nro_tarjeta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `email`, `rol_id`, `nro_tarjeta`) VALUES
(0, 'admin', 'negro', 'Administrador', '', 'admin@admin.com', 1, ''),
(1, 'comerciante', 'negro', 'Comerciante', '', 'comerciante@comerciante.com', 2, ''),
(2, 'alex', 'putito', 'Alex', 'El Leon', 'alex@elleon.com', 3, '5547-5236-5894-7895');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo`
--

CREATE TABLE `vuelo` (
  `id` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_llegada` date NOT NULL,
  `capacidad` int(11) NOT NULL,
  `ciudad_origen` varchar(50) NOT NULL,
  `ciudad_destino` varchar(50) NOT NULL,
  `pais_origen` varchar(50) NOT NULL,
  `pais_destino` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL,
  `aerolinea_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vuelo`
--

INSERT INTO `vuelo` (`id`, `fecha_salida`, `fecha_llegada`, `capacidad`, `ciudad_origen`, `ciudad_destino`, `pais_origen`, `pais_destino`, `precio`, `aerolinea_id`) VALUES
(1, '2019-01-02', '2019-01-03', 49, 'La Plata', 'Mar del Plata', 'Argentina', 'Argentina', 1000, 0),
(2, '2017-12-03', '2017-12-05', 350, 'Lanus', 'La Plata', 'Argentina', 'Argentina', 990, 0),
(3, '2017-12-02', '2017-12-11', 300, 'La Plata', 'Mar del Plata', 'Argentina', 'Argentina', 770, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo_compra`
--

CREATE TABLE `vuelo_compra` (
  `id` int(11) NOT NULL,
  `vuelo_id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vuelo_compra`
--

INSERT INTO `vuelo_compra` (`id`, `vuelo_id`, `compra_id`) VALUES
(8, 1, 35),
(9, 1, 36),
(10, 1, 37),
(11, 1, 40);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aerolinia`
--
ALTER TABLE `aerolinia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `auto_alquiler`
--
ALTER TABLE `auto_alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auto` (`id_auto`),
  ADD KEY `compra` (`compra_id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario_id`);

--
-- Indices de la tabla `concesionaria`
--
ALTER TABLE `concesionaria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitacion_alquiler`
--
ALTER TABLE `habitacion_alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel` (`id_habitacion`),
  ADD KEY `compra` (`compra_id`);

--
-- Indices de la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vuelo`
--
ALTER TABLE `vuelo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vuelo_compra`
--
ALTER TABLE `vuelo_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vuelo` (`vuelo_id`),
  ADD KEY `compra` (`compra_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aerolinia`
--
ALTER TABLE `aerolinia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `auto`
--
ALTER TABLE `auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `auto_alquiler`
--
ALTER TABLE `auto_alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `concesionaria`
--
ALTER TABLE `concesionaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `habitacion_alquiler`
--
ALTER TABLE `habitacion_alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vuelo`
--
ALTER TABLE `vuelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vuelo_compra`
--
ALTER TABLE `vuelo_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
