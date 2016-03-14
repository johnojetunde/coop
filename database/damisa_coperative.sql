-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2015 at 06:37 PM
-- Server version: 5.5.16
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `damisa_coperative`
--
CREATE DATABASE `damisa_coperative` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `damisa_coperative`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_level` varchar(255) NOT NULL,
  `logged_in` varchar(10) NOT NULL,
  `timestamp` int(50) NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `fullname`, `username`, `password`, `access_level`, `logged_in`, `timestamp`) VALUES
(1, 'Ojetunde John', 'johndoe', '0fd8c26c13833ef05bf899958f0b41c2', 'manager', 'true', 1417494770),
(2, 'Isaiah', 'makanbi', '0fd8c26c13833ef05bf899958f0b41c2', 'manager', 'true', 1417525732);

-- --------------------------------------------------------

--
-- Table structure for table `applied_loan`
--

CREATE TABLE IF NOT EXISTS `applied_loan` (
  `appl_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`appl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bf`
--

CREATE TABLE IF NOT EXISTS `bf` (
  `bf_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `year` varchar(10) NOT NULL,
  `month` varchar(10) NOT NULL,
  `bf_amount` double NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`bf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `drafts`
--

CREATE TABLE IF NOT EXISTS `drafts` (
  `draftsid` int(10) NOT NULL AUTO_INCREMENT,
  `drafter_username` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`draftsid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `drafts`
--

INSERT INTO `drafts` (`draftsid`, `drafter_username`, `subject`, `message`, `attachment`, `flag`, `timestamp`) VALUES
(5, 'john', 'Adeyemo Miss', 'T&lt;b&gt;his is miss adeyemo&#039;s place&lt;/b&gt;', '', 0, 1418422573),
(6, 'john', 'Draft Attachment', 'Save it as a draft attachment', '1418483047.zip', 0, 1418483047),
(7, 'john', 'My SUbject Mail', 'Save it as draft', '', 0, 1426037736);

-- --------------------------------------------------------

--
-- Table structure for table `frei_banned_users`
--

CREATE TABLE IF NOT EXISTS `frei_banned_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frei_chat`
--

CREATE TABLE IF NOT EXISTS `frei_chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `from_name` varchar(30) NOT NULL,
  `to` int(11) NOT NULL,
  `to_name` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  `time` double(15,4) NOT NULL,
  `GMT_time` bigint(20) NOT NULL,
  `message_type` int(11) NOT NULL DEFAULT '0',
  `room_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `frei_chat`
--

INSERT INTO `frei_chat` (`id`, `from`, `from_name`, `to`, `to_name`, `message`, `sent`, `recd`, `time`, `GMT_time`, `message_type`, `room_id`) VALUES
(1, 1426192764, 'Guest-adg', 1426049411, 'john', 'helo john', '2015-03-07 10:59:19', 1, 14257259590.4254, 1425722359089, 0, -1),
(2, 1426049411, 'Guest-acs7', 1426192764, 'Guest-adg', 'how are you bro', '2015-03-07 10:59:30', 1, 14257259700.4551, 1425722370377, 0, -1),
(3, 1426049411, 'Guest-acs7', 1426152355, 'john', 'helo', '2015-03-07 11:00:45', 1, 14257260450.5670, 1425722445464, 0, -1),
(4, 1425856170, 'Guest-1qz6', 1425870962, 'john', 'helo', '2015-03-07 11:11:40', 1, 14257267000.9341, 1425723100785, 0, -1),
(5, 1425856170, 'silas', 1425870962, 'john', 'hw far', '2015-03-07 11:14:09', 1, 14257268490.6267, 1425723249449, 0, -1),
(6, 1425870962, 'john', 1425856170, 'silas', 'i dey wella', '2015-03-07 11:14:37', 0, 14257268770.1326, 1425723276964, 0, -1),
(7, 1425903852, 'Guest-ah3w', 1426058581, 'silas', 'abik', '2015-03-07 12:31:55', 1, 14257315150.3885, 1425727914951, 0, -1),
(8, 1426058581, 'silas', 1425903852, 'Guest-ah3w', 'helo', '2015-03-07 12:32:34', 1, 14257315540.8213, 1425727954743, 0, -1),
(9, 1426058581, 'silas', 1425903852, 'Guest-ah3w', 'helo', '2015-03-07 12:33:13', 1, 14257315930.6454, 1425727993479, 0, -1),
(10, 1426058581, 'silas', 1425903852, 'john', 'hey', '2015-03-07 12:33:55', 1, 14257316350.8741, 1425728035566, 0, -1),
(11, 1425903852, 'Guest-ah3w', 1426058581, 'silas', 'yea', '2015-03-07 12:34:08', 1, 14257316480.1048, 1425728047970, 0, -1),
(12, 1425903852, 'Guest-ah3w', 1426058581, 'silas', 'helo', '2015-03-07 12:43:57', 1, 14257322380.0295, 1425728637568, 0, -1),
(13, 1426058581, 'silas', 1425903852, 'john', 'this is johndoe', '2015-03-07 12:44:09', 1, 14257322490.3498, 1425728649220, 0, -1),
(14, 1425903852, 'Guest-ah3w', 1426058581, 'silas', 'hw far everything', '2015-03-07 12:44:26', 1, 14257322660.2201, 1425728665865, 0, -1),
(15, 1426058581, 'silas', 1425903852, 'john', 'yea yea', '2015-03-07 12:44:32', 1, 14257322720.5917, 1425728672303, 0, -1),
(16, 1426168242, 'silas', 1425903852, 'john', 'brother john', '2015-03-07 12:46:32', 1, 14257323920.0531, 1425728791846, 0, -1),
(17, 1425903852, 'Guest-ah3w', 1426168242, 'silas', 'i dey aburo', '2015-03-07 12:46:44', 1, 14257324040.2572, 1425728803927, 0, -1),
(22, 1425880969, 'john', 1426168242, 'silas', '<img id="smile__1426168242" src="http://localhost/lms/freichat/client/themes/smileys/smile54593.gif" alt="smile" />', '2015-03-07 12:48:12', 1, 14257324920.8701, 1425728892561, 0, -1),
(21, 1425880969, 'john', 1426168242, 'silas', 'helo', '2015-03-07 12:48:07', 1, 14257324870.8055, 1425728887192, 0, -1),
(23, 1426168242, 'silas', 1425880969, 'john', 'this is new', '2015-03-07 12:48:24', 1, 14257325050.0844, 1425728904422, 0, -1),
(24, 1426168242, 'silas', 1425880969, 'john', 'why are you enjoying this new way of working wonder', '2015-03-07 12:48:35', 1, 14257325150.8332, 1425728915242, 0, -1),
(25, 1426157632, 'john', 1426466588, 'Admin-john', 'helo&#44; mr admin person', '2015-03-10 13:52:31', 1, 14259955510.8865, 1425991951643, 0, -1),
(26, 1426157632, 'john', 1426466588, 'Admin-john', 'I want you to help me out here', '2015-03-10 13:52:38', 1, 14259955580.0871, 1425991957707, 0, -1),
(27, 1426157632, 'john', 1426466588, 'Admin-john', 'please check my system out', '2015-03-10 13:52:44', 1, 14259955640.4409, 1425991964210, 0, -1),
(28, 1426157632, 'john', 1426466588, 'Admin-john', 'it is not working well', '2015-03-10 13:52:53', 1, 14259955730.8980, 1425991973754, 0, -1),
(29, 1426466588, 'Admin-john', 1426157632, 'john', 'good', '2015-03-10 13:53:06', 1, 14259955860.9919, 1425991986604, 0, -1),
(30, 1426466588, 'Admin-john', 1426157632, 'john', 'I am going to appreciate the things you are doing<br/>', '2015-03-10 13:53:15', 1, 14259955950.9495, 1425991995673, 0, -1),
(31, 1426157632, 'john', 1426466588, 'Admin-john', 'alryt', '2015-03-10 13:53:29', 1, 14259956090.7029, 1425992008627, 0, -1),
(32, 1426466588, 'Admin-john', 1426157632, 'john', 'great', '2015-03-10 13:53:41', 1, 14259956210.9533, 1425992021695, 0, -1),
(33, 1426466588, 'Admin-john', 1426157632, 'john', 'this is just the beginning', '2015-03-10 13:53:48', 1, 14259956280.4468, 1425992028338, 0, -1),
(34, 1426157632, 'john', 1426466588, 'Admin-john', 'alryt', '2015-03-10 13:54:01', 1, 14259956410.5642, 1425992041303, 0, -1),
(35, 1426466588, 'Admin-john', 1426157632, 'john', 'good', '2015-03-10 13:54:31', 1, 14259956710.3395, 1425992071165, 0, -1),
(36, 1426157632, 'john', 1426466588, 'Admin-john', 'great', '2015-03-10 13:56:46', 1, 14259958060.6108, 1425992206165, 0, -1),
(37, 1426466588, 'Admin-john', 1426157632, 'john', 'ryt', '2015-03-10 13:57:05', 1, 14259958250.0294, 1425992224525, 0, -1),
(38, 1426466588, 'Admin-john', 1426157632, 'john', 'brother', '2015-03-10 14:14:38', 1, 14259968790.0080, 1425993278381, 0, -1),
(39, 1426157632, 'john', 1426466588, 'Admin-john', 'owkay', '2015-03-10 14:14:50', 1, 14259968900.4470, 1425993290073, 0, -1),
(40, 1426157632, 'john', 3, '3', '<span style="color:#00ff00"><span style=''color:#00ff00''>hwlo</span></span>', '2015-03-10 15:54:33', 1, 14260028730.8286, 1425999273385, 1, 3),
(41, 1426279185, 'Guest-aeb', 1, '1', '<span style="color:grey"><span style=''color:grey''>helo</span></span>', '2015-03-10 19:28:20', 1, 14260157000.5702, 1426012100270, 1, 1),
(42, 1426426805, 'john', 1426174716, 'Admin-john', 'brother', '2015-03-10 19:33:15', 1, 14260159950.0978, 1426012394883, 0, -1),
(43, 1426174716, 'Admin-john', 1426426805, 'john', 'helo', '2015-03-10 19:33:26', 1, 14260160060.9711, 1426012406430, 0, -1),
(44, 1426174716, 'Admin-john', 1426426805, 'john', 'helo', '2015-03-10 19:34:09', 1, 14260160490.7092, 1426012448892, 0, -1),
(45, 1426174716, 'Admin-john', 1426426805, 'john', 'oga o', '2015-03-10 19:34:12', 1, 14260160520.3510, 1426012451809, 0, -1),
(46, 1426426805, 'john', 1426174716, 'Admin-john', 'great', '2015-03-10 19:34:18', 1, 14260160580.1372, 1426012457545, 0, -1),
(47, 1426426805, 'john', 3, '3', '<span style="color:#00ff00"><span style=''color:#00ff00''>brother mi</span></span>', '2015-03-10 19:34:28', 1, 14260160680.3834, 1426012468108, 1, 3),
(48, 1426174716, 'Admin-john', 3, '3', '<span style="color:grey"><span style=''color:grey''>egbon</span></span>', '2015-03-10 19:34:55', 1, 14260160950.6713, 1426012495387, 1, 3),
(49, 1426426805, 'john', 3, '3', '<span style="color:#00ff00"><span style=''color:#00ff00''>helo</span></span>', '2015-03-10 19:36:23', 1, 14260161830.6365, 1426012583182, 1, 3),
(50, 1426174716, 'Admin-john', 3, '3', 'File uploaded: <a target=\\''_blank\\'' href=http://localhost/rlms/freichat/client/plugins/upload/download.php?filename=1426016438205.png>29.png</a>', '2015-03-10 19:40:38', 1, 14260164390.0110, 1426016439, 1, 3),
(51, 1426174716, 'Admin-john', 3, '3', '<span style="color:grey"><span style=''color:grey''>great</span></span>', '2015-03-10 19:41:03', 1, 14260164630.3903, 1426012862955, 1, 3),
(52, 1426426805, 'john', 3, '3', '<span style="color:#00ff00"><span style=''color:#00ff00''>thanks</span></span>', '2015-03-10 19:41:41', 1, 14260165010.0392, 1426012900882, 1, 3),
(53, 1426174716, 'Admin-john', 5, '5', '<span style="color:grey"><span style=''color:grey''>helo</span></span>', '2015-03-10 19:48:17', 1, 14260168970.2943, 1426013295971, 1, 5),
(54, 1426426805, 'john', 5, '5', '<span style="color:#000000"><span style=''color:#000000''>make it</span></span>', '2015-03-10 19:49:10', 1, 14260169500.1282, 1426013349988, 1, 5),
(55, 1426174716, 'Admin-john', 5, '5', '<span style="color:grey"><span style=''color:grey''>javascript:void(0)</span></span>', '2015-03-10 19:49:21', 1, 14260169610.7966, 1426013361279, 1, 5),
(56, 1426174716, 'Admin-john', 1426426805, 'john', 'File uploaded: <a target=\\''_blank\\'' href=http://localhost/rlms/freichat/client/plugins/upload/download.php?filename=142601713551.pdf>Olumide.pdf</a>', '2015-03-10 19:52:15', 1, 14260171350.1321, 1426017135, 0, -1),
(57, 1426426805, 'john', 1426174716, 'Admin-john', 'great', '2015-03-10 19:52:26', 1, 14260171460.7169, 1426013546474, 0, -1),
(58, 1426174716, 'Admin-john', 1426426805, 'john', 'awesome', '2015-03-10 19:52:41', 1, 14260171610.9764, 1426013561404, 0, -1),
(59, 1426426805, 'john', 1426172334, 'Admin-john', 'helo', '2015-03-10 20:02:34', 1, 14260177540.4783, 1426014153838, 0, -1),
(60, 1426426805, 'john', 1426172334, 'Admin-john', 'users', '2015-03-10 20:02:44', 1, 14260177640.6872, 1426014164527, 0, -1),
(61, 1426172334, 'Admin-john', 1426426805, 'john', 'great', '2015-03-10 20:03:04', 1, 14260177850.0073, 1426014184753, 0, -1),
(62, 1426426805, 'john', 1426249305, 'Admin-johndoe', 'brother john', '2015-03-11 03:21:04', 1, 14260440640.7265, 1426040464544, 0, -1),
(63, 1426426805, 'john', 1426249305, 'Admin-johndoe', 'how are you today<br/>', '2015-03-11 03:21:17', 1, 14260440770.4829, 1426040477304, 0, -1),
(64, 1426249305, 'Admin-johndoe', 1426426805, 'john', 'great bro', '2015-03-11 03:21:30', 1, 14260440900.2585, 1426040489180, 0, -1),
(65, 1426426805, 'john', 1426249305, 'Admin-johndoe', 'good', '2015-03-11 03:21:52', 1, 14260441120.7209, 1426040512419, 0, -1),
(66, 1426461391, 'john', 1426167005, 'Admin-johndoe', 'helo', '2015-03-11 05:33:06', 1, 14260483860.9478, 1426044785793, 0, -1),
(67, 1426504323, 'john', 1426461749, 'Admin-johndoe', 'helo', '2015-03-11 05:42:29', 1, 14260489490.1316, 1426045348792, 0, -1),
(68, 1426461749, 'Admin-johndoe', 1426504323, 'john', 'hey', '2015-03-11 05:42:35', 1, 14260489550.6911, 1426045354908, 0, -1),
(81, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'brother', '2015-03-11 12:42:26', 1, 14260741460.4922, 1426070546360, 0, -1),
(80, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'File uploaded: <a target=\\''_blank\\'' href=http://localhost/rlms/freichat/client/plugins/upload/download.php?filename=1426074121319.pdf>Cost_Estimation.pdf</a>', '2015-03-11 12:42:01', 1, 14260741210.9602, 1426074121, 0, -1),
(79, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'adebola', '2015-03-11 12:39:21', 1, 14260739610.7229, 1426070361348, 0, -1),
(78, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'helo<br/>', '2015-03-11 12:39:18', 1, 14260739580.0957, 1426070357445, 0, -1),
(77, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'this is on the portal', '2015-03-11 12:22:10', 1, 14260729300.0571, 1426069329867, 0, -1),
(76, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'helo', '2015-03-11 12:22:06', 1, 14260729260.6585, 1426069323397, 0, -1),
(82, 1426218006, 'john', 1426267344, 'Admin-johndoe', 'yea yea', '2015-03-11 12:42:29', 1, 14260741490.7342, 1426070549318, 0, -1),
(83, 1426502230, 'Admin-johndoe', 1426460609, 'john', 'brotherhood', '2015-03-11 18:32:38', 1, 14260951580.0953, 1426091557600, 0, -1),
(84, 1426460609, 'john', 1426502230, 'Admin-johndoe', '<img id="smile__1426502230" src="http://localhost/rlms/freichat/client/themes/smileys/wink54827.gif" alt="smile" />', '2015-03-11 18:32:57', 1, 14260951770.8168, 1426091577628, 0, -1),
(85, 1426502230, 'Admin-johndoe', 1426460609, 'john', 'File uploaded: <a target=\\''_blank\\'' href=http://localhost/rlms/freichat/client/plugins/upload/download.php?filename=1426095285250.pdf>Cost_Estimation.pdf</a>', '2015-03-11 18:34:45', 1, 14260952850.7996, 1426095285, 0, -1),
(86, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'hey', '2015-03-12 17:01:25', 1, 14261760850.1795, 1426172484825, 0, -1),
(87, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'how are you', '2015-03-12 17:01:42', 1, 14261761020.2700, 1426172502055, 0, -1),
(88, 1426430304, 'babatunde', 1426600403, 'Admin-johndoe', 'good', '2015-03-12 17:01:53', 1, 14261761130.7574, 1426172492551, 0, -1),
(89, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'File uploaded: <a target=\\''_blank\\'' href=http://localhost/rlms/freichat/client/plugins/upload/download.php?filename=142617619673.png>ORBI-MAIN.png</a>', '2015-03-12 17:03:16', 1, 14261761970.0127, 1426176197, 0, -1),
(90, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'xup', '2015-03-12 17:11:24', 1, 14261766840.9388, 1426173084762, 0, -1),
(91, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'i see you in there', '2015-03-12 17:11:33', 1, 14261766930.6295, 1426173093487, 0, -1),
(92, 1426430304, 'babatunde', 1426600403, 'john', 'k', '2015-03-12 17:12:08', 1, 14261767280.4011, 1426173107459, 0, -1),
(93, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'i better get to work', '2015-03-12 17:12:14', 1, 14261767340.8780, 1426173134715, 0, -1),
(94, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'I check ur right hnd corner', '2015-03-12 17:12:25', 1, 14261767450.7430, 1426173145371, 0, -1),
(95, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'left hand*', '2015-03-12 17:12:34', 1, 14261767540.5564, 1426173154272, 0, -1),
(96, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'corner of the page', '2015-03-12 17:12:39', 1, 14261767590.6713, 1426173159493, 0, -1),
(97, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'you will see a chat room', '2015-03-12 17:12:44', 1, 14261767640.6769, 1426173164548, 0, -1),
(98, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'hanging up there', '2015-03-12 17:12:49', 1, 14261767690.9829, 1426173169763, 0, -1),
(99, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'chilling mode', '2015-03-12 17:12:55', 1, 14261767750.8821, 1426173175633, 0, -1),
(100, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'enter the room talk to me', '2015-03-12 17:13:32', 1, 14261768120.2393, 1426173211321, 0, -1),
(101, 1426600403, 'Admin-johndoe', 4, '4', '<span style="color:#000000"><span style=''color:#000000''>i am here</span></span>', '2015-03-12 17:13:43', 1, 14261768230.2844, 1426173222994, 1, 4),
(102, 1426600403, 'Admin-johndoe', 4, '4', '<span style="color:#000000"><span style=''color:#000000''>waiting</span></span>', '2015-03-12 17:13:47', 1, 14261768270.3437, 1426173227000, 1, 4),
(103, 1426430304, 'babatunde', 4, '4', '<span style="color:grey"><span style=''color:grey''>k</span></span>', '2015-03-12 17:13:47', 1, 14261768270.4340, 1426173206316, 1, 4),
(104, 1426430304, 'babatunde', 4, '4', '<span style="color:grey"><span style=''color:grey''>hi</span></span>', '2015-03-12 17:13:49', 1, 14261768290.9003, 1426173208854, 1, 4),
(105, 1426600403, 'Admin-johndoe', 4, '4', '<span style="color:#0000ff"><span style=''color:#0000ff''>i have a color blue</span></span>', '2015-03-12 17:14:02', 1, 14261768420.0458, 1426173241473, 1, 4),
(106, 1426600403, 'Admin-johndoe', 4, '4', '<span style="color:#0000ff"><span style=''color:#0000ff''>as my text color</span></span>', '2015-03-12 17:14:06', 1, 14261768460.4207, 1426173246123, 1, 4),
(107, 1426600403, 'Admin-johndoe', 4, '4', '<span style="color:#0000ff"><span style=''color:#0000ff''>this is the small chops we manage</span></span>', '2015-03-12 17:14:27', 1, 14261768670.8072, 1426173267150, 1, 4),
(108, 1426430304, 'babatunde', 4, '4', '<span style="color:grey"><span style=''color:grey''>great job</span></span>', '2015-03-12 17:14:42', 1, 14261768820.8751, 1426173261953, 1, 4),
(109, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'talk to you later. I have to go out nw. I am going to log out nw and have this server down. We will feel it more tomorrow.', '2015-03-12 17:15:09', 1, 14261769090.9322, 1426173309733, 0, -1),
(110, 1426600403, 'Admin-johndoe', 1426430304, 'babatunde', 'I am waiting for your response', '2015-03-12 17:15:18', 1, 14261769180.3622, 1426173317576, 0, -1),
(111, 1426430304, 'babatunde', 1426600403, 'Admin-johndoe', 'k', '2015-03-12 17:15:28', 1, 14261769280.1866, 1426173307118, 0, -1),
(112, 1426430304, 'babatunde', 1426600403, 'Admin-johndoe', 'no p', '2015-03-12 17:15:30', 1, 14261769300.8025, 1426173309728, 0, -1),
(113, 1428365092, 'john', 1428301508, 'victor', 'helo mr man', '2015-04-02 16:56:16', 1, 14279901760.5179, 1427986576275, 0, -1),
(114, 1428365092, 'john', 1428301508, 'victor', 'how are you ooo', '2015-04-02 16:56:20', 1, 14279901800.6662, 1427986580447, 0, -1),
(115, 1428301508, 'victor', 1428365092, 'john', 'alryt', '2015-04-02 16:57:22', 1, 14279902420.9536, 1427986642598, 0, -1),
(116, 1428301508, 'victor', 1428365092, 'john', 'i know', '2015-04-02 16:57:24', 1, 14279902440.8536, 1427986644492, 0, -1),
(117, 1428157429, 'john', 1428301508, 'kayode', 'helo', '2015-04-03 11:37:25', 1, 14280574450.1964, 1428053844869, 0, -1),
(118, 1428301508, 'kayode', 1428157429, 'john', 'hi', '2015-04-03 11:38:14', 1, 14280574940.9301, 1428053893274, 0, -1),
(119, 1428443469, 'john', 1428361352, 'kayode', 'helo', '2015-04-03 12:48:24', 1, 14280617040.7907, 1428058103846, 0, -1),
(120, 1428443469, 'john', 1428361352, 'kayode', 'How are you', '2015-04-03 12:48:29', 1, 14280617090.8605, 1428058109662, 0, -1),
(121, 1428361352, 'kayode', 1428443469, 'john', 'but I am here', '2015-04-03 12:48:41', 1, 14280617210.2520, 1428058117511, 0, -1),
(122, 1428343886, 'Admin-johndoe', 1428399137, 'kayode', 'helo', '2015-04-03 13:35:33', 1, 14280645330.8935, 1428060933576, 0, -1),
(123, 1428343886, 'Admin-johndoe', 1428541177, 'kayode', 'helo', '2015-04-03 13:52:28', 1, 14280655480.6329, 1428061948407, 0, -1),
(124, 1428343886, 'Admin-johndoe', 1428541177, 'kayode', 'thyis is the film', '2015-04-03 13:52:33', 1, 14280655530.2430, 1428061952785, 0, -1),
(125, 1428343886, 'Admin-johndoe', 1428541177, 'kayode', 'yes ppppp', '2015-04-03 13:52:36', 1, 14280655560.8439, 1428061956574, 0, -1),
(126, 1428350098, 'Guest-1qn0', 1428255300, 'kayode', 'helo', '2015-04-03 14:24:39', 1, 14280674790.9543, 1428063879864, 0, -1),
(127, 1428255300, 'kayode', 1428350098, 'Guest-1qn0', 'hi sir', '2015-04-03 14:24:50', 1, 14280674900.5559, 1428063890295, 0, -1),
(128, 1428255300, 'kayode', 1428343886, 'Admin-johndoe', 'helo', '2015-04-03 14:25:09', 0, 14280675090.3837, 1428063909185, 0, -1),
(129, 1428255300, 'kayode', 1428343886, 'Admin-johndoe', 'this is for the admin', '2015-04-03 14:25:12', 0, 14280675120.5470, 1428063912333, 0, -1),
(130, 1430326101, 'Admin-johndoe', 1430308740, 'john', 'helo bro', '2015-04-28 00:32:29', 1, 14301775490.3869, 1430173949242, 0, -1),
(131, 1430308740, 'john', 1430326101, 'Admin-johndoe', 'yea', '2015-04-28 00:32:47', 1, 14301775670.4841, 1430173967340, 0, -1);

-- --------------------------------------------------------

--
-- Table structure for table `frei_config`
--

CREATE TABLE IF NOT EXISTS `frei_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(30) DEFAULT 'NULL',
  `cat` varchar(20) DEFAULT 'NULL',
  `subcat` varchar(20) DEFAULT 'NULL',
  `val` varchar(500) DEFAULT 'NULL',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `frei_config`
--

INSERT INTO `frei_config` (`id`, `key`, `cat`, `subcat`, `val`) VALUES
(1, 'PATH', 'NULL', 'NULL', 'freichat/'),
(2, 'show_name', 'NULL', 'NULL', 'guest'),
(3, 'displayname', 'NULL', 'NULL', 'username'),
(4, 'chatspeed', 'NULL', 'NULL', '5000'),
(5, 'fxval', 'NULL', 'NULL', 'true'),
(6, 'draggable', 'NULL', 'NULL', 'enable'),
(7, 'conflict', 'NULL', 'NULL', ''),
(8, 'msgSendSpeed', 'NULL', 'NULL', '1000'),
(9, 'show_avatar', 'NULL', 'NULL', 'block'),
(10, 'debug', 'NULL', 'NULL', 'false'),
(11, 'freichat_theme', 'NULL', 'NULL', 'basic'),
(12, 'lang', 'NULL', 'NULL', 'english'),
(13, 'load', 'NULL', 'NULL', 'show'),
(14, 'time', 'NULL', 'NULL', '7'),
(15, 'JSdebug', 'NULL', 'NULL', 'false'),
(16, 'busy_timeOut', 'NULL', 'NULL', '500'),
(17, 'offline_timeOut', 'NULL', 'NULL', '1000'),
(18, 'cache', 'NULL', 'NULL', 'enabled'),
(19, 'GZIP_handler', 'NULL', 'NULL', 'ON'),
(20, 'plugins', 'file_sender', 'show', 'true'),
(21, 'plugins', 'file_sender', 'file_size', '2000'),
(22, 'plugins', 'file_sender', 'expiry', '300'),
(23, 'plugins', 'file_sender', 'valid_exts', 'jpeg,jpg,png,gif,zip,pdf'),
(24, 'plugins', 'send_conv', 'show', 'true'),
(25, 'plugins', 'send_conv', 'mailtype', 'smtp'),
(26, 'plugins', 'send_conv', 'smtp_server', 'smtp.gmail.com'),
(27, 'plugins', 'send_conv', 'smtp_port', '465'),
(28, 'plugins', 'send_conv', 'smtp_protocol', 'ssl'),
(29, 'plugins', 'send_conv', 'from_address', 'you@domain.com'),
(30, 'plugins', 'send_conv', 'from_name', 'E-Library Chat'),
(31, 'playsound', 'NULL', 'NULL', 'true'),
(32, 'ACL', 'filesend', 'user', 'allow'),
(33, 'ACL', 'filesend', 'guest', 'noallow'),
(34, 'ACL', 'chatroom', 'user', 'allow'),
(35, 'ACL', 'chatroom', 'guest', 'allow'),
(36, 'ACL', 'mail', 'user', 'allow'),
(37, 'ACL', 'mail', 'guest', 'allow'),
(38, 'ACL', 'save', 'user', 'allow'),
(39, 'ACL', 'save', 'guest', 'allow'),
(40, 'ACL', 'smiley', 'user', 'allow'),
(41, 'ACL', 'smiley', 'guest', 'allow'),
(42, 'polling', 'NULL', 'NULL', 'disabled'),
(43, 'polling_time', 'NULL', 'NULL', '30'),
(44, 'link_profile', 'NULL', 'NULL', 'disabled'),
(46, 'sef_link_profile', 'NULL', 'NULL', 'disabled'),
(47, 'plugins', 'chatroom', 'location', 'bottom'),
(48, 'plugins', 'chatroom', 'autoclose', 'true'),
(49, 'content_height', 'NULL', 'NULL', '200px'),
(50, 'chatbox_status', 'NULL', 'NULL', 'false'),
(51, 'BOOT', 'NULL', 'NULL', 'yes'),
(52, 'exit_for_guests', 'NULL', 'NULL', 'no'),
(53, 'plugins', 'chatroom', 'offset', '50px'),
(54, 'plugins', 'chatroom', 'label_offset', '0.8%'),
(55, 'addedoptions_visibility', 'NULL', 'NULL', 'HIDDEN'),
(56, 'ug_ids', 'NULL', 'NULL', ''),
(57, 'ACL', 'chat', 'user', 'allow'),
(58, 'ACL', 'chat', 'guest', 'allow'),
(59, 'plugins', 'chatroom', 'override_positions', 'yes'),
(60, 'ACL', 'video', 'user', 'allow'),
(61, 'ACL', 'video', 'guest', 'allow'),
(62, 'ACL', 'chatroom_crt', 'user', 'allow'),
(63, 'ACL', 'chatroom_crt', 'guest', 'noallow'),
(64, 'plugins', 'chatroom', 'chatroom_expiry', '3600'),
(65, 'chat_time_shown_always', 'NULL', 'NULL', 'no'),
(66, 'allow_guest_name_change', 'NULL', 'NULL', 'yes'),
(67, 'ACL', 'groupchat', 'user', 'allow'),
(68, 'ACL', 'groupchat', 'guest', 'noallow');

-- --------------------------------------------------------

--
-- Table structure for table `frei_groupchat`
--

CREATE TABLE IF NOT EXISTS `frei_groupchat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `group_author` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `group_created` int(11) NOT NULL,
  `group_participants` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `frei_rooms`
--

CREATE TABLE IF NOT EXISTS `frei_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_author` varchar(100) NOT NULL,
  `room_name` varchar(200) NOT NULL,
  `room_type` tinyint(4) NOT NULL,
  `room_password` varchar(100) NOT NULL,
  `room_created` int(11) NOT NULL,
  `room_last_active` int(11) NOT NULL,
  `room_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_name` (`room_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `frei_rooms`
--

INSERT INTO `frei_rooms` (`id`, `room_author`, `room_name`, `room_type`, `room_password`, `room_created`, `room_last_active`, `room_order`) VALUES
(1, 'admin', 'Fun Talk', 0, '', 1373557250, 1426015700, 1),
(2, 'admin', 'Crazy chat', 0, '', 1373557260, 1373557260, 5),
(3, 'admin', 'Think out loud', 0, '', 1373557872, 1426016501, 2),
(4, 'admin', 'Talk to me ', 0, '', 1373558017, 1426176882, 3),
(5, 'admin', 'Talk innovative', 1, 'damilaregrace', 1373558039, 1426016961, 4);

-- --------------------------------------------------------

--
-- Table structure for table `frei_session`
--

CREATE TABLE IF NOT EXISTS `frei_session` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `time` int(100) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `permanent_id` int(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `status_mesg` varchar(100) NOT NULL,
  `guest` tinyint(3) NOT NULL,
  `in_room` int(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permanent_id` (`permanent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `frei_session`
--

INSERT INTO `frei_session` (`id`, `username`, `time`, `session_id`, `permanent_id`, `status`, `status_mesg`, `guest`, `in_room`) VALUES
(67, 'Admin-johndoe', 1431613742, '1430326101', 1430326101, 1, 'Call me later', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `frei_smileys`
--

CREATE TABLE IF NOT EXISTS `frei_smileys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `frei_smileys`
--

INSERT INTO `frei_smileys` (`id`, `symbol`, `image_name`) VALUES
(1, ':S', 'worried55231.gif'),
(2, '(wasntme)', 'itwasntme55198.gif'),
(3, 'x(', 'angry55174.gif'),
(4, '(doh)', 'doh55146.gif'),
(5, '|-()', 'yawn55117.gif'),
(6, ']:)', 'evilgrin55088.gif'),
(7, '|(', 'dull55062.gif'),
(8, '|-)', 'sleepy55036.gif'),
(9, '(blush)', 'blush54981.gif'),
(10, ':P', 'tongueout54953.gif'),
(11, '(:|', 'sweat54888.gif'),
(12, ';(', 'crying54854.gif'),
(13, ':)', 'smile54593.gif'),
(14, ':(', 'sad54749.gif'),
(15, ':D', 'bigsmile54781.gif'),
(16, '8)', 'cool54801.gif'),
(17, ':o', 'wink54827.gif'),
(18, '(mm)', 'mmm55255.gif'),
(19, ':x', 'lipssealed55304.gif');

-- --------------------------------------------------------

--
-- Table structure for table `frei_video_session`
--

CREATE TABLE IF NOT EXISTS `frei_video_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL COMMENT 'unique room id',
  `from_id` int(11) NOT NULL,
  `msg_type` varchar(10) NOT NULL,
  `msg_label` int(2) NOT NULL,
  `msg_data` varchar(3000) NOT NULL,
  `msg_time` decimal(15,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frei_webrtc`
--

CREATE TABLE IF NOT EXISTS `frei_webrtc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frm_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `participants_id` int(11) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `imageData` longblob NOT NULL,
  `imageType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `inboxid` int(10) NOT NULL AUTO_INCREMENT,
  `sender_username` varchar(255) NOT NULL,
  `sender_fullname` varchar(255) NOT NULL,
  `receiver_username` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`inboxid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`inboxid`, `sender_username`, `sender_fullname`, `receiver_username`, `subject`, `message`, `attachment`, `flag`, `timestamp`) VALUES
(2, 'john', 'Ojetunde John Oluwadamilare', 'damilare', 'This is A test', 'This is a test email to whoever sees it. Please kindly reply with care.', '', 0, 1418348231),
(5, 'john', 'Ojetunde John Oluwadamilare', 'damilare', 'My project progress', 'This is with an attachment. Kindly check the attachment and download it for your personal usage.', '1418348375.docx', 0, 1418348375),
(6, 'john', 'Ojetunde John Oluwadamilare', 'adu', 'My project progress', 'This is with an attachment. Kindly check the attachment and download it for your personal usage.', '1418348375.docx', 0, 1418348375),
(7, 'john', 'Ojetunde John Oluwadamilare', 'john', 'Training of Saved Message', 'This is a test of the number of pages this thing can load per time.', '', 0, 1418419053),
(9, 'john', 'Ojetunde John Oluwadamilare', 'john', 'Training of Saved Message', 'This is a test of the number of pages this thing can load per time.', '', 0, 1418419066),
(11, 'john', 'Ojetunde John Oluwadamilare', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419130),
(17, 'john', 'Ojetunde John Oluwadamilare', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419171),
(20, 'john', 'Ojetunde John Oluwadamilare', 'adu', 'To Adu', 'From junk testing the send worker', '', 1, 1418432446),
(21, 'adu', 'Adu Oluwatobi', 'john', 'Check up Messages', 'This is a check up message to my own personal account', '1418481567.jpg', 1, 1418481567),
(22, 'adu', 'Adu Oluwatobi', 'ife', 'Check up Messages', 'This is a check up message to my own personal account', '1418481567.jpg', 1, 1418481567),
(23, 'john', 'Ojetunde John Oluwadamilare', 'adu', 'Draft Attachment', 'Save it as a draft attachment', '1418483047.zip', 1, 1418483973),
(25, 'john', 'Ojetunde John Oluwadamilare', 'adu', 'Saved Function Draft', 'Save it as a draft message', '', 0, 1418484123),
(26, 'john', 'Ojetunde John Oluwadamilare', 'john', 'Adeyemo Miss', 'T&lt;b&gt;his is miss adeyemo&#039;s place&lt;/b&gt;', '', 1, 1418484144),
(27, 'john', 'Ojetunde John Oluwadamilare', 'johndoe', 'Saved Function Draft', 'Save it as a draft message', '', 1, 1418484408),
(28, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'john', 'Project Submission', 'Make sure you see me on the 13th of December, 2014.', '', 1, 1418686636),
(29, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'john', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 1, 1418689681),
(31, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'john', 'Request Rejected!', 'Dr. Ojetunde John Oluwadamilare has rejected you as his/her project student, contact the project coordinator for more details', '', 0, 1418691605),
(36, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. Your project topic is <nl2br><b>Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\nCase Study: Student Union, University of Ibadan</b></nl2br> You can now proceed with your project work', '', 1, 1418719612),
(37, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'roy', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 1, 1418726922),
(38, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'roy', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. Your project topic is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 1, 1418727001),
(39, 'roy', 'Faniyi Olarotimi', 'johndoe', 'Chapter One', 'Here is attached my chapter one', '1418727112.pdf', 1, 1418727134),
(41, 'roy', 'Faniyi Olarotimi', 'adu', 'Chapter One', 'Here is attached my chapter one', '1418727112.pdf', 0, 1418727134),
(42, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'roy', 'Reply- Chapter One', 'next time send me a word document so that I can help you edit it.', '', 0, 1418727281),
(43, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'roy', 'Request Rejected!', 'Dr. Ojetunde John Oluwadamilare has rejected you as his/her project student, contact the project coordinator for more details', '', 1, 1418727593),
(44, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'roy', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418727797),
(45, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'ife', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 1, 1418728206),
(46, 'johndoe', 'Faniyi Olarotimi', 'roy', 'Project Topic Approved!', 'The Project coordinator has approved your project topic. Your project topic is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418742723),
(47, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has approved the project topic <b><nl2br>()</nl2br></b> of one of your students (Faniyi Olarotimi)  ', '', 1, 1418742723),
(48, 'johndoe', 'Faniyi Olarotimi', 'roy', 'Project Topic Disapproved!', 'The Project coordinator has disapproved your project topic, which is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418743219),
(49, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has Disapproved the project topic <b><nl2br>(An Online adaptive collaborative support system)</nl2br></b> of one of your students (Faniyi Olarotimi)  ', '', 1, 1418743219),
(50, 'johndoe', 'Faniyi Olarotimi', 'roy', 'Project Topic Approved!', 'The Project coordinator has approved your project topic. Your project topic is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418743306),
(51, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has approved the project topic <b><nl2br>(An Online adaptive collaborative support system)</nl2br></b> of one of your students (Faniyi Olarotimi)  ', '', 1, 1418743306),
(53, 'johndoe', 'Dr. Ojetunde John Oluwadamilare', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has approved the project topic <b><nl2br>(Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\nCase Study: Student Union, University of Ibadan)</nl2br></b> of one of your students (Ojetunde John Oluwadamilare)  ', '', 1, 1418743361),
(54, 'john', 'Ojetunde John', 'babatunde', 'My mailing System', 'This is my own mailing system. Enjoy it.', '1426176552.pdf', 1, 1426176552),
(55, 'johndoe', 'Ojetunde John', 'john', 'Loan Declination!', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', '', 0, 1428255239),
(56, 'johndoe', 'Ojetunde John', 'john', 'Loan Declination!', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', '', 1, 1428255310),
(57, 'johndoe', 'Ojetunde John', 'john', 'Loan Declination!', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', '', 0, 1428255600),
(58, 'johndoe', 'Ojetunde John', 'john', 'Loan Approval!', 'Your Loan of category Emergency of &#8358 100000 has been approved by the administrator', '', 0, 1428262512),
(59, 'johndoe', 'Ojetunde John', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 2000 payment on your behalf for your Emergency loan', '', 1, 1428268227),
(60, 'john', '', 'john', 'Loan Payment', 'Admin johndoe has made &#8358 generated monthly ledger and 40000 payment on your behalf for your  loan via monthly payback', '', 0, 1430077377),
(61, 'john', 'Ojetunde John', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and  payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430077771),
(62, 'john', 'Ojetunde John', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430078061),
(63, 'john', 'Ojetunde John', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430078152),
(64, 'johndoe', 'Ojetunde John', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430078937),
(65, 'johndoe', 'Ojetunde John', 'john', 'Loan Payment', 'Admin Ojetunde John has generated monthly ledger and &#8358 40000 payment on your behalf for your Emergency loan via monthly payback', '', 1, 1431613493);

-- --------------------------------------------------------

--
-- Table structure for table `junk`
--

CREATE TABLE IF NOT EXISTS `junk` (
  `junkid` int(11) NOT NULL AUTO_INCREMENT,
  `junker_username` varchar(255) NOT NULL,
  `junker_subject` varchar(500) NOT NULL,
  `junker_message` text NOT NULL,
  `attachment` varchar(500) NOT NULL,
  `flag` int(1) NOT NULL,
  `timestamp` int(20) NOT NULL,
  PRIMARY KEY (`junkid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `junk`
--

INSERT INTO `junk` (`junkid`, `junker_username`, `junker_subject`, `junker_message`, `attachment`, `flag`, `timestamp`) VALUES
(1, 'john', 'Training of Saved Message', 'This is a test of the number of pages this thing can load per time.', '', 1, 1418428578),
(2, 'john', 'the other part of it', 'the other part of it', '', 0, 1418429181),
(3, 'john', 'the other part of it', 'the other part of it', '', 0, 1418429181),
(5, 'john', 'My project progress', 'Saving the message with a zipped attachment. This is really wonderful.', '1418416730.zip', 1, 1418429365),
(6, 'adu', 'This is A test', 'This is a test email to whoever sees it. Please kindly reply with care.', '', 0, 1418433139),
(7, 'john', 'the other part of it', 'the other part of it', '', 0, 1418481658),
(8, 'john', 'Training of Saved Message', 'This is a test of the number of pages this thing can load per time.', '', 0, 1418484454),
(9, 'john', 'Training of Saved Message', 'This is a test of the number of pages this thing can load per time.', '', 0, 1418484454),
(10, 'john', 'Training of Saved Message', 'This is a test of the number of pages this thing can load per time.', '', 0, 1418484454),
(11, 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. Your project topic is <b>Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\n\r\nCase Study: Student Union, University of Ibadan</b> You can now proceed with your project work', '', 0, 1418745325),
(12, 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. You can now proceed with your project work', '', 0, 1418745326),
(13, 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. You can now proceed with your project work', '', 0, 1418745326),
(14, 'john', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418745326),
(15, 'john', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418745326),
(16, 'john', 'Project Topic Approved!', 'The Project coordinator has approved your project topic. Your project topic is <nl2br><b>Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\nCase Study: Student Union, University of Ibadan</b></nl2br> You can now proceed with your project work', '', 0, 1426039806),
(17, 'john', 'Chapter One', 'Here is attached my chapter one', '1418727112.pdf', 0, 1426039806);

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE IF NOT EXISTS `ledger` (
  `ledger_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` varchar(100) NOT NULL,
  `generated_by` varchar(100) NOT NULL,
  `loan` bigint(20) NOT NULL,
  `Ileya Funds` bigint(20) NOT NULL,
  `Christmas Savings` bigint(20) NOT NULL,
  PRIMARY KEY (`ledger_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lib_staff`
--

CREATE TABLE IF NOT EXISTS `lib_staff` (
  `staff_id` int(20) NOT NULL AUTO_INCREMENT,
  `statt_name` varchar(255) NOT NULL,
  `staff_username` varchar(255) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `staff_password` varchar(300) NOT NULL,
  `staff_level` varchar(40) NOT NULL,
  `staff_status` varchar(30) NOT NULL,
  `timestamp` int(20) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `loan_apply`
--

CREATE TABLE IF NOT EXISTS `loan_apply` (
  `lapply_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `loan_categid` int(11) NOT NULL,
  `amount` double NOT NULL,
  `interest_rate` double NOT NULL,
  `interest_amount` double NOT NULL,
  `final_amount` double NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment_amount` double NOT NULL,
  `balance_debt` double NOT NULL,
  `date_expire` date NOT NULL,
  `amount_per_month` bigint(20) NOT NULL,
  `approver` varchar(20) NOT NULL,
  PRIMARY KEY (`lapply_id`),
  KEY `loan_categid` (`loan_categid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `loan_apply`
--

INSERT INTO `loan_apply` (`lapply_id`, `username`, `loan_categid`, `amount`, `interest_rate`, `interest_amount`, `final_amount`, `timestamp`, `status`, `payment_amount`, `balance_debt`, `date_expire`, `amount_per_month`, `approver`) VALUES
(1, 'john', 2, 100000, 30, 30000, 130000, 1428177664, 'approve', 210000, 0, '2015-06-30', 40000, 'johndoe'),
(2, 'john', 2, 100000, 30, 30000, 130000, 1428180684, 'pending', 0, 130000, '2016-03-31', 0, '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `loan_apply_view`
--
CREATE TABLE IF NOT EXISTS `loan_apply_view` (
`lapply_id` bigint(20)
,`username` varchar(255)
,`cat_name` varchar(255)
,`firstname` varchar(200)
,`surname` varchar(200)
,`othername` varchar(200)
,`phone_number` varchar(100)
,`amount` double
,`interest_rate` double
,`interest_amount` double
,`final_amount` double
,`amount_per_month` bigint(20)
,`timestamp` int(11)
,`approver` varchar(255)
,`payment_amount` double
,`balance_debt` double
,`date_expire` date
,`status` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `loan_categ`
--

CREATE TABLE IF NOT EXISTS `loan_categ` (
  `loan_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `timestamp` int(20) NOT NULL,
  PRIMARY KEY (`loan_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `loan_categ`
--

INSERT INTO `loan_categ` (`loan_cat_id`, `cat_name`, `description`, `timestamp`) VALUES
(2, 'Emergency', 'This is an emergency loan. When there is no hope again and you have to make payment that is a matter of life or death.', 1428138867);

-- --------------------------------------------------------

--
-- Table structure for table `loan_interest_rate`
--

CREATE TABLE IF NOT EXISTS `loan_interest_rate` (
  `rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,0) NOT NULL,
  `interest_rate` float NOT NULL,
  `loan_categid` int(11) NOT NULL,
  `timestamp` int(20) NOT NULL,
  PRIMARY KEY (`rate_id`),
  KEY `loan_categid` (`loan_categid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `loan_interest_rate`
--

INSERT INTO `loan_interest_rate` (`rate_id`, `amount`, `interest_rate`, `loan_categid`, `timestamp`) VALUES
(1, 100000, 30, 2, 1428153530);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `admin_payer` varchar(200) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`pay_id`, `username`, `amount`, `admin_payer`, `timestamp`) VALUES
(1, 'john', 2000, 'Ojetunde John', 1428268227),
(2, 'john', 40000, 'johndoe', 1430077377),
(3, 'john', 0, 'johndoe', 1430077771),
(4, 'john', 40000, 'johndoe', 1430078061),
(5, 'john', 40000, 'johndoe', 1430078152),
(6, 'john', 40000, 'johndoe', 1430078937),
(7, 'john', 40000, 'johndoe', 1431613493);

-- --------------------------------------------------------

--
-- Table structure for table `power_staff`
--

CREATE TABLE IF NOT EXISTS `power_staff` (
  `pstaff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_cat` varchar(255) NOT NULL,
  `borrow` varchar(50) NOT NULL,
  `return` varchar(50) NOT NULL,
  `search` varchar(50) NOT NULL,
  `report` varchar(20) NOT NULL,
  `chat` varchar(20) NOT NULL,
  `book_add` varchar(20) NOT NULL,
  `book_delete` varchar(20) NOT NULL,
  `timestamp` int(50) NOT NULL,
  PRIMARY KEY (`pstaff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE IF NOT EXISTS `savings` (
  `save_id` int(11) NOT NULL AUTO_INCREMENT,
  `save_name` varchar(250) NOT NULL,
  `save_description` text NOT NULL,
  `save_def_amount` bigint(20) NOT NULL,
  `save_start_date` date NOT NULL,
  `save_end_date` date NOT NULL,
  `created_by` varchar(30) NOT NULL,
  PRIMARY KEY (`save_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`save_id`, `save_name`, `save_description`, `save_def_amount`, `save_start_date`, `save_end_date`, `created_by`) VALUES
(2, 'Christmas Savings', 'This is the savings for the month of December. Xmas Period', 8000, '2015-04-01', '2015-07-31', 'johndoe');

-- --------------------------------------------------------

--
-- Table structure for table `sent`
--

CREATE TABLE IF NOT EXISTS `sent` (
  `sentid` int(11) NOT NULL AUTO_INCREMENT,
  `sender_username` varchar(255) NOT NULL,
  `receiver_username` varchar(255) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL,
  `timestamp` int(255) NOT NULL,
  PRIMARY KEY (`sentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `sent`
--

INSERT INTO `sent` (`sentid`, `sender_username`, `receiver_username`, `subject`, `message`, `attachment`, `flag`, `timestamp`) VALUES
(1, 'john', 'john', 'This is A test', 'This is a test email to whoever sees it. Please kindly reply with care.', '', 0, 1418348231),
(2, 'john', 'damilare', 'This is A test', 'This is a test email to whoever sees it. Please kindly reply with care.', '', 0, 1418348231),
(3, 'john', 'adu', 'This is A test', 'This is a test email to whoever sees it. Please kindly reply with care.', '', 0, 1418348231),
(4, 'john', 'john', 'My project progress', 'This is with an attachment. Kindly check the attachment and download it for your personal usage.', '1418348375.docx', 0, 1418348375),
(5, 'john', 'damilare', 'My project progress', 'This is with an attachment. Kindly check the attachment and download it for your personal usage.', '1418348375.docx', 0, 1418348375),
(6, 'john', 'adu', 'My project progress', 'This is with an attachment. Kindly check the attachment and download it for your personal usage.', '1418348375.docx', 0, 1418348375),
(11, 'john', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419130),
(12, 'john', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419136),
(13, 'john', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419143),
(14, 'john', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419149),
(15, 'john', 'john', 'the other part of it', 'the other part of it', '', 0, 1418419155),
(18, 'john', 'adu', 'To Adu', 'From junk testing the send worker', '', 0, 1418432277),
(19, 'john', 'adu', 'To Adu', 'From junk testing the send worker', '', 0, 1418432360),
(20, 'john', 'adu', 'To Adu', 'From junk testing the send worker', '', 0, 1418432446),
(21, 'adu', 'john', 'Check up Messages', 'This is a check up message to my own personal account', '1418481567.jpg', 0, 1418481567),
(22, 'adu', 'ife', 'Check up Messages', 'This is a check up message to my own personal account', '1418481567.jpg', 0, 1418481567),
(23, 'john', 'adu', 'Draft Attachment', 'Save it as a draft attachment', '1418483047.zip', 0, 1418483973),
(24, 'john', 'adu', 'Saved Function Draft', 'Save it as a draft message', '', 0, 1418484061),
(25, 'john', 'adu', 'Saved Function Draft', 'Save it as a draft message', '', 0, 1418484123),
(26, 'john', 'john', 'Adeyemo Miss', 'T&lt;b&gt;his is miss adeyemo&#039;s place&lt;/b&gt;', '', 0, 1418484144),
(27, 'john', 'johndoe', 'Saved Function Draft', 'Save it as a draft message', '', 0, 1418484408),
(28, 'johndoe', 'john', 'Project Submission', 'Make sure you see me on the 13th of December, 2014.', '', 0, 1418686636),
(29, 'johndoe', 'john', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418689681),
(30, 'johndoe', 'john', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418690811),
(31, 'johndoe', 'john', 'Request Rejected!', 'Dr. Ojetunde John Oluwadamilare has rejected you as his/her project student, contact the project coordinator for more details', '', 0, 1418691605),
(32, 'johndoe', 'john', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418691823),
(33, 'johndoe', 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. You can now proceed with your project work', '', 0, 1418718629),
(34, 'johndoe', 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. You can now proceed with your project work', '', 0, 1418718655),
(35, 'johndoe', 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. Your project topic is <b>Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\n\r\nCase Study: Student Union, University of Ibadan</b> You can now proceed with your project work', '', 0, 1418719425),
(36, 'johndoe', 'john', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. Your project topic is <nl2br><b>Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\nCase Study: Student Union, University of Ibadan</b></nl2br> You can now proceed with your project work', '', 0, 1418719612),
(37, 'johndoe', 'roy', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418726922),
(38, 'johndoe', 'roy', 'Project Topic Approved!', 'Dr. Ojetunde John Oluwadamilare has approved your project topic. Your project topic is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418727001),
(39, 'roy', 'johndoe', 'Chapter One', 'Here is attached my chapter one', '1418727112.pdf', 0, 1418727134),
(40, 'roy', 'john', 'Chapter One', 'Here is attached my chapter one', '1418727112.pdf', 0, 1418727134),
(41, 'roy', 'adu', 'Chapter One', 'Here is attached my chapter one', '1418727112.pdf', 0, 1418727134),
(42, 'johndoe', 'roy', 'Reply- Chapter One', 'next time send me a word document so that I can help you edit it.', '', 0, 1418727281),
(43, 'johndoe', 'roy', 'Request Rejected!', 'Dr. Ojetunde John Oluwadamilare has rejected you as his/her project student, contact the project coordinator for more details', '', 0, 1418727593),
(44, 'johndoe', 'roy', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418727797),
(45, 'johndoe', 'ife', 'Request Confirmed!', 'Dr. Ojetunde John Oluwadamilare has confirmed you as his/her project student. you can proceed with every other process', '', 0, 1418728206),
(46, 'johndoe', 'roy', 'Project Topic Approved!', 'The Project coordinator has approved your project topic. Your project topic is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418742723),
(47, 'johndoe', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has approved the project topic <b><nl2br>()</nl2br></b> of one of your students (Faniyi Olarotimi)  ', '', 0, 1418742723),
(48, 'johndoe', 'roy', 'Project Topic Disapproved!', 'The Project coordinator has disapproved your project topic, which is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418743219),
(49, 'johndoe', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has Disapproved the project topic <b><nl2br>(An Online adaptive collaborative support system)</nl2br></b> of one of your students (Faniyi Olarotimi)  ', '', 0, 1418743219),
(50, 'johndoe', 'roy', 'Project Topic Approved!', 'The Project coordinator has approved your project topic. Your project topic is <nl2br><b>An Online adaptive collaborative support system</b></nl2br> You can now proceed with your project work', '', 0, 1418743306),
(51, 'johndoe', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has approved the project topic <b><nl2br>(An Online adaptive collaborative support system)</nl2br></b> of one of your students (Faniyi Olarotimi)  ', '', 0, 1418743306),
(52, 'johndoe', 'john', 'Project Topic Approved!', 'The Project coordinator has approved your project topic. Your project topic is <nl2br><b>Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\nCase Study: Student Union, University of Ibadan</b></nl2br> You can now proceed with your project work', '', 0, 1418743361),
(53, 'johndoe', 'johndoe', 'Project Topic Approved!', 'The Project coordinator has approved the project topic <b><nl2br>(Design and Implementation of An Electronic Voting System with Graphical Result Analysis.\r\n\r\nCase Study: Student Union, University of Ibadan)</nl2br></b> of one of your students (Ojetunde John Oluwadamilare)  ', '', 0, 1418743361),
(54, 'john', 'babatunde', 'My mailing System', 'This is my own mailing system. Enjoy it.', '1426176552.pdf', 0, 1426176552),
(55, 'johndoe', 'john', 'Loan Declination!', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', '', 0, 1428255239),
(56, 'johndoe', 'john', 'Loan Declination!', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', '', 0, 1428255310),
(57, 'johndoe', 'john', 'Loan Declination!', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', '', 0, 1428255600),
(58, 'johndoe', 'john', 'Loan Approval!', 'Your Loan of category Emergency of &#8358 100000 has been approved by the administrator', '', 0, 1428262512),
(59, 'johndoe', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 2000 payment on your behalf for your Emergency loan', '', 0, 1428268227),
(60, 'john', 'john', 'Loan Payment', 'Admin johndoe has made &#8358 generated monthly ledger and 40000 payment on your behalf for your  loan via monthly payback', '', 0, 1430077377),
(61, 'john', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and  payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430077771),
(62, 'john', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430078061),
(63, 'john', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430078152),
(64, 'johndoe', 'john', 'Loan Payment', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1430078937),
(65, 'johndoe', 'john', 'Loan Payment', 'Admin Ojetunde John has generated monthly ledger and &#8358 40000 payment on your behalf for your Emergency loan via monthly payback', '', 0, 1431613493);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `set_id` int(10) NOT NULL AUTO_INCREMENT,
  `price_per_fine` int(10) NOT NULL,
  `academic_session` varchar(100) NOT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_tracker`
--

CREATE TABLE IF NOT EXISTS `sms_tracker` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `timestamp` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `sms_tracker`
--

INSERT INTO `sms_tracker` (`id`, `phone_number`, `message`, `status`, `date`, `timestamp`) VALUES
(1, '2348165873186', 'This is just a test message with HarvestPlus SMS Platform', 'Message Sent', 'February,24,2014, 3:36pm', 1393252583),
(2, '2348169013692', 'This is just a test message with HarvestPlus SMS Platform', 'Message Sent', 'February,24,2014, 3:36pm', 1393252585),
(3, '2348034915957', 'This is just a test message with HarvestPlus SMS Platform', 'Message Sent', 'February,24,2014, 3:36pm', 1393252586),
(4, '2348099588493', 'Your HarvestPlus Account has been deactivated, get to the administrator to found out why', 'Message Not Sent', 'March,5,2014, 12:50pm', 1394020237),
(5, '2348099588493', 'Your HarvestPlus Account has been activated, log in via http://www.damisagurusgroup.com/harvest', 'Message Not Sent', 'March,5,2014, 12:52pm', 1394020322),
(6, '23423481690136', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', 'Message Not Sent', 'April,5,2015, 6:35pm', 1428255310),
(7, '23423481690136', 'Your Loan of category Emergency of &#8358 100000 has been declined by the administrator', 'Message Not Sent', 'April,5,2015, 6:40pm', 1428255600),
(8, '23423481690136', 'Your Loan of category Emergency of &#8358 100000 has been approved by the administrator', 'Message Not Sent', 'April,5,2015, 8:35pm', 1428262512),
(9, '234', 'Admin Ojetunde John has made &#8358 2000 payment on your behalf for your Emergency loan', 'Message Not Sent', 'April,5,2015, 10:10pm', 1428268228),
(10, '234', 'Admin johndoe has made &#8358 generated monthly ledger and 40000 payment on your behalf for your  loan via monthly payback', 'Message Not Sent', 'April,26,2015, 8:42pm', 1430077378),
(11, '23423481690136', 'Admin Ojetunde John has made &#8358 generated monthly ledger and  payment on your behalf for your Emergency loan via monthly payback', 'Message Not Sent', 'April,26,2015, 8:49pm', 1430077772),
(12, '23423481690136', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', 'Message Not Sent', 'April,26,2015, 8:54pm', 1430078061),
(13, '23423481690136', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', 'Message Not Sent', 'April,26,2015, 8:55pm', 1430078152),
(14, '23423481690136', 'Admin Ojetunde John has made &#8358 generated monthly ledger and 40000 payment on your behalf for your Emergency loan via monthly payback', 'Message Not Sent', 'April,26,2015, 9:08pm', 1430078938),
(15, '23423481690136', 'Admin Ojetunde John has generated monthly ledger and &#8358 40000 payment on your behalf for your Emergency loan via monthly payback', 'Message Not Sent', 'May,14,2015, 3:24pm', 1431613494);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `std_id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(200) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `othername` varchar(200) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `passport` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(200) NOT NULL,
  `presence` varchar(11) NOT NULL,
  `timestamp` int(30) NOT NULL,
  `Ileya Funds` bigint(20) NOT NULL,
  `Christmas Savings` bigint(20) NOT NULL,
  PRIMARY KEY (`std_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`std_id`, `surname`, `firstname`, `othername`, `gender`, `phone_number`, `address`, `passport`, `username`, `password`, `email`, `status`, `presence`, `timestamp`, `Ileya Funds`, `Christmas Savings`) VALUES
(1, 'Ojetunde', 'John', 'Oluwadamilare', 'Male', ' 2348169013692', 'Oyo State.', '1430056990.png', 'john', '0fd8c26c13833ef05bf899958f0b41c2', 'bjaypjay2012@gmail.com', 'activate', 'false', 1425972749, 4000, 2000),
(2, 'Ojetunde', 'Victor', 'Olatunde', 'Male', '07069208055', 'Oyo State', '', 'victor', '0fd8c26c13833ef05bf899958f0b41c2', 'ojetunks@yahoomail.com', 'activate', 'false', 1426017360, 5000, 2000),
(9, 'Fadele', 'Olukayode', 'Ayodeji', 'Female', ' 2348169013692', 'Ogun State.', '1428056480.png', 'kayode', '0fd8c26c13833ef05bf899958f0b41c2', 'kayode@yahoo.com', 'activate', 'false', 1428051086, 5000, 2000);

-- --------------------------------------------------------

--
-- Structure for view `loan_apply_view`
--
DROP TABLE IF EXISTS `loan_apply_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `loan_apply_view` AS select `loan_apply`.`lapply_id` AS `lapply_id`,`loan_apply`.`username` AS `username`,`loan_categ`.`cat_name` AS `cat_name`,`users`.`firstname` AS `firstname`,`users`.`surname` AS `surname`,`users`.`othername` AS `othername`,`users`.`phone_number` AS `phone_number`,`loan_apply`.`amount` AS `amount`,`loan_apply`.`interest_rate` AS `interest_rate`,`loan_apply`.`interest_amount` AS `interest_amount`,`loan_apply`.`final_amount` AS `final_amount`,`loan_apply`.`amount_per_month` AS `amount_per_month`,`loan_apply`.`timestamp` AS `timestamp`,`admin`.`fullname` AS `approver`,`loan_apply`.`payment_amount` AS `payment_amount`,`loan_apply`.`balance_debt` AS `balance_debt`,`loan_apply`.`date_expire` AS `date_expire`,`loan_apply`.`status` AS `status` from (((`loan_apply` left join `users` on((`loan_apply`.`username` = `users`.`username`))) left join `loan_categ` on((`loan_categ`.`loan_cat_id` = `loan_apply`.`loan_categid`))) left join `admin` on((`loan_apply`.`approver` = `admin`.`username`)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loan_apply`
--
ALTER TABLE `loan_apply`
  ADD CONSTRAINT `loan_apply_ibfk_1` FOREIGN KEY (`loan_categid`) REFERENCES `loan_categ` (`loan_cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loan_interest_rate`
--
ALTER TABLE `loan_interest_rate`
  ADD CONSTRAINT `loan_interest_rate_ibfk_1` FOREIGN KEY (`loan_categid`) REFERENCES `loan_categ` (`loan_cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
