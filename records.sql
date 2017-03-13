-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 09:57 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `artist` varchar(100) COLLATE utf8_bin NOT NULL,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `album_meta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`, `album_meta_id`) VALUES
(30, 'In Flames', 'Clayman', 67),
(63, 'In Flames', 'Lunar Strain', 0),
(65, 'In Flames', 'Subterranean', 0),
(66, 'In Flames', 'Whoracle', 0),
(67, 'In Flames', 'Colony', 0),
(68, 'In Flames', 'Reroute To Remain', 69),
(69, 'In Flames', 'Soundtrack To Your Escape', 70),
(71, 'The Eagles', 'Hell Freezes Over', 0),
(72, 'Pink Floyd', 'The Dark Side Of The Moon', 0),
(73, 'Pink Floyd', 'Wish You Were Here', 76),
(74, 'Jesse Cook', 'One World', 0),
(75, 'In Flames', 'Come Clarity', 0),
(76, 'In Flames', 'A Sense Of Purpose', 75);

-- --------------------------------------------------------

--
-- Table structure for table `album_meta`
--

CREATE TABLE `album_meta` (
  `id` int(11) NOT NULL,
  `album_length` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `album_meta`
--

INSERT INTO `album_meta` (`id`, `album_length`) VALUES
(13, '58 Minutes'),
(51, '1 Hour 36 Minutes'),
(53, '38 Minutes'),
(54, '42 Minutes'),
(55, '47 Minutes'),
(56, '58 Minutes'),
(57, '50 Minutes'),
(59, '74 Minutes'),
(60, '43 Minutes'),
(61, '34 Minutes'),
(62, '43 Minutes'),
(63, '37 Minutes'),
(64, '65 Minutes'),
(65, '53 Minutes'),
(67, '59 Minutes'),
(68, '55 Minutes'),
(69, '69 Minutes'),
(70, '50 Minutes'),
(71, '50 Minutes'),
(72, '50 Minutes'),
(73, 'test'),
(74, 'test'),
(75, '55 min'),
(76, '1 Hour');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `title` varchar(80) COLLATE utf8_bin NOT NULL,
  `length` varchar(25) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `album_id`, `title`, `length`) VALUES
