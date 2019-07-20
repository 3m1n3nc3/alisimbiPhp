-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2019 at 06:41 PM
-- Server version: 5.7.26-0ubuntu0.19.04.1
-- PHP Version: 7.2.19-0ubuntu0.19.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `alisimbi`
--
CREATE DATABASE IF NOT EXISTS `alisimbi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `alisimbi`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answer` text,
  `question_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `correct` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `question_id`, `module_id`, `correct`) VALUES
(25, 'recently extending', 15, 10, '0'),
(26, 'encountered a situation', 15, 10, '1'),
(27, 'wanted to call a constructor', 15, 10, '0'),
(28, 'reference the class', 15, 10, '0'),
(29, 'Sint dolore', 16, 3, '0'),
(30, 'voluptate irure', 16, 3, '1'),
(31, 'nisi veniam aliquip', 16, 3, '0'),
(32, 'cupidatat anim', 16, 3, '0'),
(33, 'veniam aliquip', 17, 3, '0'),
(34, 'pariatur eu', 17, 3, '1'),
(35, 'aliquip nulla esse', 17, 3, '0'),
(36, 'labore occaecat', 17, 3, '0');

-- --------------------------------------------------------

--
-- Table structure for table `benefits`
--

CREATE TABLE `benefits` (
  `id` int(11) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `benefits`
--

INSERT INTO `benefits` (`id`, `title`, `icon`, `description`) VALUES
(1, 'transcript', 'file-pdf-o', 'Get a PDF transcript so you can study at your own pace.'),
(2, 'secured', 'shield', 'These course is hosted on our secure servers and your connection is encripted'),
(3, 'recognized', 'certificate', 'Get a certificate that is recognized by a lot of  organizations, and boost the quality of your CV besides showing that you are interested in learning'),
(4, 'videos', 'pause-circle', 'This course comes with a video so that you  can feel that connection with our instructors.');

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `language` varchar(128) NOT NULL DEFAULT 'default',
  `site_name` varchar(128) NOT NULL,
  `cleanurl` enum('0','1') NOT NULL DEFAULT '0',
  `data_limit` int(11) NOT NULL DEFAULT '15',
  `rave_public_key` varchar(128) DEFAULT NULL,
  `rave_private_key` varchar(128) DEFAULT NULL,
  `rave_mode` enum('0','1') NOT NULL DEFAULT '0',
  `currency` varchar(3) NOT NULL DEFAULT 'NGN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`language`, `site_name`, `cleanurl`, `data_limit`, `rave_public_key`, `rave_private_key`, `rave_mode`, `currency`) VALUES
('default', 'Alisimbi', '0', 15, NULL, NULL, '0', 'NGN');

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
  `benefits` varchar(128) DEFAULT NULL,
  `price` decimal(6,0) NOT NULL DEFAULT '0',
  `status` enum('0','1') DEFAULT '1',
  `start` datetime DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `intro`, `cover`, `badge`, `benefits`, `price`, `status`, `start`, `creator_id`) VALUES
(2, 'Building Fish Mazes', '<ol><li><strong>Lorem ipsum ut non ut quis amet </strong></li><li><strong>laborum do amet id </strong></li><li><strong>fugiat duis esse occaecat </strong></li><li><strong>dolore dolore eu anim nulla</strong></li></ol><p>nostrud mollit in in amet irure in veniam excepteur occaecat non dolor id sit incididunt aliqua fugiat tempor ullamco mollit excepteur magna veniam commodo tempor in mollit pariatur cupidatat anim minim consectetur consectetur fugiat qui aute ex laboris anim et quis in deserunt dolore ut est in magna magna <strong>duis voluptate</strong> do laboris do labore excepteur culpa amet magna irure aute consequat aute voluptate adipisicing excepteur laborum duis in esse non in minim dolore nulla adipisicing proident duis do laborum dolor dolore do fugiat dolore dolore id excepteur irure aute irure ut pariatur ut fugiat amet esse eiusmod quis quis et sed dolor tempor aliquip et dolore culpa excepteur consectetur anim veniam officia pariatur cillum aliquip consectetur adipisicing in in voluptate deserunt cupidatat ullamco amet excepteur cillum excepteur aliquip eu nisi aute dolor nostrud amet excepteur cillum ea commodo irure ad laborum nisi veniam laborum in in ad fugiat labore eu magna veniam quis sunt nisi esse irure consequat laborum eu minim esse ut nulla ut mollit cupidatat laboris dolor excepteur sunt laborum nisi laboris cupidatat ex non exercitation labore elit fugiat consequat esse mollit mollit occaecat duis tempor ut in cupidatat ut in eiusmod in mollit ad officia deserunt ad pariatur amet ad laborum qui ut irure laborum tempor nostrud veniam.</p>', '950921736_1696954136_1909978056_n.jpg', '590350285_32334601_123605503_n.png', 'transcript', '2', '1', '1970-01-01 01:01:00', 8),
(3, 'Building Egg crate', 'Fugiat tempor ullamco mollit excepteur magna veniam commodo tempor in mollit pariatur cupidatat anim minim consectetur consectetur fugiat qui aute ex laboris anim et quis in deserunt dolore ut est in magna magna duis voluptate do laboris do labore excepteur culpa amet magna irure aute consequat aute voluptate adipisicing excepteur laborum duis in esse non in minim dolore nulla adipisicing proident duis do laborum dolor dolore do fugiat dolore dolore id excepteur irure aute irure ut pariatur ut fugiat amet esse eiusmod quis quis et sed dolor tempor aliquip et dolore culpa excepteur consectetur anim veniam officia pariatur cillum aliquip consectetur adipisicing in in voluptate deserunt cupidatat ullamco amet excepteur cillum excepteur aliquip eu nisi aute dolor nostrud amet excepteur cillum ea commodo irure ad laborum nisi veniam laborum in in ad fugiat labore eu magna veniam quis sunt nisi esse irure consequat laborum eu minim esse ut nulla ut mollit cupidatat laboris dolor excepteur sunt laborum nisi laboris cupidatat ex non exercitation labore elit fugiat consequat esse mollit mollit occaecat duis tempor ut in cupidatat ut in eiusmod in mollit ad officia deserunt ad pariatur amet ad laborum qui ut irure laborum tempor nostrud veniam.', 'singer.jpg', '', 'transcript,recognized,recognized,videos', '0', '1', '1970-01-01 01:01:00', 8),
(7, 'How to build farm house', 'Tempor in aliquip qui nulla commodo anim ut sed duis sit ea id sit et nostrud mollit minim veniam irure labore dolor adipisicing dolor aute laborum commodo veniam aute commodo amet nisi aliqua exercitation do do.Tempor in aliquip qui nulla commodo anim ut sed duis sit ea id sit et nostrud mollit minim veniam irure labore dolor adipisicing dolor aute laborum commodo veniam aute commodo amet nisi aliqua exercitation do do.Tempor in aliquip qui nulla commodo anim ut sed duis sit ea id sit et nostrud mollit minim veniam irure labore dolor adipisicing dolor aute laborum commodo veniam aute commodo amet nisi aliqua exercitation do do.', '1466121137_1148508010_1028774394_n.jpg', '1781141897_1361286276_839619606_n.png', 'secured,videos', '0', '1', '2019-07-04 00:07:00', NULL),
(8, 'Egg production for farmers', 'Tempor in aliquip qui nulla commodo anim ut sed duis sit ea id sit et nostrud mollit minim veniam irure labore dolor adipisicing dolor aute laborum commodo veniam aute commodo amet nisi aliqua exercitation do do.Tempor in aliquip qui nulla commodo anim ut sed duis sit ea id sit et nostrud mollit minim veniam irure labore dolor adipisicing dolor aute laborum commodo veniam aute commodo amet nisi aliqua exercitation do do.Tempor in aliquip qui nulla commodo anim ut sed duis sit ea id sit et nostrud mollit minim veniam irure labore dolor adipisicing dolor aute laborum commodo veniam aute commodo amet nisi aliqua exercitation do do.', '1254775880_560650264_678827578_n.jpg', '70619917_575355390_459069905_n.png', ',test,placeholder', '0', '1', '2019-07-26 00:07:00', 8),
(9, 'Winning Big contests', 'Ea dolore enim do ea duis magna aliqua qui reprehenderit sit in laborum dolore dolore duis incididunt laboris dolor et ea quis voluptate exercitation reprehenderit irure ex voluptate magna.Ea dolore enim do ea duis magna aliqua qui reprehenderit sit in laborum dolore dolore duis incididunt laboris dolor et ea quis voluptate exercitation reprehenderit irure ex voluptate magna.Ea dolore enim do ea duis magna aliqua qui reprehenderit sit in laborum dolore dolore duis incididunt laboris dolor et ea quis voluptate exercitation reprehenderit irure ex voluptate magna.', '1381441986_1967678521_322549641_n.jpg', '1267971864_1508098222_1431329653_n.png', 'transcript,recognized,recognized,videos', '23', '1', '2019-07-11 00:07:00', NULL),
(10, 'In do pariatur elit eiusmod mollit exercitation anim ut mollit aliqua', 'In do pariatur elit eiusmod mollit exercitation anim ut mollit aliqua reprehenderit sunt aliquip et dolore velit in in est incididunt magna proident do ullamco dolore nostrud proident labore fugiat commodo cupidatat adipisicing proident ad consequat fugiat nostrud non commodo in eu veniam eu incididunt eiusmod irure irure officia excepteur sit anim mollit deserunt velit ut eiusmod in dolore anim occaecat do tempor veniam ut dolore magna non irure nisi ex elit officia magna velit laboris exercitation dolor occaecat enim ut proident', '87179062_243665097_326628346_n.jpg', '1681424921_803980159_778844034_n.png', 'transcript,secured,recognized,videos', '0', '1', '1970-01-01 01:01:00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `course_access`
--

CREATE TABLE `course_access` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_module` int(11) DEFAULT NULL,
  `completed` varchar(250) DEFAULT NULL,
  `time_spent` int(11) NOT NULL DEFAULT '0',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_access`
--

INSERT INTO `course_access` (`id`, `course_id`, `user_id`, `current_module`, `completed`, `time_spent`, `reg_date`) VALUES
(9, 3, 8, 6, '2,6', 11, '2019-07-19 17:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `course_modules`
--

CREATE TABLE `course_modules` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_modules`
--

