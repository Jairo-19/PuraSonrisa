-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2026 a las 11:46:16
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
-- Base de datos: `purasonrisadb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `empleado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `servicio_id` bigint(20) UNSIGNED NOT NULL,
  `consulta_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` enum('confirmada','completada') NOT NULL DEFAULT 'confirmada',
  `motivo` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `paciente_id`, `empleado_id`, `servicio_id`, `consulta_id`, `fecha`, `hora_inicio`, `hora_fin`, `estado`, `motivo`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 4, NULL, '2026-05-11', '08:00:00', '09:00:00', 'completada', 'Vel sed voluptatem nesciunt.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(2, 3, 2, 4, NULL, '2026-07-12', '12:00:00', '13:00:00', 'confirmada', 'Porro facere a perspiciatis.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(3, 3, 2, 4, NULL, '2026-04-28', '13:00:00', '14:00:00', 'completada', 'Necessitatibus fuga blanditiis ipsum eveniet nobis.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(4, 4, 1, 3, NULL, '2026-06-17', '11:00:00', '12:00:00', 'confirmada', 'Maiores omnis perferendis iste consequatur quis consequatur.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(5, 5, 2, 3, NULL, '2026-07-10', '11:00:00', '12:00:00', 'completada', 'Quisquam reiciendis consequatur quidem laborum mollitia.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(6, 6, 1, 4, NULL, '2026-06-30', '11:00:00', '12:00:00', 'confirmada', NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(7, 6, 1, 4, NULL, '2026-05-08', '11:00:00', '12:00:00', 'confirmada', NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(8, 7, 2, 3, NULL, '2026-05-27', '11:00:00', '12:00:00', 'completada', 'Voluptas quod voluptate totam unde ullam libero alias.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(9, 7, 2, 3, NULL, '2026-05-15', '16:00:00', '17:00:00', 'confirmada', 'Sequi sunt cum ut et.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(10, 7, 2, 3, NULL, '2026-07-08', '09:00:00', '10:00:00', 'confirmada', 'Voluptas minus doloremque similique corrupti.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(11, 8, NULL, 1, 1, '2026-05-13', '12:00:00', '12:45:00', 'confirmada', NULL, '2026-04-27 08:11:18', '2026-04-27 08:11:18'),
(13, 8, NULL, 1, 1, '2026-05-21', '12:00:00', '12:45:00', 'confirmada', NULL, '2026-04-27 09:31:50', '2026-04-27 09:31:50'),
(14, 8, NULL, 2, 1, '2026-04-28', '09:00:00', '10:00:00', 'confirmada', NULL, '2026-04-27 14:04:22', '2026-04-27 14:04:22'),
(15, 11, NULL, 2, 2, '2026-04-28', '09:00:00', '10:00:00', 'confirmada', NULL, '2026-04-27 14:07:15', '2026-04-27 14:07:15'),
(16, 8, 1, 3, 3, '2026-04-28', '09:00:00', '10:30:00', 'confirmada', NULL, '2026-04-27 14:21:19', '2026-04-27 14:21:19'),
(17, 11, 10, 3, 1, '2026-04-28', '10:30:00', '12:00:00', 'confirmada', NULL, '2026-04-27 14:22:23', '2026-04-27 14:22:23'),
(18, 8, 1, 4, 2, '2026-04-28', '11:00:00', '13:00:00', 'confirmada', NULL, '2026-04-28 06:49:39', '2026-04-28 06:49:39'),
(19, 8, 1, 1, 1, '2026-04-29', '09:00:00', '09:45:00', 'confirmada', NULL, '2026-04-28 08:16:54', '2026-04-28 08:16:54'),
(20, 8, 1, 5, 1, '2026-05-07', '16:45:00', '17:30:00', 'confirmada', NULL, '2026-05-04 07:57:24', '2026-05-04 07:57:24'),
(21, 8, 2, 1, 1, '2026-05-08', '09:00:00', '09:45:00', 'confirmada', NULL, '2026-05-06 05:54:52', '2026-05-06 05:54:52'),
(22, 8, 1, 5, 2, '2026-05-21', '12:00:00', '12:45:00', 'confirmada', NULL, '2026-05-06 06:08:01', '2026-05-06 06:08:01'),
(23, 8, 1, 5, 1, '2026-05-12', '09:45:00', '10:30:00', 'confirmada', NULL, '2026-05-06 06:22:35', '2026-05-06 06:22:35'),
(24, 8, 2, 3, 1, '2026-05-07', '09:00:00', '10:30:00', 'confirmada', NULL, '2026-05-06 06:25:35', '2026-05-06 06:25:35'),
(25, 22, 1, 1, 1, '2026-05-11', '09:00:00', '09:45:00', 'confirmada', NULL, '2026-05-08 06:15:09', '2026-05-08 06:15:09'),
(26, 22, 1, 5, 1, '2026-05-15', '08:00:00', '08:45:00', 'confirmada', 'me duele la boca', '2026-05-08 06:33:55', '2026-05-08 06:33:55'),
(27, 22, 10, 8, 1, '2026-05-08', '08:00:00', '08:30:00', 'confirmada', NULL, '2026-05-08 07:44:02', '2026-05-08 07:44:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `nombre`, `color`, `activa`, `created_at`, `updated_at`) VALUES
(1, 'Consulta Rosa', '#cc0247', 1, '2026-04-27 12:35:58', '2026-04-27 12:35:58'),
(2, 'Consulta Azul', '#08beff', 1, '2026-04-27 12:35:58', '2026-04-27 12:35:58'),
(3, 'Consulta Amarilla', '#f59e0b', 1, '2026-04-27 12:35:58', '2026-04-27 12:35:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clinico`
--

CREATE TABLE `historial_clinico` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paciente_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historial_clinico`
--

INSERT INTO `historial_clinico` (`id`, `paciente_id`, `descripcion`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 3, 'Dolorem laboriosam eligendi ut eaque impedit. Corporis quas nulla ullam aut voluptatem sequi perferendis. Architecto dolorum ab sint dicta nisi culpa aut placeat.', '2025-08-05', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(2, 4, 'Est consectetur dolorem molestiae qui atque tempora ab. Ex fugit expedita dolores a rerum illo. Velit placeat labore voluptatem id ut dicta ipsa ut. Sit pariatur et suscipit maiores laudantium. Ipsam cumque quo odio magni non.', '2025-06-29', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(3, 4, 'Et voluptas laborum nam est velit. In est et quia quia a. Recusandae ea qui voluptates eum.', '2024-11-02', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(4, 5, 'Optio voluptas velit incidunt culpa natus. Et sequi earum quia vel assumenda et eius. Aut voluptatem explicabo enim aliquam amet et laborum. Sequi saepe sunt illo consequatur.', '2025-09-17', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(5, 6, 'Consequatur non incidunt assumenda. Vitae nihil repudiandae hic nemo nisi. Omnis qui corporis doloribus quas.', '2025-04-30', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(6, 6, 'Qui veniam repudiandae officia totam. Aut dolor fuga ullam voluptatem vitae. Error aspernatur veniam vero unde eos dolorum assumenda. A et facilis repellat eos alias.', '2025-02-07', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(7, 7, 'Et et voluptate dicta voluptate aut. Exercitationem quo illum ab rerum. Voluptas a voluptatem numquam nihil deserunt.', '2024-08-13', '2026-04-23 13:10:47', '2026-04-23 13:10:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_clinicas`
--

CREATE TABLE `imagenes_clinicas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `historial_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `tipo` enum('radiografia','foto','otro') NOT NULL DEFAULT 'foto',
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagenes_clinicas`
--

INSERT INTO `imagenes_clinicas` (`id`, `historial_id`, `nombre`, `ruta`, `tipo`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, '4bcfcacf-2e95-394d-99ff-655626e1e336.webp', 'imagenes/clinicas/4bcfcacf-2e95-394d-99ff-655626e1e336.webp', 'foto', NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(2, 3, 'd163eef0-009d-3c90-ada6-c912780e3e57.jpg', 'imagenes/clinicas/d163eef0-009d-3c90-ada6-c912780e3e57.jpg', 'foto', 'Mollitia qui optio ut nemo.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(3, 6, '675730ac-e166-3dca-9ec7-a969331f815d.jpg', 'imagenes/clinicas/675730ac-e166-3dca-9ec7-a969331f815d.jpg', 'radiografia', NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(4, 7, 'd2dddfbd-4692-3e08-8cc3-9054673d9097.webp', 'imagenes/clinicas/d2dddfbd-4692-3e08-8cc3-9054673d9097.webp', 'otro', 'Modi voluptatibus voluptas veritatis quas aperiam occaecati.', '2026-04-23 13:10:47', '2026-04-23 13:10:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_04_21_000001_create_usuarios_table', 1),
(2, '2026_04_21_000002_create_servicios_table', 1),
(3, '2026_04_21_000003_create_citas_table', 1),
(4, '2026_04_21_000004_create_historial_clinico_table', 1),
(5, '2026_04_21_000005_create_imagenes_clinicas_table', 1),
(6, '2026_04_23_135418_create_sessions_table', 1),
(7, '2026_04_24_000001_add_remember_token_to_usuarios_table', 2),
(8, '2026_04_27_000001_create_consultas_table', 3),
(9, '2026_04_27_000002_add_consulta_id_to_citas_table', 3),
(10, '2026_04_28_000001_remove_pendiente_from_citas_estado', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(8,2) NOT NULL,
  `duracion_minutos` smallint(5) UNSIGNED NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `precio`, `duracion_minutos`, `activo`, `created_at`, `updated_at`, `imagen`) VALUES
(1, 'Limpieza Dental', 'El servicio de limpieza dental es un procedimiento preventivo que consiste en la eliminación de placa bacteriana, sarro y manchas de los dientes. Este proceso ayuda a mantener una buena salud bucal, prevenir enfermedades periodontales y mejorar la apariencia de los dientes.', 50.00, 45, 1, '2026-04-23 13:10:45', '2026-04-29 09:20:45', '69f1e98dc964c.jpg'),
(2, 'Blanqueamiento Dental', 'El blanqueamiento dental es un procedimiento estético que tiene como objetivo aclarar el color de los dientes. Este tratamiento puede realizarse en la clínica dental o en casa, utilizando productos específicos que contienen agentes blanqueadores para eliminar manchas y decoloraciones, logrando una sonrisa más brillante y atractiva.', 150.00, 60, 1, '2026-04-23 13:10:45', '2026-04-29 09:18:29', '69f1e90544f97.webp'),
(3, 'Ortodoncia', 'La ortodoncia es una especialidad de la odontología que se encarga de corregir la posición de los dientes y las mandíbulas para mejorar la función masticatoria y la estética facial. Este tratamiento puede incluir el uso de brackets, alineadores transparentes u otros dispositivos para alinear los dientes y lograr una sonrisa armoniosa.', 2000.00, 90, 1, '2026-04-23 13:10:45', '2026-05-08 07:22:14', '69f1e9bd990af.jpg'),
(4, 'Implantes Dentales', 'Los implantes dentales son una solución permanente para reemplazar dientes perdidos. Consisten en un tornillo de titanio que se inserta en el hueso maxilar o mandibular, sobre el cual se coloca una corona dental para restaurar la función y estética de la sonrisa. Este procedimiento ofrece una alta tasa de éxito y mejora la calidad de vida del paciente.', 2500.00, 120, 1, '2026-04-23 13:10:45', '2026-04-29 09:19:39', '69f1e94b4f9ed.jpg'),
(5, 'Bruxismo', 'El tratamiento del bruxismo se enfoca en reducir el rechinamiento y apretamiento dental, proteger las piezas dentales y aliviar molestias musculares o articulares. Habitualmente incluye el uso de férulas de descarga personalizadas, control del estrés, corrección de hábitos perjudiciales y seguimiento odontológico.', 250.00, 45, 1, '2026-04-29 08:48:19', '2026-04-29 08:48:19', '69f1e1f3328a2.jpg'),
(7, 'Revisión Dental', 'Evaluación completa del estado bucodental, detección de caries, revisión de encías, diagnóstico preventivo y asesoramiento personalizado sobre higiene oral. Incluye exploración visual y valoración general por un odontólogo.', 40.00, 30, 1, '2026-05-08 07:41:00', '2026-05-08 07:41:00', 'revision-dental-1-e1436794502310_1778233260.jpg'),
(8, 'Revisión de Ortodoncia', 'Control y seguimiento del tratamiento ortodóntico para evaluar la evolución de la alineación dental, ajuste de brackets o alineadores y revisión del estado general de la mordida y encías.', 0.00, 30, 0, '2026-05-08 07:43:23', '2026-05-08 07:43:23', 'descarga_1778233403.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0Wj5DCpLijr84jQvuiH8fLEDT4SwxGLK9QP1JHeC', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnVsbVBhbDFHVExHT2VrT2dVMVZ1WDJYdTVQVElGcTZUdG1Bb2xVViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hZG1pbi9hZ2VuZGE/ZmVjaGE9MjAyNi0wNS0wOCI7czo1OiJyb3V0ZSI7czoxMjoiYWRtaW4uYWdlbmRhIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1778233442),
('7EkGe49R7sUnYZY9TNwDjQDRNGz08UKSjacJFvZQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaExLaUY0TmNFRFhWb1piVFJKZzVYVTBJQ1ZHcXZyVUl5dHh2bXVvMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778170094),
('7J8SqHK62lvi3TEPw6VzR3NTQtvvxrckdyzAzZ5a', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXRRMDJuS0tPTUpBNjFKbld4WjFTSklRdFdMSDJDZ2dMd0NZNFV6WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778228129),
('bYd7o2BsFdTCBKVNhwoD09AOauWLIbzdoC0UsmpI', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkpZVUNneDlhM0t0VU5RbW00UnRLVjR2TTdrSHYxT1RXQXJSUmhsQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778228764),
('dwKrHMaTVU7nWmQdGsq0lcrq23K9ZgYCMN3EAXrC', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzNNUXNiclNrZThrQjc4NFIwMVhMVVl1S0tpWlVWRW9rR3N1NGRkZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778228613),
('G2AYWsWbhM9ZodCKLhpJheZi3oAruPbzeBqqiZPV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-ES) WindowsPowerShell/5.1.26100.8115', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicDhIb055c1RRaUVudk5nQWVQZFIwSDhRa2xocDh4UDI5a2p4ak9SOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778228287),
('HSSqmhyZI4c5REj9PoVXNSvOWRzYZTWdz4n6Li3y', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVN6TWg4MFA4WGlKQksxRGp1N2lyT1VnRjhBYjJLTTJ6djBSTlp1SCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778229743),
('IQAvAFdM3ZfUVEuRgLrJb7cIL0qV0r71GEmR91vI', NULL, '127.0.0.1', 'PostmanRuntime/7.54.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibzNwanhRRmpWUlVUSDVhMEx3amYwMnYydVhSdnBQNk1mSUpMZDhuTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9wdWJsaWMvYXBpL2NpdGFzL21hbmFuYSI7czo1OiJyb3V0ZSI7czoxNjoiYXBpLmNpdGFzLm1hbmFuYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778170567),
('JMSyXlxzb12XMrw4wRLLIkEp7tS52OBOkXLCR6N0', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnZaTWJVVFk2RExsUWZqT2dMOVdPcGx0TThaVUhRRFN1MllQRG8weSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778229641),
('KpdL71dPQGy8CgIZqnaGvaabVdRi2JCNspMIYZ0n', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVQ4ZWJBZW5XMXVYQTlxeHFjVWtDM1RZeGpNUWp0b2llRmtvRnIzWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778229244),
('MJ8WrGIB6PTuWh43zVxinw8jYd8qtE8utzTryGot', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1BXazNPUFBRN2tTTHlvS1JWWnhLbVBmZFVidjhORndyRkNFVTE0YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778229534),
('MUgI0lDWkpX6JQimSTlun6vvqfrHlJngNk6lgzHi', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQkpOYkxhejBMaHdCdVFFWFFRUExyTE9haTVLQlZJcFNmV3E5Z1F6RyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778229525),
('PV4OBqH6htVeM7cgmsoRHO6NLTJwmCkBR03FCMnn', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0hYdUVtZ0p3N1VHeVNBeGx1QTk3N0xUTVh0cUVGMGhvMndkd3RUVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778225598),
('SlIoXaeUaJlqWXgTEJrdXAJAsDWgjqGwR3x9CNhX', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOEtVRVIzbXR0S0gxN20yV1gxTm53R0xCN3VxVEFEdU16cUZYdmR6RiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778227674),
('tlvwBjgsihHlaAI6fTxTr9h4rjM8BzpH863Il99L', NULL, '127.0.0.1', 'n8n', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTdqaDZuaUxiRlhSbHZObHNFb0gzSWY5OWZXUVF6Sm81Z3RwWEpsWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778229376),
('uoED00mGGqOrkM4xobXEI73H1BDjmmYnQAZgZ58B', NULL, '127.0.0.1', 'Wget', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlZXbktaQVFYMGlaS0xWeXJ5VnhoV3pwV1NiRmVIQkFzRWlaSm93diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778225509),
('vKNOaxqmDKLjioOnpAYrASObmGELtJaGI05bCtee', NULL, '127.0.0.1', 'PostmanRuntime/7.54.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHFQSk9YSTF2d2NDSGFHYm1NcWEzNktOUW1hRFZ3dW9hMktFR3kxWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9hcGkvY2l0YXMvbWFuYW5hIjtzOjU6InJvdXRlIjtzOjE2OiJhcGkuY2l0YXMubWFuYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778228934),
('ZiRwxQLSZNFSH4sOeC0ZqHOi7cwfNRvMPPiMFIsU', 22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibVhORTNCTVFuemVFdWxDU0Q1eHRrT0o0a0NnMk9ybjdQbUNZZ1BzMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9wdXJhc29ucmlzYS5leGFtcGxlLmNvbS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIyO30=', 1778151117);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `rol` enum('empleado','cliente') NOT NULL DEFAULT 'cliente',
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `condiciones_medicas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `remember_token`, `rol`, `telefono`, `fecha_nacimiento`, `dni`, `alergias`, `condiciones_medicas`, `created_at`, `updated_at`) VALUES
(1, 'Ms. Imogene Boyle', 'brady34@example.net', '$2y$12$B5Y1B3JKRI96/z2K50/k0.DBxxVdpZ3D5YasP4sJBmC6/d6/WoyD2', NULL, 'empleado', '650265040', '2007-04-27', '62241989h', 'Officia ut occaecati a sunt cupiditate.', 'Vel illum dolores dicta sunt.', '2026-04-23 13:10:45', '2026-04-23 13:10:45'),
(2, 'Cara Corkery', 'jerrold.littel@example.org', '$2y$12$djrWew1HVDMxOO4JK7Cpdu40.4O.WoFX7ErdRa1PKw.T62zxCf0Eq', NULL, 'empleado', '658429937', '2005-11-04', '83644203e', NULL, NULL, '2026-04-23 13:10:46', '2026-04-23 13:10:46'),
(3, 'Ernie Crona', 'weston54@example.net', '$2y$12$Ja7x5bnFFOTd9Re4ic1C/eSQzhPqcHYS.kcDEoorHZzIq1TyBTH46', NULL, 'cliente', '604581557', '1978-07-20', '57207691k', NULL, 'Nihil cum asperiores aut.', '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(4, 'Caroline Vandervort', 'kiehn.darrin@example.net', '$2y$12$0kicqzJPqlF7A59mBNcWFOrsrjjY1Zr9TKVc7009jqLTr.pCe6.ru', NULL, 'cliente', '687340019', '2002-04-05', '46206205n', NULL, NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(5, 'Ora Corkery', 'lexus00@example.net', '$2y$12$CZ70mwSvC6W9DvrdWrcDjOjrfj20vYHNdgDtI/m7XFUJVAELWZuYG', NULL, 'cliente', '616976390', '2006-10-31', '03420396d', NULL, NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(6, 'Tara Gerhold II', 'qokon@example.org', '$2y$12$CenZlymbYxpT2S8KKiEuO.6dRd/JTk8B.vRnhlfIB8VMNntGGwQjy', NULL, 'cliente', '649872150', '1970-02-09', '26042855k', 'Temporibus id voluptatem rerum quo voluptatem aut.', NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(7, 'Willa Bogan', 'carey91@example.net', '$2y$12$kqUSbAarl2Gwv2ab9Kkj0.34Cpbg1oEfGhG1s1wn2UGeQewcN4Ika', NULL, 'cliente', '630533592', '1973-06-15', '84199012x', NULL, NULL, '2026-04-23 13:10:47', '2026-04-23 13:10:47'),
(8, 'Pepe', 'pepe@gmail.com', '$2y$12$Nt4ZXawvei8t8Km7EDTRAupAlQ18W7iH0Kym8rmqoTrRqegOGDFPS', 'rt8ohZFSFC4bb63nQ4pHcjY0jl4w6Tlssbd3snM8PRwNAT8qRw9Q38vI2yXl', 'cliente', '+34612345678', '2012-07-20', '54565452Y', 'no tengo alergias', 'ninguna', '2026-04-24 06:45:12', '2026-04-24 06:45:12'),
(9, 'Juanito', 'juanito@gmail.com', '$2y$12$cS/6qKZ8rR6ytAJqTmsWke2E0k4.1ILOyJBQPus070SP7rY2Psjha', NULL, 'cliente', '+34689010120', '2000-01-11', '20205050T', NULL, NULL, '2026-04-24 07:06:45', '2026-04-24 07:06:45'),
(10, 'admin', 'admin@gmail.com', '$2y$12$Xhz95KxsU0vE/QcltRX9kus0DVldMR07FCk.C4DFZYEv2CPVN8fEq', NULL, 'empleado', '+34689789678', '2006-10-19', '12345678A', NULL, NULL, '2026-04-24 07:36:02', '2026-04-24 08:28:53'),
(11, 'Juana', 'juana@gmail.com', '$2y$12$CxrH3DG3dDFaPsCZ1qoE0O.ehBie6qAXZsQURtqhA3C5cahNwQ5ai', NULL, 'cliente', '+34654789789', '2026-04-03', '74856576T', NULL, NULL, '2026-04-27 14:06:44', '2026-04-27 14:06:44'),
(22, 'Pedrito', 'pedrito@gmail.com', '$2y$12$hW8HFNCM1Da8gltnqTHNXOvH3riVhQYnjdgZYFnRQp8A0hNvjeRcS', NULL, 'cliente', '+34612345678', '2026-04-27', '12345678Z', NULL, NULL, '2026-05-07 08:22:09', '2026-05-07 08:22:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citas_paciente_id_foreign` (`paciente_id`),
  ADD KEY `citas_empleado_id_foreign` (`empleado_id`),
  ADD KEY `citas_servicio_id_foreign` (`servicio_id`),
  ADD KEY `citas_consulta_id_foreign` (`consulta_id`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_clinico_paciente_id_foreign` (`paciente_id`);

--
-- Indices de la tabla `imagenes_clinicas`
--
ALTER TABLE `imagenes_clinicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagenes_clinicas_historial_id_foreign` (`historial_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `imagenes_clinicas`
--
ALTER TABLE `imagenes_clinicas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_consulta_id_foreign` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `citas_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD CONSTRAINT `historial_clinico_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imagenes_clinicas`
--
ALTER TABLE `imagenes_clinicas`
  ADD CONSTRAINT `imagenes_clinicas_historial_id_foreign` FOREIGN KEY (`historial_id`) REFERENCES `historial_clinico` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
