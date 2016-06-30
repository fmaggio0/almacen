
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'fmaggio0', 'fmaggio0@rosario.gov.ar', '$2y$10$.TRHC/35jTLiAyUs2oRTqO4Ny6N5x51uF/jBWytpy/a2KEV7nKLVW', 'jSgKa5LArkpsfO3xivGnHAYvBFhM267pan2taZPQOPZpyBvUnSabbSOW10nl', '2016-06-30 01:21:10', '2016-06-30 01:22:05');


INSERT INTO `areas` (`id_area`, `descripcion_area`, `created_at`, `updated_at`) VALUES
(1, 'Espacios Verdes', NULL, NULL),
(2, 'Arbolado', NULL, NULL),
(3, 'Taller', NULL, NULL),
(4, 'Administracion', NULL, NULL),
(5, 'Control de Vectores', NULL, NULL),
(6, 'Compras', NULL, NULL);


INSERT INTO `subareas` (`id_subarea`, `id_area`, `descripcion_subarea`, `created_at`, `updated_at`) VALUES
(5, 1, 'Parque España Arriba', NULL, NULL),
(6, 1, 'Patio de la Madera', NULL, NULL),
(7, 1, 'Monumento', NULL, NULL),
(8, 1, 'Cuadrilla de arbolado', NULL, NULL),
(9, 3, 'Taller Herreria', NULL, NULL),
(10, 3, 'Taller Mecanica', NULL, NULL);


INSERT INTO `rubros` (`id_rubro`, `descripcion`) VALUES
(1, 'FERROSOS'),
(2, 'ART. LIMPIEZA'),
(3, 'ART. LIBRERIA'),
(4, 'ART. INFORMATICA');


INSERT INTO `subrubros` (`id_subrubro`, `id_rubro`, `descripcion`) VALUES
(10, 1, 'BULONES'),
(11, 1, 'CAÑOS DE ALUMINIO'),
(12, 1, 'TORNILLOS'),
(13, 2, 'LIQUIDOS');


INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `dni`, `legajo`, `created_at`, `updated_at`) VALUES
(1, 'Franco Nicolas', 'Maggioni', NULL, NULL, NULL, NULL),
(2, 'Yamila Gabriela', 'Lopez', NULL, NULL, NULL, NULL),
(3, 'Matias', 'Ramirez', NULL, NULL, NULL, NULL),
(4, 'Nicolas ', 'Dalmas', NULL, NULL, NULL, NULL),
(5, 'Jesus Matias', 'Rubio', NULL, NULL, NULL, NULL),
(6, 'Dante', 'Sancimino', NULL, NULL, NULL, NULL);


INSERT INTO `articulos` (`id_articulo`, `descripcion`, `unidad`, `stock_actual`, `stock_minimo`, `usuario`, `id_usuario`, `id_rubro`, `id_subrubro`, `estado`, `created_at`, `updated_at`) VALUES
(4, 'BULONES 4MM', 'Unidad', 0, NULL, NULL, 1, 1, 10, 1, '2016-06-30 02:34:11', '2016-06-30 02:44:38'),
(5, 'BULONES 6 MM', 'Unidad', 0, NULL, NULL, 1, 1, 10, 1, '2016-06-30 02:37:49', '2016-06-30 02:50:18');
