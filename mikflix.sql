-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 05. 11 2017 kl. 20:00:37
-- Serverversion: 10.1.21-MariaDB
-- PHP-version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mikflix`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `globalsettings`
--

CREATE TABLE `globalsettings` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created` varchar(255) NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `modified` varchar(255) NOT NULL,
  `modifiedBy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `globalsettings`
--

INSERT INTO `globalsettings` (`id`, `category`, `prefix`, `title`, `value`, `created`, `createdBy`, `modified`, `modifiedBy`) VALUES
(1, 'directory', 'mainDir', 'Main Directory', 'storage/', '', '', '', ''),
(2, 'directory', 'movieDir', 'Movies Directory', 'storage/movies/', '', '', '', ''),
(3, 'directory', 'movieCmp', 'Movies Completed', 'storage/movies/completed/', '', '', '', ''),
(4, 'directory', 'movieArc', 'Movies Archive', 'storage/movies/archive/', '', '', '', ''),
(5, 'directory', 'movieTmp', 'Movies Temporary', 'storage/movies/tmp/', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `logindb`
--

CREATE TABLE `logindb` (
  `id` int(11) NOT NULL,
  `user` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `logindb`
--

INSERT INTO `logindb` (`id`, `user`, `password`, `email`, `created`) VALUES
(6, 'admin', '1234', 'mh89@live.dk', '2017-05-15 14:23:05'),
(14, 'fisk', '1234', 'fisk@fisk.dk', '2017-10-13 16:03:27'),
(15, 'FlÃ¦skesteg', '12345', 'mikkel123@hotmail.com', '2017-10-19 03:38:27');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `titleId` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `engSub` varchar(255) DEFAULT NULL,
  `daSub` varchar(255) DEFAULT NULL,
  `size` int(11) NOT NULL,
  `uploadedBy` varchar(255) NOT NULL,
  `uploaded` varchar(255) NOT NULL,
  `status` int(255) NOT NULL DEFAULT '1',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `accessLevel` int(19) NOT NULL,
  `modified` varchar(255) NOT NULL DEFAULT 'Never',
  `modifiedBy` varchar(255) NOT NULL DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `movies`
--

INSERT INTO `movies` (`id`, `titleId`, `title`, `file`, `engSub`, `daSub`, `size`, `uploadedBy`, `uploaded`, `status`, `published`, `accessLevel`, `modified`, `modifiedBy`) VALUES
(1, 1726, 'Iron Man', 'test.mp4', NULL, NULL, 339826453, 'admin', '2017-11-05 07:21:24', 0, 0, 0, '2017-11-05 07:31:41', 'admin'),
(2, 597, 'Titanic', 'test.mp4', NULL, NULL, 339826453, 'admin', '2017-11-05 07:23:14', 0, 0, 0, '2017-11-05 07:31:40', 'admin'),
(3, 190250, 'ABE', 'test.mp4', NULL, NULL, 339826453, 'admin', '2017-11-05 07:28:22', 1, 1, 0, 'Never', 'None'),
(4, 413992, 'Sweet Virginia', 'test.mp4', NULL, NULL, 339826453, 'admin', '2017-11-05 07:30:13', 1, 1, 0, 'Never', 'None');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `restrictionlevels`
--

CREATE TABLE `restrictionlevels` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rank` int(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `restrictionlevels`
--

INSERT INTO `restrictionlevels` (`id`, `title`, `rank`, `description`) VALUES
(1, 'God', 1, 'Full access'),
(2, 'Super User', 2, 'Publish, edit, remove, block users'),
(3, 'Trusted Viewer', 3, 'IRL Friend, Can view all movies'),
(4, 'Normal Viewer', 4, 'Can view all movies');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subtitle_labels`
--

CREATE TABLE `subtitle_labels` (
  `id` int(255) NOT NULL,
  `kind` varchar(255) DEFAULT NULL,
  `srclang` varchar(255) DEFAULT NULL,
  `label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Data dump for tabellen `subtitle_labels`
--

INSERT INTO `subtitle_labels` (`id`, `kind`, `srclang`, `label`) VALUES
(1, 'subtitles', 'da', 'Danish'),
(2, 'subtitles', 'en', 'English');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `titledata`
--

CREATE TABLE `titledata` (
  `id` int(255) NOT NULL,
  `titleId` int(255) NOT NULL,
  `originalTitle` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `overview` text NOT NULL,
  `adult` varchar(255) NOT NULL,
  `releaseDate` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `voteAverage` varchar(255) NOT NULL,
  `voteCount` int(255) NOT NULL,
  `popularity` varchar(255) NOT NULL,
  `mediaType` varchar(255) NOT NULL,
  `posterPath` varchar(255) NOT NULL,
  `backdropPath` varchar(255) NOT NULL,
  `lastUpdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `titledata`
--

INSERT INTO `titledata` (`id`, `titleId`, `originalTitle`, `genre`, `overview`, `adult`, `releaseDate`, `language`, `voteAverage`, `voteCount`, `popularity`, `mediaType`, `posterPath`, `backdropPath`, `lastUpdate`) VALUES
(1, 1726, 'Iron Man', '28', 'After being held captive in an Afghan cave, billionaire engineer Tony Stark creates a unique weaponized suit of armor to fight evil.', 'false', '2008-04-30', 'en', '7.4', 9156, '33.305402', 'Movie', '/848chlIWVT41VtAAgyh9bWymAYb.jpg', '/ZQixhAZx6fH1VNafFXsqa1B8QI.jpg', '2017-11-05 07:21:24'),
(2, 597, 'Titanic', '18', '84 years later, a 101-year-old woman named Rose DeWitt Bukater tells the story to her granddaughter Lizzy Calvert, Brock Lovett, Lewis Bodine, Bobby Buell and Anatoly Mikailavich on the Keldysh about her life set in April 10th 1912, on a ship called Titanic when young Rose boards the departing ship with the upper-class passengers and her mother, Ruth DeWitt Bukater, and her fiancÃ©, Caledon Hockley. Meanwhile, a drifter and artist named Jack Dawson and his best friend Fabrizio De Rossi win third-class tickets to the ship in a game. And she explains the whole story from departure until the death of Titanic on its first and last voyage April 15th, 1912 at 2:20 in the morning.', 'false', '1997-11-18', 'en', '7.5', 8003, '30.783847', 'Movie', '/kHXEpyfl6zqn8a6YuozZUujufXf.jpg', '/fVcZErSWa7gyENuj8IWp8eAfCnL.jpg', '2017-11-05 07:23:14'),
(3, 190250, 'ABE', '878', 'A short film about a robot programmed for love who wants to fix the humans who do not love him back.', 'false', '2013-04-16', 'en', '6.2', 28, '2.489847', 'Movie', '/9kArqpBC9W3ga8FVJnLYKKActS4.jpg', '/gnCDvTnpZO5xrcLbKbdsmm3KsUf.jpg', '2017-11-05 07:28:22'),
(4, 413992, 'Sweet Virginia', '', 'A former rodeo champ befriends a young man with a propensity for violence.', 'false', '2017-11-17', 'en', '0', 1, '12.392265', 'Movie', '/qTch1l0ZMU4MiOBDEJ14jVmANVC.jpg', '/2gGug6mhhYn6sRrym91n3GAq88A.jpg', '2017-11-05 07:30:13');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `topnav`
--

CREATE TABLE `topnav` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `rank` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `topnav`
--

INSERT INTO `topnav` (`id`, `name`, `target`, `rank`) VALUES
(1, 'Forside', 'index.php', 1),
(2, 'Upload', 'upload2.php', 2),
(3, 'Cinema', 'cinema.php', 3),
(6, 'Videoadmin', 'videoadmin.php', 4),
(7, 'Admin', 'admin.php', 5),
(8, 'Hollywood', 'hollywood.php', 6),
(9, 'DB', 'http://localhost:8000/phpmyadmin/', 7);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `viewing_history`
--

CREATE TABLE `viewing_history` (
  `trackingId` int(255) NOT NULL,
  `userId` int(255) NOT NULL,
  `titleId` int(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `mediaTimestamp` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Data dump for tabellen `viewing_history`
--

INSERT INTO `viewing_history` (`trackingId`, `userId`, `titleId`, `status`, `mediaTimestamp`, `timestamp`) VALUES
(1, 6, 1726, '1', '00:01:34', '2017-10-18 16:40:13');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `globalsettings`
--
ALTER TABLE `globalsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `logindb`
--
ALTER TABLE `logindb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`title`,`file`,`size`,`uploaded`,`uploadedBy`);

--
-- Indeks for tabel `restrictionlevels`
--
ALTER TABLE `restrictionlevels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `subtitle_labels`
--
ALTER TABLE `subtitle_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `titledata`
--
ALTER TABLE `titledata`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `topnav`
--
ALTER TABLE `topnav`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `viewing_history`
--
ALTER TABLE `viewing_history`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `trackingId` (`trackingId`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `globalsettings`
--
ALTER TABLE `globalsettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `logindb`
--
ALTER TABLE `logindb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Tilføj AUTO_INCREMENT i tabel `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `restrictionlevels`
--
ALTER TABLE `restrictionlevels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `subtitle_labels`
--
ALTER TABLE `subtitle_labels`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `titledata`
--
ALTER TABLE `titledata`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `topnav`
--
ALTER TABLE `topnav`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Tilføj AUTO_INCREMENT i tabel `viewing_history`
--
ALTER TABLE `viewing_history`
  MODIFY `trackingId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
