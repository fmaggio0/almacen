INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_06_02_151120_crear_rubros_tabla', 1),
('2016_06_02_151901_crear_subrubros_tabla', 1),
('2016_06_10_110447_crear_articulos_tabla', 1),
('2016_06_24_194906_crear_areas_tabla', 1),
('2016_06_24_195323_crear_subareas_tabla', 1),
('2016_06_25_230349_crear_salidamaster_tabla', 1),
('2016_06_25_230723_crear_salidadetalles_tabla', 1),
('2016_06_30_192756_crear_autorizacionesmaster_tabla', 1),
('2016_06_30_192808_crear_autorizacionesdetalles_tabla', 1),
('2016_07_09_113641_entrust_setup_tables', 1),
('2016_10_14_123535_crear_proveedores_tabla', 1),
('2016_10_21_073412_crear_ingresomaster_tabla', 1),
('2016_10_21_073432_crear_ingresodetalles_tabla', 1);

INSERT INTO `users` (`id`, `name`, `email`, `password`, `id_empleado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'fmaggio0', 'fmaggio0@rosario.gov.ar', '$2y$10$.TRHC/35jTLiAyUs2oRTqO4Ny6N5x51uF/jBWytpy/a2KEV7nKLVW', 55691, 'jSgKa5LArkpsfO3xivGnHAYvBFhM267pan2taZPQOPZpyBvUnSabbSOW10nl', '2016-06-30 04:21:10', '2016-06-30 04:22:05');

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'developers', 'developers', 'programadores', NULL, NULL);

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1);

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

INSERT INTO `areas` (`id_area`, `descripcion_area`) VALUES
(1, 'Espacios Verdes'),
(2, 'Arbolado'),
(3, 'Taller'),
(4, 'Administracion'),
(5, 'Control de Vectores'),
(6, 'Compras');

INSERT INTO `subareas` (`id_subarea`, `id_area`, `descripcion_subarea`) VALUES
(5, 1, 'Parque España Arriba'),
(6, 1, 'Patio de la Madera'),
(7, 1, 'Monumento'),
(8, 1, 'Cuadrilla de arbolado'),
(9, 3, 'Taller Herreria'),
(10, 3, 'Taller Mecanica');

INSERT INTO `articulos` (`id_articulo`, `descripcion`, `unidad`, `stock_actual`, `stock_minimo`, `id_rubro`, `id_subrubro`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Bulones 2x2', 'Unidad', 0, NULL, 1, 10, 1, '2016-10-29 10:50:12', '2016-10-29 10:51:22');

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `direccion`, `email`, `telefono`, `observaciones`, `rubros`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Industria Argentina S.R.L', 'Pje Marchena 561 1-3', 'fmaggio0@rosario.gov.ar', '3413731385', '', 'ART. INFORMATICA', 1, '2016-10-29 10:50:47', '2016-10-29 10:50:47');
