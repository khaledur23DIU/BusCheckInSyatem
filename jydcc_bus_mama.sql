-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2021 at 11:31 AM
-- Server version: 10.2.34-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jydcc_bus_mama`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_checkers`
--

CREATE TABLE `assign_checkers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checker_id` bigint(20) UNSIGNED NOT NULL,
  `bus_stop_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_checkers`
--

INSERT INTO `assign_checkers` (`id`, `checker_id`, `bus_stop_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, '2020-12-29 20:52:20', '2020-12-29 20:52:20', NULL),
(2, 4, 2, '2020-12-29 20:55:26', '2020-12-29 20:55:26', NULL),
(3, 3, 2, '2020-12-29 20:55:41', '2020-12-29 20:55:41', NULL),
(4, 5, 3, '2020-12-29 20:55:56', '2020-12-29 20:55:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bus_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_no`, `is_running`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123456G', 1, '2020-12-29 20:26:19', '2020-12-29 20:26:19', NULL),
(2, '77755V', 1, '2020-12-29 20:26:34', '2020-12-29 20:26:34', NULL),
(3, 'DHA-009', 1, '2021-01-04 18:10:56', '2021-01-04 18:10:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buses_in_routes`
--

CREATE TABLE `buses_in_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bus_id` bigint(20) UNSIGNED NOT NULL,
  `bus_route_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buses_in_routes`
--

INSERT INTO `buses_in_routes` (`id`, `bus_id`, `bus_route_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2020-12-29 20:28:50', '2020-12-29 20:28:50', NULL),
(2, 2, 1, '2020-12-29 20:29:01', '2020-12-29 20:29:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bus_routes`
--

CREATE TABLE `bus_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departure_starting_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_ending_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_starting_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_ending_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_routes`
--

INSERT INTO `bus_routes` (`id`, `departure_starting_place`, `departure_ending_place`, `return_starting_place`, `return_ending_place`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gabtoli', 'Dhanmondi 32', 'Dhanmondi 32', 'Gabtoli', 1, '2020-12-29 20:27:48', '2020-12-29 20:27:48', NULL),
(2, 'Firmgate', 'Uttara', 'Uttara', 'Firmgate', 1, '2020-12-29 20:28:21', '2020-12-29 20:28:21', NULL),
(3, 'Gabtoli', 'Jatrabari', 'Jatrabari', 'Gabtoli', 1, '2021-01-04 18:11:53', '2021-01-04 18:11:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops`
--

CREATE TABLE `bus_stops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serialize_id` int(11) DEFAULT NULL,
  `bus_route_id` bigint(20) UNSIGNED NOT NULL,
  `bus_stop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_route_type` int(11) NOT NULL,
  `bus_route_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus_stops`
--

INSERT INTO `bus_stops` (`id`, `serialize_id`, `bus_route_id`, `bus_stop`, `bus_route_type`, `bus_route_type_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 1, 'Gabtoli', 1, 'departure', '2020-12-29 20:29:34', '2020-12-29 20:29:34', NULL),
(2, NULL, 1, 'Shyamoli', 1, 'departure', '2020-12-29 20:29:59', '2020-12-29 20:29:59', NULL),
(3, NULL, 1, 'Asadgate', 1, 'departure', '2020-12-29 20:30:23', '2020-12-29 20:30:23', NULL),
(4, NULL, 1, 'Dhanmondi 32', 1, 'departure', '2020-12-29 20:30:54', '2020-12-29 20:30:54', NULL),
(5, NULL, 1, 'Dhanmondi 32', 2, 'return', '2020-12-29 20:31:16', '2020-12-29 20:31:16', NULL),
(6, NULL, 1, 'Asadgate', 2, 'return', '2020-12-29 20:31:34', '2020-12-29 20:31:34', NULL),
(7, NULL, 1, 'Kallanpur', 2, 'return', '2020-12-29 20:31:58', '2020-12-29 20:31:58', NULL),
(8, NULL, 1, 'Gabtoli', 2, 'return', '2020-12-29 20:32:12', '2020-12-29 20:32:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `check_ins`
--

CREATE TABLE `check_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checker_id` bigint(20) UNSIGNED NOT NULL,
  `bus_id` bigint(20) UNSIGNED NOT NULL,
  `bus_stop_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `check_ins`
--

INSERT INTO `check_ins` (`id`, `checker_id`, `bus_id`, `bus_stop_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 1, '2020-12-29 21:08:45', '2020-12-29 21:08:45', NULL),
(2, 3, 1, 2, '2020-12-29 21:10:28', '2020-12-29 21:10:28', NULL),
(3, 2, 2, 1, '2021-01-04 18:06:34', '2021-01-04 18:06:34', NULL),
(4, 3, 2, 2, '2021-01-04 18:08:58', '2021-01-04 18:08:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `check_in_incomes`
--

CREATE TABLE `check_in_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checkInPass_id` bigint(20) UNSIGNED NOT NULL,
  `income` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `check_in_incomes`
--

INSERT INTO `check_in_incomes` (`id`, `checkInPass_id`, `income`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, '2020-12-29 21:08:45', '2020-12-29 21:08:45', NULL),
(2, 2, 783, '2020-12-29 21:10:28', '2020-12-29 21:10:28', NULL),
(3, 3, 0, '2021-01-04 18:06:34', '2021-01-04 18:06:34', NULL),
(4, 4, 418, '2021-01-04 18:08:58', '2021-01-04 18:08:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `check_in_passengers`
--

CREATE TABLE `check_in_passengers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checkIn_id` bigint(20) UNSIGNED NOT NULL,
  `student` int(11) NOT NULL DEFAULT 0,
  `staff` int(11) NOT NULL DEFAULT 0,
  `physically_disabled` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `check_in_passengers`
--

INSERT INTO `check_in_passengers` (`id`, `checkIn_id`, `student`, `staff`, `physically_disabled`, `total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 5, 0, 2, 25, '2020-12-29 21:08:45', '2020-12-29 21:08:45', NULL),
(2, 2, 3, 0, 1, 33, '2020-12-29 21:10:28', '2020-12-29 21:10:28', NULL),
(3, 3, 2, 3, 1, 20, '2021-01-04 18:06:34', '2021-01-04 18:06:34', NULL),
(4, 4, 5, 6, 6, 24, '2021-01-04 18:08:58', '2021-01-04 18:08:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `checker_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complain` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complains`
--

INSERT INTO `complains` (`id`, `checker_id`, `title`, `complain`, `is_seen`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Complain test', 'Complain test', 1, '2021-01-04 18:19:22', '2021-01-04 18:20:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_incomes`
--

CREATE TABLE `daily_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dailyIncome` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_incomes`
--

INSERT INTO `daily_incomes` (`id`, `dailyIncome`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 783, '2020-12-29 16:20:12', '2020-12-29 16:20:12', NULL),
(2, 0, '2020-12-30 07:00:08', '2020-12-30 07:00:08', NULL),
(3, 0, '2020-12-31 07:00:04', '2020-12-31 07:00:04', NULL),
(4, 0, '2021-01-01 07:00:04', '2021-01-01 07:00:04', NULL),
(5, 0, '2021-01-02 07:00:04', '2021-01-02 07:00:04', NULL),
(6, 0, '2021-01-03 07:00:04', '2021-01-03 07:00:04', NULL),
(7, 418, '2021-01-04 07:00:04', '2021-01-04 18:09:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_income_entries`
--

CREATE TABLE `daily_income_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bus_id` bigint(20) UNSIGNED NOT NULL,
  `income` bigint(20) UNSIGNED NOT NULL,
  `check_in_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `check_in_places` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_income_entries`
--

INSERT INTO `daily_income_entries` (`id`, `bus_id`, `income`, `check_in_ids`, `check_in_places`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 783, '[1,2]', '[1,2]', '2020-12-29 21:08:45', '2020-12-29 21:10:28', NULL),
(2, 2, 418, '[3,4]', '[1,2]', '2021-01-04 18:06:34', '2021-01-04 18:08:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_services`
--

CREATE TABLE `email_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'smtp',
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'smtp.googlemail.com',
  `port` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '465',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'busmama@gmail.com',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'password',
  `mail_encryption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ssl',
  `from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'busmama@gmail.com',
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BusMama',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_services`
--

INSERT INTO `email_services` (`id`, `driver`, `host`, `port`, `username`, `password`, `mail_encryption`, `from_address`, `from_name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'smtp.googlemail.com', '465', 'busmama@gmail.com', 'password', 'ssl', 'busmama@gmail.com', 'BusMama', 1, '2020-12-28 20:57:53', '2020-12-28 20:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(147, '2014_10_12_000000_create_users_table', 1),
(148, '2014_10_12_100000_create_password_resets_table', 1),
(149, '2019_08_19_000000_create_failed_jobs_table', 1),
(150, '2020_12_11_181208_create_permission_tables', 1),
(151, '2020_12_12_000946_create_user_profiles_table', 1),
(152, '2020_12_25_155615_create_passenger_categories_table', 1),
(153, '2020_12_25_160644_create_buses_table', 1),
(154, '2020_12_25_160718_create_bus_routes_table', 1),
(155, '2020_12_25_160739_create_bus_stops_table', 1),
(156, '2020_12_25_160931_create_buses_in_routes_table', 1),
(157, '2020_12_25_161019_create_ticket_pricings_table', 1),
(158, '2020_12_25_161132_create_assign_checkers_table', 1),
(159, '2020_12_25_161208_create_check_ins_table', 1),
(160, '2020_12_26_231733_create_check_in_passengers_table', 1),
(161, '2020_12_26_232040_create_check_in_incomes_table', 1),
(162, '2020_12_26_232316_create_daily_income_entries_table', 1),
(163, '2020_12_28_052313_create_daily_incomes_table', 1),
(164, '2020_12_28_052957_create_monthly_incomes_table', 1),
(165, '2020_12_28_053015_create_yearly_incomes_table', 1),
(166, '2020_12_28_053041_create_complains_table', 1),
(167, '2020_12_29_040009_create_site_settings_table', 1),
(168, '2020_12_29_040309_create_email_services_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(2, 'App\\User', 3),
(2, 'App\\User', 4),
(2, 'App\\User', 5),
(3, 'App\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_incomes`
--

CREATE TABLE `monthly_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `monthlyIncome` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthly_incomes`
--

INSERT INTO `monthly_incomes` (`id`, `monthlyIncome`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 783, '2020-12-29 16:20:13', '2020-12-29 16:20:13', NULL),
(2, 418, '2021-01-01 07:00:05', '2021-01-04 18:09:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `passenger_categories`
--

CREATE TABLE `passenger_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `passenger_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_in_percentage` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passenger_categories`
--

INSERT INTO `passenger_categories` (`id`, `passenger_category`, `cost_in_percentage`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Regular', 100, 1, '2020-12-29 06:57:23', '2020-12-29 06:57:23', NULL),
(2, 'Student', 50, 1, '2020-12-29 06:57:23', '2020-12-29 06:57:23', NULL),
(3, 'Staff', 60, 1, '2020-12-29 06:57:23', '2020-12-29 06:57:23', NULL),
(4, 'Physically Disabled', 20, 1, '2020-12-29 06:57:23', '2020-12-29 20:51:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user-list', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(2, 'user', 'user-create', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(3, 'user', 'user-edit', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(4, 'user', 'user-delete', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(5, 'role', 'role-list', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(6, 'role', 'role-create', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(7, 'role', 'role-edit', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(8, 'role', 'role-delete', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(9, 'assign-checker', 'assign-checker-list', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(10, 'assign-checker', 'assign-checker-create', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(11, 'assign-checker', 'assign-checker-edit', 'web', '2020-12-29 06:57:18', '2020-12-29 06:57:18'),
(12, 'assign-checker', 'assign-checker-delete', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(13, 'bus', 'bus-list', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(14, 'bus', 'bus-create', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(15, 'bus', 'bus-edit', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(16, 'bus', 'bus-delete', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(17, 'bus-in-Route', 'bus-in-Route-list', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(18, 'bus-in-Route', 'bus-in-Route-create', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(19, 'bus-in-Route', 'bus-in-Route-edit', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(20, 'bus-in-Route', 'bus-in-Route-delete', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(21, 'bus-route', 'bus-route-list', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(22, 'bus-route', 'bus-route-create', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(23, 'bus-route', 'bus-route-edit', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(24, 'bus-route', 'bus-route-delete', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(25, 'bus-stops', 'bus-stops-list', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(26, 'bus-stops', 'bus-stops-create', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(27, 'bus-stops', 'bus-stops-edit', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(28, 'bus-stops', 'bus-stops-delete', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(29, 'checker', 'checker-list', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(30, 'checker', 'checker-create', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(31, 'checker', 'checker-edit', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(32, 'checker', 'checker-delete', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(33, 'all-Check-in', 'all-Check-in-list', 'web', '2020-12-29 06:57:19', '2020-12-29 06:57:19'),
(34, 'all-Check-in', 'all-Check-in-create', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(35, 'all-Check-in', 'all-Check-in-edit', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(36, 'all-Check-in', 'all-Check-in-delete', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(37, 'complains', 'complains-list', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(38, 'complains', 'complains-create', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(39, 'complains', 'complains-edit', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(40, 'complains', 'complains-delete', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(41, 'Income-Report', 'Income-Report-list', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(42, 'Income-Report', 'Income-Report-create', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(43, 'Income-Report', 'Income-Report-edit', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(44, 'Income-Report', 'Income-Report-delete', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(45, 'passenger-category', 'passenger-category-list', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(46, 'passenger-category', 'passenger-category-create', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(47, 'passenger-category', 'passenger-category-edit', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(48, 'passenger-category', 'passenger-category-delete', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(49, 'settings', 'settings-list', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(50, 'settings', 'settings-create', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(51, 'settings', 'settings-edit', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(52, 'settings', 'settings-delete', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(53, 'ticket-price', 'ticket-price-list', 'web', '2020-12-29 06:57:20', '2020-12-29 06:57:20'),
(54, 'ticket-price', 'ticket-price-create', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(55, 'ticket-price', 'ticket-price-edit', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(56, 'ticket-price', 'ticket-price-delete', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(57, 'check-in', 'check-in-list', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(58, 'check-in', 'check-in-create', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(59, 'check-in', 'check-in-edit', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(60, 'check-in', 'check-in-delete', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(61, 'checker-complain', 'checker-complain-list', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(62, 'checker-complain', 'checker-complain-create', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(63, 'checker-complain', 'checker-complain-edit', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21'),
(64, 'checker-complain', 'checker-complain-delete', 'web', '2020-12-29 06:57:21', '2020-12-29 06:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2020-12-29 06:57:25', '2020-12-29 06:57:25'),
(2, 'Checker', 'web', '2020-12-29 06:57:26', '2020-12-29 06:57:26'),
(3, 'Test Role', 'web', '2020-12-29 20:59:19', '2020-12-29 20:59:19');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(18, 1),
(19, 1),
(19, 3),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 3),
(52, 1),
(52, 3),
(53, 1),
(53, 3),
(54, 1),
(54, 3),
(55, 1),
(55, 3),
(56, 1),
(56, 3),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BusMama',
  `site_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'busmama@gmail.com',
  `site_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://busmama.com',
  `site_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'All Right Reserved Mijanur Rahman',
  `mail_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_email`, `site_address`, `site_description`, `meta_title`, `meta_description`, `footer_text`, `mail_verified`, `created_at`, `updated_at`) VALUES
(1, 'BusMama', 'busmama@gmail.com', 'https://busmama.com', NULL, 'Meta', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'All Right Reserved Mijanur Rahman', 0, '2020-12-28 20:39:48', '2020-12-29 20:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_pricings`
--

CREATE TABLE `ticket_pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bus_route_id` bigint(20) UNSIGNED NOT NULL,
  `from_where` bigint(20) UNSIGNED NOT NULL,
  `to_where` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_pricings`
--

INSERT INTO `ticket_pricings` (`id`, `bus_route_id`, `from_where`, `to_where`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 25, '2020-12-29 20:48:54', '2020-12-29 20:48:54', NULL),
(2, 1, 2, 3, 15, '2020-12-29 20:49:18', '2020-12-29 20:49:18', NULL),
(3, 1, 3, 4, 20, '2020-12-29 20:49:53', '2020-12-29 20:49:53', NULL),
(4, 1, 5, 6, 20, '2020-12-29 20:50:20', '2020-12-29 20:50:20', NULL),
(5, 1, 6, 7, 30, '2020-12-29 20:50:42', '2020-12-29 20:50:42', NULL),
(6, 1, 7, 8, 10, '2020-12-29 20:51:00', '2020-12-29 20:51:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jhon Doe', 'admin@gmail.com', '2020-12-29 06:57:25', '$2y$10$/J0QuiAMpjEfoYoMl8PINes/G1qJsgrcXWYq59/ctLJsooLcgvzGy', NULL, '2020-12-29 06:57:25', '2020-12-29 06:57:25', NULL),
(2, 'Jr. Smith', 'checker@gmail.com', '2020-12-29 06:57:26', '$2y$10$.Kx5JcweW0ph3gz8bHoW1.9N56sRZgFDralTrrrUidmCkFrK5j9My', '7SqSnF1kIhJRYFILTHMk8nNgnJ0l1acI2ZG8ONnocgu3jE6ZtuMQltpqYTzI', '2020-12-29 06:57:26', '2020-12-29 06:57:26', NULL),
(3, 'Milan Sm.', 'checker2@gmail.com', NULL, '$2y$10$jprXfyf5rGTkDrPVSYdiKOW98uft.s7uStSNlFM1DYLMPDYZsRn7m', NULL, '2020-12-29 20:53:13', '2020-12-29 20:53:13', NULL),
(4, 'Thomas', 'checker3@gmail.com', NULL, '$2y$10$.ICmRjoNqZFEsJ9qAUt4Ke15Hz0kjktHnnWT/ywgTuzjXNI3HzR3e', NULL, '2020-12-29 20:53:44', '2020-12-29 20:53:44', NULL),
(5, 'Adil', 'checker4@gmail.com', NULL, '$2y$10$iP7Gma0QeMmZQHZKoRXNeuL26WfVmFZYGW0/a26r0UkSjfEt9zYCW', NULL, '2020-12-29 20:54:54', '2020-12-29 20:54:54', NULL),
(6, 'Abraham', 'ab@gmail.com', NULL, '$2y$10$mGQdOmH4KSiw7Bl8ZL2kXuLz/25agYfh9nKhnKpef3TC1WV6mS9uu', NULL, '2020-12-29 21:00:11', '2020-12-29 21:00:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_status` tinyint(1) NOT NULL DEFAULT 1,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_plus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `account_status`, `bio`, `phone`, `birth_date`, `website`, `facebook`, `instagram`, `google_plus`, `linkedin`, `quora`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-29 06:57:25', '2020-12-29 06:57:25', NULL),
(2, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-29 06:57:26', '2020-12-29 06:57:26', NULL),
(3, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-29 20:53:13', '2020-12-29 20:53:13', NULL),
(4, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-29 20:53:44', '2020-12-29 20:53:44', NULL),
(5, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-29 20:54:54', '2020-12-29 20:54:54', NULL),
(6, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-29 21:00:11', '2020-12-29 21:00:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `yearly_incomes`
--

CREATE TABLE `yearly_incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `yearlyIncome` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_checkers`
--
ALTER TABLE `assign_checkers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_checkers_checker_id_foreign` (`checker_id`),
  ADD KEY `assign_checkers_bus_stop_id_foreign` (`bus_stop_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buses_bus_no_unique` (`bus_no`);

--
-- Indexes for table `buses_in_routes`
--
ALTER TABLE `buses_in_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buses_in_routes_bus_id_foreign` (`bus_id`),
  ADD KEY `buses_in_routes_bus_route_id_foreign` (`bus_route_id`);

--
-- Indexes for table `bus_routes`
--
ALTER TABLE `bus_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_stops`
--
ALTER TABLE `bus_stops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_stops_bus_route_id_foreign` (`bus_route_id`);

--
-- Indexes for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_ins_checker_id_foreign` (`checker_id`),
  ADD KEY `check_ins_bus_id_foreign` (`bus_id`),
  ADD KEY `check_ins_bus_stop_id_foreign` (`bus_stop_id`);

--
-- Indexes for table `check_in_incomes`
--
ALTER TABLE `check_in_incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_in_incomes_checkinpass_id_foreign` (`checkInPass_id`);

--
-- Indexes for table `check_in_passengers`
--
ALTER TABLE `check_in_passengers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_in_passengers_checkin_id_foreign` (`checkIn_id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complains_checker_id_foreign` (`checker_id`);

--
-- Indexes for table `daily_incomes`
--
ALTER TABLE `daily_incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_income_entries`
--
ALTER TABLE `daily_income_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `email_services`
--
ALTER TABLE `email_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `monthly_incomes`
--
ALTER TABLE `monthly_incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger_categories`
--
ALTER TABLE `passenger_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `passenger_categories_passenger_category_unique` (`passenger_category`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_pricings`
--
ALTER TABLE `ticket_pricings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_pricings_bus_route_id_foreign` (`bus_route_id`),
  ADD KEY `ticket_pricings_from_where_foreign` (`from_where`),
  ADD KEY `ticket_pricings_to_where_foreign` (`to_where`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `yearly_incomes`
--
ALTER TABLE `yearly_incomes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_checkers`
--
ALTER TABLE `assign_checkers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buses_in_routes`
--
ALTER TABLE `buses_in_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bus_routes`
--
ALTER TABLE `bus_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bus_stops`
--
ALTER TABLE `bus_stops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `check_in_incomes`
--
ALTER TABLE `check_in_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `check_in_passengers`
--
ALTER TABLE `check_in_passengers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_incomes`
--
ALTER TABLE `daily_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `daily_income_entries`
--
ALTER TABLE `daily_income_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_services`
--
ALTER TABLE `email_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `monthly_incomes`
--
ALTER TABLE `monthly_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_pricings`
--
ALTER TABLE `ticket_pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `yearly_incomes`
--
ALTER TABLE `yearly_incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
