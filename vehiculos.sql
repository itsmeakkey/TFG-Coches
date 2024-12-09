-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2024 a las 19:14:47
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `coches`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `matricula` varchar(15) NOT NULL,
  `plazas` tinyint(4) NOT NULL,
  `combustible` varchar(50) NOT NULL,
  `precioDia` decimal(10,2) NOT NULL,
  `fechaMatriculacion` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `marca`, `modelo`, `matricula`, `plazas`, `combustible`, `precioDia`, `fechaMatriculacion`, `estado`, `imagen`) VALUES
(1, 'Peugeot', '308', 'GHI345', 5, 'Diésel', 33.00, '2022-11-25', 'Ocupado', '../Extras/principal/coche5.png'),
(2, 'Toyota', 'Corolla', 'ABC123', 5, 'Gasolina', 30.00, '2020-01-15', 'Ocupado', '../Extras/principal/coche1.jpg'),
(3, 'Volkswagen', 'Golf', 'LMN789', 5, 'Gasolina', 35.00, '2021-03-10', 'Disponible', '../Extras/principal/coche3.png'),
(55, 'Renault', 'Clio', 'DEF012', 5, 'Gasolina', 28.00, '2018-08-05', 'Disponible', '../Extras/principal/coche4.jpg'),
(564, 'Volkswagen', 'Passat 2020', 'XYZ543', 5, 'Diésel', 30.00, '2024-12-03', 'Disponible', '../Extras/principal/coche1733767790.png'),
(565, 'Seat ', 'Ibiza ', 'FED013', 4, 'Diésel', 35.00, '2024-12-03', 'Disponible', '../Extras/principal/coche1733767999.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
