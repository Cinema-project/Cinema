-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Gru 2017, 23:02
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
-- Struktura tabeli dla tabeli `cinemamovies`
--

DROP TABLE IF EXISTS `cinemamovies`;
CREATE TABLE IF NOT EXISTS `cinemamovies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `tmdbmovie_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`movie_id`),
  KEY `cinemamovies_ibfk_1` (`tmdbmovie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cinemas`
--

DROP TABLE IF EXISTS `cinemas`;
CREATE TABLE IF NOT EXISTS `cinemas` (
  `id_cinema` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `locationEW` double NOT NULL,
  `locationNS` double NOT NULL,
  PRIMARY KEY (`id_cinema`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `time` time NOT NULL,
  `id_cinema` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`id_event`),
  UNIQUE KEY `id_cinema` (`id_cinema`),
  KEY `id_movie` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `facebook_users`
--

DROP TABLE IF EXISTS `facebook_users`;
CREATE TABLE IF NOT EXISTS `facebook_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `picture_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Struktura tabeli dla tabeli `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `id_genre` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `genres_movie`
--

DROP TABLE IF EXISTS `genres_movie`;
CREATE TABLE IF NOT EXISTS `genres_movie` (
  `id_movie` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`),
  KEY `id_genre` (`id_genre`)
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
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tmdbmovies`
--

DROP TABLE IF EXISTS `tmdbmovies`;
CREATE TABLE IF NOT EXISTS `tmdbmovies` (
  `MovieID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Popularity` int(11) NOT NULL,
  `Poster` text NOT NULL,
  `Trailer` text NOT NULL,
  `vote_average` double NOT NULL,
  `Premiere_date` date NOT NULL,
  PRIMARY KEY (`MovieID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `upcomming`
--

DROP TABLE IF EXISTS `upcomming`;
CREATE TABLE IF NOT EXISTS `upcomming` (
  `id_movie` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_movie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(254) NOT NULL,
  `Nick` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `Avatar` text,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `AccountName_UNIQUE` (`Email`),
  KEY `fk_Accounts_Roles1_idx` (`RoleId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`UserId`, `Email`, `Nick`, `Password`, `RoleId`, `Avatar`) VALUES
(1, 'Admin', 'Admin', '$2y$10$DjW1zh6mOKBifrJ8p0uBcOJ9h0l80DehgmY.4xe9KVFuWgp/4O/hq ', 1, NULL),
(2, 'Arek', 'AREK', '$2y$10$sow.mC0Tg6tTv6exZn0vLuM3i5yT4DBDOsHXHVPq.V0ITdc057h9q', 1, NULL),
(3, 'Jan', 'Janusz', '$2y$10$MIIt1b9om9EEPvGYkZd08uwjElyS6.vn8iE/r4VtopwSFWNCoSYxa', 2, NULL),
(4, 'Adam', 'adam', '$2y$10$WCp2.yuzRn4MA9IGin4J8ufga0G/0pUZyIj4OZLZmIumn75Y3WWZi', 2, NULL),
(5, 'Bartek', 'Barto', '$2y$10$sow.mC0Tg6tTv6exZn0vLuM3i5yT4DBDOsHXHVPq.V0ITdc057h9q', 2, NULL),
(6, 'qweqrq@qwqerqr.pl', 'nick', '$2y$10$7cHt.jaMM0KwB12SmxvpNu0pciFcpUp3HZQeSX1V1TmhMUQz9Piju', 1, NULL);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cinemamovies`
--
ALTER TABLE `cinemamovies`
  ADD CONSTRAINT `cinemamovies_ibfk_1` FOREIGN KEY (`tmdbmovie_id`) REFERENCES `tmdbmovies` (`MovieID`);

--
-- Ograniczenia dla tabeli `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_cinema`) REFERENCES `cinemas` (`id_cinema`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `cinemamovies` (`movie_id`);

--
-- Ograniczenia dla tabeli `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_Favorites_Accounts1` FOREIGN KEY (`AccountId`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Favorites_Movies1` FOREIGN KEY (`MovieId`) REFERENCES `tmdbmovies` (`MovieID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `genres_movie`
--
ALTER TABLE `genres_movie`
  ADD CONSTRAINT `genres_movie_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `tmdbmovies` (`MovieID`),
  ADD CONSTRAINT `genres_movie_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id_genre`);

--
-- Ograniczenia dla tabeli `tmdbmovies`
--
ALTER TABLE `tmdbmovies`
  ADD CONSTRAINT `tmdbmovies_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `moviestmdb_events` (`id_movie_tmdb`);

--
-- Ograniczenia dla tabeli `upcomming`
--
ALTER TABLE `upcomming`
  ADD CONSTRAINT `upcomming_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `tmdbmovies` (`MovieID`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_Accounts_Roles1` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`RoleId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
