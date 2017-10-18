-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 18. 10 2017 kl. 21:55:47
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
(14, 'fisk', '1234', 'fisk@fisk.dk', '2017-10-13 16:03:27');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `titleId` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `uploadedBy` varchar(255) NOT NULL,
  `uploaded` varchar(255) NOT NULL,
  `status` int(255) NOT NULL DEFAULT '1',
  `modified` varchar(255) NOT NULL DEFAULT 'Never',
  `modifiedBy` varchar(255) NOT NULL DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `movies`
--

INSERT INTO `movies` (`id`, `titleId`, `title`, `file`, `size`, `uploadedBy`, `uploaded`, `status`, `modified`, `modifiedBy`) VALUES
(4, 190250, 'abe', 'test.mp4', 339826453, 'admin', '2017-10-09 06:21:58', 1, 'Never', 'None'),
(5, 447092, 'kelo', 'test.mp4', 339826453, 'admin', '2017-10-09 06:24:35', 0, '2017-10-15 07:19:49', 'admin'),
(15, 1895, 'revenge of the sith', 'test.mp4', 339826453, 'admin', '2017-10-09 06:52:48', 0, '2017-10-15 07:19:52', 'admin'),
(18, 10201, 'yes man', 'test.mp4', 339826453, 'admin', '2017-10-09 07:27:09', 1, 'Never', 'None'),
(19, 1726, 'Iron Man', 'test.mp4', 339826453, 'admin', '2017-10-14 11:12:42', 1, '2017-10-14 11:13:05', 'admin'),
(20, 428497, 'aye', 'test.mp4', 339826453, 'admin', '2017-10-14 11:15:16', 1, 'Never', 'None'),
(21, 597, 'Titanic', 'test.mp4', 339826453, 'admin', '2017-10-14 11:30:47', 1, 'Never', 'None'),
(524, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(525, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(526, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(527, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(528, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(529, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(530, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(531, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(532, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(533, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(534, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(535, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(536, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(537, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(538, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(539, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(540, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(541, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(542, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(543, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(544, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(545, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(546, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(547, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(548, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(549, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(550, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(551, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(552, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(553, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(554, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(555, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(556, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(557, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(558, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(559, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(560, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(561, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(562, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(563, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(564, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(565, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(566, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(567, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(568, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(569, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(570, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(571, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(572, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(573, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(574, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(575, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(576, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(577, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(578, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(579, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(580, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(581, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(582, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(583, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(584, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(585, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(586, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(587, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(588, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(589, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(590, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(591, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(592, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(593, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(594, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(595, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(596, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(597, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(598, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(599, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(600, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(601, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(602, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(603, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(604, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(605, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(606, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(607, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(608, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(609, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(610, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(611, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(612, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(613, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(614, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(615, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(616, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(617, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(618, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(619, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(620, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(621, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(622, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(623, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(624, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(625, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(626, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(627, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(628, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(629, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(630, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(631, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(632, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(633, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(634, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(635, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(636, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(637, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(638, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(639, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(640, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(641, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(642, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(643, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(644, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(645, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(646, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(647, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(648, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(649, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(650, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(651, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(652, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(653, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(654, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(655, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(656, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(657, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(658, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(659, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(660, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(661, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(662, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(663, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(664, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(665, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(666, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(667, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(668, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(669, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(670, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(671, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(672, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(673, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(674, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(675, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(676, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(677, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(678, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(679, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(680, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(681, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(682, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(683, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(684, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(685, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(686, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(687, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(688, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(689, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(690, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(691, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(692, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(693, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(694, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(695, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(696, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(697, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(698, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(699, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(700, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(701, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(702, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(703, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(704, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(705, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(706, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(707, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(708, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(709, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(710, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(711, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(712, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(713, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(714, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(715, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(716, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(717, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(718, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(719, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(720, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(721, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(722, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(723, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(724, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(725, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(726, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(727, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(728, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(729, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(730, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(731, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(732, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(733, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(734, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(735, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(736, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(737, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(738, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(739, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(740, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(741, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(742, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(743, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(744, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(745, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(746, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(747, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(748, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(749, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(750, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(751, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(752, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(753, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(754, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(755, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(756, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(757, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None'),
(758, 10201, 'Yes Man', '', 0, '', '', 1, 'Never', 'None'),
(759, 190250, 'Abe', '', 0, '', '', 1, 'Never', 'None'),
(760, 1726, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(761, 428497, 'Iron Man', '', 0, '', '', 1, 'Never', 'None'),
(762, 1726, 'Pop Aye', '', 0, '', '', 1, 'Never', 'None'),
(763, 597, 'Titanic', '', 0, '', '', 1, 'Never', 'None');

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
  `lastUpdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `titledata`
--

INSERT INTO `titledata` (`id`, `titleId`, `originalTitle`, `genre`, `overview`, `adult`, `releaseDate`, `language`, `voteAverage`, `voteCount`, `popularity`, `mediaType`, `posterPath`, `lastUpdate`) VALUES
(1, 190250, 'ABE', '878', 'A short film about a robot programmed for love who wants to fix the humans who do not love him back.', '0', '2013-04-16', 'en', '6.1', 28, '2.325683', 'Movie', '/9kArqpBC9W3ga8FVJnLYKKActS4.jpg', '2017-10-09 06:21:58'),
(4, 10201, 'Yes Man', '35', 'Carl Allen has stumbled across a way to shake free of post-divorce blues and a dead-end job: embrace life and say yes to everything.', 'false', '2008-12-09', 'en', '6.4', 1850, '17.824712', 'Movie', '/zqSqnHb045TN8Lzt2X4IVy8dfAW.jpg', '2017-10-09 07:27:09'),
(5, 1726, 'Iron Man', '28', 'After being held captive in an Afghan cave, billionaire engineer Tony Stark creates a unique weaponized suit of armor to fight evil.', 'false', '2008-04-30', 'en', '7.4', 8898, '26.964965', 'Movie', '/848chlIWVT41VtAAgyh9bWymAYb.jpg', '2017-10-14 11:12:42'),
(6, 428497, 'Pop Aye', '18', 'On a chance encounter, a disenchanted architect bumps into his long-lost elephant on the streets of Bangkok. Excited, he takes his elephant on a journey across Thailand in search of the farm where they grew up together.', 'false', '2017-09-06', 'th', '0', 3, '2.475736', 'Movie', '/kTwE3Ff2LpCGBI4q7hsLzt2wnHP.jpg', '2017-10-14 11:15:16'),
(7, 597, 'Titanic', '18', '84 years later, a 101-year-old woman named Rose DeWitt Bukater tells the story to her granddaughter Lizzy Calvert, Brock Lovett, Lewis Bodine, Bobby Buell and Anatoly Mikailavich on the Keldysh about her life set in April 10th 1912, on a ship called Titanic when young Rose boards the departing ship with the upper-class passengers and her mother, Ruth DeWitt Bukater, and her fiancÃ©, Caledon Hockley. Meanwhile, a drifter and artist named Jack Dawson and his best friend Fabrizio De Rossi win third-class tickets to the ship in a game. And she explains the whole story from departure until the death of Titanic on its first and last voyage April 15th, 1912 at 2:20 in the morning.', 'false', '1997-11-18', 'en', '7.5', 7768, '17.773917', 'Movie', '/kHXEpyfl6zqn8a6YuozZUujufXf.jpg', '2017-10-14 11:30:47');

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
(2, 'Upload', 'upload.php', 2),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Tilføj AUTO_INCREMENT i tabel `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=764;
--
-- Tilføj AUTO_INCREMENT i tabel `restrictionlevels`
--
ALTER TABLE `restrictionlevels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `titledata`
--
ALTER TABLE `titledata`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
