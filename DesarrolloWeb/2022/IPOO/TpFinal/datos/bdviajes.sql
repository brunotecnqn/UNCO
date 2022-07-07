-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2022 a las 20:21:09
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdviajes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` bigint(20) NOT NULL,
  `enombre` varchar(150) DEFAULT NULL,
  `edireccion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `enombre`, `edireccion`) VALUES
(1, 'Veloz', 'AV. Mendoza'),
(2, 'Andesmar', 'AV. Mendoza'),
(3, 'FlechaBus', 'AV. Mendoza'),
(4, 'Balut', 'AV. Salta'),
(5, 'Veloz del Norte', 'AV. Mendoza'),
(6, 'San Juan BUS', 'AV Salta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajero`
--

CREATE TABLE `pasajero` (
  `rdocumento` varchar(15) NOT NULL,
  `pnombre` varchar(150) DEFAULT NULL,
  `papellido` varchar(150) DEFAULT NULL,
  `ptelefono` int(11) DEFAULT NULL,
  `idviaje` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pasajero`
--

INSERT INTO `pasajero` (`rdocumento`, `pnombre`, `papellido`, `ptelefono`, `idviaje`) VALUES
('123131223', 'Juan', 'Cruz', 2437788, 1),
('222222', 'Pablo', 'Ponzio', 1213123, 2),
('342342333', 'Paula', 'Rojas', 2437851, 1),
('4444444', 'Eugenia', 'M', 123123, 1),
('6666666', 'Bruno', 'Terrazas', 2123123, 1),
('777777', 'br', 'a', 3423423, 1),
('8888888', 'Agustina', 'Rossi', 299342112, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

CREATE TABLE `responsable` (
  `rnumeroempleado` bigint(20) NOT NULL,
  `rnumerolicencia` bigint(20) DEFAULT NULL,
  `rnombre` varchar(150) DEFAULT NULL,
  `rapellido` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`rnumeroempleado`, `rnumerolicencia`, `rnombre`, `rapellido`) VALUES
(1, 342434323, 'Julian', 'Dias'),
(2, 123333233, 'Pablo', 'Sosa'),
(3, 442434323, 'Maria', 'Mendez'),
(4, 542434323, 'Saul', 'Petinatti'),
(5, 53588532, 'Maria', 'Lopez'),
(6, 23588532, 'Claudio', 'Lopez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `idviaje` bigint(20) NOT NULL,
  `vdestino` varchar(150) DEFAULT NULL,
  `vcantmaxpasajeros` int(11) DEFAULT NULL,
  `idempresa` bigint(20) DEFAULT NULL,
  `rnumeroempleado` bigint(20) DEFAULT NULL,
  `vimporte` float DEFAULT 0,
  `tipoAsiento` varchar(150) DEFAULT NULL,
  `idayvuelta` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`idviaje`, `vdestino`, `vcantmaxpasajeros`, `idempresa`, `rnumeroempleado`, `vimporte`, `tipoAsiento`, `idayvuelta`) VALUES
(1, 'Buenos Aires', 5, 1, 1, 30000, 'cama', 'si'),
(2, 'Bariloche', 80, 2, 2, 40000, 'cama', 'si'),
(3, 'Las Grutas', 80, 3, 1, 25000, 'cama', 'si'),
(4, 'Bahia Blanca', 80, 4, 1, 25000, 'cama', 'si'),
(5, 'Perito Moreno', 80, 1, 2, 25000, 'cama', 'si'),
(6, 'Las Grutas', 80, 6, 2, 25000, 'cama', 'si'),
(7, 'Puerto Madryn', 80, 3, 2, 25000, 'cama', 'si'),
(8, 'Ushuaia', 80, 2, 2, 25000, 'cama', 'si'),
(9, 'Chubut', 60, 3, 3, 47000, 'cama', 'no');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD PRIMARY KEY (`rdocumento`),
  ADD KEY `idviaje` (`idviaje`);

--
-- Indices de la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`rnumeroempleado`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`idviaje`),
  ADD KEY `idempresa` (`idempresa`),
  ADD KEY `rnumeroempleado` (`rnumeroempleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `rnumeroempleado` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `idviaje` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD CONSTRAINT `pasajero_ibfk_1` FOREIGN KEY (`idviaje`) REFERENCES `viaje` (`idviaje`);

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`),
  ADD CONSTRAINT `viaje_ibfk_2` FOREIGN KEY (`rnumeroempleado`) REFERENCES `responsable` (`rnumeroempleado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
