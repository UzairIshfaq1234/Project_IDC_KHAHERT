-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2023 at 11:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idc`
--

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
-- Table structure for table `idc_admins`
--

CREATE TABLE `idc_admins` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` int(11) NOT NULL,
  `Contactno` varchar(255) NOT NULL,
  `Image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idc_admins`
--

INSERT INTO `idc_admins` (`Id`, `Name`, `Username`, `Email`, `Password`, `Role`, `Contactno`, `Image`, `created_at`, `updated_at`) VALUES
(2, 'muhamad uzair ishfaq', 'admin', 'uzairishfaq1234@gmail.com', 'admin1234', 1, '03075842703', '1700068613_admin.jpg', '2023-11-15 12:16:53', '2023-11-16 11:43:34'),
(6, 'muhamad uzair ishfaq', 'doctor', 'uzairishfaq1234@gmail.com', 'doctor1234', 3, '03075842703', '1700320786_doctor.jpg', '2023-11-18 10:19:47', '2023-11-18 10:19:47'),
(7, 'Khadija Ibrahim', 'Khadijaadmin', 'www.khadijamughal786@gmail.com', '12345678', 1, '03075842703', '1700155132_lab.jpg', '2023-11-20 01:13:51', '2023-11-20 01:13:51'),
(8, 'Khadija Ibrahim', 'Khadijatech', 'www.khadijamughal786@gmail.com', '12345678', 2, '03075842703', '1700460969_Khadijatech.jpg', '2023-11-20 01:16:09', '2023-11-20 01:16:09'),
(9, 'Khadija Ibrahim', 'KhadijaPath', 'www.khadijamughal786@gmail.com', '12345678', 3, '03075842703', '1700461252_KhadijaPath.jpg', '2023-11-20 01:20:52', '2023-11-20 01:20:52'),
(11, 'madam gulshan saleem', 'GulshanAdmin', 'gulshansaleem@lgu.edu.pk', 'gulshan123456', 1, '03154784468', '1703864132_GulshanAdmin.jpg', '2023-12-29 10:35:33', '2023-12-29 10:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `idc_patients`
--

CREATE TABLE `idc_patients` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Sampleno` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Contactno` varchar(255) NOT NULL,
  `Addedby` varchar(255) DEFAULT NULL,
  `Doctorby` varchar(255) DEFAULT NULL,
  `Result` varchar(255) DEFAULT NULL,
  `Image` text DEFAULT NULL,
  `treated` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idc_patients`
--

INSERT INTO `idc_patients` (`Id`, `Sampleno`, `Name`, `Email`, `Contactno`, `Addedby`, `Doctorby`, `Result`, `Image`, `treated`, `created_at`, `updated_at`) VALUES
(1, '1', 'sudais Khan', 'uzairishfaq12345@gmail.com', '03075842703', 'lab', 'doctor', 'Positive', '1700328569_1.png', '1', '2023-11-18 12:28:39', '2023-12-27 06:56:57'),
(2, '1312', 'muhamad uzair ishfaq', 'uzairishfaq1234@gmail.com', '03075842703', 'lab', 'KhadijaPath', 'Positive', '1702019922_1312.png', '1', '2023-11-18 12:28:53', '2023-12-08 02:18:42'),
(3, '14362', 'Khadija Ibrahim', 'www.khadijamughal786@gmail.com', '03075842703', 'Khadijatech', 'KhadijaPath', 'Positive', '1700461944_14362.png', '1', '2023-11-20 01:16:59', '2023-11-20 01:32:24'),
(4, '112577', 'muhamad uzair ishfaq', 'uzairishfaq1234@gmail.com', '03075842703', 'Khadijatech', 'Khadijaadmin', 'Positive', '1702629235_112577.png', '1', '2023-12-08 02:17:15', '2023-12-15 03:33:55'),
(5, '112dxd', 'muhamad uzair ishfaq', 'uzairishfaq1234@gmail.com', '03075842703', 'Khadijaadmin', 'KhadijaPath', 'Negative', '1703260361_112dxd.jpg', '1', '2023-12-20 11:08:30', '2023-12-22 10:52:41'),
(6, '131223', 'muhamad uzair ishfaq', 'uzairishfaq1234@gmail.com', '03075842703', 'lab', 'admin', 'Negative', '1703408383_131223.png', '1', '2023-12-22 10:44:51', '2023-12-24 03:59:43'),
(7, '131253223', 'Uzair Khan 12354', 'uzairishfaq1234@gmail.com', '03075842703', 'lab', 'KhadijaPath', 'Negative', '1703260020_131253223.jpg', '1', '2023-12-22 10:45:23', '2023-12-29 08:37:33'),
(8, '11212334', 'Muhammad Uzair Ishfaq', 'uzairishfaq1234@gmail.com', '03075842703', 'admin', 'doctor', 'Positive', '1703678044_11212334.png', '1', '2023-12-24 03:00:18', '2023-12-27 06:54:04'),
(9, '16765283', 'Uzair Ishfaq Khan', 'uzairishfaq1234@gmail.com', '03154784468', 'Khadijatech', 'doctor', 'Negative', '1703678057_16765283.png', '1', '2023-12-27 06:44:26', '2023-12-27 06:54:17'),
(10, '1676528323', 'Uzair Ishfaq Khan', 'uzairishfaq1234@gmail.com', '03154784468', 'Khadijatech', 'KhadijaPath', 'Positive', '1703857460_1676528323.png', '1', '2023-12-29 08:35:57', '2023-12-29 08:44:20'),
(11, '16765288997', 'madam gulshan saleem', 'gulshansaleem@lgu.edu.pk', '03154784468', 'Khadijatech', 'KhadijaPath', 'Positive', '1703864962_16765288997.png', '1', '2023-12-29 10:38:37', '2023-12-29 10:49:22');

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
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2023_11_13_175304_create_idc_admins_table', 1),
(13, '2023_11_16_173924_create_idc_patients_table', 2);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `idc_admins`
--
ALTER TABLE `idc_admins`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `idc_admins_username_unique` (`Username`);

--
-- Indexes for table `idc_patients`
--
ALTER TABLE `idc_patients`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `idc_patients_sampleno_unique` (`Sampleno`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idc_admins`
--
ALTER TABLE `idc_admins`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `idc_patients`
--
ALTER TABLE `idc_patients`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