INSERT INTO `course_modules` (`id`, `course_id`, `module_id`) VALUES
(30, 3, 6),
(31, 3, 2),
(33, 2, 12),
(34, 2, 10),
(35, 2, 3),
(36, 10, 12),
(37, 10, 7);

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
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `course_id`, `user_id`) VALUES
(1, 3, 8),
(2, 3, 9),
(3, 8, 8),
(4, 10, 8),
(5, 2, 4),
(6, 2, 8),
(7, 7, 4),
(8, 7, 9),
(9, 10, 9),
(10, 10, 4),
(12, 3, 4),
(13, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `cover` varchar(128) DEFAULT NULL,
  `video` varchar(128) DEFAULT NULL,
  `intro` text NOT NULL,
  `transcript` text,
  `badge` varchar(128) DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT '1',
  `creator_id` int(11) DEFAULT NULL,
  `secure_code` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `title`, `cover`, `video`, `intro`, `transcript`, `badge`, `duration`, `creator_id`, `secure_code`) VALUES
(1, 'Grazing Goals', 'cows.jpg', '1234.mp4', ' esse  enim amet duis adipisicing non nisi minim ullamco ut ut in et voluptate adipisicing cillum ut elit aliquip do ut ', 'Elit nisi elit esse minim consectetur nostrud anim velit amet duis amet esse  enim amet duis adipisicing non nisi minim ullamco ut ut in et voluptate adipisicing cillum ut elit aliquip do ut ', '', 5, 4, NULL),
(2, 'Plant selection', 'here.jpg', '1235.mp4', 'deserunt in aliquip veniam enim tempor sunt ut nulla in sunt aliqua incididunt ', 'ad aliquip aliquip deserunt in aliquip veniam enim tempor sunt ut nulla in sunt aliqua incididunt aute irure sed in pariatur excepteur dolor tempor pariatur fugiat ad dolor dolore ut tempor nostrud et id duis consectetur incididunt dolore tempor dolor id ex nisi pariatur do veniam velit sed nulla ut reprehenderit occaecat sed ut. ', '', 6, 9, NULL),
(3, 'Growing Bigger crops', '1635170479_376140385_816286088_n.jpg', '1234.mp4', 'consectetur nostrud anim velit amet duis amet', 'Esse minim consectetur nostrud anim velit amet duis amet esse  enim amet duis adipisicing non nisi minim ullamco ut ut in et voluptate adipisicing cillum ut elit aliquip do ut', '877068376_290509973_1549788050_n.png', 5, 8, NULL),
(4, 'Singular System', 'here.jpg', '1235.mp4', 'pariatur excepteur dolor tempor pariatur fugiat ad dolor dolore', '  aute irure sed in pariatur excepteur dolor tempor pariatur fugiat ad dolor dolore ut tempor nostrud et id duis consectetur incididunt dolore tempor dolor id ex nisi pariatur do veniam velit sed nulla ut reprehenderit occaecat sed ut. ', '', 6, 4, NULL),
(5, 'Simple Work', 'obj.jpg', '1234.mp4', 'veniam excepteur do sed incididunt mollit in enim amet et est aliquip', 'laboris veniam excepteur do sed incididunt mollit in enim amet et est aliquip pariatur in mollit quis culpa consectetur consectetur culpa elit in in fugiat cillum fugiat aute aute esse ad minim aute eiusmod laboris voluptate', '', 4, 9, NULL),
(6, 'Social Farming', 'cows.jpg', '1234.mp4', 'amet duis adipisicing non nisi minim ullamco ut ut in et voluptate adipisicing ', 'et esse  enim amet duis adipisicing non nisi minim ullamco ut ut in et voluptate adipisicing cillum ut elit aliquip do ut  Elit nisi elit esse minim consectetur nostrud anim velit amet duis am', '', 5, 8, NULL),
(7, 'Owning Multiple Lands', 'cows.jpg', '1234.mp4', 'incididunt nulla amet magna culpa dolore minim consectetur reprehenderi', 'eiusmod incididunt nulla amet magna culpa dolore minim consectetur reprehenderit in id in aute aliqua laborum laborum in voluptate enim aute dolor cillum duis do veniam esse occaecat deserunt consequat ', '', 22, 8, NULL),
(8, 'Salivating Cows milk', 'obj.jpg', '1234.mp4', 'veniam excepteur do sed incididunt mollit in enim amet', 'laboris veniam excepteur do sed incididunt mollit in enim amet et est aliquip pariatur in mollit quis culpa consectetur consectetur culpa elit in in fugiat cillum fugiat aute aute esse ad minim aute eiusmod laboris voluptate', '', 4, 9, NULL),
(9, 'Growing Faster', '466251843_2131297300_732634645_n.jpg', NULL, 'Sunt do in dolor officia ullamco sunt sunt ut est voluptate et elit duis cillum nulla laborum id tempor dolore dolore non ut veniam qui sunt irure anim ad non quis adipisicing sint reprehenderit exercitation esse consequat anim aute fugiat officia dolore voluptate in et sunt dolore nisi cupidatat excepteur', 'Sunt do in dolor officia ullamco sunt sunt ut est voluptate et elit duis cillum nulla laborum id tempor dolore dolore non ut veniam qui sunt irure anim ad non quis adipisicing sint reprehenderit exercitation esse consequat anim aute fugiat officia dolore voluptate in et sunt dolore nisi cupidatat excepteur est labore eiusmod minim velit enim exercitation sit commodo consectetur velit laboris dolor dolor dolor veniam minim dolore adipisicing magna fugiat dolore nisi voluptate consequat commodo sunt voluptate ut labore sunt ut dolor cillum nulla occaecat ut consectetur nulla exercitation laboris voluptate qui laborum officia pariatur sunt nisi amet officia aliqua ut veniam culpa irure velit id quis deserunt laborum sit elit ut aliquip et voluptate aute ullamco veniam dolor enim commodo do excepteur commodo in id dolore adipisicing in incididunt incididunt laboris et dolore commodo duis nisi do in nisi aliqua laborum sit commodo officia ut aliquip cupidatat in ex sunt ut do ex eu eiusmod esse aute esse pariatur mollit eu sint laborum aliqua non in nulla elit dolore sunt in voluptate eiusmod enim culpa velit eu.', '585601809_1728100493_1574795546_n.png', 5, 4, NULL),
(10, 'Subtle way in', '1239738311_25007336_812689415_n.jpg', 'https://www.youtube.com/embed/tgbNymZ7vqYf', 'Qui laborum sit exercitation excepteur commodo ad magna exercitation labore eiusmod in mollit elit nisi adipisicing esse aliqua ut eiusmod incididunt fugiat sit adipisicing sunt tempor aute veniam esse amet eiusmod nulla officia esse deserunt duis magna culpa labore in est non nisi duis commodo nulla cillum', '<p>Qui laborum sit exercitation excepteur commodo ad magna exercitation labore eiusmod in mollit elit nisi adipisicing esse aliqua ut eiusmod incididunt fugiat sit adipisicing sunt tempor aute veniam esse amet eiusmod nulla officia esse deserunt duis magna culpa labore in est non nisi duis commodo nulla cillum dolor sunt officia exercitation commodo cupidatat pariatur commodo fugiat dolor voluptate labore eu ea sunt nisi officia dolore duis dolor eu occaecat minim exercitation excepteur in ut incididunt dolor exercitation ut dolor ut qui aliquip esse minim cupidatat ut incididunt id ut nostrud anim est enim officia dolore nulla irure tempor sed nisi sunt voluptate deserunt do exercitation pariatur exercitation ex in labore veniam exercitation sit labore et aliqua consectetur nisi eiusmod qui eiusmod magna pariatur officia ut quis nisi labore ut aute velit velit adipisicing sed proident do ex ut fugiat magna commodo non aute est esse nulla nisi ex dolor enim excepteur laborum consectetur culpa amet aute esse qui cupidatat ex irure eiusmod dolore duis non elit amet officia officia est quis proident cillum non dolor cupidatat officia consequat elit ut enim nisi aliquip non reprehenderit duis dolore sed tempor cupidatat veniam enim ullamco ut enim irure dolore labore duis.</p>', '507064966_735836057_410694_n.png', 21, 8, 'a36d22309be74e86657d421c66e9fec1'),
(11, 'Growing Faster with speed', '872541950_1631821693_1614954296_n.jpg', NULL, 'Lorem ipsum magna eiusmod in occaecat magna dolore quis ea exercitation elit commodo aliquip elit pariatur quis do sunt eu ullamco eu exercitation amet aliquip tempor adipisicing mollit ex do dolor nostrud culpa eiusmod sit culpa dolore sed deserunt aliquip eu.', 'Dolor sint velit nisi deserunt deserunt irure magna sint magna in fugiat duis enim eu excepteur adipisicing aliquip eu in occaecat ut mollit irure aute velit ex nisi non sint culpa aliquip aliquip pariatur in aliquip id consequat exercitation do anim ut laboris nulla anim officia cillum proident fugiat duis eiusmod laborum ad ut ea occaecat adipisicing labore et cillum excepteur do irure anim amet eu occaecat tempor ex incididunt fugiat reprehenderit laborum occaecat sed sed non ad in cillum nulla elit sit amet et culpa velit deserunt sint in sed in ea labore ex pariatur mollit laboris consequat ea sunt sint in nulla deserunt occaecat sunt incididunt do culpa proident sed ut in minim in elit incididunt dolore sit qui ex nostrud in minim ut amet dolor minim adipisicing magna nisi enim sint elit.', '994855119_1041962009_1288335880_n.png', 21, 8, NULL),
(12, 'Salvation for the animals', '1126235064_694408361_1269459394_n.jpg', '1972153517_671281916_v.mp4', 'Mollit consequat anim anim commodo et aliquip minim mollit dolore incididunt consectetur deserunt qui culpa in nostrud aliquip qui in pariatur dolore velit minim reprehenderit incididunt deserunt do culpa est dolor ex incididunt et aute ut et exercitation nostrud id aliquip ut aute cupidatat aute cillum in officia exercitation excepteur duis laborum exercitation esse culpa ea aliquip sed aliqua aliqua tempor', 'Mollit consequat anim anim commodo et aliquip minim mollit dolore incididunt consectetur deserunt qui culpa in nostrud aliquip qui in pariatur dolore velit minim reprehenderit incididunt deserunt do culpa est dolor ex incididunt et aute ut et exercitation nostrud id aliquip ut aute cupidatat aute cillum in officia exercitation excepteur duis laborum exercitation esse culpa ea aliquip sed aliqua aliqua tempor do in irure non labore ullamco dolor velit dolor reprehenderit voluptate dolor magna ut excepteur amet enim aliqua excepteur dolore enim fugiat dolor ullamco in dolore in ex in dolor anim nostrud ex reprehenderit eiusmod amet culpa ut duis irure qui minim proident velit nostrud dolore mollit excepteur ea sint enim consectetur sed nostrud veniam excepteur ut sint anim proident ad commodo nisi culpa enim mollit adipisicing in veniam anim aliqua sunt qui anim magna velit cupidatat in ea enim dolor pariatur labore anim esse dolor cillum enim sint velit aliqua amet nostrud mollit nulla esse officia ullamco id nisi tempor.\r\nMollit consequat anim anim commodo et aliquip minim mollit dolore incididunt consectetur deserunt qui culpa in nostrud aliquip qui in pariatur dolore velit minim reprehenderit incididunt deserunt do culpa est dolor ex incididunt et aute ut et exercitation nostrud id aliquip ut aute cupidatat aute cillum in officia exercitation excepteur duis laborum exercitation esse culpa ea aliquip sed aliqua aliqua tempor do in irure non labore ullamco dolor velit dolor reprehenderit voluptate dolor magna ut excepteur amet enim aliqua excepteur dolore enim fugiat dolor ullamco in dolore in ex in dolor anim nostrud ex reprehenderit eiusmod amet culpa ut duis irure qui minim proident velit nostrud dolore mollit excepteur ea sint enim consectetur sed nostrud veniam excepteur ut sint anim proident ad commodo nisi culpa enim mollit adipisicing in veniam anim aliqua sunt qui anim magna velit cupidatat in ea enim dolor pariatur labore anim esse dolor cillum enim sint velit aliqua amet nostrud mollit nulla esse officia ullamco id nisi tempor.', '1351121296_395472417_901397762_n.png', 20, 2, '2f8d7569839249d697b1015cd5206a80');

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
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text,
  `module_id` int(11) DEFAULT NULL,
  `correct` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `module_id`, `correct`) VALUES
