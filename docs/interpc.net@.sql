-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-06-2025 a las 18:29:40
-- Versión del servidor: 5.7.24
-- Versión de PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `carrito_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Estructura de tabla para la tabla `itemcarrito`
--

CREATE TABLE `itemcarrito` (
  `item_id` int(11) NOT NULL,
  `carrito_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 'Parlantes', 'Nuevo', '35.15', 20, 'tecnologia', 'uploads/terreno.webp'),
(4, 'Fuente de poder', 'Nuevo', '85.50', 1, 'tecnologia', 'uploads/imagen_2025-04-09_215935676-removebg-preview.png'),
(5, 'Pantalla portatil', 'Nuevo', '160.50', 3, 'tecnologia', 'uploads/WhatsApp Image 2025-04-04 at 19.05.45.jpeg'),
(6, 'mouse ergonomico', 'Nuevo', '22.00', 10, 'Medio de trabajo', '/interpc/uploads/mouse.jpg'),
(7, 'Impresora', 'Nuevas y seminuevas', '200.00', 3, 'Medio de trabajo', '/interpc/uploads/mouse.jpg'),
(8, 'Alexa echo POP', 'Nuevo', '65.00', 14, 'Inteligencia', '/interpc/uploads/mouse.jpg');

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
(9, 'Marcos', 'marcosledher123@gmail.com', '$2y$10$5qazB./Sv3qJ41KN97544etTTMGcU2OgeKmvBC7ULCvy/MRGC10T6', 'Merced', '0987410032'),
(10, 'Odalis', 'Oda03@gmail.com', '$2y$10$ap3OEI5PWcCafDtn4HdIyefrm3qFY08J2ryh1LRHv2Zr.XRQDVbxu', 'Barrio Cumanda', '0987233212');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`carrito_id`);

--
-- Indices de la tabla `codigo_admin`
--
ALTER TABLE `codigo_admin`
  ADD PRIMARY KEY (`id_codigo`);

--
-- Indices de la tabla `itemcarrito`
--
ALTER TABLE `itemcarrito`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_item_carrito` (`carrito_id`),
  ADD KEY `fk_item_producto` (`producto_id`);

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
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `carrito_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigo_admin`
--
ALTER TABLE `codigo_admin`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `itemcarrito`
--
ALTER TABLE `itemcarrito`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `itemcarrito`
--
ALTER TABLE `itemcarrito`
  ADD CONSTRAINT `fk_item_carrito` FOREIGN KEY (`carrito_id`) REFERENCES `carrito` (`carrito_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
