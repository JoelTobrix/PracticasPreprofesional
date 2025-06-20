-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-06-2025 a las 09:51:29
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `interpc.net@`
--
CREATE DATABASE IF NOT EXISTS `interpc.net@` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `interpc.net@`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_admin`
--

CREATE TABLE `codigo_admin` (
  `id_codigo` int(11) NOT NULL,
  `codigo` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `codigo_admin`
--

INSERT INTO `codigo_admin` (`id_codigo`, `codigo`) VALUES
(1, '3302');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `nombre`, `descripcion`, `precio`, `stock`, `categoria`, `imagen`) VALUES
(1, 'laptop', 'Nuevo', '800.04', 3, 'tecnologia', 'uploads/WhatsApp Image 2025-04-04 at 19.05.45(1).jpeg'),
(2, 'mouse', 'Nuevo', '20.10', 5, 'tecnologia', 'uploads/WhatsApp Image 2025-04-04 at 19.05.45.jpeg'),
(3, 'Parlantes', 'Nuevo', '20.15', 10, 'tecnologia', 'uploads/terreno.webp'),
(4, 'Fuente de poder', 'Nuevo', '85.50', 1, 'tecnologia', 'uploads/imagen_2025-04-09_215935676-removebg-preview.png'),
(5, 'Pantalla portatil', 'Nuevo', '160.50', 3, 'tecnologia', 'uploads/WhatsApp Image 2025-04-04 at 19.05.45.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombre`, `email`, `password`, `direccion`, `telefono`) VALUES
(1, 'Fabian', 'fabian123@gmail.com', '$2y$10$UFNAj3fB86WKpTDfWBP3AOxeYUnoAK.zrJn10BRFyV4V04Acpk3qW', 'Merced', '0987410032'),
(2, 'criss', 'criscristian49@gmail.com', '$2y$10$ztN2U6bz0lwqoQNqg5zCS.SJAW5ZKePgwFeX3FlLMn/P2P.KEZ14O', 'Barrio los Olivos', '0988521336'),
(4, 'Marcos', 'marcosledher123@gmail.com', '$2y$10$6oI8VVUmSibtvWsApURdQuzSD7UNl1nw2p/CH5Q2w1DmToNOD4rjO', 'Barrio el obrero', '0988541239'),
(6, 'Fabian', 'fabian123@gmail.com', '$2y$10$4bUk3AbCrTJy0UWFy9zx7uPXZWduqp2LkIMbhR6.BFLbJQm/ueNgq', 'Barrio el obrero', '0988541239'),
(9, 'Marcos', 'marcosledher123@gmail.com', '$2y$10$5qazB./Sv3qJ41KN97544etTTMGcU2OgeKmvBC7ULCvy/MRGC10T6', 'Merced', '0987410032');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigo_admin`
--
ALTER TABLE `codigo_admin`
  ADD PRIMARY KEY (`id_codigo`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `codigo_admin`
--
ALTER TABLE `codigo_admin`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
