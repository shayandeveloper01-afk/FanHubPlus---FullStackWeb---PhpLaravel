-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2026 at 07:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fan_hub_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(100) NOT NULL,
  `target_type` varchar(100) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_activity_logs`
--

INSERT INTO `admin_activity_logs` (`id`, `admin_id`, `action`, `target_type`, `target_id`, `notes`, `created_at`) VALUES
(1, 1, 'user.ban', 'User', 20, 'Banned MUHAMMAD SHAYAN', '2026-09-28 21:18:31'),
(2, 1, 'user.unban', 'User', 20, 'Unbanned MUHAMMAD SHAYAN', '2026-09-28 21:18:36'),
(3, 1, 'user.promote', 'User', 20, 'Promoted MUHAMMAD SHAYAN to admin', '2026-09-28 21:20:18'),
(4, 1, 'user.demote', 'User', 20, 'Demoted MUHAMMAD SHAYAN', '2026-09-28 21:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `analytics_events`
--

CREATE TABLE `analytics_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(64) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `analytics_events`
--

INSERT INTO `analytics_events` (`id`, `event_type`, `profile_id`, `session_id`, `metadata`, `url`, `created_at`) VALUES
(1, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:29'),
(2, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:30'),
(3, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:30'),
(4, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:36'),
(5, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:36'),
(6, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:37'),
(7, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:37'),
(8, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:38'),
(9, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:38'),
(10, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-26 18:35:47'),
(11, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:47'),
(12, 'chatbot_local_reply', NULL, 'b44a635f-363e-4877-8e28-a2fb5502d88e', '[]', 'chat/message', '2026-09-26 18:35:51'),
(13, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:59'),
(14, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:35:59'),
(15, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-26 18:36:03'),
(16, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-26 18:36:04'),
(17, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-26 18:36:10'),
(18, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:36:12'),
(19, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:36:13'),
(20, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-26 18:38:40'),
(21, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-26 18:38:40'),
(22, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-26 18:38:44'),
(23, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-26 18:38:47'),
(24, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-26 18:39:10'),
(25, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-26 18:39:18'),
(26, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-26 18:39:31'),
(27, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-26 18:39:35'),
(28, 'chatbot_local_reply', NULL, 'b44a635f-363e-4877-8e28-a2fb5502d88e', '[]', 'chat/message', '2026-09-26 18:39:39'),
(29, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:39:55'),
(30, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:39:55'),
(31, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-26 18:46:06'),
(32, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-26 18:46:06'),
(33, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-26 18:46:13'),
(34, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-26 18:46:13'),
(35, 'content_view', NULL, NULL, '{\"content_id\":8}', 'contents/8', '2026-09-26 18:46:16'),
(36, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/8\"}', 'contents/8', '2026-09-26 18:46:16'),
(37, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:46:20'),
(38, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:46:21'),
(39, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-26 18:46:37'),
(40, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:54:01'),
(41, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:54:02'),
(42, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-26 18:54:13'),
(43, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 18:54:13'),
(44, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-26 18:54:25'),
(45, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-26 18:55:14'),
(46, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-26 18:55:55'),
(47, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-26 18:59:20'),
(48, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-26 18:59:40'),
(49, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-26 19:00:06'),
(50, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 19:00:22'),
(51, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-26 19:00:23'),
(52, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-26 19:00:27'),
(53, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-26 19:00:34'),
(54, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-26 19:00:41'),
(55, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:45:15'),
(56, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:45:17'),
(57, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 14:45:51'),
(58, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:45:54'),
(59, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:45:54'),
(60, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 14:45:55'),
(61, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:45:59'),
(62, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:46:00'),
(63, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-27 14:46:14'),
(64, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:46:14'),
(65, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 14:46:16'),
(66, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:10:26'),
(67, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:10:28'),
(68, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:10:28'),
(69, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:10:29'),
(70, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:10:30'),
(71, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:10:31'),
(72, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 15:10:36'),
(73, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 15:10:44'),
(74, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:10:49'),
(75, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:10:49'),
(76, 'content_view', NULL, NULL, '{\"content_id\":4}', 'contents/4', '2026-09-27 15:31:28'),
(77, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/4\"}', 'contents/4', '2026-09-27 15:31:28'),
(78, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:34:07'),
(79, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:34:08'),
(80, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:34:09'),
(81, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:34:10'),
(82, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:34:11'),
(83, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:34:11'),
(84, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:34:13'),
(85, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:34:32'),
(86, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:34:32'),
(87, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:34:46'),
(88, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:35:02'),
(89, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:50:14'),
(90, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:50:14'),
(91, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:15'),
(92, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:15'),
(93, 'page_view', NULL, NULL, '{\"path\":\"\\/categories\"}', 'categories', '2026-09-27 15:53:20'),
(94, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:29'),
(95, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:29'),
(96, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:53:30'),
(97, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:33'),
(98, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:33'),
(99, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:53:35'),
(100, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-27 15:53:37'),
(101, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-27 15:53:39'),
(102, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:41'),
(103, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:41'),
(104, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:53:44'),
(105, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:47'),
(106, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:47'),
(107, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:53:48'),
(108, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:55'),
(109, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:53:56'),
(110, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:53:57'),
(111, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:01'),
(112, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:01'),
(113, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:54:21'),
(114, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:22'),
(115, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:22'),
(116, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:43'),
(117, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:43'),
(118, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 15:54:44'),
(119, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:45'),
(120, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 15:54:46'),
(121, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:00:19'),
(122, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:00:20'),
(123, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 16:00:26'),
(124, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-27 16:00:28'),
(125, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-27 16:00:30'),
(126, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-27 16:00:31'),
(127, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:00:46'),
(128, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:00:52'),
(129, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:00:54'),
(130, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:01:11'),
(131, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:01:36'),
(132, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:01:36'),
(133, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:01:36'),
(134, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:01:36'),
(135, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/nearby\"}', 'events/nearby', '2026-09-27 16:01:36'),
(136, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:01:47'),
(137, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:01:48'),
(138, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:01:51'),
(139, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:01:51'),
(140, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 16:01:53'),
(141, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-27 16:01:54'),
(142, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-27 16:01:55'),
(143, 'page_view', NULL, NULL, '{\"path\":\"\\/categories\\/anime\"}', 'categories/anime', '2026-09-27 16:01:58'),
(144, 'page_view', NULL, NULL, '{\"path\":\"\\/categories\\/comics\"}', 'categories/comics', '2026-09-27 16:02:02'),
(145, 'page_view', NULL, NULL, '{\"path\":\"\\/categories\\/cosplay\"}', 'categories/cosplay', '2026-09-27 16:02:14'),
(146, 'page_view', NULL, NULL, '{\"path\":\"\\/categories\\/gaming\"}', 'categories/gaming', '2026-09-27 16:02:16'),
(147, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-27 16:02:24'),
(148, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:02:26'),
(149, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:02:27'),
(150, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:02:33'),
(151, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:02:33'),
(152, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:28:24'),
(153, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:28:25'),
(154, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/tv-series\"}', 'category/tv-series', '2026-09-27 16:29:12'),
(155, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/movies\"}', 'category/movies', '2026-09-27 16:29:21'),
(156, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/manga\"}', 'category/manga', '2026-09-27 16:29:23'),
(157, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-27 16:29:27'),
(158, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-27 16:29:32'),
(159, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-27 16:29:34'),
(160, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-27 16:39:56'),
(161, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:39:57'),
(162, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:39:58'),
(163, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:39:59'),
(164, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:39:59'),
(165, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:55:50'),
(166, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:55:51'),
(167, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 16:55:51'),
(168, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:41:09'),
(169, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:41:09'),
(170, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-27 17:42:47'),
(171, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:42:55'),
(172, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:42:55'),
(173, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-27 17:43:07'),
(174, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:58:27'),
(175, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:58:28'),
(176, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:58:32'),
(177, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:58:33'),
(178, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-27 17:59:08'),
(179, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:59:12'),
(180, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:59:12'),
(181, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:59:46'),
(182, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 17:59:46'),
(183, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-27 17:59:48'),
(184, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-27 17:59:53'),
(185, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-27 17:59:54'),
(186, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-27 17:59:59'),
(187, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-27 18:00:06'),
(188, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:00:41'),
(189, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:00:41'),
(190, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:08:55'),
(191, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:08:56'),
(192, 'page_view', NULL, NULL, '{\"path\":\"\\/privacy-policy\"}', 'privacy-policy', '2026-09-27 18:09:19'),
(193, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-27 18:09:28'),
(194, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:09:43'),
(195, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:09:44'),
(196, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-27 18:09:57'),
(197, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:10:04'),
(198, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:10:05'),
(199, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 18:10:07'),
(200, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 18:10:12'),
(201, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-27 18:10:18'),
(202, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-27 18:10:25'),
(203, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-27 18:10:40'),
(204, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:10:47'),
(205, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:10:47'),
(206, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 18:10:50'),
(207, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:10:59'),
(208, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:11:00'),
(209, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 18:11:02'),
(210, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:19:41'),
(211, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:19:42'),
(212, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 18:19:44'),
(213, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:19:50'),
(214, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:19:50'),
(215, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 18:19:52'),
(216, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 18:19:55'),
(217, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 18:20:37'),
(218, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 18:20:45'),
(219, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 18:20:55'),
(220, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 18:21:02'),
(221, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 18:49:38'),
(222, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:49:47'),
(223, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 18:49:47'),
(224, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 18:49:50'),
(225, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 18:49:56'),
(226, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 18:50:28'),
(227, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 18:50:36'),
(228, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:01:42'),
(229, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:01:48'),
(230, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:01:53'),
(231, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:01:53'),
(232, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:02:04'),
(233, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:08:23'),
(234, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:08:32'),
(235, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:08:34'),
(236, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:08:58'),
(237, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:08:58'),
(238, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 19:09:00'),
(239, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 19:09:03'),
(240, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:09:09'),
(241, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:09:12'),
(242, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:09:15'),
(243, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:09:24'),
(244, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:14:50'),
(245, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:14:57'),
(246, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:15:09'),
(247, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:15:11'),
(248, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:15:20'),
(249, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:26:49'),
(250, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:28:11'),
(251, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:28:18'),
(252, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:28:18'),
(253, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:28:32'),
(254, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:28:41'),
(255, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-27 19:28:50'),
(256, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:29:16'),
(257, 'page_view', NULL, NULL, '{\"path\":\"\\/articles\\/create\"}', 'articles/create', '2026-09-27 19:29:18'),
(258, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:34:45'),
(259, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:34:55'),
(260, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:35:02'),
(261, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:35:12'),
(262, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:35:13'),
(263, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:35:13'),
(264, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:35:13'),
(265, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:35:13'),
(266, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:41:43'),
(267, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:41:52'),
(268, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 19:42:01'),
(269, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 19:42:06'),
(270, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:42:11'),
(271, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:42:11'),
(272, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:42:12'),
(273, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:42:13'),
(274, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 19:42:16'),
(275, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:42:35'),
(276, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:42:49'),
(277, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 19:42:55'),
(278, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 19:42:58'),
(279, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-27 19:49:53'),
(280, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:50:32'),
(281, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:50:35'),
(282, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:51:09'),
(283, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:52:22'),
(284, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:52:28'),
(285, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:52:35'),
(286, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:52:36'),
(287, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 19:52:37'),
(288, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 19:52:41'),
(289, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 19:52:44'),
(290, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:56:19'),
(291, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-27 19:56:19'),
(292, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 19:56:21'),
(293, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-27 20:31:12'),
(294, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-27 20:31:20'),
(295, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 20:31:26'),
(296, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-27 20:31:52'),
(297, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 07:46:40'),
(298, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:46:50'),
(299, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:52:18'),
(300, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:52:44'),
(301, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:53:21'),
(302, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:53:38'),
(303, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:54:16'),
(304, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 07:54:35'),
(305, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:54:49'),
(306, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:54:49'),
(307, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-28 07:54:51'),
(308, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 07:54:59'),
(309, 'page_view', NULL, NULL, '{\"path\":\"\\/about\"}', 'about', '2026-09-28 07:55:19'),
(310, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:55:28'),
(311, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:55:29'),
(312, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 07:55:29'),
(313, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:55:49'),
(314, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:55:56'),
(315, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-28 07:55:59'),
(316, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:56:42'),
(317, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:56:43'),
(318, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-28 07:56:44'),
(319, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 07:56:47'),
(320, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 07:56:49'),
(321, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 07:56:57'),
(322, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:57:02'),
(323, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 07:57:03'),
(324, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 07:57:06'),
(325, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-28 07:57:09'),
(326, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-28 07:57:18'),
(327, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 07:57:33'),
(328, 'page_view', NULL, NULL, '{\"path\":\"\\/articles\\/create\"}', 'articles/create', '2026-09-28 07:57:35'),
(329, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 08:06:27'),
(330, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-28 08:06:28'),
(331, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 08:06:52'),
(332, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:07:37'),
(333, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:07:37'),
(334, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:08:18'),
(335, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:08:18'),
(336, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:08:34'),
(337, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:08:34'),
(338, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 08:12:00'),
(339, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 08:12:01'),
(340, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:12:33'),
(341, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:12:34'),
(342, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:13:25'),
(343, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:13:25'),
(344, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 08:13:43'),
(345, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 08:13:43'),
(346, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:13:48'),
(347, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:13:49'),
(348, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 08:13:51'),
(349, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:13:55'),
(350, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 08:13:59'),
(351, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:14:05'),
(352, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:14:15'),
(353, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/glastonbury-festival-2025\"}', 'events/glastonbury-festival-2025', '2026-09-28 08:14:53'),
(354, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:21:35'),
(355, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:21:36'),
(356, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 08:38:48'),
(357, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 08:38:59'),
(358, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 08:38:59'),
(359, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 08:39:10'),
(360, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 08:39:10'),
(361, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:39:26'),
(362, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:39:26'),
(363, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 08:40:10'),
(364, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 08:40:10'),
(365, 'chatbot_local_reply', NULL, 'b44a635f-363e-4877-8e28-a2fb5502d88e', '[]', 'chat/message', '2026-09-28 08:40:13'),
(366, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:49:50'),
(367, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:49:54'),
(368, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:51:00'),
(369, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 08:51:02'),
(370, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 09:39:11'),
(371, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 09:40:31'),
(372, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 09:40:31'),
(373, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 10:06:00'),
(374, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:06:01'),
(375, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:06:01'),
(376, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 10:06:18'),
(377, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:06:18'),
(378, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:16:03'),
(379, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:16:03'),
(380, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 10:21:23'),
(381, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:21:23'),
(382, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:22:39'),
(383, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:22:39'),
(384, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:28:12'),
(385, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:28:12'),
(386, 'content_view', NULL, NULL, '{\"content_id\":8}', 'contents/8', '2026-09-28 10:28:25'),
(387, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/8\"}', 'contents/8', '2026-09-28 10:28:25'),
(388, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:28:31'),
(389, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:28:31'),
(390, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:28:35'),
(391, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:28:35'),
(392, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:29:47'),
(393, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:29:52'),
(394, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 10:29:56'),
(395, 'page_view', NULL, NULL, '{\"path\":\"\\/articles\\/create\"}', 'articles/create', '2026-09-28 10:29:58'),
(396, 'page_view', NULL, NULL, '{\"path\":\"\\/articles\"}', 'articles', '2026-09-28 10:31:09'),
(397, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:31:14'),
(398, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:31:15'),
(399, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/tv-series\"}', 'category/tv-series', '2026-09-28 10:31:25'),
(400, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:31:32'),
(401, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:31:32'),
(402, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:45:29'),
(403, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:45:30'),
(404, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:46:35'),
(405, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:46:35'),
(406, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 10:49:11'),
(407, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 10:49:11'),
(408, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 10:49:17'),
(409, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 10:49:17'),
(410, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-28 10:49:24'),
(411, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:49:30'),
(412, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:49:30'),
(413, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 10:49:53'),
(414, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 10:49:53'),
(415, 'page_view', NULL, NULL, '{\"path\":\"\\/faqs\"}', 'faqs', '2026-09-28 10:50:14'),
(416, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-28 10:50:16'),
(417, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-28 10:50:20'),
(418, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 10:50:22'),
(419, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 10:50:22'),
(420, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:50:29'),
(421, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:50:29'),
(422, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:50:52'),
(423, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:51:04'),
(424, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 10:51:05'),
(425, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:04:17'),
(426, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:04:17'),
(427, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:04:37'),
(428, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:04:38'),
(429, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:04:45'),
(430, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:05:07'),
(431, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:05:08'),
(432, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 11:05:12'),
(433, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 11:05:12'),
(434, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:05:15'),
(435, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:05:15'),
(436, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:07:26'),
(437, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:07:27'),
(438, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:10:23'),
(439, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:10:24'),
(440, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:13:18'),
(441, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:13:18'),
(442, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:14:00'),
(443, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:14:01'),
(444, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:19:45'),
(445, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 11:19:45'),
(446, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 11:32:26'),
(447, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:13:53'),
(448, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:13:54'),
(449, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 12:14:18'),
(450, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 12:14:22'),
(451, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:19:20'),
(452, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:19:20'),
(453, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:19:25'),
(454, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:19:28'),
(455, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:20:05'),
(456, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:20:05'),
(457, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 12:20:57'),
(458, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 12:21:03'),
(459, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:25:29'),
(460, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:25:29'),
(461, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 12:26:22'),
(462, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/akira-kaneda-jacket-replica\"}', 'merchandise/akira-kaneda-jacket-replica', '2026-09-28 12:26:34'),
(463, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 12:29:31'),
(464, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:29:32'),
(465, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:29:33'),
(466, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:36'),
(467, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:37'),
(468, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:38'),
(469, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:39'),
(470, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:52'),
(471, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:52'),
(472, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:54'),
(473, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:29:54'),
(474, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:30:22'),
(475, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:30:23'),
(476, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:30:24'),
(477, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:30:24'),
(478, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:36:21'),
(479, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:36:25'),
(480, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 12:36:45'),
(481, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:36:46'),
(482, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:36:48'),
(483, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:36:51'),
(484, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:36:52'),
(485, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:36:53'),
(486, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:36:54'),
(487, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 12:36:55'),
(488, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:37:07'),
(489, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:37:08'),
(490, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:37:09'),
(491, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:37:09'),
(492, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 12:37:27'),
(493, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 12:37:28'),
(494, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 12:37:30'),
(495, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 12:37:35'),
(496, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:37:40'),
(497, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:37:40'),
(498, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 12:43:58'),
(499, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:43:58'),
(500, 'chatbot_local_reply', NULL, 'b44a635f-363e-4877-8e28-a2fb5502d88e', '[]', 'chat/message', '2026-09-28 12:44:14'),
(501, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:44:40'),
(502, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 12:44:54'),
(503, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:04:49'),
(504, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:04:50'),
(505, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:11:40'),
(506, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:11:40'),
(507, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:17:06'),
(508, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:17:07'),
(509, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 13:17:12'),
(510, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:17:12'),
(511, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:07'),
(512, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:08'),
(513, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:16'),
(514, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:16'),
(515, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:31'),
(516, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:32'),
(517, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:33'),
(518, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:34'),
(519, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:54'),
(520, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:21:55'),
(521, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:25'),
(522, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:26'),
(523, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:33'),
(524, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:34'),
(525, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:34'),
(526, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:34'),
(527, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:35'),
(528, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:40'),
(529, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:41'),
(530, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:55'),
(531, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:23:56'),
(532, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:37:35'),
(533, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:37:35'),
(534, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:26'),
(535, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:26'),
(536, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:34'),
(537, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:34'),
(538, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:34'),
(539, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:35'),
(540, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:35'),
(541, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:38'),
(542, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:03:39'),
(543, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:11:20'),
(544, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:11:20'),
(545, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:11:24'),
(546, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:11:24'),
(547, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:14:33'),
(548, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:14:34'),
(549, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:17:15'),
(550, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:17:15'),
(551, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:17:23'),
(552, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:17:23'),
(553, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:34:17'),
(554, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:34:17'),
(555, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:42:15'),
(556, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:42:16'),
(557, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:42:22'),
(558, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 14:42:23'),
(559, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 14:43:18'),
(560, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:43:20'),
(561, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:43:21'),
(562, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:43:25'),
(563, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:43:26'),
(564, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:54:53'),
(565, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:54:53');
INSERT INTO `analytics_events` (`id`, `event_type`, `profile_id`, `session_id`, `metadata`, `url`, `created_at`) VALUES
(566, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 14:55:54'),
(567, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 14:55:54'),
(568, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 14:56:05'),
(569, 'page_view', NULL, NULL, '{\"path\":\"\\/privacy-policy\"}', 'privacy-policy', '2026-09-28 14:56:15'),
(570, 'page_view', NULL, NULL, '{\"path\":\"\\/privacy-policy\"}', 'privacy-policy', '2026-09-28 14:56:43'),
(571, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:56:46'),
(572, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:56:46'),
(573, 'content_view', NULL, NULL, '{\"content_id\":4}', 'contents/4', '2026-09-28 14:56:49'),
(574, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/4\"}', 'contents/4', '2026-09-28 14:56:49'),
(575, 'content_view', NULL, NULL, '{\"content_id\":4}', 'contents/4', '2026-09-28 14:58:30'),
(576, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/4\"}', 'contents/4', '2026-09-28 14:58:30'),
(577, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:58:39'),
(578, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 14:58:40'),
(579, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 14:59:00'),
(580, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 14:59:01'),
(581, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:02:20'),
(582, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:02:20'),
(583, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:05:34'),
(584, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:05:35'),
(585, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/london-film-festival-opening-night\"}', 'events/london-film-festival-opening-night', '2026-09-28 15:06:17'),
(586, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/london-film-festival-opening-night\"}', 'events/london-film-festival-opening-night', '2026-09-28 15:19:53'),
(587, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:19:55'),
(588, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:19:55'),
(589, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:25:37'),
(590, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:25:38'),
(591, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:26:24'),
(592, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:26:24'),
(593, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:27:32'),
(594, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:27:33'),
(595, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:28:23'),
(596, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:28:23'),
(597, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:29:37'),
(598, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:29:38'),
(599, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:32:57'),
(600, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:32:57'),
(601, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:35:34'),
(602, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:35:35'),
(603, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:35:43'),
(604, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:35:44'),
(605, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/london-film-festival-opening-night\"}', 'events/london-film-festival-opening-night', '2026-09-28 15:36:16'),
(606, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:38:53'),
(607, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:38:53'),
(608, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:39:16'),
(609, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:39:16'),
(610, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:39:22'),
(611, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:39:23'),
(612, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:40:20'),
(613, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:40:20'),
(614, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:41:15'),
(615, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:41:15'),
(616, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:41:22'),
(617, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:41:23'),
(618, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 15:46:26'),
(619, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 15:46:27'),
(620, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:46:31'),
(621, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 15:46:31'),
(622, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 15:46:34'),
(623, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 15:46:34'),
(624, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 15:46:38'),
(625, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 15:46:38'),
(626, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 15:46:45'),
(627, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 15:46:45'),
(628, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 15:46:48'),
(629, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 15:46:48'),
(630, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 13:17:51'),
(631, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 13:17:51'),
(632, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:17:56'),
(633, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:17:57'),
(634, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:18:00'),
(635, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:18:00'),
(636, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 13:18:14'),
(637, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:18:16'),
(638, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 13:18:17'),
(639, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:20:29'),
(640, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:20:30'),
(641, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 18:21:05'),
(642, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:46:53'),
(643, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:46:55'),
(644, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:47:56'),
(645, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:47:57'),
(646, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:51:04'),
(647, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:51:05'),
(648, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-28 18:51:13'),
(649, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 18:51:17'),
(650, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 18:51:22'),
(651, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 18:51:42'),
(652, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 18:51:51'),
(653, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 18:52:04'),
(654, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:52:12'),
(655, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:52:13'),
(656, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 18:52:18'),
(657, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 18:52:23'),
(658, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 18:53:31'),
(659, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:54:20'),
(660, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:54:21'),
(661, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 18:54:27'),
(662, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:54:28'),
(663, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:54:29'),
(664, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:54:31'),
(665, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 18:54:38'),
(666, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 19:02:47'),
(667, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 19:03:05'),
(668, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 19:03:26'),
(669, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 19:03:43'),
(670, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 19:04:02'),
(671, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 19:04:18'),
(672, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:06:04'),
(673, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:06:05'),
(674, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 19:06:26'),
(675, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 19:06:36'),
(676, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 19:06:45'),
(677, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 19:06:46'),
(678, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 19:07:07'),
(679, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 19:07:18'),
(680, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-28 19:07:29'),
(681, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/cosplay\"}', 'category/cosplay', '2026-09-28 19:07:33'),
(682, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-28 19:07:34'),
(683, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/manga\"}', 'category/manga', '2026-09-28 19:07:45'),
(684, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/tv-series\"}', 'category/tv-series', '2026-09-28 19:07:47'),
(685, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/movies\"}', 'category/movies', '2026-09-28 19:07:49'),
(686, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-28 19:07:51'),
(687, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 19:07:52'),
(688, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-28 19:07:54'),
(689, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/cosplay\"}', 'category/cosplay', '2026-09-28 19:07:56'),
(690, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-28 19:07:57'),
(691, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/movies\"}', 'category/movies', '2026-09-28 19:07:58'),
(692, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/tv-series\"}', 'category/tv-series', '2026-09-28 19:08:00'),
(693, 'page_view', NULL, NULL, '{\"path\":\"\\/about\"}', 'about', '2026-09-28 19:08:02'),
(694, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-28 19:08:15'),
(695, 'page_view', NULL, NULL, '{\"path\":\"\\/faqs\"}', 'faqs', '2026-09-28 19:08:42'),
(696, 'page_view', NULL, NULL, '{\"path\":\"\\/faqs\"}', 'faqs', '2026-09-28 19:09:04'),
(697, 'page_view', NULL, NULL, '{\"path\":\"\\/privacy-policy\"}', 'privacy-policy', '2026-09-28 19:09:06'),
(698, 'page_view', NULL, NULL, '{\"path\":\"\\/terms\"}', 'terms', '2026-09-28 19:09:09'),
(699, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 19:09:17'),
(700, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:09:46'),
(701, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:09:47'),
(702, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 19:09:48'),
(703, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 19:09:54'),
(704, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-28 19:10:07'),
(705, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-28 19:10:36'),
(706, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/categories\"}', 'admin/categories', '2026-09-28 19:11:02'),
(707, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:15:52'),
(708, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:15:52'),
(709, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:23:03'),
(710, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:23:04'),
(711, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 19:26:04'),
(712, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 19:26:10'),
(713, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 19:26:16'),
(714, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:26:19'),
(715, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:26:19'),
(716, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:32:54'),
(717, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:32:54'),
(718, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:32:57'),
(719, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:32:57'),
(720, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:36:43'),
(721, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:37:28'),
(722, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:38:10'),
(723, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:44:52'),
(724, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:44:53'),
(725, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:50:48'),
(726, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:52:23'),
(727, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:52:27'),
(728, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 19:52:34'),
(729, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:53:36'),
(730, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:53:37'),
(731, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:53:38'),
(732, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:53:39'),
(733, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:53:42'),
(734, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:53:43'),
(735, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:54:00'),
(736, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 19:54:00'),
(737, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 19:54:07'),
(738, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 19:54:08'),
(739, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 20:00:36'),
(740, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 20:00:37'),
(741, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 20:00:41'),
(742, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:00:43'),
(743, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:00:43'),
(744, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 20:00:59'),
(745, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-28 20:01:02'),
(746, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 20:01:06'),
(747, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 20:01:18'),
(748, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 20:01:22'),
(749, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 20:10:03'),
(750, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 20:10:09'),
(751, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 20:12:36'),
(752, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 20:12:40'),
(753, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 20:12:47'),
(754, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:12:56'),
(755, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:12:56'),
(756, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:27:23'),
(757, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:28:00'),
(758, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:28:00'),
(759, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:29:25'),
(760, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:29:52'),
(761, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:29:52'),
(762, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:32:51'),
(763, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:33:03'),
(764, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:33:03'),
(765, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:33:27'),
(766, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:33:27'),
(767, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:37:54'),
(768, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:38:34'),
(769, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:38:34'),
(770, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:44:32'),
(771, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:44:32'),
(772, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-28 20:44:37'),
(773, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 20:44:39'),
(774, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 20:44:40'),
(775, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 20:45:37'),
(776, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 20:45:37'),
(777, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 20:45:53'),
(778, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 20:45:53'),
(779, 'content_view', NULL, NULL, '{\"content_id\":7}', 'contents/7', '2026-09-28 20:46:01'),
(780, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/7\"}', 'contents/7', '2026-09-28 20:46:01'),
(781, 'content_view', NULL, NULL, '{\"content_id\":8}', 'contents/8', '2026-09-28 20:46:07'),
(782, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/8\"}', 'contents/8', '2026-09-28 20:46:07'),
(783, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-28 20:46:14'),
(784, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-28 20:46:16'),
(785, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 20:46:17'),
(786, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 20:46:17'),
(787, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:49:02'),
(788, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:49:02'),
(789, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 20:49:04'),
(790, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 20:49:04'),
(791, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 20:49:08'),
(792, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 20:49:09'),
(793, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:52:44'),
(794, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 20:52:45'),
(795, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 20:52:45'),
(796, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 20:52:47'),
(797, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 20:55:28'),
(798, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 20:55:30'),
(799, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:05:13'),
(800, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:05:14'),
(801, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:05:20'),
(802, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:05:20'),
(803, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:06:01'),
(804, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:06:01'),
(805, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:06:14'),
(806, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:06:14'),
(807, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:06:31'),
(808, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:06:31'),
(809, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:07:38'),
(810, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:07:38'),
(811, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:08:14'),
(812, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:08:15'),
(813, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:08:21'),
(814, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:08:21'),
(815, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:08:22'),
(816, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:08:32'),
(817, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:08:50'),
(818, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:08:56'),
(819, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:09:04'),
(820, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-28 21:09:12'),
(821, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 21:09:48'),
(822, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 21:09:56'),
(823, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:10:13'),
(824, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:10:22'),
(825, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-28 21:10:27'),
(826, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:10:30'),
(827, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/1\"}', 'admin/users/1', '2026-09-28 21:10:36'),
(828, 'content_view', NULL, NULL, '{\"content_id\":5}', 'contents/5', '2026-09-28 21:10:36'),
(829, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/5\"}', 'contents/5', '2026-09-28 21:10:37'),
(830, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-28 21:11:29'),
(831, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:13:03'),
(832, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:13:04'),
(833, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:13:05'),
(834, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:13:17'),
(835, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/create\"}', 'contents/create', '2026-09-28 21:13:33'),
(836, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-28 21:16:10'),
(837, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-28 21:16:17'),
(838, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:17:34'),
(839, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:17:39'),
(840, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:17:39'),
(841, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 21:17:40'),
(842, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 21:17:42'),
(843, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 21:17:52'),
(844, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 21:17:52'),
(845, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:18:03'),
(846, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:18:03'),
(847, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:18:04'),
(848, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:18:08'),
(849, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-28 21:18:17'),
(850, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:18:25'),
(851, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:18:31'),
(852, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:18:36'),
(853, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/20\"}', 'admin/users/20', '2026-09-28 21:18:37'),
(854, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:20:16'),
(855, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:20:19'),
(856, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:20:30'),
(857, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/20\"}', 'admin/users/20', '2026-09-28 21:20:34'),
(858, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/20\"}', 'admin/users/20', '2026-09-28 21:20:38'),
(859, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 21:20:42'),
(860, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/20\"}', 'admin/users/20', '2026-09-28 21:20:44'),
(861, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/20\"}', 'admin/users/20', '2026-09-28 21:21:52'),
(862, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/20\"}', 'admin/users/20', '2026-09-28 21:24:17'),
(863, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/reviews\"}', 'admin/reviews', '2026-09-28 21:24:28'),
(864, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/reviews\"}', 'admin/reviews', '2026-09-28 21:24:39'),
(865, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/reviews\"}', 'admin/reviews', '2026-09-28 21:24:43'),
(866, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/reviews\"}', 'admin/reviews', '2026-09-28 21:24:50'),
(867, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/feedback\"}', 'admin/feedback', '2026-09-28 21:24:59'),
(868, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:25:12'),
(869, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:25:13'),
(870, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:25:15'),
(871, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:25:19'),
(872, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 21:25:25'),
(873, 'page_view', NULL, NULL, '{\"path\":\"\\/my-messages\"}', 'my-messages', '2026-09-28 21:25:30'),
(874, 'page_view', NULL, NULL, '{\"path\":\"\\/my-messages\"}', 'my-messages', '2026-09-28 21:25:34'),
(875, 'page_view', NULL, NULL, '{\"path\":\"\\/articles\"}', 'articles', '2026-09-28 21:25:41'),
(876, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:25:52'),
(877, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:25:57'),
(878, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:25:58'),
(879, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:26:08'),
(880, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:26:08'),
(881, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 21:26:13'),
(882, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 21:26:17'),
(883, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 21:26:18'),
(884, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 21:27:02'),
(885, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 21:27:07'),
(886, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:28:05'),
(887, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/ghost-in-the-shell-section-9-badge\"}', 'merchandise/ghost-in-the-shell-section-9-badge', '2026-09-28 21:28:09'),
(888, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:28:28'),
(889, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:28:28'),
(890, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:28:29'),
(891, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:28:47'),
(892, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:29:44'),
(893, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 21:30:37'),
(894, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 21:30:39'),
(895, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 21:30:41'),
(896, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 21:30:42'),
(897, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 21:30:50'),
(898, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:30:53'),
(899, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:30:54'),
(900, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:35:13'),
(901, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:35:18'),
(902, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:37:38'),
(903, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:40:47'),
(904, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:43:03'),
(905, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/ghost-in-the-shell-section-9-badge\"}', 'merchandise/ghost-in-the-shell-section-9-badge', '2026-09-28 21:43:06'),
(906, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:43:20'),
(907, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:48:15'),
(908, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:50:33'),
(909, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:50:34'),
(910, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 21:50:48'),
(911, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:50:48'),
(912, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:51:01'),
(913, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:51:02'),
(914, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:51:05'),
(915, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/elden-ring-tarnished-enamel-pin-set\"}', 'merchandise/elden-ring-tarnished-enamel-pin-set', '2026-09-28 21:51:08'),
(916, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:51:20'),
(917, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:51:34'),
(918, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/akira-kaneda-jacket-replica\"}', 'merchandise/akira-kaneda-jacket-replica', '2026-09-28 21:51:56'),
(919, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 21:52:02'),
(920, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:53:20'),
(921, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:53:26'),
(922, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:53:28'),
(923, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\\/edit\"}', 'merchandise/shayan/edit', '2026-09-28 21:55:17'),
(924, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:55:34'),
(925, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:55:36'),
(926, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:55:37'),
(927, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:55:54'),
(928, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:56:03'),
(929, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:56:03'),
(930, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:56:05'),
(931, 'page_view', NULL, NULL, '{\"path\":\"\\/register\"}', 'register', '2026-09-28 21:56:11'),
(932, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:56:38'),
(933, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:57:17'),
(934, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:57:42'),
(935, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:57:49'),
(936, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:57:54'),
(937, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:58:24'),
(938, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:58:24'),
(939, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:58:25'),
(940, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:58:28'),
(941, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:58:40'),
(942, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 21:58:41'),
(943, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 21:58:42'),
(944, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 21:58:51'),
(945, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:58:54'),
(946, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/shayan\"}', 'merchandise/shayan', '2026-09-28 21:58:56'),
(947, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 21:59:00'),
(948, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/the-last-of-us-part-ii-ellie-tattoo-sleeve\"}', 'merchandise/the-last-of-us-part-ii-ellie-tattoo-sleeve', '2026-09-28 21:59:05'),
(949, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:00:14'),
(950, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:00:17'),
(951, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:00:23'),
(952, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 22:00:28'),
(953, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:00:34'),
(954, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:00:36'),
(955, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:00:40'),
(956, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:03:14'),
(957, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:05:52'),
(958, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:05:55'),
(959, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:06:26'),
(960, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:06:29'),
(961, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:10:45'),
(962, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:10:51'),
(963, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:10:51'),
(964, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:10:54'),
(965, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:11:30'),
(966, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:11:35'),
(967, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:11:40'),
(968, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-28 22:11:48'),
(969, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 22:11:51'),
(970, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\\/30\"}', 'admin/users/30', '2026-09-28 22:11:56'),
(971, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/feedback\"}', 'admin/feedback', '2026-09-28 22:12:08'),
(972, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/faqs\"}', 'admin/faqs', '2026-09-28 22:12:12'),
(973, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 22:12:20'),
(974, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/profile\"}', 'admin/profile', '2026-09-28 22:12:22'),
(975, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-28 22:12:26'),
(976, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/contents\"}', 'admin/contents', '2026-09-28 22:12:31'),
(977, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 22:12:33'),
(978, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/contents\"}', 'admin/contents', '2026-09-28 22:13:01'),
(979, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/contents\\/create\"}', 'admin/contents/create', '2026-09-28 22:13:03'),
(980, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:15:18'),
(981, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:15:18'),
(982, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:15:20'),
(983, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:15:21'),
(984, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 22:15:22'),
(985, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 22:15:22'),
(986, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:15:24'),
(987, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:15:29'),
(988, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:15:30'),
(989, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:15:33'),
(990, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:15:37'),
(991, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:15:39'),
(992, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 22:15:52'),
(993, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:15:54'),
(994, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/elden-ring-tarnished-enamel-pin-set\"}', 'merchandise/elden-ring-tarnished-enamel-pin-set', '2026-09-28 22:15:56'),
(995, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:16:01'),
(996, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 22:16:01'),
(997, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:16:02'),
(998, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:16:03'),
(999, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 22:16:03'),
(1000, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 22:16:03'),
(1001, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 22:16:09'),
(1002, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 22:16:09'),
(1003, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 22:16:16'),
(1004, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 22:16:16'),
(1005, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:16:59'),
(1006, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:17:00'),
(1007, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-28 22:24:11'),
(1008, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:24:18'),
(1009, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:24:19'),
(1010, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:24:20'),
(1011, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:24:21'),
(1012, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:24:24'),
(1013, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:24:29'),
(1014, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-28 22:24:33'),
(1015, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-28 22:24:41'),
(1016, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/contents\"}', 'admin/contents', '2026-09-28 22:24:43'),
(1017, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/events\"}', 'admin/events', '2026-09-28 22:24:45'),
(1018, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/categories\"}', 'admin/categories', '2026-09-28 22:24:46'),
(1019, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/events\"}', 'admin/events', '2026-09-28 22:24:47'),
(1020, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/resources\"}', 'admin/resources', '2026-09-28 22:24:49'),
(1021, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/reviews\"}', 'admin/reviews', '2026-09-28 22:24:50'),
(1022, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/reviews\"}', 'admin/reviews', '2026-09-28 22:24:51'),
(1023, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/faqs\"}', 'admin/faqs', '2026-09-28 22:24:53'),
(1024, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/profile\"}', 'admin/profile', '2026-09-28 22:24:55'),
(1025, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/categories\"}', 'admin/categories', '2026-09-28 22:24:57'),
(1026, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:25:06'),
(1027, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:25:07'),
(1028, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:25:08'),
(1029, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:25:12'),
(1030, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:25:35'),
(1031, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:25:35'),
(1032, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:25:37'),
(1033, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:25:41'),
(1034, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:25:48'),
(1035, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/akira-kaneda-jacket-replica\"}', 'merchandise/akira-kaneda-jacket-replica', '2026-09-28 22:25:50'),
(1036, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:25:54'),
(1037, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/cyberpunk-2077-night-city-poster-set\"}', 'merchandise/cyberpunk-2077-night-city-poster-set', '2026-09-28 22:26:00'),
(1038, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/cyberpunk-2077-night-city-poster-set\\/edit\"}', 'merchandise/cyberpunk-2077-night-city-poster-set/edit', '2026-09-28 22:26:04'),
(1039, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:26:17'),
(1040, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:26:17'),
(1041, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:26:30'),
(1042, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:26:30'),
(1043, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:26:40'),
(1044, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:26:40'),
(1045, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:26:41'),
(1046, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:27:11'),
(1047, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:27:15'),
(1048, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:27:21'),
(1049, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:27:22'),
(1050, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 22:27:30'),
(1051, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 22:27:31'),
(1052, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 22:27:39'),
(1053, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 22:27:41'),
(1054, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/ghost-in-the-shell-section-9-badge\"}', 'merchandise/ghost-in-the-shell-section-9-badge', '2026-09-28 22:27:43'),
(1055, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:27:46'),
(1056, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:27:48'),
(1057, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:30:10'),
(1058, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:30:10'),
(1059, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:30:59'),
(1060, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:31:00'),
(1061, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 22:31:01'),
(1062, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 22:31:01'),
(1063, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:31:15'),
(1064, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:31:16'),
(1065, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:38'),
(1066, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:39'),
(1067, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:42'),
(1068, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:54'),
(1069, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:55'),
(1070, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:57'),
(1071, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:32:58'),
(1072, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:01'),
(1073, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:01'),
(1074, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:03'),
(1075, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:04'),
(1076, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:19'),
(1077, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:19'),
(1078, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-28 22:33:24'),
(1079, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:24'),
(1080, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:24'),
(1081, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:32'),
(1082, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:33:33'),
(1083, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:33:34'),
(1084, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:33:36'),
(1085, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 22:33:42'),
(1086, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 22:33:43'),
(1087, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 22:35:40'),
(1088, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 22:35:41'),
(1089, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:35:46'),
(1090, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 22:35:50'),
(1091, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 22:35:50');
INSERT INTO `analytics_events` (`id`, `event_type`, `profile_id`, `session_id`, `metadata`, `url`, `created_at`) VALUES
(1092, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:35:51'),
(1093, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:35:53'),
(1094, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:35:55'),
(1095, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 22:35:58'),
(1096, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 22:35:58'),
(1097, 'content_view', NULL, NULL, '{\"content_id\":4}', 'contents/4', '2026-09-28 22:36:28'),
(1098, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/4\"}', 'contents/4', '2026-09-28 22:36:28'),
(1099, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:36:44'),
(1100, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:36:44'),
(1101, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 22:36:45'),
(1102, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 22:36:45'),
(1103, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:38:50'),
(1104, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:38:50'),
(1105, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:40:05'),
(1106, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:40:06'),
(1107, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 22:40:07'),
(1108, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 22:40:08'),
(1109, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 22:41:14'),
(1110, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:41:18'),
(1111, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:41:24'),
(1112, 'content_view', NULL, NULL, '{\"content_id\":8}', 'contents/8', '2026-09-28 22:42:06'),
(1113, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:43:47'),
(1114, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 22:43:50'),
(1115, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 22:43:51'),
(1116, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-28 22:44:02'),
(1117, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-28 22:44:02'),
(1118, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 22:47:06'),
(1119, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:47:07'),
(1120, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:47:08'),
(1121, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:47:30'),
(1122, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:19'),
(1123, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:21'),
(1124, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:26'),
(1125, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:27'),
(1126, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:48:32'),
(1127, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:48:33'),
(1128, 'content_view', NULL, NULL, '{\"content_id\":6}', 'contents/6', '2026-09-28 22:48:34'),
(1129, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/6\"}', 'contents/6', '2026-09-28 22:48:35'),
(1130, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:48:38'),
(1131, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:48:41'),
(1132, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:48:44'),
(1133, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:46'),
(1134, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:47'),
(1135, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:48'),
(1136, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:49'),
(1137, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:49'),
(1138, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:49'),
(1139, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:49'),
(1140, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:50'),
(1141, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:48:59'),
(1142, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:49:21'),
(1143, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:49:22'),
(1144, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:49:23'),
(1145, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:49:38'),
(1146, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:49:53'),
(1147, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:49:56'),
(1148, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:49:56'),
(1149, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:49:57'),
(1150, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:49:59'),
(1151, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:50:00'),
(1152, 'content_view', NULL, NULL, '{\"content_id\":4}', 'contents/4', '2026-09-28 22:50:02'),
(1153, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/4\"}', 'contents/4', '2026-09-28 22:50:02'),
(1154, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:50:14'),
(1155, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:50:16'),
(1156, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 22:50:20'),
(1157, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:50:23'),
(1158, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:50:23'),
(1159, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:50:24'),
(1160, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:50:26'),
(1161, 'page_view', NULL, NULL, '{\"path\":\"\\/feedback\"}', 'feedback', '2026-09-28 22:50:49'),
(1162, 'page_view', NULL, NULL, '{\"path\":\"\\/about\"}', 'about', '2026-09-28 22:50:57'),
(1163, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:50:59'),
(1164, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:50:59'),
(1165, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:51:57'),
(1166, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:51:59'),
(1167, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:52:00'),
(1168, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:52:00'),
(1169, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:52:00'),
(1170, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:52:01'),
(1171, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:52:01'),
(1172, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:53:55'),
(1173, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:53:57'),
(1174, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:53:57'),
(1175, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:53:58'),
(1176, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:54:00'),
(1177, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 22:54:00'),
(1178, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-28 22:54:01'),
(1179, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-28 22:54:05'),
(1180, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:54:09'),
(1181, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:54:11'),
(1182, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:56:41'),
(1183, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 22:58:22'),
(1184, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 23:00:17'),
(1185, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-28 23:00:25'),
(1186, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:00:32'),
(1187, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:00:32'),
(1188, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:03:32'),
(1189, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:03:33'),
(1190, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:05:28'),
(1191, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:05:28'),
(1192, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:08:00'),
(1193, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:08:00'),
(1194, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:10:33'),
(1195, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:10:33'),
(1196, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:15:03'),
(1197, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:15:03'),
(1198, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 23:15:38'),
(1199, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 23:15:39'),
(1200, 'content_view', NULL, NULL, '{\"content_id\":2}', 'contents/2', '2026-09-28 23:15:47'),
(1201, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/2\"}', 'contents/2', '2026-09-28 23:15:47'),
(1202, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:15:53'),
(1203, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:15:53'),
(1204, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:16:01'),
(1205, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:16:01'),
(1206, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 23:16:52'),
(1207, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:17:56'),
(1208, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:17:56'),
(1209, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:18:15'),
(1210, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:18:15'),
(1211, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:21:39'),
(1212, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:21:40'),
(1213, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 23:23:23'),
(1214, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 23:23:32'),
(1215, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:06'),
(1216, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:07'),
(1217, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:22'),
(1218, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:22'),
(1219, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:44'),
(1220, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:45'),
(1221, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:45'),
(1222, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:24:53'),
(1223, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 23:25:02'),
(1224, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 23:25:05'),
(1225, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-28 23:25:07'),
(1226, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-28 23:25:24'),
(1227, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:26:04'),
(1228, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:26:04'),
(1229, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:26:37'),
(1230, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:32:12'),
(1231, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:32:13'),
(1232, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:34:42'),
(1233, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:34:43'),
(1234, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:37:56'),
(1235, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:37:57'),
(1236, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 23:38:21'),
(1237, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:39:09'),
(1238, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:39:10'),
(1239, 'content_view', NULL, NULL, '{\"content_id\":1}', 'contents/1', '2026-09-28 23:40:48'),
(1240, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/1\"}', 'contents/1', '2026-09-28 23:40:49'),
(1241, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:43:05'),
(1242, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:43:06'),
(1243, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:46:25'),
(1244, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-28 23:46:26'),
(1245, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-28 23:46:37'),
(1246, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-28 23:46:39'),
(1247, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-29 00:01:07'),
(1248, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:01:08'),
(1249, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:01:09'),
(1250, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-29 00:01:24'),
(1251, 'content_view', NULL, NULL, '{\"content_id\":55}', 'contents/55', '2026-09-29 00:01:26'),
(1252, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/55\"}', 'contents/55', '2026-09-29 00:01:26'),
(1253, 'content_view', NULL, NULL, '{\"content_id\":57}', 'contents/57', '2026-09-29 00:01:36'),
(1254, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/57\"}', 'contents/57', '2026-09-29 00:01:36'),
(1255, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/movies\"}', 'category/movies', '2026-09-29 00:01:47'),
(1256, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/manga\"}', 'category/manga', '2026-09-29 00:01:52'),
(1257, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/tv-series\"}', 'category/tv-series', '2026-09-29 00:01:55'),
(1258, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-29 00:01:59'),
(1259, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/cosplay\"}', 'category/cosplay', '2026-09-29 00:02:02'),
(1260, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-29 00:02:03'),
(1261, 'content_view', NULL, NULL, '{\"content_id\":3}', 'contents/3', '2026-09-29 00:02:07'),
(1262, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/3\"}', 'contents/3', '2026-09-29 00:02:07'),
(1263, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:02:13'),
(1264, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:02:13'),
(1265, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:33:01'),
(1266, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:33:01'),
(1267, 'content_view', NULL, NULL, '{\"content_id\":124}', 'contents/124', '2026-09-29 00:33:09'),
(1268, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/124\"}', 'contents/124', '2026-09-29 00:33:11'),
(1269, 'content_view', NULL, NULL, '{\"content_id\":131}', 'contents/131', '2026-09-29 00:33:26'),
(1270, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/131\"}', 'contents/131', '2026-09-29 00:33:27'),
(1271, 'content_view', NULL, NULL, '{\"content_id\":132}', 'contents/132', '2026-09-29 00:33:43'),
(1272, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/132\"}', 'contents/132', '2026-09-29 00:33:43'),
(1273, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-29 00:35:42'),
(1274, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-29 00:35:46'),
(1275, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/cosplay\"}', 'category/cosplay', '2026-09-29 00:35:49'),
(1276, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/gaming\"}', 'category/gaming', '2026-09-29 00:35:53'),
(1277, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/manga\"}', 'category/manga', '2026-09-29 00:35:56'),
(1278, 'content_view', NULL, NULL, '{\"content_id\":124}', 'contents/124', '2026-09-29 00:36:02'),
(1279, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/124\"}', 'contents/124', '2026-09-29 00:36:02'),
(1280, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/movies\"}', 'category/movies', '2026-09-29 00:36:07'),
(1281, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/tv-series\"}', 'category/tv-series', '2026-09-29 00:36:11'),
(1282, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-29 00:36:16'),
(1283, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:36:19'),
(1284, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:36:20'),
(1285, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:36:35'),
(1286, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:36:36'),
(1287, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:38:27'),
(1288, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 00:38:28'),
(1289, 'content_view', NULL, NULL, '{\"content_id\":121}', 'contents/121', '2026-09-29 00:38:42'),
(1290, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/121\"}', 'contents/121', '2026-09-29 00:38:44'),
(1291, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:08:07'),
(1292, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:08:08'),
(1293, 'content_view', NULL, NULL, '{\"content_id\":112}', 'contents/112', '2026-09-29 01:08:24'),
(1294, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/112\"}', 'contents/112', '2026-09-29 01:08:25'),
(1295, 'content_view', NULL, NULL, '{\"content_id\":134}', 'contents/134', '2026-09-29 01:10:03'),
(1296, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/134\"}', 'contents/134', '2026-09-29 01:10:03'),
(1297, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:10:30'),
(1298, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:10:30'),
(1299, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:12:58'),
(1300, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:12:58'),
(1301, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:13:03'),
(1302, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:13:03'),
(1303, 'page_view', NULL, NULL, '{\"path\":\"\\/events\\/fanhub-karachi-community-night\"}', 'events/fanhub-karachi-community-night', '2026-09-29 01:13:16'),
(1304, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-29 01:13:30'),
(1305, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:13:54'),
(1306, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:13:54'),
(1307, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:14:36'),
(1308, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:17:09'),
(1309, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:17:09'),
(1310, 'content_view', NULL, NULL, '{\"content_id\":131}', 'contents/131', '2026-09-29 01:17:16'),
(1311, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/131\"}', 'contents/131', '2026-09-29 01:17:16'),
(1312, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:29:22'),
(1313, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:29:23'),
(1314, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:29:34'),
(1315, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:29:35'),
(1316, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:35:58'),
(1317, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:35:59'),
(1318, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:36:00'),
(1319, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:36:01'),
(1320, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:47:53'),
(1321, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:47:54'),
(1322, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:47:55'),
(1323, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:47:55'),
(1324, 'chatbot_local_reply', NULL, '0b0c8b77-698b-455d-837d-b99295418159', '[]', 'chat/message', '2026-09-29 01:48:05'),
(1325, 'chatbot_local_reply', NULL, '0b0c8b77-698b-455d-837d-b99295418159', '[]', 'chat/message', '2026-09-29 01:48:37'),
(1326, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:42'),
(1327, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:43'),
(1328, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:44'),
(1329, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:44'),
(1330, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:45'),
(1331, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:45'),
(1332, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:46'),
(1333, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:46'),
(1334, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:47'),
(1335, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:47'),
(1336, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:48'),
(1337, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:48:49'),
(1338, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:48:50'),
(1339, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 01:49:01'),
(1340, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:49:23'),
(1341, 'chatbot_local_reply', NULL, '0b0c8b77-698b-455d-837d-b99295418159', '[]', 'chat/message', '2026-09-29 01:49:28'),
(1342, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:49:33'),
(1343, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:49:33'),
(1344, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:49:35'),
(1345, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:49:35'),
(1346, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:51:12'),
(1347, 'chatbot_local_reply', NULL, '0b0c8b77-698b-455d-837d-b99295418159', '[]', 'chat/message', '2026-09-29 01:51:21'),
(1348, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:53:58'),
(1349, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:53:59'),
(1350, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:54:00'),
(1351, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:00'),
(1352, 'chatbot_local_reply', NULL, '0b0c8b77-698b-455d-837d-b99295418159', '[]', 'chat/message', '2026-09-29 01:54:10'),
(1353, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:13'),
(1354, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:14'),
(1355, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:54:14'),
(1356, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:15'),
(1357, 'chatbot_local_reply', NULL, '0b0c8b77-698b-455d-837d-b99295418159', '[]', 'chat/message', '2026-09-29 01:54:29'),
(1358, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:31'),
(1359, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:31'),
(1360, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 01:54:33'),
(1361, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 01:54:33'),
(1362, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:14:54'),
(1363, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:14:55'),
(1364, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-29 02:15:08'),
(1365, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/anime\"}', 'category/anime', '2026-09-29 02:15:21'),
(1366, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/comics\"}', 'category/comics', '2026-09-29 02:15:28'),
(1367, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/cosplay\"}', 'category/cosplay', '2026-09-29 02:15:30'),
(1368, 'page_view', NULL, NULL, '{\"path\":\"\\/category\\/movies\"}', 'category/movies', '2026-09-29 02:15:33'),
(1369, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:15:40'),
(1370, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:15:41'),
(1371, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:16:25'),
(1372, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:16:26'),
(1373, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 02:17:07'),
(1374, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:17:08'),
(1375, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:17:08'),
(1376, 'content_view', NULL, NULL, '{\"content_id\":178}', 'contents/178', '2026-09-29 02:17:21'),
(1377, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/178\"}', 'contents/178', '2026-09-29 02:17:21'),
(1378, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:19:14'),
(1379, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:19:15'),
(1380, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:19:27'),
(1381, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:19:27'),
(1382, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:26:15'),
(1383, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:26:16'),
(1384, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:32:11'),
(1385, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:32:12'),
(1386, 'content_view', NULL, NULL, '{\"content_id\":111}', 'contents/111', '2026-09-29 02:33:10'),
(1387, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/111\"}', 'contents/111', '2026-09-29 02:33:10'),
(1388, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:33:35'),
(1389, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:33:36'),
(1390, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:53:54'),
(1391, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:53:55'),
(1392, 'content_view', NULL, NULL, '{\"content_id\":112}', 'contents/112', '2026-09-29 02:53:59'),
(1393, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/112\"}', 'contents/112', '2026-09-29 02:53:59'),
(1394, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:55:26'),
(1395, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:55:27'),
(1396, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:55:28'),
(1397, 'content_view', NULL, NULL, '{\"content_id\":158}', 'contents/158', '2026-09-29 02:55:52'),
(1398, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/158\"}', 'contents/158', '2026-09-29 02:55:52'),
(1399, 'content_view', NULL, NULL, '{\"content_id\":159}', 'contents/159', '2026-09-29 02:56:06'),
(1400, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/159\"}', 'contents/159', '2026-09-29 02:56:06'),
(1401, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:56:11'),
(1402, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:56:37'),
(1403, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:56:38'),
(1404, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 02:56:39'),
(1405, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:56:40'),
(1406, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:58:46'),
(1407, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:58:47'),
(1408, 'content_view', NULL, NULL, '{\"content_id\":170}', 'contents/170', '2026-09-29 02:58:55'),
(1409, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/170\"}', 'contents/170', '2026-09-29 02:58:55'),
(1410, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:59:21'),
(1411, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 02:59:22'),
(1412, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:00:56'),
(1413, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:00:57'),
(1414, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-29 03:03:36'),
(1415, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:03:43'),
(1416, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:03:44'),
(1417, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 03:03:44'),
(1418, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 03:03:48'),
(1419, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 03:03:50'),
(1420, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-29 03:03:52'),
(1421, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 03:05:08'),
(1422, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/create\"}', 'merchandise/create', '2026-09-29 03:05:14'),
(1423, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 03:06:04'),
(1424, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 03:06:16'),
(1425, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:06:24'),
(1426, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:06:25'),
(1427, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 03:06:26'),
(1428, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 03:06:30'),
(1429, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 03:06:34'),
(1430, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:06:42'),
(1431, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:06:42'),
(1432, 'content_view', NULL, NULL, '{\"content_id\":175}', 'contents/175', '2026-09-29 03:07:41'),
(1433, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/175\"}', 'contents/175', '2026-09-29 03:07:41'),
(1434, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:08:06'),
(1435, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:08:07'),
(1436, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:09:52'),
(1437, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 03:09:53'),
(1438, 'page_view', NULL, NULL, '{\"path\":\"\\/explore\"}', 'explore', '2026-09-29 03:09:58'),
(1439, 'page_view', NULL, NULL, '{\"path\":\"\\/events\"}', 'events', '2026-09-29 03:09:59'),
(1440, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 03:10:01'),
(1441, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/wasiq\"}', 'merchandise/wasiq', '2026-09-29 03:10:04'),
(1442, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\\/fasihuddin\"}', 'merchandise/fasihuddin', '2026-09-29 03:10:11'),
(1443, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:32:02'),
(1444, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:32:39'),
(1445, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:32:44'),
(1446, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:32:45'),
(1447, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 04:32:47'),
(1448, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:32:52'),
(1449, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:32:56'),
(1450, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:32:57'),
(1451, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:35:35'),
(1452, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:35:36'),
(1453, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 04:35:36'),
(1454, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:35:39'),
(1455, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 04:35:44'),
(1456, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 04:35:47'),
(1457, 'page_view', NULL, NULL, '{\"path\":\"\\/chat\\/history\"}', 'chat/history', '2026-09-29 04:35:55'),
(1458, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:36:42'),
(1459, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:36:42'),
(1460, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 04:36:43'),
(1461, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:36:47'),
(1462, 'page_view', NULL, NULL, '{\"path\":\"\\/merchandise\"}', 'merchandise', '2026-09-29 04:36:47'),
(1463, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\"}', 'admin', '2026-09-29 04:36:51'),
(1464, 'page_view', NULL, NULL, '{\"path\":\"\\/admin\\/users\"}', 'admin/users', '2026-09-29 04:37:02'),
(1465, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:37:22'),
(1466, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:37:23'),
(1467, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:04'),
(1468, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:05'),
(1469, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 04:38:05'),
(1470, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:38:08'),
(1471, 'page_view', NULL, NULL, '{\"path\":\"\\/bookmarks\"}', 'bookmarks', '2026-09-29 04:38:13'),
(1472, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:16'),
(1473, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:17'),
(1474, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-29 04:38:25'),
(1475, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-29 04:38:31'),
(1476, 'page_view', NULL, NULL, '{\"path\":\"\\/profile\"}', 'profile', '2026-09-29 04:38:36'),
(1477, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:38:49'),
(1478, 'page_view', NULL, NULL, '{\"path\":\"\\/dashboard\"}', 'dashboard', '2026-09-29 04:38:49'),
(1479, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:54'),
(1480, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:55'),
(1481, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:57'),
(1482, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:38:58'),
(1483, 'content_view', NULL, NULL, '{\"content_id\":155}', 'contents/155', '2026-09-29 04:39:33'),
(1484, 'page_view', NULL, NULL, '{\"path\":\"\\/contents\\/155\"}', 'contents/155', '2026-09-29 04:39:35'),
(1485, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:55:46'),
(1486, 'page_view', NULL, NULL, '{\"path\":\"\\/\"}', '/', '2026-09-29 04:55:47'),
(1487, 'page_view', NULL, NULL, '{\"path\":\"\\/login\"}', 'login', '2026-09-29 04:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `read_time_minutes` smallint(5) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `category_id`, `title`, `slug`, `excerpt`, `body`, `cover_image`, `status`, `is_featured`, `published_at`, `created_at`, `updated_at`, `deleted_at`, `read_time_minutes`) VALUES
(1, 20, 2, 'the horror', 'the-horror', 'horror movie', '<p>horror</p>', 'articles/MbqjVgTW0DkXAOOIzd98Z7GYdKlCIsYN4hzlnUED.png', 'published', 0, '2026-09-28 10:31:09', '2026-09-28 10:31:09', '2026-09-28 10:31:09', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('22d200f8670dbdb3e253a90eee5098477c95c23d', 'i:3;', 1790656756),
('22d200f8670dbdb3e253a90eee5098477c95c23d:timer', 'i:1790656756;', 1790656756),
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1790656702),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1790656702;', 1790656702),
('5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1790657806),
('5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1790657806;', 1790657806),
('7b2c1ceea801a29a640862138f49fe58', 'i:7;', 1790648079),
('7b2c1ceea801a29a640862138f49fe58:timer', 'i:1790648079;', 1790648079),
('91032ad7bbcb6cf72875e8e8207dcfba80173f7c', 'i:1;', 1790635919),
('91032ad7bbcb6cf72875e8e8207dcfba80173f7c:timer', 'i:1790635919;', 1790635919),
('admin@fanhubplus.test|127.0.0.1', 'i:2;', 1790633550),
('admin@fanhubplus.test|127.0.0.1:timer', 'i:1790633550;', 1790633550),
('analytics.trending', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:11:{i:0;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:5;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:40:\"Demon Slayer — Infinity Castle Preview\";s:4:\"slug\";s:36:\"demon-slayer-infinity-castle-preview\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:11206;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=x7uLutVRBfI\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:5;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:40:\"Demon Slayer — Infinity Castle Preview\";s:4:\"slug\";s:36:\"demon-slayer-infinity-castle-preview\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:11206;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=x7uLutVRBfI\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:1;s:4:\"name\";s:5:\"Anime\";s:4:\"slug\";s:5:\"anime\";s:11:\"description\";s:35:\"Anime fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:74:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"play-circle\"></svg>\";s:5:\"color\";s:7:\"#ec4899\";s:10:\"sort_order\";i:1;}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:1;s:4:\"name\";s:5:\"Anime\";s:4:\"slug\";s:5:\"anime\";s:11:\"description\";s:35:\"Anime fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:74:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"play-circle\"></svg>\";s:5:\"color\";s:7:\"#ec4899\";s:10:\"sort_order\";i:1;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:6:\"status\";i:4;s:8:\"icon_svg\";i:5;s:5:\"color\";i:6;s:10:\"sort_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:1;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:2;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:37:\"Black Myth: Wukong — First Gameplay\";s:4:\"slug\";s:32:\"black-myth-wukong-first-gameplay\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:8907;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=7eS7schhJ8k\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:2;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:37:\"Black Myth: Wukong — First Gameplay\";s:4:\"slug\";s:32:\"black-myth-wukong-first-gameplay\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:8907;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=7eS7schhJ8k\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:6;s:4:\"name\";s:6:\"Gaming\";s:4:\"slug\";s:6:\"gaming\";s:11:\"description\";s:36:\"Gaming fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:70:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"gamepad\"></svg>\";s:5:\"color\";s:7:\"#6366f1\";s:10:\"sort_order\";i:6;}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:6;s:4:\"name\";s:6:\"Gaming\";s:4:\"slug\";s:6:\"gaming\";s:11:\"description\";s:36:\"Gaming fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:70:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"gamepad\"></svg>\";s:5:\"color\";s:7:\"#6366f1\";s:10:\"sort_order\";i:6;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:6:\"status\";i:4;s:8:\"icon_svg\";i:5;s:5:\"color\";i:6;s:10:\"sort_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:2;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:1;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:45:\"Elden Ring — Shadow of the Erdtree Gameplay\";s:4:\"slug\";s:41:\"elden-ring-shadow-of-the-erdtree-gameplay\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:7206;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=JugxpebuS_E\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:1;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:45:\"Elden Ring — Shadow of the Erdtree Gameplay\";s:4:\"slug\";s:41:\"elden-ring-shadow-of-the-erdtree-gameplay\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:7206;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=JugxpebuS_E\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:215;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:3;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:6;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:39:\"Jujutsu Kaisen — Culling Game Trailer\";s:4:\"slug\";s:35:\"jujutsu-kaisen-culling-game-trailer\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:9805;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=MePL_vS-G9Q\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:6;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:39:\"Jujutsu Kaisen — Culling Game Trailer\";s:4:\"slug\";s:35:\"jujutsu-kaisen-culling-game-trailer\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:9805;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=MePL_vS-G9Q\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:66;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:4;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:3;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:38:\"Civilization VII — Gameplay Overview\";s:4:\"slug\";s:34:\"civilization-vii-gameplay-overview\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:3405;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/kK_JrrP9m2U/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=kK_JrrP9m2U\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:3;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:38:\"Civilization VII — Gameplay Overview\";s:4:\"slug\";s:34:\"civilization-vii-gameplay-overview\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:3405;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/kK_JrrP9m2U/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=kK_JrrP9m2U\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:215;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:5;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:4;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:52:\"League of Legends Worlds — Championship Highlights\";s:4:\"slug\";s:48:\"league-of-legends-worlds-championship-highlights\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:4604;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=rZHrffKAc6k\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:4;s:7:\"user_id\";i:1;s:11:\"category_id\";i:6;s:5:\"title\";s:52:\"League of Legends Worlds — Championship Highlights\";s:4:\"slug\";s:48:\"league-of-legends-worlds-championship-highlights\";s:4:\"body\";s:174:\"A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:6:\"Gaming\";s:4:\"year\";i:2026;s:4:\"type\";s:4:\"game\";s:11:\"views_count\";i:4604;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=rZHrffKAc6k\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:215;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:6;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:8;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:42:\"Frieren — Beyond Journey’s End Preview\";s:4:\"slug\";s:35:\"frieren-beyond-journeys-end-preview\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:6704;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=tR8YH0G67Rk\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:8;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:42:\"Frieren — Beyond Journey’s End Preview\";s:4:\"slug\";s:35:\"frieren-beyond-journeys-end-preview\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:6704;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=tR8YH0G67Rk\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:66;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:7;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:124;s:7:\"user_id\";i:1;s:11:\"category_id\";i:4;s:5:\"title\";s:69:\"Sword of the Demon Hunter: Kijin Gentosho — Manga Promotional Video\";s:4:\"slug\";s:64:\"sword-of-the-demon-hunter-kijin-gentosho-manga-promotional-video\";s:4:\"body\";s:180:\"A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:13:\"Manga Preview\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:1;s:9:\"thumbnail\";s:59:\"https://images3.penguinrandomhouse.com/smedia/9781685793333\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=l-0oLbHzfWw\";s:10:\"created_at\";s:19:\"2026-09-29 05:28:42\";s:10:\"updated_at\";s:19:\"2026-09-29 05:42:13\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:124;s:7:\"user_id\";i:1;s:11:\"category_id\";i:4;s:5:\"title\";s:69:\"Sword of the Demon Hunter: Kijin Gentosho — Manga Promotional Video\";s:4:\"slug\";s:64:\"sword-of-the-demon-hunter-kijin-gentosho-manga-promotional-video\";s:4:\"body\";s:180:\"A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:13:\"Manga Preview\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:1;s:9:\"thumbnail\";s:59:\"https://images3.penguinrandomhouse.com/smedia/9781685793333\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=l-0oLbHzfWw\";s:10:\"created_at\";s:19:\"2026-09-29 05:28:42\";s:10:\"updated_at\";s:19:\"2026-09-29 05:42:13\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:4;s:4:\"name\";s:5:\"Manga\";s:4:\"slug\";s:5:\"manga\";s:11:\"description\";s:35:\"Manga fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:72:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"book-open\"></svg>\";s:5:\"color\";s:7:\"#f59e0b\";s:10:\"sort_order\";i:4;}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:4;s:4:\"name\";s:5:\"Manga\";s:4:\"slug\";s:5:\"manga\";s:11:\"description\";s:35:\"Manga fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:72:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"book-open\"></svg>\";s:5:\"color\";s:7:\"#f59e0b\";s:10:\"sort_order\";i:4;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:6:\"status\";i:4;s:8:\"icon_svg\";i:5;s:5:\"color\";i:6;s:10:\"sort_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:8;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:131;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";s:38:\"Superestar — Official Series Trailer\";s:4:\"slug\";s:34:\"superestar-official-series-trailer\";s:4:\"body\";s:186:\"A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:15:\"Drama & Fantasy\";s:4:\"year\";i:2026;s:4:\"type\";s:6:\"series\";s:11:\"views_count\";i:1;s:9:\"thumbnail\";s:60:\"https://pics.filmaffinity.com/superestar-231903360-large.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=h75xrfq-SBE\";s:10:\"created_at\";s:19:\"2026-09-29 05:28:42\";s:10:\"updated_at\";s:19:\"2026-09-29 05:42:13\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:131;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";s:38:\"Superestar — Official Series Trailer\";s:4:\"slug\";s:34:\"superestar-official-series-trailer\";s:4:\"body\";s:186:\"A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:15:\"Drama & Fantasy\";s:4:\"year\";i:2026;s:4:\"type\";s:6:\"series\";s:11:\"views_count\";i:1;s:9:\"thumbnail\";s:60:\"https://pics.filmaffinity.com/superestar-231903360-large.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=h75xrfq-SBE\";s:10:\"created_at\";s:19:\"2026-09-29 05:28:42\";s:10:\"updated_at\";s:19:\"2026-09-29 05:42:13\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:2;s:4:\"name\";s:9:\"TV Series\";s:4:\"slug\";s:9:\"tv-series\";s:11:\"description\";s:39:\"TV Series fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:65:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"tv\"></svg>\";s:5:\"color\";s:7:\"#8b5cf6\";s:10:\"sort_order\";i:2;}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:2;s:4:\"name\";s:9:\"TV Series\";s:4:\"slug\";s:9:\"tv-series\";s:11:\"description\";s:39:\"TV Series fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:65:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"tv\"></svg>\";s:5:\"color\";s:7:\"#8b5cf6\";s:10:\"sort_order\";i:2;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:6:\"status\";i:4;s:8:\"icon_svg\";i:5;s:5:\"color\";i:6;s:10:\"sort_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:9;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:112;s:7:\"user_id\";i:1;s:11:\"category_id\";i:7;s:5:\"title\";s:42:\"Odin Makes — Gundam Cosplay Helmet Build\";s:4:\"slug\";s:38:\"odin-makes-gundam-cosplay-helmet-build\";s:4:\"body\";s:188:\"A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:19:\"Male Cosplay Builds\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"other\";s:11:\"views_count\";i:1;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/gO3yICj9gvY/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=gO3yICj9gvY\";s:10:\"created_at\";s:19:\"2026-09-29 05:17:03\";s:10:\"updated_at\";s:19:\"2026-09-29 08:05:31\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:112;s:7:\"user_id\";i:1;s:11:\"category_id\";i:7;s:5:\"title\";s:42:\"Odin Makes — Gundam Cosplay Helmet Build\";s:4:\"slug\";s:38:\"odin-makes-gundam-cosplay-helmet-build\";s:4:\"body\";s:188:\"A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:19:\"Male Cosplay Builds\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"other\";s:11:\"views_count\";i:1;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/gO3yICj9gvY/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=gO3yICj9gvY\";s:10:\"created_at\";s:19:\"2026-09-29 05:17:03\";s:10:\"updated_at\";s:19:\"2026-09-29 08:05:31\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:7;s:4:\"name\";s:7:\"Cosplay\";s:4:\"slug\";s:7:\"cosplay\";s:11:\"description\";s:37:\"Cosplay fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:74:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"user-circle\"></svg>\";s:5:\"color\";s:7:\"#f43f5e\";s:10:\"sort_order\";i:7;}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:7;s:4:\"name\";s:7:\"Cosplay\";s:4:\"slug\";s:7:\"cosplay\";s:11:\"description\";s:37:\"Cosplay fandom content and community.\";s:6:\"status\";s:6:\"active\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-26 23:34:49\";s:8:\"icon_svg\";s:74:\"<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"user-circle\"></svg>\";s:5:\"color\";s:7:\"#f43f5e\";s:10:\"sort_order\";i:7;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:7:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:6:\"status\";i:4;s:8:\"icon_svg\";i:5;s:5:\"color\";i:6;s:10:\"sort_order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}i:10;O:18:\"App\\Models\\Content\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"contents\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:17:{s:2:\"id\";i:7;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:35:\"Vinland Saga — Season Two Trailer\";s:4:\"slug\";s:31:\"vinland-saga-season-two-trailer\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:4401;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=Ph50sNkApVM\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:11:\"\0*\0original\";a:17:{s:2:\"id\";i:7;s:7:\"user_id\";i:1;s:11:\"category_id\";i:1;s:5:\"title\";s:35:\"Vinland Saga — Season Two Trailer\";s:4:\"slug\";s:31:\"vinland-saga-season-two-trailer\";s:4:\"body\";s:176:\"A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.\";s:6:\"status\";s:9:\"published\";s:5:\"genre\";s:9:\"Adventure\";s:4:\"year\";i:2026;s:4:\"type\";s:5:\"anime\";s:11:\"views_count\";i:4401;s:9:\"thumbnail\";s:52:\"https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg\";s:11:\"trailer_url\";s:43:\"https://www.youtube.com/watch?v=Ph50sNkApVM\";s:10:\"created_at\";s:19:\"2026-09-26 23:34:49\";s:10:\"updated_at\";s:19:\"2026-09-29 05:36:58\";s:10:\"deleted_at\";N;s:12:\"release_date\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"year\";s:7:\"integer\";s:11:\"views_count\";s:7:\"integer\";s:12:\"release_date\";s:4:\"date\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:66;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:13:{i:0;s:7:\"user_id\";i:1;s:11:\"category_id\";i:2;s:5:\"title\";i:3;s:4:\"slug\";i:4;s:4:\"body\";i:5;s:6:\"status\";i:6;s:5:\"genre\";i:7;s:4:\"year\";i:8;s:4:\"type\";i:9;s:11:\"views_count\";i:10;s:9:\"thumbnail\";i:11;s:11:\"trailer_url\";i:12;s:12:\"release_date\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1790658346),
('setting.contact_email', 's:17:\"hello@example.com\";', 1790636149);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon_svg` text DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#8b5cf6',
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`, `icon_svg`, `color`, `sort_order`) VALUES
(1, 'Anime', 'anime', 'Anime fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"play-circle\"></svg>', '#ec4899', 1),
(2, 'TV Series', 'tv-series', 'TV Series fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"tv\"></svg>', '#8b5cf6', 2),
(3, 'Movies', 'movies', 'Movies fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"film\"></svg>', '#06b6d4', 3),
(4, 'Manga', 'manga', 'Manga fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"book-open\"></svg>', '#f59e0b', 4),
(5, 'Comics', 'comics', 'Comics fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"zap\"></svg>', '#10b981', 5),
(6, 'Gaming', 'gaming', 'Gaming fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"gamepad\"></svg>', '#6366f1', 6),
(7, 'Cosplay', 'cosplay', 'Cosplay fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"user-circle\"></svg>', '#f43f5e', 7),
(8, 'Events', 'events', 'Events fandom content and community.', 'active', '2026-09-26 18:34:49', '2026-09-26 18:34:49', '<svg viewBox=\"0 0 24 24\" aria-hidden=\"true\" data-icon=\"calendar\"></svg>', '#a855f7', 8);

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` enum('protagonist','antagonist','supporting','other') NOT NULL DEFAULT 'other',
  `order_index` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_session_id` bigint(20) UNSIGNED NOT NULL,
  `sender` enum('user','bot') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tokens_used` int(10) UNSIGNED DEFAULT NULL,
  `feedback` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `chat_session_id`, `sender`, `message`, `created_at`, `tokens_used`, `feedback`) VALUES
(1, 1, 'user', 'hello', '2026-09-26 18:35:51', NULL, NULL),
(2, 1, 'bot', 'Hi! I\'m the FanHub assistant. I can recommend popular content, search titles, or answer questions from the FanHub FAQs. What are you in the mood for?', '2026-09-26 18:35:51', NULL, 1),
(3, 1, 'user', 'ffhf', '2026-09-26 18:39:38', NULL, NULL),
(4, 1, 'bot', 'I can help you discover FanHub+ content and answer questions covered by our FAQs. Try asking for popular recommendations, or mention a title or genre. You can also browse [Explore](http://127.0.0.1:8000/explore).', '2026-09-26 18:39:39', NULL, NULL),
(5, 1, 'user', '..', '2026-09-28 08:40:13', NULL, NULL),
(6, 1, 'bot', 'I found these FanHub+ matches for you:\n\n- [Demon Slayer — Infinity Castle Arc Preview](http://127.0.0.1:8000/contents/5)\n- [Jujutsu Kaisen Season 3 — Culling Game Begins](http://127.0.0.1:8000/contents/6)\n- [Black Myth: Wukong — First Impressions](http://127.0.0.1:8000/contents/2)\n- [Elden Ring Shadow of the Erdtree — Review](http://127.0.0.1:8000/contents/1)\n\nWant recommendations in a specific genre?', '2026-09-28 08:40:13', NULL, -1),
(7, 1, 'user', 'MUJHA ABOUT KA PAGE KI LINK DOU', '2026-09-28 12:44:14', NULL, NULL),
(8, 1, 'bot', 'I found these FanHub+ matches for you:\n\n- [Frieren: Beyond Journey\'s End — Why Everyone Is Talking About It](http://127.0.0.1:8000/contents/8)\n\nWant recommendations in a specific genre?', '2026-09-28 12:44:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_sessions`
--

INSERT INTO `chat_sessions` (`id`, `session_id`, `user_id`, `profile_id`, `created_at`, `updated_at`, `title`) VALUES
(1, 'b44a635f-363e-4877-8e28-a2fb5502d88e', 20, NULL, '2026-09-26 18:35:51', '2026-09-28 08:40:13', 'hello'),
(2, '0b0c8b77-698b-455d-837d-b99295418159', 30, NULL, '2026-09-29 01:48:05', '2026-09-29 01:48:05', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `genre` varchar(255) DEFAULT NULL,
  `year` smallint(5) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `views_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `thumbnail` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `user_id`, `category_id`, `title`, `slug`, `body`, `status`, `genre`, `year`, `type`, `views_count`, `thumbnail`, `trailer_url`, `created_at`, `updated_at`, `deleted_at`, `release_date`) VALUES
(1, 1, 6, 'Elden Ring — Shadow of the Erdtree Gameplay', 'elden-ring-shadow-of-the-erdtree-gameplay', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 7206, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(2, 1, 6, 'Black Myth: Wukong — First Gameplay', 'black-myth-wukong-first-gameplay', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 8907, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(3, 1, 6, 'Civilization VII — Gameplay Overview', 'civilization-vii-gameplay-overview', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 3405, 'https://img.youtube.com/vi/kK_JrrP9m2U/hqdefault.jpg', 'https://www.youtube.com/watch?v=kK_JrrP9m2U', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(4, 1, 6, 'League of Legends Worlds — Championship Highlights', 'league-of-legends-worlds-championship-highlights', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 4604, 'https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg', 'https://www.youtube.com/watch?v=rZHrffKAc6k', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(5, 1, 1, 'Demon Slayer — Infinity Castle Preview', 'demon-slayer-infinity-castle-preview', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 11206, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(6, 1, 1, 'Jujutsu Kaisen — Culling Game Trailer', 'jujutsu-kaisen-culling-game-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 9805, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(7, 1, 1, 'Vinland Saga — Season Two Trailer', 'vinland-saga-season-two-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 4401, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(8, 1, 1, 'Frieren — Beyond Journey’s End Preview', 'frieren-beyond-journeys-end-preview', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 6704, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-26 18:34:49', '2026-09-29 00:36:58', NULL, NULL),
(9, 1, 1, 'Demon Slayer — Infinity Castle Preview — FanHub Video 1', 'demon-slayer-infinity-castle-preview-fanhub-video-1', 'Watch this Adventure feature selected for Anime. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(10, 1, 1, 'Jujutsu Kaisen — Culling Game Trailer — FanHub Video 2', 'jujutsu-kaisen-culling-game-trailer-fanhub-video-2', 'Watch this Adventure feature selected for Anime. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(11, 1, 1, 'Vinland Saga — Season Two Trailer — FanHub Video 3', 'vinland-saga-season-two-trailer-fanhub-video-3', 'Watch this Adventure feature selected for Anime. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(12, 1, 1, 'Frieren — Beyond Journey’s End Preview — FanHub Video 4', 'frieren-beyond-journeys-end-preview-fanhub-video-4', 'Watch this Adventure feature selected for Anime. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(13, 1, 1, 'New Saga — Official Anime Trailer — FanHub Video 5', 'new-saga-official-anime-trailer-fanhub-video-5', 'Watch this Adventure feature selected for Anime. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(14, 1, 5, 'Marvel Ultimate Endgame — Comic Event Trailer — FanHub Video 1', 'marvel-ultimate-endgame-comic-event-trailer-fanhub-video-1', 'Watch this Superhero feature selected for Comics. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/j1YHKBraABA/hqdefault.jpg', 'https://www.youtube.com/watch?v=j1YHKBraABA', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(15, 1, 5, 'The Ultimates #1 — Marvel Comics Trailer — FanHub Video 2', 'the-ultimates-1-marvel-comics-trailer-fanhub-video-2', 'Watch this Superhero feature selected for Comics. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/jXvLMDSk8LY/hqdefault.jpg', 'https://www.youtube.com/watch?v=jXvLMDSk8LY', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(16, 1, 5, 'Marvel Comics — New Stories Trailer Reel — FanHub Video 3', 'marvel-comics-new-stories-trailer-reel-fanhub-video-3', 'Watch this Superhero feature selected for Comics. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/78N6JyT4nM8/hqdefault.jpg', 'https://www.youtube.com/watch?v=78N6JyT4nM8', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(17, 1, 5, 'Avengers: Doomsday — Official Teaser — FanHub Video 4', 'avengers-doomsday-official-teaser-fanhub-video-4', 'Watch this Superhero feature selected for Comics. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/399Ez7WHK5s/hqdefault.jpg', 'https://www.youtube.com/watch?v=399Ez7WHK5s', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(18, 1, 5, 'Avengers: Doomsday — First Look — FanHub Video 5', 'avengers-doomsday-first-look-fanhub-video-5', 'Watch this Superhero feature selected for Comics. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/UiMg566PREA/hqdefault.jpg', 'https://www.youtube.com/watch?v=UiMg566PREA', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(19, 1, 4, 'Demon Slayer — Manga to Screen Preview — FanHub Video 1', 'demon-slayer-manga-to-screen-preview-fanhub-video-1', 'Watch this Manga Preview feature selected for Manga. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(20, 1, 4, 'Jujutsu Kaisen — Culling Game Story Preview — FanHub Video 2', 'jujutsu-kaisen-culling-game-story-preview-fanhub-video-2', 'Watch this Manga Preview feature selected for Manga. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(21, 1, 4, 'Vinland Saga — Manga Story Arc Preview — FanHub Video 3', 'vinland-saga-manga-story-arc-preview-fanhub-video-3', 'Watch this Manga Preview feature selected for Manga. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(22, 1, 4, 'Frieren — Manga World Preview — FanHub Video 4', 'frieren-manga-world-preview-fanhub-video-4', 'Watch this Manga Preview feature selected for Manga. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(23, 1, 4, 'New Saga — Manga Fantasy Adaptation Preview — FanHub Video 5', 'new-saga-manga-fantasy-adaptation-preview-fanhub-video-5', 'Watch this Manga Preview feature selected for Manga. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(24, 1, 3, 'Avengers: Doomsday — Official Teaser — FanHub Video 1', 'avengers-doomsday-official-teaser-fanhub-video-1', 'Watch this Fantasy & Action feature selected for Movies. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/399Ez7WHK5s/hqdefault.jpg', 'https://www.youtube.com/watch?v=399Ez7WHK5s', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(25, 1, 3, 'Avengers: Doomsday — First Look — FanHub Video 2', 'avengers-doomsday-first-look-fanhub-video-2', 'Watch this Fantasy & Action feature selected for Movies. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/UiMg566PREA/hqdefault.jpg', 'https://www.youtube.com/watch?v=UiMg566PREA', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(26, 1, 3, 'Demon Slayer — Infinity Castle Film Preview — FanHub Video 3', 'demon-slayer-infinity-castle-film-preview-fanhub-video-3', 'Watch this Fantasy & Action feature selected for Movies. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(27, 1, 3, 'Elden Ring — Shadow of the Erdtree Cinematic — FanHub Video 4', 'elden-ring-shadow-of-the-erdtree-cinematic-fanhub-video-4', 'Watch this Fantasy & Action feature selected for Movies. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(28, 1, 3, 'Black Myth: Wukong — Cinematic Trailer — FanHub Video 5', 'black-myth-wukong-cinematic-trailer-fanhub-video-5', 'Watch this Fantasy & Action feature selected for Movies. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(29, 1, 2, 'Frieren — Beyond Journey’s End Series Preview — FanHub Video 1', 'frieren-beyond-journeys-end-series-preview-fanhub-video-1', 'Watch this Drama & Fantasy feature selected for TV Series. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(30, 1, 2, 'Vinland Saga — Season Two Series Trailer — FanHub Video 2', 'vinland-saga-season-two-series-trailer-fanhub-video-2', 'Watch this Drama & Fantasy feature selected for TV Series. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(31, 1, 2, 'New Saga — Fantasy Series Trailer — FanHub Video 3', 'new-saga-fantasy-series-trailer-fanhub-video-3', 'Watch this Drama & Fantasy feature selected for TV Series. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(32, 1, 2, 'Jujutsu Kaisen — Season Three Preview — FanHub Video 4', 'jujutsu-kaisen-season-three-preview-fanhub-video-4', 'Watch this Drama & Fantasy feature selected for TV Series. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(33, 1, 2, 'Demon Slayer — Infinity Castle Series Preview — FanHub Video 5', 'demon-slayer-infinity-castle-series-preview-fanhub-video-5', 'Watch this Drama & Fantasy feature selected for TV Series. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(34, 1, 6, 'Elden Ring — Shadow of the Erdtree Gameplay — FanHub Video 1', 'elden-ring-shadow-of-the-erdtree-gameplay-fanhub-video-1', 'Watch this Gaming feature selected for Gaming. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(35, 1, 6, 'Black Myth: Wukong — First Gameplay — FanHub Video 2', 'black-myth-wukong-first-gameplay-fanhub-video-2', 'Watch this Gaming feature selected for Gaming. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(36, 1, 6, 'Civilization VII — Gameplay Overview — FanHub Video 3', 'civilization-vii-gameplay-overview-fanhub-video-3', 'Watch this Gaming feature selected for Gaming. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/kK_JrrP9m2U/hqdefault.jpg', 'https://www.youtube.com/watch?v=kK_JrrP9m2U', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(37, 1, 6, 'League of Legends Worlds — Championship Highlights — FanHub Video 4', 'league-of-legends-worlds-championship-highlights-fanhub-video-4', 'Watch this Gaming feature selected for Gaming. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg', 'https://www.youtube.com/watch?v=rZHrffKAc6k', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(38, 1, 6, 'Elden Ring — Shadow Realm Gameplay Showcase — FanHub Video 5', 'elden-ring-shadow-realm-gameplay-showcase-fanhub-video-5', 'Watch this Gaming feature selected for Gaming. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(39, 1, 7, 'Demon Slayer — Character Costume Showcase — FanHub Video 1', 'demon-slayer-character-costume-showcase-fanhub-video-1', 'Watch this Cosplay Showcase feature selected for Cosplay. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(40, 1, 7, 'Jujutsu Kaisen — Character Design Showcase — FanHub Video 2', 'jujutsu-kaisen-character-design-showcase-fanhub-video-2', 'Watch this Cosplay Showcase feature selected for Cosplay. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(41, 1, 7, 'Vinland Saga — Costume and Armor Showcase — FanHub Video 3', 'vinland-saga-costume-and-armor-showcase-fanhub-video-3', 'Watch this Cosplay Showcase feature selected for Cosplay. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(42, 1, 7, 'Frieren — Fantasy Character Showcase — FanHub Video 4', 'frieren-fantasy-character-showcase-fanhub-video-4', 'Watch this Cosplay Showcase feature selected for Cosplay. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(43, 1, 7, 'New Saga — Fantasy Costume Showcase — FanHub Video 5', 'new-saga-fantasy-costume-showcase-fanhub-video-5', 'Watch this Cosplay Showcase feature selected for Cosplay. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(44, 1, 8, 'League of Legends Worlds — Grand Final Highlights — FanHub Video 1', 'league-of-legends-worlds-grand-final-highlights-fanhub-video-1', 'Watch this Fandom Events feature selected for Events. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg', 'https://www.youtube.com/watch?v=rZHrffKAc6k', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(45, 1, 8, 'Marvel Comics — Ultimate Endgame Launch Feature — FanHub Video 2', 'marvel-comics-ultimate-endgame-launch-feature-fanhub-video-2', 'Watch this Fandom Events feature selected for Events. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/j1YHKBraABA/hqdefault.jpg', 'https://www.youtube.com/watch?v=j1YHKBraABA', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(46, 1, 8, 'The Ultimates #1 — Comic Launch Feature — FanHub Video 3', 'the-ultimates-1-comic-launch-feature-fanhub-video-3', 'Watch this Fandom Events feature selected for Events. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/jXvLMDSk8LY/hqdefault.jpg', 'https://www.youtube.com/watch?v=jXvLMDSk8LY', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(47, 1, 8, 'Demon Slayer — Infinity Castle Premiere Feature — FanHub Video 4', 'demon-slayer-infinity-castle-premiere-feature-fanhub-video-4', 'Watch this Fandom Events feature selected for Events. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(48, 1, 8, 'Black Myth: Wukong — Global Launch Feature — FanHub Video 5', 'black-myth-wukong-global-launch-feature-fanhub-video-5', 'Watch this Fandom Events feature selected for Events. The thumbnail is pulled from the same video so the preview and player stay in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-28 23:52:11', '2026-09-28 23:55:37', '2026-09-28 23:55:37', NULL),
(49, 1, 1, 'Anime Spotlight: Demon Slayer — Infinity Castle Preview', 'anime-spotlight-demon-slayer-infinity-castle-preview', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(50, 1, 1, 'Anime Spotlight: Jujutsu Kaisen — Culling Game Trailer', 'anime-spotlight-jujutsu-kaisen-culling-game-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(51, 1, 1, 'Anime Spotlight: Vinland Saga — Season Two Trailer', 'anime-spotlight-vinland-saga-season-two-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(52, 1, 1, 'Anime Spotlight: Frieren — Beyond Journey’s End Preview', 'anime-spotlight-frieren-beyond-journeys-end-preview', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(53, 1, 1, 'Anime Spotlight: New Saga — Official Anime Trailer', 'anime-spotlight-new-saga-official-anime-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(54, 1, 5, 'Comics Spotlight: Marvel Ultimate Endgame — Comic Event Trailer', 'comics-spotlight-marvel-ultimate-endgame-comic-event-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/j1YHKBraABA/hqdefault.jpg', 'https://www.youtube.com/watch?v=j1YHKBraABA', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(55, 1, 5, 'Comics Spotlight: The Ultimates #1 — Marvel Comics Trailer', 'comics-spotlight-the-ultimates-1-marvel-comics-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 1, 'https://img.youtube.com/vi/jXvLMDSk8LY/hqdefault.jpg', 'https://www.youtube.com/watch?v=jXvLMDSk8LY', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(56, 1, 5, 'Comics Spotlight: Marvel Comics — New Stories Trailer Reel', 'comics-spotlight-marvel-comics-new-stories-trailer-reel', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/78N6JyT4nM8/hqdefault.jpg', 'https://www.youtube.com/watch?v=78N6JyT4nM8', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(57, 1, 5, 'Comics Spotlight: Avengers: Doomsday — Official Teaser', 'comics-spotlight-avengers-doomsday-official-teaser', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 1, 'https://img.youtube.com/vi/399Ez7WHK5s/hqdefault.jpg', 'https://www.youtube.com/watch?v=399Ez7WHK5s', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(58, 1, 5, 'Comics Spotlight: Avengers: Doomsday — First Look', 'comics-spotlight-avengers-doomsday-first-look', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/UiMg566PREA/hqdefault.jpg', 'https://www.youtube.com/watch?v=UiMg566PREA', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(59, 1, 4, 'Manga Spotlight: Demon Slayer — Manga to Screen Preview', 'manga-spotlight-demon-slayer-manga-to-screen-preview', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(60, 1, 4, 'Manga Spotlight: Jujutsu Kaisen — Culling Game Story Preview', 'manga-spotlight-jujutsu-kaisen-culling-game-story-preview', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(61, 1, 4, 'Manga Spotlight: Vinland Saga — Manga Story Arc Preview', 'manga-spotlight-vinland-saga-manga-story-arc-preview', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(62, 1, 4, 'Manga Spotlight: Frieren — Manga World Preview', 'manga-spotlight-frieren-manga-world-preview', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(63, 1, 4, 'Manga Spotlight: New Saga — Manga Fantasy Adaptation Preview', 'manga-spotlight-new-saga-manga-fantasy-adaptation-preview', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(64, 1, 3, 'Movies Spotlight: Avengers: Doomsday — Official Teaser', 'movies-spotlight-avengers-doomsday-official-teaser', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/399Ez7WHK5s/hqdefault.jpg', 'https://www.youtube.com/watch?v=399Ez7WHK5s', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(65, 1, 3, 'Movies Spotlight: Avengers: Doomsday — First Look', 'movies-spotlight-avengers-doomsday-first-look', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/UiMg566PREA/hqdefault.jpg', 'https://www.youtube.com/watch?v=UiMg566PREA', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(66, 1, 3, 'Movies Spotlight: Demon Slayer — Infinity Castle Film Preview', 'movies-spotlight-demon-slayer-infinity-castle-film-preview', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(67, 1, 3, 'Movies Spotlight: Elden Ring — Shadow of the Erdtree Cinematic', 'movies-spotlight-elden-ring-shadow-of-the-erdtree-cinematic', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(68, 1, 3, 'Movies Spotlight: Black Myth: Wukong — Cinematic Trailer', 'movies-spotlight-black-myth-wukong-cinematic-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(69, 1, 2, 'TV Series Spotlight: Frieren — Beyond Journey’s End Series Preview', 'tv-series-spotlight-frieren-beyond-journeys-end-series-preview', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(70, 1, 2, 'TV Series Spotlight: Vinland Saga — Season Two Series Trailer', 'tv-series-spotlight-vinland-saga-season-two-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(71, 1, 2, 'TV Series Spotlight: New Saga — Fantasy Series Trailer', 'tv-series-spotlight-new-saga-fantasy-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(72, 1, 2, 'TV Series Spotlight: Jujutsu Kaisen — Season Three Preview', 'tv-series-spotlight-jujutsu-kaisen-season-three-preview', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(73, 1, 2, 'TV Series Spotlight: Demon Slayer — Infinity Castle Series Preview', 'tv-series-spotlight-demon-slayer-infinity-castle-series-preview', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(74, 1, 6, 'Gaming Spotlight: Elden Ring — Shadow of the Erdtree Gameplay', 'gaming-spotlight-elden-ring-shadow-of-the-erdtree-gameplay', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(75, 1, 6, 'Gaming Spotlight: Black Myth: Wukong — First Gameplay', 'gaming-spotlight-black-myth-wukong-first-gameplay', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(76, 1, 6, 'Gaming Spotlight: Civilization VII — Gameplay Overview', 'gaming-spotlight-civilization-vii-gameplay-overview', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/kK_JrrP9m2U/hqdefault.jpg', 'https://www.youtube.com/watch?v=kK_JrrP9m2U', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(77, 1, 6, 'Gaming Spotlight: League of Legends Worlds — Championship Highlights', 'gaming-spotlight-league-of-legends-worlds-championship-highlights', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg', 'https://www.youtube.com/watch?v=rZHrffKAc6k', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(78, 1, 6, 'Gaming Spotlight: Elden Ring — Shadow Realm Gameplay Showcase', 'gaming-spotlight-elden-ring-shadow-realm-gameplay-showcase', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(79, 1, 7, 'Cosplay Spotlight: Demon Slayer — Character Costume Showcase', 'cosplay-spotlight-demon-slayer-character-costume-showcase', 'A curated Cosplay Showcase feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(80, 1, 7, 'Cosplay Spotlight: Jujutsu Kaisen — Character Design Showcase', 'cosplay-spotlight-jujutsu-kaisen-character-design-showcase', 'A curated Cosplay Showcase feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(81, 1, 7, 'Cosplay Spotlight: Vinland Saga — Costume and Armor Showcase', 'cosplay-spotlight-vinland-saga-costume-and-armor-showcase', 'A curated Cosplay Showcase feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(82, 1, 7, 'Cosplay Spotlight: Frieren — Fantasy Character Showcase', 'cosplay-spotlight-frieren-fantasy-character-showcase', 'A curated Cosplay Showcase feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(83, 1, 7, 'Cosplay Spotlight: New Saga — Fantasy Costume Showcase', 'cosplay-spotlight-new-saga-fantasy-costume-showcase', 'A curated Cosplay Showcase feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Cosplay Showcase', 2026, 'other', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(84, 1, 8, 'Events Spotlight: League of Legends Worlds — Grand Final Highlights', 'events-spotlight-league-of-legends-worlds-grand-final-highlights', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg', 'https://www.youtube.com/watch?v=rZHrffKAc6k', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(85, 1, 8, 'Events Spotlight: Marvel Comics — Ultimate Endgame Launch Feature', 'events-spotlight-marvel-comics-ultimate-endgame-launch-feature', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/j1YHKBraABA/hqdefault.jpg', 'https://www.youtube.com/watch?v=j1YHKBraABA', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(86, 1, 8, 'Events Spotlight: The Ultimates #1 — Comic Launch Feature', 'events-spotlight-the-ultimates-1-comic-launch-feature', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/jXvLMDSk8LY/hqdefault.jpg', 'https://www.youtube.com/watch?v=jXvLMDSk8LY', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(87, 1, 8, 'Events Spotlight: Demon Slayer — Infinity Castle Premiere Feature', 'events-spotlight-demon-slayer-infinity-castle-premiere-feature', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(88, 1, 8, 'Events Spotlight: Black Myth: Wukong — Global Launch Feature', 'events-spotlight-black-myth-wukong-global-launch-feature', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-28 23:53:33', '2026-09-29 00:16:47', '2026-09-29 00:16:47', NULL),
(89, 1, 1, 'New Saga — Official Anime Trailer', 'new-saga-official-anime-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-29 00:17:03', '2026-09-29 00:36:58', NULL, NULL),
(90, 1, 5, 'Marvel Ultimate Endgame — Comic Event Trailer', 'marvel-ultimate-endgame-comic-event-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/j1YHKBraABA/hqdefault.jpg', 'https://www.youtube.com/watch?v=j1YHKBraABA', '2026-09-29 00:17:03', '2026-09-29 00:36:58', NULL, NULL),
(91, 1, 5, 'The Ultimates #1 — Marvel Comics Trailer', 'the-ultimates-1-marvel-comics-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/jXvLMDSk8LY/hqdefault.jpg', 'https://www.youtube.com/watch?v=jXvLMDSk8LY', '2026-09-29 00:17:03', '2026-09-29 00:36:58', NULL, NULL),
(92, 1, 5, 'Comics Spotlight: Marvel Comics — New Stories Trailer Reel', 'comics-spotlight-marvel-comics-new-stories-trailer-reel-1', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/78N6JyT4nM8/hqdefault.jpg', 'https://www.youtube.com/watch?v=78N6JyT4nM8', '2026-09-29 00:17:03', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL),
(93, 1, 5, 'Comics Spotlight: INCOMING! — Official Marvel Comics Trailer', 'comics-spotlight-incoming-official-marvel-comics-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/wFXwFm-Nk8Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=wFXwFm-Nk8Q', '2026-09-29 00:17:03', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL),
(94, 1, 5, 'Comics Spotlight: DC Elseworlds — Comic Trailer', 'comics-spotlight-dc-elseworlds-comic-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/w96tswk2YrY/hqdefault.jpg', 'https://www.youtube.com/watch?v=w96tswk2YrY', '2026-09-29 00:17:03', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL),
(95, 1, 4, 'Manga Spotlight: Demon Slayer — Manga to Screen Preview', 'manga-spotlight-demon-slayer-manga-to-screen-preview-1', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(96, 1, 4, 'Manga Spotlight: Jujutsu Kaisen — Culling Game Story Preview', 'manga-spotlight-jujutsu-kaisen-culling-game-story-preview-1', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(97, 1, 4, 'Manga Spotlight: Vinland Saga — Manga Story Arc Preview', 'manga-spotlight-vinland-saga-manga-story-arc-preview-1', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL);
INSERT INTO `contents` (`id`, `user_id`, `category_id`, `title`, `slug`, `body`, `status`, `genre`, `year`, `type`, `views_count`, `thumbnail`, `trailer_url`, `created_at`, `updated_at`, `deleted_at`, `release_date`) VALUES
(98, 1, 4, 'Manga Spotlight: Frieren — Manga World Preview', 'manga-spotlight-frieren-manga-world-preview-1', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(99, 1, 4, 'Manga Spotlight: New Saga — Manga Fantasy Adaptation Preview', 'manga-spotlight-new-saga-manga-fantasy-adaptation-preview-1', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(100, 1, 3, 'Avengers: Doomsday — Official Teaser', 'avengers-doomsday-official-teaser', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/399Ez7WHK5s/hqdefault.jpg', 'https://www.youtube.com/watch?v=399Ez7WHK5s', '2026-09-29 00:17:03', '2026-09-29 00:36:58', NULL, NULL),
(101, 1, 3, 'Avengers: Doomsday — First Look', 'avengers-doomsday-first-look', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/UiMg566PREA/hqdefault.jpg', 'https://www.youtube.com/watch?v=UiMg566PREA', '2026-09-29 00:17:03', '2026-09-29 00:36:58', NULL, NULL),
(102, 1, 3, 'Movies Spotlight: Demon Slayer — Infinity Castle Film Preview', 'movies-spotlight-demon-slayer-infinity-castle-film-preview-1', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(103, 1, 3, 'Movies Spotlight: Elden Ring — Shadow of the Erdtree Cinematic', 'movies-spotlight-elden-ring-shadow-of-the-erdtree-cinematic-1', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/JugxpebuS_E/hqdefault.jpg', 'https://www.youtube.com/watch?v=JugxpebuS_E', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(104, 1, 3, 'Movies Spotlight: Black Myth: Wukong — Cinematic Trailer', 'movies-spotlight-black-myth-wukong-cinematic-trailer-1', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(105, 1, 2, 'TV Series Spotlight: Frieren — Beyond Journey’s End Series Preview', 'tv-series-spotlight-frieren-beyond-journeys-end-series-preview-1', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/tR8YH0G67Rk/hqdefault.jpg', 'https://www.youtube.com/watch?v=tR8YH0G67Rk', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(106, 1, 2, 'TV Series Spotlight: Vinland Saga — Season Two Series Trailer', 'tv-series-spotlight-vinland-saga-season-two-series-trailer-1', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/Ph50sNkApVM/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ph50sNkApVM', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(107, 1, 2, 'TV Series Spotlight: New Saga — Fantasy Series Trailer', 'tv-series-spotlight-new-saga-fantasy-series-trailer-1', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/BaomnapVQ-0/hqdefault.jpg', 'https://www.youtube.com/watch?v=BaomnapVQ-0', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(108, 1, 2, 'TV Series Spotlight: Jujutsu Kaisen — Season Three Preview', 'tv-series-spotlight-jujutsu-kaisen-season-three-preview-1', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/MePL_vS-G9Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=MePL_vS-G9Q', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(109, 1, 2, 'TV Series Spotlight: Demon Slayer — Infinity Castle Series Preview', 'tv-series-spotlight-demon-slayer-infinity-castle-series-preview-1', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(110, 1, 6, 'Elden Ring Nightreign — Reveal Gameplay Trailer', 'elden-ring-nightreign-reveal-gameplay-trailer', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/Djtsw5k_DNc/hqdefault.jpg', 'https://www.youtube.com/watch?v=Djtsw5k_DNc', '2026-09-29 00:17:03', '2026-09-29 00:36:58', NULL, NULL),
(111, 1, 7, 'Odin Makes — War Machine Cosplay Helmet', 'odin-makes-war-machine-cosplay-helmet', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 1, 'https://img.youtube.com/vi/WuheOkYkzlw/hqdefault.jpg', 'https://www.youtube.com/watch?v=WuheOkYkzlw', '2026-09-29 00:17:03', '2026-09-29 03:05:31', NULL, NULL),
(112, 1, 7, 'Odin Makes — Gundam Cosplay Helmet Build', 'odin-makes-gundam-cosplay-helmet-build', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 1, 'https://img.youtube.com/vi/gO3yICj9gvY/hqdefault.jpg', 'https://www.youtube.com/watch?v=gO3yICj9gvY', '2026-09-29 00:17:03', '2026-09-29 03:05:31', NULL, NULL),
(113, 1, 7, 'Odin Makes — Full Gundam Cosplay Body Armor', 'odin-makes-full-gundam-cosplay-body-armor', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 0, 'https://img.youtube.com/vi/_6iaDJ9lFV8/hqdefault.jpg', 'https://www.youtube.com/watch?v=_6iaDJ9lFV8', '2026-09-29 00:17:03', '2026-09-29 03:05:31', NULL, NULL),
(114, 1, 7, 'Odin Makes — Full Gundam Suit Cosplay Build', 'odin-makes-full-gundam-suit-cosplay-build', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 0, 'https://img.youtube.com/vi/zXpVTeJNJZA/hqdefault.jpg', 'https://www.youtube.com/watch?v=zXpVTeJNJZA', '2026-09-29 00:17:03', '2026-09-29 03:05:31', NULL, NULL),
(115, 1, 7, 'Odin Makes — Lando Calrissian Cosplay Helmet', 'odin-makes-lando-calrissian-cosplay-helmet', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 0, 'https://img.youtube.com/vi/PzmPViZbrHQ/hqdefault.jpg', 'https://www.youtube.com/watch?v=PzmPViZbrHQ', '2026-09-29 00:17:03', '2026-09-29 03:05:31', NULL, NULL),
(116, 1, 8, 'Events Spotlight: League of Legends Worlds — Grand Final Highlights', 'events-spotlight-league-of-legends-worlds-grand-final-highlights-1', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/rZHrffKAc6k/hqdefault.jpg', 'https://www.youtube.com/watch?v=rZHrffKAc6k', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(117, 1, 8, 'Events Spotlight: Marvel Comics — Ultimate Endgame Launch Feature', 'events-spotlight-marvel-comics-ultimate-endgame-launch-feature-1', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/j1YHKBraABA/hqdefault.jpg', 'https://www.youtube.com/watch?v=j1YHKBraABA', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(118, 1, 8, 'Events Spotlight: The Ultimates #1 — Comic Launch Feature', 'events-spotlight-the-ultimates-1-comic-launch-feature-1', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/jXvLMDSk8LY/hqdefault.jpg', 'https://www.youtube.com/watch?v=jXvLMDSk8LY', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(119, 1, 8, 'Events Spotlight: Demon Slayer — Infinity Castle Premiere Feature', 'events-spotlight-demon-slayer-infinity-castle-premiere-feature-1', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/x7uLutVRBfI/hqdefault.jpg', 'https://www.youtube.com/watch?v=x7uLutVRBfI', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(120, 1, 8, 'Events Spotlight: Black Myth: Wukong — Global Launch Feature', 'events-spotlight-black-myth-wukong-global-launch-feature-1', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/7eS7schhJ8k/hqdefault.jpg', 'https://www.youtube.com/watch?v=7eS7schhJ8k', '2026-09-29 00:17:03', '2026-09-29 00:28:42', '2026-09-29 00:28:42', NULL),
(121, 1, 4, 'Jujutsu Kaisen Modulo — Manga Promotional Video', 'jujutsu-kaisen-modulo-manga-promotional-video', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 1, 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781974771455/jujutsu-kaisen-modulo-vol-1-9781974771455_hr.jpg', 'https://www.youtube.com/watch?v=plJgNCcUS_I', '2026-09-29 00:28:42', '2026-09-29 00:45:22', NULL, NULL),
(122, 1, 4, 'Manga Spotlight: Kagurabachi — Manga Promotional Video', 'manga-spotlight-kagurabachi-manga-promotional-video', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/trJ4Z0ubPVw/hqdefault.jpg', 'https://www.youtube.com/watch?v=trJ4Z0ubPVw', '2026-09-29 00:28:42', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL),
(123, 1, 4, 'Manga Spotlight: Jujutsu Kaisen Modulo — Final Volume Manga PV', 'manga-spotlight-jujutsu-kaisen-modulo-final-volume-manga-pv', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/ZZNG4uSuzns/hqdefault.jpg', 'https://www.youtube.com/watch?v=ZZNG4uSuzns', '2026-09-29 00:28:42', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL),
(124, 1, 4, 'Sword of the Demon Hunter: Kijin Gentosho — Manga Promotional Video', 'sword-of-the-demon-hunter-kijin-gentosho-manga-promotional-video', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 1, 'https://images3.penguinrandomhouse.com/smedia/9781685793333', 'https://www.youtube.com/watch?v=l-0oLbHzfWw', '2026-09-29 00:28:42', '2026-09-29 00:42:13', NULL, NULL),
(125, 1, 4, 'Manga Spotlight: Jujutsu Kaisen Modulo — Manga Promo Trailer', 'manga-spotlight-jujutsu-kaisen-modulo-manga-promo-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/Bd2Vb-B5lSo/hqdefault.jpg', 'https://www.youtube.com/watch?v=Bd2Vb-B5lSo', '2026-09-29 00:28:42', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL),
(126, 1, 3, 'Avengers: Endgame — Official Trailer', 'avengers-endgame-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/TcMBFSGVi1c/hqdefault.jpg', 'https://www.youtube.com/watch?v=TcMBFSGVi1c', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(127, 1, 3, 'Avengers: Infinity War — Official Trailer', 'avengers-infinity-war-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/6ZfuNTqbHE8/hqdefault.jpg', 'https://www.youtube.com/watch?v=6ZfuNTqbHE8', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(128, 1, 3, 'The Marvels — Official Trailer', 'the-marvels-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/1myF4CtgoLw/hqdefault.jpg', 'https://www.youtube.com/watch?v=1myF4CtgoLw', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(129, 1, 2, 'The Eternaut — Official Series Trailer', 'the-eternaut-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/TqT4fDQQqCc/hqdefault.jpg', 'https://www.youtube.com/watch?v=TqT4fDQQqCc', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(130, 1, 2, 'YOU — Official Series Trailer', 'you-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/v99ooSjCVhg/hqdefault.jpg', 'https://www.youtube.com/watch?v=v99ooSjCVhg', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(131, 1, 2, 'Superestar — Official Series Trailer', 'superestar-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 1, 'https://pics.filmaffinity.com/superestar-231903360-large.jpg', 'https://www.youtube.com/watch?v=h75xrfq-SBE', '2026-09-29 00:28:42', '2026-09-29 00:42:13', NULL, NULL),
(132, 1, 2, 'Olympo — Official Series Trailer', 'olympo-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 1, 'https://static.tvmaze.com/uploads/images/original_untouched/572/1431039.jpg', 'https://www.youtube.com/watch?v=bqDwi4i8NRo', '2026-09-29 00:28:42', '2026-09-29 00:42:13', NULL, NULL),
(133, 1, 2, 'Roosters — Official Series Trailer', 'roosters-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/eOREb9wDcvk/hqdefault.jpg', 'https://www.youtube.com/watch?v=eOREb9wDcvk', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(134, 1, 8, 'Netflix Tudum 2025 — Global Fan Event Highlights', 'netflix-tudum-2025-global-fan-event-highlights', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 1, 'https://img.youtube.com/vi/lcCx2oLavbc/hqdefault.jpg', 'https://www.youtube.com/watch?v=lcCx2oLavbc', '2026-09-29 00:28:42', '2026-09-29 01:10:03', NULL, NULL),
(135, 1, 8, 'Netflix Tudum 2025 — Official Event Trailer', 'netflix-tudum-2025-official-event-trailer', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/jdgVdMolHlo/hqdefault.jpg', 'https://www.youtube.com/watch?v=jdgVdMolHlo', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(136, 1, 8, 'Anime Expo — Zenless Zone Zero Stage Highlights', 'anime-expo-zenless-zone-zero-stage-highlights', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/p6Mq6Fx0uds/hqdefault.jpg', 'https://www.youtube.com/watch?v=p6Mq6Fx0uds', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(137, 1, 8, 'PAX West — Convention Highlights', 'pax-west-convention-highlights', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/msqLAWgNXWo/hqdefault.jpg', 'https://www.youtube.com/watch?v=msqLAWgNXWo', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(138, 1, 8, 'Jump Festa — Official Event Broadcast', 'jump-festa-official-event-broadcast', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/D0lHvj8pNxs/hqdefault.jpg', 'https://www.youtube.com/watch?v=D0lHvj8pNxs', '2026-09-29 00:28:42', '2026-09-29 00:36:58', NULL, NULL),
(139, 1, 5, 'Ultimate Spider-Man — Official Marvel Comics Trailer', 'ultimate-spider-man-official-marvel-comics-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/jKuLR5KCiY0/hqdefault.jpg', 'https://www.youtube.com/watch?v=jKuLR5KCiY0', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL, NULL),
(140, 1, 5, 'Ultimate Black Panther #1 — Official Marvel Comics Trailer', 'ultimate-black-panther-1-official-marvel-comics-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/3PJA_uXj_Zk/hqdefault.jpg', 'https://www.youtube.com/watch?v=3PJA_uXj_Zk', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL, NULL),
(141, 1, 5, 'Ultimate Invasion #1 — Official Marvel Comics Trailer', 'ultimate-invasion-1-official-marvel-comics-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/dagPKfcYHn4/hqdefault.jpg', 'https://www.youtube.com/watch?v=dagPKfcYHn4', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL, NULL),
(142, 1, 4, 'Assassin’s Creed Dynasty — Official Manga Trailer', 'assassins-creed-dynasty-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/tFSwg8Qv2sg/hqdefault.jpg', 'https://www.youtube.com/watch?v=tFSwg8Qv2sg', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL, NULL),
(143, 1, 4, 'Kingdom — Official Manga Trailer', 'kingdom-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/dfOe-VRQijY/hqdefault.jpg', 'https://www.youtube.com/watch?v=dfOe-VRQijY', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL, NULL),
(144, 1, 4, 'Hunter x Hunter — Official Manga Trailer', 'hunter-x-hunter-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/ZeXQulzYbqE/hqdefault.jpg', 'https://www.youtube.com/watch?v=ZeXQulzYbqE', '2026-09-29 00:36:58', '2026-09-29 00:36:58', NULL, NULL),
(145, 1, 1, 'Chainsaw Man: Reze Arc — Official Anime Film Trailer', 'chainsaw-man-reze-arc-official-anime-film-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/LjAgmxL5xkw/hqdefault.jpg', 'https://www.youtube.com/watch?v=LjAgmxL5xkw', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(146, 1, 1, 'My Hero Academia: Final Season — Official Trailer', 'my-hero-academia-final-season-official-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/fXbY97v2k4s/hqdefault.jpg', 'https://www.youtube.com/watch?v=fXbY97v2k4s', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(147, 1, 1, 'Attack on Titan: The Final Chapters — Special Trailer', 'attack-on-titan-the-final-chapters-special-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/M_OauHnAFc8/hqdefault.jpg', 'https://www.youtube.com/watch?v=M_OauHnAFc8', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(148, 1, 1, 'Crunchyroll Spring 2026 — Anime Season Preview', 'crunchyroll-spring-2026-anime-season-preview', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/7Wc6ugY3meg/hqdefault.jpg', 'https://www.youtube.com/watch?v=7Wc6ugY3meg', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(149, 1, 1, 'Gachiakuta — Official Trailer', 'gachiakuta-official-trailer', 'A curated Adventure feature for Anime fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Adventure', 2026, 'anime', 0, 'https://img.youtube.com/vi/3UkmWacjR7Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=3UkmWacjR7Q', '2026-09-29 02:11:16', '2026-09-29 02:18:26', NULL, NULL),
(150, 1, 5, 'Spider-Man: Across the Spider-Verse — Official Trailer', 'spider-man-across-the-spider-verse-official-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/shW9i6k8cB0/hqdefault.jpg', 'https://www.youtube.com/watch?v=shW9i6k8cB0', '2026-09-29 02:11:16', '2026-09-29 02:31:33', '2026-09-29 02:31:33', NULL),
(151, 1, 5, 'Blue Beetle — Official DC Trailer', 'blue-beetle-official-dc-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/vS3_72Gb-bI/hqdefault.jpg', 'https://www.youtube.com/watch?v=vS3_72Gb-bI', '2026-09-29 02:11:16', '2026-09-29 02:31:33', '2026-09-29 02:31:33', NULL),
(152, 1, 5, 'The Flash — Official DC Trailer', 'the-flash-official-dc-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/hebWYacbdvc/hqdefault.jpg', 'https://www.youtube.com/watch?v=hebWYacbdvc', '2026-09-29 02:11:16', '2026-09-29 02:31:33', '2026-09-29 02:31:33', NULL),
(153, 1, 5, 'Joker: Folie à Deux — Official Trailer', 'joker-folie-a-deux-official-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/xy8aJw1vYHo/hqdefault.jpg', 'https://www.youtube.com/watch?v=xy8aJw1vYHo', '2026-09-29 02:11:16', '2026-09-29 02:31:33', '2026-09-29 02:31:33', NULL),
(154, 1, 5, 'Justice League — Official Comic-Con Trailer', 'justice-league-official-comic-con-trailer', 'A curated Superhero feature for Comics fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Superhero', 2026, 'other', 0, 'https://img.youtube.com/vi/fIHH5-HVS9o/hqdefault.jpg', 'https://www.youtube.com/watch?v=fIHH5-HVS9o', '2026-09-29 02:11:16', '2026-09-29 02:31:33', '2026-09-29 02:31:33', NULL),
(155, 1, 4, 'Chainsaw Man, Vol. 12 — Official Manga Trailer', 'chainsaw-man-vol-12-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 1, 'https://img.youtube.com/vi/__F7YFMYxAY/hqdefault.jpg', 'https://www.youtube.com/watch?v=__F7YFMYxAY', '2026-09-29 02:11:16', '2026-09-29 04:39:33', NULL, NULL),
(156, 1, 4, 'Chainsaw Man, Vol. 1 — Official Manga Trailer', 'chainsaw-man-vol-1-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/tVG_sBhNcr0/hqdefault.jpg', 'https://www.youtube.com/watch?v=tVG_sBhNcr0', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(157, 1, 4, 'Spy x Family, Vol. 1 — Official Manga Trailer', 'spy-x-family-vol-1-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 0, 'https://img.youtube.com/vi/g1F16L66Y_Q/hqdefault.jpg', 'https://www.youtube.com/watch?v=g1F16L66Y_Q', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(158, 1, 4, 'Dandadan, Vol. 1 — Official Manga Trailer', 'dandadan-vol-1-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 1, 'https://img.youtube.com/vi/tRJIGlh1ILY/hqdefault.jpg', 'https://www.youtube.com/watch?v=tRJIGlh1ILY', '2026-09-29 02:11:16', '2026-09-29 02:55:52', NULL, NULL),
(159, 1, 4, 'Death Note Short Stories — Official Manga Trailer', 'death-note-short-stories-official-manga-trailer', 'A curated Manga Preview feature for Manga fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Manga Preview', 2026, 'anime', 1, 'https://img.youtube.com/vi/Rax3IuHnF4M/hqdefault.jpg', 'https://www.youtube.com/watch?v=Rax3IuHnF4M', '2026-09-29 02:11:16', '2026-09-29 02:56:06', NULL, NULL),
(160, 1, 3, 'Spider-Man: No Way Home — Official Trailer', 'spider-man-no-way-home-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/JfVOs4VSpmA/hqdefault.jpg', 'https://www.youtube.com/watch?v=JfVOs4VSpmA', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(161, 1, 3, 'Dune: Part Two — Official Trailer', 'dune-part-two-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/Way9Dexny3w/hqdefault.jpg', 'https://www.youtube.com/watch?v=Way9Dexny3w', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(162, 1, 3, 'Barbie — Official Trailer', 'barbie-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/pBk4NYhWNMM/hqdefault.jpg', 'https://www.youtube.com/watch?v=pBk4NYhWNMM', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(163, 1, 3, 'Deadpool & Wolverine — Official Trailer', 'deadpool-wolverine-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/73_1biulkYk/hqdefault.jpg', 'https://www.youtube.com/watch?v=73_1biulkYk', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(164, 1, 3, 'The Batman — Official Trailer', 'the-batman-official-trailer', 'A curated Fantasy & Action feature for Movies fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fantasy & Action', 2026, 'movie', 0, 'https://img.youtube.com/vi/mqqft2x_Aa4/hqdefault.jpg', 'https://www.youtube.com/watch?v=mqqft2x_Aa4', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(165, 1, 2, 'Wednesday — Official Series Trailer', 'wednesday-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/Di310WS8zLk/hqdefault.jpg', 'https://www.youtube.com/watch?v=Di310WS8zLk', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(166, 1, 2, 'The Last of Us — Official Series Trailer', 'the-last-of-us-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/uLtkt8BonwM/hqdefault.jpg', 'https://www.youtube.com/watch?v=uLtkt8BonwM', '2026-09-29 02:11:16', '2026-09-29 02:31:33', NULL, NULL),
(167, 1, 2, 'House of the Dragon — Official Series Trailer', 'house-of-the-dragon-official-series-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/DotnJ7tTA34/hqdefault.jpg', 'https://www.youtube.com/watch?v=DotnJ7tTA34', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(168, 1, 2, 'Arcane: Season Two — Official Trailer', 'arcane-season-two-official-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/hsffPST-x1k/hqdefault.jpg', 'https://www.youtube.com/watch?v=hsffPST-x1k', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(169, 1, 2, 'Severance: Season Two — Official Trailer', 'severance-season-two-official-trailer', 'A curated Drama & Fantasy feature for TV Series fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Drama & Fantasy', 2026, 'series', 0, 'https://img.youtube.com/vi/_UXKlYvLGJY/hqdefault.jpg', 'https://www.youtube.com/watch?v=_UXKlYvLGJY', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(170, 1, 6, 'Grand Theft Auto VI — Official Trailer 2', 'grand-theft-auto-vi-official-trailer-2', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 1, 'https://img.youtube.com/vi/VQRLujxTm3c/hqdefault.jpg', 'https://www.youtube.com/watch?v=VQRLujxTm3c', '2026-09-29 02:11:16', '2026-09-29 02:58:55', NULL, NULL),
(171, 1, 6, 'The Legend of Zelda: Tears of the Kingdom — Official Trailer', 'the-legend-of-zelda-tears-of-the-kingdom-official-trailer', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/2SNF4M_v7wc/hqdefault.jpg', 'https://www.youtube.com/watch?v=2SNF4M_v7wc', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(172, 1, 6, 'Super Mario Bros. Wonder — Official Overview', 'super-mario-bros-wonder-official-overview', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/G0m_uNaSres/hqdefault.jpg', 'https://www.youtube.com/watch?v=G0m_uNaSres', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(173, 1, 6, 'Elden Ring — Official Launch Trailer', 'elden-ring-official-launch-trailer', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/AKXiKBnzpBQ/hqdefault.jpg', 'https://www.youtube.com/watch?v=AKXiKBnzpBQ', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(174, 1, 6, 'Cyberpunk 2077 — Official Cinematic Trailer', 'cyberpunk-2077-official-cinematic-trailer', 'A curated Gaming feature for Gaming fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Gaming', 2026, 'game', 0, 'https://img.youtube.com/vi/8X2kIfS6fb8/hqdefault.jpg', 'https://www.youtube.com/watch?v=8X2kIfS6fb8', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(175, 1, 7, 'Odin Makes — Mechagodzilla Cosplay Hands', 'odin-makes-mechagodzilla-cosplay-hands', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 1, 'https://img.youtube.com/vi/5f_o0Hih-0o/hqdefault.jpg', 'https://www.youtube.com/watch?v=5f_o0Hih-0o', '2026-09-29 02:11:16', '2026-09-29 03:07:41', NULL, NULL),
(176, 1, 7, 'Odin Makes — Infinity Gauntlet Cosplay Prop', 'odin-makes-infinity-gauntlet-cosplay-prop', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 0, 'https://img.youtube.com/vi/lwmzq81ezic/hqdefault.jpg', 'https://www.youtube.com/watch?v=lwmzq81ezic', '2026-09-29 02:11:16', '2026-09-29 03:05:31', NULL, NULL),
(177, 1, 7, 'Odin Makes — Thor Mjolnir Cosplay Prop', 'odin-makes-thor-mjolnir-cosplay-prop', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 0, 'https://img.youtube.com/vi/4JcNl1PeY0M/hqdefault.jpg', 'https://www.youtube.com/watch?v=4JcNl1PeY0M', '2026-09-29 02:11:16', '2026-09-29 03:05:31', NULL, NULL),
(178, 1, 7, 'Odin Makes — Black Panther Cosplay Mask', 'odin-makes-black-panther-cosplay-mask', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 1, 'https://img.youtube.com/vi/y3FK9TB1UM8/hqdefault.jpg', 'https://www.youtube.com/watch?v=y3FK9TB1UM8', '2026-09-29 02:11:16', '2026-09-29 03:05:31', NULL, NULL),
(179, 1, 7, 'Odin Makes — Mechagodzilla Cosplay Arms', 'odin-makes-mechagodzilla-cosplay-arms', 'A curated Male Cosplay Builds feature for Cosplay fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Male Cosplay Builds', 2026, 'other', 0, 'https://img.youtube.com/vi/Q-pZeePU9i0/hqdefault.jpg', 'https://www.youtube.com/watch?v=Q-pZeePU9i0', '2026-09-29 02:11:16', '2026-09-29 03:05:31', NULL, NULL),
(180, 1, 8, 'Gamescom Opening Night Live 2025 — Full Showcase', 'gamescom-opening-night-live-2025-full-showcase', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/HVC_dBNUZGc/hqdefault.jpg', 'https://www.youtube.com/watch?v=HVC_dBNUZGc', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(181, 1, 8, 'AnimeJapan Kickoff 2025 — Stage Preview', 'animejapan-kickoff-2025-stage-preview', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/fqTpYnPLLzg/hqdefault.jpg', 'https://www.youtube.com/watch?v=fqTpYnPLLzg', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(182, 1, 8, 'AnimeJapan 2025 — Bandai Namco Stage', 'animejapan-2025-bandai-namco-stage', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/Ff0wywnfG5o/hqdefault.jpg', 'https://www.youtube.com/watch?v=Ff0wywnfG5o', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(183, 1, 8, 'AnimeJapan 2025 — Isekai Channel Stage', 'animejapan-2025-isekai-channel-stage', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/aX_vzFv0Wm8/hqdefault.jpg', 'https://www.youtube.com/watch?v=aX_vzFv0Wm8', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL),
(184, 1, 8, 'AnimeJapan 2025 — Gunpla Special Stage', 'animejapan-2025-gunpla-special-stage', 'A curated Fandom Events feature for Events fans. Open the video to watch the full trailer or feature; its poster is generated from the exact same video so the artwork stays in sync.', 'published', 'Fandom Events', 2026, 'other', 0, 'https://img.youtube.com/vi/fkPJTWf55Zk/hqdefault.jpg', 'https://www.youtube.com/watch?v=fkPJTWf55Zk', '2026-09-29 02:11:16', '2026-09-29 02:11:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `content_notes`
--

CREATE TABLE `content_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `timestamp_seconds` int(10) UNSIGNED DEFAULT NULL,
  `is_spoiler` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_notes`
--

INSERT INTO `content_notes` (`id`, `user_id`, `content_id`, `note`, `created_at`, `updated_at`, `timestamp_seconds`, `is_spoiler`) VALUES
(1, 20, 5, 'good', '2026-09-28 21:06:31', '2026-09-28 21:06:31', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content_tag`
--

CREATE TABLE `content_tag` (
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_stats`
--

CREATE TABLE `daily_stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `metric` varchar(80) NOT NULL,
  `value` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `venue_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `ticket_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `category_id`, `content_id`, `title`, `slug`, `description`, `venue_name`, `address`, `city`, `country`, `latitude`, `longitude`, `start_datetime`, `end_datetime`, `cover_image`, `ticket_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 'Tokyo Anime Festival 2025', 'tokyo-anime-festival-2025', 'The largest anime convention in Asia, featuring exclusive premieres, cosplay contests, and guest panels.', 'Tokyo Big Sight', '3-11-1 Ariake, Koto City', 'Tokyo', 'Japan', 35.6298000, 139.7956000, '2026-10-26 10:00:00', '2026-10-28 20:00:00', 'catalog-artwork/event/1-tokyo-anime-festival-2025.svg', 'https://example.com/tickets/tokyo-anime-fest', '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(2, 1, NULL, NULL, 'Coachella Valley Music & Arts Festival', 'coachella-valley-music-arts-festival', 'Iconic outdoor music festival in the California desert. Three days of music, art, and culture.', 'Empire Polo Club', '81800 Avenue 51', 'Indio', 'United States', 33.6823000, -116.2380000, '2026-11-10 12:00:00', '2026-11-12 23:59:00', 'catalog-artwork/event/2-coachella-valley-music-arts-festival.svg', 'https://example.com/tickets/coachella', '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(3, 1, 6, NULL, 'EVO 2025 — Fighting Game Championship', 'evo-2025-fighting-game-championship', 'The world\'s premier fighting game tournament. Street Fighter, Tekken, Mortal Kombat and more.', 'Mandalay Bay Convention Center', '3950 S Las Vegas Blvd', 'Las Vegas', 'United States', 36.0916000, -115.1760000, '2026-11-25 09:00:00', '2026-11-27 22:00:00', 'catalog-artwork/event/3-evo-2025-fighting-game-championship.svg', 'https://example.com/tickets/evo-2025', '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(4, 1, NULL, NULL, 'London Film Festival — Opening Night', 'london-film-festival-opening-night', 'BFI London Film Festival opening gala screening with red carpet and Q&A.', 'Royal Festival Hall', 'Belvedere Rd, South Bank', 'London', 'United Kingdom', 51.5045000, -0.1160000, '2026-10-16 19:30:00', '2026-10-16 23:00:00', 'catalog-artwork/event/4-london-film-festival-opening-night.svg', 'https://example.com/tickets/lff', '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(5, 1, 6, NULL, 'Gamescom 2025', 'gamescom-2025', 'Europe\'s largest gaming trade show. Hands-on demos, world premieres, and cosplay.', 'Koelnmesse', 'Messeplatz 1', 'Cologne', 'Germany', 50.9463000, 6.9820000, '2026-12-25 09:00:00', '2026-12-29 18:00:00', 'catalog-artwork/event/5-gamescom-2025.svg', 'https://example.com/tickets/gamescom', '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(6, 1, NULL, NULL, 'Glastonbury Festival 2025', 'glastonbury-festival-2025', 'The world-famous performing arts festival on Worthy Farm, Somerset.', 'Worthy Farm', 'Pilton, Shepton Mallet', 'Somerset', 'United Kingdom', 51.1537000, -2.5897000, '2026-11-20 11:00:00', '2026-11-24 23:59:00', 'catalog-artwork/event/6-glastonbury-festival-2025.svg', NULL, '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(7, 1, 1, NULL, 'Anime Expo 2024 — Los Angeles', 'anime-expo-2024-los-angeles', 'North America\'s largest anime convention. Panels, screenings, and exclusive merchandise.', 'Los Angeles Convention Center', '1201 S Figueroa St', 'Los Angeles', 'United States', 34.0407000, -118.2698000, '2026-07-28 10:00:00', '2026-07-31 20:00:00', 'catalog-artwork/event/7-anime-expo-2024-los-angeles.svg', NULL, '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(8, 1, 6, NULL, 'The Game Awards 2024', 'the-game-awards-2024', 'Annual celebration of the best in video games, with world premiere announcements.', 'Peacock Theater', '1111 S Figueroa St', 'Los Angeles', 'United States', 34.0430000, -118.2673000, '2026-08-27 20:00:00', '2026-08-27 23:30:00', 'catalog-artwork/event/8-the-game-awards-2024.svg', NULL, '2026-09-26 18:34:49', '2026-09-28 09:58:12', NULL),
(10, 1, 6, NULL, 'FanHub Karachi Community Night', 'fanhub-karachi-community-night', 'A Karachi anime and gaming community meetup for fans, creators, and live entertainment.', 'Karachi Arts Council', 'M.R. Kiyani Road', 'Karachi', 'Pakistan', 24.8607000, 67.0011000, '2026-10-16 18:00:00', '2026-10-16 22:00:00', 'catalog-artwork/event/10-fanhub-karachi-community-night.svg', NULL, '2026-09-28 09:13:39', '2026-09-28 10:19:57', NULL),
(11, 1, 1, NULL, 'Dubai Fan Expo', 'dubai-fan-expo', 'A weekend celebrating anime, gaming, film, and fan culture.', 'Dubai World Trade Centre', 'Sheikh Zayed Road', 'Dubai', 'United Arab Emirates', 25.2285000, 55.2867000, '2026-11-07 10:00:00', '2026-11-08 20:00:00', 'catalog-artwork/event/11-dubai-fan-expo.svg', NULL, '2026-09-28 09:13:39', '2026-09-28 09:58:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_rsvps`
--

CREATE TABLE `event_rsvps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('going','interested') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`keywords`)),
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `keywords`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'How do I create an account?', 'Click \"Join Free\" on the homepage or visit /register. Fill in your name, email, and password to get started!', '[\"register\",\"sign up\",\"account\",\"join\",\"create account\"]', 1, 1, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(2, 'How do I reset my password?', 'Click \"Forgot your password?\" on the login page and enter your email. You\'ll receive a reset link within a few minutes.', '[\"password\",\"reset\",\"forgot\",\"lost password\",\"change password\"]', 1, 2, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(3, 'How do I edit my profile?', 'Go to Dashboard → click your name → Profile. You can update your display name, avatar, and bio from there.', '[\"profile\",\"edit\",\"avatar\",\"bio\",\"username\",\"settings\"]', 1, 3, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(4, 'How do I submit content?', 'Go to Dashboard → My Content → Create. You can add fan fiction, art, videos, and more. Make sure you\'re logged in first.', '[\"submit\",\"upload\",\"post\",\"add content\",\"create content\",\"share\"]', 1, 4, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(5, 'How do I bookmark content?', 'Click the bookmark icon on any content card or detail page. View all your bookmarks under Dashboard → Bookmarks.', '[\"bookmark\",\"save\",\"favourite\",\"favorite\",\"watchlist\"]', 1, 5, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(6, 'How do I rate content?', 'Open any content page and use the star rating widget. You must be logged in to leave a rating.', '[\"rate\",\"rating\",\"stars\",\"review\",\"score\"]', 1, 6, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(7, 'What content categories are available?', 'FanHub+ supports Anime, Manga, Movies, TV Shows, Games, Books, and more. Browse all categories on the Explore page.', '[\"categories\",\"types\",\"genre\",\"anime\",\"manga\",\"movies\",\"games\"]', 1, 7, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(8, 'How do I report inappropriate content?', 'Use the \"Report\" option on any content page, or submit a report via the Feedback form with category \"Report\".', '[\"report\",\"inappropriate\",\"abuse\",\"flag\",\"offensive\",\"spam\"]', 1, 8, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(9, 'How do I track my feedback submission?', 'Visit /feedback/status and enter your reference code (shown after submission) or your email address to see the current status.', '[\"track\",\"feedback\",\"status\",\"reference\",\"check feedback\"]', 1, 9, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(10, 'How do I contact support?', 'Use the Feedback form at /feedback to reach our team. Select \"General\" for general enquiries or \"Bug\" to report an issue.', '[\"contact\",\"support\",\"help\",\"email\",\"admin\"]', 1, 10, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(11, 'How do I RSVP to an event?', 'Open any event page and click \"Going\" or \"Interested\". You must be logged in. You can change your RSVP at any time from the same page.', '[\"rsvp\",\"event\",\"attend\",\"going\",\"interested\",\"register event\"]', 1, 11, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(12, 'How do I add an event to my calendar?', 'On any event detail page, click \"Add to Calendar\" to download an .ics file compatible with Google Calendar, Outlook, and Apple Calendar.', '[\"calendar\",\"ics\",\"download\",\"google calendar\",\"export event\"]', 1, 12, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(13, 'What is My List and how do I use it?', 'My List is your personal content queue. Click the \"+\" icon on any content card to add it. Access your list from your fandom profile page.', '[\"my list\",\"watchlist\",\"list\",\"add to list\",\"saved content\",\"queue\"]', 1, 13, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(14, 'What are fandom profiles and how do I create one?', 'Fandom profiles let you keep separate watch histories and lists for different fandoms. Go to /profiles to create or switch between profiles.', '[\"fandom profile\",\"profile\",\"create profile\",\"switch profile\",\"multiple profiles\"]', 1, 14, '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(15, 'How do I browse merchandise?', 'Visit /merchandise to browse all available fan merchandise. You can filter by tag or search by name. Click any item for full details.', '[\"merchandise\",\"merch\",\"shop\",\"buy\",\"store\",\"products\"]', 1, 15, '2026-09-26 18:34:49', '2026-09-26 18:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `reference_code` varchar(12) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'general',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `related_type` varchar(255) DEFAULT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `admin_reaction` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchandise`
--

CREATE TABLE `merchandise` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `item_type` varchar(24) NOT NULL DEFAULT 'physical',
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `views_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `external_purchase_link` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(32) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchandise`
--

INSERT INTO `merchandise` (`id`, `user_id`, `category_id`, `content_id`, `title`, `slug`, `description`, `item_type`, `price`, `currency`, `image`, `status`, `views_count`, `external_purchase_link`, `whatsapp_number`, `instagram_url`, `facebook_url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 'Akira Kaneda Jacket — Replica', 'akira-kaneda-jacket-replica', 'High-quality replica of the iconic red jacket from Akira. Embroidered patches, genuine leather feel.', 'physical', 149.99, 'USD', 'catalog-artwork/merchandise/1-akira-kaneda-jacket-replica.svg', 'active', 1243, NULL, NULL, NULL, NULL, '2026-09-26 18:34:49', '2026-09-28 22:25:54', '2026-09-28 22:25:54'),
(2, 1, 6, NULL, 'Cyberpunk 2077 Night City Poster Set', 'cyberpunk-2077-night-city-poster-set', 'Set of 4 high-resolution art prints from Night City. 18×24 inches, matte finish.', 'physical', 39.99, 'USD', 'catalog-artwork/merchandise/2-cyberpunk-2077-night-city-poster-set.svg', 'active', 871, NULL, NULL, NULL, NULL, '2026-09-26 18:34:49', '2026-09-28 22:26:00', NULL),
(3, 1, 6, NULL, 'Elden Ring Tarnished Enamel Pin Set', 'elden-ring-tarnished-enamel-pin-set', 'Set of 6 hard enamel pins featuring iconic symbols from the Lands Between.', 'physical', 24.99, 'USD', 'catalog-artwork/merchandise/3-elden-ring-tarnished-enamel-pin-set.svg', 'active', 432, NULL, NULL, NULL, NULL, '2026-09-26 18:34:49', '2026-09-28 22:15:55', NULL),
(4, 1, 1, NULL, 'Ghost in the Shell Section 9 Badge', 'ghost-in-the-shell-section-9-badge', 'Official-style Section 9 badge prop replica. Metal construction with display case.', 'physical', 59.00, 'USD', 'catalog-artwork/merchandise/4-ghost-in-the-shell-section-9-badge.svg', 'active', 782, NULL, NULL, NULL, NULL, '2026-09-26 18:34:49', '2026-09-28 22:27:43', NULL),
(5, 1, 6, NULL, 'The Last of Us Part II Ellie Tattoo Sleeve', 'the-last-of-us-part-ii-ellie-tattoo-sleeve', 'Temporary tattoo sleeve replicating Ellie\'s iconic arm tattoo. Waterproof, lasts 7 days.', 'physical', 12.99, 'USD', 'catalog-artwork/merchandise/5-the-last-of-us-part-ii-ellie-tattoo-sleeve.svg', 'active', 211, NULL, NULL, NULL, NULL, '2026-09-26 18:34:49', '2026-09-28 21:59:05', NULL),
(6, 20, 2, NULL, 'SHAYAN', 'shayan', NULL, 'digital_image', 50.00, 'PKR', 'merchandise/y5aVdVgt9MjlzPjYd9gtRgpfiFQ8aGkEusnobukM.jpg', 'active', 5, NULL, '+923492467804', NULL, NULL, '2026-09-28 21:53:20', '2026-09-28 21:59:00', '2026-09-28 21:59:00'),
(7, 20, 1, NULL, 'WASIQ', 'wasiq', NULL, 'digital_image', 10.00, 'USD', 'merchandise/BfNuaqZEEDmBnjWzuoeid4ulypxDf2Q5csRqJI7S.jpg', 'active', 1, NULL, '+923352697296', NULL, NULL, '2026-09-29 03:05:07', '2026-09-29 03:10:04', NULL),
(8, 20, 5, NULL, 'Fasihuddin', 'fasihuddin', NULL, 'digital_image', 2.00, 'USD', 'merchandise/hKknLJyH9ipY6NetD3us7ClGDMIEPRumMCBYfcH7.jpg', 'active', 1, NULL, '+923352697296', NULL, NULL, '2026-09-29 03:06:04', '2026-09-29 03:10:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_images`
--

CREATE TABLE `merchandise_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchandise_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_tags`
--

CREATE TABLE `merchandise_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchandise_tags`
--

INSERT INTO `merchandise_tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Limited Edition', 'limited-edition', '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(2, 'Pre-Order', 'pre-order', '2026-09-26 18:34:49', '2026-09-26 18:34:49'),
(3, 'Collectible', 'collectible', '2026-09-26 18:34:49', '2026-09-26 18:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_tag_pivot`
--

CREATE TABLE `merchandise_tag_pivot` (
  `merchandise_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchandise_tag_pivot`
--

INSERT INTO `merchandise_tag_pivot` (`merchandise_id`, `tag_id`) VALUES
(1, 1),
(1, 3),
(3, 2),
(4, 1),
(8, 1),
(8, 2),
(8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000010_create_categories_table', 1),
(5, '2024_01_01_000020_create_contents_table', 1),
(6, '2026_09_24_194700_add_phase2_fields_to_contents_table', 1),
(7, '2026_09_24_200044_create_bookmarks_table', 1),
(8, '2026_09_24_200044_create_content_notes_table', 1),
(9, '2026_09_24_200045_create_characters_table', 1),
(10, '2026_09_24_200045_create_ratings_table', 1),
(11, '2026_09_24_200046_create_articles_table', 1),
(12, '2026_09_24_200047_create_timeline_events_table', 1),
(13, '2026_09_25_000001_create_merchandise_tags_table', 1),
(14, '2026_09_25_000002_create_merchandise_table', 1),
(15, '2026_09_25_000003_create_merchandise_images_table', 1),
(16, '2026_09_25_000004_create_merchandise_tag_pivot_table', 1),
(17, '2026_09_25_000005_create_events_table', 1),
(18, '2026_09_25_112033_change_keywords_to_json_in_faqs_table', 1),
(19, '2026_09_26_000001_add_banned_at_to_users_table', 1),
(20, '2026_09_26_000002_create_feedback_table', 1),
(21, '2026_09_26_000003_create_faqs_table', 1),
(22, '2026_09_26_000004_add_soft_deletes_to_users_table', 1),
(23, '2026_09_27_000001_add_reference_code_to_feedback_table', 1),
(24, '2026_09_27_000002_create_chat_tables', 1),
(25, '2026_09_28_000001_create_profiles_table', 1),
(26, '2026_09_28_000002_add_trailer_url_to_contents_table', 1),
(27, '2026_09_28_000003_create_watch_progress_table', 1),
(28, '2026_09_28_000004_create_my_list_table', 1),
(29, '2026_09_28_000005_add_profile_id_to_ratings_table', 1),
(30, '2026_09_29_000001_create_event_rsvps_table', 1),
(31, '2026_09_30_000001_create_analytics_events_table', 1),
(32, '2026_10_01_000001_expand_faq_question_length', 1),
(33, '2026_10_02_000001_add_role_to_users_table', 1),
(34, '2026_10_02_000002_create_site_settings_table', 1),
(35, '2026_10_02_000003_create_admin_activity_logs_table', 1),
(36, '2026_10_03_000001_add_discovery_fields_to_categories_table', 1),
(37, '2026_10_03_000002_create_resources_table', 1),
(38, '2026_10_03_000003_create_daily_stats_table', 1),
(39, '2026_10_03_000004_add_rating_review_and_article_read_time', 1),
(40, '2026_10_03_000005_create_tags_tables', 1),
(41, '2026_10_03_000006_expand_profiles_table', 1),
(42, '2026_10_03_000007_expand_content_notes_table', 1),
(43, '2026_10_03_000008_expand_chat_sessions_and_messages', 1),
(44, '2026_10_04_000001_add_password_changed_at_to_users_table', 2),
(45, '2026_10_04_000002_normalize_legacy_timestamps_to_pakistan_time', 3),
(46, '2026_10_05_000001_add_release_date_to_contents_table', 4),
(47, '2026_10_05_000002_add_category_id_to_articles_table', 4),
(48, '2026_10_06_000001_add_country_to_events_table', 4),
(49, '2026_10_07_000001_add_moderation_fields_to_ratings_table', 5),
(50, '2026_10_07_000002_add_admin_reply_and_reaction_to_ratings', 6),
(51, '2026_10_07_000003_add_admin_reaction_to_feedback_table', 7),
(52, '2026_10_08_000001_add_seller_channels_to_merchandise_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `my_list`
--

CREATE TABLE `my_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_kid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `fandom_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fandom_tags`)),
  `is_kids` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review` text DEFAULT NULL,
  `review_status` varchar(20) DEFAULT NULL,
  `review_moderation_note` text DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `admin_reaction` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `profile_id`, `content_id`, `rating`, `created_at`, `updated_at`, `review`, `review_status`, `review_moderation_note`, `admin_reply`, `admin_reaction`) VALUES
(1, 20, NULL, 5, 1, '2026-09-28 21:06:14', '2026-09-28 21:06:14', 'good', 'approved', NULL, NULL, NULL),
(2, 20, NULL, 2, 1, '2026-09-28 21:17:52', '2026-09-28 21:24:50', 'exce', 'approved', NULL, 'thanks', 'like');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('wallpaper','fanart','fanfic','subtitle','theme','audio') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size_kb` int(10) UNSIGNED NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `download_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `license` varchar(100) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `moderation_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2zek18C98uREER9RocL72biGQeqA8zGS4t0kVtOH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaU1QdDNSOWs3Z3BVZUNRRlVjVWVaeDFQbkxrWUVTaDlhYmc0VXY2WSI7czoxNjoidmlld2VkX2NvbnRlbnRfNSI7YjoxO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY29udGVudHMvNSI7czo1OiJyb3V0ZSI7czoxMzoiY29udGVudHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790629514),
('33lOpHpgeTaIk1CLExemDsYRrAQ2FMGZJfJZ6fMW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlpYY0xMYlg1d0tCNHBmN09NSXZTc3dNSGdYWDBrWXdMTVYxWDh0TCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1790657748),
('3HrBfxlSMRQfNSqF6roscgP9CQc4LInD3icDWoR8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2k4ckwyamhiTkw0eUt5d0xwaXVzTEQ5YjNjb3BBVGF3UEp4YzRSUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mZWVkYmFjayI7czo1OiJyb3V0ZSI7czoxNToiZmVlZGJhY2suY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790630170),
('4SmQ2Lqjwgssj8OMY6FEBDn6XYgZXvCH01xgnXeA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ1pEOEs5OXVSZDhERVVYbVhiQnBFcnAyeHZSV3pDcjFzODYzMHRYQyI7czoxNjoidmlld2VkX2NvbnRlbnRfNSI7YjoxO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY29udGVudHMvNSI7czo1OiJyb3V0ZSI7czoxMzoiY29udGVudHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790629520),
('bf01ZfEudlUeaxN5AvanBCrBYYhkGb4EA6nmXYqz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3lqc3Z5b0tDTGdYekhseE1CdlY3MThTeFRuSDZNN09mYWZacVh0UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mZWVkYmFjayI7czo1OiJyb3V0ZSI7czoxNToiZmVlZGJhY2suY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790630177),
('hajTCrYoJU8DrvbvUpv7oqlOBx6OqrxumEO66mtx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHNjd1FIY2dJcjFPOThRUm16cVZsb3pPTGtSU2JsMG1mZGFrbUVHNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790637997),
('hlWrJPuJH10VpL7hD4f1i5ozEUavpj7f95btLyLH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjlQUGFEcUFORGNya01td1NxYUZsTGZVdGdlRDdHYVV0RUxOU0ZKNyI7czoxNDoidmlld2VkX21lcmNoXzYiO2I6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21lcmNoYW5kaXNlL3NoYXlhbiI7czo1OiJyb3V0ZSI7czoxNjoibWVyY2hhbmRpc2Uuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790632598),
('MRppAPaNHIGn3dOTF5rHDgNGK6FeyOtq0vjWEGa7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ015QmkxMDhwdGRFcGRvZVJKN0Jqa3RWUUltYTc3MTNwR2xMWGp5ciI7czoxNjoidmlld2VkX2NvbnRlbnRfNSI7YjoxO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY29udGVudHMvNSI7czo1OiJyb3V0ZSI7czoxMzoiY29udGVudHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790629837),
('rhJeKOdaUy5uKyQH2vSa122WuzIPSr0iqgImZRfg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGY2WlVnOGd1aVBHZkZaZkp2Rnd2SVhBZ2pNYnZ5MjRtWXF2S3pDdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZXJjaGFuZGlzZS9zaGF5YW4iO3M6NToicm91dGUiO3M6MTY6Im1lcmNoYW5kaXNlLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790632994),
('RXICZSAgyfcOsu2oFX73CD9U6lnz0ynbrSZhxV5Y', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoielRVMXgwVjZSckFvc3ozd1duRW1INnBTa0lhaXNINnVzb3l3ZTlPOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790656322),
('TaGd8RA0C2lb4VfxQKCG4gh7LbWsuPchK9CVDqDr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkJITWhpMU1tUVpyNTBjRkI0R1Y1bmlwZjhPWHc4U1pJdURMWVdDaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZXJjaGFuZGlzZSI7czo1OiJyb3V0ZSI7czoxNzoibWVyY2hhbmRpc2UuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790632994),
('Xnw2vZaIqDEqRvnUlgiMQIEP4NCigQUSqZOgvfTX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXJ4M1lrN0RaOTVoZXVCclJnY28wTFJ0dE84MzdaNjZMajZ1Z0t5aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9leHBsb3JlIjtzOjU6InJvdXRlIjtzOjc6ImV4cGxvcmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790636201),
('xsPskpI8Gv1Vx9IhTsrzXPUfKqf99Et1e7kQKWWb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOG0zekNKd2MzUjZZdm9BTlRoT2ZNeHNmOUFQeU90dnpZQWV1aFBZYyI7czoxNDoidmlld2VkX21lcmNoXzYiO2I6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21lcmNoYW5kaXNlL3NoYXlhbiI7czo1OiJyb3V0ZSI7czoxNjoibWVyY2hhbmRpc2Uuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790632638),
('YldUC1qSbrJFto1SiFlyV2y1fkgW3HgF4lypIdWG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEtRdDhJRjZFbks5YXNuclR3OHpqVlBhdmJ1V0dZMTkzbEFnTHdFOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9leHBsb3JlIjtzOjU6InJvdXRlIjtzOjc6ImV4cGxvcmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790636302),
('ZoYwrpkHkd7hPMBpoERjUX35IyHwolyhcapVEvdU', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0Mxb3VwQXZGQUF4c0ljMDJHa2lOdjdzUFBKYmhrSkZ4akRUMUFqbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZXJjaGFuZGlzZSI7czo1OiJyb3V0ZSI7czoxNzoibWVyY2hhbmRpc2UuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790656607);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#8b5cf6',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timeline_events`
--

CREATE TABLE `timeline_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `order_index` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('user','organizer','admin') NOT NULL DEFAULT 'user',
  `banned_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `password_changed_at`, `remember_token`, `avatar`, `is_admin`, `role`, `banned_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@fanhubplus.com', '2026-09-26 18:34:49', '$2y$12$6UgDXioCmUWu65r92.pLFOnoH5jPHyi0fdylcvNXKfiWDPU8O8HJq', NULL, NULL, 'profile-pictures/okvcvExX6dwVJBY3sQMixYUfe0MRhUx8gWoTQkP8.jpg', 1, 'admin', NULL, NULL, '2026-09-26 18:34:49', '2026-09-28 21:09:56'),
(20, 'MUHAMMAD SHAYAN', 'shayandeveloper01@gmail.com', NULL, '$2y$12$eIxfgEJiF15TmUsMnkuxLOa3LxZrLJqggZvxyxzXS/1EsgrYI6yWO', '2026-09-28 07:54:16', NULL, 'profile-pictures/8uFOBGL5wLZfVl9HDdZ8oED0iD1j76mrr9DHRnTg.jpg', 0, 'user', NULL, NULL, '2026-09-27 19:50:30', '2026-09-28 21:20:42'),
(30, 'FASIH', 'fasih12@gmail.com', NULL, '$2y$12$zwx4lgt7zBhOSc5m0uWbH.clwyTlZ5NFVyloUD.Gm9j3rVxB7378C', NULL, NULL, 'profile-pictures/B8T0fZNz4xxI4yMbIejLjLKOPAIh94TaZLqRkWrs.jpg', 0, 'user', NULL, NULL, '2026-09-28 21:57:41', '2026-09-29 04:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `watch_progress`
--

CREATE TABLE `watch_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `progress_pct` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_activity_logs_admin_id_created_at_index` (`admin_id`,`created_at`),
  ADD KEY `admin_activity_logs_action_index` (`action`);

--
-- Indexes for table `analytics_events`
--
ALTER TABLE `analytics_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `analytics_events_profile_id_foreign` (`profile_id`),
  ADD KEY `analytics_events_event_type_index` (`event_type`),
  ADD KEY `analytics_events_created_at_index` (`created_at`),
  ADD KEY `analytics_events_event_type_created_at_index` (`event_type`,`created_at`),
  ADD KEY `analytics_events_session_id_index` (`session_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_user_id_foreign` (`user_id`),
  ADD KEY `articles_status_is_featured_index` (`status`,`is_featured`),
  ADD KEY `articles_published_at_index` (`published_at`),
  ADD KEY `articles_category_id_foreign` (`category_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookmarks_user_id_content_id_unique` (`user_id`,`content_id`),
  ADD KEY `bookmarks_content_id_foreign` (`content_id`);

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
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `characters_content_id_index` (`content_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_chat_session_id_foreign` (`chat_session_id`);

--
-- Indexes for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chat_sessions_session_id_unique` (`session_id`),
  ADD KEY `chat_sessions_user_id_foreign` (`user_id`),
  ADD KEY `chat_sessions_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contents_slug_unique` (`slug`),
  ADD KEY `contents_user_id_foreign` (`user_id`),
  ADD KEY `contents_category_id_index` (`category_id`),
  ADD KEY `contents_genre_index` (`genre`),
  ADD KEY `contents_year_index` (`year`),
  ADD KEY `contents_type_index` (`type`),
  ADD KEY `contents_views_count_index` (`views_count`),
  ADD KEY `contents_status_index` (`status`);

--
-- Indexes for table `content_notes`
--
ALTER TABLE `content_notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_notes_user_id_content_id_unique` (`user_id`,`content_id`),
  ADD KEY `content_notes_content_id_foreign` (`content_id`);

--
-- Indexes for table `content_tag`
--
ALTER TABLE `content_tag`
  ADD PRIMARY KEY (`content_id`,`tag_id`),
  ADD KEY `content_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `daily_stats`
--
ALTER TABLE `daily_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `daily_stats_date_metric_unique` (`date`,`metric`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_user_id_foreign` (`user_id`),
  ADD KEY `events_content_id_foreign` (`content_id`),
  ADD KEY `events_city_index` (`city`),
  ADD KEY `events_start_datetime_index` (`start_datetime`),
  ADD KEY `events_category_id_index` (`category_id`),
  ADD KEY `events_country_index` (`country`);

--
-- Indexes for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_rsvps_event_id_user_id_unique` (`event_id`,`user_id`),
  ADD KEY `event_rsvps_user_id_foreign` (`user_id`),
  ADD KEY `event_rsvps_event_id_status_index` (`event_id`,`status`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_is_published_index` (`is_published`),
  ADD KEY `faqs_sort_order_index` (`sort_order`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `feedback_reference_code_unique` (`reference_code`),
  ADD KEY `feedback_user_id_foreign` (`user_id`),
  ADD KEY `feedback_related_type_related_id_index` (`related_type`,`related_id`),
  ADD KEY `feedback_type_index` (`type`),
  ADD KEY `feedback_status_index` (`status`);

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
-- Indexes for table `merchandise`
--
ALTER TABLE `merchandise`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `merchandise_slug_unique` (`slug`),
  ADD KEY `merchandise_user_id_foreign` (`user_id`),
  ADD KEY `merchandise_content_id_foreign` (`content_id`),
  ADD KEY `merchandise_category_id_index` (`category_id`),
  ADD KEY `merchandise_status_index` (`status`),
  ADD KEY `merchandise_views_count_index` (`views_count`);

--
-- Indexes for table `merchandise_images`
--
ALTER TABLE `merchandise_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchandise_images_merchandise_id_sort_order_index` (`merchandise_id`,`sort_order`);

--
-- Indexes for table `merchandise_tags`
--
ALTER TABLE `merchandise_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `merchandise_tags_slug_unique` (`slug`);

--
-- Indexes for table `merchandise_tag_pivot`
--
ALTER TABLE `merchandise_tag_pivot`
  ADD PRIMARY KEY (`merchandise_id`,`tag_id`),
  ADD KEY `merchandise_tag_pivot_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_list`
--
ALTER TABLE `my_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `my_list_profile_id_content_id_unique` (`profile_id`,`content_id`),
  ADD KEY `my_list_content_id_foreign` (`content_id`),
  ADD KEY `my_list_profile_id_index` (`profile_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_index` (`user_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_user_id_content_id_unique` (`user_id`,`content_id`),
  ADD KEY `ratings_content_id_index` (`content_id`),
  ADD KEY `ratings_profile_id_foreign` (`profile_id`),
  ADD KEY `ratings_review_status_index` (`review_status`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resources_slug_unique` (`slug`),
  ADD KEY `resources_user_id_foreign` (`user_id`),
  ADD KEY `resources_content_id_is_approved_index` (`content_id`,`is_approved`),
  ADD KEY `resources_is_approved_index` (`is_approved`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indexes for table `timeline_events`
--
ALTER TABLE `timeline_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timeline_events_content_id_order_index_index` (`content_id`,`order_index`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `watch_progress`
--
ALTER TABLE `watch_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `watch_progress_profile_id_content_id_unique` (`profile_id`,`content_id`),
  ADD KEY `watch_progress_content_id_foreign` (`content_id`),
  ADD KEY `watch_progress_profile_id_updated_at_index` (`profile_id`,`updated_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `analytics_events`
--
ALTER TABLE `analytics_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1488;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `content_notes`
--
ALTER TABLE `content_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_stats`
--
ALTER TABLE `daily_stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchandise`
--
ALTER TABLE `merchandise`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `merchandise_images`
--
ALTER TABLE `merchandise_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchandise_tags`
--
ALTER TABLE `merchandise_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `my_list`
--
ALTER TABLE `my_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline_events`
--
ALTER TABLE `timeline_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `watch_progress`
--
ALTER TABLE `watch_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD CONSTRAINT `admin_activity_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `analytics_events`
--
ALTER TABLE `analytics_events`
  ADD CONSTRAINT `analytics_events_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_chat_session_id_foreign` FOREIGN KEY (`chat_session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `chat_sessions_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chat_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `contents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `contents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `content_notes`
--
ALTER TABLE `content_notes`
  ADD CONSTRAINT `content_notes_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `content_tag`
--
ALTER TABLE `content_tag`
  ADD CONSTRAINT `content_tag_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_rsvps`
--
ALTER TABLE `event_rsvps`
  ADD CONSTRAINT `event_rsvps_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_rsvps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `merchandise`
--
ALTER TABLE `merchandise`
  ADD CONSTRAINT `merchandise_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `merchandise_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `merchandise_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merchandise_images`
--
ALTER TABLE `merchandise_images`
  ADD CONSTRAINT `merchandise_images_merchandise_id_foreign` FOREIGN KEY (`merchandise_id`) REFERENCES `merchandise` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merchandise_tag_pivot`
--
ALTER TABLE `merchandise_tag_pivot`
  ADD CONSTRAINT `merchandise_tag_pivot_merchandise_id_foreign` FOREIGN KEY (`merchandise_id`) REFERENCES `merchandise` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `merchandise_tag_pivot_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `merchandise_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `my_list`
--
ALTER TABLE `my_list`
  ADD CONSTRAINT `my_list_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `my_list_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `resources_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timeline_events`
--
ALTER TABLE `timeline_events`
  ADD CONSTRAINT `timeline_events_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `watch_progress`
--
ALTER TABLE `watch_progress`
  ADD CONSTRAINT `watch_progress_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watch_progress_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
