-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2018 a las 17:55:49
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

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`Id_Carrera`, `Carrera`, `Descripcion`, `Estado`) VALUES
(1, 'Carrera 1', 'descripcion 1', 1),
(2, 'Carrera 2', 'descripcion 2', 1),
(3, 'Carrera 3', 'descripcion 3', 1);

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

--
-- Volcado de datos para la tabla `detalle_postulante`
--

INSERT INTO `detalle_postulante` (`Id_Detalle_Postulante`, `Id_Postulante`, `Id_Institucion_Procedencia`, `Id_Especialidad`, `Anio_Inicio_B`, `Anio_Fin_B`, `Id_Carrera`, `Tel_Fijo`, `Tel_Movil`, `Fecha_Nacimiento`, `DUI`, `NIT`, `Imagen`, `Estado`) VALUES
(1, 1, 1, 1, 2000, 2003, 1, '2321-5242', '7000-0007', '1999-11-15', '12345678-9', '1234-123123-123-1', '1.jpg', 1),
(2, 2, 2, 3, 2010, 2017, 1, '5634-4853', '7384-0012', '1993-08-03', '23790019-2', '3948-687374-641-6', '2.jpg', 1),
(3, 3, 1, 3, 2010, 2014, 1, '6131-2253', '2819-6873', '1991-07-01', '71775842-4', '8373-317081-933-1', '3.jpg', 1),
(4, 4, 1, 3, 2013, 2015, 2, '9196-5347', '3146-0814', '1997-11-22', '48702028-9', '1359-447417-994-5', '4.jpg', 1),
(5, 5, 1, 5, 2013, 2017, 2, '4607-9992', '1035-1225', '2000-07-02', '61966439-5', '3924-607607-439-1', '5.jpg', 1),
(6, 6, 3, 5, 2012, 2017, 3, '4304-5488', '5831-2664', '1998-01-13', '88443476-2', '7128-380429-290-6', '6.jpg', 1),
(7, 7, 1, 3, 2011, 2017, 1, '1061-4787', '8579-4571', '2000-10-01', '98721848-6', '1946-912824-900-8', '7.jpg', 1),
(8, 8, 3, 1, 2010, 2015, 2, '6234-6611', '5142-4670', '1997-10-21', '45313640-9', '9121-688547-240-5', '8.jpg', 1),
(9, 9, 4, 4, 2012, 2014, 2, '6148-2479', '9214-9099', '1999-03-22', '29315362-5', '6103-205198-783-1', '9.jpg', 1),
(10, 10, 4, 3, 2012, 2014, 2, '2644-4914', '2456-6475', '1998-08-22', '70934608-1', '6361-153751-114-4', '10.jpg', 1),
(11, 11, 3, 4, 2013, 2017, 2, '2186-2034', '1117-7890', '1997-06-30', '69532965-8', '2776-758010-984-6', '11.jpg', 1),
(12, 12, 1, 3, 2010, 2017, 1, '6611-5117', '2616-5336', '1993-12-03', '72257599-1', '2494-201231-940-6', '12.jpg', 1),
(13, 13, 1, 1, 2011, 2016, 1, '6918-0360', '3142-1922', '2000-04-24', '25620140-2', '2040-928342-682-2', '13.jpg', 1),
(14, 14, 4, 4, 2012, 2014, 1, '6385-6201', '3898-7185', '1990-01-15', '84134676-3', '2747-443481-314-6', '14.jpg', 1),
(15, 15, 4, 5, 2013, 2017, 2, '8096-7871', '3528-1986', '2000-06-25', '20719492-0', '4124-622957-707-3', '15.jpg', 1),
(16, 16, 3, 4, 2012, 2016, 2, '6646-9989', '1068-3517', '1995-12-14', '98897743-5', '8071-601649-749-7', '16.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `Id_Especialidad` int(11) NOT NULL,
  `Especialidad` varchar(200) NOT NULL,
  `Estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`Id_Especialidad`, `Especialidad`, `Estado`) VALUES
(1, 'Arquitectura', 1),
(2, 'Software', 1),
(3, 'General', 1),
(4, 'Contaduria', 1),
(5, 'Diseño gráfico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion_procedencia`
--

CREATE TABLE `institucion_procedencia` (
  `Id_Institucion_Procedencia` int(11) NOT NULL,
  `Institucion_Procedencia` varchar(200) NOT NULL,
  `Estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `institucion_procedencia`
--

INSERT INTO `institucion_procedencia` (`Id_Institucion_Procedencia`, `Institucion_Procedencia`, `Estado`) VALUES
(1, 'Institución 1', 1),
(2, 'Institución 2', 1),
(3, 'Institución 3', 1),
(4, 'Institución 4', 1);

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

--
-- Volcado de datos para la tabla `postulante`
--

INSERT INTO `postulante` (`Id_Postulante`, `Nombres`, `Apellidos`, `Correo`, `Clave`, `Estado`) VALUES
(1, 'usuario', 'prueba', 'usuario.prueba@gmail.com', '$2y$10$wmOjc6yfNYoZaI4hTADbHecLG55Im7yIfGd84yy4maBimcxunPE9i', 3),
(2, 'Armando', 'Wilkerson', 'armando.wilkerson@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(3, 'Porter', 'Sosa', 'porter.sosa@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(4, 'Cooper', 'Cox', 'cooper.cox@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(5, 'Timothy', 'Becker', 'timothy.becker@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(6, 'Arthur', 'Anderson', 'arthur.anderson@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(7, 'Nigel', 'Simmons', 'nigel.simmons@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(8, 'Reuben', 'Benson', 'reuben.benson@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(9, 'Barrett', 'Meyer', 'barrett.meyer@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(10, 'Cooper', 'Patterson', 'cooper.patterson@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(11, 'Cade', 'Harrison', 'cade.harrison@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(12, 'Ivor', 'Hayden', 'ivor.hayden@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(13, 'Salvador', 'Dickson', 'salvador.dickson@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(14, 'Travis', 'Avila', 'travis.avila@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 3),
(15, 'Joshua', 'Porter', 'joshua.porter@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(16, 'Plato', 'Fitzgerald', 'plato.fitzgerald@gmail.com', '$2y$10$twjt.ZEFIcQGmy6bk0quOuAUjuazbHzmIL1IXg4CzUHokt/2bXVF6', 2),
(17, 'Jose', 'Pepe', 'josepepe@gmail.com', '$2y$10$lY/FHb3/x1cM5f6gM3qBLOE.lWEi3IKsxd9vo3HTJUlaZIkXYeiLq', 1),
(18, 'gabriel', 'andres', 'gabrielandres@gmail.com', '$2y$10$Mmfh/CLYP.tm/dlYBWKJbeAjoWGUsCXTHx26iuef20C.viuvr9nqa', 1);

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
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_Usuario`, `Nombres`, `Apellidos`, `Correo`, `Alias`, `Clave`, `Estado`) VALUES
(1, 'administrador', 'sistema', 'administrador.sistema@gmail.com', 'Administrador', '$2y$10$vbUuOCqksufaSOJ22kMDD.BYmV2wo7lIC.Md7VnvaDB0qO2nybFAi', 1);

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
  MODIFY `Id_Postulante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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