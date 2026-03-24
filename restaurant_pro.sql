-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Mar 24, 2026 at 12:09 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`id`, `name`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Extra lemon 1pcs', 10.00, NULL, '2026-03-24 10:44:57', '2026-03-24 10:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `location` point NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `password`, `role_id`, `created_at`, `updated_at`, `deleted_at`, `location`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '01638107361', '$2y$12$nD9eoC2ur0cK1YZMRVPvneCUihyiqgFTQiA3I4VAHWq0CmFZQa8By', 1, '2026-03-24 09:19:45', '2026-03-24 09:26:40', NULL, 0x00000000010100000000000000000000000000000000000000);

-- --------------------------------------------------------

--
-- Table structure for table `admin_menus`
--

CREATE TABLE `admin_menus` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menus`
--

INSERT INTO `admin_menus` (`id`, `name`, `slug`, `icon`, `url`, `parent_id`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dashboard', 'dashboard', 'ri-dashboard-line', '/admin/dashboard', NULL, 1, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(2, 'Role & Permissions', 'role-permissions', 'ri-shield-user-line', NULL, NULL, 2, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(3, 'Admin Roles', 'admin-roles', 'ri-shield-check-line', '/admin/admin-roles', 2, 1, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(4, 'Admin Permissions', 'admin-permissions', 'ri-key-line', '/admin/admin-permissions', 2, 2, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(5, 'Menu Permissions', 'menu-permissions', 'ri-links-line', '/admin/admin-menu-permissions', 2, 3, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(6, 'Role Menu Permissions', 'role-menu-permissions', 'ri-shield-star-line', '/admin/admin-role-menu-permissions', 2, 4, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(7, 'Admin Menus', 'admin-menus', 'ri-menu-line', '/admin/admin-menus', 2, 5, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(8, 'Admin', 'admin', 'ri-admin-line', NULL, NULL, 3, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(9, 'Admins', 'admins', 'ri-team-line', '/admin/admins', 8, 1, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(10, 'Categories', 'categories', 'ri-price-tag-3-line', '/admin/categories', NULL, 4, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(11, 'Products', 'products', 'ri-shopping-bag-3-line', '/admin/products', NULL, 5, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(12, 'Ingredients', 'ingredients', 'ri-restaurant-line', '/admin/ingredients', 11, 1, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(13, 'Product Ingredients', 'product-ingredients', 'ri-list-check-3', '/admin/product-ingredients', 11, 3, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(14, 'Addons', 'addons', 'ri-add-circle-line', '/admin/addons', 11, 4, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(15, 'Product Addons', 'product-addons', 'ri-links-line', '/admin/product-addons', 11, 5, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL),
(16, 'Product List', 'product-list', 'ri-shopping-cart-line', '/admin/products', 11, 2, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu_permission`
--

