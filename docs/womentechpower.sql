-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost:8889
-- Timp de generare: dec. 29, 2024 la 02:34 PM
-- Versiune server: 8.0.35
-- Versiune PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `womentechpower`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `event_date` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_type` enum('workshop','mentoring','networking','conference') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `max_participants` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('confirmed','waiting','cancelled') COLLATE utf8mb4_general_ci DEFAULT 'confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `profession` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expertise` text COLLATE utf8mb4_general_ci,
  `linkedin_profile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('active','pending','mentor') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `members`
--

INSERT INTO `members` (`id`, `first_name`, `last_name`, `email`, `profession`, `company`, `expertise`, `linkedin_profile`, `status`, `created_at`, `profile_picture`) VALUES
(3, 'BMihai', 'Leoca', 'mihai@test.com', 'tester', 'coera', 'z', 'sahttps://www.linkedin.com/jobs/', 'pending', '2024-12-18 17:49:03', 'uploads/676527a21fc3b.jpg'),
(4, 'MihaiPoza', 'Upload', 'mihai@upload.com', 'mecanic', 'Bosch', 'Mecanic', 'sahttps://www.linkedin.com/jobs/', 'pending', '2024-12-20 08:13:50', 'uploads/6765273e83e6a_Screenshot 2024-12-10 at 11.56.09.png'),
(6, 'Ghita', 'Ionel', 'ghita.ionel@gmail.com', 'Strungar', 'Bosch', '', 'sahttps://www.linkedin.com/jobs/', 'pending', '2024-12-23 12:27:30', 'uploads/6769573290528_Blue Orange Modern Car Insurance Instagram Post (Square).png');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `read_status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `notifications`
--

INSERT INTO `notifications` (`id`, `member_id`, `message`, `read_status`, `created_at`) VALUES
(1, NULL, 'Welcome Leoca! You have successfully joined Women in FinTech.', 0, '2024-12-20 10:55:02'),
(2, 6, 'Welcome Ghita! You have successfully joined Women in FinTech.', 0, '2024-12-23 12:27:30');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexuri pentru tabele `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexuri pentru tabele `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexuri pentru tabele `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `members` (`id`) ON DELETE SET NULL;

--
-- Constrângeri pentru tabele `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constrângeri pentru tabele `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
