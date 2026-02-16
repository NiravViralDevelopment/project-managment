-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 16, 2026 at 01:08 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_man`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  KEY `audit_logs_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'user.created', 'App\\Models\\User', 2, NULL, '{\"id\": 2, \"name\": \"Nadiad Circle\", \"email\": \"nadiyad@gmail.com\", \"zone_id\": \"1\", \"created_at\": \"2026-02-14T09:48:11.000000Z\", \"updated_at\": \"2026-02-14T09:48:11.000000Z\"}', '127.0.0.1', '2026-02-14 04:18:11', '2026-02-14 04:18:11'),
(2, 1, 'user.created', 'App\\Models\\User', 3, NULL, '{\"id\": 3, \"name\": \"Palanpur\", \"email\": \"palanpur@gmail.com\", \"zone_id\": \"1\", \"circle_id\": null, \"created_at\": \"2026-02-15T07:17:18.000000Z\", \"updated_at\": \"2026-02-15T07:17:18.000000Z\", \"division_id\": null, \"substation_id\": null}', '127.0.0.1', '2026-02-15 01:47:18', '2026-02-15 01:47:18'),
(3, 1, 'user.created', 'App\\Models\\User', 4, NULL, '{\"id\": 4, \"name\": \"karamsad\", \"email\": \"karamsad@gmail.com\", \"zone_id\": \"1\", \"circle_id\": \"3\", \"created_at\": \"2026-02-15T07:18:01.000000Z\", \"updated_at\": \"2026-02-15T07:18:01.000000Z\", \"division_id\": \"1\", \"substation_id\": \"1\"}', '127.0.0.1', '2026-02-15 01:48:01', '2026-02-15 01:48:01'),
(4, 1, 'user.created', 'App\\Models\\User', 5, NULL, '{\"id\": 5, \"name\": \"Vimal\", \"email\": \"vimal@gmail.com\", \"zone_id\": null, \"circle_id\": null, \"created_at\": \"2026-02-15T07:19:44.000000Z\", \"updated_at\": \"2026-02-15T07:19:44.000000Z\", \"division_id\": null, \"substation_id\": null}', '127.0.0.1', '2026-02-15 01:49:44', '2026-02-15 01:49:44'),
(5, 1, 'user.updated', 'App\\Models\\User', 5, '{\"id\": 5, \"name\": \"Vimal\", \"email\": \"vimal@gmail.com\", \"zone_id\": null, \"circle_id\": null, \"created_at\": \"2026-02-15T07:19:44.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-02-15T07:19:44.000000Z\", \"division_id\": null, \"substation_id\": null, \"email_verified_at\": null}', '{\"id\": 5, \"name\": \"Vimal\", \"email\": \"vimal@gmail.com\", \"zone_id\": null, \"circle_id\": null, \"created_at\": \"2026-02-15T07:19:44.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-02-15T07:19:44.000000Z\", \"division_id\": null, \"substation_id\": null, \"email_verified_at\": null}', '127.0.0.1', '2026-02-15 01:51:01', '2026-02-15 01:51:01'),
(6, 1, 'user.created', 'App\\Models\\User', 6, NULL, '{\"id\": 6, \"name\": \"Bharuch\", \"email\": \"bharuch@gmail.com\", \"zone_id\": \"2\", \"circle_id\": null, \"created_at\": \"2026-02-15T12:20:04.000000Z\", \"updated_at\": \"2026-02-15T12:20:04.000000Z\", \"division_id\": null, \"substation_id\": null}', '127.0.0.1', '2026-02-15 06:50:04', '2026-02-15 06:50:04'),
(7, 1, 'user.created', 'App\\Models\\User', 7, NULL, '{\"id\": 7, \"name\": \"navsari\", \"email\": \"vapi@gmail.com\", \"zone_id\": \"2\", \"circle_id\": \"5\", \"created_at\": \"2026-02-15T12:25:54.000000Z\", \"updated_at\": \"2026-02-15T12:25:54.000000Z\", \"division_id\": \"2\", \"substation_id\": \"2\"}', '127.0.0.1', '2026-02-15 06:55:54', '2026-02-15 06:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-login_otp:admin@example.com', 's:6:\"995694\";', 1771084305),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:13:{i:0;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:12:\"manage-users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:7;i:1;i:10;i:2;i:11;i:3;i:13;i:4;i:14;}}i:1;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"manage-roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:7;i:1;i:10;i:2;i:11;i:3;i:12;i:4;i:13;i:5;i:14;}}i:2;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"manage-zones\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:7;i:1;i:10;i:2;i:11;i:3;i:12;i:4;i:13;i:5;i:14;}}i:3;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"create-projects\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:7;i:1;i:8;i:2;i:10;i:3;i:11;i:4;i:13;i:5;i:14;}}i:4;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:13:\"edit-projects\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:7;i:1;i:8;i:2;i:10;i:3;i:11;i:4;i:13;i:5;i:14;}}i:5;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:15:\"delete-projects\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:6:{i:0;i:7;i:1;i:10;i:2;i:11;i:3;i:12;i:4;i:13;i:5;i:14;}}i:6;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:19:\"assign-team-members\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:7;i:1;i:8;i:2;i:10;i:3;i:11;i:4;i:12;i:5;i:13;i:6;i:14;}}i:7;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:12:\"manage-tasks\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:7;i:1;i:8;i:2;i:10;i:3;i:11;i:4;i:12;i:5;i:13;i:6;i:14;}}i:8;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"view-projects\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:8:{i:0;i:7;i:1;i:8;i:2;i:9;i:3;i:10;i:4;i:11;i:5;i:12;i:6;i:13;i:7;i:14;}}i:9;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:12:\"update-tasks\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:7;i:1;i:8;i:2;i:9;i:3;i:10;i:4;i:11;i:5;i:13;i:6;i:14;}}i:10;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:14:\"manage-circles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:7;i:1;i:11;i:2;i:12;i:3;i:13;i:4;i:14;}}i:11;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:16:\"manage-divisions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:7;i:1;i:11;i:2;i:13;i:3;i:14;}}i:12;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:18:\"manage-substations\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:7;i:1;i:11;i:2;i:13;i:3;i:14;}}}s:5:\"roles\";a:8:{i:0;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:10;s:1:\"b\";s:4:\"Zone\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:11;s:1:\"b\";s:6:\"Circle\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"Sub Station\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:14;s:1:\"b\";s:9:\"Corporate\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:8:\"Devision\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"Project Manager\";s:1:\"c\";s:3:\"web\";}i:7;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:11:\"Team Member\";s:1:\"c\";s:3:\"web\";}}}', 1771226450);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `circles`
--

