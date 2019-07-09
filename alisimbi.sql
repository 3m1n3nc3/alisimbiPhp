-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2019 at 11:17 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `alisimbi`
--
CREATE DATABASE IF NOT EXISTS `alisimbi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `alisimbi`;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `language` varchar(128) NOT NULL DEFAULT 'default',
  `site_name` varchar(128) NOT NULL,
  `cleanurl` enum('0','1') NOT NULL DEFAULT '0',
  `data_limit` int(11) NOT NULL DEFAULT '15'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`language`, `site_name`, `cleanurl`, `data_limit`) VALUES
('default', 'Alisimbi', '0', 15);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `c_line` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `facebook` varchar(128) NOT NULL,
  `twitter` varchar(128) NOT NULL,
  `instagram` varchar(128) NOT NULL,
  `youtube` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `c_line`, `address`, `email`, `phone`, `facebook`, `twitter`, `instagram`, `youtube`) VALUES
(1, 'Alisimbi Limited', 'Office Address: 69 Old Ring Road, Off Apico House, Abak Road, Uyo.', 'info.alisimbi@gmail.com', '08180391130', 'alisimbi', 'alisimbi_agric', 'alisimbi', '1hhiu121213123');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `intro` text,
  `cover` varchar(128) DEFAULT NULL,
  `badge` varchar(128) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '1',
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `intro`, `cover`, `badge`, `status`, `start`) VALUES
(1, 'Farming in rural settlements', 'Occaecat quis ut sed officia laboris non incididunt officia eu in et nulla magna dolore duis occaecat aliqua velit labore ut nulla laborum tempor voluptate ex eu aliquip in proident tempor consectetur mollit ullamco velit dolor laborum non enim ex mollit eu amet aliqua quis est quis dolor deserunt nulla in voluptate amet incididunt id do in do qui ea laborum nostrud irure est pariatur minim nisi do cillum dolor non ad incididunt cillum mollit reprehenderit pariatur dolore qui pariatur dolor proident sint aliquip ut sunt in duis in nisi culpa ex proident est est dolor sed pariatur dolor velit officia elit id magna id enim quis ut voluptate ut minim irure aliquip aute mollit velit nulla ad mollit ea eu laborum reprehenderit deserunt in amet deserunt anim in deserunt officia voluptate proident culpa pariatur dolore sit nisi est exercitation dolore tempor sint anim laborum ullamco sint magna voluptate sed enim consectetur duis excepteur do culpa exercitation ullamco tempor culpa ullamco nostrud incididunt fugiat laborum in esse ut labore nostrud in fugiat reprehenderit labore ut tempor non deserunt tempor fugiat in quis proident esse occaecat esse amet elit ullamco pariatur aute id non qui officia ut officia qui.', 'obj.jpg', '', '1', '2019-07-17 08:28:11'),
(2, 'Building Fish Mazes', 'Lorem ipsum ut non ut quis amet laborum do amet id fugiat duis esse occaecat dolore dolore eu anim nulla nostrud mollit in in amet irure in veniam excepteur occaecat non dolor id sit incididunt aliqua fugiat tempor ullamco mollit excepteur magna veniam commodo tempor in mollit pariatur cupidatat anim minim consectetur consectetur fugiat qui aute ex laboris anim et quis in deserunt dolore ut est in magna magna duis voluptate do laboris do labore excepteur culpa amet magna irure aute consequat aute voluptate adipisicing excepteur laborum duis in esse non in minim dolore nulla adipisicing proident duis do laborum dolor dolore do fugiat dolore dolore id excepteur irure aute irure ut pariatur ut fugiat amet esse eiusmod quis quis et sed dolor tempor aliquip et dolore culpa excepteur consectetur anim veniam officia pariatur cillum aliquip consectetur adipisicing in in voluptate deserunt cupidatat ullamco amet excepteur cillum excepteur aliquip eu nisi aute dolor nostrud amet excepteur cillum ea commodo irure ad laborum nisi veniam laborum in in ad fugiat labore eu magna veniam quis sunt nisi esse irure consequat laborum eu minim esse ut nulla ut mollit cupidatat laboris dolor excepteur sunt laborum nisi laboris cupidatat ex non exercitation labore elit fugiat consequat esse mollit mollit occaecat duis tempor ut in cupidatat ut in eiusmod in mollit ad officia deserunt ad pariatur amet ad laborum qui ut irure laborum tempor nostrud veniam.', 'here.jpg', '', '1', '2019-07-25 04:32:11'),
(3, 'Building Egg crate', 'Fugiat tempor ullamco mollit excepteur magna veniam commodo tempor in mollit pariatur cupidatat anim minim consectetur consectetur fugiat qui aute ex laboris anim et quis in deserunt dolore ut est in magna magna duis voluptate do laboris do labore excepteur culpa amet magna irure aute consequat aute voluptate adipisicing excepteur laborum duis in esse non in minim dolore nulla adipisicing proident duis do laborum dolor dolore do fugiat dolore dolore id excepteur irure aute irure ut pariatur ut fugiat amet esse eiusmod quis quis et sed dolor tempor aliquip et dolore culpa excepteur consectetur anim veniam officia pariatur cillum aliquip consectetur adipisicing in in voluptate deserunt cupidatat ullamco amet excepteur cillum excepteur aliquip eu nisi aute dolor nostrud amet excepteur cillum ea commodo irure ad laborum nisi veniam laborum in in ad fugiat labore eu magna veniam quis sunt nisi esse irure consequat laborum eu minim esse ut nulla ut mollit cupidatat laboris dolor excepteur sunt laborum nisi laboris cupidatat ex non exercitation labore elit fugiat consequat esse mollit mollit occaecat duis tempor ut in cupidatat ut in eiusmod in mollit ad officia deserunt ad pariatur amet ad laborum qui ut irure laborum tempor nostrud veniam.', 'singer.jpg', '', '1', '2019-07-25 04:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `homer`
--

CREATE TABLE `homer` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `intro` varchar(128) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homer`
--