CREATE TABLE `admin_menu_permission` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menu_permission`
--

INSERT INTO `admin_menu_permission` (`id`, `menu_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(2, 2, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(3, 3, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(4, 3, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(5, 3, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(6, 3, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(7, 3, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(8, 4, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(9, 4, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(10, 4, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(11, 4, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(12, 4, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(13, 5, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(14, 5, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(15, 5, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(16, 5, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(17, 5, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(18, 6, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(19, 6, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(20, 6, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(21, 6, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(22, 6, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(23, 7, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(24, 7, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(25, 7, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(26, 7, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(27, 7, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(28, 8, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(29, 9, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(30, 9, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(31, 9, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(32, 9, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(33, 9, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(34, 10, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(35, 10, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(36, 10, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(37, 10, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(38, 10, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(39, 11, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(40, 11, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(41, 11, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(42, 11, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(43, 11, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(44, 12, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(45, 12, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(46, 12, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(47, 12, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(48, 12, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(49, 16, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(50, 16, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(51, 16, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(52, 16, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(53, 16, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(54, 13, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(55, 13, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(56, 13, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(57, 13, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(58, 13, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(59, 14, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(60, 14, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(61, 14, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(62, 14, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(63, 14, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(64, 15, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(65, 15, 2, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(66, 15, 3, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(67, 15, 4, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(68, 15, 5, '2026-03-24 10:22:41', '2026-03-24 10:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Access', 'access', 'Can access/view menu', '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(2, 'Create', 'create', 'Can create new records', '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(3, 'Edit', 'edit', 'Can edit records', '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(4, 'View', 'view', 'Can view record details', '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(5, 'Delete', 'delete', 'Can delete records', '2026-03-24 10:22:41', '2026-03-24 10:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'super_admin', 'Super Administrator with full system access and permissions.', '2026-03-24 09:19:44', '2026-03-24 09:19:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_menu_permission`
--

CREATE TABLE `admin_role_menu_permission` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `menu_permission_id` bigint UNSIGNED NOT NULL,
  `allow` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_menu_permission`
--

INSERT INTO `admin_role_menu_permission` (`id`, `role_id`, `menu_permission_id`, `allow`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(2, 1, 2, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(3, 1, 3, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(4, 1, 4, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(5, 1, 5, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(6, 1, 6, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(7, 1, 7, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(8, 1, 8, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(9, 1, 9, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(10, 1, 10, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(11, 1, 11, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(12, 1, 12, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(13, 1, 13, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(14, 1, 14, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(15, 1, 15, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(16, 1, 16, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(17, 1, 17, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(18, 1, 18, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(19, 1, 19, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(20, 1, 20, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(21, 1, 21, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(22, 1, 22, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(23, 1, 23, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(24, 1, 24, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(25, 1, 25, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(26, 1, 26, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(27, 1, 27, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(28, 1, 28, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(29, 1, 29, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(30, 1, 30, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(31, 1, 31, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(32, 1, 32, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(33, 1, 33, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(34, 1, 34, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(35, 1, 35, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(36, 1, 36, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(37, 1, 37, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(38, 1, 38, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(39, 1, 39, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(40, 1, 40, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(41, 1, 41, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(42, 1, 42, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(43, 1, 43, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(44, 1, 44, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(45, 1, 45, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(46, 1, 46, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(47, 1, 47, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(48, 1, 48, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(49, 1, 54, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(50, 1, 55, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(51, 1, 56, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(52, 1, 57, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(53, 1, 58, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(54, 1, 59, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(55, 1, 60, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(56, 1, 61, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(57, 1, 62, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(58, 1, 63, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(59, 1, 64, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(60, 1, 65, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(61, 1, 66, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(62, 1, 67, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(63, 1, 68, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(64, 1, 49, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(65, 1, 50, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(66, 1, 51, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(67, 1, 52, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41'),
(68, 1, 53, 1, '2026-03-24 10:22:41', '2026-03-24 10:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Juice', 'juice', 1, NULL, '2026-03-24 10:25:18', '2026-03-24 10:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `unit`, `stock_qty`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Oil', '5gm', 100.00, NULL, '2026-03-24 10:28:27', '2026-03-24 10:28:27'),
(2, 'Onion', '5gm', 100.00, NULL, '2026-03-24 10:28:46', '2026-03-24 10:28:46'),
(3, 'Salt', '1gm', 100.00, NULL, '2026-03-24 10:29:04', '2026-03-24 10:29:04'),
(4, 'Spicy', '1 pcs', 100.00, NULL, '2026-03-24 10:29:20', '2026-03-24 10:29:20'),
(5, 'Lemon', '1pcs', 100.00, NULL, '2026-03-24 10:29:40', '2026-03-24 10:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_15_142017_create_admins_table', 1),
(5, '2025_11_16_151316_create_admin_roles_table', 1),
(6, '2025_11_18_000001_create_admin_menus_table', 1),
(7, '2025_11_18_171711_create_admin_permissions_table', 1),
(8, '2025_11_18_172930_create_admin_menu_permission_table', 1),
(9, '2025_11_18_173816_create_admin_role_menu_permission_table', 1),
(10, '2026_03_24_100000_create_categories_table', 2),
(11, '2026_03_24_101500_create_products_table', 3),
(12, '2026_03_24_103000_create_ingredients_table', 4),
(13, '2026_03_24_104500_create_product_ingredients_table', 5),
(14, '2026_03_24_110000_create_addons_table', 6),
(15, '2026_03_24_111500_create_product_addons_table', 7),
(16, '2026_03_24_120000_create_orders_table', 8),
(17, '2026_03_24_120100_create_order_items_table', 8),
(18, '2026_03_24_120200_create_order_item_addons_table', 8),
(19, '2026_03_24_130000_add_phone_to_users_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `soft_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_phone`, `order_status`, `total_amount`, `payment_status`, `soft_delete`, `created_at`, `updated_at`) VALUES
(1, 23, 'bokhtiar', '01638107361', 'pending', 40.00, 'unpaid', 0, '2026-03-24 11:55:46', '2026-03-24 11:55:46'),
(2, 23, 'bokhtiar', '01638107361', 'pending', 70.00, 'unpaid', 0, '2026-03-24 12:07:30', '2026-03-24 12:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0.00, '2026-03-24 11:55:46', '2026-03-24 11:55:46'),
(2, 1, 1, 1, 30.00, '2026-03-24 11:55:46', '2026-03-24 11:55:46'),
(3, 2, 1, 1, 10.00, '2026-03-24 12:07:30', '2026-03-24 12:07:30'),
(4, 2, 1, 2, 30.00, '2026-03-24 12:07:30', '2026-03-24 12:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_addons`
--

CREATE TABLE `order_item_addons` (
  `id` bigint UNSIGNED NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `addon_id` bigint UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_addons`
--

INSERT INTO `order_item_addons` (`id`, `order_item_id`, `addon_id`, `price`) VALUES
(1, 1, 1, 10.00),
(2, 3, 1, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `slug`, `price`, `is_available`, `image_url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Lemonite Juice', NULL, 1, 'lemonite-juice', 30.00, 1, 'https://i.ytimg.com/vi/VDXawwjLmj4/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLC-c3Ec7sYeZ8G-_oYPIgEOwJd_0g', NULL, '2026-03-24 10:26:46', '2026-03-24 10:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_addons`
--

CREATE TABLE `product_addons` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `addon_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_addons`
--

INSERT INTO `product_addons` (`id`, `product_id`, `addon_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE `product_ingredients` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `ingredient_id` bigint UNSIGNED NOT NULL,
  `qty` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ingredients`
--

INSERT INTO `product_ingredients` (`id`, `product_id`, `ingredient_id`, `qty`) VALUES
(2, 1, 5, 100.00),
(3, 1, 1, 100.00),
(4, 1, 2, 100.00),
(5, 1, 4, 100.00),
(6, 1, 3, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NDAOiqcKINakl2vb9kyWiCnTJCufNJyHC7RzbPbq', 23, '172.25.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IlY0NzVTeUpwT2s0aHluNWdWODVXdHNRQnZKS3lnTWZHTGpwUXhLbUsiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG9jYWxob3N0OjgwMDYvbXktb3JkZXJzIjtzOjU6InJvdXRlIjtzOjEyOiJvcmRlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjg6ImFkbWluX2lkIjtpOjE7czoxMDoiYWRtaW5fbmFtZSI7czoxMToiU3VwZXIgQWRtaW4iO3M6MTM6ImFkbWluX3JvbGVfaWQiO2k6MTtzOjE1OiJhZG1pbl9yb2xlX25hbWUiO3M6MTE6IlN1cGVyIEFkbWluIjtzOjE3OiJhZG1pbl9wZXJtaXNzaW9ucyI7YToxNjp7czo5OiJkYXNoYm9hcmQiO2E6MTp7aTowO3M6NjoiYWNjZXNzIjt9czoxNjoicm9sZS1wZXJtaXNzaW9ucyI7YToxOntpOjA7czo2OiJhY2Nlc3MiO31zOjExOiJhZG1pbi1yb2xlcyI7YTo1OntpOjA7czo2OiJhY2Nlc3MiO2k6MTtzOjY6ImNyZWF0ZSI7aToyO3M6NDoiZWRpdCI7aTozO3M6NDoidmlldyI7aTo0O3M6NjoiZGVsZXRlIjt9czoxNzoiYWRtaW4tcGVybWlzc2lvbnMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6MTY6Im1lbnUtcGVybWlzc2lvbnMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6MjE6InJvbGUtbWVudS1wZXJtaXNzaW9ucyI7YTo1OntpOjA7czo2OiJhY2Nlc3MiO2k6MTtzOjY6ImNyZWF0ZSI7aToyO3M6NDoiZWRpdCI7aTozO3M6NDoidmlldyI7aTo0O3M6NjoiZGVsZXRlIjt9czoxMToiYWRtaW4tbWVudXMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6NToiYWRtaW4iO2E6MTp7aTowO3M6NjoiYWNjZXNzIjt9czo2OiJhZG1pbnMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6MTA6ImNhdGVnb3JpZXMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6ODoicHJvZHVjdHMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6MTE6ImluZ3JlZGllbnRzIjthOjU6e2k6MDtzOjY6ImFjY2VzcyI7aToxO3M6NjoiY3JlYXRlIjtpOjI7czo0OiJlZGl0IjtpOjM7czo0OiJ2aWV3IjtpOjQ7czo2OiJkZWxldGUiO31zOjE5OiJwcm9kdWN0LWluZ3JlZGllbnRzIjthOjU6e2k6MDtzOjY6ImFjY2VzcyI7aToxO3M6NjoiY3JlYXRlIjtpOjI7czo0OiJlZGl0IjtpOjM7czo0OiJ2aWV3IjtpOjQ7czo2OiJkZWxldGUiO31zOjY6ImFkZG9ucyI7YTo1OntpOjA7czo2OiJhY2Nlc3MiO2k6MTtzOjY6ImNyZWF0ZSI7aToyO3M6NDoiZWRpdCI7aTozO3M6NDoidmlldyI7aTo0O3M6NjoiZGVsZXRlIjt9czoxNDoicHJvZHVjdC1hZGRvbnMiO2E6NTp7aTowO3M6NjoiYWNjZXNzIjtpOjE7czo2OiJjcmVhdGUiO2k6MjtzOjQ6ImVkaXQiO2k6MztzOjQ6InZpZXciO2k6NDtzOjY6ImRlbGV0ZSI7fXM6MTI6InByb2R1Y3QtbGlzdCI7YTo1OntpOjA7czo2OiJhY2Nlc3MiO2k6MTtzOjY6ImNyZWF0ZSI7aToyO3M6NDoiZWRpdCI7aTozO3M6NDoidmlldyI7aTo0O3M6NjoiZGVsZXRlIjt9fXM6MjA6ImFkbWluX21lbnVfc3RydWN0dXJlIjthOjU6e2k6MTthOjEwOntzOjc6Im1lbnVfaWQiO2k6MTtzOjk6Im1lbnVfbmFtZSI7czo5OiJEYXNoYm9hcmQiO3M6OToibWVudV9zbHVnIjtzOjk6ImRhc2hib2FyZCI7czo4OiJtZW51X3VybCI7czoxNjoiL2FkbWluL2Rhc2hib2FyZCI7czo5OiJtZW51X2ljb24iO3M6MTc6InJpLWRhc2hib2FyZC1saW5lIjtzOjk6InBhcmVudF9pZCI7TjtzOjEwOiJzb3J0X29yZGVyIjtpOjE7czo5OiJpc19hY3RpdmUiO2I6MTtzOjExOiJwZXJtaXNzaW9ucyI7YToxOntzOjY6ImFjY2VzcyI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjA6e319aToyO2E6MTA6e3M6NzoibWVudV9pZCI7aToyO3M6OToibWVudV9uYW1lIjtzOjE4OiJSb2xlICYgUGVybWlzc2lvbnMiO3M6OToibWVudV9zbHVnIjtzOjE2OiJyb2xlLXBlcm1pc3Npb25zIjtzOjg6Im1lbnVfdXJsIjtOO3M6OToibWVudV9pY29uIjtzOjE5OiJyaS1zaGllbGQtdXNlci1saW5lIjtzOjk6InBhcmVudF9pZCI7TjtzOjEwOiJzb3J0X29yZGVyIjtpOjI7czo5OiJpc19hY3RpdmUiO2I6MTtzOjExOiJwZXJtaXNzaW9ucyI7YToxOntzOjY6ImFjY2VzcyI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjU6e2k6MDthOjEwOntzOjc6Im1lbnVfaWQiO2k6MztzOjk6Im1lbnVfbmFtZSI7czoxMToiQWRtaW4gUm9sZXMiO3M6OToibWVudV9zbHVnIjtzOjExOiJhZG1pbi1yb2xlcyI7czo4OiJtZW51X3VybCI7czoxODoiL2FkbWluL2FkbWluLXJvbGVzIjtzOjk6Im1lbnVfaWNvbiI7czoyMDoicmktc2hpZWxkLWNoZWNrLWxpbmUiO3M6OToicGFyZW50X2lkIjtpOjI7czoxMDoic29ydF9vcmRlciI7aToxO3M6OToiaXNfYWN0aXZlIjtiOjE7czoxMToicGVybWlzc2lvbnMiO2E6NTp7czo2OiJhY2Nlc3MiO2I6MTtzOjY6ImNyZWF0ZSI7YjoxO3M6NDoiZWRpdCI7YjoxO3M6NDoidmlldyI7YjoxO3M6NjoiZGVsZXRlIjtiOjE7fXM6ODoiY2hpbGRyZW4iO2E6MDp7fX1pOjE7YToxMDp7czo3OiJtZW51X2lkIjtpOjQ7czo5OiJtZW51X25hbWUiO3M6MTc6IkFkbWluIFBlcm1pc3Npb25zIjtzOjk6Im1lbnVfc2x1ZyI7czoxNzoiYWRtaW4tcGVybWlzc2lvbnMiO3M6ODoibWVudV91cmwiO3M6MjQ6Ii9hZG1pbi9hZG1pbi1wZXJtaXNzaW9ucyI7czo5OiJtZW51X2ljb24iO3M6MTE6InJpLWtleS1saW5lIjtzOjk6InBhcmVudF9pZCI7aToyO3M6MTA6InNvcnRfb3JkZXIiO2k6MjtzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjU6e3M6NjoiYWNjZXNzIjtiOjE7czo2OiJjcmVhdGUiO2I6MTtzOjQ6ImVkaXQiO2I6MTtzOjQ6InZpZXciO2I6MTtzOjY6ImRlbGV0ZSI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjA6e319aToyO2E6MTA6e3M6NzoibWVudV9pZCI7aTo1O3M6OToibWVudV9uYW1lIjtzOjE2OiJNZW51IFBlcm1pc3Npb25zIjtzOjk6Im1lbnVfc2x1ZyI7czoxNjoibWVudS1wZXJtaXNzaW9ucyI7czo4OiJtZW51X3VybCI7czoyOToiL2FkbWluL2FkbWluLW1lbnUtcGVybWlzc2lvbnMiO3M6OToibWVudV9pY29uIjtzOjEzOiJyaS1saW5rcy1saW5lIjtzOjk6InBhcmVudF9pZCI7aToyO3M6MTA6InNvcnRfb3JkZXIiO2k6MztzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjU6e3M6NjoiYWNjZXNzIjtiOjE7czo2OiJjcmVhdGUiO2I6MTtzOjQ6ImVkaXQiO2I6MTtzOjQ6InZpZXciO2I6MTtzOjY6ImRlbGV0ZSI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjA6e319aTozO2E6MTA6e3M6NzoibWVudV9pZCI7aTo2O3M6OToibWVudV9uYW1lIjtzOjIxOiJSb2xlIE1lbnUgUGVybWlzc2lvbnMiO3M6OToibWVudV9zbHVnIjtzOjIxOiJyb2xlLW1lbnUtcGVybWlzc2lvbnMiO3M6ODoibWVudV91cmwiO3M6MzQ6Ii9hZG1pbi9hZG1pbi1yb2xlLW1lbnUtcGVybWlzc2lvbnMiO3M6OToibWVudV9pY29uIjtzOjE5OiJyaS1zaGllbGQtc3Rhci1saW5lIjtzOjk6InBhcmVudF9pZCI7aToyO3M6MTA6InNvcnRfb3JkZXIiO2k6NDtzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjU6e3M6NjoiYWNjZXNzIjtiOjE7czo2OiJjcmVhdGUiO2I6MTtzOjQ6ImVkaXQiO2I6MTtzOjQ6InZpZXciO2I6MTtzOjY6ImRlbGV0ZSI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjA6e319aTo0O2E6MTA6e3M6NzoibWVudV9pZCI7aTo3O3M6OToibWVudV9uYW1lIjtzOjExOiJBZG1pbiBNZW51cyI7czo5OiJtZW51X3NsdWciO3M6MTE6ImFkbWluLW1lbnVzIjtzOjg6Im1lbnVfdXJsIjtzOjE4OiIvYWRtaW4vYWRtaW4tbWVudXMiO3M6OToibWVudV9pY29uIjtzOjEyOiJyaS1tZW51LWxpbmUiO3M6OToicGFyZW50X2lkIjtpOjI7czoxMDoic29ydF9vcmRlciI7aTo1O3M6OToiaXNfYWN0aXZlIjtiOjE7czoxMToicGVybWlzc2lvbnMiO2E6NTp7czo2OiJhY2Nlc3MiO2I6MTtzOjY6ImNyZWF0ZSI7YjoxO3M6NDoiZWRpdCI7YjoxO3M6NDoidmlldyI7YjoxO3M6NjoiZGVsZXRlIjtiOjE7fXM6ODoiY2hpbGRyZW4iO2E6MDp7fX19fWk6ODthOjEwOntzOjc6Im1lbnVfaWQiO2k6ODtzOjk6Im1lbnVfbmFtZSI7czo1OiJBZG1pbiI7czo5OiJtZW51X3NsdWciO3M6NToiYWRtaW4iO3M6ODoibWVudV91cmwiO047czo5OiJtZW51X2ljb24iO3M6MTM6InJpLWFkbWluLWxpbmUiO3M6OToicGFyZW50X2lkIjtOO3M6MTA6InNvcnRfb3JkZXIiO2k6MztzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjE6e3M6NjoiYWNjZXNzIjtiOjE7fXM6ODoiY2hpbGRyZW4iO2E6MTp7aTowO2E6MTA6e3M6NzoibWVudV9pZCI7aTo5O3M6OToibWVudV9uYW1lIjtzOjY6IkFkbWlucyI7czo5OiJtZW51X3NsdWciO3M6NjoiYWRtaW5zIjtzOjg6Im1lbnVfdXJsIjtzOjEzOiIvYWRtaW4vYWRtaW5zIjtzOjk6Im1lbnVfaWNvbiI7czoxMjoicmktdGVhbS1saW5lIjtzOjk6InBhcmVudF9pZCI7aTo4O3M6MTA6InNvcnRfb3JkZXIiO2k6MTtzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjU6e3M6NjoiYWNjZXNzIjtiOjE7czo2OiJjcmVhdGUiO2I6MTtzOjQ6ImVkaXQiO2I6MTtzOjQ6InZpZXciO2I6MTtzOjY6ImRlbGV0ZSI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjA6e319fX1pOjEwO2E6MTA6e3M6NzoibWVudV9pZCI7aToxMDtzOjk6Im1lbnVfbmFtZSI7czoxMDoiQ2F0ZWdvcmllcyI7czo5OiJtZW51X3NsdWciO3M6MTA6ImNhdGVnb3JpZXMiO3M6ODoibWVudV91cmwiO3M6MTc6Ii9hZG1pbi9jYXRlZ29yaWVzIjtzOjk6Im1lbnVfaWNvbiI7czoxOToicmktcHJpY2UtdGFnLTMtbGluZSI7czo5OiJwYXJlbnRfaWQiO047czoxMDoic29ydF9vcmRlciI7aTo0O3M6OToiaXNfYWN0aXZlIjtiOjE7czoxMToicGVybWlzc2lvbnMiO2E6NTp7czo2OiJhY2Nlc3MiO2I6MTtzOjY6ImNyZWF0ZSI7YjoxO3M6NDoiZWRpdCI7YjoxO3M6NDoidmlldyI7YjoxO3M6NjoiZGVsZXRlIjtiOjE7fXM6ODoiY2hpbGRyZW4iO2E6MDp7fX1pOjExO2E6MTA6e3M6NzoibWVudV9pZCI7aToxMTtzOjk6Im1lbnVfbmFtZSI7czo4OiJQcm9kdWN0cyI7czo5OiJtZW51X3NsdWciO3M6ODoicHJvZHVjdHMiO3M6ODoibWVudV91cmwiO3M6MTU6Ii9hZG1pbi9wcm9kdWN0cyI7czo5OiJtZW51X2ljb24iO3M6MjI6InJpLXNob3BwaW5nLWJhZy0zLWxpbmUiO3M6OToicGFyZW50X2lkIjtOO3M6MTA6InNvcnRfb3JkZXIiO2k6NTtzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjU6e3M6NjoiYWNjZXNzIjtiOjE7czo2OiJjcmVhdGUiO2I6MTtzOjQ6ImVkaXQiO2I6MTtzOjQ6InZpZXciO2I6MTtzOjY6ImRlbGV0ZSI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjU6e2k6MDthOjEwOntzOjc6Im1lbnVfaWQiO2k6MTI7czo5OiJtZW51X25hbWUiO3M6MTE6IkluZ3JlZGllbnRzIjtzOjk6Im1lbnVfc2x1ZyI7czoxMToiaW5ncmVkaWVudHMiO3M6ODoibWVudV91cmwiO3M6MTg6Ii9hZG1pbi9pbmdyZWRpZW50cyI7czo5OiJtZW51X2ljb24iO3M6MTg6InJpLXJlc3RhdXJhbnQtbGluZSI7czo5OiJwYXJlbnRfaWQiO2k6MTE7czoxMDoic29ydF9vcmRlciI7aToxO3M6OToiaXNfYWN0aXZlIjtiOjE7czoxMToicGVybWlzc2lvbnMiO2E6NTp7czo2OiJhY2Nlc3MiO2I6MTtzOjY6ImNyZWF0ZSI7YjoxO3M6NDoiZWRpdCI7YjoxO3M6NDoidmlldyI7YjoxO3M6NjoiZGVsZXRlIjtiOjE7fXM6ODoiY2hpbGRyZW4iO2E6MDp7fX1pOjE7YToxMDp7czo3OiJtZW51X2lkIjtpOjEzO3M6OToibWVudV9uYW1lIjtzOjE5OiJQcm9kdWN0IEluZ3JlZGllbnRzIjtzOjk6Im1lbnVfc2x1ZyI7czoxOToicHJvZHVjdC1pbmdyZWRpZW50cyI7czo4OiJtZW51X3VybCI7czoyNjoiL2FkbWluL3Byb2R1Y3QtaW5ncmVkaWVudHMiO3M6OToibWVudV9pY29uIjtzOjE1OiJyaS1saXN0LWNoZWNrLTMiO3M6OToicGFyZW50X2lkIjtpOjExO3M6MTA6InNvcnRfb3JkZXIiO2k6MztzOjk6ImlzX2FjdGl2ZSI7YjoxO3M6MTE6InBlcm1pc3Npb25zIjthOjU6e3M6NjoiYWNjZXNzIjtiOjE7czo2OiJjcmVhdGUiO2I6MTtzOjQ6ImVkaXQiO2I6MTtzOjQ6InZpZXciO2I6MTtzOjY6ImRlbGV0ZSI7YjoxO31zOjg6ImNoaWxkcmVuIjthOjA6e319aToyO2E6MTA6e3M6NzoibWVudV9pZCI7aToxNDtzOjk6Im1lbnVfbmFtZSI7czo2OiJBZGRvbnMiO3M6OToibWVudV9zbHVnIjtzOjY6ImFkZG9ucyI7czo4OiJtZW51X3VybCI7czoxMzoiL2FkbWluL2FkZG9ucyI7czo5OiJtZW51X2ljb24iO3M6MTg6InJpLWFkZC1jaXJjbGUtbGluZSI7czo5OiJwYXJlbnRfaWQiO2k6MTE7czoxMDoic29ydF9vcmRlciI7aTo0O3M6OToiaXNfYWN0aXZlIjtiOjE7czoxMToicGVybWlzc2lvbnMiO2E6NTp7czo2OiJhY2Nlc3MiO2I6MTtzOjY6ImNyZWF0ZSI7YjoxO3M6NDoiZWRpdCI7YjoxO3M6NDoidmlldyI7YjoxO3M6NjoiZGVsZXRlIjtiOjE7fXM6ODoiY2hpbGRyZW4iO2E6MDp7fX1pOjM7YToxMDp7czo3OiJtZW51X2lkIjtpOjE1O3M6OToibWVudV9uYW1lIjtzOjE0OiJQcm9kdWN0IEFkZG9ucyI7czo5OiJtZW51X3NsdWciO3M6MTQ6InByb2R1Y3QtYWRkb25zIjtzOjg6Im1lbnVfdXJsIjtzOjIxOiIvYWRtaW4vcHJvZHVjdC1hZGRvbnMiO3M6OToibWVudV9pY29uIjtzOjEzOiJyaS1saW5rcy1saW5lIjtzOjk6InBhcmVudF9pZCI7aToxMTtzOjEwOiJzb3J0X29yZGVyIjtpOjU7czo5OiJpc19hY3RpdmUiO2I6MTtzOjExOiJwZXJtaXNzaW9ucyI7YTo1OntzOjY6ImFjY2VzcyI7YjoxO3M6NjoiY3JlYXRlIjtiOjE7czo0OiJlZGl0IjtiOjE7czo0OiJ2aWV3IjtiOjE7czo2OiJkZWxldGUiO2I6MTt9czo4OiJjaGlsZHJlbiI7YTowOnt9fWk6NDthOjEwOntzOjc6Im1lbnVfaWQiO2k6MTY7czo5OiJtZW51X25hbWUiO3M6MTI6IlByb2R1Y3QgTGlzdCI7czo5OiJtZW51X3NsdWciO3M6MTI6InByb2R1Y3QtbGlzdCI7czo4OiJtZW51X3VybCI7czoxNToiL2FkbWluL3Byb2R1Y3RzIjtzOjk6Im1lbnVfaWNvbiI7czoyMToicmktc2hvcHBpbmctY2FydC1saW5lIjtzOjk6InBhcmVudF9pZCI7aToxMTtzOjEwOiJzb3J0X29yZGVyIjtpOjI7czo5OiJpc19hY3RpdmUiO2I6MTtzOjExOiJwZXJtaXNzaW9ucyI7YTo1OntzOjY6ImFjY2VzcyI7YjoxO3M6NjoiY3JlYXRlIjtiOjE7czo0OiJlZGl0IjtiOjE7czo0OiJ2aWV3IjtiOjE7czo2OiJkZWxldGUiO2I6MTt9czo4OiJjaGlsZHJlbiI7YTowOnt9fX19fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIzO30=', 1774354082);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tyrique Steuber', 'amya17@example.net', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', 'feLsCJ57KE', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(2, 'Uriah Kub', 'akoss@example.org', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', 'dzf8xhkRdz', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(3, 'Ruthie Cormier', 'nikolaus.pietro@example.org', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', '5tcfi0mRag', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(4, 'Makenzie Hackett', 'rosalee55@example.com', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', '9LnnX9U2ES', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(5, 'Mariah Upton', 'lacy99@example.net', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', '9FCPGSczD8', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(6, 'Donato Luettgen', 'stark.esther@example.org', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', 'i5E8zS01AJ', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(7, 'Alexys Hamill', 'sarina.corkery@example.org', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', 'FZwwDCOetF', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(8, 'Otho Cruickshank', 'jose22@example.org', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', 'jnPcgv2tYe', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(9, 'Emmalee Becker', 'johnny84@example.com', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', 'wh9Nvq2G2u', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(10, 'Johnpaul Kling', 'mireya95@example.com', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', '9PBNw4jHPY', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(11, 'Test User', 'test@example.com', NULL, '2026-03-24 09:19:44', '$2y$12$jataQdCMinHgicflkO.HDum56KUQAT8lwoNNkK8.Kwe5HorBEHBcC', '8QY96wSquH', '2026-03-24 09:19:44', '2026-03-24 09:19:44'),
(12, 'Gabe Muller MD', 'wschneider@example.org', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'pzQnH09Fir', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(13, 'Dr. Loyal White Sr.', 'chickle@example.org', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'J4T2eWZrO6', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(14, 'Dr. Alan Wuckert', 'voberbrunner@example.com', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'AKzQKEru8W', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(15, 'Isabel Gottlieb', 'fgottlieb@example.net', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'IdaFo5PK0b', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(16, 'Ms. Nakia Larkin DDS', 'mhaag@example.org', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'DfO4aCoxHn', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(17, 'Syble Jones', 'homenick.rhea@example.com', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'S0XpnWV5SY', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(18, 'Miss Kelli Stroman I', 'huel.karlie@example.com', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', '3KtGxWPnCj', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(19, 'Miss Ollie Walker', 'orn.harmon@example.net', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'iOzssvXIfT', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(20, 'Elmo Kuphal', 'natalia39@example.org', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', 'ZXEnDSWCVS', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(21, 'Logan Aufderhar', 'wilkinson.edwina@example.org', NULL, '2026-03-24 11:45:19', '$2y$12$C4VEsZVtNJnuucAqXGNWIecVfxaD8sp82UNzQ91i9IAXgSD4PcU2G', '2FhIoAzGnd', '2026-03-24 11:45:19', '2026-03-24 11:45:19'),
(23, 'bokhtiar', 'phone_01638107361@local.user', '01638107361', NULL, '$2y$12$E1PXADSAUNd6i/nHfVgrC.jI8/QBxhT1jGR3URIOt8Yh/Tgm2ZNoq', NULL, '2026-03-24 11:55:14', '2026-03-24 11:55:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_phone_unique` (`phone`),
  ADD SPATIAL KEY `location_index` (`location`);

--
-- Indexes for table `admin_menus`
--
ALTER TABLE `admin_menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_menus_slug_unique` (`slug`),
  ADD KEY `admin_menus_parent_id_index` (`parent_id`),
  ADD KEY `admin_menus_is_active_index` (`is_active`),
  ADD KEY `admin_menus_sort_order_index` (`sort_order`);

--
-- Indexes for table `admin_menu_permission`
--
ALTER TABLE `admin_menu_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_menu_permission_menu_id_permission_id_unique` (`menu_id`,`permission_id`),
  ADD KEY `admin_menu_permission_menu_id_index` (`menu_id`),
  ADD KEY `admin_menu_permission_permission_id_index` (`permission_id`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_slug_unique` (`slug`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_slug_unique` (`slug`);

--
-- Indexes for table `admin_role_menu_permission`
--
ALTER TABLE `admin_role_menu_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_role_menu_permission_role_id_menu_permission_id_unique` (`role_id`,`menu_permission_id`),
  ADD KEY `admin_role_menu_permission_role_id_index` (`role_id`),
  ADD KEY `admin_role_menu_permission_menu_permission_id_index` (`menu_permission_id`),
  ADD KEY `admin_role_menu_permission_allow_index` (`allow`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_order_status_index` (`order_status`),
  ADD KEY `orders_payment_status_index` (`payment_status`),
  ADD KEY `orders_created_at_index` (`created_at`),
  ADD KEY `orders_soft_delete_index` (`soft_delete`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_item_addons`
--
ALTER TABLE `order_item_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_addons_order_item_id_foreign` (`order_item_id`),
  ADD KEY `order_item_addons_addon_id_foreign` (`addon_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_addons`
--
ALTER TABLE `product_addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_addons_product_id_addon_id_unique` (`product_id`,`addon_id`),
  ADD KEY `product_addons_addon_id_foreign` (`addon_id`);

--
-- Indexes for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_ingredients_product_id_ingredient_id_unique` (`product_id`,`ingredient_id`),
  ADD KEY `product_ingredients_ingredient_id_foreign` (`ingredient_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_menus`
--
ALTER TABLE `admin_menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `admin_menu_permission`
--
ALTER TABLE `admin_menu_permission`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_role_menu_permission`
--
ALTER TABLE `admin_role_menu_permission`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_item_addons`
--
ALTER TABLE `order_item_addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_addons`
--
ALTER TABLE `product_addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_menus`
--
ALTER TABLE `admin_menus`
  ADD CONSTRAINT `admin_menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `admin_menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_menu_permission`
--
ALTER TABLE `admin_menu_permission`
  ADD CONSTRAINT `admin_menu_permission_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `admin_menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_menu_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `admin_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_role_menu_permission`
--
ALTER TABLE `admin_role_menu_permission`
  ADD CONSTRAINT `admin_role_menu_permission_menu_permission_id_foreign` FOREIGN KEY (`menu_permission_id`) REFERENCES `admin_menu_permission` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_role_menu_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item_addons`
--
ALTER TABLE `order_item_addons`
  ADD CONSTRAINT `order_item_addons_addon_id_foreign` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_addons_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_addons`
--
ALTER TABLE `product_addons`
  ADD CONSTRAINT `product_addons_addon_id_foreign` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_addons_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD CONSTRAINT `product_ingredients_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ingredients_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
