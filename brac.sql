-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2019 a las 07:19:03
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

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
-- Estructura de tabla para la tabla `aerolinea`
--

CREATE TABLE `aerolinea` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `reputacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aerolinea`
--

INSERT INTO `aerolinea` (`id`, `nombre`, `reputacion_id`) VALUES
(1, 'KLM ', 0),
(2, 'Transavia Airlines ', 0),
(3, 'Denim Air ', 0),
(4, 'Qatar Airways', 0),
(5, 'Singapore Airlines', 0);

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
  `ciudad_id` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `gama` varchar(255) NOT NULL,
  `modelo_id` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `patente` varchar(255) NOT NULL,
  `autonomia` int(11) NOT NULL,
  `concesionaria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auto`
--

INSERT INTO `auto` (`id`, `ciudad_id`, `precio`, `gama`, `modelo_id`, `capacidad`, `patente`, `autonomia`, `concesionaria_id`) VALUES
(1, 1, 500, 'Media', 1, 4, 'BG8-S98', 15, 2),
(2, 84, 800, 'Media', 10, 4, 'BKE-98S', 12, 6),
(3, 82, 1500, 'Alta', 20, 4, 'PA1-RG9', 20, 5),
(4, 17, 1600, 'Alta', 3, 5, 'B9B-WA8', 20, 7),
(5, 2, 800, 'Media', 26, 5, 'LKJ-6D2', 16, 3),
(6, 5, 400, 'Baja', 13, 5, 'AG8-SS6', 10, 4),
(7, 5, 950, 'Media', 14, 5, 'POA-65A', 14, 4),
(8, 96, 4000, 'Alta', 19, 2, 'AXX-253', 100, 9),
(9, 82, 2100, 'Media', 7, 4, 'bfr-hah', 300, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auto_alquiler`
--

CREATE TABLE `auto_alquiler` (
  `id` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `id_auto` int(11) NOT NULL,
  `precio_alquiler` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `cancelado` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auto_alquiler`
--

INSERT INTO `auto_alquiler` (`id`, `desde`, `hasta`, `id_auto`, `precio_alquiler`, `compra_id`, `cancelado`) VALUES
(1, '2019-02-10', '2019-02-20', 1, 0, 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `pais_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `nombre`, `pais_id`) VALUES
(1, 'Buenos Aires', 2),
(2, 'Córdoba', 2),
(3, 'Mendoza', 2),
(4, 'Rio Negro', 2),
(5, 'Santa Fe', 2),
(7, 'La Paz', 3),
(8, 'Cochabamba', 3),
(11, 'Oruro', 3),
(12, 'Potosí', 3),
(17, 'Rio de Jainero', 4),
(18, 'Bahia', 4),
(19, 'São Paulo', 4),
(20, 'Goias', 4),
(21, 'Santiago', 5),
(22, 'Iquique', 5),
(23, 'Tacna', 5),
(24, 'Valparaiso', 5),
(25, 'Medellín', 6),
(26, 'Barranquilla', 6),
(27, 'Cartagena', 6),
(28, 'Bogota', 6),
(29, 'Quito', 7),
(30, 'Guayaquil', 7),
(31, 'Zamora', 7),
(32, 'Itapua', 8),
(33, 'Asunción', 8),
(34, 'Concepción', 8),
(35, 'San Pedro', 8),
(36, 'Lima', 9),
(37, 'Cuzco', 9),
(38, 'Piura', 9),
(39, 'Cajamarca', 9),
(40, 'Montevideo', 10),
(41, 'Paysandu', 10),
(42, 'Tacuarembó', 10),
(43, 'Colonia', 10),
(44, 'san José', 11),
(45, 'Cartago', 11),
(46, 'Guanascate', 11),
(47, 'Puntarenas', 11),
(48, 'Veraguas', 12),
(49, 'Los Santos', 12),
(50, 'Panamá Oeste', 12),
(51, 'Colón', 12),
(52, 'San Juan', 13),
(53, 'Ponce', 13),
(54, 'Cabo Rojo', 13),
(55, 'Mayagüez', 13),
(56, 'La Habana', 14),
(57, 'Varadero', 14),
(58, 'Santiago de Cuba', 14),
(59, 'Kingston', 15),
(60, 'Bahia Montego', 15),
(61, 'Portmore', 15),
(62, 'Hayes', 15),
(63, 'Sinaloa', 16),
(64, 'Jalisco', 16),
(65, 'Chiapas', 16),
(66, 'Chihuahua', 16),
(77, 'New York', 17),
(78, 'California', 17),
(79, 'Florida', 17),
(80, 'Colorado', 17),
(81, 'Mississippi', 17),
(82, 'Berlín', 18),
(83, 'Múnich', 18),
(84, 'Hamburgo', 18),
(85, 'Bruselas', 19),
(86, 'Gante', 19),
(87, 'Charleroi', 19),
(88, 'Zagreb', 20),
(89, 'Zadar', 20),
(90, 'Split', 20),
(91, 'Madrid', 21),
(92, 'Barcelona', 21),
(93, 'Valencia', 21),
(94, 'Sevilla', 21),
(95, 'Málaga', 21),
(96, 'París', 22),
(97, 'Mónaco', 22),
(98, 'Atenas', 23),
(99, 'Roma', 24),
(100, 'Milán', 24),
(101, 'Venecia', 24),
(102, 'Toscana', 24),
(103, 'Ámsterdam', 25),
(104, 'La Haya', 25),
(105, 'Lisboa', 26),
(106, 'Oporto', 26),
(107, 'Braga', 26),
(108, 'Moscú', 27),
(109, 'Tokio', 28),
(110, 'Yokohama', 28),
(111, 'Osaka', 28),
(112, 'Pekín', 29),
(113, 'Shanghaí', 29),
(114, 'Sydney', 30),
(115, 'Melbourne', 30),
(116, 'Londres', 31),
(117, 'Liverpool', 31),
(118, 'Manchester', 31);

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
(4, '2019-01-27 12:12:08', 29900, 13),
(5, '2019-01-25 18:35:05', 180, 13),
(6, '2019-01-28 02:13:48', 159500, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concesionaria`
--

CREATE TABLE `concesionaria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ciudad_id` int(11) NOT NULL,
  `reputacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concesionaria`
--

INSERT INTO `concesionaria` (`id`, `nombre`, `ciudad_id`, `reputacion`) VALUES
(1, 'Espasa   VOLKSWAGEN', 1, 0),
(2, ' Automotores Mataderos S.A.', 1, 0),
(3, 'CORDOBA - Auto Haus S.A', 2, 0),
(4, ' SANTA FE - Escobar Santa Fe S.A', 5, 0),
(5, 'PLM EXPORT GMBH', 82, 0),
(6, 'AUTOCENTER SCHMOLKE GMBH & CO. KG', 84, 0),
(7, ' Autostar', 17, 0),
(8, 'Audi Lounge', 17, 0),
(9, 'Paris Car', 96, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `gap_max` int(11) NOT NULL,
  `descuento_escala` int(11) NOT NULL,
  `precio_puntos` int(11) NOT NULL,
  `precio_peso` int(11) NOT NULL,
  `porcentaje_devolucion` int(11) NOT NULL,
  `intentos_sesion` int(11) NOT NULL,
  `precio_ejecutiva` int(11) NOT NULL,
  `precio_primera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `gap_max`, `descuento_escala`, `precio_puntos`, `precio_peso`, `porcentaje_devolucion`, `intentos_sesion`, `precio_ejecutiva`, `precio_primera`) VALUES
(1, 5, 20, 150, 200, 15, 6, 850, 1700);

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
(1, 5, 450, 10),
(2, 3, 600, 11),
(3, 3, 450, 10),
(4, 4, 1200, 7),
(5, 4, 1500, 3),
(6, 3, 1000, 9),
(7, 5, 1288, 5),
(8, 2, 2199, 4),
(9, 3, 1299, 4),
(10, 3, 1235, 4),
(11, 2, 2311, 7),
(12, 3, 1299, 7),
(13, 2, 1233, 7),
(14, 4, 1200, 7),
(15, 3, 1299, 7),
(16, 2, 12331, 4),
(17, 2, 1244, 8),
(18, 4, 1500, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion_alquiler`
--

CREATE TABLE `habitacion_alquiler` (
  `id` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `precio_alquiler` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `cancelado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `habitacion_alquiler`
--

INSERT INTO `habitacion_alquiler` (`id`, `desde`, `hasta`, `id_habitacion`, `precio_alquiler`, `compra_id`, `cancelado`) VALUES
(1, '2018-02-10', '2018-02-12', 2, 0, 4, '1'),
(2, '2019-01-17', '2019-01-20', 4, 0, 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ciudad_id` int(11) NOT NULL,
  `estrellas` int(11) NOT NULL,
  `reputacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hotel`
--

INSERT INTO `hotel` (`id`, `nombre`, `ciudad_id`, `estrellas`, `reputacion`) VALUES
(2, 'Hotel Madero', 1, 4, '1.25'),
(3, ' Hilton', 1, 5, '4.58'),
(4, ' Savoy Hotel', 1, 3, '5.00'),
(5, ' Sileo Hotel', 1, 4, '4.37'),
(6, 'Novotel Munich City', 83, 4, '2.75'),
(7, ' Radisson Blu Hotel, Berlin', 82, 2, '3.64'),
(8, ' Holiday Inn Munich - Westpark', 83, 5, '4.02'),
(9, 'Centro Hotel City Gate', 84, 2, '4.53'),
(10, 'iQ Hotel Roma', 99, 3, '4.66'),
(11, 'Hotel Paris', 96, 3, '3.22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `descripcion`) VALUES
(1, 'Volkswagen'),
(2, 'Peugeot'),
(3, 'Citroen'),
(4, 'Fiat'),
(5, 'Audi'),
(6, 'Chevrolet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `marca_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`id`, `descripcion`, `marca_id`) VALUES
(1, 'Fox', 1),
(2, 'Vento', 1),
(3, 'Scirocco', 1),
(4, 'Voyage', 1),
(5, 'Gol', 1),
(6, '208', 2),
(7, '308', 2),
(8, '508', 2),
(9, 'Partner', 2),
(10, 'C3', 3),
(11, 'C4', 3),
(12, 'Berlingo', 3),
(13, 'Duna', 4),
(14, 'Punto', 4),
(15, 'Argo', 4),
(16, 'Cronos', 4),
(17, 'A3', 5),
(18, 'A4', 5),
(19, 'A5', 5),
(20, 'TT', 5),
(26, 'Onix', 6),
(27, 'Prisma', 6),
(28, 'Corsa', 6),
(29, 'Aveo', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`) VALUES
(2, 'Argentina'),
(3, 'Bolivia'),
(4, 'Brasil'),
(5, 'Chile'),
(6, 'Colombia'),
(7, 'Ecuador'),
(8, 'Paraguay'),
(9, 'Peru'),
(10, 'Uruguay'),
(11, 'Costa Rica'),
(12, 'Panama'),
(13, 'Puerto Rico'),
(14, 'Cuba'),
(15, 'Jamaica'),
(16, 'México'),
(17, 'Estados Unidos'),
(18, 'Alemania'),
(19, 'Belgica'),
(20, 'Croacia'),
(21, 'España'),
(22, 'Francia'),
(23, 'Grecia'),
(24, 'Italia'),
(25, 'Paises Bajos'),
(26, 'Portugal'),
(27, 'Rusia'),
(28, 'Japon'),
(29, 'China'),
(30, 'Australia'),
(31, 'Inglaterra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `pregunta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_pregunta`, `pregunta`) VALUES
(1, 'Cuál es tu color favorito?'),
(2, 'Cuál es tu lugar favorito?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `descripcion_rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `descripcion_rol`) VALUES
(1, 'cliente'),
(2, 'administrador'),
(3, 'comerciante');

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
  `dni` varchar(8) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `nro_tarjeta` varchar(255) DEFAULT NULL,
  `pregunta` int(11) NOT NULL,
  `respuesta` varchar(255) NOT NULL,
  `cant_intentos` int(11) NOT NULL,
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `dni`, `email`, `rol_id`, `nro_tarjeta`, `pregunta`, `respuesta`, `cant_intentos`, `bloqueado`) VALUES
(0, 'administrador', 'negro', 'Lorenzo', 'Perez', '', 'juan.perez@gmail.com', 2, '5486-5595-4877-8966', 1, 'verde', 3, 0),
(1, 'comerciante', 'negro', 'Comerciante', 'cazzulos', '23812815', 'comerciante@comerciante.com', 3, NULL, 2, 'playa', 0, 0),
(4, 'juanperezzs', 'Clien852.', 'Lorenzo', 'Peraz', '89945213', 'juan.perez@gmail.com', 3, '5486-6233-4896-8966', 1, 'rojo', 0, 0),
(6, 'josesito', 'Clien852.', 'JosÃ©', 'Lopez', '28901092', 'jose.lopez@gmail.com', 1, '1536-6233-4877-1592', 2, 'campo', 0, 0),
(8, 'pedrito', 'Clien852.', 'Pedro ', 'Garcia', '28917299', 'pedro.garcia@gmail.com', 1, '1234-1234-1334-1343', 2, 'ciudad', 0, 0),
(13, 'alex', 'negro', 'Alex', 'Velasquez', NULL, 'alex@gmail.com', 1, '5486-6233-4877-8966', 2, 'mar', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo`
--

CREATE TABLE `vuelo` (
  `id` int(11) NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `fecha_llegada` datetime NOT NULL,
  `ciudad_origen` varchar(50) NOT NULL,
  `ciudad_destino` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL,
  `capacidad_economica` int(11) NOT NULL,
  `capacidad_ejecutiva` int(11) NOT NULL,
  `capacidad_primera` int(11) NOT NULL,
  `aerolinea_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vuelo`
--

INSERT INTO `vuelo` (`id`, `fecha_salida`, `fecha_llegada`, `ciudad_origen`, `ciudad_destino`, `precio`, `capacidad_economica`, `capacidad_ejecutiva`, `capacidad_primera`, `aerolinea_id`) VALUES
(5, '2018-01-10 08:10:00', '2018-01-10 15:15:00', 'buenos aires', 'lisboa', 28000, 178, 97, 29, 1),
(6, '2018-01-10 13:00:00', '2018-01-11 03:00:00', 'buenos aires', 'lisboa', 30000, 99, 17, 10, 1),
(7, '2018-01-10 13:00:00', '2018-01-10 15:00:00', 'buenos aires', 'montevideo', 2000, 39, 5, 0, 3),
(8, '2018-01-10 13:00:00', '2018-01-10 15:00:00', 'montevideo', 'lisboa', 22000, 80, 5, 10, 3),
(10, '2018-01-10 19:00:00', '2018-01-11 07:00:00', 'montevideo', 'lisboa', 2800, 90, 10, 10, 5),
(11, '2018-01-11 04:00:00', '2018-01-11 07:00:00', 'lisboa', 'madrid', 5800, 50, 10, 20, 1),
(12, '2018-01-11 08:00:00', '2018-01-11 11:00:00', 'lisboa', 'madrid', 6500, 50, 10, 20, 3),
(13, '2018-01-10 09:00:00', '2018-01-10 16:00:00', 'buenos aires', 'madrid', 25000, -3, -8, 0, 1),
(14, '2018-01-10 17:00:00', '2018-01-10 20:00:00', 'madrid', 'lisboa', 1900, 11, 12, 22, 1),
(15, '2018-04-15 12:00:00', '2018-04-16 06:00:00', 'buenos aires', 'madrid', 22000, 15, 18, 13, 1),
(16, '2018-01-10 17:45:00', '2018-01-10 20:00:00', 'buenos aires', 'Roma', 19890, 287, 97, 80, 4),
(17, '2018-01-10 21:00:00', '2018-01-11 04:15:00', 'Roma', 'lisboa', 3567, 1231, 108, 23, 4),
(18, '2018-02-10 22:10:00', '2018-02-11 03:40:00', 'Melbourne', 'Madrid', 18000, 120, 60, 10, 5),
(19, '2018-02-10 07:15:00', '2018-02-10 09:25:00', 'Melbourne', 'Lisboa', 10000, 20, 10, 5, 2),
(20, '2018-02-10 10:20:00', '2018-02-10 11:40:00', 'Lisboa', 'Madrid', 7500, 80, 40, 20, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo_compra`
--

CREATE TABLE `vuelo_compra` (
  `id` int(11) NOT NULL,
  `vuelo` varchar(64) NOT NULL,
  `pasajeros` int(11) NOT NULL,
  `clase_vuelo` varchar(64) NOT NULL,
  `precio_vuelo` varchar(255) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `cancelado` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vuelo_compra`
--

INSERT INTO `vuelo_compra` (`id`, `vuelo`, `pasajeros`, `clase_vuelo`, `precio_vuelo`, `compra_id`, `cancelado`) VALUES
(1, '6', 1, 'economica', '30000', 4, NULL),
(2, '13v14', 4, 'economica', '26900', 6, '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aerolinea`
--
ALTER TABLE `aerolinea`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `ciudad_id` (`ciudad_id`),
  ADD KEY `modelo_id` (`modelo_id`);

--
-- Indices de la tabla `auto_alquiler`
--
ALTER TABLE `auto_alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auto` (`id_auto`),
  ADD KEY `compra` (`compra_id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pais_id` (`pais_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `ciudad_id` (`ciudad_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `ciudad_id` (`ciudad_id`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`) USING BTREE;

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregunta`);

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
  ADD KEY `compra` (`compra_id`),
  ADD KEY `vuelo` (`vuelo`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aerolinea`
--
ALTER TABLE `aerolinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `aeropuerto`
--
ALTER TABLE `aeropuerto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `auto`
--
ALTER TABLE `auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `auto_alquiler`
--
ALTER TABLE `auto_alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `concesionaria`
--
ALTER TABLE `concesionaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `habitacion_alquiler`
--
ALTER TABLE `habitacion_alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `vuelo`
--
ALTER TABLE `vuelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `vuelo_compra`
--
ALTER TABLE `vuelo_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auto`
--
ALTER TABLE `auto`
  ADD CONSTRAINT `auto_ibfk_1` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auto_ibfk_2` FOREIGN KEY (`modelo_id`) REFERENCES `modelo` (`id`);

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `concesionaria`
--
ALTER TABLE `concesionaria`
  ADD CONSTRAINT `concesionaria_ibfk_1` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `hotel_ibfk_1` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