INSERT INTO `homer` (`id`, `title`, `intro`, `description`) VALUES
(1, 'Welcome to Alisimbi', 'The future of Agribusiness.', 'Learn relevant agribusiness skills and get matched to markets and funding opportunities to grow your business.  START HERE…');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `cover` int(128) NOT NULL,
  `video` int(128) NOT NULL,
  `transcript` text NOT NULL,
  `badge` varchar(128) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `link` varchar(128) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `content`, `link`, `date`, `state`) VALUES
(1, 'How we built the big farm', 'here.jpg', 'Dolore tempor duis laboris sit veniam in in et dolor in mollit non ullamco aliqua fugiat cupidatat in velit irure voluptate quis eu aliqua cupidatat pariatur ea sit nisi deserunt irure in velit laboris nostrud laboris mollit minim do do ullamco fugiat pariatur minim fugiat excepteur labore reprehenderit voluptate minim exercitation aute ullamco laborum amet deserunt reprehenderit aute esse tempor laboris nulla adipisicing dolor dolor cillum nulla elit commodo incididunt ad dolor nostrud ut ad proident in elit est ut culpa non non aute tempor dolor in anim irure laborum ut in minim sit qui aute quis magna amet magna dolore consectetur commodo nostrud velit minim incididunt duis labore ex deserunt cillum deserunt amet ea in consequat adipisicing amet nostrud aliqua anim nostrud enim sit duis aute do elit ut eiusmod consectetur do sint sed minim dolore duis reprehenderit aliqua quis exercitation esse enim quis in adipisicing aliqua dolor nisi tempor do commodo dolor voluptate culpa do est commodo ex minim ex pariatur in ullamco commodo qui ut officia proident laborum cillum adipisicing sed non dolore fugiat exercitation elit dolore occaecat minim minim nisi culpa in do laborum deserunt elit voluptate ea magna qui nisi tempor ullamco cillum anim voluptate cupidatat magna mollit velit tempor amet laboris qui consectetur commodo officia duis elit ut laborum ea esse sit nostrud excepteur tempor fugiat sunt ea eiusmod pariatur id ut elit nulla irure cillum ut sunt nisi commodo dolore tempor in occaecat in laboris tempor sunt aute cupidatat eu elit consectetur consequat id qui sint reprehenderit quis adipisicing duis culpa.', 'big-farm', '2019-07-05 16:55:29', '1'),
(2, 'The singer who planted corns', 'singer.jpg', 'Dolore tempor duis laboris sit veniam in in et dolor in mollit non ullamco aliqua fugiat cupidatat in velit irure voluptate quis eu aliqua cupidatat pariatur ea sit nisi deserunt irure in velit laboris nostrud laboris mollit minim do do ullamco fugiat pariatur minim fugiat excepteur labore reprehenderit voluptate minim exercitation aute ullamco laborum amet deserunt reprehenderit aute esse tempor laboris nulla adipisicing dolor dolor cillum nulla elit commodo incididunt ad dolor nostrud ut ad proident in elit est ut culpa non non aute tempor dolor in anim irure laborum ut in minim sit qui aute quis magna amet magna dolore consectetur commodo nostrud velit minim incididunt duis labore ex deserunt cillum deserunt amet ea in consequat adipisicing amet nostrud aliqua anim nostrud enim sit duis aute do elit ut eiusmod consectetur do sint sed minim dolore duis reprehenderit aliqua quis exercitation esse enim quis in adipisicing aliqua dolor nisi tempor do commodo dolor voluptate culpa do est commodo ex minim ex pariatur in ullamco commodo qui ut officia proident laborum cillum adipisicing sed non dolore fugiat exercitation elit dolore occaecat minim minim nisi culpa in do laborum deserunt elit voluptate ea magna qui nisi tempor ullamco cillum anim voluptate cupidatat magna mollit velit tempor amet laboris qui consectetur commodo officia duis elit ut laborum ea esse sit nostrud excepteur tempor fugiat sunt ea eiusmod pariatur id ut elit nulla irure cillum ut sunt nisi commodo dolore tempor in occaecat in laboris tempor sunt aute cupidatat eu elit consectetur consequat id qui sint reprehenderit quis adipisicing duis culpa.', 'corrn-singer', '2019-07-05 16:55:29', '1'),
(3, 'What people said about obasanjo farms', 'obj.jpg', 'Dolore tempor duis laboris sit veniam in in et dolor in mollit non ullamco aliqua fugiat cupidatat in velit irure voluptate quis eu aliqua cupidatat pariatur ea sit nisi deserunt irure in velit laboris nostrud laboris mollit minim do do ullamco fugiat pariatur minim fugiat excepteur labore reprehenderit voluptate minim exercitation aute ullamco laborum amet deserunt reprehenderit aute esse tempor laboris nulla adipisicing dolor dolor cillum nulla elit commodo incididunt ad dolor nostrud ut ad proident in elit est ut culpa non non aute tempor dolor in anim irure laborum ut in minim sit qui aute quis magna amet magna dolore consectetur commodo nostrud velit minim incididunt duis labore ex deserunt cillum deserunt amet ea in consequat adipisicing amet nostrud aliqua anim nostrud enim sit duis aute do elit ut eiusmod consectetur do sint sed minim dolore duis reprehenderit aliqua quis exercitation esse enim quis in adipisicing aliqua dolor nisi tempor do commodo dolor voluptate culpa do est commodo ex minim ex pariatur in ullamco commodo qui ut officia proident laborum cillum adipisicing sed non dolore fugiat exercitation elit dolore occaecat minim minim nisi culpa in do laborum deserunt elit voluptate ea magna qui nisi tempor ullamco cillum anim voluptate cupidatat magna mollit velit tempor amet laboris qui consectetur commodo officia duis elit ut laborum ea esse sit nostrud excepteur tempor fugiat sunt ea eiusmod pariatur id ut elit nulla irure cillum ut sunt nisi commodo dolore tempor in occaecat in laboris tempor sunt aute cupidatat eu elit consectetur consequat id qui sint reprehenderit quis adipisicing duis culpa.', 'obasanjo-farms', '2019-07-05 16:55:29', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `company` varchar(128) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `image`, `company`, `description`) VALUES
(1, 'Ogorchukwu Ovunda', 'ground-logs.jpg', 'Power Machines Limited', 'Eu veniam labore sed id nulla aliquip dolore laborum est pariatur occaecat elit tempor aliqua dolore nisi mollit id eu ut amet in laborum in excepteur dolor.'),
(2, 'Singer Orodu', 'drinkmilk.jpg', 'Newnify Music Limited', 'Sunt quis quis nisi ad ex amet mollit incididunt aliqua in ea est deserunt ut aliqua commodo occaecat incididunt consequat ad.');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `organisation` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `organisation`, `image`, `content`) VALUES
(1, 'Davidson John', 'Intel', 'drinkmilk.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo'),
(2, 'Godwin Amaowoh', 'Facebook Inc', 'here.jpg', 'consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(3, 'Daniel Obi', 'Microsoft Corp', 'obj.jpg', 'Sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `link` varchar(128) NOT NULL,
  `video` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `title`, `content`, `link`, `video`, `image`, `date`, `state`) VALUES
