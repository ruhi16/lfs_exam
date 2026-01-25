-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2025 at 05:10 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hhhh`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam01_names`
--

CREATE TABLE `exam01_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam01_names`
--

INSERT INTO `exam01_names` (`id`, `name`, `description`, `exam_month`, `exam_year`, `order_index`, `is_optional`, `session_id`, `school_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'First Term', 'blsdf', NULL, NULL, 1, 0, NULL, NULL, 4, NULL, 1, 0, 'active', 'sdfdsf', '2025-08-21 21:22:59', '2025-08-21 21:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `exam02_types`
--

CREATE TABLE `exam02_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam02_types`
--

INSERT INTO `exam02_types` (`id`, `name`, `description`, `order_index`, `is_optional`, `session_id`, `school_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Formative', 'fdsf', 1, 0, NULL, NULL, 4, NULL, 1, 0, 'dsffsf', 'sfsdfsdf', '2025-08-21 21:23:20', '2025-08-21 21:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `exam03_parts`
--

CREATE TABLE `exam03_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam03_parts`
--

INSERT INTO `exam03_parts` (`id`, `name`, `description`, `order_index`, `is_optional`, `session_id`, `school_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Written', '', NULL, 0, NULL, NULL, 4, NULL, 1, 0, '', '', '2025-08-21 21:23:31', '2025-08-21 21:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `exam04_modes`
--

CREATE TABLE `exam04_modes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam04_modes`
--

INSERT INTO `exam04_modes` (`id`, `name`, `description`, `order_index`, `is_optional`, `session_id`, `school_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'oral', '', NULL, 0, NULL, NULL, 4, NULL, 1, 0, '', '', '2025-08-21 21:23:40', '2025-08-21 21:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `exam05_details`
--

CREATE TABLE `exam05_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `myclass_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_name_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_type_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_part_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_mode_id` int(10) UNSIGNED DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam05_details`
--

INSERT INTO `exam05_details` (`id`, `name`, `description`, `myclass_id`, `exam_name_id`, `exam_type_id`, `exam_part_id`, `exam_mode_id`, `order_index`, `is_optional`, `session_id`, `school_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(2, 'First Term', 'Exam Configuration updated', 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, 4, NULL, 1, 0, NULL, NULL, '2025-08-21 21:24:28', '2025-08-21 21:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `exam06_class_subjects`
--

CREATE TABLE `exam06_class_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `myclass_id` int(10) UNSIGNED DEFAULT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `full_marks` int(10) UNSIGNED DEFAULT NULL,
  `pass_marks` int(10) UNSIGNED DEFAULT NULL,
  `time_in_minutes` int(10) UNSIGNED DEFAULT NULL,
  `is_additional` tinyint(1) DEFAULT 0,
  `is_combined` tinyint(1) DEFAULT 0,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `exam_weightage` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam07_ansscr_dists`
--

CREATE TABLE `exam07_ansscr_dists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `myclass_section_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_class_subject_id` int(10) UNSIGNED DEFAULT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam09_schedule_rooms`
--

CREATE TABLE `exam09_schedule_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_class_subject_id` int(10) UNSIGNED DEFAULT NULL,
  `room_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `teacher1_id` int(10) UNSIGNED DEFAULT NULL,
  `teacher2_id` int(10) UNSIGNED DEFAULT NULL,
  `teacher3_id` int(10) UNSIGNED DEFAULT NULL,
  `teacher4_id` int(10) UNSIGNED DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam10_marks_entries`
--

CREATE TABLE `exam10_marks_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_class_subject_id` int(10) UNSIGNED DEFAULT NULL,
  `myclass_section_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_marks` decimal(8,2) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam11_question_papers`
--

CREATE TABLE `exam11_question_papers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_detail_id` int(10) UNSIGNED DEFAULT NULL,
  `exam_class_subject_id` int(10) UNSIGNED DEFAULT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL,
  `is_submitted` tinyint(1) DEFAULT 0,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_particulars`
--

CREATE TABLE `fee_particulars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_22_151005_create_notices_table', 1),
(6, '2024_06_25_133932_create_roles_table', 1),
(7, '2024_08_18_131554_create_teachers_table', 1),
(8, '2024_08_19_043016_create_schools_table', 1),
(9, '2024_08_19_043104_create_sessions_table', 1),
(10, '2025_01_13_100000_add_status_to_users_table', 2),
(11, '2025_02_16_064857_create_fee_particulars_table', 2),
(12, '2025_02_17_175430_create_myclasses_table', 2),
(13, '2025_02_17_175811_create_sections_table', 2),
(14, '2025_02_17_175958_create_myclass_sections_table', 2),
(15, '2025_02_17_182839_create_session_event_categories_table', 2),
(16, '2025_02_17_182941_create_session_events_table', 2),
(17, '2025_02_17_183204_create_session_event_schedules_table', 2),
(18, '2025_02_17_190028_create_studentdbs_table', 2),
(19, '2025_02_17_190306_create_studentcrs_table', 2),
(20, '2025_06_23_184547_create_exam01_names_table', 2),
(21, '2025_06_24_004628_create_exam02_types_table', 2),
(22, '2025_06_24_004722_create_exam03_parts_table', 2),
(23, '2025_06_24_005021_create_exam04_modes_table', 2),
(24, '2025_06_24_005049_create_exam05_details_table', 2),
(25, '2025_06_24_015033_create_exam06_class_subjects_table', 2),
(26, '2025_06_24_015159_create_exam07_ansscr_dists_table', 2),
(27, '2025_06_24_015750_create_exam09_schedule_rooms_table', 2),
(28, '2025_06_24_015939_create_exam10_marks_entries_table', 2),
(29, '2025_06_24_020117_create_exam11_question_papers_table', 2),
(30, '2025_08_02_025121_create_subjects_table', 2),
(31, '2025_08_02_025439_create_subject_types_table', 2),
(32, '2025_08_03_133128_create_myclass_subjects_table', 2),
(34, '2025_08_03_133129_create_subject_teacher_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `myclasses`
--

CREATE TABLE `myclasses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `myclasses`
--

INSERT INTO `myclasses` (`id`, `name`, `description`, `order_index`, `school_id`, `session_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Baby Land', '', 1, 1, 1, 4, NULL, 1, 0, 'active', '', '2025-08-21 21:08:27', '2025-08-21 21:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `myclass_sections`
--

CREATE TABLE `myclass_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `myclass_id` int(10) UNSIGNED DEFAULT NULL,
  `section_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `myclass_sections`
--

INSERT INTO `myclass_sections` (`id`, `name`, `description`, `order_index`, `myclass_id`, `section_id`, `school_id`, `session_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'A', '', 1, 1, 1, 1, 1, 4, NULL, 1, 0, NULL, NULL, '2025-08-21 21:12:07', '2025-08-21 21:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `myclass_subjects`
--

CREATE TABLE `myclass_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `myclass_id` int(10) UNSIGNED DEFAULT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `myclass_subjects`
--

INSERT INTO `myclass_subjects` (`id`, `name`, `description`, `order_index`, `is_optional`, `myclass_id`, `subject_id`, `session_id`, `school_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'BL Bengali', '', 1, 0, 1, 1, 1, 1, 4, NULL, 1, 0, 'active', '', '2025-08-21 21:18:21', '2025-08-21 21:18:40');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dop` date NOT NULL,
  `doe` date NOT NULL,
  `fileaddr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'User', 'Students', NULL, NULL),
(2, 'Sub Admin', 'Teacher', NULL, NULL),
(3, 'Office Staff', 'Clerk', NULL, NULL),
(4, 'Admin', 'Principal', NULL, NULL),
(5, 'Super Admin', 'Management', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dist` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `index` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hscode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `session_id`, `name`, `details`, `vill`, `po`, `ps`, `pin`, `dist`, `index`, `hscode`, `disecode`, `estd`, `status`, `remark`, `created_at`, `updated_at`) VALUES
(1, 1, 'Little Flower School', NULL, 'Bhagwangola', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2025-08-21 18:30:00', '2025-08-22 12:20:08'),
(2, 1, 'Manikchak High Madrasah(H.S)', NULL, 'Manikchak ', 'Manikchak', 'Lalgola', '742123', 'Murshidabad', '19071515802', '116126', '19074585632', '1921', 'inactive', 'This is Manikchak', '2025-08-22 12:15:59', '2025-08-22 12:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `description`, `order_index`, `school_id`, `session_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'A', '', NULL, 1, 1, 4, NULL, 1, 0, NULL, '', '2025-08-21 21:10:25', '2025-08-21 21:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdate` date NOT NULL,
  `entdate` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prev_session_id` int(11) DEFAULT NULL,
  `next_session_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `details`, `stdate`, `entdate`, `status`, `remark`, `prev_session_id`, `next_session_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, '2025-26', 'Current Session', '2025-04-01', '2026-03-31', 'Active', 'Current ', NULL, NULL, NULL, '2025-08-21 21:21:33', '2025-08-21 21:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `session_events`
--

CREATE TABLE `session_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `session_event_category_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_event_categories`
--

CREATE TABLE `session_event_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_event_schedules`
--

CREATE TABLE `session_event_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `session_event_id` int(10) UNSIGNED DEFAULT NULL,
  `session_event_category_id` int(10) UNSIGNED DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentcrs`
--

CREATE TABLE `studentcrs` (
  `id` int(10) UNSIGNED NOT NULL,
  `studentdb_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `myclass_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `roll_no` int(11) NOT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crstatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_class_id` int(11) DEFAULT NULL,
  `next_section_id` int(11) DEFAULT NULL,
  `next_session_id` int(11) DEFAULT NULL,
  `next_studentcr_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentcrs`
--

INSERT INTO `studentcrs` (`id`, `studentdb_id`, `session_id`, `myclass_id`, `section_id`, `roll_no`, `result`, `description`, `crstatus`, `next_class_id`, `next_section_id`, `next_session_id`, `next_studentcr_id`, `school_id`, `created_at`, `updated_at`) VALUES
(21, 21, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:47:45'),
(22, 22, 1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:48:19'),
(23, 23, 1, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:49:55'),
(24, 24, 1, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:50:23'),
(25, 25, 1, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:51:31'),
(26, 26, 1, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:53:18'),
(27, 27, 1, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:53:53'),
(28, 28, 1, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:54:29'),
(29, 29, 1, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:54:54'),
(30, 30, 1, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:55:21'),
(31, 31, 1, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 08:55:37'),
(32, 32, 1, 5, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-29 09:02:43'),
(33, 33, 1, 5, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(34, 34, 1, 5, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(35, 35, 1, 5, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(36, 36, 1, 5, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(37, 37, 1, 5, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(38, 38, 1, 5, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(39, 39, 1, 5, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(40, 40, 1, 5, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(41, 41, 1, 5, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(42, 42, 1, 5, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(43, 43, 1, 5, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(44, 44, 1, 5, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(45, 45, 1, 5, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(46, 46, 1, 6, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(47, 47, 1, 6, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(48, 48, 1, 6, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(49, 49, 1, 6, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(50, 50, 1, 6, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(51, 51, 1, 6, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(52, 52, 1, 6, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(53, 53, 1, 6, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(54, 54, 1, 7, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(55, 55, 1, 7, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(56, 56, 1, 7, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(57, 57, 1, 7, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(58, 58, 1, 7, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(59, 59, 1, 7, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(60, 60, 1, 7, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(61, 61, 1, 7, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(62, 62, 1, 7, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(63, 63, 1, 7, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(64, 64, 1, 7, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(65, 65, 1, 7, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(66, 66, 1, 7, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(67, 67, 1, 8, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(68, 68, 1, 8, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(69, 69, 1, 8, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(70, 70, 1, 8, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(71, 71, 1, 8, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 12:26:00', '2025-03-11 12:26:00'),
(72, 75, 1, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-29 08:58:24'),
(73, 76, 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-29 08:58:43'),
(74, 77, 1, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-29 08:59:00'),
(75, 78, 1, 2, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-29 08:59:32'),
(76, 79, 1, 2, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:21:02'),
(77, 80, 1, 2, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(78, 81, 1, 2, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:36:31'),
(79, 82, 1, 2, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:36:56'),
(80, 83, 1, 2, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(81, 84, 1, 2, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:37:17'),
(82, 85, 1, 2, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:37:53'),
(83, 86, 1, 2, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:38:12'),
(84, 87, 1, 2, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:38:30'),
(85, 88, 1, 2, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:38:45'),
(86, 89, 1, 2, 1, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:39:02'),
(87, 90, 1, 2, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:39:20'),
(88, 91, 1, 2, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:39:35'),
(89, 92, 1, 2, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:36:00'),
(90, 93, 1, 2, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:41:40'),
(91, 94, 1, 2, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(92, 95, 1, 2, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:43:15'),
(93, 96, 1, 2, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(94, 97, 1, 2, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:46:01'),
(95, 98, 1, 2, 2, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:48:37'),
(96, 99, 1, 2, 2, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(97, 100, 1, 2, 2, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(98, 101, 1, 2, 2, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:49:19'),
(99, 102, 1, 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(100, 103, 1, 2, 2, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:40:49'),
(101, 104, 1, 2, 2, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:41:09'),
(102, 105, 1, 2, 2, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:41:40'),
(103, 106, 1, 2, 2, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(104, 107, 1, 2, 2, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:42:07'),
(105, 108, 1, 2, 2, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:42:32'),
(106, 109, 1, 2, 2, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(107, 110, 1, 4, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:44:30'),
(108, 111, 1, 4, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:44:49'),
(109, 112, 1, 4, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:45:05'),
(110, 113, 1, 4, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:45:22'),
(111, 114, 1, 4, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:45:51'),
(112, 115, 1, 4, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:46:10'),
(113, 116, 1, 4, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:46:54'),
(114, 117, 1, 4, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:47:53'),
(115, 118, 1, 4, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:48:10'),
(116, 119, 1, 4, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:48:47'),
(117, 120, 1, 4, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(118, 121, 1, 4, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(119, 122, 1, 4, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:49:17'),
(120, 123, 1, 4, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:50:27'),
(121, 124, 1, 4, 1, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:51:32'),
(122, 125, 1, 4, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:51:56'),
(123, 126, 1, 4, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:52:20'),
(124, 127, 1, 4, 1, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:52:40'),
(125, 128, 1, 4, 1, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:52:58'),
(126, 129, 1, 4, 1, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:53:15'),
(127, 130, 1, 4, 1, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 10:53:43'),
(128, 131, 1, 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-30 09:53:08'),
(129, 132, 1, 3, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:30:54'),
(130, 133, 1, 3, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:31:28'),
(131, 134, 1, 3, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:32:10'),
(132, 135, 1, 3, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(133, 136, 1, 3, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:33:06'),
(134, 137, 1, 3, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:33:26'),
(135, 138, 1, 3, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:33:50'),
(136, 139, 1, 3, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:34:15'),
(137, 140, 1, 3, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:34:42'),
(138, 141, 1, 3, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(139, 142, 1, 3, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:35:14'),
(140, 143, 1, 3, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:35:47'),
(141, 144, 1, 3, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:36:12'),
(142, 145, 1, 3, 1, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(143, 146, 1, 3, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:37:03'),
(144, 147, 1, 3, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:53:48'),
(145, 148, 1, 3, 1, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(146, 149, 1, 3, 1, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:54:30'),
(147, 150, 1, 3, 1, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(148, 151, 1, 3, 1, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(149, 152, 1, 3, 1, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-31 21:55:25'),
(150, 153, 1, 3, 1, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(151, 154, 1, 3, 1, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(152, 155, 1, 3, 1, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(153, 156, 1, 3, 1, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(154, 157, 1, 3, 1, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(155, 158, 1, 3, 1, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(156, 159, 1, 3, 1, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(157, 160, 1, 3, 1, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(158, 161, 1, 3, 1, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(159, 162, 1, 3, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-04-08 13:36:15'),
(160, 163, 1, 3, 1, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(161, 164, 1, 3, 1, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(162, 165, 1, 3, 1, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-11 05:26:00', '2025-03-11 05:26:00'),
(163, 80, 1, 1, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-28 08:50:19', '2025-04-04 07:17:55'),
(164, 166, 1, 1, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 09:32:05', '2025-03-29 09:33:04'),
(165, 167, 1, 1, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 09:36:03', '2025-03-29 09:38:43'),
(166, 168, 1, 1, 1, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 09:42:39', '2025-03-29 09:43:33'),
(167, 169, 1, 7, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 10:06:37', '2025-03-29 10:06:37'),
(168, 170, 1, 1, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 10:52:59', '2025-03-29 10:52:59'),
(169, 80, 1, 1, 2, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 09:32:27', '2025-03-30 09:41:02'),
(170, 171, 1, 3, 1, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 10:31:49', '2025-03-30 10:31:49'),
(171, 172, 1, 3, 1, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 10:34:44', '2025-03-30 10:34:44'),
(172, 173, 1, 3, 1, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 10:38:30', '2025-03-30 10:38:30'),
(173, 174, 1, 2, 2, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-30 10:59:31', '2025-03-30 10:59:31'),
(174, 80, 1, 2, 2, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-01 09:55:14', '2025-04-01 09:55:14'),
(175, 175, 1, 8, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 08:05:31', '2025-04-03 08:05:31'),
(176, 176, 1, 4, 1, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 08:11:27', '2025-04-03 08:11:27'),
(177, 177, 1, 4, 1, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 08:21:20', '2025-04-03 08:21:20'),
(178, 178, 1, 5, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 08:35:21', '2025-04-03 08:35:21'),
(179, 179, 1, 5, 1, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 08:39:50', '2025-04-03 08:39:50'),
(180, 180, 1, 5, 1, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 08:45:14', '2025-04-03 08:45:14'),
(181, 181, 1, 6, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 09:12:19', '2025-04-03 09:12:19'),
(182, 182, 1, 6, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 09:15:59', '2025-04-03 09:15:59'),
(183, 183, 1, 7, 1, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 09:20:45', '2025-04-03 09:20:45'),
(184, 184, 1, 7, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 09:26:10', '2025-04-03 09:26:10'),
(185, 185, 1, 7, 1, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 09:32:13', '2025-04-10 19:46:25'),
(186, 186, 1, 7, 1, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 09:37:08', '2025-04-03 09:37:08'),
(187, 187, 1, 5, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-04 07:38:30', '2025-04-04 07:38:30'),
(188, 188, 1, 7, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 03:28:10', '2025-04-22 03:28:10'),
(189, 189, 1, 1, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 03:55:42', '2025-04-22 03:55:42'),
(190, 190, 1, 8, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 04:09:57', '2025-04-22 04:09:57'),
(191, 191, 1, 7, 1, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-22 04:13:15', '2025-04-22 04:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `studentdbs`
--

CREATE TABLE `studentdbs` (
  `id` int(10) UNSIGNED NOT NULL,
  `studentid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid_auto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admBookNo` int(10) UNSIGNED DEFAULT NULL,
  `admSlNo` int(10) UNSIGNED DEFAULT NULL,
  `admDate` date DEFAULT NULL,
  `prCls` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prSch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adhaar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fadhaar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `madhaar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `vill1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vill2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pstn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dist` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobl1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobl2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_grp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cste` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `natn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `micr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bnnm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brnm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stclass_id` int(11) DEFAULT NULL,
  `stsection_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `streason` int(11) DEFAULT NULL,
  `enclass_id` int(11) DEFAULT NULL,
  `ensection_id` int(11) DEFAULT NULL,
  `ensession_id` int(11) DEFAULT NULL,
  `enreason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_ref_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_ref_brthcrt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_ref_adhaar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `crstatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentdbs`
--

INSERT INTO `studentdbs` (`id`, `studentid`, `uuid_auto`, `admBookNo`, `admSlNo`, `admDate`, `prCls`, `prSch`, `name`, `adhaar`, `fname`, `fadhaar`, `mname`, `madhaar`, `dob`, `vill1`, `vill2`, `post`, `pstn`, `dist`, `pin`, `state`, `mobl1`, `mobl2`, `ssex`, `blood_grp`, `phch`, `relg`, `cste`, `natn`, `accNo`, `ifsc`, `micr`, `bnnm`, `brnm`, `stclass_id`, `stsection_id`, `session_id`, `school_id`, `streason`, `enclass_id`, `ensection_id`, `ensession_id`, `enreason`, `img_ref_profile`, `img_ref_brthcrt`, `img_ref_adhaar`, `user_id`, `crstatus`, `remarks`, `created_at`, `updated_at`) VALUES
(21, NULL, 'LFS202526001', 1, 1, '2025-04-04', NULL, NULL, 'Anas Aktar', '6619 4188 4097', 'Md. Aktar Ali', '', 'Umme Habiba', '', '2020-10-06', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9614417887', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/21_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 08:21:04'),
(22, NULL, 'LFS202526002', 1, 1, '2025-03-31', NULL, NULL, 'Rehanth Rouson', '3285 4536 4084', 'Rakesh Rouson', '', 'Tania Islam', '', '2021-08-01', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7365016889', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/22_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 19:39:44'),
(23, NULL, 'LFS202526006', 1, 1, '2025-04-01', NULL, NULL, 'MD Emon Sekh', '9642 9071 0017', 'MD Palash', '', 'Jinnatara Khatun', '', '2020-11-10', 'Mahisasthali', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6296831029', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/23_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:34:58'),
(24, NULL, 'LFS202526003', 1, 1, '2025-04-01', NULL, NULL, 'Inaya Hoque', '0', 'Emdadul Hoque', '', 'Shikha Khatun', '', '2021-06-10', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933455055', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/24_profile.jpg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:35:09'),
(25, NULL, 'LFS202526008', 1, 0, '2025-04-01', NULL, NULL, 'Mahir Sk', '0', 'Mamun Sk', '', 'Khusbu Parvin', '', '2020-12-23', 'Jalibagicha', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9749802876', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/25_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:34:39'),
(26, NULL, 'LFS202526007', 1, 1, '2025-04-08', NULL, NULL, 'Imrose Sk', '6482 2884 5260', 'Belal Sk ', NULL, 'Chumki Khatun', NULL, '2020-12-19', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7908266868', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/26_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:25:51'),
(27, NULL, 'LFS202526009', 1, 0, '2025-04-01', NULL, NULL, 'Fahmin Hoque', '7333 5333 0654', 'MD Tofijul Hoque', NULL, 'Baby Najnin', NULL, '2021-08-03', 'Kalinagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6296936247', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/27_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:37:13'),
(28, NULL, 'LFS202526010', 1, 1, '2025-04-04', NULL, NULL, 'Dipto Saha', '7699 3641 6414', 'Dibbendu Saha', NULL, 'Suparna Saha', NULL, '2020-11-20', 'Mahisasthali', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7679143534', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/28_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 05:53:26'),
(29, NULL, 'LFS202526011', 1, 0, '2025-03-29', NULL, NULL, 'Faiz Sk', '7260 5726 3006', 'Mejarul Sk', NULL, 'Tunjila Khatun', NULL, '2021-02-05', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9933013242', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/29_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 08:54:54'),
(30, NULL, 'LFS202526004', 1, 1, '2025-04-08', NULL, NULL, 'Alija Afreen', '6899 5857 2951', 'Jamal Asif', NULL, 'Khadija Khatun', NULL, '2021-06-03', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8158800931', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/30_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:26:09'),
(31, NULL, 'LFS202526064', 1, 1, '2025-03-29', NULL, NULL, 'Fahim Hoque', '4294 8832 4208', 'Injamamul Hoque', NULL, 'Farida Khatun Hoque', NULL, '2020-09-23', 'Altabartala', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9414115936', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/31_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 08:55:37'),
(32, '20251111', 'LFS202223019', 2, 21, '2025-03-29', NULL, NULL, 'Aayan Abid', '2222 4444 5555', 'Milon Sk', '', 'Sabia Sultana', '', '2018-05-15', 'Dayanagar', 'aaaa', 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8945807511', NULL, 'male', 'B+', 'No', 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/32_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 10:48:53'),
(33, NULL, 'LFS202223013', 1, 1, '2025-03-29', NULL, NULL, 'Fahim Islam', '', 'Sariful Islam', NULL, 'SAHINA KHATUN', NULL, '2017-12-24', 'mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6289034414', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/33_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:05:56'),
(34, NULL, 'LFS202122019', 1, 1, '2025-03-29', NULL, NULL, 'Enaya Sarkar', '', 'Eazaj Al Amin', NULL, 'SUMITA KHATUN', NULL, '2017-12-10', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933641783', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/34_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:07:52'),
(35, NULL, 'LFS202223014', 1, 1, '2025-04-01', NULL, NULL, 'Faiza Aktar', '', 'Md Hasibul Hoque', NULL, 'NASRIN AKTAR', NULL, '2017-09-03', 'Dayanagar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9775414454', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/35_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:35:12'),
(36, NULL, 'LFS202324014', 1, 1, '2025-04-01', NULL, NULL, 'Aarfa Khan', '', 'Mehedi Alam Khan', NULL, 'Rejina Khatun', NULL, '2017-09-03', 'Dayanagar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9609272847', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/36_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:35:42'),
(37, NULL, 'LFS202223004', 1, 1, '2025-03-29', NULL, NULL, 'Sara Anjum', '', 'Saddam Hossain', NULL, 'RAHIMA BIBI', NULL, '2018-03-22', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9339230192', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/37_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:10:49'),
(38, NULL, 'LFS202324016', 1, 1, '2025-04-01', NULL, NULL, 'Noman Alam', '', 'Shukre Alam', NULL, 'Najnin Aktar', NULL, '2018-02-10', 'Mahesh Narayan Ganj', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9775270047', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/38_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:36:02'),
(39, NULL, 'LFS202324041', 1, 1, '2025-04-08', NULL, NULL, 'Mahir Sk', '', 'Asgar Ali', NULL, 'Sanuwara Bibi', NULL, '2017-10-03', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9547089126', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/39_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 14:25:16'),
(40, NULL, 'LFS202324045', 1, 1, '2025-04-08', NULL, NULL, 'Aman Hossain', '', 'Arif Hossain', NULL, 'Naseeba Bibi', NULL, '2017-12-11', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6296230180', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/40_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 14:26:49'),
(41, NULL, 'LFS202324038', 1, 1, '2025-04-01', NULL, NULL, 'Asrat Safi', '', 'Md Mithun Sk', NULL, 'Hasiba Khatun', NULL, '2017-05-23', 'Hanumantnagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8116356940', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/41_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:36:55'),
(42, NULL, 'LFS202324051', 1, 1, '2025-04-01', NULL, NULL, 'Sara Hossain', '', 'Saddam Hossain', NULL, 'Semily Khatun', NULL, '2017-12-11', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6297022098', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/42_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:37:16'),
(43, NULL, 'LFS202223017', 1, 1, '2025-04-08', NULL, NULL, 'Arbin Islam', '', 'Md Sahidul Islam', NULL, 'Poly Bibi', NULL, '2016-09-09', 'Bhabanipur', NULL, 'Krishnapur', 'Lalgola', 'Murshidabad', '742148', 'West Bengal', '9732689769', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/43_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 14:26:06'),
(44, NULL, 'LFS202223034', 1, 1, '2025-03-31', NULL, NULL, 'Nusrat Khatun', '', 'Motahar Hossain', NULL, 'PINKI KHATUN', NULL, '2017-12-09', 'Kantanagar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9000260750', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/44_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:35:52'),
(45, NULL, 'LFS202122018', 1, 1, '2025-04-01', NULL, NULL, 'Ramisa Khatun', '', 'Halim Saikh', NULL, 'Bilkish Khatun', NULL, '2017-11-28', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8170803190', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/45_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:37:57'),
(46, NULL, 'LFS202223021', 1, 1, '2025-03-29', NULL, NULL, 'Faria Islam Mimi', '', 'Sahidul Islam', NULL, 'Habiba bibi', NULL, '2016-05-17', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7679234604', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/46_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:44:54'),
(47, NULL, 'LFS202122004', 1, 1, '2025-03-31', NULL, NULL, 'Saheli Sabnam', '', 'Md Mobassar Ali', NULL, 'TUHINA BIBI', NULL, '2016-08-17', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7001159758', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/47_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:36:36'),
(48, NULL, 'LFS202324047', 1, 1, '2025-04-01', NULL, NULL, 'Said Aktar', '', 'Mustofa Sk', NULL, 'Habiba Bibi', NULL, '2016-12-14', 'Ramnapara', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7384255801', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/48_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:39:02'),
(49, NULL, 'LFS202324053', 1, 1, '2025-03-29', NULL, NULL, 'Abdul Aziz', '', 'Milon Sekh', NULL, 'Auliya Bibi', NULL, '2015-04-11', 'kashipur', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8640080577', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/49_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:47:52'),
(50, NULL, 'LFS202223005', 1, 1, '2025-03-29', NULL, NULL, 'Rahida Parvin', '', 'Rasel Sk', NULL, 'Eliza Bibi', NULL, '2017-01-01', 'Kashidanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8653132689', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/50_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:48:31'),
(51, NULL, 'LFS202223030', 1, 1, '2025-04-08', NULL, NULL, 'Riaj Sk', '', 'Selim Sk', NULL, 'Rabia Bibi', NULL, '2017-01-20', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8972582624', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/51_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 14:27:27'),
(52, NULL, 'LFS202122001', 1, 1, '2025-03-29', NULL, NULL, 'Anas Hoque', '', 'Milon Sk', NULL, 'AYESHA BIBI', NULL, '2016-04-14', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9153708130', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/52_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:50:19'),
(53, NULL, 'LFS202324025', 1, 1, '2025-04-01', NULL, NULL, 'Sangita Mondal', '9130 6519 0199', 'Satyaban Mondal', NULL, 'July Mondal', NULL, '2017-02-07', 'Kantanagar', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7047014507', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 6, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/53_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:40:05'),
(54, NULL, 'LFS202122010', 1, 1, '2025-03-31', NULL, NULL, 'Anisha Aktar', '', 'Md Aktar Ali', NULL, 'UMME HABIBA', NULL, '2015-09-18', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9614417887', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/54_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:37:21'),
(55, NULL, 'LFS201920001', 1, 1, '2025-03-29', NULL, NULL, 'Nafisa Hoque', '', 'Emdadul Hoque', NULL, 'SIKHA KHATUN', NULL, '2016-03-02', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933455055', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/55_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:53:46'),
(56, NULL, 'LFS202324032', 1, 1, '2025-04-01', NULL, NULL, 'Sajeeda Noushin', '2324 3819 0834', 'Md Abul Fazal', NULL, 'Mst Sahida Begum', NULL, '2015-11-03', 'Rajanagar', NULL, 'Laskarpur', 'Lalgola', 'Murshidabad', '742148', 'West Bengal', '8016216416', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/56_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:40:54'),
(57, NULL, 'LFS202122011', 1, 1, '2025-04-04', NULL, NULL, 'Salma Aktar', '', 'Md Golam Moula', NULL, 'SINA AKTAR', NULL, '2016-06-29', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9732999201', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/57_profile.jpg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 13:56:42'),
(58, NULL, 'LFS201920079', 1, 1, '2025-03-29', NULL, NULL, 'Fatematu Johora', '', 'Md Abdul Hamid', NULL, 'RIPA BIBI', NULL, '2015-01-15', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8343005772', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/58_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:57:00'),
(59, NULL, 'LFS202324059', 1, 1, '2025-04-01', NULL, NULL, 'Rafaz Ahmed', '', 'Jainuddin Ahmed', NULL, 'Rashia Khatun', NULL, '2015-05-18', 'Jalibagicha', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8101906892', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/59_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:41:14'),
(60, NULL, 'LFS202122030', 1, 1, '2025-03-29', NULL, NULL, 'Abir Ahmed', '', 'Ikhtar Ahmed', NULL, 'JESMINA KHATUN', NULL, '2015-02-18', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9365998080', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/60_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-29 09:59:03'),
(61, NULL, 'LFS201920060', 1, 1, '2025-03-30', NULL, NULL, 'Farhan Hoque', '', 'Injamamul Hoque', NULL, 'FARIDA KHATUN HOQUE', NULL, '2015-11-08', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9614115936', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/61_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:04:42'),
(62, NULL, 'LFS202425006', 1, 1, '2025-04-01', NULL, NULL, 'Faiyad Abrar', '', 'Sadikul Islam', NULL, 'Tanjila Ferdousha Khanam', NULL, '2015-07-21', 'Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8670114544', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/62_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:41:40'),
(63, NULL, 'LFS202122008', 1, 1, '2025-03-30', NULL, NULL, 'Swellehin Alom Mondal', '5494 2360 1141', 'Md Mehebub Alom', NULL, 'Sumaiya Khatun', NULL, '2015-03-29', 'Habaspur Mathpara', NULL, 'Habaspur', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7384782689', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/63_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:06:52'),
(64, NULL, 'LFS201920069', 1, 1, '2025-04-04', NULL, NULL, 'Ayan Uman', '', 'Md Wasin Reja', NULL, 'Tuhina Parvin', NULL, '2015-06-23', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8972104504', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/64_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:59:45'),
(65, NULL, 'LFS201920075', 1, 1, '2025-04-01', NULL, NULL, 'Nusrat Alam', '', 'Md Jahangir Alam', NULL, 'Akhtara Bibi', NULL, '2015-10-14', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9093226997', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/65_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:42:03'),
(66, NULL, 'LFS201920083', 1, 1, '2025-03-30', NULL, NULL, 'Ridwan Hasan', '', 'Sukuruddin', NULL, 'UMME KULSUM', NULL, '2015-10-22', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8906369403', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 7, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/66_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:10:03'),
(67, NULL, 'LFS201920002', 1, 1, '2025-04-04', NULL, NULL, 'Atique Hossain', '', 'Md Ali Hossain', NULL, 'Rabia Khatun', NULL, '2014-10-06', 'Kantanagar', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8670015537', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 8, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/67_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:45:19'),
(68, NULL, 'LFS201920070', 1, 1, '2025-03-30', NULL, NULL, 'Sayan Hasan', '', 'Mehedi Hasan', NULL, 'RUMA YASMIN', NULL, '2015-04-28', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6294267877', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 8, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/68_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:13:38'),
(69, NULL, 'LFS201920082', 1, 1, '2025-04-01', NULL, NULL, 'Abu Asis Amin', '', 'Abu Nasher Amin', NULL, 'ALIYA PARVIN', NULL, '2014-10-05', 'Kalinagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9733455714', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 8, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/69_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:43:15'),
(70, NULL, 'LFS202324001', 1, 1, '2025-04-01', NULL, NULL, 'Ayush Sonar', '7646 5325 9267', 'Santosh Sonar', NULL, 'Rubi Sonar', NULL, '2013-03-14', 'Mahesh Narayan Ganj', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9123675157', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 8, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/70_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:42:35'),
(71, NULL, 'LFS201920074', 1, 1, '2025-04-01', NULL, NULL, 'Fahad Mobarat', '', 'Golam Murtuza', NULL, 'MODINA BIBI', NULL, '2014-09-04', 'Kalinagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9749232425', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 8, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/71_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:43:34'),
(75, NULL, 'LFS202425001', 1, 1, '2025-04-01', NULL, NULL, 'Arindam Saha', '', 'SOUMEN SAHA', NULL, 'ANUSRI SAHA', NULL, '2020-09-23', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8926748931', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/75_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:38:41'),
(76, NULL, 'LFS202425004', 1, 1, '2025-03-31', NULL, NULL, 'Anik Ali', '', 'AKBAR ALI', NULL, 'SABNAM KHATUN', NULL, '2020-04-06', 'Maheshnarayanganj', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9153620634', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/76_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:21:35'),
(77, NULL, 'LFS202425003', 1, 1, '2025-03-31', NULL, NULL, 'Anish Islam', '', 'NOOR ISLAM', NULL, 'MEHERUNNESHA', NULL, '2020-04-05', 'Maheshnarayanganj', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7679404854', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/77_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:23:11'),
(78, NULL, 'LFS202425023', 1, 1, '2025-03-31', NULL, NULL, 'Priyam Poddar', '', 'PROTIM PODDAR', NULL, 'DEBIKA GHOSH PODDAR', NULL, '2021-03-28', 'Maheshnarayanganj', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8926838770', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/78_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:23:40'),
(79, NULL, 'LFS202425025', 1, 1, '2025-03-31', NULL, NULL, 'Aman Islam', '', 'MD SARIFUL ISLAM', NULL, 'RIJIA SULTANA', NULL, '2020-10-12', 'Sekhpara', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7602415384', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/79_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:24:06'),
(80, NULL, 'LFS202526040', 1, 1, '2025-04-22', NULL, NULL, 'Abdul Samir', '', 'Abdur Rakib', '', 'Ruma Khatun', NULL, '2019-10-02', 'Natunpara Kashiyadanga', '', 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8158802274', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/80_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-22 03:46:36'),
(81, NULL, 'LFS202526035', 1, 1, '2025-04-01', NULL, NULL, 'Mariyam Khatun', '3676 9415 8254', 'Saddam Sk', NULL, 'Meherunnesa Khatun', NULL, '2019-10-13', 'Altabartala', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8759176792', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/81_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:41:39'),
(82, NULL, 'LFS202526012', 1, 1, '2025-04-01', NULL, NULL, 'Suhana Aktar', '3869 4648 3708', 'Abdul Sahid', NULL, 'Rama Khatun', NULL, '2021-01-14', 'Kantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7305204802', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/82_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:42:14'),
(83, NULL, 'LFS202526034', 1, 1, '2025-04-01', NULL, NULL, 'Nur Nabi', '7590 9250 7396', 'Sariful Sk', NULL, 'Nur Mahal', NULL, '2020-09-07', 'Kupkandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9002109391 ', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/83_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:42:45'),
(84, NULL, 'LFS202526033', 1, 1, '2025-04-08', NULL, NULL, 'Arin KAYES', '5637 2493 1035', 'Imrul Kayes', NULL, 'Tarin Akther', NULL, '2021-02-04', 'N.Para Kashiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8101088787', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/84_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:27:07'),
(85, NULL, 'LFS202526032', 1, 1, '2025-04-08', NULL, NULL, 'Tamanna Khatun', '', 'Lalchad Sk', NULL, 'Tahida Khatun', NULL, '2020-08-25', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7063330027', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/85_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:29:10'),
(86, NULL, 'LFS202526031', 1, 1, '2025-04-01', NULL, NULL, 'Rizwan Sk', '2216 6470 6333', 'Mustakim Sk', NULL, 'Rubina Khatun', NULL, '2020-09-22', 'Kashiyadanga Uttar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8597417778', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/86_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:44:30'),
(87, NULL, 'LFS202526030', 1, 1, '2025-03-30', NULL, NULL, 'Jisan Sk', '7726 4301 8045', 'Nurul Islam', NULL, 'Late Rina Khatun', NULL, '2020-09-22', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7047686270', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/87_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:38:30'),
(88, NULL, 'LFS202526016', 1, 1, '2025-04-01', NULL, NULL, 'Sanbi Sarkar', '6490 4492 3832', 'Kiron Sarkar', NULL, 'Salma Khatun', NULL, '2020-07-28', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9002935690', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/88_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:44:55'),
(89, NULL, 'LFS202526023', 1, 1, '2025-04-01', NULL, NULL, 'Pratiusha Pal', '4353 9068 9788', 'Pradip Kumar Pal', NULL, 'Priya Sarkar', NULL, '2020-10-29', 'Mohisastholi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8906136882', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/89_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:45:28'),
(90, NULL, 'LFS202526024', 1, 1, '2025-04-08', NULL, NULL, 'Salma Jahan', '', 'Ayantani Sk', NULL, 'Sabna Khatun', NULL, '2020-07-05', 'Dakshin HanumantaNagar', NULL, 'B.Gola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9124005054', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/90_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:30:43'),
(91, NULL, 'LFS202526025', 1, 1, '2025-03-31', NULL, NULL, 'Salma Khatun', '', 'MD Abu Sayeed', NULL, 'Samima Khatun', NULL, '2021-01-14', 'Kashiyadanga Uttar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9563613210', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/91_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:26:57'),
(92, NULL, 'LFS202526026', 1, 1, '2025-04-01', NULL, NULL, 'Aarika', '', 'Sekender Ali Parbhej', NULL, 'Yeasmin Khatun', NULL, '2020-07-27', 'Kashiyadanga Uttar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7029965686', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/92_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:46:27'),
(93, NULL, 'LFS202526027', 1, 1, '2025-04-08', NULL, NULL, 'Shayed Ansari', '6572 0382 8172', 'Ramiz Raja', NULL, 'Shyamali Khatun', NULL, '2020-09-29', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9432171452', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/93_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:38:08'),
(94, NULL, 'LFS202526028', 1, 1, '2025-04-22', NULL, NULL, 'Rafida Hasan', '6660 5608 1372', 'Hasan Ali', NULL, 'Rakiba Khatun', NULL, '2020-02-20', 'Hanumantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8016875116', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/94_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-22 03:37:15'),
(95, NULL, 'LFS202526029', 1, 1, '2025-04-01', NULL, NULL, 'Ayat Zamya', '4603 7748 9484', 'MD Moin Islam', NULL, 'Rajibunnesha Khatun', NULL, '2021-05-18', 'Darakandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '6297005859', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/95_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:47:46'),
(96, NULL, 'LFS202526015', 1, 1, '2025-04-04', NULL, NULL, 'Arif Sk', '3978 2415 1344', 'Samirul Sk', NULL, 'Tahamina Bibi', NULL, '2018-03-13', 'Kashipur Naharpara', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933165420', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/96_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:14:18'),
(97, NULL, 'LFS202526022', 1, 1, '2025-03-30', NULL, NULL, 'Simran', '7619 2019 7174', 'Sarikul', NULL, 'Mousumi Khatun', NULL, '2020-05-16', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933596018', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/97_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:46:01'),
(98, NULL, 'LFS202526021', 1, 1, '2025-04-04', NULL, NULL, 'Mahir Faisal', '5088 8140 0772', 'Jiarul Hoque', NULL, 'Mamotaz Begam', NULL, '2020-10-10', 'Kalinagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8159043890', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/98_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:09:18'),
(99, NULL, 'LFS202526014', 1, 1, '2025-04-04', NULL, NULL, 'Naznin Fatema', '', 'Mizanul Islam', NULL, 'Nurjema Khatun', NULL, '2021-01-11', 'Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8597211908', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/99_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:11:38'),
(100, NULL, 'LFS202526043', 1, 1, '2025-03-30', NULL, NULL, 'RAFID MEHEFUZ', '', 'ABDUR ROUF', NULL, 'SOBNAM MOSTARI', NULL, '2020-08-15', 'Kashiyadanga Uttar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9775007525', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/100_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:48:08'),
(101, NULL, 'LFS202526020', 1, 1, '2025-03-30', NULL, NULL, 'Rahi Pal', '8305 7005 8501', 'Rintu Pal', NULL, 'Pali Singha', NULL, '2020-10-22', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9641878454', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/101_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:49:19'),
(102, NULL, 'LFS202526017', 1, 1, '2025-04-01', NULL, NULL, 'Ayaan Roushan', '', 'Rakesh Roushan', NULL, 'Runa Khatun', NULL, '2019-06-25', 'Mahesh Narayanganj', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7908385381', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/102_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:49:39'),
(103, NULL, 'LFS202526039', 1, 1, '2025-03-30', NULL, NULL, 'Sayed Tashfeen Imad', '', 'Sayed Abdul Hadi', NULL, 'Lucky Khatun', NULL, '2020-08-17', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', NULL, 'W.B', '00000000', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/103_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:40:49'),
(104, NULL, 'LFS202526019', 1, 1, '2025-04-01', NULL, NULL, 'Ankit Mandal', '2256 0051 0029', 'Pratap Kumar Mandal', NULL, 'Chandana Mandal', NULL, '2020-10-16', 'Chak Bhojraj', NULL, 'Krishnapur Dinurpara', 'Lalgola', 'Murshidabad', '742148', 'W.B', '9775768842', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/104_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:50:16'),
(105, NULL, 'LFS202526018', 1, 1, '2025-04-22', NULL, NULL, 'Humaira Yeasmin', '7487 4647 9404', 'Sariful Islam', NULL, 'Sabina Yeasmin', NULL, '2020-06-28', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9002318556', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/105_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-22 03:35:07'),
(106, NULL, 'LFS202526013', 1, 1, '2025-04-08', NULL, NULL, 'Junaid Islam', '3484 1459 2135', 'Sariful Islam', NULL, 'Beauty Khatun', NULL, '2020-12-19', 'N.Para Kashiyadanga', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9932175029', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/106_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:38:52'),
(107, NULL, 'LFS202526037', 1, 1, '2025-03-30', NULL, NULL, 'Riyaz Sk', '', 'Dolon Sk', NULL, 'Sikha Khatun', NULL, '2020-02-16', 'Mahesh Narayan Ganj', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '6296198189', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/107_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:42:07'),
(108, NULL, 'LFS202526042', 1, 1, '2025-03-31', NULL, NULL, 'Afiya Arshin', '', 'Abu Hena', NULL, 'Rousanara Khatun', NULL, '2021-03-04', 'Barsatigola', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9153840282', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/108_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 22:28:40'),
(109, NULL, 'LFS202526038', 1, 1, '2025-03-30', NULL, NULL, 'FARIHA ISLAM', '', 'SARIFUL ISLAM', NULL, 'SAHINA KHATUN', NULL, '2021-03-10', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8536823438', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/109_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:52:20'),
(110, NULL, 'LFS202324021', 1, 1, '2025-04-01', NULL, NULL, 'Nazmin Sultana', '', 'Nazir Ahmed', NULL, 'Tahamina Khatun', NULL, '2018-07-12', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9932827156', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/110_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:07:29'),
(111, NULL, 'LFS202324031', 1, 1, '2025-03-30', NULL, NULL, 'Md Nur Alom', '3036 7572 7189', 'MD Saifullah', NULL, 'Sabnur Khatun', NULL, '2018-12-22', 'Darakandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9851317248', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/111_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:44:49'),
(112, NULL, 'LFS202324026', 1, 1, '2025-04-01', NULL, NULL, 'Ayan Islam', '', 'Sariful Islam', NULL, 'Shikha Khatun', NULL, '2018-03-15', 'Hanumantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7583945418', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/112_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:08:07'),
(113, NULL, 'LFS202324055', 1, 1, '2025-04-01', NULL, NULL, 'Dishad Ahamed', '3162 3452 8551', 'Hasibul Islam', NULL, 'Behula Bibi', NULL, '2018-11-15', 'Kupkandhi', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9679050257', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/113_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:08:40'),
(114, NULL, 'LFS202324028', 1, 1, '2025-04-01', NULL, NULL, 'Ankita Mandal', '8740 6747 4420', 'Pradip Mandal', NULL, 'Shefali Mandal', NULL, '2018-09-26', 'Kantanagar', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9800490120', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/114_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:12:16'),
(115, NULL, 'LFS202324035', 1, 1, '2025-04-01', NULL, NULL, 'Fariya Khanam', '', 'Mitun Sk', NULL, 'Mastura Khatun', NULL, '2017-10-28', 'Jalibagicha', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8918968183', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/115_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:09:26'),
(116, NULL, 'LFS202324042', 1, 1, '2025-04-01', NULL, NULL, 'Minhaj Seakh', '', 'Mursalim Sk', NULL, 'Masenur Bibi', NULL, '2018-05-14', 'Kalinagar', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7029659155', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/116_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:09:49'),
(117, NULL, 'LFS202324027', 1, 1, '2025-04-08', NULL, NULL, 'Jasika Sabnam', '', 'Harejul Sk', NULL, 'Afika Khatun', NULL, '2018-07-19', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7074155153', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/117_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 14:24:31'),
(118, NULL, 'LFS202324037', 1, 1, '2025-04-01', NULL, NULL, 'AL Toush Abir Ali', '3350 2515 3504', 'MD Sabir Ali', NULL, 'Tripti Katun', NULL, '2018-10-21', 'Kupkandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9382155223', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/118_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:12:59'),
(119, NULL, 'LFS202324034', 1, 1, '2025-04-01', NULL, NULL, 'Ayan Sk', '4234 8220 0697', 'Sofik Sk', NULL, 'Jhuma Bibi', NULL, '2018-11-24', 'Kashiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8116708595', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/119_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:13:27'),
(120, NULL, 'LFS202425008', 1, 1, '2025-04-08', NULL, NULL, 'Jamela Khatun', '', 'Kousar Ali', NULL, 'Sabana Khatun', NULL, '2019-01-03', 'N,Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', NULL, 'West Bengal', '7001390723', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/120_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 14:24:02'),
(121, NULL, 'LFS202324044', 1, 1, '2025-04-04', NULL, NULL, 'Zain Ikbal', '', 'Towsif Ikbal', NULL, 'Mehen Negar Khatun', NULL, '2018-12-17', 'Barsatigola', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8906317778', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/121_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:39:57'),
(122, NULL, 'LFS202223023', 1, 1, '2025-03-30', NULL, NULL, 'Ayanur Rahaman', '', 'Hasibur Rahaman', NULL, 'Baby Sahanaj', NULL, '2018-06-21', 'Dayanagar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9002583759', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/122_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:49:17'),
(123, NULL, 'LFS202324048', 1, 1, '2025-04-01', NULL, NULL, 'Saib Aktar', '', 'Mustofa Sk', NULL, 'Habiba Bibi', NULL, '2018-06-10', 'Ramnapara', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7384255801', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/123_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:26:00'),
(124, NULL, 'LFS202526057', 1, 1, '2025-03-30', NULL, NULL, 'Nourin Anjum', '', 'Md Altaf Hossain', NULL, 'Nazma Parvin', NULL, '2018-09-22', 'Hanumantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8942027508', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/124_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:51:32'),
(125, NULL, 'LFS202526055', 1, 1, '2025-03-30', NULL, NULL, 'Yousof Sekh', '', 'Jiarul Rahaman', NULL, 'Sadika Bibi', NULL, '2018-05-02', 'Kasiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8670010701', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/125_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:51:56'),
(126, NULL, 'LFS202526058', 1, 1, '2025-03-30', NULL, NULL, 'Mim Mahammad', '', 'Rajesh Sk', NULL, 'Tumpa Bibi', NULL, '2018-07-09', 'Kasiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8597245267', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/126_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:52:20'),
(127, NULL, 'LFS202526059', 1, 1, '2025-04-04', NULL, NULL, 'SAMIM SEKH', '', 'RAJESH SK', NULL, 'TUMPA BIBI', NULL, '2018-07-09', 'Kasiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8597245267', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/127_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:42:23'),
(128, NULL, 'LFS202526056', 1, 1, '2025-04-04', NULL, NULL, 'HASNAHENA KHATUN', '', 'HAKIM SK', NULL, 'MOYNA BIBI', NULL, '2017-10-30', 'Charabangola', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '6296040421', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/128_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:44:04'),
(129, NULL, 'LFS202324010', 1, 1, '2025-03-30', NULL, NULL, 'SARFARAZ KARIM', '', 'MASUM KARIM', NULL, 'TAKDIRA KHATUN', NULL, '2017-06-12', 'Dayanagar', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9932008510', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/129_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:53:15'),
(130, NULL, 'LFS202324052', 1, 1, '2025-03-30', NULL, NULL, 'Ankush Mandal', '', 'Pratik Mondal', NULL, 'Dipali Mandal', NULL, '2018-10-28', 'Kantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '6297318481', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/130_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:53:43'),
(131, NULL, 'LFS202425012', 1, 1, '2025-03-30', NULL, NULL, 'Sadiya Islam', '', 'Sariful Islam', NULL, 'Nasrin Sultana', NULL, '2019-08-02', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8158066697', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/131_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:53:08'),
(132, NULL, 'LFS202425060', 1, 1, '2025-03-31', NULL, NULL, 'Arnab Roy', '', 'Ashim Roy', NULL, 'Barnali Bahalia', NULL, '2019-03-28', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8016336728', NULL, 'male', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/132_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 21:30:54');
INSERT INTO `studentdbs` (`id`, `studentid`, `uuid_auto`, `admBookNo`, `admSlNo`, `admDate`, `prCls`, `prSch`, `name`, `adhaar`, `fname`, `fadhaar`, `mname`, `madhaar`, `dob`, `vill1`, `vill2`, `post`, `pstn`, `dist`, `pin`, `state`, `mobl1`, `mobl2`, `ssex`, `blood_grp`, `phch`, `relg`, `cste`, `natn`, `accNo`, `ifsc`, `micr`, `bnnm`, `brnm`, `stclass_id`, `stsection_id`, `session_id`, `school_id`, `streason`, `enclass_id`, `ensection_id`, `ensession_id`, `enreason`, `img_ref_profile`, `img_ref_brthcrt`, `img_ref_adhaar`, `user_id`, `crstatus`, `remarks`, `created_at`, `updated_at`) VALUES
(133, NULL, 'LFS202324003', 1, 1, '2025-03-31', NULL, NULL, 'Karim Sk', '', 'Kamrul Sk', NULL, 'ROKIA KHATUN', NULL, '0000-00-00', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7318844661', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/133_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 21:31:28'),
(134, NULL, 'LFS202425031', 1, 1, '2025-04-01', NULL, NULL, 'Maisha Bepary', '', 'Manik Bepary', NULL, 'Dola Bepary', NULL, '2019-11-24', 'Kalukhali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '6291196701', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/134_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:53:43'),
(135, NULL, 'LFS202526033', 1, 1, '2025-04-01', NULL, NULL, 'Fariha Khatun', '', 'Chand Mohammad', NULL, 'Fatema Khatun', NULL, '2019-07-25', 'Kupkandhi', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7384036660', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/135_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:54:09'),
(136, NULL, 'LFS202425022', 1, 1, '2025-03-31', NULL, NULL, 'Iyan Ali', '', 'Imran Ali', NULL, 'Salema Sultana', NULL, '2019-10-27', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8345051648', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/136_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 21:33:06'),
(137, NULL, 'LFS202425021', 1, 1, '2025-04-01', NULL, NULL, 'Muskan Khatun', '8134 8602 6618', 'Manowar Hossain', NULL, 'Sumita Khatun', NULL, '2019-09-12', 'Debipur', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8167057767', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/137_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:54:35'),
(138, NULL, 'LFS202425030', 1, 1, '2025-04-01', NULL, NULL, 'Abdul Rahaman', '', 'Abu Salam', NULL, 'Samima Bibi', NULL, '2018-10-22', 'Kupkandhi', NULL, 'Benipur', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8101372057', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/138_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:54:54'),
(139, NULL, 'LFS202425032', 1, 1, '2025-04-01', NULL, NULL, 'Aradhya Mondal', '', 'Rajesh Mondal', NULL, 'Shraboni Pramanik Mondal', NULL, '2019-07-16', 'Chak Bhojraj', NULL, 'Lalgola', 'Lalgola', 'Murshidabad', '742148', 'W.B', '9732390480', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/139_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:55:22'),
(140, NULL, 'LFS202425032', 1, 1, '2025-04-08', NULL, NULL, 'Tanvir Islam', '4609 7981 0229', 'Somenul Islam', NULL, 'Samima Khatun', NULL, '2019-07-03', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7699837162', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/140_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:32:33'),
(141, NULL, 'LFS202425011', 1, 1, '2025-04-08', NULL, NULL, 'Ayan Hossain', '', 'Alamgir Hossain', NULL, 'Bauti Khatun', NULL, '2019-08-02', 'N.Para Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7699944214', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/141_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:33:05'),
(142, NULL, 'LFS202425018', 1, 1, '2025-03-31', NULL, NULL, 'Md Farhan Ali Khan', '', 'Ishmail Sk', NULL, 'MURSHIDA BIBI', NULL, '2019-04-11', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9907156923', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/142_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 21:35:14'),
(143, NULL, 'LFS202425013', 1, 1, '2025-04-01', NULL, NULL, 'Sarfaraz Sk', '', 'Md Selim Sekh', NULL, 'RABIA KHATUN', NULL, '2019-08-03', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '8972582624', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/143_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:58:29'),
(144, NULL, 'LFS202425016', 1, 1, '2025-03-31', NULL, NULL, 'Sonal Aktar', '', 'Fazle Rabbi', NULL, 'SOMA BIBI', NULL, '2019-02-05', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9932886353', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/144_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 21:36:12'),
(145, NULL, 'LFS202324012', 1, 1, '2025-03-30', NULL, NULL, 'Sohan Ali', '', 'Ersad Ali', NULL, 'SATHI KHATUN', NULL, '2019-05-30', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9635809434', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/145_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 09:57:44'),
(146, NULL, 'LFS202425024', 1, 1, '2025-04-01', NULL, NULL, 'Khurshid Islam', '', 'Sariful Islam', NULL, 'Khadija Khatun', NULL, '2020-05-13', 'Mohisastholi', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9933850756', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/146_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 08:58:57'),
(147, NULL, 'LFS202324036', 1, 1, '2025-04-08', NULL, NULL, 'Farhad Seikh', '3750 9632 9354', 'Ripon Sk', NULL, 'Alpana Khatun', NULL, '2019-05-16', 'Char Safihazipara', NULL, 'Hanumanta Nagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7584923090', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/147_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:33:58'),
(148, NULL, 'LFS202425028', 1, 1, '2025-04-04', NULL, NULL, 'Inayat Hossain', '', 'Sher Shah Ali', NULL, 'Sabina Khatun', NULL, '2019-02-05', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', NULL, 'West Bengal', '9733744282', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/148_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:41:17'),
(149, NULL, 'LFS202425020', 1, 1, '2025-04-01', NULL, NULL, 'Rayan Shaikh', '8776 5119 6785', 'Rasel Shaikh', NULL, 'Mujima Khatun', NULL, '2019-08-20', 'Debipur', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9932838933', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/149_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:03:22'),
(150, NULL, 'LFS202425010', 1, 1, '2025-04-01', NULL, NULL, 'Romin Sk', '', 'Rajib Sk', NULL, 'Rimpa Khatun', NULL, '2019-10-19', 'Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6294872609', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/150_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:03:49'),
(151, NULL, 'LFS202425017', 1, 1, '2025-03-30', NULL, NULL, 'Yasin Alom', '', 'Mehebub Alom', NULL, 'JOTY KHATUN', NULL, '2019-02-17', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9002135696', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/151_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:00:09'),
(152, NULL, 'LFS202425036', 1, 1, '2025-03-31', NULL, NULL, 'Kiaan Jaman', '7061 2083 7766', 'Md Kamrujjaman', NULL, 'Twin Bibi', NULL, '2019-06-21', 'Puraton Kasiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '7405604165', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/152_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-31 21:55:25'),
(153, NULL, 'LFS202526053', 1, 1, '2025-03-30', NULL, NULL, 'Aayat Yasmin', '5488 8898 5517', 'Kutubuddin Sk', NULL, 'Tumpa Khatun', NULL, '2018-12-11', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7583936968', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/153_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:01:25'),
(154, NULL, 'LFS202526051', 1, 0, '2025-04-01', NULL, NULL, 'Ashwat Nayna', '5675 3703 6055', 'Washim  ', NULL, 'Nurjahan Khatun', NULL, '2019-06-24', 'Kupkandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '6297223108', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/154_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:04:14'),
(155, NULL, 'LFS202526050', 1, 0, '2025-04-01', NULL, NULL, 'Yeara khatun', '', 'Yean Ali', NULL, 'Kamrunnesa Khatun', NULL, '2019-08-07', 'Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8167045448', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/155_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:04:47'),
(156, NULL, 'LFS202526049', 1, 1, '2025-03-30', NULL, NULL, 'Evana Yesmin', '6510 6169 6586', 'Benjir Hossain', NULL, 'Tohida Yeasmin', NULL, '2019-11-23', 'Barsatigola', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8944880380', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/156_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:11:53'),
(157, NULL, 'LFS202526048', 1, 1, '2025-04-01', NULL, NULL, 'MD Rahamat Hasan', '4027 2315 8968', 'MD Tofail Hasan', NULL, 'Sakina Khatun', NULL, '2018-10-20', 'Debipur', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8972118492', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, '2025-04-01 09:05:52'),
(158, NULL, 'LFS202425027', 1, 1, '2025-03-30', NULL, NULL, 'Shreya Mondal', '', 'Tata Mondal', NULL, 'Smriti Mondal', NULL, '2019-11-25', 'Kantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7029664451', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/158_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:23:13'),
(159, NULL, 'LFS202526047', 1, 1, '2025-04-04', NULL, NULL, 'Afrin Hoque ', '6151 0001 1177', 'Enamul Hoque', NULL, 'Rubia Khatun', NULL, '2020-01-06', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7602381061', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/159_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 06:45:36'),
(160, NULL, 'LFS202526046', 1, 1, '2025-03-30', NULL, NULL, 'Rayan Sekh', '', 'MD Dablu Sk', NULL, 'Anju Manuara', NULL, '2019-12-24', 'Ruhimari', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8670205342', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/160_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:22:48'),
(161, NULL, 'LFS202526045', 1, 1, '2025-04-08', NULL, NULL, 'Nahisa Khatun', '8147 4994 3246', 'Alomgir', NULL, 'Mila Bibi', NULL, '2019-01-05', 'N.Para Kashiyadanga', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9153169266', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/161_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:34:42'),
(162, NULL, 'LFS202526044', 1, 1, '2025-04-08', NULL, NULL, 'Puspo Sonar', '2952 4304 0056', 'Sanjayram Sonar', NULL, 'Sumi Sonar', NULL, '2018-08-08', 'Debipur', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'W.B', '9800024725', NULL, 'female', NULL, NULL, 'Hindu', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/162_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:36:15'),
(163, NULL, 'LFS202425007', 1, 1, '2025-03-30', NULL, NULL, 'SANIA AFSANA', '', 'IMRAN ALI', NULL, 'SHORIFA KHATUN', NULL, '2019-10-19', 'Kantanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9932682449', NULL, 'female', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/163_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-03-30 10:25:28'),
(164, NULL, 'LFS202526054', 1, 1, '2025-04-04', NULL, NULL, 'NOORAMIN', '', 'MILAN SK', NULL, 'AULIYA BIBI', NULL, '2018-12-10', 'Kashipur', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8640080577', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/164_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-04 07:52:12'),
(165, NULL, 'LFS202526052', 1, 1, '2025-04-08', NULL, NULL, 'AHMAD HASAN', '', 'MD NUR AMIN', NULL, 'MOMINA KHATUN', NULL, '2020-11-29', 'Kashiadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7063295575', NULL, 'male', NULL, NULL, 'Muslim', 'General', 'Indian', NULL, NULL, NULL, NULL, NULL, 3, 1, 1, 1, NULL, 1, 1, 1, NULL, 'studentdb/165_profile.jpeg', NULL, NULL, 4, NULL, NULL, NULL, '2025-04-08 13:35:18'),
(166, NULL, 'LFS202526060', 1, 1, '2025-04-03', NULL, NULL, 'Fahima Aktar', NULL, 'Rajibul Hoque', NULL, 'Khadija Khatun', NULL, '2022-02-05', 'Ramnapara', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8597172324', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/166_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-03-29 09:32:05', '2025-04-03 08:36:38'),
(167, NULL, 'LFS202526005', 1, 1, '2025-03-29', NULL, NULL, 'EYANA HOSSAIN', NULL, 'ARIF HOSSAIN', NULL, 'UMMEHENA KHATUN', NULL, '2021-10-14', NULL, NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', NULL, NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/167_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-03-29 09:36:03', '2025-03-29 09:38:43'),
(168, NULL, 'LFS202526065', 1, 1, '2025-03-29', NULL, NULL, 'ANABIA HASAN', NULL, 'SUKURUDDIN', NULL, 'UMME KULSUM', NULL, '2021-02-15', 'Jalibagicha', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8906369403', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/168_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-03-29 09:42:39', '2025-03-29 10:01:03'),
(169, NULL, 'LFS202223002', 1, 1, '2025-03-31', NULL, NULL, 'IBRAHIM MEHEDI', NULL, 'MEHEDI HASAN', NULL, 'MST SUMINAZNIN', NULL, '2015-10-04', 'Kupkandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9002880788', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/169_profile.jpg', NULL, NULL, 4, NULL, NULL, '2025-03-29 10:06:37', '2025-03-31 22:18:02'),
(170, NULL, 'LFS202526068', 1, 0, '2025-03-31', NULL, NULL, 'Aahan Abid', NULL, 'Milon Sk', NULL, 'Sabia Sultana', NULL, '2021-11-15', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8945807511', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/170_profile.jpg', NULL, NULL, 4, NULL, NULL, '2025-03-29 10:52:59', '2025-03-31 22:09:05'),
(171, NULL, 'LFS202425029', 1, 1, '2025-03-31', NULL, NULL, 'MD RIDAY SK', NULL, 'MD MAJARUL SK', NULL, 'AKTARUNNESHA KHATUN', NULL, '2019-12-29', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9064460398', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/171_profile.jpg', NULL, NULL, 4, NULL, NULL, '2025-03-30 10:31:49', '2025-03-31 22:05:33'),
(172, NULL, 'LFS202526067', 1, 1, '2025-03-31', NULL, NULL, 'ANIS AMAN', NULL, 'KAMRUJJAMAN', NULL, 'ARJIA KHATUN', NULL, '2019-11-30', 'Char paikmari', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8116365457', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/172_profile.jpg', NULL, NULL, 4, NULL, NULL, '2025-03-30 10:34:44', '2025-03-31 22:06:05'),
(173, NULL, 'LFS202526063', 1, 1, '2025-04-04', NULL, NULL, 'MD TAMIM SK', NULL, 'MD SAMIM SK', NULL, 'MOUSUMI KHATUN', NULL, '2018-11-13', 'Char Natunpara', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9874165524', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/173_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-03-30 10:38:30', '2025-04-04 06:22:26'),
(174, NULL, 'LFS202526041', 1, 1, '2025-04-04', NULL, NULL, 'MEHEK KHATUN', NULL, 'MD SAMIM SK', NULL, 'MOUSUMI KHATUN', NULL, '2021-02-16', 'Char Natunpara', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9874165524', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/174_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-03-30 10:59:31', '2025-04-04 06:10:25'),
(175, NULL, 'LFS20192066', 1, 1, '2025-04-04', NULL, NULL, 'KHADIJA KHATUN', NULL, 'MD ABUL KHAYER', NULL, 'AYESHA BIBI', NULL, '2014-11-01', 'Charbalipara', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9734575923', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/175_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 08:05:31', '2025-04-04 07:51:27'),
(176, NULL, 'LFS202526062', 1, 1, '2025-04-03', NULL, NULL, 'ABDUL RAHIM', NULL, 'JOBAYEL SK', NULL, 'SAGIRUN BIBI', NULL, '2018-05-10', 'RAMNA DANGAPARA', NULL, 'MAHISASTHALI', 'BHAGWANGOLA', 'MURSHIDABAD', '742135', 'West Bengal', '7585003824', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/176_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 08:11:27', '2025-04-03 08:50:48'),
(177, NULL, 'LFS202526068', 1, 1, '2025-04-04', NULL, NULL, 'MST GULAIKHA', NULL, 'MD ABDUL KHAYER', NULL, 'AYESHA BIBI', NULL, '2019-04-14', 'Charbalipara', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9734575923', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/177_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 08:21:20', '2025-04-04 07:48:45'),
(178, NULL, 'LFS202526061', 1, 1, '2025-04-03', NULL, NULL, 'TANISA', NULL, 'JUBAIL SK', NULL, 'SAGIRAN BIBI', NULL, '2016-09-29', 'RAMNAPARA', NULL, 'MAHISASTHALI', 'BHAGWANGOLA', 'MURSHIDABAD', '742135', 'West Bengal', '7585003824', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/178_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 08:35:21', '2025-04-03 08:58:19'),
(179, NULL, 'LFS202324013', 1, 1, '2025-04-04', NULL, NULL, 'RIZWAN KHAN', NULL, 'WASIM AKRAM', NULL, 'SHILA BIBI', NULL, '2017-10-17', 'KASHIADANGA', NULL, 'MAHISASTHALI', 'BHAGWANGOLA', 'MURSHIDABAD', '742135', 'West Bengal', '7585885008', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/179_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 08:39:50', '2025-04-04 07:59:05'),
(180, NULL, 'LFS202425009', 1, 1, '2025-04-04', NULL, NULL, 'JUWARIYA KHATUN', NULL, 'JAHIRUL ISLAM', NULL, 'SABARUNNESHA BIBI', NULL, '2017-06-08', 'Dayanagar', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7687000815', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/180_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 08:45:14', '2025-04-04 07:28:15'),
(181, NULL, 'LFS201920038', 1, 1, '2025-04-04', NULL, NULL, 'AHIL SARKAR', NULL, 'SAHANUL ISLAM', NULL, 'NASIMA KHATUN', NULL, '2016-05-26', 'Mahisasthali', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933956065', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/181_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 09:12:19', '2025-04-04 06:47:12'),
(182, NULL, 'LFS202122020', 1, 1, '2025-04-04', NULL, NULL, 'MD ARYAN', NULL, 'MD HAJIKUL ALAM', NULL, 'LOVELY BIBI', NULL, '2016-09-14', 'Kantanagar', NULL, 'Kantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9064180769', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/182_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 09:15:59', '2025-04-04 07:47:33'),
(183, NULL, 'LFS202526066', 1, 1, '2025-04-04', NULL, NULL, 'JINAN AMAN', NULL, 'KAMRUJJAMAN', NULL, 'ARJIA KHATUN', NULL, '2015-05-04', 'Char Paikmari', NULL, 'Hanumantanagar', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8345811656', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/183_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 09:20:45', '2025-04-04 07:55:08'),
(184, NULL, 'LFS202021026', 1, 1, '2025-04-04', NULL, NULL, 'EHAN HOQUE', NULL, 'AZMAL HOQUE', NULL, 'TAHASINA KHATUN', NULL, '2015-11-21', 'Sekherpara', NULL, 'Habaspur', 'Bhagwangola', 'Mushidabad', '742135', 'West Bengal', '7384560809', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/184_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-03 09:26:10', '2025-04-04 07:56:46'),
(185, NULL, 'LFS202324039', 1, 1, '2025-04-10', NULL, NULL, 'AZIZA SULTANA', NULL, 'MD ASADULLAH', NULL, 'SIMA BIBI', NULL, '2014-04-13', 'MADAPUR', NULL, 'BAHADURPUR', 'BHAGWANGOLA', 'MURSHIDABAD', '742135', 'West Bengal', '9641064870', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/185_profile.jpg', NULL, NULL, 4, NULL, NULL, '2025-04-03 09:32:13', '2025-04-10 19:43:01'),
(186, NULL, 'LFS201920081', 1, 1, '2025-04-11', NULL, NULL, 'ANKIT ROY', NULL, 'ASIT ROY', NULL, 'BABY ROY', NULL, '2015-04-23', 'Bahaliapara', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9933947637', NULL, 'male', NULL, NULL, 'Hindu', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/186_profile.jpg', NULL, NULL, 4, NULL, NULL, '2025-04-03 09:37:08', '2025-04-11 18:41:51'),
(187, NULL, 'LFS202324017', 1, 1, '2025-04-04', NULL, NULL, 'LIJA KHATUN', NULL, 'Attar Shah', NULL, 'Hadisha Khatun', NULL, '2017-03-20', 'Rambagh Badhpul', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7010161069', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/-1_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-04 07:38:30', '2025-04-04 07:38:30'),
(188, NULL, 'LFS202021014', 1, 1, '2025-04-22', NULL, NULL, 'Fahim Ahamed', NULL, 'Juel Hoque', NULL, 'Mosjida Bibi', NULL, '2016-03-17', 'Kupkandhi', NULL, 'Bhagwangola', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '9635205896', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/188_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-22 03:28:10', '2025-04-22 03:29:22'),
(189, NULL, 'LFS202526073', 1, 1, '2025-04-22', NULL, NULL, 'Alhaj Hoque', NULL, 'Rabiul Hoque', NULL, 'Lima Khatun', NULL, '2021-11-16', 'Kashiyadanga', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '8653856842', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/189_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-22 03:55:42', '2025-04-22 03:56:29'),
(190, NULL, 'LFS202526072', 1, 1, '2025-04-22', NULL, NULL, 'Anas Ali', NULL, 'Ramjan Ali', NULL, 'Runa Bibi', NULL, '2014-05-15', 'Naharpara', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7980812782', NULL, 'male', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/190_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-22 04:09:57', '2025-04-22 04:10:18'),
(191, NULL, 'LFS202526071', 1, 1, '2025-04-22', NULL, NULL, 'Aliya Ali', NULL, 'Ramjan Ali', NULL, 'Runa Bibi', NULL, '2015-11-13', 'Naharpara', NULL, 'Mahisasthali', 'Bhagwangola', 'Murshidabad', '742135', 'West Bengal', '7980812782', NULL, 'female', NULL, NULL, 'Muslim', 'General', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'studentdb/191_profile.jpeg', NULL, NULL, 4, NULL, NULL, '2025-04-22 04:13:15', '2025-04-22 04:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `subject_type_id` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `description`, `order_index`, `subject_type_id`, `school_id`, `session_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`, `code`) VALUES
(1, 'Bengali', 'sfsfds', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-08-21 21:17:43', '2025-08-21 21:17:43', 'Beng');

-- --------------------------------------------------------

--
-- Table structure for table `subject_teacher`
--

CREATE TABLE `subject_teacher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_teacher`
--

INSERT INTO `subject_teacher` (`id`, `subject_id`, `teacher_id`, `is_primary`, `notes`, `school_id`, `session_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'fsfsf', NULL, NULL, NULL, NULL, 1, 0, 'active', NULL, '2025-08-22 09:44:30', '2025-08-22 09:44:30'),
(2, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 'active', NULL, '2025-08-22 09:45:13', '2025-08-22 09:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `subject_types`
--

CREATE TABLE `subject_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int(10) UNSIGNED DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_finalized` tinyint(1) DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_types`
--

INSERT INTO `subject_types` (`id`, `name`, `description`, `order_index`, `school_id`, `session_id`, `user_id`, `approved_by`, `is_active`, `is_finalized`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Formative', 'Formative Subject', NULL, 1, 1, 4, NULL, 1, 0, NULL, 'Find ', '2025-08-21 21:12:52', '2025-08-21 21:12:52'),
(2, 'Summative', 'Summative subjects', NULL, 1, 1, 4, NULL, 1, 0, NULL, 'sum', '2025-08-21 21:13:12', '2025-08-21 21:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desig` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hqual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `train_qual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_qual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_subject_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prev_session_pk` int(11) DEFAULT NULL,
  `img_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `nickName`, `mobno`, `desig`, `hqual`, `train_qual`, `extra_qual`, `main_subject_id`, `notes`, `prev_session_pk`, `img_ref`, `status`, `remark`, `user_id`, `session_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, 'Ratin Chatterjee', 'RC', '123', 'Senior Teacher', 'MA', 'BEd', 'PGDCA', '1', 'Notes', 0, 'dsfs', 'active', 'Remarks', 5, 1, 1, '2025-08-21 18:30:00', '2025-08-22 06:50:34'),
(2, 'Ayantika', NULL, '9153122277', 'Assistant Teacher', 'MSc', 'MED', 'MCA', '1', NULL, NULL, 'teacher-profiles/uYbJ3wpcquV9xOVRfu8nGySrEczJTBBaqQj0eMlA.png', 'active', NULL, 4, 1, 1, '2025-08-22 06:46:50', '2025-08-22 06:49:27'),
(3, 'Hari Narayan', 'HND', '542632', 'Assistant Teacher', 'MA', 'BEd', NULL, '1', 'Notes', NULL, 'teacher-profiles/EaFgEymyfSmf9UWe7EBcJ6A88Q9WVvANdQfmHbHX.png', 'retired', 'Remarks', 4, 1, 1, '2025-08-22 07:59:56', '2025-08-22 07:59:56'),
(4, 'sdfafa', 'dfsfs', '23232323232323', 'Art Teacher', 'dfs', 'sdfsf', 'dsfsdfs', '1', 'fdfs', NULL, NULL, 'inactive', 'sfsfsf', 4, 1, 1, '2025-08-22 08:58:22', '2025-08-22 08:58:22'),
(5, 'sadadsad', 'df', '3333', 'Assistant Teacher', 'dfd', 'fd', 'df', '1', 'dfd', NULL, 'teacher-profiles/aDmmkuPtLRnaClGyu6whfmQrDy67sSwrI0PDcaMK.jpg', 'active', 'dfd', 4, 1, 1, '2025-08-22 09:03:37', '2025-08-22 09:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `teacher_id` int(11) NOT NULL DEFAULT 0,
  `studentdb_id` int(11) NOT NULL DEFAULT 0,
  `is_requested` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `remember_token`, `role_id`, `status`, `teacher_id`, `studentdb_id`, `is_requested`, `created_at`, `updated_at`) VALUES
(1, 'User', 'user@gmail.com', '2024-09-03 15:20:23', '$2y$10$4I/GqH1X6xaHOsaz6IaFSOQWGD1Z3rdIR9SVmFgcV43Y4UNqwaSuq', NULL, NULL, 1, 'active', 5, 0, 0, '2024-06-25 01:25:42', '2024-09-18 17:50:37'),
(2, 'Sub Admin', 'subadmin@gmail.com', '2024-09-22 15:20:18', '$2y$10$xWBR2C70wr16W8fafFcJyubTs67NqEhWLKGjeycBmuONYzegtw59e', NULL, NULL, 2, 'active', 4, 0, 0, '2024-06-25 01:26:13', '2024-06-25 01:26:13'),
(3, 'Office Staff', 'office@gmail.com', '2024-09-12 02:57:29', '$2y$10$Q/4X2YbvQ7YYrCNFaEKpxuX4ONaflkCJQYc0JgH75C3c4MrnXsPiq', NULL, '5usAMiOUDBeBXpsy9QBsZSEpNN6SlfiSgDTzyztjznaDpnku6K5f3IqyDs7X', 3, 'active', 3, 0, 0, '2024-06-25 01:26:49', '2024-09-12 09:33:25'),
(4, 'Admin', 'admin@gmail.com', '2024-09-23 15:20:02', '$2y$10$RyE2pp17XVshwHlqHzJSN.jiHAFqrX1aqIydx2zaW/7eYrdGDwoxy', NULL, 'I8nC62oQAmNr9ppsVmSSkBuFsqOMhdw4T6R8IsF6D5V1JH7DUvmpFZ15FzJW', 4, 'active', 2, 0, 0, '2024-06-25 01:27:21', '2024-06-25 01:27:21'),
(5, 'Super Admin', 'supadmin@gmail.com', '2024-09-23 15:20:02', '$2y$10$RyE2pp17XVshwHlqHzJSN.jiHAFqrX1aqIydx2zaW/7eYrdGDwoxy', NULL, 'WMptTtuOrpyyGXf1HZAuhQfj23saCMeRZglmDZlEOfOUWoOIgwMEB2ONvtw9', 5, 'active', 1, 0, 0, '2024-06-25 01:27:21', '2024-06-25 01:27:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam01_names`
--
ALTER TABLE `exam01_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam02_types`
--
ALTER TABLE `exam02_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam03_parts`
--
ALTER TABLE `exam03_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam04_modes`
--
ALTER TABLE `exam04_modes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam05_details`
--
ALTER TABLE `exam05_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam06_class_subjects`
--
ALTER TABLE `exam06_class_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam07_ansscr_dists`
--
ALTER TABLE `exam07_ansscr_dists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam09_schedule_rooms`
--
ALTER TABLE `exam09_schedule_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam10_marks_entries`
--
ALTER TABLE `exam10_marks_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam11_question_papers`
--
ALTER TABLE `exam11_question_papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_particulars`
--
ALTER TABLE `fee_particulars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myclasses`
--
ALTER TABLE `myclasses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myclass_sections`
--
ALTER TABLE `myclass_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myclass_subjects`
--
ALTER TABLE `myclass_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_events`
--
ALTER TABLE `session_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_event_categories`
--
ALTER TABLE `session_event_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_event_schedules`
--
ALTER TABLE `session_event_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentcrs`
--
ALTER TABLE `studentcrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentdbs`
--
ALTER TABLE `studentdbs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_types`
--
ALTER TABLE `subject_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `exam01_names`
--
ALTER TABLE `exam01_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam02_types`
--
ALTER TABLE `exam02_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam03_parts`
--
ALTER TABLE `exam03_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam04_modes`
--
ALTER TABLE `exam04_modes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam05_details`
--
ALTER TABLE `exam05_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam06_class_subjects`
--
ALTER TABLE `exam06_class_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam07_ansscr_dists`
--
ALTER TABLE `exam07_ansscr_dists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam09_schedule_rooms`
--
ALTER TABLE `exam09_schedule_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam10_marks_entries`
--
ALTER TABLE `exam10_marks_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam11_question_papers`
--
ALTER TABLE `exam11_question_papers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_particulars`
--
ALTER TABLE `fee_particulars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `myclasses`
--
ALTER TABLE `myclasses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `myclass_sections`
--
ALTER TABLE `myclass_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `myclass_subjects`
--
ALTER TABLE `myclass_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session_events`
--
ALTER TABLE `session_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_event_categories`
--
ALTER TABLE `session_event_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_event_schedules`
--
ALTER TABLE `session_event_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentcrs`
--
ALTER TABLE `studentcrs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `studentdbs`
--
ALTER TABLE `studentdbs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subject_types`
--
ALTER TABLE `subject_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
