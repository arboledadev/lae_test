-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 11-01-2021 a las 20:40:27
-- Versión del servidor: 5.7.26
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lae_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nombres` text,
  `apellidos` text,
  `email` varchar(250) DEFAULT NULL,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id_admin`, `nombres`, `apellidos`, `email`, `password`) VALUES
(1, 'Ivens', 'Arboleda', 'arboledadev@gmail.com', '$2y$10$LK.RCiwgfiAHCISbjT6Zb.rJZ7smE4lc.7EEaSUqQhPRuUXz1mWUS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api_keys`
--

CREATE TABLE `api_keys` (
  `id_api_key` int(11) NOT NULL,
  `api_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `api_keys`
--

INSERT INTO `api_keys` (`id_api_key`, `api_key`) VALUES
(1, '6367a50d-5da3-44a0-ae31-9142090862a4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tarea` varchar(150) NOT NULL,
  `estado` int(11) NOT NULL COMMENT '1- Completa 0-Incompleta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_session`
--

CREATE TABLE `tokens_session` (
  `id_token_session` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_admin` int(11) NOT NULL,
  `token` text NOT NULL,
  `token_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tokens_session`
--

INSERT INTO `tokens_session` (`id_token_session`, `fecha`, `id_admin`, `token`, `token_estado`) VALUES
(1, '2021-01-10 00:51:50', 1, '1baf424d6af938d8316b2551a7e45d770a1c0b7d1198a2c5f5cb6c6a15b1a18a7d55b5979ab258852d7df6954d0eb263ad961807067c5ea88f61df327419ad60U8YCSRItK5H9OAHL5D3oKxPafN06EDx9naHgJ4kkeNg-', 1),
(2, '2021-01-11 00:10:11', 1, '7b67dfe8d00b3bdc8f15d71b7d9fe8e694cd0e14c3fcabe32a5d5ec04a328e4b25368c74adc0ff404df98e865c259e62b0731f23d6184b4fba577fd9ef94ff2aNSk0S~RHojVJivRZT3eU05gLelXl8JmnQSQbCHdnK5k-', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `telefono` varchar(150) NOT NULL,
  `email` text NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0-Inactivo 1-Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `apellidos`, `telefono`, `email`, `estado`) VALUES
(1, 'José Luis', 'Perales', '34199000', 'jose.luis@mail.com', 1),
(2, 'Roberto Carlos', 'Braga', '33434123', 'roberto.carlos@mail.com', 1),
(3, 'Nicola', 'Di Vari', '43134233', 'nicola.divari@mail.com', 1),
(4, 'Camilo', 'Sesto', '45234434', 'camilo.sesto@mail.com', 0),
(5, 'Jose Luis', 'Rodríguez', '41345555', 'jose.luis.rod@mail.com', 1),
(6, 'Nino', 'Bravo', '66567789', 'nino.bravo@mail.com', 0),
(7, 'Miguel', 'Galeano', '43456433', 'miguel.galeano@mail.com', 1),
(8, 'Diego', 'Verdaguer', '45315333', 'diego.verdaguer@mail.com', 1),
(9, 'Juan Gabriel', 'Aguilera', '25424444', 'juan.gabriel@mail.com', 0),
(10, 'Ana Gabriel', 'Araujo', '45245244', 'ana.gabriel@mail.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id_api_key`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indices de la tabla `tokens_session`
--
ALTER TABLE `tokens_session`
  ADD PRIMARY KEY (`id_token_session`),
  ADD KEY `id_usuario` (`id_admin`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id_api_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tokens_session`
--
ALTER TABLE `tokens_session`
  MODIFY `id_token_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tokens_session`
--
ALTER TABLE `tokens_session`
  ADD CONSTRAINT `tokens_session_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
