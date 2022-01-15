-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2021 a las 03:29:10
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica_veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `cliente_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_correo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_celular` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `cliente_nombre`, `cliente_direccion`, `cliente_correo`, `cliente_celular`, `cliente_telefono`) VALUES
(1, 'Fernanda Rodriguez', 'Cuajimalpa, Estado de Mexico', 'fer@correo.com', '+1234567890', '+9876543210'),
(2, 'Daniel Sanchez Perez', 'Calle #24, Delegacion Miguel Hidalgo, Ciudad de Mexico', 'danielSan@correo.com', '+1234567890', ''),
(3, 'Juan Benitez', 'Estado de Mexico', 'juan@correo.com', '123456789+', ''),
(4, 'Rodrigo Hernandez', 'Delegacion Miguel Hidalgo, Ciudad de Mexico, Mexico', 'rod_123@correo.com', '+0123456789', '+9876543210');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `mascota_id` int(10) UNSIGNED NOT NULL,
  `mascota_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `mascota_propietario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `mascota_raza` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `mascota_sexo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `mascota_nacimiento` date NOT NULL,
  `mascota_muerte` date NOT NULL,
  `mascota_vacuna` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`mascota_id`, `mascota_nombre`, `mascota_propietario`, `mascota_raza`, `mascota_sexo`, `mascota_nacimiento`, `mascota_muerte`, `mascota_vacuna`) VALUES
(1, 'firulais', 'Rodrigo Hernandez', 'chihuahua', 'Macho', '0000-00-00', '0000-00-00', 'Vacuna tipo A y D'),
(2, 'bodoque', 'Rodrigo Hernandez', 'chihuahua', 'Macho', '0000-00-00', '2021-11-30', 'Vacuna tipo A B y D'),
(3, 'Poopy', 'Fernanda Rodriguez', 'Pastor Aleman', 'Hembra', '2021-09-06', '0000-00-00', 'Sin vacunas'),
(4, 'Peludo', 'Daniel Sanchez Perez', 'Frech', 'Macho', '0000-00-00', '0000-00-00', 'Vacuna Tipo A'),
(6, 'chiquis', 'Fernanda Rodriguez', 'Cruza', 'Hembra', '0000-00-00', '0000-00-00', 'Sin vacunas'),
(7, 'pulga', 'Fernanda Rodriguez', 'chihuahua', 'Macho', '2021-11-08', '2021-12-01', 'Vacuna A y B12'),
(8, 'pulga', 'Daniel Sanchez Perez', 'Pastor Aleman', 'Macho', '2021-12-01', '0000-00-00', 'Vacuna C'),
(9, 'Rabbin', 'Juan Benitez', 'Doberman', 'Macho', '2020-03-18', '0000-00-00', 'Sin vacunas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`),
  ADD UNIQUE KEY `cliente_nombre` (`cliente_nombre`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`mascota_id`),
  ADD KEY `propietario_uniq` (`mascota_propietario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `mascota_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `propietario_uniq` FOREIGN KEY (`mascota_propietario`) REFERENCES `cliente` (`cliente_nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
