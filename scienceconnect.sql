-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2013 at 06:49 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scienceconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fromemail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `toemail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `fromemail`, `toemail`, `subject`, `body`, `date`) VALUES
(3, 'marwan@abc.com', 'supreet@abc.com', 'abc', 'Hello', 'March 14, 2013'),
(4, 'supreet@abc.com', 'marwan@abc.com', 'abc', 'whats up?', 'March 14, 2013'),
(5, 'supreet@abc.com', 'marwan@abc.com', 'abcd', 'Hello', 'March 17, 2013'),
(6, 'supreet@abc.com', 'marwan@abc.com', 'new one', 'HI HELLO', 'March 18, 2013');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE IF NOT EXISTS `proposals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`id`, `email`, `name`, `title`, `content`, `date`) VALUES
(5, 'supreet@abc.com', 'Supreet', 'Alice in Wonderland', '''You ought to be ashamed of yourself for asking such a simple question,'' added the Gryphon; and then they both sat silent and looked at poor Alice, who felt ready to sink into the earth. At last the Gryphon said to the Mock Turtle, ''Drive on, old fellow! Don''t be all day about it!'' and he went on in these words: ''Yes, we went to school in the sea, though you mayn''t believe it—'' ''I never said I didn''t!'' interrupted Alice. ''You did,'' said the Mock Turtle.', 'March 14, 2013'),
(6, 'marwan@abc.com', 'Marwan', 'Revolution has begun', '''I am bound to Tahiti for more men.'' ''Very good. Let me board you a moment—I come in peace.'' With that he leaped from the canoe, swam to the boat; and climbing the gunwale, stood face to face with the captain. ''Cross your arms, sir; throw back your head. Now, repeat after me. As soon as Steelkilt leaves me, I swear to beach this boat on yonder island, and remain there six days. If I do not, may lightning strike me!''A pretty scholar,'' laughed the Lakeman. ''Adios, Senor!'' and leaping into the sea, he swam back to his comrades.', 'March 14, 2013');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(11, 'supreet@abc.com', 1234),
(12, 'marwan@abc.com', 1234),
(14, 'dave@abc.com', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE IF NOT EXISTS `userdetails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emailID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `university` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`id`, `emailID`, `name`, `email`, `university`, `address`, `number`) VALUES
(11, 'supreet@abc.com', 'Supreet', 'supreet@gmail.com', 'Newcastle', '218 Ladykirk Road', '07989999998'),
(12, 'marwan@abc.com', 'Marwan', 'marwan@gmail.com', 'Newcastle', 'Newcastle upon Tyne', '07458888888'),
(13, NULL, 'Supreet', 'supreet@gmail.com', 'Newcastle', '218 Ladykirk Road', '07989999998'),
(14, 'dave@abc.com', 'Dave', 'dave@abc.com', 'Newcastle', 'ABC', '555566');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
