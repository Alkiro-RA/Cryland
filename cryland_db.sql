-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Gru 2023, 20:40
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `cryland_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `armors`
--

CREATE TABLE `armors` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `atack_bonus` int(255) NOT NULL,
  `health_bonus` int(255) NOT NULL,
  `defense_bonus` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bosses`
--

CREATE TABLE `bosses` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `atack` int(255) NOT NULL,
  `health` int(255) NOT NULL,
  `defense` int(255) NOT NULL,
  `consumable` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `characterlist`
--

CREATE TABLE `characterlist` (
  `userid` int(255) NOT NULL,
  `characterid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `characters`
--

CREATE TABLE `characters` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `level` int(255) NOT NULL,
  `exp` int(255) NOT NULL,
  `atack` int(255) NOT NULL,
  `health` int(255) NOT NULL,
  `defense` int(255) NOT NULL,
  `potion` int(60) NOT NULL,
  `consumable` int(60) NOT NULL,
  `consumable_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `enemies`
--

CREATE TABLE `enemies` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `atack` int(255) NOT NULL,
  `health` int(255) NOT NULL,
  `defense` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `eq`
--

CREATE TABLE `eq` (
  `characterid` int(255) NOT NULL,
  `weaponid` int(255) NOT NULL,
  `armorid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `id` int(255) NOT NULL,
  `rolename` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `roleid` int(10) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `roleid`, `nickname`, `email`, `password`) VALUES
(1, 0, 'Kyuba', 'test@o2.pl', '$2y$10$BCz8EvvyQoih1.Q6AY4OkebrKTsuDoAXIWwq1H1g7z5LOtkgTM7z.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `weapons`
--

CREATE TABLE `weapons` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `atack_bonus` int(255) NOT NULL,
  `health_bonus` int(255) NOT NULL,
  `defense_bonus` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `armors`
--
ALTER TABLE `armors`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `bosses`
--
ALTER TABLE `bosses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `characterlist`
--
ALTER TABLE `characterlist`
  ADD KEY `userid` (`userid`),
  ADD KEY `characterid` (`characterid`);

--
-- Indeksy dla tabeli `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `enemies`
--
ALTER TABLE `enemies`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `eq`
--
ALTER TABLE `eq`
  ADD KEY `characterid` (`characterid`,`weaponid`,`armorid`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roleid` (`roleid`);

--
-- Indeksy dla tabeli `weapons`
--
ALTER TABLE `weapons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `armors`
--
ALTER TABLE `armors`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `bosses`
--
ALTER TABLE `bosses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `enemies`
--
ALTER TABLE `enemies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `weapons`
--
ALTER TABLE `weapons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `characterlist`
--
ALTER TABLE `characterlist`
  ADD CONSTRAINT `characterlist_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `characterlist_ibfk_2` FOREIGN KEY (`characterid`) REFERENCES `characters` (`id`);

--
-- Ograniczenia dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`roleid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
