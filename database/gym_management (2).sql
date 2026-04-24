-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 22, 2026 lúc 01:38 PM
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
-- Cơ sở dữ liệu: `gym_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `booking_type` enum('class','pt_session') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Vùng tập: Tay, Chân, Bụng, Ngực, Lưng, Toàn thân...',
  `schedule_id` bigint UNSIGNED DEFAULT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('free','pending','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `status` enum('confirmed','cancelled','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmed',
  `reschedule_status` enum('none','pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `reschedule_reason` text COLLATE utf8mb4_unicode_ci,
  `reschedule_at` timestamp NULL DEFAULT NULL,
  `report_content` text COLLATE utf8mb4_unicode_ci,
  `effort_rating` int DEFAULT NULL,
  `session_intensity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `subscription_id`, `booking_type`, `target_area`, `schedule_id`, `trainer_id`, `start_time`, `end_time`, `price`, `payment_status`, `status`, `reschedule_status`, `reschedule_reason`, `reschedule_at`, `report_content`, `effort_rating`, `session_intensity`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 'class', NULL, 121, 12, '2026-04-17 08:00:00', '2026-04-17 09:00:00', 0.00, 'free', 'confirmed', 'none', NULL, NULL, NULL, NULL, NULL, '2026-04-15 20:58:20', '2026-04-15 20:58:20'),
