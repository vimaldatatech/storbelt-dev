-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: newstagingawscredit-rds.cjcyq280guvd.ap-southeast-2.rds.amazonaws.com
-- Generation Time: Apr 06, 2026 at 02:59 AM
-- Server version: 8.0.44
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webential-store-buddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_company`
--

CREATE TABLE `admin_company` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_user_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"d\";s:13:\"owner_user_id\";s:1:\"g\";s:6:\"module\";s:1:\"h\";s:6:\"action\";}s:11:\"permissions\";a:8:{i:0;a:6:{s:1:\"a\";i:1;s:1:\"b\";s:16:\"super.users.view\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:1;a:6:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"super.users.create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:2;a:6:{s:1:\"a\";i:3;s:1:\"b\";s:16:\"super.users.edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:3;a:6:{s:1:\"a\";i:4;s:1:\"b\";s:20:\"super.companies.view\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:4;a:6:{s:1:\"a\";i:5;s:1:\"b\";s:22:\"super.companies.create\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:5;a:6:{s:1:\"a\";i:8;s:1:\"b\";s:20:\"super.companies.edit\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:6;a:6:{s:1:\"a\";i:9;s:1:\"b\";s:22:\"super.companies.delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}i:7;a:6:{s:1:\"a\";i:10;s:1:\"b\";s:18:\"super.users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"g\";N;s:1:\"h\";N;}}s:5:\"roles\";a:0:{}}', 1771995093);

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
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trading_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_suburb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_postcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_suburb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_postcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abn_acn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','suspended','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Australia/Sydney',
  `plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storman_api_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storman_api_token` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `name`, `code`, `trading_name`, `phone`, `billing_address`, `billing_state`, `billing_suburb`, `billing_postcode`, `delivery_address`, `delivery_state`, `delivery_suburb`, `delivery_postcode`, `website_url`, `abn_acn`, `slug`, `platform`, `status`, `timezone`, `plan`, `storman_api_url`, `storman_api_token`, `created_at`, `updated_at`) VALUES
(5, 23, 'Storage Company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'storage-company', 'storman', 'active', 'Australia/Sydney', 'Basic', 'https://cloud.storman.com', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNWQ5MjFkNGZlYzYzNTllNGI2ZjgwNjJjNWJlODU1YmRmOTRhNDU2YmIxMjU0NzhkNDNhZWVlYzBiOGFkOGE0NjhhNDk0ZDI5OTczZDQ2ZjkiLCJpYXQiOjE3NTc1Nzk2NzMuOTAxNDk5LCJuYmYiOjE3NTc1Nzk2NzMuOTAxNTAxLCJleHAiOjE3ODkxMTU2NzMuODg0NjA3LCJzdWIiOiIzMTI2Iiwic2NvcGVzIjpbXX0.Gr5twcgvy8IcuFRy6aRoV2kw1JjMtZsUNk7ztyR2StYaenN27wRWOhhmcCU_upP2ZWIihHGLhBogYfms_SJRPUUIBR1atArgdWpuv2_Qb1tLjQCKI96AOw4jccWAPsVX9b5T6kxfDLQUZYqBuFiKwAfJ17WqbwtxR04Pv9WHXg-C1claByV26rRjvvVe_AmpKw3_eiuyCDlrVy2H7K1GV5Tlhw4t6m-5oYHTI0SK2mZj4l8vE4tQAwzsj3MxCfiDsMUanVAAgRrylkd0chSHHODdosnOQmJeruBFYkQZXOrzUpm2K4WK8Y0PkgSFQrVEdxKHjYTe5v2sRRajVXKYLM_m_nHhBJ0wV7SRIEmKor7ZnYftviItSTQiQbS1jokFJPMyx_7Tnr_txXoijwS9RAkEe0JByliu5_s3AVPkH_gmyKmKsG-I40CQ71HoNtVZdk9PS9tOeKXp-xsw-s_oaKWLhIlHzfvclQmCODkqWbkPfNAhy9n2DcYtSH-X-VQBvZjYAyLP80pqlM1S0o4hT1hy9BMlMWOqaW9GyXpZQM8K8YZpe-Esm7WP_zP7ZUoSsa_SNHtjIjfWPL_OP-bVCbmgQACW0D5ponR-MCO6nvplIKJ_Ls_yYsWHmd43vllFvf_Wp3oC9njhuCNsoowTnHYsX96BOIUxDjmbKcdYZOw', '2026-02-04 11:30:34', '2026-02-04 11:30:34'),
(6, 24, 'Webential Storage', NULL, 'Webential Trading Name', '123 456 7890', 'New Street', 'State', 'NSW', '2000', 'Old Street', 'WA', 'Suburb', '2002', NULL, '12345679801', 'webential-storage', 'storman', 'active', 'Australia/Sydney', 'basic', 'https://cloud.storman.com', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNWQ5MjFkNGZlYzYzNTllNGI2ZjgwNjJjNWJlODU1YmRmOTRhNDU2YmIxMjU0NzhkNDNhZWVlYzBiOGFkOGE0NjhhNDk0ZDI5OTczZDQ2ZjkiLCJpYXQiOjE3NTc1Nzk2NzMuOTAxNDk5LCJuYmYiOjE3NTc1Nzk2NzMuOTAxNTAxLCJleHAiOjE3ODkxMTU2NzMuODg0NjA3LCJzdWIiOiIzMTI2Iiwic2NvcGVzIjpbXX0.Gr5twcgvy8IcuFRy6aRoV2kw1JjMtZsUNk7ztyR2StYaenN27wRWOhhmcCU_upP2ZWIihHGLhBogYfms_SJRPUUIBR1atArgdWpuv2_Qb1tLjQCKI96AOw4jccWAPsVX9b5T6kxfDLQUZYqBuFiKwAfJ17WqbwtxR04Pv9WHXg-C1claByV26rRjvvVe_AmpKw3_eiuyCDlrVy2H7K1GV5Tlhw4t6m-5oYHTI0SK2mZj4l8vE4tQAwzsj3MxCfiDsMUanVAAgRrylkd0chSHHODdosnOQmJeruBFYkQZXOrzUpm2K4WK8Y0PkgSFQrVEdxKHjYTe5v2sRRajVXKYLM_m_nHhBJ0wV7SRIEmKor7ZnYftviItSTQiQbS1jokFJPMyx_7Tnr_txXoijwS9RAkEe0JByliu5_s3AVPkH_gmyKmKsG-I40CQ71HoNtVZdk9PS9tOeKXp-xsw-s_oaKWLhIlHzfvclQmCODkqWbkPfNAhy9n2DcYtSH-X-VQBvZjYAyLP80pqlM1S0o4hT1hy9BMlMWOqaW9GyXpZQM8K8YZpe-Esm7WP_zP7ZUoSsa_SNHtjIjfWPL_OP-bVCbmgQACW0D5ponR-MCO6nvplIKJ_Ls_yYsWHmd43vllFvf_Wp3oC9njhuCNsoowTnHYsX96BOIUxDjmbKcdYZOw', '2026-02-17 11:55:57', '2026-02-20 05:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_facilities`
--