(15, 'This assumes that the user_rol, cod_office combination is a primary key. If only one of these is the PK, then add the other field to the UPDATE list. If neither of them is a primary key (that seems unlikely) then this approach will always create new records - probably not what is wanted.\r\n\r\nHowever, this approach makes prepared statements easier to build and more concise.', 10, '3'),
(16, 'Sint dolore et sed ullamco cupidatat anim officia deserunt minim quis excepteur velit veniam nisi eiusmod do labore irure cillum nisi magna ex cupidatat adipisicing eiusmod nisi sed adipisicing nulla et mollit officia proident ex magna aute sit et ad aute voluptate irure minim id ut elit laborum excepteur voluptate irure nostrud nisi veniam aliquip', 3, '3'),
(17, 'minim dolor incididunt dolore voluptate mollit nisi eiusmod exercitation officia dolor pariatur labore veniam aliquip nulla esse nisi magna ut nostrud quis sed minim sint irure ut sunt in aliqua ea nisi ut ad non labore occaecat consectetur reprehenderit cupidatat pariatur eu consequat magna exercitation proident consequat in ad ullamco elit dolore adipisicing proident quis quis sed esse nisi elit mollit labore non culpa ut duis anim et tempor laborum nostrud commodo nostrud ut ut minim consectetur aliqua sit et labore magna non aliquip fugiat adipisicing eu pariatur id dolor dolor aute occaecat commodo et ut.', 3, '4');

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
  `facebook` varchar(128) DEFAULT NULL,
  `twitter` varchar(128) DEFAULT NULL,
  `instagram` varchar(128) DEFAULT NULL,
  `f_name` varchar(128) DEFAULT NULL,
  `l_name` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `about` text,
  `role` enum('learner','teacher','mod','admin','sudo') NOT NULL DEFAULT 'learner',
  `rating` int(11) NOT NULL DEFAULT '0',
  `token` varchar(128) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `facebook`, `twitter`, `instagram`, `f_name`, `l_name`, `photo`, `city`, `state`, `country`, `about`, `role`, `rating`, `token`, `date`) VALUES
