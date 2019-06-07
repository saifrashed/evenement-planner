-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 06 jun 2019 om 09:28
-- Serverversie: 8.0.15
-- PHP-versie: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_planner`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `activity_description` text NOT NULL,
  `date_planned` date NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activity_todo`
--

CREATE TABLE `activity_todo` (
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `role`
--

INSERT INTO `role` (`role_id`, `description`) VALUES
(0, 'vrijwilliger'),
(1, 'beheerder');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `status`
--

INSERT INTO `status` (`status_id`, `description`) VALUES
(0, 'klaar'),
(1, 'bezig'),
(2, 'in de wacht');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(256) NOT NULL,
  `lname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `gender` int(11) NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `gender`, `password`, `role`) VALUES
(1, 'saif', 'rashed', 'saifeddinerashed@icloud.com', 0, '$2y$10$K7tgqZ4lb2I2QiG9CC4sYeoO6J5m2W7svPAVcSrsSc76EAWklduWG', 1),
(2, 'saif', 'rashed', 'saifeddinerashed@icloud.com', 0, '$2y$10$pNpMxWRW0hr/Bg5n9Yt4OOzLeUq5yOLRwyDp4eLrPoMZfT2unA7fi', 0),
(3, 'adham', 'rashed', 'adham@live.nl', 0, '$2y$10$3ViGs.rgXyQvqRcRv2E5r.mpGafFbsn1AIWvzobybPwd8HVhJj2yy', 0),
(4, 'saif', 'rashed', 'ddsd@icloud.com', 0, '$2y$10$DDKpU4x/R7yMc.nos8vZHuzdRfFZyi/PeD9sw2dPcSX4jajg9Cz4K', 0),
(5, 'adham', 'rashed', 'ietsandwers@live.nl', 1, '$2y$10$wWPKpIxl5pUPo7DiyhzzquQGXAI59r/Fj/qQrAIOo6BOOj8tH1Vy2', 0),
(6, 'adham', 'rashed', 'adhasdadm@live.nl', 0, '$2y$10$c73Ch7GS8ck1BUNz1kdoL.KCnKXJO2y.VmgBH38apevryi6YH/cOq', 0),
(7, 'saif', 'rashed', 'saifeenevdfrashed@icloud.com', 0, '$2y$10$WsL5QQCbOnfmg8biHq.H/eS1RDONGQUcEzrlmizIz0agTF/PzrQ4.', 0),
(8, 'saif', 'rashed', 'saifeenevdfrashfefded@icloud.com', 0, '$2y$10$v7QUvQPl0mJ7Uo0Fvc4qLellsMjdHLodRp2pqVgzThF1ajc4QO9Pi', 0),
(9, 'saif', 'rashed', 'saifeddinerfrefashed@icloud.com', 0, '$2y$10$v5F1y17vU050yjXP8NIp8OawS77VrqnJDvkSKSoK3d/aLNSNwV5S2', 0),
(10, 'adham', 'rashed', 'adhafeferfem@live.nl', 0, '$2y$10$sPJIuejkDxDI4hWY0VvdgOTF0cfbTvnTclMLjOxHP6q1ITuOAljV2', 0),
(11, 'rauf', 'turay', 'rauf@live.nl', 1, '$2y$10$G2LqnDd9zct53kJ62UyKo.CCX8MYvLWN8e0LUUWwj7TuEdseR7/Yy', 0),
(12, 'jack', 'jones', 'jack.jones@multiversum.com', 1, '$2y$10$RaTPCzcQtRvjN7PrKlT6HeW9HlEPpxvNwDDDooEjXcjhulcuahQUy', 0),
(13, 'saif', 'rashed', 'saif@live.nl', 0, '$2y$10$8mcwfYSyevDq1AKd/keEEOXdo2RBMamt99P7TxkbIEe4kALeEJGIW', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_activity`
--

CREATE TABLE `user_activity` (
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexen voor tabel `activity_todo`
--
ALTER TABLE `activity_todo`
  ADD KEY `user_id` (`user_id`,`activity_id`,`cat_id`,`status_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexen voor tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexen voor tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Indexen voor tabel `user_activity`
--
ALTER TABLE `user_activity`
  ADD KEY `user_id` (`user_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `activity_todo`
--
ALTER TABLE `activity_todo`
  ADD CONSTRAINT `activity_todo_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `activity_todo_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`),
  ADD CONSTRAINT `activity_todo_ibfk_3` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  ADD CONSTRAINT `activity_todo_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `users` (`role`);

--
-- Beperkingen voor tabel `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_activity_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
