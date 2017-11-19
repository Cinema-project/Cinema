-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Lis 2017, 23:30
-- Wersja serwera: 10.1.28-MariaDB
-- Wersja PHP: 7.1.10

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
CREATE DATABASE IF NOT EXISTS `db_cinema` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_cinema`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `awards`
--

DROP TABLE IF EXISTS `awards`;
CREATE TABLE IF NOT EXISTS `awards` (
  `AwardId` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`AwardId`),
  UNIQUE KEY `unique_constraint` (`Name`,`Category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `directors`
--

DROP TABLE IF EXISTS `directors`;
CREATE TABLE IF NOT EXISTS `directors` (
  `DirectorId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Biography` text NOT NULL,
  PRIMARY KEY (`DirectorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `AccountId` int(11) NOT NULL,
  `MovieId` int(11) NOT NULL,
  KEY `fk_Favorites_Movies1_idx` (`MovieId`),
  KEY `fk_Favorites_Accounts1` (`AccountId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `MovieId` int(11) NOT NULL AUTO_INCREMENT,
  `DirectorId` int(11) NOT NULL,
  `Title` text NOT NULL,
  `TypeId` int(11) NOT NULL,
  `Length` time DEFAULT NULL,
  `Description` text,
  `PremiereDate` date DEFAULT NULL,
  PRIMARY KEY (`MovieId`),
  KEY `DirectorId` (`DirectorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies_awards`
--

DROP TABLE IF EXISTS `movies_awards`;
CREATE TABLE IF NOT EXISTS `movies_awards` (
  `MovieId` int(11) NOT NULL,
  `AwardId` int(11) NOT NULL,
  PRIMARY KEY (`MovieId`,`AwardId`),
  KEY `fk_Movies_has_Awards_Awards1_idx` (`AwardId`),
  KEY `fk_Movies_has_Awards_Movies1_idx` (`MovieId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `RoleId` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  PRIMARY KEY (`RoleId`),
  UNIQUE KEY `RoleId_UNIQUE` (`RoleId`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`RoleId`, `Name`) VALUES
(1, 'Admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(45) NOT NULL,
  `Nick` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `Avatar` text,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `AccountName_UNIQUE` (`Login`),
  KEY `fk_Accounts_Roles1_idx` (`RoleId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`UserId`, `Login`, `Nick`, `Password`, `RoleId`, `Avatar`) VALUES
(1, 'Admin', 'Admin', 'Admin', 1, NULL),
(2, 'Arek', 'AREK', 'Arek2', 1, NULL),
(7, 'qweqrq@qwqerqr.pl', 'nick', '12345678', 1, NULL);

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