(19, 30, 'Clayman', '3:29'),
(21, 30, 'Pinball Map', '4:08'),
(22, 30, 'Only For The weak', '4:55'),
(23, 30, 'As The Future Repeats Today', '3:28'),
(24, 30, 'Square Nothting', '3:58'),
(25, 30, 'Satellites and Astronauts', '5:01'),
(26, 30, 'Brush the Dust Away', '3:17'),
(27, 30, 'Swim', '3:14'),
(28, 30, 'Suburban Me', '3:36'),
(29, 30, 'Another Day in Quicksand', '3:58'),
(30, 30, 'Strong and Smart', '2:36'),
(31, 30, 'World of Promises', '3:50'),
(32, 63, 'Behind Space', '4:55'),
(33, 63, 'Lunar Strain', '4:05'),
(34, 63, 'Starforsaken', '3:10'),
(35, 63, 'Dreamscape', '3:45'),
(37, 63, 'Everlost (pt. 1)', '4:17'),
(38, 63, 'Everlost (pt. 2)', '2:57'),
(39, 63, 'Hargalaten', '2:26'),
(40, 63, 'In Flames', '5:33'),
(41, 63, 'Upon an Oaken Throne', '2:50'),
(42, 63, 'Clad in Shadows', '2:54'),
(43, 65, 'Stand Ablaze', '4:35'),
(44, 65, 'Ever Dying', '4:23'),
(45, 65, 'Subterranean', '5:47'),
(46, 65, 'Timeless', '1:46'),
(47, 65, 'Biosphere', '5:11'),
(48, 65, 'Dead Eternity', '5:02'),
(49, 65, 'The Inborn Lifeless', '3:24'),
(50, 65, 'Eye of the Beholder', '5:29'),
(51, 65, 'Murders in the Rue Morgue', '3:09'),
(53, 66, 'Jotun', '3:55'),
(54, 66, 'Food for the Gods', '4:21'),
(55, 66, 'Gyroscope', '3:26'),
(56, 66, 'Dialogue with the Stars', '3:01'),
(57, 66, 'The Hive', '4:04'),
(58, 66, 'Jester Script Transfigured', '5:47'),
(59, 66, 'Morphing into Primal', '3:05'),
(60, 66, 'Worlds Within the Margin', '5:06'),
(61, 66, 'Episode 666', '3:46'),
(62, 66, 'Everything Counts', '3:18'),
(63, 66, 'Whoracle', '2:46'),
(64, 67, 'Embody the Invisible', '3:38'),
(65, 67, 'Ordinary Story', '4:16'),
(66, 67, 'Scorn', '3:38'),
(67, 67, 'Zombie Inc.', '5:05'),
(68, 67, 'Pallar Anders Visa', '1:41'),
(69, 67, 'Coerced Coexistence', '4:14'),
(70, 67, 'Resin', '3:22'),
(71, 67, 'Behind Space \'99', '3:59'),
(72, 67, 'Insipid 2000', '3:45'),
(73, 67, 'the New World', '3:20'),
(74, 67, 'Man Made God', '4:11'),
(75, 68, 'Reroute to Remain', '3:53'),
(76, 68, 'System', '3:39'),
(77, 68, 'Drifter', '3:11'),
(78, 68, 'Trigger', '4:59'),
(79, 68, 'Cloud Connected', '3:41'),
(80, 68, 'Transparent', '4:04'),
(81, 68, 'Dawn of a New Day', '3:41'),
(82, 68, 'Egonomic', '2:37'),
(83, 68, 'Minus', '3:46'),
(84, 68, 'Dismiss the Cynics', '3:39'),
(85, 68, 'Free Fall', '3:58'),
(86, 68, 'Dark Signs', '3:20'),
(87, 68, 'Metaphor', '3:39'),
(88, 68, 'Black & White', '3:35'),
(89, 68, 'Watch them Feed', '3:12'),
(90, 68, 'Land of Confusion', '3:23'),
(91, 69, 'F(r)iend', '3:25'),
(92, 69, 'The Quiet Place', '3:45'),
(93, 69, 'Dead Alone', '3:43'),
(94, 69, 'Touch of Red', '4:13'),
(95, 69, 'Like You Better Dead', '3:23'),
(96, 69, 'My Sweet Shadow', '4:39'),
(97, 69, 'Evil in a Closet', '4:02'),
(98, 69, 'In Search For I', '3:23'),
(99, 69, 'Borders and Shading', '4:22'),
(100, 69, 'Superhero of the Computer Rage', '4:01'),
(101, 69, 'Dial 595-Escape', '3:48'),
(102, 69, 'Bottled', '3:06'),
(103, 69, 'Discover Me Like Emptiness', '4:18'),
(104, 71, 'Get Over It', '3:32'),
(105, 71, 'Love Will Keep Us Alive', '4:03'),
(106, 71, 'The Girl From Yesterday', '3:24'),
(107, 71, 'Learn To Be Still', '4:29'),
(108, 71, 'Tequila Sunrise', '3:28'),
(109, 71, 'Hotel California', '7:12'),
(110, 71, 'Wasted Time', '5:20'),
(111, 71, 'Pretty Maids All In a Row', '4:27'),
(112, 71, 'I Can\'t Tell You Why', '5:11'),
(113, 71, 'New York Minute', '6:38'),
(114, 71, 'The Last Resort', '7:24'),
(115, 71, 'Take It Easy', '4:36'),
(116, 71, 'In The City', '4:08'),
(117, 71, 'Life In The Fast Lane', '6:01'),
(118, 71, 'Desperado', '4:18'),
(119, 72, 'Speak To Me', '1:05'),
(120, 72, 'Breathe(in the air)', '2:50'),
(121, 72, 'On The Run', '3:45'),
(122, 72, 'Time', '6:54'),
(123, 72, 'The Great Gig In The Sky', '4:44'),
(124, 72, 'Money', '6:23'),
(125, 72, 'Us and Them', '7:49'),
(126, 72, 'Any Colour You Like', '3:26'),
(127, 72, 'Brain Damage', '3:47'),
(128, 72, 'Eclipse', '2:10'),
(129, 73, 'Shine On You Crazy Diamond Parts 1-5', '13:31'),
(130, 73, 'Welcome To The Machine', '7:32'),
(131, 73, 'Have a Cigar', '5:08'),
(132, 73, 'Wish You Were Here', '5:35'),
(133, 73, 'Shine On You Crazy Diamond Parts 6-9', '12:27'),
(134, 74, 'Shake', '3:41'),
(135, 74, 'Taxi Brazil', '2:55'),
(136, 74, 'Once', '5:05'),
(137, 74, 'Bombay Slam', '3:38'),
(138, 74, 'To Your Shore', '3:40'),
(139, 74, 'Three Days', '3:58'),
(140, 74, 'Tommy And Me', '4:12'),
(141, 74, 'When Night Falls', '3:35'),
(142, 74, 'Steampunk Rickshaw', '5:26'),
(143, 74, 'Beneath Your Skin', '4:38'),
(144, 74, 'Breath', '2:48'),
(145, 75, 'Take This Life', '3:35'),
(146, 76, 'The Mirror\'s Truth', '3:00'),
(147, 75, 'Leeches', '2:56'),
(148, 75, 'Reflect The Storm', '4:16'),
(149, 75, 'Dead End', '3:23'),
(150, 75, 'Scream', '3:13'),
(151, 75, 'Come Clarity', '4:16'),
(152, 75, 'Vacuum', '3:40'),
(153, 75, 'Pacing Death\'s Trail', '3:01'),
(154, 75, 'Crawling Through Knives', '4:03'),
(155, 75, 'Versus Terminus', '3:19'),
(156, 75, 'Our Infinite Struggle', '3:47'),
(157, 75, 'Vanishing Light', '3:15'),
(158, 75, 'Your Bedtime Story Is Scaring Everyone', '5:19'),
(159, 76, 'Disconnected', '3:37'),
(160, 76, 'Sleepless Again', '4:10'),
(162, 76, 'I\'m The Highway', '3:41'),
(163, 76, 'Delight And Angers', '3:39'),
(164, 76, 'Move Through Me', '3:06'),
(165, 76, 'The Chosen Pessimist', '8:14'),
(166, 76, 'Sober And Irrelevant', '3:22'),
(167, 76, 'Condemned', '3:34'),
(168, 76, 'Drenched In Fear', '3:30'),
(169, 76, 'March To The Shore', '3:28'),
(170, 76, 'Eraser', '3:20'),
(171, 76, 'Titlt', '3:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_album_album_meta1_idx` (`album_meta_id`);

--
-- Indexes for table `album_meta`
--
ALTER TABLE `album_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `album_meta`
--
ALTER TABLE `album_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_album_album_meta1` FOREIGN KEY (`album_meta_id`) REFERENCES `album_meta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `FK_songs_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
