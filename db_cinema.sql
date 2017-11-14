-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Lis 2017, 17:03
-- Wersja serwera: 10.1.26-MariaDB
-- Wersja PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `db_cinema`
--
DROP DATABASE IF EXISTS `db_cinema`;
CREATE DATABASE IF NOT EXISTS `db_cinema` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_cinema`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `awards`
--

DROP TABLE IF EXISTS `awards`;
CREATE TABLE `awards` (
  `AwardId` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Category` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `directors`
--

DROP TABLE IF EXISTS `directors`;
CREATE TABLE `directors` (
  `DirectorId` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Biography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `AccountId` int(11) NOT NULL,
  `MovieId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `MovieId` int(11) NOT NULL,
  `DirectorId` int(11) NOT NULL,
  `Title` text NOT NULL,
  `TypeId` int(11) NOT NULL,
  `Length` time DEFAULT NULL,
  `Description` text,
  `PremiereDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies_awards`
--

DROP TABLE IF EXISTS `movies_awards`;
CREATE TABLE `movies_awards` (
  `MovieId` int(11) NOT NULL,
  `AwardId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `RoleId` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`RoleId`, `Name`) VALUES
(1, 'Admin'),
(3, 'Guest'),
(2, 'User');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `Login` varchar(45) NOT NULL,
  `Nick` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `Avatar` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`UserId`, `Login`, `Nick`, `Password`, `RoleId`, `Avatar`) VALUES
(1, 'Admin', 'Admin', 'Admin', 1, NULL),
(2, 'Wyso', 'Wyso', 'qwerty123', 2, NULL),
(3, 'Qbson', 'Damian', 'qwerty123', 2, NULL),
(4, 'Vincent', 'Winccent', 'qwerty123', 2, NULL),
(5, 'Łukasz', 'Nosacz', 'qwerty123', 2, NULL),
(6, 'Bartek', 'Programista', 'qwerty123', 2, NULL),
(7, 'Jan', 'Kowalski', 'qwerty123', 2, NULL),
(8, 'Tomasz', 'Nowak', 'qwerty123', 2, NULL),
(9, 'Jerzy', 'Lec', 'qwerty123', 2, NULL),
(10, 'Jurek', 'Owsiak', 'qwerty123', 2, NULL),
(11, 'Donald', 'Tusk', 'qwerty123', 2, NULL),
(12, 'Jarek', 'Kaczor', 'qwerty123', 2, NULL),
(13, 'Marek', 'Jolo', 'qwerty123', 3, NULL),
(14, 'Artur', 'Sołtyś', 'qwerty123', 3, NULL),
(15, 'Polak', 'Nosacz', 'qwerty123', 3, NULL),
(16, 'George', 'Nowam', 'qwerty123', 3, NULL),
(17, 'Natalia', 'Kowalski', 'qwerty123', 3, NULL),
(18, 'Julia', 'Nowak', 'qwerty123', 3, NULL),
(19, 'Izabela', 'Lec', 'qwerty123', 3, NULL),
(21, 'Jędrzej', 'Tusk', 'qwerty123', 3, NULL),
(22, 'Gumiś', 'Kaczor', 'qwerty123', 3, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`AwardId`),
  ADD UNIQUE KEY `unique_constraint` (`Name`,`Category`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`DirectorId`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD KEY `fk_Favorites_Movies1_idx` (`MovieId`),
  ADD KEY `fk_Favorites_Accounts1` (`AccountId`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MovieId`),
  ADD KEY `DirectorId` (`DirectorId`);

--
-- Indexes for table `movies_awards`
--
ALTER TABLE `movies_awards`
  ADD PRIMARY KEY (`MovieId`,`AwardId`),
  ADD KEY `fk_Movies_has_Awards_Awards1_idx` (`AwardId`),
  ADD KEY `fk_Movies_has_Awards_Movies1_idx` (`MovieId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleId`),
  ADD UNIQUE KEY `RoleId_UNIQUE` (`RoleId`),
  ADD UNIQUE KEY `Name_UNIQUE` (`Name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `AccountName_UNIQUE` (`Login`),
  ADD KEY `fk_Accounts_Roles1_idx` (`RoleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `directors`
--
ALTER TABLE `directors`
  MODIFY `DirectorId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `movies`
--
ALTER TABLE `movies`
  MODIFY `MovieId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_Favorites_Accounts1` FOREIGN KEY (`AccountId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Favorites_Movies1` FOREIGN KEY (`MovieId`) REFERENCES `movies` (`MovieId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `DirectorId` FOREIGN KEY (`DirectorId`) REFERENCES `directors` (`DirectorId`);

--
-- Ograniczenia dla tabeli `movies_awards`
--
ALTER TABLE `movies_awards`
  ADD CONSTRAINT `fk_Movies_has_Awards_Awards1` FOREIGN KEY (`AwardId`) REFERENCES `awards` (`AwardId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Movies_has_Awards_Movies1` FOREIGN KEY (`MovieId`) REFERENCES `movies` (`MovieId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_Accounts_Roles1` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`RoleId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