(1, 'How to make money selling crops', 'Ut reprehenderit ut non minim ut amet commodo irure voluptate ea aute aliqua eu tempor dolore aute enim non nisi in reprehenderit aute incididunt minim consectetur laborum cupidatat ad proident sit sed eu amet dolore incididunt consequat culpa dolore minim nostrud commodo culpa cupidatat anim pariatur aliqua commodo elit nulla magna consectetur sed dolor dolore cillum sit irure dolore labore ut ut ut voluptate ullamco mollit dolore ullamco quis esse officia fugiat consequat enim dolore aute officia aliquip ad aliqua nostrud pariatur officia cillum nisi consectetur ut aliqua deserunt laborum fugiat excepteur nisi minim ut nulla qui sit eiusmod eiusmod culpa sint aliqua tempor irure veniam voluptate eu anim labore pariatur ut amet id id labore sunt sit qui nostrud dolor velit laborum velit id occaecat voluptate duis elit ut culpa mollit laboris veniam labore non aliqua dolore dolor sit est aute in ea consectetur deserunt ullamco est proident cillum esse ad fugiat cillum.', 'selling-crops', 'https://www.youtube.com/embed/9YffrCViTVk', '', '2019-07-06 13:33:18', '1'),
(2, 'How to drink milk', 'In labore eiusmod non adipisicing aliqua sed anim fugiat id eu sit commodo id culpa dolor ea cillum aliqua voluptate consequat ex ut quis id labore adipisicing magna enim sint excepteur tempor sunt eiusmod ad ad non in non amet veniam irure occaecat eiusmod elit in pariatur ullamco ut et duis irure duis ullamco adipisicing cillum ea qui consequat laborum officia enim ex duis exercitation minim reprehenderit deserunt reprehenderit dolore dolor elit nostrud sunt fugiat pariatur anim pariatur cupidatat adipisicing voluptate velit consequat duis reprehenderit anim et occaecat proident officia esse occaecat irure consequat dolor elit sit ut est dolore irure officia do fugiat adipisicing laboris consectetur cillum in eu ex fugiat laborum magna culpa quis est irure qui veniam cupidatat minim elit aliquip mollit ut ullamco mollit do labore ea consectetur ut quis in incididunt laboris et do sint incididunt adipisicing ullamco elit dolore commodo sit labore do ea ullamco elit minim deserunt minim aute in ad.', 'drink-milk', '1234.mp4', 'drinkmilk.jpg', '2019-07-06 13:33:18', '1'),
(3, 'how to build groud logs', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'ground-logs', '1235.mp4', 'ground-logs.jpg', '2019-07-06 13:33:18', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(128) DEFAULT NULL,
  `f_name` varchar(128) DEFAULT NULL,
  `l_name` varchar(128) DEFAULT NULL,
  `photo` varchar(11) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `about` text,
  `role` enum('learner','teacher','mod','admin','sudo') NOT NULL DEFAULT 'learner',
  `token` varchar(128) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `f_name`, `l_name`, `photo`, `city`, `state`, `country`, `about`, `role`, `token`, `date`) VALUES
(4, 'david', '28f20a02bf8a021fab4fcec48afb584e', 'mygames.ng@gmail.com', '3333', 'David', 'Geer', NULL, 'Balakan', 'Saki', 'Azerbaijan', 'sssss', 'learner', '478bf19e77d5c61d2f73dc02a6775e6f', '2019-07-08 06:25:16'),
(8, 'marxemi', '28f20a02bf8a021fab4fcec48afb584e', 'marxemi@yahoo.com', '3333', 'Marxemi', 'John', NULL, 'Kaduna', 'Kaduna', 'Nigeria', 'Shake', 'admin', '9b8746b1df8e7f3f3b16e14151f6efbd', '2019-07-08 11:27:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homer`
--
ALTER TABLE `homer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `homer`
--
ALTER TABLE `homer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;