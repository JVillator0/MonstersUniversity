-- para crear el usario de bases de datos de un solo
GRANT USAGE ON *.* TO 'monsters_dba'@'localhost' IDENTIFIED BY PASSWORD '*3D3F2942EBEDD56DF252F3AF286FD7D8811BA82F';

GRANT ALL PRIVILEGES ON `monsters\_university\_db`.* TO 'monsters_dba'@'localhost' WITH GRANT OPTION;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2018 a las 18:29:34
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `monsters_university_db`
--
CREATE DATABASE IF NOT EXISTS `monsters_university_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `monsters_university_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `Id_Carrera` int(11) NOT NULL,
  `Carrera` varchar(200) NOT NULL,
  `Descripcion` varchar(500) NOT NULL,
  `Estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_postulante`
--

CREATE TABLE `detalle_postulante` (
  `Id_Detalle_Postulante` int(11) NOT NULL,
  `Id_Postulante` int(11) NOT NULL,
  `Id_Institucion_Procedencia` int(11) NOT NULL,
  `Id_Especialidad` int(11) NOT NULL,
  `Anio_Inicio_B` int(11) NOT NULL,
  `Anio_Fin_B` int(11) NOT NULL,
  `Id_Carrera` int(11) NOT NULL,
  `Tel_Fijo` varchar(50) DEFAULT NULL,
  `Tel_Movil` varchar(50) DEFAULT NULL,
  `Fecha_Nacimiento` date NOT NULL,
  `DUI` varchar(20) NOT NULL,
  `NIT` varchar(20) NOT NULL,
  `Imagen` varchar(500) NOT NULL,
  `Estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `Id_Especialidad` int(11) NOT NULL,
  `Especialidad` varchar(200) NOT NULL,
  `Estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion_procedencia`
--

CREATE TABLE `institucion_procedencia` (
  `Id_Institucion_Procedencia` int(11) NOT NULL,
  `Institucion_Procedencia` varchar(200) NOT NULL,
  `Estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulante`
--

CREATE TABLE `postulante` (
  `Id_Postulante` int(11) NOT NULL,
  `Nombres` varchar(200) NOT NULL,
  `Apellidos` varchar(200) NOT NULL,
  `Correo` varchar(200) NOT NULL,
  `Clave` varchar(200) NOT NULL,
  `Estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_Usuario` int(11) NOT NULL,
  `Nombres` varchar(200) NOT NULL,
  `Apellidos` varchar(200) NOT NULL,
  `Correo` varchar(200) NOT NULL,
  `Alias` varchar(200) NOT NULL,
  `Clave` varchar(200) NOT NULL,
  `Estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`Id_Carrera`);

--
-- Indices de la tabla `detalle_postulante`
--
ALTER TABLE `detalle_postulante`
  ADD PRIMARY KEY (`Id_Detalle_Postulante`),
  ADD KEY `Id_Carrera` (`Id_Carrera`),
  ADD KEY `Id_Postulante` (`Id_Postulante`),
  ADD KEY `Id_Institucion_Procedencia` (`Id_Institucion_Procedencia`),
  ADD KEY `Id_Especialidad` (`Id_Especialidad`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`Id_Especialidad`);

--
-- Indices de la tabla `institucion_procedencia`
--
ALTER TABLE `institucion_procedencia`
  ADD PRIMARY KEY (`Id_Institucion_Procedencia`);

--
-- Indices de la tabla `postulante`
--
ALTER TABLE `postulante`
  ADD PRIMARY KEY (`Id_Postulante`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `Id_Carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_postulante`
--
ALTER TABLE `detalle_postulante`
  MODIFY `Id_Detalle_Postulante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `Id_Especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `institucion_procedencia`
--
ALTER TABLE `institucion_procedencia`
  MODIFY `Id_Institucion_Procedencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `postulante`
--
ALTER TABLE `postulante`
  MODIFY `Id_Postulante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_postulante`
--
ALTER TABLE `detalle_postulante`
  ADD CONSTRAINT `detalle_postulante_ibfk_1` FOREIGN KEY (`Id_Carrera`) REFERENCES `carrera` (`Id_Carrera`),
  ADD CONSTRAINT `detalle_postulante_ibfk_2` FOREIGN KEY (`Id_Postulante`) REFERENCES `postulante` (`Id_Postulante`),
  ADD CONSTRAINT `detalle_postulante_ibfk_3` FOREIGN KEY (`Id_Institucion_Procedencia`) REFERENCES `institucion_procedencia` (`Id_Institucion_Procedencia`),
  ADD CONSTRAINT `detalle_postulante_ibfk_4` FOREIGN KEY (`Id_Especialidad`) REFERENCES `especialidad` (`Id_Especialidad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