CREATE TABLE `customer_facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `api_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `suburb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trading_hours` json DEFAULT NULL,
  `facility_features` json DEFAULT NULL,
  `custom_fields` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_facilities`
--

INSERT INTO `customer_facilities` (`id`, `api_id`, `user_id`, `code`, `is_active`, `group`, `name`, `short_name`, `company_name`, `business_name`, `phone`, `email`, `address`, `suburb`, `city`, `region`, `region_code`, `country_code`, `post_code`, `latitude`, `longitude`, `trading_hours`, `facility_features`, `custom_fields`, `created_at`, `updated_at`) VALUES
(1, '562', 24, 'YOUS2', 1, NULL, 'Your Storage Co 2 - Hillsdale', 'Hillsdale', 'Your Storage Co', 'StorNow Digital', '02 9432 2880', 'support@stornowdigital.com', '24 Perkins St', 'Hillsdale', '', 'NSW', 'NSW', 'AU', '2580', '0', '0', '{\"accessHours\": {\"friday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"tuesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"thursday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}}, \"officeHours\": {\"friday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": true}, \"tuesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": true}, \"thursday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}}, \"nonTradingDays\": [{\"date\": \"2022-01-01\", \"name\": \"New Years Day\"}, {\"date\": \"2021-12-25\", \"name\": \"Christmas Day\"}, {\"date\": \"2021-12-26\", \"name\": \"Boxing Day\"}]}', '[{\"is_active\": 1, \"sort_order\": 1, \"feature_name\": \"SNC-Camera Surveillance\", \"feature_shortname\": \"Camera Surveillance\"}, {\"is_active\": 1, \"sort_order\": 2, \"feature_name\": \"SNC-24/7 Access\", \"feature_shortname\": \"24/7 Access\"}, {\"is_active\": 1, \"sort_order\": 4, \"feature_name\": \"SNC-Easy Sign Up\", \"feature_shortname\": \"Easy Sign Up\"}, {\"is_active\": 1, \"sort_order\": 3, \"feature_name\": \"SNC-Family Owned\", \"feature_shortname\": \"Family Owned\"}, {\"is_active\": 1, \"sort_order\": 5, \"feature_name\": \"SNC-Free Move In*\", \"feature_shortname\": \"Free Move In*\"}, {\"is_active\": 1, \"sort_order\": 6, \"feature_name\": \"SNC-Storage Experts\", \"feature_shortname\": \"Storage Experts\"}, {\"is_active\": 1, \"sort_order\": 8, \"feature_name\": \"SNC-Free Trailer Hire*\", \"feature_shortname\": \"Free Trailer Hire*\"}, {\"is_active\": 1, \"sort_order\": 9, \"feature_name\": \"SNC-Variety Of Sizes\", \"feature_shortname\": \"Variety Of Sizes\"}, {\"is_active\": 1, \"sort_order\": 10, \"feature_name\": \"SNC-Convenient Locations\", \"feature_shortname\": \"Convenient Locations\"}, {\"is_active\": 1, \"sort_order\": 11, \"feature_name\": \"SNC-Short or Long Term\", \"feature_shortname\": \"Short or Long Term\"}, {\"is_active\": 1, \"sort_order\": 16, \"feature_name\": \"SNC-Free Truck Hire*\", \"feature_shortname\": \"Free Truck Hire*\"}, {\"is_active\": 1, \"sort_order\": 15, \"feature_name\": \"SNC-7 Days Access\", \"feature_shortname\": \"7 Days Access\"}, {\"is_active\": 1, \"sort_order\": 14, \"feature_name\": \"SNC-Insurance Available\", \"feature_shortname\": \"Insurance Available\"}, {\"is_active\": 1, \"sort_order\": 13, \"feature_name\": \"SNC-High Security\", \"feature_shortname\": \"High Security\"}]', '[{\"field_name\": \"SNF-PIN Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF- Pest Control\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-High Security\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Various Sizes\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-24/7 Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Camera Surveillance\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-7 Days Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Truck Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Trailer Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Box Shop\", \"field_value\": \"1\"}]', '2026-02-17 12:17:25', '2026-02-18 02:45:17'),
(2, '561', 24, 'YOUST', 1, NULL, 'Your Storage Co - Oakdale', 'Oakdale', 'Your Storage Co', 'StorNow Digital', '02 9432 2880', 'support@stornowdigital.com', '25 Park Dr', 'Oakdale', '', 'NSW', 'NSW', 'AU', '2283', '0', '0', '{\"accessHours\": {\"friday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"tuesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"thursday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}}, \"officeHours\": {\"friday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": true, \"open_by_appointment\": false}, \"tuesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": true, \"open_by_appointment\": false}, \"thursday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}}, \"nonTradingDays\": [{\"date\": \"2022-01-01\", \"name\": \"New Years Day\"}, {\"date\": \"2021-12-25\", \"name\": \"Christmas Day\"}, {\"date\": \"2021-12-26\", \"name\": \"Boxing Day\"}]}', '[{\"is_active\": 1, \"sort_order\": 1, \"feature_name\": \"SNC-Camera Surveillance\", \"feature_shortname\": \"Camera Surveillance\"}, {\"is_active\": 1, \"sort_order\": 2, \"feature_name\": \"SNC-24/7 Access\", \"feature_shortname\": \"24/7 Access\"}, {\"is_active\": 1, \"sort_order\": 3, \"feature_name\": \"SNC-Family Owned\", \"feature_shortname\": \"Family Owned\"}, {\"is_active\": 1, \"sort_order\": 4, \"feature_name\": \"SNC-Easy Sign Up\", \"feature_shortname\": \"Easy Sign Up\"}, {\"is_active\": 1, \"sort_order\": 5, \"feature_name\": \"SNC-Free Move In*\", \"feature_shortname\": \"Free Move In*\"}, {\"is_active\": 1, \"sort_order\": 6, \"feature_name\": \"SNC-Storage Experts\", \"feature_shortname\": \"Storage Experts\"}, {\"is_active\": 1, \"sort_order\": 8, \"feature_name\": \"SNC-Free Trailer Hire*\", \"feature_shortname\": \"Free Trailer Hire*\"}, {\"is_active\": 1, \"sort_order\": 9, \"feature_name\": \"SNC-Variety Of Sizes\", \"feature_shortname\": \"Variety Of Sizes\"}, {\"is_active\": 1, \"sort_order\": 10, \"feature_name\": \"SNC-Convenient Locations\", \"feature_shortname\": \"Convenient Locations\"}, {\"is_active\": 1, \"sort_order\": 11, \"feature_name\": \"SNC-Short or Long Term\", \"feature_shortname\": \"Short or Long Term\"}, {\"is_active\": 1, \"sort_order\": 13, \"feature_name\": \"SNC-High Security\", \"feature_shortname\": \"High Security\"}, {\"is_active\": 1, \"sort_order\": 14, \"feature_name\": \"SNC-Insurance Available\", \"feature_shortname\": \"Insurance Available\"}, {\"is_active\": 1, \"sort_order\": 15, \"feature_name\": \"SNC-7 Days Access\", \"feature_shortname\": \"7 Days Access\"}, {\"is_active\": 1, \"sort_order\": 16, \"feature_name\": \"SNC-Free Truck Hire*\", \"feature_shortname\": \"Free Truck Hire*\"}, {\"is_active\": 1, \"sort_order\": 50, \"feature_name\": \"SMC-Mobile Delivery\", \"feature_shortname\": \"Pods stored at delivery address then picked up\"}, {\"is_active\": 1, \"sort_order\": 50, \"feature_name\": \"SMC-Mobile Stored\", \"feature_shortname\": \"Pods dropped off & stored at depot\"}, {\"is_active\": 1, \"sort_order\": 50, \"feature_name\": \"SMC-Mobile Redelivery\", \"feature_shortname\": \"Pod delivered to separate address\"}]', '[{\"field_name\": \"SNF-PIN Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF- Pest Control\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-High Security\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-24/7 Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Camera Surveillance\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-7 Days Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Truck Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Trailer Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Box Shop\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Various Sizes\", \"field_value\": \"1\"}]', '2026-02-17 12:17:25', '2026-02-18 02:45:17'),
(3, '562', 23, 'YOUS2', 1, NULL, 'Your Storage Co 2 - Hillsdale', 'Hillsdale', 'Your Storage Co', 'StorNow Digital', '02 9432 2880', 'support@stornowdigital.com', '24 Perkins St', 'Hillsdale', '', 'NSW', 'NSW', 'AU', '2580', '0', '0', '{\"accessHours\": {\"friday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"tuesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"thursday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}}, \"officeHours\": {\"friday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": true}, \"tuesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": true}, \"thursday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}}, \"nonTradingDays\": [{\"date\": \"2022-01-01\", \"name\": \"New Years Day\"}, {\"date\": \"2021-12-25\", \"name\": \"Christmas Day\"}, {\"date\": \"2021-12-26\", \"name\": \"Boxing Day\"}]}', '[{\"is_active\": 1, \"sort_order\": 1, \"feature_name\": \"SNC-Camera Surveillance\", \"feature_shortname\": \"Camera Surveillance\"}, {\"is_active\": 1, \"sort_order\": 2, \"feature_name\": \"SNC-24/7 Access\", \"feature_shortname\": \"24/7 Access\"}, {\"is_active\": 1, \"sort_order\": 4, \"feature_name\": \"SNC-Easy Sign Up\", \"feature_shortname\": \"Easy Sign Up\"}, {\"is_active\": 1, \"sort_order\": 3, \"feature_name\": \"SNC-Family Owned\", \"feature_shortname\": \"Family Owned\"}, {\"is_active\": 1, \"sort_order\": 5, \"feature_name\": \"SNC-Free Move In*\", \"feature_shortname\": \"Free Move In*\"}, {\"is_active\": 1, \"sort_order\": 6, \"feature_name\": \"SNC-Storage Experts\", \"feature_shortname\": \"Storage Experts\"}, {\"is_active\": 1, \"sort_order\": 8, \"feature_name\": \"SNC-Free Trailer Hire*\", \"feature_shortname\": \"Free Trailer Hire*\"}, {\"is_active\": 1, \"sort_order\": 9, \"feature_name\": \"SNC-Variety Of Sizes\", \"feature_shortname\": \"Variety Of Sizes\"}, {\"is_active\": 1, \"sort_order\": 10, \"feature_name\": \"SNC-Convenient Locations\", \"feature_shortname\": \"Convenient Locations\"}, {\"is_active\": 1, \"sort_order\": 11, \"feature_name\": \"SNC-Short or Long Term\", \"feature_shortname\": \"Short or Long Term\"}, {\"is_active\": 1, \"sort_order\": 16, \"feature_name\": \"SNC-Free Truck Hire*\", \"feature_shortname\": \"Free Truck Hire*\"}, {\"is_active\": 1, \"sort_order\": 15, \"feature_name\": \"SNC-7 Days Access\", \"feature_shortname\": \"7 Days Access\"}, {\"is_active\": 1, \"sort_order\": 14, \"feature_name\": \"SNC-Insurance Available\", \"feature_shortname\": \"Insurance Available\"}, {\"is_active\": 1, \"sort_order\": 13, \"feature_name\": \"SNC-High Security\", \"feature_shortname\": \"High Security\"}]', '[{\"field_name\": \"SNF-PIN Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF- Pest Control\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-High Security\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Various Sizes\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-24/7 Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Camera Surveillance\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-7 Days Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Truck Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Trailer Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Box Shop\", \"field_value\": \"1\"}]', '2026-02-23 02:47:06', '2026-02-23 02:47:06'),
(4, '561', 23, 'YOUST', 1, NULL, 'Your Storage Co - Oakdale', 'Oakdale', 'Your Storage Co', 'StorNow Digital', '02 9432 2880', 'support@stornowdigital.com', '25 Park Dr', 'Oakdale', '', 'NSW', 'NSW', 'AU', '2283', '0', '0', '{\"accessHours\": {\"friday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"tuesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"thursday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"23:59\", \"from\": \"00:00\", \"closed\": false, \"24_hour_access\": false, \"open_by_appointment\": false}}, \"officeHours\": {\"friday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"monday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"sunday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": true, \"open_by_appointment\": false}, \"tuesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"saturday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": true, \"open_by_appointment\": false}, \"thursday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}, \"wednesday\": {\"to\": \"17:00\", \"from\": \"08:00\", \"closed\": false, \"open_by_appointment\": false}}, \"nonTradingDays\": [{\"date\": \"2022-01-01\", \"name\": \"New Years Day\"}, {\"date\": \"2021-12-25\", \"name\": \"Christmas Day\"}, {\"date\": \"2021-12-26\", \"name\": \"Boxing Day\"}]}', '[{\"is_active\": 1, \"sort_order\": 1, \"feature_name\": \"SNC-Camera Surveillance\", \"feature_shortname\": \"Camera Surveillance\"}, {\"is_active\": 1, \"sort_order\": 2, \"feature_name\": \"SNC-24/7 Access\", \"feature_shortname\": \"24/7 Access\"}, {\"is_active\": 1, \"sort_order\": 3, \"feature_name\": \"SNC-Family Owned\", \"feature_shortname\": \"Family Owned\"}, {\"is_active\": 1, \"sort_order\": 4, \"feature_name\": \"SNC-Easy Sign Up\", \"feature_shortname\": \"Easy Sign Up\"}, {\"is_active\": 1, \"sort_order\": 5, \"feature_name\": \"SNC-Free Move In*\", \"feature_shortname\": \"Free Move In*\"}, {\"is_active\": 1, \"sort_order\": 6, \"feature_name\": \"SNC-Storage Experts\", \"feature_shortname\": \"Storage Experts\"}, {\"is_active\": 1, \"sort_order\": 8, \"feature_name\": \"SNC-Free Trailer Hire*\", \"feature_shortname\": \"Free Trailer Hire*\"}, {\"is_active\": 1, \"sort_order\": 9, \"feature_name\": \"SNC-Variety Of Sizes\", \"feature_shortname\": \"Variety Of Sizes\"}, {\"is_active\": 1, \"sort_order\": 10, \"feature_name\": \"SNC-Convenient Locations\", \"feature_shortname\": \"Convenient Locations\"}, {\"is_active\": 1, \"sort_order\": 11, \"feature_name\": \"SNC-Short or Long Term\", \"feature_shortname\": \"Short or Long Term\"}, {\"is_active\": 1, \"sort_order\": 13, \"feature_name\": \"SNC-High Security\", \"feature_shortname\": \"High Security\"}, {\"is_active\": 1, \"sort_order\": 14, \"feature_name\": \"SNC-Insurance Available\", \"feature_shortname\": \"Insurance Available\"}, {\"is_active\": 1, \"sort_order\": 15, \"feature_name\": \"SNC-7 Days Access\", \"feature_shortname\": \"7 Days Access\"}, {\"is_active\": 1, \"sort_order\": 16, \"feature_name\": \"SNC-Free Truck Hire*\", \"feature_shortname\": \"Free Truck Hire*\"}, {\"is_active\": 1, \"sort_order\": 50, \"feature_name\": \"SMC-Mobile Delivery\", \"feature_shortname\": \"Pods stored at delivery address then picked up\"}, {\"is_active\": 1, \"sort_order\": 50, \"feature_name\": \"SMC-Mobile Stored\", \"feature_shortname\": \"Pods dropped off & stored at depot\"}, {\"is_active\": 1, \"sort_order\": 50, \"feature_name\": \"SMC-Mobile Redelivery\", \"feature_shortname\": \"Pod delivered to separate address\"}]', '[{\"field_name\": \"SNF-PIN Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF- Pest Control\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-High Security\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-24/7 Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Camera Surveillance\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-7 Days Access\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Truck Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Free Trailer Hire*\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Box Shop\", \"field_value\": \"1\"}, {\"field_name\": \"SNF-Various Sizes\", \"field_value\": \"1\"}]', '2026-02-23 02:47:06', '2026-02-23 02:47:06');

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
(4, '2026_02_02_065302_create_permission_tables', 2),
(5, '2026_01_30_104208_create_companies_table', 3),
(6, '2026_01_30_104250_add_company_fields_to_users_table', 3),
(7, '2026_02_02_070814_create_admin_company_table', 4),
(8, '2026_02_05_043213_add_company_id_to_roles_table', 5),
(9, '2026_02_06_084616_add_owner_user_id_to_permissions_table', 6),
(10, '2026_02_06_111126_add_columns_to_permissions_table', 7),
(11, '2026_02_11_042912_create_customer_facilities_table', 8),
(12, '2026_02_11_111940_add_last_sync_storman_to_users_table', 9),
(13, '2026_02_17_083344_add_missing_fields_to_companies_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 22),
(5, 'App\\Models\\User', 22),
(8, 'App\\Models\\User', 22),
(9, 'App\\Models\\User', 22),
(10, 'App\\Models\\User', 22),
(1, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 23),
(10, 'App\\Models\\User', 23),
(1, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 24),
(5, 'App\\Models\\User', 24),
(8, 'App\\Models\\User', 24),
(9, 'App\\Models\\User', 24),
(10, 'App\\Models\\User', 24);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `owner_user_id`, `created_at`, `updated_at`, `module`, `action`) VALUES
(1, 'super.users.view', 'web', NULL, '2026-02-15 22:48:58', '2026-02-15 22:48:58', NULL, NULL),
(2, 'super.users.create', 'web', NULL, '2026-02-15 22:49:03', '2026-02-15 22:49:03', NULL, NULL),
(3, 'super.users.edit', 'web', NULL, '2026-02-15 22:49:10', '2026-02-15 22:49:10', NULL, NULL),
(4, 'super.companies.view', 'web', NULL, '2026-02-15 22:49:15', '2026-02-15 22:49:15', NULL, NULL),
(5, 'super.companies.create', 'web', NULL, '2026-02-15 22:49:23', '2026-02-15 22:49:23', NULL, NULL),
(8, 'super.companies.edit', 'web', NULL, '2026-02-16 04:59:05', '2026-02-16 04:59:05', NULL, NULL),
(9, 'super.companies.delete', 'web', NULL, '2026-02-16 05:41:30', '2026-02-16 05:41:30', NULL, NULL),
(10, 'super.users.delete', 'web', NULL, '2026-02-16 21:24:43', '2026-02-16 21:24:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `company_user_id`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', NULL, '2026-02-02 01:56:39', '2026-02-02 01:56:39'),
(2, 'admin', 'web', NULL, '2026-02-02 01:56:39', '2026-02-02 01:56:39'),
(3, 'company', 'web', NULL, '2026-02-02 01:56:39', '2026-02-02 01:56:39'),
(4, 'staff', 'web', NULL, '2026-02-02 01:56:39', '2026-02-02 01:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_user_id` bigint UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_data_sync` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `parent_user_id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `last_data_sync`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Super Admin', '', 'superadmin@admin.com', NULL, '$2y$12$XQx1HSemebtyue8qyLk/P.r8fPEgCsQy5J1MIweBjBIGc7dOn.Zgi', 'active', NULL, NULL, NULL, '2026-02-02 01:56:40', '2026-02-02 04:43:52', NULL),
(22, NULL, 'Store Staff', '', 'staff@admin.com', NULL, '$2y$12$PuKOR2YlZeD6s7Z8YhtysuszpNJhJqZkrX3mG1UDqhaESkNFUd1LS', 'active', NULL, NULL, NULL, '2026-02-04 11:28:23', '2026-02-04 11:28:23', NULL),
(23, NULL, 'Storage Company', '', 'storagecompany@test.com', NULL, '$2y$12$rKTJ1IWn12phKrSy3lmTZuvv4ZVQ0VykdzmibACp35xyXUSokY9M2', 'active', NULL, '2026-02-23 02:47:06', NULL, '2026-02-04 11:30:34', '2026-02-23 02:47:06', NULL),
(24, NULL, 'Vimal', 'Darji', 'vimal@webential.com.au', NULL, '$2y$12$7i0aXnYFA4vcoHPFcNG5Tuy5cvHyBZe4wu6AHmSv2C1ANMaa7OAOm', 'active', NULL, '2026-02-18 02:45:17', NULL, '2026-02-17 11:55:57', '2026-02-20 05:36:32', NULL),
(25, 24, 'Rupesh', 'Jadhav', 'rupesh.wtech@gmail.com', NULL, '$2y$12$mTExj/QJYL66Ad94.x.4kOmeYjNYOtvReLmbsMI/yNufwHOAuYiQq', 'active', NULL, NULL, NULL, '2026-02-17 12:18:06', '2026-02-17 12:18:06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_company`
--
ALTER TABLE `admin_company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_company_admin_user_id_company_id_unique` (`admin_user_id`,`company_id`),
  ADD KEY `admin_company_company_id_foreign` (`company_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_slug_unique` (`slug`);

--
-- Indexes for table `customer_facilities`
--
ALTER TABLE `customer_facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_facilities_user_id_code_unique` (`user_id`,`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_owner_user_id_index` (`owner_user_id`),
  ADD KEY `permissions_module_index` (`module`),
  ADD KEY `permissions_action_index` (`action`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_company_user_id_index` (`company_user_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_company`
--
ALTER TABLE `admin_company`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_facilities`
--
ALTER TABLE `customer_facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_company`
--
ALTER TABLE `admin_company`
  ADD CONSTRAINT `admin_company_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_company_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_facilities`
--
ALTER TABLE `customer_facilities`
  ADD CONSTRAINT `customer_facilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