(2, 3, 5, 'class', NULL, 45, 9, '2026-04-16 15:00:00', '2026-04-16 16:00:00', 0.00, 'free', 'confirmed', 'none', NULL, NULL, NULL, NULL, NULL, '2026-04-15 21:02:35', '2026-04-15 21:02:35'),
(3, 3, 5, 'pt_session', NULL, NULL, 8, '2026-04-18 17:00:00', '2026-04-18 18:00:00', 0.00, 'free', 'confirmed', 'none', NULL, NULL, NULL, NULL, NULL, '2026-04-17 18:28:28', '2026-04-17 18:28:28'),
(4, 3, 5, 'class', NULL, 59, 9, '2026-04-22 15:00:00', '2026-04-22 16:00:00', 0.00, 'free', 'confirmed', 'none', NULL, NULL, NULL, NULL, NULL, '2026-04-21 16:48:08', '2026-04-21 16:48:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkins`
--

CREATE TABLE `checkins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `qr_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Token QR động (UUID hoặc JWT ngắn hạn)',
  `expires_at` datetime NOT NULL,
  `checked_in_at` datetime DEFAULT NULL,
  `status` enum('active','used','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipments`
--

CREATE TABLE `equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','maintenance','broken') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_maintained_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `equipments`
--

INSERT INTO `equipments` (`id`, `name`, `description`, `status`, `last_maintained_at`, `created_at`, `updated_at`) VALUES
(1, 'Máy chạy bộ Matrix T50', 'Máy chạy bộ cao cấp cho khu vực cardio', 'active', '2026-03-01', '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(2, 'Xe đạp tập Gym Life', 'Xe đạp có màn hình theo dõi nhịp tim', 'active', '2026-03-15', '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(3, 'Giàn tạ đa năng 4 mặt', 'Hệ thống tạ kéo lưng, chân, ngực', 'maintenance', '2026-04-10', '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(4, 'Tạ tay Iron Bull (20kg)', 'Bộ tạ tay cao su cao cấp', 'active', NULL, '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(5, 'Thảm tập Yoga Reebok', 'Thảm chống trượt 6mm', 'active', NULL, '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(6, 'Bóng tập Gym Ball 65cm', 'Sử dụng cho các bài tập core', 'broken', '2026-04-12', '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(7, 'Máy ép ngực thủy lực', 'Máy chuyên dụng tập cơ ngực', 'active', '2026-02-20', '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(8, 'Gậy tập Pilates', 'Dụng cụ hỗ trợ giữ thăng bằng', 'active', NULL, '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(9, 'Dây kháng lực TRX', 'Dụng cụ tập luyện treo người', 'active', '2026-04-01', '2026-04-13 05:39:19', '2026-04-13 05:39:19'),
(10, 'Máy kéo xô King Fitness', 'Thiết bị tập cơ lưng xô chuyên nghiệp', 'active', '2026-03-20', '2026-04-13 05:39:19', '2026-04-13 05:39:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `recorded_by` enum('user','trainer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'trainer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
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
-- Cấu trúc bảng cho bảng `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `item_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `resolved_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên gói (VD: Gym Cơ Bản, Yoga 1 Tháng)',
  `category` enum('gym','yoga') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại gói: thể hình hoặc yoga',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
(1, 'Gym 1 Tháng', 'gym', 'Tập tự do khu thể hình, không PT', 30, 300000.00, 0, 0, 1, '2026-04-02 15:34:26', '2026-04-02 15:34:26'),
(2, 'Gym 1 Tháng + 4 Buổi PT', 'gym', 'Tập tự do + 4 buổi hướng dẫn cùng PT', 30, 800000.00, 1, 4, 1, '2026-04-02 15:34:26', '2026-04-02 15:34:26'),
(3, 'Gym 1 Tháng + 12 Buổi PT', 'gym', 'Tập tự do + 12 buổi PT, ưu tiên đặt lịch', 30, 1500000.00, 1, 12, 1, '2026-04-02 15:34:26', '2026-04-02 15:34:26'),
(4, 'Yoga 1 Tháng', 'yoga', 'Tham gia không giới hạn lớp yoga trong tháng', 30, 350000.00, 0, 0, 1, '2026-04-02 15:34:26', '2026-04-02 15:34:26'),
(5, 'Yoga 1 Tháng + 4 Buổi PT', 'yoga', 'Lớp yoga + 4 buổi tập riêng cùng HLV yoga', 30, 900000.00, 1, 4, 1, '2026-04-02 15:34:26', '2026-04-02 15:34:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(6, '2026_04_03_000001_create_trainers_table', 1),
(7, '2026_04_03_000002_create_subscriptions_table', 1),
(8, '2026_04_03_000003_create_payments_table', 1),
(9, '2026_04_03_000004_create_schedules_table', 1),
(10, '2026_04_03_000005_create_bookings_table', 1),
(11, '2026_04_03_000006_create_checkins_table', 1),
(12, '2026_04_03_000007_create_equipments_table', 1),
(13, '2026_04_03_000008_create_reviews_table', 1),
(14, '2026_04_03_000009_create_notifications_table', 1),
(15, '2026_04_03_000011_create_support_tickets_table', 1),
(16, '2026_04_11_125943_add_missing_fields_to_users_table', 1),
(17, '2026_04_11_152054_add_height_to_users_table', 1),
(18, '2026_04_11_152055_create_health_metrics_table', 1),
(19, '2026_04_11_152055_create_reschedule_requests_table', 1),
(20, '2026_04_11_152055_create_session_reports_table', 1),
(21, '2026_04_13_000001_add_frozen_until_to_subscriptions_table', 1),
(22, '2026_04_13_000002_add_frozen_status_to_subscriptions', 1),
(23, '2026_04_14_230144_create_news_table', 1),
(24, '2026_04_15_083525_add_cancelled_to_payments_status', 1),
(25, '2026_04_16_103816_create_trial_registrations_table', 1),
(26, '2026_04_16_203442_drop_trial_registrations_table', 1),
(27, '2026_04_18_084232_create_news_categories_table', 1),
(28, '2026_04_18_084233_create_news_tags_table', 1),
(29, '2026_04_18_084234_create_news_comments_table', 1),
(30, '2026_04_18_084242_create_news_post_tag_table', 1),
(31, '2026_04_21_214542_create_leave_requests_table', 2),
(32, '2026_04_21_234145_create_jobs_table', 3),
(33, '2026_04_21_235312_fix_notifications_table_structure', 4),
(34, '2026_04_22_000526_cleanup_unused_tables_v2', 5),
(35, '2026_04_22_001741_mega_db_merge_and_simplify', 6),
(36, '2026_04_22_194601_add_target_area_to_bookings_table', 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags_list` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `author_id` bigint UNSIGNED DEFAULT NULL,
  `news_status` enum('draft','pending','published','hidden') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `title_font_family` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Outfit',
  `title_font_size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '24',
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `published_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `image`, `excerpt`, `content`, `tags_list`, `category_id`, `author_id`, `news_status`, `is_featured`, `views`, `title_font_family`, `title_font_size`, `meta_title`, `meta_description`, `published_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bài viết tin tức mẫu số 1', 'bai-viet-tin-tuc-mau-so-1', 'news/P5Wg334CnOWmK9wlLa6fgjqJhGjHtEtYGglxriDx.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 1. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 1. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Cardio, Giảm cân', 1, 1, 'published', 1, 2622, 'Outfit', '24', NULL, NULL, '2026-03-29 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:30'),
(2, 'Bài viết tin tức mẫu số 2', 'bai-viet-tin-tuc-mau-so-2', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 2. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 2. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Tăng cơ', 4, 1, 'published', 1, 3033, 'Outfit', '24', NULL, NULL, '2026-03-23 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(3, 'Bài viết tin tức mẫu số 3', 'bai-viet-tin-tuc-mau-so-3', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 3. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 3. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Cardio, Tăng cơ', 2, 1, 'published', 1, 3336, 'Outfit', '24', NULL, NULL, '2026-03-22 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(4, 'Bài viết tin tức mẫu số 4', 'bai-viet-tin-tuc-mau-so-4', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 4. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 4. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Boxing, Tăng cơ', 1, 1, 'published', 0, 4680, 'Outfit', '24', NULL, NULL, '2026-03-19 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(5, 'Bài viết tin tức mẫu số 5', 'bai-viet-tin-tuc-mau-so-5', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 5. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 5. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Giảm cân, Tăng cơ', 2, 1, 'published', 0, 4591, 'Outfit', '24', NULL, NULL, '2026-04-13 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(6, 'Bài viết tin tức mẫu số 6', 'bai-viet-tin-tuc-mau-so-6', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 6. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 6. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Cardio, Giảm cân', 3, 1, 'published', 0, 1193, 'Outfit', '24', NULL, NULL, '2026-04-08 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-21 17:08:26'),
(7, 'Bài viết tin tức mẫu số 7', 'bai-viet-tin-tuc-mau-so-7', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 7. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 7. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Boxing, Cardio, Yoga', 3, 1, 'published', 0, 2805, 'Outfit', '24', NULL, NULL, '2026-04-06 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(8, 'Bài viết tin tức mẫu số 8', 'bai-viet-tin-tuc-mau-so-8', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 8. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 8. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Boxing, Giảm cân', 1, 1, 'published', 0, 2534, 'Outfit', '24', NULL, NULL, '2026-03-27 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(9, 'Bài viết tin tức mẫu số 9', 'bai-viet-tin-tuc-mau-so-9', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 9. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 9. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Boxing, Sức bền, Tăng cơ', 4, 1, 'published', 0, 4174, 'Outfit', '24', NULL, NULL, '2026-03-20 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02'),
(10, 'Bài viết tin tức mẫu số 10', 'bai-viet-tin-tuc-mau-so-10', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 10. Nội dung này giúp thu hút người đọc.', '<p>Đây là nội dung chi tiết của bài viết mẫu số 10. Chào mừng bạn đến với Gym Pro.</p><p>Hành trình tập luyện của bạn sẽ trở nên thú vị hơn với những kiến thức bổ ích này.</p>', 'Boxing, Giảm cân', 2, 1, 'published', 0, 3019, 'Outfit', '24', NULL, NULL, '2026-04-01 06:01:30', NULL, '2026-04-17 06:01:30', '2026-04-17 07:23:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Khuyến mãi', 'khuyen-mai', 'Các chương trình ưu đãi mới nhất.', 1, '2026-04-17 06:01:30', '2026-04-17 06:01:30'),
(2, 'Kiến thức tập luyện', 'kien-thuc-tap-luyen', 'Hướng dẫn kỹ thuật và bài tập.', 1, '2026-04-17 06:01:30', '2026-04-17 06:01:30'),
(3, 'Dinh dưỡng', 'dinh-duong', 'Chế độ ăn uống lành mạnh.', 1, '2026-04-17 06:01:30', '2026-04-17 06:01:30'),
(4, 'Sự kiện', 'su-kien', 'Các sự kiện tại phòng gym.', 1, '2026-04-17 06:01:30', '2026-04-17 06:01:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news_comments`
--

CREATE TABLE `news_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `news_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0fc374f2-b6c0-405c-aada-55ce098f2df7', 'App\\Notifications\\DailyScheduleSummaryNotification', 'App\\Models\\User', 3, '{\"type\":\"daily_summary\",\"title\":\"L\\u1ecbch t\\u1eadp h\\u00f4m nay (1 bu\\u1ed5i)\",\"message\":\"H\\u00f4m nay b\\u1ea1n c\\u00f3 1 bu\\u1ed5i t\\u1eadp. Bu\\u1ed5i \\u0111\\u1ea7u ti\\u00ean b\\u1eaft \\u0111\\u1ea7u l\\u00fac 15:00. Ch\\u00fac b\\u1ea1n t\\u1eadp luy\\u1ec7n hi\\u1ec7u qu\\u1ea3!\",\"count\":1}', '2026-04-22 12:57:46', '2026-04-22 12:55:01', '2026-04-22 12:57:46'),
('15f234f8-5a40-4759-a0aa-f5a7af8a3b51', 'App\\Notifications\\BookingConfirmedNotification', 'App\\Models\\User', 3, '{\"type\":\"booking_confirmed\",\"title\":\"\\u0110\\u1eb7t l\\u1ecbch th\\u00e0nh c\\u00f4ng\",\"message\":\"L\\u1ecbch t\\u1eadp L\\u1edbp h\\u1ecdc l\\u00fac 08:00 17\\/04\\/2026 \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c x\\u00e1c nh\\u1eadn.\",\"booking_id\":1}', '2026-04-22 12:39:12', '2026-04-22 12:37:30', '2026-04-22 12:39:12'),
('3ba53a67-6796-4d5d-bf9b-27a6536f437a', 'App\\Notifications\\BookingConfirmedNotification', 'App\\Models\\User', 3, '{\"type\":\"booking_confirmed\",\"title\":\"\\u0110\\u1eb7t l\\u1ecbch th\\u00e0nh c\\u00f4ng\",\"message\":\"L\\u1ecbch t\\u1eadp L\\u1edbp h\\u1ecdc l\\u00fac 08:00 17\\/04\\/2026 \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c x\\u00e1c nh\\u1eadn.\",\"booking_id\":1}', '2026-04-22 12:37:12', '2026-04-22 12:36:51', '2026-04-22 12:37:12'),
('59027c83-594d-4939-986f-1550127319b7', 'App\\Notifications\\DailyScheduleSummaryNotification', 'App\\Models\\User', 3, '{\"type\":\"daily_summary\",\"title\":\"L\\u1ecbch t\\u1eadp h\\u00f4m nay (1 bu\\u1ed5i)\",\"message\":\"H\\u00f4m nay b\\u1ea1n c\\u00f3 1 bu\\u1ed5i t\\u1eadp. Bu\\u1ed5i \\u0111\\u1ea7u ti\\u00ean b\\u1eaft \\u0111\\u1ea7u l\\u00fac 15:00. Ch\\u00fac b\\u1ea1n t\\u1eadp luy\\u1ec7n hi\\u1ec7u qu\\u1ea3!\",\"count\":1}', '2026-04-22 12:57:46', '2026-04-22 12:54:36', '2026-04-22 12:57:46'),
('6c7a7e7b-a6f3-405b-9c76-68eca48d6403', 'App\\Notifications\\DailyScheduleSummaryNotification', 'App\\Models\\User', 3, '{\"type\":\"daily_summary\",\"title\":\"L\\u1ecbch t\\u1eadp h\\u00f4m nay (1 bu\\u1ed5i)\",\"message\":\"H\\u00f4m nay b\\u1ea1n c\\u00f3 1 bu\\u1ed5i t\\u1eadp. Bu\\u1ed5i \\u0111\\u1ea7u ti\\u00ean b\\u1eaft \\u0111\\u1ea7u l\\u00fac 15:00. Ch\\u00fac b\\u1ea1n t\\u1eadp luy\\u1ec7n hi\\u1ec7u qu\\u1ea3!\",\"count\":1}', '2026-04-22 12:57:46', '2026-04-22 12:51:41', '2026-04-22 12:57:46'),
('8757a25a-e3af-4904-ad46-753f8f083e6b', 'App\\Notifications\\DailyScheduleSummaryNotification', 'App\\Models\\User', 3, '{\"type\":\"daily_summary\",\"title\":\"L\\u1ecbch t\\u1eadp h\\u00f4m nay (1 bu\\u1ed5i)\",\"message\":\"H\\u00f4m nay b\\u1ea1n c\\u00f3 1 bu\\u1ed5i t\\u1eadp. Bu\\u1ed5i \\u0111\\u1ea7u ti\\u00ean b\\u1eaft \\u0111\\u1ea7u l\\u00fac 15:00. Ch\\u00fac b\\u1ea1n t\\u1eadp luy\\u1ec7n hi\\u1ec7u qu\\u1ea3!\",\"count\":1}', '2026-04-22 12:57:46', '2026-04-22 12:57:15', '2026-04-22 12:57:46'),
('e90281be-2259-4d95-9e6e-6e75524706f9', 'App\\Notifications\\DailyScheduleSummaryNotification', 'App\\Models\\User', 3, '{\"type\":\"daily_summary\",\"title\":\"L\\u1ecbch t\\u1eadp h\\u00f4m nay (1 bu\\u1ed5i)\",\"message\":\"H\\u00f4m nay b\\u1ea1n c\\u00f3 1 bu\\u1ed5i t\\u1eadp. Bu\\u1ed5i \\u0111\\u1ea7u ti\\u00ean b\\u1eaft \\u0111\\u1ea7u l\\u00fac 15:00. Ch\\u00fac b\\u1ea1n t\\u1eadp luy\\u1ec7n hi\\u1ec7u qu\\u1ea3!\",\"count\":1}', '2026-04-22 12:51:38', '2026-04-22 12:50:29', '2026-04-22 12:51:38'),
('fc69cbeb-d1b1-4e32-ae97-c548034bede4', 'App\\Notifications\\DailyScheduleSummaryNotification', 'App\\Models\\User', 3, '{\"type\":\"daily_summary\",\"title\":\"L\\u1ecbch t\\u1eadp h\\u00f4m nay (1 bu\\u1ed5i)\",\"message\":\"H\\u00f4m nay b\\u1ea1n c\\u00f3 1 bu\\u1ed5i t\\u1eadp. Bu\\u1ed5i \\u0111\\u1ea7u ti\\u00ean b\\u1eaft \\u0111\\u1ea7u l\\u00fac 15:00. Ch\\u00fac b\\u1ea1n t\\u1eadp luy\\u1ec7n hi\\u1ec7u qu\\u1ea3!\",\"count\":1}', '2026-04-22 12:51:38', '2026-04-22 12:51:08', '2026-04-22 12:51:38'),
('fcc498dd-bbdf-445a-8d87-e771a2df1d3d', 'App\\Notifications\\BookingConfirmedNotification', 'App\\Models\\User', 3, '{\"type\":\"booking_confirmed\",\"title\":\"\\u0110\\u1eb7t l\\u1ecbch th\\u00e0nh c\\u00f4ng\",\"message\":\"L\\u1ecbch t\\u1eadp L\\u1edbp h\\u1ecdc l\\u00fac 08:00 17\\/04\\/2026 \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c x\\u00e1c nh\\u1eadn.\",\"booking_id\":1}', '2026-04-22 12:37:12', '2026-04-22 12:36:37', '2026-04-22 12:37:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '$2y$10$4kNF1vMkat8t/gniT9m/8OWEhn6A8MA9Jc2A5Qz9YuapfO9eBgoTS', '2026-04-17 06:50:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` enum('cash','transfer','e_wallet') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','refunded','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `invoice_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã hóa đơn tự sinh',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `confirmed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `subscription_id`, `amount`, `method`, `status`, `invoice_code`, `note`, `confirmed_by`, `created_at`, `updated_at`) VALUES
(1, 2, 900000.00, 'e_wallet', 'cancelled', 'VNP1776087760', NULL, 1, '2026-04-13 06:42:40', '2026-04-21 14:01:25'),
(2, 3, 900000.00, 'e_wallet', 'cancelled', 'VNP1776087996', NULL, 1, '2026-04-13 06:46:36', '2026-04-21 14:01:22'),
(3, 4, 900000.00, 'e_wallet', 'cancelled', 'VNP1776088052', NULL, 1, '2026-04-13 06:47:32', '2026-04-21 14:01:19'),
(4, 5, 900000.00, 'e_wallet', 'completed', 'VNP1776088131', NULL, NULL, '2026-04-13 06:48:51', '2026-04-13 06:49:56'),
(5, 6, 800000.00, 'e_wallet', 'cancelled', 'VNP1776090417', NULL, 1, '2026-04-13 07:26:57', '2026-04-21 14:01:13'),
(6, 7, 800000.00, 'e_wallet', 'cancelled', 'VNP1776090435', NULL, 1, '2026-04-13 07:27:15', '2026-04-21 14:01:09'),
(7, 8, 800000.00, 'e_wallet', 'cancelled', 'VNP1776090475', NULL, 1, '2026-04-13 07:27:55', '2026-04-21 14:01:06'),
(8, 9, 300000.00, 'e_wallet', 'cancelled', 'VNP1776135937', NULL, 1, '2026-04-13 20:05:37', '2026-04-21 14:01:02'),
(9, 10, 300000.00, 'e_wallet', 'completed', 'VNP1776136124', NULL, NULL, '2026-04-13 20:08:44', '2026-04-13 20:09:19'),
(10, 11, 300000.00, 'e_wallet', 'completed', 'VNP1776138882', NULL, NULL, '2026-04-13 20:54:42', '2026-04-13 20:55:02'),
(11, 12, 1500000.00, 'e_wallet', 'cancelled', 'VNP1776213837', NULL, NULL, '2026-04-14 17:43:57', '2026-04-14 18:36:15'),
(12, 13, 1500000.00, 'e_wallet', 'completed', 'VNP1776213842', NULL, NULL, '2026-04-14 17:44:02', '2026-04-14 17:45:28'),
(13, 14, 800000.00, 'e_wallet', 'completed', 'VNP1776214104', NULL, NULL, '2026-04-14 17:48:24', '2026-04-14 17:48:40'),
(14, 15, 900000.00, 'e_wallet', 'cancelled', 'VNP1776214432', NULL, 1, '2026-04-14 17:53:52', '2026-04-21 14:00:53'),
(15, 16, 300000.00, 'e_wallet', 'cancelled', 'VNP1776214605', NULL, NULL, '2026-04-14 17:56:45', '2026-04-14 18:36:29'),
(16, 17, 300000.00, 'e_wallet', 'cancelled', 'VNP1776214778', NULL, 1, '2026-04-14 17:59:38', '2026-04-21 14:00:42'),
(17, 20, 800000.00, 'e_wallet', 'cancelled', 'VNP1776215168', NULL, 1, '2026-04-14 18:06:08', '2026-04-21 14:00:46'),
(18, 23, 1500000.00, 'e_wallet', 'completed', 'VNP1776215868', NULL, NULL, '2026-04-14 18:17:48', '2026-04-14 18:18:05'),
(19, 24, 1500000.00, 'e_wallet', 'cancelled', 'VNP1776218166', NULL, 1, '2026-04-14 18:56:06', '2026-04-21 14:00:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `rating` int NOT NULL COMMENT '1-5 sao',
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('gym','yoga') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trainer_id` bigint UNSIGNED DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `capacity` int NOT NULL DEFAULT '20',
  `current_enrolled` int NOT NULL DEFAULT '0',
  `status` enum('upcoming','ongoing','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `schedules`
--

INSERT INTO `schedules` (`id`, `title`, `category`, `trainer_id`, `start_time`, `end_time`, `capacity`, `current_enrolled`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Body Building', 'gym', 9, '2026-04-07 19:00:00', '2026-04-07 20:00:00', 20, 11, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(2, 'Body Building', 'gym', 9, '2026-04-09 10:00:00', '2026-04-09 11:00:00', 20, 9, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(3, 'Body Building', 'gym', 9, '2026-04-11 13:00:00', '2026-04-11 14:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(4, 'Body Building', 'gym', 9, '2026-04-10 19:00:00', '2026-04-10 20:00:00', 20, 11, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(5, 'Core Strength', 'gym', 9, '2026-04-10 14:00:00', '2026-04-10 15:00:00', 20, 16, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(6, 'Power Lifting', 'gym', 9, '2026-04-07 13:00:00', '2026-04-07 14:00:00', 20, 6, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(7, 'Power Lifting', 'gym', 9, '2026-04-07 06:00:00', '2026-04-07 07:00:00', 20, 14, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(8, 'Body Building', 'gym', 9, '2026-04-07 18:00:00', '2026-04-07 19:00:00', 20, 15, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(9, 'Body Building', 'gym', 9, '2026-04-08 11:00:00', '2026-04-08 12:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(10, 'HIIT Cardio', 'gym', 9, '2026-04-12 19:00:00', '2026-04-12 20:00:00', 20, 8, 'upcoming', '2026-04-10 16:00:39', '2026-04-10 16:00:39'),
(11, 'Power Yoga', 'yoga', 12, '2026-04-06 07:00:00', '2026-04-06 08:00:00', 20, 14, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(12, 'Power Yoga', 'yoga', 12, '2026-04-09 06:00:00', '2026-04-09 07:00:00', 20, 8, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(13, 'Hatha Yoga', 'yoga', 12, '2026-04-06 13:00:00', '2026-04-06 14:00:00', 20, 11, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(14, 'Power Yoga', 'yoga', 12, '2026-04-10 10:00:00', '2026-04-10 11:00:00', 20, 10, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(15, 'Meditation', 'yoga', 12, '2026-04-08 10:00:00', '2026-04-08 11:00:00', 20, 12, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(16, 'Hatha Yoga', 'yoga', 12, '2026-04-10 17:00:00', '2026-04-10 18:00:00', 20, 12, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(17, 'Hatha Yoga', 'yoga', 12, '2026-04-08 16:00:00', '2026-04-08 17:00:00', 20, 13, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(18, 'Hatha Yoga', 'yoga', 12, '2026-04-07 12:00:00', '2026-04-07 13:00:00', 20, 16, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(19, 'Meditation', 'yoga', 12, '2026-04-11 14:00:00', '2026-04-11 15:00:00', 20, 15, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(20, 'Vinyasa Flow', 'yoga', 12, '2026-04-08 14:00:00', '2026-04-08 15:00:00', 20, 12, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(21, 'Body Building', 'gym', 13, '2026-04-12 17:00:00', '2026-04-12 18:00:00', 20, 18, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(22, 'Body Building', 'gym', 13, '2026-04-09 07:00:00', '2026-04-09 08:00:00', 20, 13, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(23, 'Body Building', 'gym', 13, '2026-04-08 12:00:00', '2026-04-08 13:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(24, 'Core Strength', 'gym', 13, '2026-04-07 16:00:00', '2026-04-07 17:00:00', 20, 12, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(25, 'HIIT Cardio', 'gym', 13, '2026-04-07 09:00:00', '2026-04-07 10:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(26, 'Core Strength', 'gym', 13, '2026-04-07 06:00:00', '2026-04-07 07:00:00', 20, 7, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(27, 'Power Lifting', 'gym', 13, '2026-04-12 09:00:00', '2026-04-12 10:00:00', 20, 13, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(28, 'Power Lifting', 'gym', 13, '2026-04-10 11:00:00', '2026-04-10 12:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(29, 'Body Building', 'gym', 13, '2026-04-07 15:00:00', '2026-04-07 16:00:00', 20, 8, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(30, 'HIIT Cardio', 'gym', 13, '2026-04-06 18:00:00', '2026-04-06 19:00:00', 20, 18, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(31, 'CrossFit', 'gym', 8, '2026-04-08 10:00:00', '2026-04-08 11:00:00', 20, 11, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(32, 'Zumba Dance', 'gym', 8, '2026-04-08 16:00:00', '2026-04-08 17:00:00', 20, 16, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(33, 'Yoga Recovery', 'gym', 8, '2026-04-07 16:00:00', '2026-04-07 17:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(34, 'Zumba Dance', 'yoga', 8, '2026-04-10 17:00:00', '2026-04-10 18:00:00', 20, 17, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(35, 'Kick Boxing', 'gym', 8, '2026-04-12 09:00:00', '2026-04-12 10:00:00', 20, 15, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(36, 'CrossFit', 'yoga', 8, '2026-04-12 10:00:00', '2026-04-12 11:00:00', 20, 16, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(37, 'Yoga Recovery', 'gym', 8, '2026-04-08 18:00:00', '2026-04-08 19:00:00', 20, 10, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(38, 'Kick Boxing', 'gym', 8, '2026-04-09 09:00:00', '2026-04-09 10:00:00', 20, 7, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(39, 'Yoga Recovery', 'gym', 8, '2026-04-11 12:00:00', '2026-04-11 13:00:00', 20, 9, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(40, 'Zumba Dance', 'yoga', 8, '2026-04-11 08:00:00', '2026-04-11 09:00:00', 20, 14, 'upcoming', '2026-04-10 16:00:40', '2026-04-10 16:00:40'),
(41, 'Yoga Basic - Sáng', 'yoga', 9, '2026-04-14 08:00:54', '2026-04-14 09:00:54', 20, 0, 'upcoming', '2026-04-13 20:36:54', '2026-04-13 20:36:54'),
(42, 'HIIT Training - Chiều', 'gym', 12, '2026-04-14 16:00:54', '2026-04-14 17:00:54', 15, 0, 'upcoming', '2026-04-13 20:36:54', '2026-04-13 20:36:54'),
(43, 'Cardio Blast - Ngày mai', 'gym', 13, '2026-04-15 07:00:54', '2026-04-15 08:00:54', 25, 0, 'upcoming', '2026-04-13 20:36:54', '2026-04-13 20:36:54'),
(44, 'Power Lifting - Tuần sau', 'gym', 8, '2026-04-21 10:00:54', '2026-04-21 11:30:54', 10, 0, 'upcoming', '2026-04-13 20:36:54', '2026-04-13 20:36:54'),
(45, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-16 15:00:00', '2026-04-16 16:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 21:02:35'),
(46, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-16 17:00:00', '2026-04-16 18:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(47, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-17 10:00:00', '2026-04-17 11:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(48, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-17 15:00:00', '2026-04-17 16:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(49, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-18 08:00:00', '2026-04-18 09:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(50, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-18 10:00:00', '2026-04-18 11:00:00', 15, 4, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(51, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-18 15:00:00', '2026-04-18 16:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(52, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-19 08:00:00', '2026-04-19 09:00:00', 15, 8, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(53, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-19 15:00:00', '2026-04-19 16:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(54, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-19 19:00:00', '2026-04-19 20:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(55, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-20 15:00:00', '2026-04-20 16:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(56, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 9, '2026-04-20 19:00:00', '2026-04-20 20:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(57, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-21 15:00:00', '2026-04-21 16:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(58, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-21 19:00:00', '2026-04-21 20:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(59, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-22 15:00:00', '2026-04-22 16:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:40', '2026-04-21 16:48:08'),
(60, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 9, '2026-04-22 19:00:00', '2026-04-22 20:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(61, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-23 08:00:00', '2026-04-23 09:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(62, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-23 10:00:00', '2026-04-23 11:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(63, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-23 15:00:00', '2026-04-23 16:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(64, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-24 08:00:00', '2026-04-24 09:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(65, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-24 10:00:00', '2026-04-24 11:00:00', 15, 3, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(66, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-24 17:00:00', '2026-04-24 18:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(67, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-25 08:00:00', '2026-04-25 09:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(68, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-25 19:00:00', '2026-04-25 20:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(69, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-26 08:00:00', '2026-04-26 09:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(70, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-26 15:00:00', '2026-04-26 16:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(71, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-26 17:00:00', '2026-04-26 18:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(72, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 9, '2026-04-27 08:00:00', '2026-04-27 09:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(73, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-27 10:00:00', '2026-04-27 11:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(74, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-27 15:00:00', '2026-04-27 16:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(75, 'Lưng Xô & Tay Trước', 'gym', 9, '2026-04-28 10:00:00', '2026-04-28 11:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(76, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-28 17:00:00', '2026-04-28 18:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(77, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 9, '2026-04-28 19:00:00', '2026-04-28 20:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(78, 'Vai & Bụng (Core)', 'gym', 9, '2026-04-29 10:00:00', '2026-04-29 11:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(79, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 9, '2026-04-29 17:00:00', '2026-04-29 18:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(80, 'Chân & Mông (Lower Body)', 'gym', 9, '2026-04-29 19:00:00', '2026-04-29 20:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:40', '2026-04-15 20:42:40'),
(81, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-16 15:00:00', '2026-04-16 16:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(82, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-16 17:00:00', '2026-04-16 18:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(83, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-16 19:00:00', '2026-04-16 20:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(84, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-17 08:00:00', '2026-04-17 09:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(85, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-17 15:00:00', '2026-04-17 16:00:00', 15, 4, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(86, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-17 17:00:00', '2026-04-17 18:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(87, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-18 10:00:00', '2026-04-18 11:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(88, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-18 19:00:00', '2026-04-18 20:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(89, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-19 08:00:00', '2026-04-19 09:00:00', 15, 4, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(90, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-19 17:00:00', '2026-04-19 18:00:00', 15, 8, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(91, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-19 19:00:00', '2026-04-19 20:00:00', 15, 3, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(92, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-20 15:00:00', '2026-04-20 16:00:00', 15, 8, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(93, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-20 17:00:00', '2026-04-20 18:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(94, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-21 10:00:00', '2026-04-21 11:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(95, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-21 17:00:00', '2026-04-21 18:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(96, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-21 19:00:00', '2026-04-21 20:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(97, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-22 08:00:00', '2026-04-22 09:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(98, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-22 15:00:00', '2026-04-22 16:00:00', 15, 3, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(99, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-22 19:00:00', '2026-04-22 20:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(100, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-23 10:00:00', '2026-04-23 11:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(101, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-23 15:00:00', '2026-04-23 16:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(102, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-24 08:00:00', '2026-04-24 09:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(103, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-24 10:00:00', '2026-04-24 11:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(104, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-24 19:00:00', '2026-04-24 20:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(105, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-25 17:00:00', '2026-04-25 18:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(106, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-25 19:00:00', '2026-04-25 20:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(107, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-26 08:00:00', '2026-04-26 09:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(108, 'Thiền Định & Phục Hồi', 'yoga', 12, '2026-04-26 15:00:00', '2026-04-26 16:00:00', 15, 8, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(109, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-26 17:00:00', '2026-04-26 18:00:00', 15, 3, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(110, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-27 08:00:00', '2026-04-27 09:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(111, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-27 10:00:00', '2026-04-27 11:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(112, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-27 19:00:00', '2026-04-27 20:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(113, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-28 08:00:00', '2026-04-28 09:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(114, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-28 15:00:00', '2026-04-28 16:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(115, 'Yoga Trị Liệu Cột Sống', 'yoga', 12, '2026-04-29 15:00:00', '2026-04-29 16:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(116, 'Vinyasa Flow Năng Lượng', 'yoga', 12, '2026-04-29 17:00:00', '2026-04-29 18:00:00', 15, 8, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(117, 'Hatha Yoga Cơ Bản', 'yoga', 12, '2026-04-29 19:00:00', '2026-04-29 20:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(118, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-16 08:00:00', '2026-04-16 09:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(119, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-16 17:00:00', '2026-04-16 18:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(120, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-16 19:00:00', '2026-04-16 20:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(121, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-17 08:00:00', '2026-04-17 09:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:58:20'),
(122, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-17 10:00:00', '2026-04-17 11:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(123, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-18 15:00:00', '2026-04-18 16:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(124, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-18 17:00:00', '2026-04-18 18:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(125, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-18 19:00:00', '2026-04-18 20:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(126, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-19 08:00:00', '2026-04-19 09:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(127, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-19 19:00:00', '2026-04-19 20:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(128, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-20 10:00:00', '2026-04-20 11:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(129, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-20 15:00:00', '2026-04-20 16:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(130, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-21 10:00:00', '2026-04-21 11:00:00', 15, 9, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(131, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-21 17:00:00', '2026-04-21 18:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(132, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-21 19:00:00', '2026-04-21 20:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(133, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-22 08:00:00', '2026-04-22 09:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(134, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-22 10:00:00', '2026-04-22 11:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(135, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-22 19:00:00', '2026-04-22 20:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(136, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-23 10:00:00', '2026-04-23 11:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(137, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-23 15:00:00', '2026-04-23 16:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(138, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-23 19:00:00', '2026-04-23 20:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(139, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-24 08:00:00', '2026-04-24 09:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(140, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-24 15:00:00', '2026-04-24 16:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(141, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-24 17:00:00', '2026-04-24 18:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(142, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-25 08:00:00', '2026-04-25 09:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(143, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-25 17:00:00', '2026-04-25 18:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(144, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-26 10:00:00', '2026-04-26 11:00:00', 15, 4, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(145, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-26 15:00:00', '2026-04-26 16:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(146, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-26 17:00:00', '2026-04-26 18:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(147, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-27 10:00:00', '2026-04-27 11:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(148, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-27 15:00:00', '2026-04-27 16:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(149, 'Vai & Bụng (Core)', 'gym', 12, '2026-04-27 19:00:00', '2026-04-27 20:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(150, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-28 08:00:00', '2026-04-28 09:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(151, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-28 10:00:00', '2026-04-28 11:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(152, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-28 19:00:00', '2026-04-28 20:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(153, 'Ngực & Tay Sau (Bodybuilding)', 'gym', 12, '2026-04-29 08:00:00', '2026-04-29 09:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(154, 'Lưng Xô & Tay Trước', 'gym', 12, '2026-04-29 10:00:00', '2026-04-29 11:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(155, 'Chân & Mông (Lower Body)', 'gym', 12, '2026-04-29 15:00:00', '2026-04-29 16:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(156, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-16 08:00:00', '2026-04-16 09:00:00', 15, 12, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(157, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-16 19:00:00', '2026-04-16 20:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(158, 'Thiền Định & Phục Hồi', 'yoga', 13, '2026-04-17 17:00:00', '2026-04-17 18:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(159, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-17 19:00:00', '2026-04-17 20:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(160, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-18 10:00:00', '2026-04-18 11:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(161, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-18 19:00:00', '2026-04-18 20:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(162, 'Thiền Định & Phục Hồi', 'yoga', 13, '2026-04-19 08:00:00', '2026-04-19 09:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(163, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-19 15:00:00', '2026-04-19 16:00:00', 15, 5, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(164, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-20 10:00:00', '2026-04-20 11:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(165, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-20 17:00:00', '2026-04-20 18:00:00', 15, 3, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(166, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-20 19:00:00', '2026-04-20 20:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(167, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-21 08:00:00', '2026-04-21 09:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(168, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-21 15:00:00', '2026-04-21 16:00:00', 15, 8, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(169, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-22 10:00:00', '2026-04-22 11:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(170, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-22 17:00:00', '2026-04-22 18:00:00', 15, 4, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(171, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-23 08:00:00', '2026-04-23 09:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(172, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-23 10:00:00', '2026-04-23 11:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(173, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-24 08:00:00', '2026-04-24 09:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(174, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-24 17:00:00', '2026-04-24 18:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(175, 'Thiền Định & Phục Hồi', 'yoga', 13, '2026-04-24 19:00:00', '2026-04-24 20:00:00', 15, 13, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(176, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-25 08:00:00', '2026-04-25 09:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(177, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-25 15:00:00', '2026-04-25 16:00:00', 15, 11, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(178, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-25 19:00:00', '2026-04-25 20:00:00', 15, 10, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(179, 'Thiền Định & Phục Hồi', 'yoga', 13, '2026-04-26 10:00:00', '2026-04-26 11:00:00', 15, 15, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(180, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-26 17:00:00', '2026-04-26 18:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(181, 'Thiền Định & Phục Hồi', 'yoga', 13, '2026-04-26 19:00:00', '2026-04-26 20:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(182, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-27 08:00:00', '2026-04-27 09:00:00', 15, 14, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(183, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-27 10:00:00', '2026-04-27 11:00:00', 15, 6, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(184, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-28 15:00:00', '2026-04-28 16:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(185, 'Vinyasa Flow Năng Lượng', 'yoga', 13, '2026-04-28 17:00:00', '2026-04-28 18:00:00', 15, 7, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(186, 'Hatha Yoga Cơ Bản', 'yoga', 13, '2026-04-28 19:00:00', '2026-04-28 20:00:00', 15, 2, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(187, 'Thiền Định & Phục Hồi', 'yoga', 13, '2026-04-29 10:00:00', '2026-04-29 11:00:00', 15, 0, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41'),
(188, 'Yoga Trị Liệu Cột Sống', 'yoga', 13, '2026-04-29 17:00:00', '2026-04-29 18:00:00', 15, 1, 'upcoming', '2026-04-15 20:42:41', '2026-04-15 20:42:41');

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
  `status` enum('pending_payment','active','expired','cancelled','frozen') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending_payment',
  `cancel_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` datetime DEFAULT NULL,
  `frozen_until` date DEFAULT NULL COMMENT 'Ngày kết thúc đóng băng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `membership_id`, `trainer_id`, `start_date`, `end_date`, `final_price`, `pt_sessions_left`, `status`, `cancel_reason`, `cancelled_at`, `frozen_until`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 9, '2026-04-06', '2026-05-06', 800000.00, 4, 'active', NULL, NULL, NULL, '2026-04-11 02:18:46', '2026-04-11 02:18:46'),
(2, 3, 5, NULL, '2026-04-13', '2026-05-13', 900000.00, 4, 'pending_payment', NULL, NULL, NULL, '2026-04-13 06:42:40', '2026-04-13 06:42:40'),
(3, 3, 5, NULL, '2026-04-13', '2026-05-13', 900000.00, 4, 'pending_payment', NULL, NULL, NULL, '2026-04-13 06:46:36', '2026-04-13 06:46:36'),
(4, 3, 5, NULL, '2026-04-13', '2026-05-13', 900000.00, 4, 'pending_payment', NULL, NULL, NULL, '2026-04-13 06:47:32', '2026-04-13 06:47:32'),
(5, 3, 5, NULL, '2026-04-13', '2026-06-12', 900000.00, 3, 'active', NULL, NULL, NULL, '2026-04-13 06:48:51', '2026-04-17 18:28:28'),
(6, 3, 2, NULL, '2026-04-13', '2026-05-13', 800000.00, 4, 'cancelled', 'ok', '2026-04-22 19:52:53', NULL, '2026-04-13 07:26:57', '2026-04-22 12:52:53'),
(7, 3, 2, NULL, '2026-04-13', '2026-05-13', 800000.00, 4, 'pending_payment', NULL, NULL, NULL, '2026-04-13 07:27:15', '2026-04-13 07:27:15'),
(8, 3, 2, NULL, '2026-04-13', '2026-05-13', 800000.00, 4, 'pending_payment', NULL, NULL, NULL, '2026-04-13 07:27:55', '2026-04-13 07:27:55'),
(9, 3, 1, NULL, '2026-04-14', '2026-05-14', 300000.00, 0, 'pending_payment', NULL, NULL, NULL, '2026-04-13 20:05:37', '2026-04-13 20:05:37'),
(10, 3, 1, NULL, '2026-04-14', '2026-05-14', 300000.00, 0, 'active', NULL, NULL, NULL, '2026-04-13 20:08:44', '2026-04-13 20:09:19'),
(11, 3, 1, NULL, '2026-04-14', '2026-05-14', 300000.00, 0, 'active', NULL, NULL, NULL, '2026-04-13 20:54:42', '2026-04-13 20:55:02'),
(12, 3, 3, NULL, '2026-04-15', '2026-05-15', 1500000.00, 12, 'cancelled', 'ko', '2026-04-15 08:36:15', NULL, '2026-04-14 17:43:57', '2026-04-14 18:36:15'),
(13, 3, 3, NULL, '2026-04-15', '2026-05-15', 1500000.00, 12, 'active', NULL, NULL, NULL, '2026-04-14 17:44:02', '2026-04-14 17:45:28'),
(14, 3, 2, NULL, '2026-04-15', '2026-05-15', 800000.00, 4, 'active', NULL, NULL, NULL, '2026-04-14 17:48:24', '2026-04-14 17:48:40'),
(15, 3, 5, NULL, '2026-04-15', '2026-05-15', 900000.00, 4, 'cancelled', 'ko thích tập nx', '2026-04-15 08:35:49', NULL, '2026-04-14 17:53:52', '2026-04-14 18:35:49'),
(16, 3, 1, NULL, '2026-04-15', '2026-05-15', 300000.00, 0, 'cancelled', 'cút đi', '2026-04-15 08:36:29', NULL, '2026-04-14 17:56:45', '2026-04-14 18:36:29'),
(17, 3, 1, NULL, '2026-04-15', '2026-05-15', 300000.00, 0, 'cancelled', 'tôi ko muốn dky nx', '2026-04-15 08:33:31', NULL, '2026-04-14 17:59:38', '2026-04-14 18:33:31'),
(20, 3, 2, NULL, '2026-04-15', '2026-05-15', 800000.00, 4, 'cancelled', 'tôi ko muốn dky th', '2026-04-15 08:30:21', NULL, '2026-04-14 18:06:08', '2026-04-14 18:30:21'),
(23, 3, 3, NULL, '2026-04-15', '2026-05-15', 1500000.00, 12, 'active', NULL, NULL, NULL, '2026-04-14 18:17:48', '2026-04-14 18:18:05'),
(24, 3, 3, NULL, '2026-04-15', '2026-05-15', 1500000.00, 12, 'cancelled', 'ko mua', '2026-04-22 00:35:08', NULL, '2026-04-14 18:56:06', '2026-04-21 17:35:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` double(8,2) DEFAULT NULL COMMENT 'Chiều cao (cm)',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user' COMMENT 'Vai trò: user, staff, admin, trainer',
  `specialization` enum('gym','yoga','both') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_per_session` decimal(12,2) NOT NULL DEFAULT '500000.00',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `avatar_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `height`, `password`, `role`, `specialization`, `price_per_session`, `is_available`, `avatar_url`, `is_active`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'admin', NULL, 500000.00, 1, NULL, 1, '2026-04-02 16:29:21', NULL, '2026-04-02 15:34:25', '2026-04-21 02:30:31'),
(2, 'Client Test', 'client@gmail.com', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'user', NULL, 500000.00, 1, NULL, 1, '2026-04-02 16:29:31', NULL, '2026-04-02 15:34:26', '2026-04-21 02:30:31'),
(3, 'Đức Anh Nguyễn', 'anp93005@gmail.com', NULL, NULL, '$2y$10$h/Q.8WCBlsIRQMNDQkUXquGvs9f0.Rh0.YjRP00y9qlFX62hp3KP.', 'user', NULL, 500000.00, 1, '/storage/avatars/UIbibMtXLrwdzJG9FUcXs4XL7FpZdB7YMVGSSwGm.jpg', 1, NULL, NULL, '2026-04-02 15:38:04', '2026-04-21 15:20:25'),
(5, 'Nguyễn Minh Tuấn', 'tuan.gym@extrafit.vn', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'gym', 500000.00, 1, 'https://images.unsplash.com/photo-1567013127542-490d757e51cd?w=500&q=80&auto=format&fit=crop', 1, NULL, NULL, '2026-04-10 16:00:39', '2026-04-21 02:30:31'),
(6, 'Trần Thị Lan', 'lan.yoga@extrafit.vn', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'yoga', 500000.00, 1, 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=500&q=80&auto=format&fit=crop', 1, NULL, NULL, '2026-04-10 16:00:40', '2026-04-21 02:30:31'),
(7, 'Lê Văn Hùng', 'hung.boxing@extrafit.vn', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'gym', 500000.00, 1, 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop', 1, NULL, NULL, '2026-04-10 16:00:40', '2026-04-21 02:30:31'),
(8, 'Phạm Thu Hà', 'ha.fitness@extrafit.vn', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'both', 500000.00, 1, '/storage/avatars/w6zVBxJQZFsSVaX9KerUAB7YKBzhpFtsVBVmKYEP.jpg', 1, NULL, NULL, '2026-04-10 16:00:40', '2026-04-21 02:30:31'),
(9, 'Phạm Thu Hà', 'thuha12@gmail.com', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'both', 500000.00, 1, NULL, 1, NULL, NULL, '2026-04-11 00:04:49', '2026-04-21 02:30:31'),
(10, 'Phan Đức Tú', 'tubun2@gmail.com', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'staff', NULL, 500000.00, 1, NULL, 1, NULL, NULL, '2026-04-11 00:18:02', '2026-04-21 02:30:31'),
(11, 'Admin User', 'admin@dummy.com', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'user', NULL, 500000.00, 1, NULL, 1, NULL, NULL, '2026-04-11 01:46:51', '2026-04-21 02:30:31'),
(12, 'Lê Văn Hùng', 'hung.bodybuilding@extrafit.vn', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'gym', 500000.00, 1, 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop', 1, NULL, NULL, '2026-04-15 20:42:41', '2026-04-21 02:30:31'),
(13, 'Phạm Thu Hà', 'ha.yoga@extrafit.vn', NULL, NULL, '$2y$10$olk10lusqrfMu7nDf9.H0O9V8642pb2S/h.7jIb2LpRP81qCwdxSC', 'trainer', 'yoga', 500000.00, 1, 'https://images.unsplash.com/photo-1609899537878-49e9196c5bcd?w=500&q=80&auto=format&fit=crop', 1, NULL, NULL, '2026-04-15 20:42:41', '2026-04-21 02:30:31'),
(15, 'duc anh', 'chau12@gmail.com', NULL, NULL, '$2y$10$hR4UxDITp6yfPCZh/TNJ2uYG12NNQfDZXovN5FKfQVRNgnpE20Pr6', 'staff', NULL, 500000.00, 1, NULL, 1, NULL, NULL, '2026-04-21 15:51:23', '2026-04-21 15:51:23');

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
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_trainer_id_foreign` (`trainer_id`),
  ADD KEY `leave_requests_resolved_by_foreign` (`resolved_by`);

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
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `news_comments`
--
ALTER TABLE `news_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_comments_news_id_foreign` (`news_id`),
  ADD KEY `news_comments_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
-- Chỉ mục cho bảng `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_membership_id_foreign` (`membership_id`),
  ADD KEY `subscriptions_trainer_id_foreign` (`trainer_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `leave_requests`
--
ALTER TABLE `leave_requests`
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `news_comments`
--
ALTER TABLE `news_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT cho bảng `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`),
  ADD CONSTRAINT `bookings_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`),
  ADD CONSTRAINT `bookings_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
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
  ADD CONSTRAINT `health_metrics_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `health_metrics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leave_requests_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `news_comments`
--
ALTER TABLE `news_comments`
  ADD CONSTRAINT `news_comments_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `reviews_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`),
  ADD CONSTRAINT `subscriptions_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
