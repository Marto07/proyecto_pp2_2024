-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2024 a las 21:00:32
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
-- Base de datos: `proyecto_pp2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_perfil_modulo`
--

CREATE TABLE `asignacion_perfil_modulo` (
  `id_asignacion_perfil_modulo` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_perfil` int(11) DEFAULT NULL,
  `rela_modulo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion_perfil_modulo`
--

INSERT INTO `asignacion_perfil_modulo` (`id_asignacion_perfil_modulo`, `estado`, `rela_perfil`, `rela_modulo`) VALUES
(1, 1, 2, 2),
(2, 1, 2, 1),
(3, 1, 2, 3),
(4, 1, 1, 1),
(6, 1, 3, 1),
(7, 1, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_persona_complejo`
--

CREATE TABLE `asignacion_persona_complejo` (
  `id_asignacion_persona_complejo` int(11) NOT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_persona` int(11) DEFAULT NULL,
  `rela_complejo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_persona_domicilio`
--

CREATE TABLE `asignacion_persona_domicilio` (
  `id_asignacion_persona_domicilio` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_persona` int(11) DEFAULT NULL,
  `rela_barrio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_sucursal_domicilio`
--

CREATE TABLE `asignacion_sucursal_domicilio` (
  `id_asignacion_sucursal_domicilio` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_sucursal` int(11) DEFAULT NULL,
  `rela_barrio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_tarifa_servicio`
--

CREATE TABLE `asignacion_tarifa_servicio` (
  `id_asignacion_tarifa_servicio` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_tarifa` int(11) DEFAULT NULL,
  `rela_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrio`
--

CREATE TABLE `barrio` (
  `id_barrio` int(11) NOT NULL,
  `descripcion_barrio` varchar(50) DEFAULT NULL,
  `rela_localidad` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `complejo`
--

CREATE TABLE `complejo` (
  `id_complejo` int(11) NOT NULL,
  `descripcion_complejo` varchar(50) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int(11) NOT NULL,
  `descripcion_contacto` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_tipo_contacto` int(11) DEFAULT NULL,
  `rela_persona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `descripcion_contacto`, `estado`, `rela_tipo_contacto`, `rela_persona`) VALUES
(11, ' Correo@prueba.com', 1, 1, 12),
(12, 'Rinngley@gmail.com', 1, 1, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE `control` (
  `id_control` int(11) NOT NULL,
  `descripcion_control` varchar(50) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_estado_control` int(11) DEFAULT NULL,
  `rela_reserva` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deporte`
--

CREATE TABLE `deporte` (
  `id_deporte` int(11) NOT NULL,
  `descripcion_deporte` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id_documento` int(11) NOT NULL,
  `descripcion_documento` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_tipo_documento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`id_documento`, `descripcion_documento`, `estado`, `rela_tipo_documento`) VALUES
(13, '15.253.244', 1, 1),
(14, '42757241', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL,
  `descripcion_equipo` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_evento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_control`
--

CREATE TABLE `estado_control` (
  `id_estado_control` int(11) NOT NULL,
  `descripcion_estado_control` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_reserva`
--

CREATE TABLE `estado_reserva` (
  `id_estado_reserva` int(11) NOT NULL,
  `descripcion_estado_reserva` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_zona`
--

CREATE TABLE `estado_zona` (
  `id_estado_zona` int(11) NOT NULL,
  `descripcion_estado_zona` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `descripcion_evento` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_deporte`
--

CREATE TABLE `formato_deporte` (
  `id_formato_deporte` int(11) NOT NULL,
  `descripcion_formato_deporte` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_deporte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `horario_inicio` time DEFAULT NULL,
  `horario_fin` time DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL,
  `descripcion_localidad` varchar(50) DEFAULT NULL,
  `rela_provincia` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id_modulo` int(11) NOT NULL,
  `descripcion_modulo` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `descripcion_modulo`, `estado`) VALUES
(1, 'inicio', 1),
(2, 'personas', 1),
(3, 'Domicilios', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `descripcion_perfil` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `descripcion_perfil`, `estado`) VALUES
(1, 'Basico', 1),
(2, 'administrador', 1),
(3, 'Personal Administrativo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cuil` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_documento` int(11) DEFAULT NULL,
  `rela_sexo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre`, `apellido`, `cuil`, `fecha_nacimiento`, `fecha_alta`, `estado`, `rela_documento`, `rela_sexo`) VALUES
(12, 'Nombre de prueba', 'Apellido de Prueba', NULL, NULL, NULL, 1, 13, 1),
(13, 'edgar', 'coppa', NULL, NULL, NULL, 1, 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL,
  `descripcion_provincia` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `descripcion_reserva` varchar(50) DEFAULT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_estado_reserva` int(11) DEFAULT NULL,
  `rela_persona` int(11) DEFAULT NULL,
  `rela_zona` int(11) DEFAULT NULL,
  `rela_horario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `descripcion_servicio` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL,
  `descripcion_sexo` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id_sexo`, `descripcion_sexo`, `estado`) VALUES
(1, 'masculino', 1),
(2, 'femenino', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id_socio` int(11) NOT NULL,
  `descripcion_socio` varchar(50) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_complejo` int(11) DEFAULT NULL,
  `rela_persona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `descripcion_sucursal` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_complejo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `id_tarifa` int(11) NOT NULL,
  `precio` float DEFAULT NULL,
  `horario_desde` time DEFAULT NULL,
  `horario_hasta` time DEFAULT NULL,
  `turno` enum('dia','noche') DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_contacto`
--

CREATE TABLE `tipo_contacto` (
  `id_tipo_contacto` int(11) NOT NULL,
  `descripcion_tipo_contacto` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_contacto`
--

INSERT INTO `tipo_contacto` (`id_tipo_contacto`, `descripcion_tipo_contacto`, `estado`) VALUES
(1, 'E-mail', 1),
(2, 'Telefono', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` int(11) NOT NULL,
  `descripcion_tipo_documento` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `descripcion_tipo_documento`, `estado`) VALUES
(1, 'DNI', 1),
(2, 'Libreta', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_terreno`
--

CREATE TABLE `tipo_terreno` (
  `id_tipo_terreno` int(11) NOT NULL,
  `descripcion_tipo_terreno` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'no verificado',
  `rela_contacto` int(11) NOT NULL,
  `rela_perfil` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `password`, `token`, `estado`, `rela_contacto`, `rela_perfil`) VALUES
(7, 'UserName Prueba', '$2y$10$EjZxH67afUdqvylIgoAgUO1Fog5Whi3ziEMZQR.WKUYRs5g3cV.h.', '', 'verificado', 11, 2),
(8, 'rinngley', '$2y$10$LUo2AL/knShM5wrYy5Ody.rqAe/u4axw3dMKwC.dhF8jcUfoQuysS', 'fb21b596674f9fde250f257c12a8c833', 'verificado', 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id_zona` int(11) NOT NULL,
  `descripcion_zona` varchar(50) DEFAULT NULL,
  `dimension` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `rela_tipo_terreno` int(11) DEFAULT NULL,
  `rela_formato_deporte` int(11) DEFAULT NULL,
  `rela_estado_zona` int(11) DEFAULT NULL,
  `rela_sucursal` int(11) DEFAULT NULL,
  `rela_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion_perfil_modulo`
--
ALTER TABLE `asignacion_perfil_modulo`
  ADD PRIMARY KEY (`id_asignacion_perfil_modulo`),
  ADD KEY `rela_perfil` (`rela_perfil`),
  ADD KEY `rela_modulo` (`rela_modulo`);

--
-- Indices de la tabla `asignacion_persona_complejo`
--
ALTER TABLE `asignacion_persona_complejo`
  ADD PRIMARY KEY (`id_asignacion_persona_complejo`),
  ADD KEY `rela_persona` (`rela_persona`),
  ADD KEY `rela_complejo` (`rela_complejo`);

--
-- Indices de la tabla `asignacion_persona_domicilio`
--
ALTER TABLE `asignacion_persona_domicilio`
  ADD PRIMARY KEY (`id_asignacion_persona_domicilio`),
  ADD KEY `rela_persona` (`rela_persona`),
  ADD KEY `rela_barrio` (`rela_barrio`);

--
-- Indices de la tabla `asignacion_sucursal_domicilio`
--
ALTER TABLE `asignacion_sucursal_domicilio`
  ADD PRIMARY KEY (`id_asignacion_sucursal_domicilio`),
  ADD KEY `rela_sucursal` (`rela_sucursal`),
  ADD KEY `rela_barrio` (`rela_barrio`);

--
-- Indices de la tabla `asignacion_tarifa_servicio`
--
ALTER TABLE `asignacion_tarifa_servicio`
  ADD PRIMARY KEY (`id_asignacion_tarifa_servicio`),
  ADD KEY `rela_tarifa` (`rela_tarifa`),
  ADD KEY `rela_servicio` (`rela_servicio`);

--
-- Indices de la tabla `barrio`
--
ALTER TABLE `barrio`
  ADD PRIMARY KEY (`id_barrio`),
  ADD KEY `rela_localidad` (`rela_localidad`);

--
-- Indices de la tabla `complejo`
--
ALTER TABLE `complejo`
  ADD PRIMARY KEY (`id_complejo`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`),
  ADD UNIQUE KEY `descripcion_contacto` (`descripcion_contacto`),
  ADD KEY `rela_tipo_contacto` (`rela_tipo_contacto`),
  ADD KEY `rela_persona` (`rela_persona`);

--
-- Indices de la tabla `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `rela_estado_control` (`rela_estado_control`),
  ADD KEY `rela_reserva` (`rela_reserva`);

--
-- Indices de la tabla `deporte`
--
ALTER TABLE `deporte`
  ADD PRIMARY KEY (`id_deporte`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id_documento`),
  ADD UNIQUE KEY `descripcion_documento` (`descripcion_documento`,`rela_tipo_documento`),
  ADD KEY `rela_tipo_documento` (`rela_tipo_documento`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `rela_evento` (`rela_evento`);

--
-- Indices de la tabla `estado_control`
--
ALTER TABLE `estado_control`
  ADD PRIMARY KEY (`id_estado_control`);

--
-- Indices de la tabla `estado_reserva`
--
ALTER TABLE `estado_reserva`
  ADD PRIMARY KEY (`id_estado_reserva`);

--
-- Indices de la tabla `estado_zona`
--
ALTER TABLE `estado_zona`
  ADD PRIMARY KEY (`id_estado_zona`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `rela_servicio` (`rela_servicio`);

--
-- Indices de la tabla `formato_deporte`
--
ALTER TABLE `formato_deporte`
  ADD PRIMARY KEY (`id_formato_deporte`),
  ADD KEY `rela_deporte` (`rela_deporte`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id_localidad`),
  ADD KEY `rela_provincia` (`rela_provincia`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `rela_documento` (`rela_documento`),
  ADD KEY `rela_sexo` (`rela_sexo`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id_provincia`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `rela_estado_reserva` (`rela_estado_reserva`),
  ADD KEY `rela_persona` (`rela_persona`),
  ADD KEY `rela_zona` (`rela_zona`),
  ADD KEY `rela_horario` (`rela_horario`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id_sexo`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id_socio`),
  ADD KEY `rela_complejo` (`rela_complejo`),
  ADD KEY `rela_persona` (`rela_persona`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `rela_complejo` (`rela_complejo`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `tipo_contacto`
--
ALTER TABLE `tipo_contacto`
  ADD PRIMARY KEY (`id_tipo_contacto`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indices de la tabla `tipo_terreno`
--
ALTER TABLE `tipo_terreno`
  ADD PRIMARY KEY (`id_tipo_terreno`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `rela_contacto` (`rela_contacto`),
  ADD KEY `rela_perfil` (`rela_perfil`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id_zona`),
  ADD KEY `rela_tipo_terreno` (`rela_tipo_terreno`),
  ADD KEY `rela_formato_deporte` (`rela_formato_deporte`),
  ADD KEY `rela_estado_zona` (`rela_estado_zona`),
  ADD KEY `rela_sucursal` (`rela_sucursal`),
  ADD KEY `rela_servicio` (`rela_servicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacion_perfil_modulo`
--
ALTER TABLE `asignacion_perfil_modulo`
  MODIFY `id_asignacion_perfil_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `asignacion_persona_complejo`
--
ALTER TABLE `asignacion_persona_complejo`
  MODIFY `id_asignacion_persona_complejo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignacion_persona_domicilio`
--
ALTER TABLE `asignacion_persona_domicilio`
  MODIFY `id_asignacion_persona_domicilio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignacion_sucursal_domicilio`
--
ALTER TABLE `asignacion_sucursal_domicilio`
  MODIFY `id_asignacion_sucursal_domicilio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignacion_tarifa_servicio`
--
ALTER TABLE `asignacion_tarifa_servicio`
  MODIFY `id_asignacion_tarifa_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `barrio`
--
ALTER TABLE `barrio`
  MODIFY `id_barrio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `complejo`
--
ALTER TABLE `complejo`
  MODIFY `id_complejo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id_control` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `deporte`
--
ALTER TABLE `deporte`
  MODIFY `id_deporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_control`
--
ALTER TABLE `estado_control`
  MODIFY `id_estado_control` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_reserva`
--
ALTER TABLE `estado_reserva`
  MODIFY `id_estado_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_zona`
--
ALTER TABLE `estado_zona`
  MODIFY `id_estado_zona` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formato_deporte`
--
ALTER TABLE `formato_deporte`
  MODIFY `id_formato_deporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id_provincia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id_sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_contacto`
--
ALTER TABLE `tipo_contacto`
  MODIFY `id_tipo_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_terreno`
--
ALTER TABLE `tipo_terreno`
  MODIFY `id_tipo_terreno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_perfil_modulo`
--
ALTER TABLE `asignacion_perfil_modulo`
  ADD CONSTRAINT `asignacion_perfil_modulo_ibfk_1` FOREIGN KEY (`rela_perfil`) REFERENCES `perfil` (`id_perfil`),
  ADD CONSTRAINT `asignacion_perfil_modulo_ibfk_2` FOREIGN KEY (`rela_modulo`) REFERENCES `modulo` (`id_modulo`);

--
-- Filtros para la tabla `asignacion_persona_complejo`
--
ALTER TABLE `asignacion_persona_complejo`
  ADD CONSTRAINT `asignacion_persona_complejo_ibfk_1` FOREIGN KEY (`rela_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `asignacion_persona_complejo_ibfk_2` FOREIGN KEY (`rela_complejo`) REFERENCES `complejo` (`id_complejo`);

--
-- Filtros para la tabla `asignacion_persona_domicilio`
--
ALTER TABLE `asignacion_persona_domicilio`
  ADD CONSTRAINT `asignacion_persona_domicilio_ibfk_1` FOREIGN KEY (`rela_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `asignacion_persona_domicilio_ibfk_2` FOREIGN KEY (`rela_barrio`) REFERENCES `barrio` (`id_barrio`);

--
-- Filtros para la tabla `asignacion_sucursal_domicilio`
--
ALTER TABLE `asignacion_sucursal_domicilio`
  ADD CONSTRAINT `asignacion_sucursal_domicilio_ibfk_1` FOREIGN KEY (`rela_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `asignacion_sucursal_domicilio_ibfk_2` FOREIGN KEY (`rela_barrio`) REFERENCES `barrio` (`id_barrio`);

--
-- Filtros para la tabla `asignacion_tarifa_servicio`
--
ALTER TABLE `asignacion_tarifa_servicio`
  ADD CONSTRAINT `asignacion_tarifa_servicio_ibfk_1` FOREIGN KEY (`rela_tarifa`) REFERENCES `tarifa` (`id_tarifa`),
  ADD CONSTRAINT `asignacion_tarifa_servicio_ibfk_2` FOREIGN KEY (`rela_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `barrio`
--
ALTER TABLE `barrio`
  ADD CONSTRAINT `barrio_ibfk_1` FOREIGN KEY (`rela_localidad`) REFERENCES `localidad` (`id_localidad`);

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`rela_tipo_contacto`) REFERENCES `tipo_contacto` (`id_tipo_contacto`),
  ADD CONSTRAINT `contacto_ibfk_2` FOREIGN KEY (`rela_persona`) REFERENCES `persona` (`id_persona`);

--
-- Filtros para la tabla `control`
--
ALTER TABLE `control`
  ADD CONSTRAINT `control_ibfk_1` FOREIGN KEY (`rela_estado_control`) REFERENCES `estado_control` (`id_estado_control`),
  ADD CONSTRAINT `control_ibfk_2` FOREIGN KEY (`rela_reserva`) REFERENCES `reserva` (`id_reserva`);

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`rela_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`);

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`rela_evento`) REFERENCES `evento` (`id_evento`);

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`rela_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `formato_deporte`
--
ALTER TABLE `formato_deporte`
  ADD CONSTRAINT `formato_deporte_ibfk_1` FOREIGN KEY (`rela_deporte`) REFERENCES `deporte` (`id_deporte`);

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `localidad_ibfk_1` FOREIGN KEY (`rela_provincia`) REFERENCES `provincia` (`id_provincia`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rela_documento`) REFERENCES `documento` (`id_documento`),
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`rela_sexo`) REFERENCES `sexo` (`id_sexo`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`rela_estado_reserva`) REFERENCES `estado_reserva` (`id_estado_reserva`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`rela_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`rela_zona`) REFERENCES `zona` (`id_zona`),
  ADD CONSTRAINT `reserva_ibfk_4` FOREIGN KEY (`rela_horario`) REFERENCES `horario` (`id_horario`);

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `socio_ibfk_1` FOREIGN KEY (`rela_complejo`) REFERENCES `complejo` (`id_complejo`),
  ADD CONSTRAINT `socio_ibfk_2` FOREIGN KEY (`rela_persona`) REFERENCES `persona` (`id_persona`);

--
-- Filtros para la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD CONSTRAINT `sucursal_ibfk_1` FOREIGN KEY (`rela_complejo`) REFERENCES `complejo` (`id_complejo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rela_contacto`) REFERENCES `contacto` (`id_contacto`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`rela_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `zona_ibfk_1` FOREIGN KEY (`rela_tipo_terreno`) REFERENCES `tipo_terreno` (`id_tipo_terreno`),
  ADD CONSTRAINT `zona_ibfk_2` FOREIGN KEY (`rela_formato_deporte`) REFERENCES `formato_deporte` (`id_formato_deporte`),
  ADD CONSTRAINT `zona_ibfk_3` FOREIGN KEY (`rela_estado_zona`) REFERENCES `estado_zona` (`id_estado_zona`),
  ADD CONSTRAINT `zona_ibfk_4` FOREIGN KEY (`rela_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `zona_ibfk_5` FOREIGN KEY (`rela_servicio`) REFERENCES `servicio` (`id_servicio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