DROP TABLE IF EXISTS `circles`;
CREATE TABLE IF NOT EXISTS `circles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `circles_zone_id_foreign` (`zone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `circles`
--

INSERT INTO `circles` (`id`, `name`, `zone_id`, `created_at`, `updated_at`) VALUES
(1, 'HimatNagar Circle', 1, '2026-02-14 22:29:15', '2026-02-14 22:29:15'),
(2, 'Palanpur Circle', 1, '2026-02-14 22:29:33', '2026-02-14 22:29:33'),
(3, 'Nadiad Circle', 1, '2026-02-14 22:29:47', '2026-02-14 22:29:47'),
(4, 'Bharuch', 2, '2026-02-15 06:53:38', '2026-02-15 06:53:38'),
(5, 'navsari', 2, '2026-02-15 06:53:50', '2026-02-15 06:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` bigint UNSIGNED NOT NULL,
  `circle_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `divisions_zone_id_foreign` (`zone_id`),
  KEY `divisions_circle_id_foreign` (`circle_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `zone_id`, `circle_id`, `created_at`, `updated_at`) VALUES
(1, 'Nadiyad Devision', 1, 3, '2026-02-14 22:34:36', '2026-02-14 22:34:36'),
(2, 'navsari', 2, 5, '2026-02-15 06:54:48', '2026-02-15 06:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_otps`
--

DROP TABLE IF EXISTS `login_otps`;
CREATE TABLE IF NOT EXISTS `login_otps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_otps_email_index` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_otps`
--

INSERT INTO `login_otps` (`id`, `email`, `otp`, `expires_at`, `used_at`, `created_at`, `updated_at`) VALUES
(1, 'admin@example.com', '108903', '2026-02-14 11:58:29', NULL, '2026-02-14 11:48:29', '2026-02-14 11:48:29'),
(2, 'admin@example.com', '909623', '2026-02-14 12:00:10', NULL, '2026-02-14 11:50:11', '2026-02-14 11:50:11'),
(3, 'nadiyad@gmail.com', '758841', '2026-02-14 12:02:05', NULL, '2026-02-14 11:52:05', '2026-02-14 11:52:05'),
(4, 'admin@example.com', '562164', '2026-02-14 12:21:51', NULL, '2026-02-14 12:11:51', '2026-02-14 12:11:51'),
(5, 'admin@example.com', '211847', '2026-02-14 22:20:02', NULL, '2026-02-14 22:10:02', '2026-02-14 22:10:02'),
(6, 'vimal@gmail.com', '321221', '2026-02-15 02:00:01', NULL, '2026-02-15 01:50:01', '2026-02-15 01:50:01'),
(7, 'karamsad@gmail.com', '820345', '2026-02-15 02:24:11', NULL, '2026-02-15 02:14:11', '2026-02-15 02:14:11'),
(8, 'palanpur@gmail.com', '411050', '2026-02-15 05:59:49', NULL, '2026-02-15 05:49:49', '2026-02-15 05:49:49'),
(9, 'admin@example.com', '683790', '2026-02-15 06:00:14', NULL, '2026-02-15 05:50:14', '2026-02-15 05:50:14'),
(10, 'karamsad@gmail.com', '837611', '2026-02-15 06:10:24', NULL, '2026-02-15 06:00:24', '2026-02-15 06:00:24'),
(11, 'nadiyad@gmail.com', '856012', '2026-02-15 06:53:13', NULL, '2026-02-15 06:43:13', '2026-02-15 06:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_14_075224_create_personal_access_tokens_table', 1),
(5, '2026_02_14_075238_create_permission_tables', 1),
(6, '2026_02_14_075251_add_soft_deletes_to_users_table', 1),
(7, '2026_02_14_075259_create_project_user_table', 1),
(8, '2026_02_14_075259_create_projects_table', 1),
(9, '2026_02_14_075300_create_tasks_table', 1),
(10, '2026_02_14_075301_create_task_comments_table', 1),
(11, '2026_02_14_075302_create_audit_logs_table', 1),
(13, '2026_02_14_093245_create_zones_table', 2),
(14, '2026_02_14_093454_add_manage_zones_permission', 2),
(15, '2026_02_14_093820_ensure_admin_has_all_permissions', 3),
(16, '2026_02_14_094422_add_zone_id_to_users_table', 4),
(17, '2026_02_14_171722_create_login_otps_table', 5),
(18, '2026_02_15_120000_add_project_progress_modules', 6),
(19, '2026_02_15_035558_create_circles_table', 7),
(20, '2026_02_15_140001_add_manage_circles_permission', 8),
(21, '2026_02_15_140002_add_name_and_zone_id_to_circles_table', 8),
(22, '2026_02_15_150000_create_divisions_table', 9),
(23, '2026_02_15_150001_add_manage_divisions_permission', 9),
(24, '2026_02_15_160000_create_substations_table', 10),
(25, '2026_02_15_160001_add_manage_substations_permission', 10),
(26, '2026_02_15_170000_add_hierarchy_to_users_table', 11),
(27, '2026_02_15_180000_add_substation_and_project_fields_to_projects', 12);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 2),
(10, 'App\\Models\\User', 6),
(11, 'App\\Models\\User', 3),
(13, 'App\\Models\\User', 4),
(13, 'App\\Models\\User', 7),
(14, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(21, 'manage-users', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(22, 'manage-roles', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(23, 'manage-zones', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(24, 'create-projects', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(25, 'edit-projects', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(26, 'delete-projects', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(27, 'assign-team-members', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(28, 'manage-tasks', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(29, 'view-projects', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(30, 'update-tasks', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(31, 'manage-circles', 'web', '2026-02-14 22:27:02', '2026-02-14 22:27:02'),
(32, 'manage-divisions', 'web', '2026-02-14 22:32:49', '2026-02-14 22:32:49'),
(33, 'manage-substations', 'web', '2026-02-14 22:42:27', '2026-02-14 22:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `timeline` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voltage_level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_length_km` decimal(12,2) DEFAULT NULL,
  `approved_cost_cr` decimal(15,2) DEFAULT NULL,
  `scheduled_cod` date DEFAULT NULL,
  `target_cod` date DEFAULT NULL,
  `executing_agency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_period` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overall_status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expenditure_till_date` decimal(15,2) DEFAULT NULL,
  `billing_pending` decimal(15,2) DEFAULT NULL,
  `cost_overrun` decimal(15,2) DEFAULT NULL,
  `financial_health` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary_text` text COLLATE utf8mb4_unicode_ci,
  `expected_foundation_nos` int DEFAULT NULL,
  `expected_erection_nos` int DEFAULT NULL,
  `expected_stringing_km` decimal(12,2) DEFAULT NULL,
  `clearance_expected` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deadline` date DEFAULT NULL,
  `date_of_commissioning` date DEFAULT NULL,
  `scheduled_date_of_completion` date DEFAULT NULL,
  `project_cost` decimal(15,2) DEFAULT NULL,
  `scheme` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_manager_id` bigint UNSIGNED DEFAULT NULL,
  `substation_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_project_manager_id_foreign` (`project_manager_id`),
  KEY `projects_substation_id_foreign` (`substation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `timeline`, `voltage_level`, `line_length_km`, `approved_cost_cr`, `scheduled_cod`, `target_cod`, `executing_agency`, `review_period`, `overall_status`, `expenditure_till_date`, `billing_pending`, `cost_overrun`, `financial_health`, `summary_text`, `expected_foundation_nos`, `expected_erection_nos`, `expected_stringing_km`, `clearance_expected`, `status`, `deadline`, `date_of_commissioning`, `scheduled_date_of_completion`, `project_cost`, `scheme`, `project_manager_id`, `substation_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Georgia Stark', 'Molestiae quia incid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'On Hold', '2017-01-12', NULL, NULL, NULL, NULL, 1, NULL, '2026-02-14 09:46:28', '2026-02-15 06:57:02', '2026-02-15 06:57:02'),
(2, 'Lael Wilkinson', 'Est esse nulla sun', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'On Hold', '2007-03-04', NULL, NULL, NULL, NULL, 2, NULL, '2026-02-14 09:46:47', '2026-02-15 06:56:58', '2026-02-15 06:56:58'),
(3, 'Shelley Woods', 'Omnis quod laborum a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Completed', '1994-06-26', NULL, NULL, NULL, NULL, 2, NULL, '2026-02-14 09:46:55', '2026-02-15 06:56:54', '2026-02-15 06:56:54'),
(4, 'Idona George', 'Incidunt et consect', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', '2024-03-06', NULL, NULL, NULL, NULL, 2, NULL, '2026-02-14 09:47:28', '2026-02-15 06:56:46', '2026-02-15 06:56:46'),
(5, 'Stacey Duran', 'Ut molestiae et qui', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', '2008-02-14', NULL, NULL, NULL, NULL, 2, NULL, '2026-02-14 09:48:35', '2026-02-15 06:56:49', '2026-02-15 06:56:49'),
(6, 'Cullen Mcclain', 'Velit eveniet repud', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', '1980-09-28', NULL, NULL, NULL, NULL, 2, NULL, '2026-02-14 09:48:44', '2026-02-15 06:56:43', '2026-02-15 06:56:43'),
(7, 'Diana Booker', 'Dignissimos dolore i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Completed', '1975-10-24', NULL, NULL, NULL, NULL, 7, 2, '2026-02-14 11:57:30', '2026-02-15 06:56:12', NULL),
(8, 'viral project', 'welcome this project', '2024', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', '2026-02-17', '2026-02-08', '2026-02-15', '4999999999.99', 'asoj 166kv', 4, 1, '2026-02-15 05:52:16', '2026-02-15 05:52:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_bottlenecks`
--

DROP TABLE IF EXISTS `project_bottlenecks`;
CREATE TABLE IF NOT EXISTS `project_bottlenecks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_summary` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_bottlenecks_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_clearances`
--

DROP TABLE IF EXISTS `project_clearances`;
CREATE TABLE IF NOT EXISTS `project_clearances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `clearance_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int NOT NULL DEFAULT '0',
  `obtained` int NOT NULL DEFAULT '0',
  `pending` int NOT NULL DEFAULT '0',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_clearances_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_decisions`
--

DROP TABLE IF EXISTS `project_decisions`;
CREATE TABLE IF NOT EXISTS `project_decisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `decision_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_decisions_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_manpower`
--

DROP TABLE IF EXISTS `project_manpower`;
CREATE TABLE IF NOT EXISTS `project_manpower` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `parameter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_manpower_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_milestones`
--

DROP TABLE IF EXISTS `project_milestones`;
CREATE TABLE IF NOT EXISTS `project_milestones` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `milestone_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `planned_date` date DEFAULT NULL,
  `actual_date` date DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_variance_days` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_milestones_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_physical_progress`
--

DROP TABLE IF EXISTS `project_physical_progress`;
CREATE TABLE IF NOT EXISTS `project_physical_progress` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_scope` decimal(12,2) NOT NULL DEFAULT '0.00',
  `achieved` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `progress_pct` decimal(5,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_physical_progress_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_risks`
--

DROP TABLE IF EXISTS `project_risks`;
CREATE TABLE IF NOT EXISTS `project_risks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `issue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `impact` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsibility` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_plan` text COLLATE utf8mb4_unicode_ci,
  `target_date` date DEFAULT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_risks_project_id_foreign` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

DROP TABLE IF EXISTS `project_user`;
CREATE TABLE IF NOT EXISTS `project_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_user_project_id_user_id_unique` (`project_id`,`user_id`),
  KEY `project_user_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_user`
--

INSERT INTO `project_user` (`id`, `project_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-02-14 09:46:28', '2026-02-14 09:46:28'),
(2, 2, 2, '2026-02-14 09:46:47', '2026-02-14 09:46:47'),
(3, 3, 2, '2026-02-14 09:46:55', '2026-02-14 09:46:55'),
(4, 4, 2, '2026-02-14 09:47:28', '2026-02-14 09:47:28'),
(5, 5, 2, '2026-02-14 09:48:35', '2026-02-14 09:48:35'),
(6, 6, 2, '2026-02-14 09:48:44', '2026-02-14 09:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(7, 'Admin', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(8, 'Project Manager', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(9, 'Team Member', 'web', '2026-02-14 04:12:11', '2026-02-14 04:12:11'),
(10, 'Zone', 'web', '2026-02-14 11:54:45', '2026-02-14 11:54:45'),
(11, 'Circle', 'web', '2026-02-15 00:56:52', '2026-02-15 00:56:52'),
(12, 'Devision', 'web', '2026-02-15 00:57:09', '2026-02-15 00:57:09'),
(13, 'Sub Station', 'web', '2026-02-15 00:57:30', '2026-02-15 00:57:30'),
(14, 'Corporate', 'web', '2026-02-15 01:50:50', '2026-02-15 01:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(14, 5),
(15, 4),
(15, 5),
(16, 4),
(17, 4),
(17, 5),
(18, 4),
(18, 5),
(19, 4),
(19, 5),
(19, 6),
(20, 4),
(20, 5),
(20, 6),
(21, 7),
(21, 10),
(21, 11),
(21, 13),
(21, 14),
(22, 7),
(22, 10),
(22, 11),
(22, 12),
(22, 13),
(22, 14),
(23, 7),
(23, 10),
(23, 11),
(23, 12),
(23, 13),
(23, 14),
(24, 7),
(24, 8),
(24, 10),
(24, 11),
(24, 13),
(24, 14),
(25, 7),
(25, 8),
(25, 10),
(25, 11),
(25, 13),
(25, 14),
(26, 7),
(26, 10),
(26, 11),
(26, 12),
(26, 13),
(26, 14),
(27, 7),
(27, 8),
(27, 10),
(27, 11),
(27, 12),
(27, 13),
(27, 14),
(28, 7),
(28, 8),
(28, 10),
(28, 11),
(28, 12),
(28, 13),
(28, 14),
(29, 7),
(29, 8),
(29, 9),
(29, 10),
(29, 11),
(29, 12),
(29, 13),
(29, 14),
(30, 7),
(30, 8),
(30, 9),
(30, 10),
(30, 11),
(30, 13),
(30, 14),
(31, 7),
(31, 11),
(31, 12),
(31, 13),
(31, 14),
(32, 7),
(32, 11),
(32, 13),
(32, 14),
(33, 7),
(33, 11),
(33, 13),
(33, 14);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jlvT1My4Ht7qrTymhkofMnSCKlEjCyGZVaA2y563', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRGZvZTZVWVJuMmltbzlFYmVxSEVnQ1lyMTZYc3NhT1RoSWJzWnNGUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1771158975),
('F4tyUMgjejIEWKPma2jGtTAJHJwA8PLrCVx5kWIU', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1dRalBuRU5QQkxYTTFzNER0T3BSQ3UzREJUN0FEYUxPT0kzbUdxWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1771158393),
('GtkeiipjYmRfI8FIs37qRPJiq4enqNPTU267kA58', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzV4dG5FNjlRaDNCNExmNzdkclgxMjdDQXRYTUpNUmxYVWxjZHpRTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9qZWN0cyI7czo1OiJyb3V0ZSI7czoxNDoicHJvamVjdHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1771158381);

-- --------------------------------------------------------

--
-- Table structure for table `substations`
--

DROP TABLE IF EXISTS `substations`;
CREATE TABLE IF NOT EXISTS `substations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` bigint UNSIGNED NOT NULL,
  `circle_id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `substations_zone_id_foreign` (`zone_id`),
  KEY `substations_circle_id_foreign` (`circle_id`),
  KEY `substations_division_id_foreign` (`division_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `substations`
--

INSERT INTO `substations` (`id`, `name`, `zone_id`, `circle_id`, `division_id`, `created_at`, `updated_at`) VALUES
(1, 'Karansad', 1, 3, 1, '2026-02-14 22:50:15', '2026-02-14 22:50:15'),
(2, 'vapi', 2, 5, 2, '2026-02-15 06:55:06', '2026-02-15 06:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Todo',
  `priority` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medium',
  `due_date` date DEFAULT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_project_id_foreign` (`project_id`),
  KEY `tasks_assigned_to_foreign` (`assigned_to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

DROP TABLE IF EXISTS `task_comments`;
CREATE TABLE IF NOT EXISTS `task_comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_comments_task_id_foreign` (`task_id`),
  KEY `task_comments_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_id` bigint UNSIGNED DEFAULT NULL,
  `circle_id` bigint UNSIGNED DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `substation_id` bigint UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_zone_id_foreign` (`zone_id`),
  KEY `users_circle_id_foreign` (`circle_id`),
  KEY `users_division_id_foreign` (`division_id`),
  KEY `users_substation_id_foreign` (`substation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `zone_id`, `circle_id`, `division_id`, `substation_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$4H.513uGRckEh1jicbfpsuGLzepZ91f9mUyqa8YPdjBDijURrOkZW', 'pETXM50xSmWpngY77KGOnmUhnmSoEXIuOV2QFG0y1F7q0BvLsaRHCV3FGI9c', '2026-02-14 02:35:39', '2026-02-14 02:35:39', NULL),
(2, 'Nadiad Circle', 'nadiyad@gmail.com', 1, NULL, NULL, NULL, NULL, '$2y$12$vdao3VRZ4IlVhSEkbFhOmuUPOWKd3kfF.MRtGUFCQxWhqKKyJCqJi', '9K3d2Jk4oovwOG5Lb2r6kK5Wq6wcsZRN6ZKwVNWhOvc0lOJcEBd44xPpKAWb', '2026-02-14 04:18:11', '2026-02-14 04:18:11', NULL),
(3, 'Palanpur', 'palanpur@gmail.com', 1, NULL, NULL, NULL, NULL, '$2y$12$XMfFxMTI1LV4B1doW8y63e38YQRu47fMqxE4Ph7Cx31wp/qTLmOZa', NULL, '2026-02-15 01:47:18', '2026-02-15 01:47:18', NULL),
(4, 'karamsad', 'karamsad@gmail.com', 1, 3, 1, 1, NULL, '$2y$12$wG/yzGZev.gtWEZGaKNcaOK2SYbwVKCuii3fMWoAMdp7AH6.Fnq8y', NULL, '2026-02-15 01:48:01', '2026-02-15 01:48:01', NULL),
(5, 'Vimal', 'vimal@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$PXB3Ye/COXXcisfyHW/pJOxSs4Tjgk/R/6khPQbPZCkhHVmHC2/Ja', NULL, '2026-02-15 01:49:44', '2026-02-15 01:49:44', NULL),
(6, 'Bharuch', 'bharuch@gmail.com', 2, NULL, NULL, NULL, NULL, '$2y$12$48VFhLEWxFgnLvnpVe72UeUviWrb/KA6fkCSffn3me3tSiCqqvlCS', NULL, '2026-02-15 06:50:04', '2026-02-15 06:50:04', NULL),
(7, 'navsari', 'vapi@gmail.com', 2, 5, 2, 2, NULL, '$2y$12$Jo5maWw9vRgNbZ1h/LD2vuWqksSWnqD3vx25StTZvpFqEbfjyH59u', NULL, '2026-02-15 06:55:54', '2026-02-15 06:55:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE IF NOT EXISTS `zones` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mehsana Zone', '2026-02-14 04:13:06', '2026-02-14 04:13:06'),
(2, 'Bharuch Zone', '2026-02-14 04:13:20', '2026-02-14 04:13:20'),
(3, 'Rajkot Zone', '2026-02-14 04:13:27', '2026-02-14 04:13:27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
