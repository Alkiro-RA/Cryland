-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Gru 2023, 00:03
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
-- Struktura tabeli dla tabeli `bosses`
--

CREATE TABLE `bosses` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `attack` int(255) NOT NULL,
  `health` int(255) NOT NULL,
  `maxhealth` int(255) NOT NULL,
  `defense` int(255) NOT NULL,
  `consumable` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `bosses`
--

INSERT INTO `bosses` (`id`, `name`, `attack`, `health`, `maxhealth`, `defense`, `consumable`) VALUES
(1, 'Skeleton King', 15, 100, 100, 5, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `characters`
--

CREATE TABLE `characters` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `level` int(255) NOT NULL,
  `exp` int(255) NOT NULL,
  `coins` int(255) NOT NULL,
  `weaponsid` int(11) DEFAULT NULL,
  `attack` int(255) NOT NULL,
  `health` int(255) NOT NULL,
  `maxhealth` int(255) NOT NULL,
  `defense` int(255) NOT NULL,
  `potion` int(60) NOT NULL,
  `consumable` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `characters`
--

INSERT INTO `characters` (`id`, `name`, `level`, `exp`, `coins`, `weaponsid`, `attack`, `health`, `maxhealth`, `defense`, `potion`, `consumable`) VALUES
(1, 'Kyuba', 3, 26, 50, NULL, 7, 5, 5, 5, 0, 0);
INSERT INTO `characters` (`id`, `name`, `level`, `exp`, `coins`, `weaponsid`, `attack`, `health`, `maxhealth`, `defense`, `potion`, `consumable`) VALUES
(2, 'Rash', 3, 26, 50, NULL, 7, 5, 5, 5, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `enemies`
--

CREATE TABLE `enemies` (
  `id` int(255) NOT NULL,
  `lvl` int(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `attack` int(255) NOT NULL,
  `health` int(255) NOT NULL,
  `maxhealth` int(255) NOT NULL,
  `defense` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `enemies`
--

INSERT INTO `enemies` (`id`, `lvl`, `name`, `attack`, `health`, `maxhealth`, `defense`) VALUES
(1, 2, 'Goblin', 2, 6, 6, 2),
(2, 1, 'Wolf', 2, 5, 5, 1),
(6, 3, 'Hobgoblin', 5, 10, 10, 4),
(7, 2, 'Skeleton', 5, 3, 3, 0),
(11, 3, 'Armored Skeleton', 5, 5, 5, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `id` int(255) NOT NULL,
  `rolename` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`id`, `rolename`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `roleid` int(255) NOT NULL,
  `charactersid` int(255) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `roleid`, `charactersid`, `nickname`, `email`, `password`) VALUES
(1, 2, 1, 'Kyuba', 'test@o2.pl', '$2y$10$4QG1rpzN4UnO1l4xPzk1a.kAdWkBDuFK7pkNa7LeSNopzppNiDl8m');
INSERT INTO `users` (`id`, `roleid`, `charactersid`, `nickname`, `email`, `password`) VALUES
(2, 2, 2, 'Rash', 'rog@test.pl', '$2y$10$Y.DXRyTWgfPqRXn.7u1.Xesm.QfXtfrMNv0xNxWi1pRRdPYaLQmIS');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `weapons`
--

CREATE TABLE `weapons` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `price` int(255) NOT NULL,
  `attack_bonus` int(255) NOT NULL,
  `health_bonus` int(255) NOT NULL,
  `defense_bonus` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `weapons` (`id`, `name`, `price`, `attack_bonus`, `health_bonus`, `defense_bonus`) VALUES ('1', 'Knife', '10', '3', '0', '1');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bosses`
--
ALTER TABLE `bosses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weaponsid` (`weaponsid`);

--
-- Indeksy dla tabeli `enemies`
--
ALTER TABLE `enemies`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `charactersid` (`charactersid`),
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
-- AUTO_INCREMENT dla tabeli `bosses`
--
ALTER TABLE `bosses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `enemies`
--
ALTER TABLE `enemies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `weapons`
--
ALTER TABLE `weapons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`weaponsid`) REFERENCES `weapons` (`id`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`charactersid`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
