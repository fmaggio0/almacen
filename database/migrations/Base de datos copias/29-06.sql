-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2016 at 01:11 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `almacen`
--

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id_area`, `descripcion_area`, `created_at`, `updated_at`) VALUES
(1, 'Espacios Verdes', NULL, NULL),
(2, 'Arbolado', NULL, NULL),
(3, 'Taller', NULL, NULL),
(4, 'Administracion', NULL, NULL),
(5, 'Control de Vectores', NULL, NULL),
(6, 'Compras', NULL, NULL);

--
-- Dumping data for table `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `descripcion`, `unidad`, `stock_actual`, `stock_minimo`, `id_rubro`, `id_subrubro`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Bulones 2x2', 'Unidad', 0, NULL, 1, 10, 1, '2016-10-29 10:50:12', '2016-10-29 10:51:22');

--
-- Dumping data for table `ingresos_detalles`
--

INSERT INTO `ingresos_detalles` (`id_detalles`, `id_master`, `id_articulo`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 55, '2016-10-29 10:51:01', '2016-10-29 10:51:01');

--
-- Dumping data for table `ingresos_master`
--

INSERT INTO `ingresos_master` (`id_master`, `tipo_ingreso`, `tipo_comprobante`, `nro_comprobante`, `descripcion`, `estado`, `id_proveedor`, `id_usuario`, `created_at`, `updated_at`) VALUES
(1, 'Ingreso por facturacion', 'Factura', '123111', '', 1, 1, 1, '2016-10-29 10:51:01', '2016-10-29 10:51:01');

--
-- Dumping data for table `migrations`
--

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

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `direccion`, `email`, `telefono`, `observaciones`, `rubros`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Industria Argentina S.R.L', 'Pje Marchena 561 1-3', 'fmaggio0@rosario.gov.ar', '3413731385', '', 'ART. INFORMATICA', 1, '2016-10-29 10:50:47', '2016-10-29 10:50:47');

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'developers', 'developers', 'programadores', NULL, NULL);

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1);

--
-- Dumping data for table `rubros`
--

INSERT INTO `rubros` (`id_rubro`, `descripcion`) VALUES
(1, 'FERROSOS'),
(2, 'ART. LIMPIEZA'),
(3, 'ART. LIBRERIA'),
(4, 'ART. INFORMATICA');

--
-- Dumping data for table `salidas_detalles`
--

INSERT INTO `salidas_detalles` (`id_detalles`, `id_master`, `id_articulo`, `id_empleado`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 55691, 55, '2016-10-29 10:51:22', '2016-10-29 10:51:22');

--
-- Dumping data for table `salidas_master`
--

INSERT INTO `salidas_master` (`id_master`, `tipo_retiro`, `estado`, `id_subarea`, `id_usuario`, `created_at`, `updated_at`) VALUES
(1, 'Salida de recursos', 0, 7, 1, '2016-10-29 10:51:22', '2016-10-29 10:51:22');

--
-- Dumping data for table `subareas`
--

INSERT INTO `subareas` (`id_subarea`, `id_area`, `descripcion_subarea`, `created_at`, `updated_at`) VALUES
(5, 1, 'Parque España Arriba', NULL, NULL),
(6, 1, 'Patio de la Madera', NULL, NULL),
(7, 1, 'Monumento', NULL, NULL),
(8, 1, 'Cuadrilla de arbolado', NULL, NULL),
(9, 3, 'Taller Herreria', NULL, NULL),
(10, 3, 'Taller Mecanica', NULL, NULL);

--
-- Dumping data for table `subrubros`
--

INSERT INTO `subrubros` (`id_subrubro`, `id_rubro`, `descripcion`) VALUES
(10, 1, 'BULONES'),
(11, 1, 'CAÑOS DE ALUMINIO'),
(12, 1, 'TORNILLOS'),
(13, 2, 'LIQUIDOS');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `id_empleado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'fmaggio0', 'fmaggio0@rosario.gov.ar', '$2y$10$.TRHC/35jTLiAyUs2oRTqO4Ny6N5x51uF/jBWytpy/a2KEV7nKLVW', 55691, 'jSgKa5LArkpsfO3xivGnHAYvBFhM267pan2taZPQOPZpyBvUnSabbSOW10nl', '2016-06-30 04:21:10', '2016-06-30 04:22:05');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
