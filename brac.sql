-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2018 at 02:20 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brac`
--

-- --------------------------------------------------------

--
-- Table structure for table `auto`
--

CREATE TABLE `auto` (
  `id` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto`
--

INSERT INTO `auto` (`id`, `precio`, `modelo`, `capacidad`, `ciudad`, `pais`) VALUES
(1, 50000, 'Volkswagen Vento', 5, 'La Plata', 'Argentina'),
(2, 1234, 'Peugeot', 4, 'La Plata', 'Argentina'),
(3, 5555, 'Mini', 4, 'La Plata', 'Argentina'),
(4, 9999, 'Cobra', 4, 'La Plata', 'Argentina');

-- --------------------------------------------------------

--
-- Table structure for table `auto_alquiler`
--

CREATE TABLE `auto_alquiler` (
  `id` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `id_auto` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto_alquiler`
--

INSERT INTO `auto_alquiler` (`id`, `desde`, `hasta`, `id_auto`, `compra_id`) VALUES
(6, '2017-12-30', '2017-12-31', 4, 35),
(7, '2017-12-30', '2017-12-31', 3, 36),
(8, '2017-12-08', '2017-12-09', 4, 39);

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `compra`
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
-- Table structure for table `habitacion`
--

CREATE TABLE `habitacion` (
  `id` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `estrellas` int(11) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `habitacion`
--

INSERT INTO `habitacion` (`id`, `capacidad`, `precio`, `estrellas`, `ciudad`, `pais`) VALUES
(1, 10, 500, 4, 'La Plata', 'Argentina'),
(2, 4, 500, 4, 'La Plata', 'Argentina'),
(3, 5, 777, 5, 'Mar del Plata', 'Argentina'),
(4, 4, 1234, 5, 'La Plata', 'Argentina'),
(5, 40, 4444, 3, 'La Plata', 'Argentina');

-- --------------------------------------------------------

--
-- Table structure for table `habitacion_alquiler`
--

CREATE TABLE `habitacion_alquiler` (
  `id` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `habitacion_alquiler`
--

INSERT INTO `habitacion_alquiler` (`id`, `desde`, `hasta`, `id_habitacion`, `compra_id`) VALUES
(8, '2017-12-16', '2017-12-17', 2, 35),
(9, '2017-12-30', '2017-12-31', 2, 36),
(10, '2017-12-13', '2017-12-14', 2, 38);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `nombre`, `apellido`, `email`) VALUES
(0, 'admin', 'admin', 'Administrador', '', ''),
(1, 'agus', 'agus', 'Agustin', 'Jobs', 'agus@jobs.com'),
(2, 'rami', 'rami', 'Ramiro', 'Chilenux', 'rami@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `vuelo`
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
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vuelo`
--

INSERT INTO `vuelo` (`id`, `fecha_salida`, `fecha_llegada`, `capacidad`, `ciudad_origen`, `ciudad_destino`, `pais_origen`, `pais_destino`, `precio`) VALUES
(1, '2017-12-02', '2017-12-09', 49, 'La Plata', 'Mar del Plata', 'Argentina', 'Argentina', 1000),
(2, '2017-12-03', '2017-12-05', 350, 'Lanus', 'La Plata', 'Argentina', 'Argentina', 990),
(3, '2017-12-02', '2017-12-11', 300, 'La Plata', 'Mar del Plata', 'Argentina', 'Argentina', 770);

-- --------------------------------------------------------

--
-- Table structure for table `vuelo_compra`
--

CREATE TABLE `vuelo_compra` (
  `id` int(11) NOT NULL,
  `vuelo_id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vuelo_compra`
--

INSERT INTO `vuelo_compra` (`id`, `vuelo_id`, `compra_id`) VALUES
(8, 1, 35),
(9, 1, 36),
(10, 1, 37),
(11, 1, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auto_alquiler`
--
ALTER TABLE `auto_alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auto` (`id_auto`),
  ADD KEY `compra` (`compra_id`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario_id`);

--
-- Indexes for table `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habitacion_alquiler`
--
ALTER TABLE `habitacion_alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel` (`id_habitacion`),
  ADD KEY `compra` (`compra_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vuelo`
--
ALTER TABLE `vuelo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vuelo_compra`
--
ALTER TABLE `vuelo_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vuelo` (`vuelo_id`),
  ADD KEY `compra` (`compra_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auto`
--
ALTER TABLE `auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `auto_alquiler`
--
ALTER TABLE `auto_alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `habitacion_alquiler`
--
ALTER TABLE `habitacion_alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vuelo`
--
ALTER TABLE `vuelo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `vuelo_compra`
--
ALTER TABLE `vuelo_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
