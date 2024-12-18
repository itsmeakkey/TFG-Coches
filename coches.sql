-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2024 a las 16:17:17
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
CREATE DATABASE IF NOT EXISTS `coches` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `coches`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `reserva_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparaciones`
--

DROP TABLE IF EXISTS `reparaciones`;
CREATE TABLE `reparaciones` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `costo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reparaciones`
--

INSERT INTO `reparaciones` (`id`, `vehiculo_id`, `fecha`, `descripcion`, `costo`) VALUES
(45, 2, '2024-12-01', 'Cambio de aceite y filtros', 75.00),
(46, 3, '2024-12-01', 'Reemplazo de batería', 120.00),
(52, 55, '2023-06-15', 'Inventada', 23.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_seguro`
--

DROP TABLE IF EXISTS `reserva_seguro`;
CREATE TABLE `reserva_seguro` (
  `reserva_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguros`
--

DROP TABLE IF EXISTS `seguros`;
CREATE TABLE `seguros` (
  `id` int(11) NOT NULL,
  `tipo` enum('obligatorio','opcional') NOT NULL,
  `cobertura` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguros`
--

INSERT INTO `seguros` (`id`, `tipo`, `cobertura`, `precio`, `descripcion`) VALUES
(21, 'obligatorio', 'Responsabilidad Civil', 15.00, 'Cubre los daños a terceros en caso de accidente. Obligatorio por ley.'),
(22, 'obligatorio', 'Seguro contra Robo', 10.00, 'Cubre el robo total o parcial del vehículo de alquiler. Incluye asistencia.'),
(23, 'obligatorio', 'Daños por colisión (CDW)', 20.00, 'Cubre los daños causados por colisión con otro vehículo u objeto. Requiere franquicia.'),
(26, 'opcional', 'Asistencia en Carretera Premium', 7.00, 'Cobertura avanzada de asistencia en carretera, incluyendo cambio de neumáticos y asistencia por avería.'),
(28, 'opcional', 'Seguro de Equipaje', 6.00, 'Cubre la pérdida, robo o daños en el equipaje dentro del vehículo.'),
(29, 'opcional', 'Conductor Adicional', 10.00, 'Añade cobertura para un conductor adicional, permitiéndole conducir el vehículo bajo la misma póliza.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `dni`, `apellidos`, `nombre`, `fechaNacimiento`, `telefono`, `correo`, `localidad`, `provincia`, `cp`, `tipo`, `password`, `token`) VALUES
(1, '26050377W', 'Ruiz Aranda', 'David', '1999-06-15', '630031412', 'akkey@server.edu', 'Alcalá la Real', 'Jaén', '23680', 2, '$2y$15$K8Ii8OhSqw9z0UoQl6DWNesylnv94lhF8SsPVg1.Vss3LddvX7ej6', '602d1305678a8d5fdb372271e980da6a'),
(36, '52536633J', 'Ruiz Aranda', 'Cliente', '1999-06-15', '987654321', 'cliente@server.edu', 'Alcalá la Real', 'Jaén', '23680', 1, '$2y$15$Ovraze7CUYnYYjBfzfTx8eMHEHRa84CsruNsMk7x7X5k/sJKfftFm', '1d7f7abc18fcb43975065399b0d1e48e');

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
(1, 'Peugeot', '308', 'GHI345', 5, 'Diésel', 33.00, '2022-11-25', 'Disponible', '../Extras/principal/coche5.png'),
(2, 'Toyota', 'Corolla', 'ABC123', 5, 'Gasolina', 30.00, '2020-01-15', 'Disponible', '../Extras/principal/coche1.jpg'),
(3, 'Volkswagen', 'Golf', 'LMN789', 5, 'Gasolina', 35.00, '2021-03-10', 'Disponible', '../Extras/principal/coche3.png'),
(55, 'Renault', 'Clio', 'DEF012', 5, 'Gasolina', 28.00, '2018-08-05', 'Disponible', '../Extras/principal/coche4.jpg'),
(57, 'Nissan', 'Qashqai', 'JKL678', 5, 'Gasolina', 40.00, '2020-12-30', 'Disponible', '../Extras/principal/coche6.png'),
(563, 'Honda', 'Civic', 'GHI346', 4, 'Diésel', 45.00, '2024-11-04', 'Disponible', '../Extras/principal/coche1730740547.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_id` (`reserva_id`);

--
-- Indices de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`);

--
-- Indices de la tabla `reserva_seguro`
--
ALTER TABLE `reserva_seguro`
  ADD PRIMARY KEY (`reserva_id`,`seguro_id`),
  ADD KEY `seguro_id` (`seguro_id`);

--
-- Indices de la tabla `seguros`
--
ALTER TABLE `seguros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `seguros`
--
ALTER TABLE `seguros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=565;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  ADD CONSTRAINT `reparaciones_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reserva_seguro`
--
ALTER TABLE `reserva_seguro`
  ADD CONSTRAINT `reserva_seguro_ibfk_1` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguros` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