(4, 'david', '28f20a02bf8a021fab4fcec48afb584e', 'mygames.ng@gmail.com', '3333', NULL, NULL, NULL, 'David', 'Geer', 'cows.jpg', 'Balakan', 'Saki', 'Azerbaijan', 'sssss', 'learner', 0, '478bf19e77d5c61d2f73dc02a6775e6f', '2019-07-08 06:25:16'),
(8, 'marxemi', '28f20a02bf8a021fab4fcec48afb584e', 'marxemi@yahoo.com', '3333', 'ssssssss', 'sssss', 'sssssss', 'Marxemi', 'John', 'obj.jpg', 'Kaduna', 'Waikato', 'New Zealand', 'Lorem ipsum ut non ut quis amet laborum do amet id fugiat duis esse occaecat dolore dolore eu anim nulla nostrud mollit in in amet irure in veniam excepteur occaecat non dolor id sit incididunt aliqua...', 'learner', 3, '9b8746b1df8e7f3f3b16e14151f6efbd', '2019-07-08 11:27:45'),
(9, 'qqqq', '0dc015b3f305f10d9a8bb68b625cdfea', 'qqqq@dd.gg', NULL, NULL, NULL, NULL, 'qqqqq', 'qqqqq', 'drinkmilk.jpg', 'Abovyan', 'Kotaik', 'Armenia', 'Anim nulla nostrud mollit in in amet irure in veniam excepteur occaecat non dolor id sit incididunt aliqua Lorem ipsum ut non ut quis amet laborum do amet id fugiat duis esse occaecat dolore dolore eu.', 'learner', 0, '8967eafbca151e55526712b84e49cd67', '2019-07-11 03:06:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_id` (`question_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `course_access`
--
ALTER TABLE `course_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homer`
--
ALTER TABLE `homer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
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
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `module_id` (`module_id`);

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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `course_access`
--
ALTER TABLE `course_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `course_modules`
--
ALTER TABLE `course_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `homer`
--
ALTER TABLE `homer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
