-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2016 a las 00:34:12
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `almacen`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id_area` int(10) unsigned NOT NULL,
  `descripcion_area` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id_area`, `descripcion_area`, `created_at`, `updated_at`) VALUES
(1, 'Espacios Verdes', NULL, NULL),
(2, 'Arbolado', NULL, NULL),
(3, 'Taller', NULL, NULL),
(4, 'Administracion', NULL, NULL),
(5, 'Control de Vectores', NULL, NULL),
(6, 'Compras', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE IF NOT EXISTS `articulos` (
  `id_articulo` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unidad` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `stock_actual` int(11) NOT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `usuario` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_rubro` int(10) unsigned NOT NULL,
  `id_subrubro` int(10) unsigned DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `descripcion`, `unidad`, `stock_actual`, `stock_minimo`, `usuario`, `id_usuario`, `id_rubro`, `id_subrubro`, `estado`, `created_at`, `updated_at`) VALUES
(4, 'BULONES 4MM', 'Unidad', 0, NULL, NULL, 1, 1, 10, 1, '2016-06-30 02:34:11', '2016-06-30 02:44:38'),
(5, 'BULONES 6 MM', 'Unidad', 0, NULL, NULL, 1, 1, 10, 1, '2016-06-30 02:37:49', '2016-06-30 02:50:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` int(10) unsigned NOT NULL,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `dni` int(11) DEFAULT NULL,
  `legajo` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `dni`, `legajo`, `created_at`, `updated_at`) VALUES
(1, 'Franco Nicolas', 'Maggioni', NULL, NULL, NULL, NULL),
(2, 'Yamila Gabriela', 'Lopez', NULL, NULL, NULL, NULL),
(3, 'Matias', 'Ramirez', NULL, NULL, NULL, NULL),
(4, 'Nicolas ', 'Dalmas', NULL, NULL, NULL, NULL),
(5, 'Jesus Matias', 'Rubio', NULL, NULL, NULL, NULL),
(6, 'Dante', 'Sancimino', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_06_02_151120_crear_rubros_tabla', 1),
('2016_06_02_151901_crear_subrubros_tabla', 1),
('2016_06_10_110447_crear_articulos_tabla', 1),
('2016_06_19_215052_crear_empleados_tabla', 1),
('2016_06_24_194906_crear_areas_tabla', 1),
('2016_06_24_195323_crear_subareas_tabla', 1),
('2016_06_25_230349_crear_salidamaster_tabla', 1),
('2016_06_25_230723_crear_salidadetalles_tabla', 1),
('2016_06_29_185122_crear_usersinfo_tabla', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

CREATE TABLE IF NOT EXISTS `rubros` (
  `id_rubro` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`id_rubro`, `descripcion`) VALUES
(1, 'FERROSOS'),
(2, 'ART. LIMPIEZA'),
(3, 'ART. LIBRERIA'),
(4, 'ART. INFORMATICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas_detalles`
--

CREATE TABLE IF NOT EXISTS `salidas_detalles` (
  `id_detalles` int(10) unsigned NOT NULL,
  `id_master` int(10) unsigned NOT NULL,
  `id_articulo` int(10) unsigned NOT NULL,
  `id_empleado` int(10) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `salidas_detalles`
--

INSERT INTO `salidas_detalles` (`id_detalles`, `id_master`, `id_articulo`, `id_empleado`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 10, '2016-06-30 00:27:45', '2016-06-30 00:27:45'),
(2, 2, 5, 1, 10, '2016-06-30 00:37:39', '2016-06-30 00:37:39'),
(3, 3, 5, 1, 10, '2016-06-30 00:37:42', '2016-06-30 00:37:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas_master`
--

CREATE TABLE IF NOT EXISTS `salidas_master` (
  `id_master` int(10) unsigned NOT NULL,
  `tipo_retiro` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `id_subarea` int(10) unsigned NOT NULL,
  `id_usuario` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `salidas_master`
--

INSERT INTO `salidas_master` (`id_master`, `tipo_retiro`, `estado`, `id_subarea`, `id_usuario`, `created_at`, `updated_at`) VALUES
(1, 'retiropersonal', 0, 9, 1, '2016-06-30 00:27:45', '2016-06-30 00:27:45'),
(2, 'retiropersonal', 0, 5, 1, '2016-06-30 00:37:39', '2016-06-30 00:37:39'),
(3, 'retiropersonal', 0, 5, 1, '2016-06-30 00:37:42', '2016-06-30 00:37:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subareas`
--

CREATE TABLE IF NOT EXISTS `subareas` (
  `id_subarea` int(10) unsigned NOT NULL,
  `id_area` int(10) unsigned NOT NULL,
  `descripcion_subarea` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `subareas`
--

INSERT INTO `subareas` (`id_subarea`, `id_area`, `descripcion_subarea`, `created_at`, `updated_at`) VALUES
(5, 1, 'Parque España Arriba', NULL, NULL),
(6, 1, 'Patio de la Madera', NULL, NULL),
(7, 1, 'Monumento', NULL, NULL),
(8, 1, 'Cuadrilla de arbolado', NULL, NULL),
(9, 3, 'Taller herreria', NULL, NULL),
(10, 3, 'Taller Mecanica', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subrubros`
--

CREATE TABLE IF NOT EXISTS `subrubros` (
  `id_subrubro` int(10) unsigned NOT NULL,
  `id_rubro` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `subrubros`
--

INSERT INTO `subrubros` (`id_subrubro`, `id_rubro`, `descripcion`) VALUES
(10, 1, 'BULONES'),
(11, 1, 'CAÑOS DE ALUMINIO'),
(12, 1, 'TORNILLOS'),
(13, 2, 'LIQUIDOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'fmaggio0', 'fmaggio0@rosario.gov.ar', '$2y$10$.TRHC/35jTLiAyUs2oRTqO4Ny6N5x51uF/jBWytpy/a2KEV7nKLVW', 'jSgKa5LArkpsfO3xivGnHAYvBFhM267pan2taZPQOPZpyBvUnSabbSOW10nl', '2016-06-30 01:21:10', '2016-06-30 01:22:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_info`
--

CREATE TABLE IF NOT EXISTS `users_info` (
  `id_user` int(10) unsigned NOT NULL,
  `id_area` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users_info`
--

INSERT INTO `users_info` (`id_user`, `id_area`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`),
  ADD KEY `articulos_id_usuario_foreign` (`id_usuario`),
  ADD KEY `articulos_id_rubro_foreign` (`id_rubro`),
  ADD KEY `articulos_id_subrubro_foreign` (`id_subrubro`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `rubros`
--
ALTER TABLE `rubros`
  ADD PRIMARY KEY (`id_rubro`);

--
-- Indices de la tabla `salidas_detalles`
--
ALTER TABLE `salidas_detalles`
  ADD PRIMARY KEY (`id_detalles`),
  ADD KEY `salidas_detalles_id_master_foreign` (`id_master`),
  ADD KEY `salidas_detalles_id_articulo_foreign` (`id_articulo`),
  ADD KEY `salidas_detalles_id_empleado_foreign` (`id_empleado`);

--
-- Indices de la tabla `salidas_master`
--
ALTER TABLE `salidas_master`
  ADD PRIMARY KEY (`id_master`),
  ADD KEY `salidas_master_id_subarea_foreign` (`id_subarea`),
  ADD KEY `salidas_master_id_usuario_foreign` (`id_usuario`);

--
-- Indices de la tabla `subareas`
--
ALTER TABLE `subareas`
  ADD PRIMARY KEY (`id_subarea`),
  ADD KEY `subareas_id_area_foreign` (`id_area`);

--
-- Indices de la tabla `subrubros`
--
ALTER TABLE `subrubros`
  ADD PRIMARY KEY (`id_subrubro`),
  ADD KEY `subrubros_id_rubro_foreign` (`id_rubro`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `users_info`
--
ALTER TABLE `users_info`
  ADD KEY `users_info_id_user_foreign` (`id_user`),
  ADD KEY `users_info_id_area_foreign` (`id_area`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id_area` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_articulo` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `rubros`
--
ALTER TABLE `rubros`
  MODIFY `id_rubro` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `salidas_detalles`
--
ALTER TABLE `salidas_detalles`
  MODIFY `id_detalles` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `salidas_master`
--
ALTER TABLE `salidas_master`
  MODIFY `id_master` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `subareas`
--
ALTER TABLE `subareas`
  MODIFY `id_subarea` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `subrubros`
--
ALTER TABLE `subrubros`
  MODIFY `id_subrubro` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_id_rubro_foreign` FOREIGN KEY (`id_rubro`) REFERENCES `rubros` (`id_rubro`),
  ADD CONSTRAINT `articulos_id_subrubro_foreign` FOREIGN KEY (`id_subrubro`) REFERENCES `subrubros` (`id_subrubro`),
  ADD CONSTRAINT `articulos_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `salidas_detalles`
--
ALTER TABLE `salidas_detalles`
  ADD CONSTRAINT `salidas_detalles_id_articulo_foreign` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`),
  ADD CONSTRAINT `salidas_detalles_id_empleado_foreign` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `salidas_detalles_id_master_foreign` FOREIGN KEY (`id_master`) REFERENCES `salidas_master` (`id_master`);

--
-- Filtros para la tabla `salidas_master`
--
ALTER TABLE `salidas_master`
  ADD CONSTRAINT `salidas_master_id_subarea_foreign` FOREIGN KEY (`id_subarea`) REFERENCES `subareas` (`id_subarea`),
  ADD CONSTRAINT `salidas_master_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `subareas`
--
ALTER TABLE `subareas`
  ADD CONSTRAINT `subareas_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id_area`);

--
-- Filtros para la tabla `subrubros`
--
ALTER TABLE `subrubros`
  ADD CONSTRAINT `subrubros_id_rubro_foreign` FOREIGN KEY (`id_rubro`) REFERENCES `rubros` (`id_rubro`);

--
-- Filtros para la tabla `users_info`
--
ALTER TABLE `users_info`
  ADD CONSTRAINT `users_info_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id_area`),
  ADD CONSTRAINT `users_info_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
