-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 13, 2026 lúc 01:53 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `du_an_agile`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `booking_type` enum('class','pt_session') COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_id` bigint UNSIGNED DEFAULT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('confirmed','cancelled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkins`
--

CREATE TABLE `checkins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `qr_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Token QR động (UUID hoặc JWT ngắn hạn)',
  `expires_at` datetime NOT NULL,
  `checked_in_at` datetime DEFAULT NULL,
  `status` enum('active','used','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipments`
--

CREATE TABLE `equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','maintenance','broken') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_maintained_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `equipments`
--

INSERT INTO `equipments` (`id`, `name`, `description`, `status`, `last_maintained_at`, `created_at`, `updated_at`) VALUES
(1, 'Máy chạy bộ Matrix T50', 'Máy chạy bộ cao cấp cho khu vực cardio', 'active', '2026-03-01', '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(2, 'Xe đạp tập Gym Life', 'Xe đạp có màn hình theo dõi nhịp tim', 'active', '2026-03-15', '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(3, 'Giàn tạ đa năng 4 mặt', 'Hệ thống tạ kéo lưng, chân, ngực', 'maintenance', '2026-04-10', '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(4, 'Tạ tay Iron Bull (20kg)', 'Bộ tạ tay cao su cao cấp', 'active', NULL, '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(5, 'Thảm tập Yoga Reebok', 'Thảm chống trượt 6mm', 'active', NULL, '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(6, 'Bóng tập Gym Ball 65cm', 'Sử dụng cho các bài tập core', 'broken', '2026-04-12', '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(7, 'Máy ép ngực thủy lực', 'Máy chuyên dụng tập cơ ngực', 'active', '2026-02-20', '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(8, 'Gậy tập Pilates', 'Dụng cụ hỗ trợ giữ thăng bằng', 'active', NULL, '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(9, 'Dây kháng lực TRX', 'Dụng cụ tập luyện treo người', 'active', '2026-04-01', '2026-04-13 12:39:19', '2026-04-13 12:39:19'),
(10, 'Máy kéo xô King Fitness', 'Thiết bị tập cơ lưng xô chuyên nghiệp', 'active', '2026-03-20', '2026-04-13 12:39:19', '2026-04-13 12:39:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `health_metrics`
--

CREATE TABLE `health_metrics` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `weight` double(8,2) NOT NULL COMMENT 'Cân nặng (kg)',
  `bmi` double(8,2) NOT NULL COMMENT 'Chỉ số BMI',
  `fat_percent` double(8,2) DEFAULT NULL COMMENT 'Phần trăm mỡ (%)',
  `recorded_by` enum('user','trainer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'trainer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên gói (VD: Gym Cơ Bản, Yoga 1 Tháng)',
  `category` enum('gym','yoga') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại gói: thể hình hoặc yoga',
  `description` text COLLATE utf8mb4_unicode_ci,
  `duration_days` int NOT NULL COMMENT 'Số ngày hiệu lực',
  `price` decimal(12,2) NOT NULL COMMENT 'Giá cố định',
  `allow_pt` tinyint NOT NULL DEFAULT '0' COMMENT 'Gói có kèm PT không',
  `pt_sessions` int NOT NULL DEFAULT '0' COMMENT 'Số buổi PT đi kèm (nếu có)',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `category`, `description`, `duration_days`, `price`, `allow_pt`, `pt_sessions`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Gym 1 Tháng', 'gym', 'Tập tự do khu thể hình, không PT', 30, 300000.00, 0, 0, 1, '2026-04-02 22:34:26', '2026-04-02 22:34:26'),
(2, 'Gym 1 Tháng + 4 Buổi PT', 'gym', 'Tập tự do + 4 buổi hướng dẫn cùng PT', 30, 800000.00, 1, 4, 1, '2026-04-02 22:34:26', '2026-04-02 22:34:26'),
(3, 'Gym 1 Tháng + 12 Buổi PT', 'gym', 'Tập tự do + 12 buổi PT, ưu tiên đặt lịch', 30, 1500000.00, 1, 12, 1, '2026-04-02 22:34:26', '2026-04-02 22:34:26'),
(4, 'Yoga 1 Tháng', 'yoga', 'Tham gia không giới hạn lớp yoga trong tháng', 30, 350000.00, 0, 0, 1, '2026-04-02 22:34:26', '2026-04-02 22:34:26'),
(5, 'Yoga 1 Tháng + 4 Buổi PT', 'yoga', 'Lớp yoga + 4 buổi tập riêng cùng HLV yoga', 30, 900000.00, 1, 4, 1, '2026-04-02 22:34:26', '2026-04-02 22:34:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_02_164013_create_memberships_table', 1),
(6, '2026_04_03_000001_create_trainers_table', 2),
(7, '2026_04_03_000002_create_subscriptions_table', 2),
(8, '2026_04_03_000003_create_payments_table', 2),
(9, '2026_04_03_000004_create_schedules_table', 2),
(10, '2026_04_03_000005_create_bookings_table', 2),
(11, '2026_04_03_000006_create_checkins_table', 2),
(12, '2026_04_03_000007_create_equipments_table', 2),
(13, '2026_04_03_000008_create_reviews_table', 2),
(14, '2026_04_03_000009_create_notifications_table', 2),
(15, '2026_04_03_000010_create_news_table', 2),
(16, '2026_04_03_000011_create_support_tickets_table', 2),
(17, '2026_04_11_125943_add_missing_fields_to_users_table', 3),
(22, '2026_04_03_000002_create_subscriptions_table', 3),
(23, '2026_04_03_000003_create_payments_table', 3),
(24, '2026_04_03_000004_create_schedules_table', 3),
(25, '2026_04_03_000005_create_bookings_table', 3),
(26, '2026_04_03_000006_create_checkins_table', 3),
(27, '2026_04_03_000007_create_equipments_table', 3),
(28, '2026_04_03_000008_create_reviews_table', 3),
(29, '2026_04_03_000009_create_notifications_table', 3),
(30, '2026_04_03_000010_create_news_table', 3),
(31, '2026_04_03_000011_create_support_tickets_table', 3),
(32, '2026_04_11_125943_add_missing_fields_to_users_table', 3),
(33, '2026_04_11_152054_add_height_to_users_table', 4),
(34, '2026_04_11_152055_create_health_metrics_table', 4),
(35, '2026_04_11_152055_create_reschedule_requests_table', 4),
(36, '2026_04_11_152055_create_session_reports_table', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `category` enum('news','event','announcement') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'news',
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('system','reminder','booking','payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'system',
  `is_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` enum('cash','transfer','e_wallet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `invoice_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã hóa đơn tự sinh',
  `note` text COLLATE utf8mb4_unicode_ci,
  `confirmed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `subscription_id`, `amount`, `method`, `status`, `invoice_code`, `note`, `confirmed_by`, `created_at`, `updated_at`) VALUES
(1, 2, 900000.00, 'e_wallet', 'pending', 'VNP1776087760', NULL, NULL, '2026-04-13 13:42:40', '2026-04-13 13:42:40'),
(2, 3, 900000.00, 'e_wallet', 'pending', 'VNP1776087996', NULL, NULL, '2026-04-13 13:46:36', '2026-04-13 13:46:36'),
(3, 4, 900000.00, 'e_wallet', 'pending', 'VNP1776088052', NULL, NULL, '2026-04-13 13:47:32', '2026-04-13 13:47:32'),
(4, 5, 900000.00, 'e_wallet', 'completed', 'VNP1776088131', NULL, NULL, '2026-04-13 13:48:51', '2026-04-13 13:49:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reschedule_requests`
--

CREATE TABLE `reschedule_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `requested_by` bigint UNSIGNED NOT NULL,
  `original_start_time` datetime NOT NULL,
  `new_start_time` datetime NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `rating` int NOT NULL COMMENT '1-5 sao',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('gym','yoga') COLLATE utf8mb4_unicode_ci NOT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `capacity` int NOT NULL DEFAULT '20',
  `current_enrolled` int NOT NULL DEFAULT '0',
  `status` enum('upcoming','ongoing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `schedules`
--

INSERT INTO `schedules` (`id`, `title`, `category`, `trainer_id`, `start_time`, `end_time`, `capacity`, `current_enrolled`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Body Building', 'gym', 1, '2026-04-07 19:00:00', '2026-04-07 20:00:00', 20, 11, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(2, 'Body Building', 'gym', 1, '2026-04-09 10:00:00', '2026-04-09 11:00:00', 20, 9, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(3, 'Body Building', 'gym', 1, '2026-04-11 13:00:00', '2026-04-11 14:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(4, 'Body Building', 'gym', 1, '2026-04-10 19:00:00', '2026-04-10 20:00:00', 20, 11, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(5, 'Core Strength', 'gym', 1, '2026-04-10 14:00:00', '2026-04-10 15:00:00', 20, 16, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(6, 'Power Lifting', 'gym', 1, '2026-04-07 13:00:00', '2026-04-07 14:00:00', 20, 6, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(7, 'Power Lifting', 'gym', 1, '2026-04-07 06:00:00', '2026-04-07 07:00:00', 20, 14, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(8, 'Body Building', 'gym', 1, '2026-04-07 18:00:00', '2026-04-07 19:00:00', 20, 15, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(9, 'Body Building', 'gym', 1, '2026-04-08 11:00:00', '2026-04-08 12:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(10, 'HIIT Cardio', 'gym', 1, '2026-04-12 19:00:00', '2026-04-12 20:00:00', 20, 8, 'upcoming', '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(11, 'Power Yoga', 'yoga', 2, '2026-04-06 07:00:00', '2026-04-06 08:00:00', 20, 14, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(12, 'Power Yoga', 'yoga', 2, '2026-04-09 06:00:00', '2026-04-09 07:00:00', 20, 8, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(13, 'Hatha Yoga', 'yoga', 2, '2026-04-06 13:00:00', '2026-04-06 14:00:00', 20, 11, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(14, 'Power Yoga', 'yoga', 2, '2026-04-10 10:00:00', '2026-04-10 11:00:00', 20, 10, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(15, 'Meditation', 'yoga', 2, '2026-04-08 10:00:00', '2026-04-08 11:00:00', 20, 12, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(16, 'Hatha Yoga', 'yoga', 2, '2026-04-10 17:00:00', '2026-04-10 18:00:00', 20, 12, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(17, 'Hatha Yoga', 'yoga', 2, '2026-04-08 16:00:00', '2026-04-08 17:00:00', 20, 13, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(18, 'Hatha Yoga', 'yoga', 2, '2026-04-07 12:00:00', '2026-04-07 13:00:00', 20, 16, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(19, 'Meditation', 'yoga', 2, '2026-04-11 14:00:00', '2026-04-11 15:00:00', 20, 15, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(20, 'Vinyasa Flow', 'yoga', 2, '2026-04-08 14:00:00', '2026-04-08 15:00:00', 20, 12, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(21, 'Body Building', 'gym', 3, '2026-04-12 17:00:00', '2026-04-12 18:00:00', 20, 18, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(22, 'Body Building', 'gym', 3, '2026-04-09 07:00:00', '2026-04-09 08:00:00', 20, 13, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(23, 'Body Building', 'gym', 3, '2026-04-08 12:00:00', '2026-04-08 13:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(24, 'Core Strength', 'gym', 3, '2026-04-07 16:00:00', '2026-04-07 17:00:00', 20, 12, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(25, 'HIIT Cardio', 'gym', 3, '2026-04-07 09:00:00', '2026-04-07 10:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(26, 'Core Strength', 'gym', 3, '2026-04-07 06:00:00', '2026-04-07 07:00:00', 20, 7, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(27, 'Power Lifting', 'gym', 3, '2026-04-12 09:00:00', '2026-04-12 10:00:00', 20, 13, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(28, 'Power Lifting', 'gym', 3, '2026-04-10 11:00:00', '2026-04-10 12:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(29, 'Body Building', 'gym', 3, '2026-04-07 15:00:00', '2026-04-07 16:00:00', 20, 8, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(30, 'HIIT Cardio', 'gym', 3, '2026-04-06 18:00:00', '2026-04-06 19:00:00', 20, 18, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(31, 'CrossFit', 'gym', 4, '2026-04-08 10:00:00', '2026-04-08 11:00:00', 20, 11, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(32, 'Zumba Dance', 'gym', 4, '2026-04-08 16:00:00', '2026-04-08 17:00:00', 20, 16, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(33, 'Yoga Recovery', 'gym', 4, '2026-04-07 16:00:00', '2026-04-07 17:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(34, 'Zumba Dance', 'yoga', 4, '2026-04-10 17:00:00', '2026-04-10 18:00:00', 20, 17, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(35, 'Kick Boxing', 'gym', 4, '2026-04-12 09:00:00', '2026-04-12 10:00:00', 20, 15, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(36, 'CrossFit', 'yoga', 4, '2026-04-12 10:00:00', '2026-04-12 11:00:00', 20, 16, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(37, 'Yoga Recovery', 'gym', 4, '2026-04-08 18:00:00', '2026-04-08 19:00:00', 20, 10, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(38, 'Kick Boxing', 'gym', 4, '2026-04-09 09:00:00', '2026-04-09 10:00:00', 20, 7, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(39, 'Yoga Recovery', 'gym', 4, '2026-04-11 12:00:00', '2026-04-11 13:00:00', 20, 9, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(40, 'Zumba Dance', 'yoga', 4, '2026-04-11 08:00:00', '2026-04-11 09:00:00', 20, 14, 'upcoming', '2026-04-10 23:00:40', '2026-04-10 23:00:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `session_reports`
--

CREATE TABLE `session_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Nhận xét của PT',
  `effort_rating` int DEFAULT NULL COMMENT 'Đánh giá nỗ lực (1-10)',
  `session_intensity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Cường độ buổi tập (Low, Medium, High)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `membership_id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `final_price` decimal(12,2) NOT NULL COMMENT 'Giá thực tế khi đăng ký',
  `pt_sessions_left` int NOT NULL DEFAULT '0' COMMENT 'Số buổi PT còn lại',
  `status` enum('pending_payment','active','expired','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_payment',
  `cancel_reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `membership_id`, `trainer_id`, `start_date`, `end_date`, `final_price`, `pt_sessions_left`, `status`, `cancel_reason`, `cancelled_at`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 1, '2026-04-06', '2026-05-06', 800000.00, 4, 'active', NULL, NULL, '2026-04-11 09:18:46', '2026-04-11 09:18:46'),
(2, 3, 5, NULL, '2026-04-13', '2026-05-13', 900000.00, 4, 'pending_payment', NULL, NULL, '2026-04-13 13:42:40', '2026-04-13 13:42:40'),
(3, 3, 5, NULL, '2026-04-13', '2026-05-13', 900000.00, 4, 'pending_payment', NULL, NULL, '2026-04-13 13:46:36', '2026-04-13 13:46:36'),
(4, 3, 5, NULL, '2026-04-13', '2026-05-13', 900000.00, 4, 'pending_payment', NULL, NULL, '2026-04-13 13:47:32', '2026-04-13 13:47:32'),
(5, 3, 5, NULL, '2026-04-13', '2026-06-12', 900000.00, 4, 'active', NULL, NULL, '2026-04-13 13:48:51', '2026-04-13 13:50:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `status` enum('open','in_progress','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trainers`
--

CREATE TABLE `trainers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `specialization` enum('gym','yoga','both') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Chuyên môn: thể hình / yoga / cả hai',
  `is_available` tinyint NOT NULL DEFAULT '1' COMMENT 'Đang nhận học viên',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trainers`
--

INSERT INTO `trainers` (`id`, `user_id`, `specialization`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 5, 'gym', 1, '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(2, 6, 'yoga', 1, '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(3, 7, 'gym', 1, '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(4, 8, 'both', 1, '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(5, 9, 'both', 1, '2026-04-11 07:15:38', '2026-04-11 07:15:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` double(8,2) DEFAULT NULL COMMENT 'Chiều cao (cm)',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user' COMMENT 'Vai trò: user, staff, admin, trainer',
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `height`, `role`, `avatar_url`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, NULL, 'admin', NULL, 1, '2026-04-02 23:29:21', '$2y$10$MqY5/tj7e4DNoJFUl/1i/e370wPOCEuy1.s/2ZRvWId0CNN2LxmTi', NULL, '2026-04-02 22:34:25', '2026-04-02 23:33:11'),
(2, 'Client Test', 'client@gmail.com', NULL, NULL, 'user', NULL, 1, '2026-04-02 23:29:31', '$2y$10$saoAn5zcGuiKVLc8BXL7BeUTDVi899EMrXa4M.JNch2twqU/LdDa2', NULL, '2026-04-02 22:34:26', '2026-04-02 23:29:31'),
(3, 'Đức Anh Nguyễn', 'anp93005@gmail.com', NULL, NULL, 'user', '/storage/avatars/UIbibMtXLrwdzJG9FUcXs4XL7FpZdB7YMVGSSwGm.jpg', 1, NULL, '$2y$10$f6Bx2eC3xqbZQVFAylOcXOBwSMStg2YSgi.B.rv/IRnreK9SoZAqi', NULL, '2026-04-02 22:38:04', '2026-04-13 05:49:55'),
(5, 'Nguyễn Minh Tuấn', 'tuan.gym@extrafit.vn', NULL, NULL, 'trainer', 'https://images.unsplash.com/photo-1567013127542-490d757e51cd?w=500&q=80&auto=format&fit=crop', 1, NULL, '$2y$10$BCxzeYNnkkeVlaoB6HSzneETwgz7E1bIvOC0gfAP8WSuYgp/Sc7vS', NULL, '2026-04-10 23:00:39', '2026-04-10 23:00:39'),
(6, 'Trần Thị Lan', 'lan.yoga@extrafit.vn', NULL, NULL, 'trainer', 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=500&q=80&auto=format&fit=crop', 1, NULL, '$2y$10$lcH2VeGnEXk1J9O6NLtDg.2x6dXJ4yABKU17Um/VmFJZblum8KID.', NULL, '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(7, 'Lê Văn Hùng', 'hung.boxing@extrafit.vn', NULL, NULL, 'trainer', 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop', 1, NULL, '$2y$10$MmPNGEZH18sbO/fqXp35yuMg2eGSsJHzMKWrzwRObEaY8Z/6E5va.', NULL, '2026-04-10 23:00:40', '2026-04-10 23:00:40'),
(8, 'Phạm Thu Hà', 'ha.fitness@extrafit.vn', NULL, NULL, 'trainer', '/storage/avatars/w6zVBxJQZFsSVaX9KerUAB7YKBzhpFtsVBVmKYEP.jpg', 1, NULL, '$2y$10$KDRJEC/qASttEhq/oDSF9OQH08kdel4Dw1X7BoFeY4rVfa8WgCvCC', NULL, '2026-04-10 23:00:40', '2026-04-10 23:38:00'),
(9, 'Phạm Thu Hà', 'thuha12@gmail.com', NULL, NULL, 'trainer', NULL, 1, NULL, '$2y$10$FXaG1uJKtNXpH89MWce6q.241PnZunOUxjhNZy6c5QLe6.XmcrlZm', NULL, '2026-04-11 07:04:49', '2026-04-11 08:27:54'),
(10, 'Phan Đức Tú', 'tubun2@gmail.com', NULL, NULL, 'staff', NULL, 1, NULL, '$2y$10$IalRE7D5bBKEoqRZfqORwOQHB2ijfSFF26CHZHTxlZFz/BtQGi6Vq', NULL, '2026-04-11 07:18:02', '2026-04-11 08:03:49'),
(11, 'Admin User', 'admin@dummy.com', NULL, NULL, 'user', NULL, 1, NULL, '$2y$10$f0OMXD4nD..1k87H/2M.ZOKzaa4L9A.PqBe.SZ0T2OCTZtdWvAOcC', NULL, '2026-04-11 08:46:51', '2026-04-11 08:46:51');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_subscription_id_foreign` (`subscription_id`),
  ADD KEY `bookings_schedule_id_foreign` (`schedule_id`),
  ADD KEY `bookings_trainer_id_foreign` (`trainer_id`);

--
-- Chỉ mục cho bảng `checkins`
--
ALTER TABLE `checkins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `checkins_qr_token_unique` (`qr_token`),
  ADD KEY `checkins_user_id_foreign` (`user_id`),
  ADD KEY `checkins_subscription_id_foreign` (`subscription_id`);

--
-- Chỉ mục cho bảng `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `health_metrics`
--
ALTER TABLE `health_metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `health_metrics_user_id_foreign` (`user_id`),
  ADD KEY `health_metrics_trainer_id_foreign` (`trainer_id`);

--
-- Chỉ mục cho bảng `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_author_id_foreign` (`author_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_subscription_id_foreign` (`subscription_id`),
  ADD KEY `payments_confirmed_by_foreign` (`confirmed_by`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reschedule_requests_booking_id_foreign` (`booking_id`),
  ADD KEY `reschedule_requests_requested_by_foreign` (`requested_by`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_trainer_id_foreign` (`trainer_id`),
  ADD KEY `reviews_booking_id_foreign` (`booking_id`);

--
-- Chỉ mục cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_trainer_id_foreign` (`trainer_id`);

--
-- Chỉ mục cho bảng `session_reports`
--
ALTER TABLE `session_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_reports_booking_id_foreign` (`booking_id`),
  ADD KEY `session_reports_trainer_id_foreign` (`trainer_id`),
  ADD KEY `session_reports_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_membership_id_foreign` (`membership_id`),
  ADD KEY `subscriptions_trainer_id_foreign` (`trainer_id`);

--
-- Chỉ mục cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`),
  ADD KEY `support_tickets_assigned_to_foreign` (`assigned_to`);

--
-- Chỉ mục cho bảng `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainers_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `checkins`
--
ALTER TABLE `checkins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `health_metrics`
--
ALTER TABLE `health_metrics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `session_reports`
--
ALTER TABLE `session_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`),
  ADD CONSTRAINT `bookings_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`),
  ADD CONSTRAINT `bookings_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `checkins`
--
ALTER TABLE `checkins`
  ADD CONSTRAINT `checkins_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`),
  ADD CONSTRAINT `checkins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `health_metrics`
--
ALTER TABLE `health_metrics`
  ADD CONSTRAINT `health_metrics_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `health_metrics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`);

--
-- Các ràng buộc cho bảng `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD CONSTRAINT `reschedule_requests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reschedule_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `reviews_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Các ràng buộc cho bảng `session_reports`
--
ALTER TABLE `session_reports`
  ADD CONSTRAINT `session_reports_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_reports_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`),
  ADD CONSTRAINT `subscriptions_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`),
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
