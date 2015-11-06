-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2015 at 03:32 AM
-- Server version: 5.5.42-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `treasherlocked3`
--

-- --------------------------------------------------------

--
-- Table structure for table `gameplay`
--

CREATE TABLE IF NOT EXISTS `gameplay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `level` int(2) NOT NULL,
  `clear_time` datetime NOT NULL,
  `attempts` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `level` int(2) NOT NULL,
  `html` text NOT NULL,
  `answer` varchar(40) NOT NULL,
  `url_mask` varchar(12) DEFAULT NULL,
  `favicon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_type` int(1) NOT NULL DEFAULT '0',
  `oauth_id` bigint(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(5) NOT NULL,
  `presence` varchar(40) NOT NULL,
  `auth_code` varchar(40) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` int(1) NOT NULL DEFAULT '1',
  `location` varchar(40) NOT NULL,
  `institute` varchar(60) NOT NULL,
  `registered_in` datetime NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=237 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_type`, `oauth_id`, `username`, `email`, `password`, `salt`, `presence`, `auth_code`, `first_name`, `middle_name`, `last_name`, `gender`, `location`, `institute`, `registered_in`, `verified`) VALUES
(4, 0, 0, 'username', 'email@mail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', '', '', 'Name', NULL, '', 1, 'Location', 'Institute College', '2015-10-26 00:11:43', 1),
(5, 0, 0, 'sin', 'sinha.rahul208@gmail.com', '18548853e5fa97ef2547d5958d70bffc31a93d39', '', '', '', 'Rahul SInha', NULL, '', 1, 'Khagaria', 'KoshiCollege', '2015-10-26 10:02:46', 1),
(6, 0, 0, 'fg7', 'falgunighosh14@gmail.com', 'b4560b52550377b12eed2bb84e42bf459275dc50', '', '', '', 'Falguni Ghosh', NULL, '', 1, 'Warangal', 'National Institute Of Technology  Warangal', '2015-10-26 14:31:32', 1),
(7, 0, 0, 'arijit', 'mandalarijit1996@gmail.com', 'bee3e19740ffed92e2fc4d0fe2e521c07ae97787', '', '', '', 'Arijit Mandal', NULL, '', 1, 'Warangal', 'National Institute Of Technology Warangal', '2015-10-26 14:33:26', 1),
(8, 0, 0, 'Scarlett', 'dddaisyd06@gmail.com', 'fcc0a74a0426f4c0b79685122570a2f4b47cc84c', '', '4b5d9ea93d943eccaa43a822eaab1b7d5aabcc5b', '', 'Daisy Das', NULL, '', 0, 'Rourkela', 'NIT Rourkela', '2015-10-26 20:47:00', 1),
(9, 0, 0, 'kuldeep', 'person.kkaiwart@gmail.com', 'c2b0fb330429a7a73acaf6672ac892cf3373bcce', '', '1ad009c362ae619700e85f1df1a779dc9a6282b5', '', 'Kuldeep', NULL, '', 1, 'ROURKELA', 'NIT ROURKELA', '2015-10-26 21:07:40', 1),
(10, 0, 0, 'analkumar', 'anal.kumar@niser.ac.in', 'd24fb296ea7c7a9c5816e207fe89cf77d0635afb', '', '2276523714ed3c25950197ecb84d2c229add0c4a', '', 'Anal Kumar', NULL, '', 1, 'Bhubaneswar', 'National Institute Of Science Education And Research', '2015-10-26 22:57:48', 1),
(11, 0, 0, 'Ls123', 'lipikasahoo96@gmail.com', 'da11952228e5b1e8c8e23f0ebeba8c7d2107557a', '', '', '', 'Lipika', NULL, '', 0, 'Rourkela', 'NIT Rourkela', '2015-10-27 20:10:08', 1),
(12, 0, 0, 'ragesh', 'ragesh10ten@gmail.com', '6fa04ae60770216a92b9effc55224ebae22214d7', '', '', '', 'Ragesh', NULL, '', 1, 'Kottayam', 'Saintgits College', '2015-10-27 21:14:16', 1),
(13, 0, 0, 'sambitlp', 'sambit1suranjan@gmail.com', 'eb86af9343e301348b30e448c45b9a3ae9515a07', '', 'b461f583757e4415e7c2ad5b80924bf761f93103', '', 'Sambit Suranjan', NULL, '', 1, 'Rourkela', 'NIT Rourkela', '2015-10-27 21:15:24', 1),
(19, 2, 9223372036854775807, 'Keval', '15pgp084.keval@iimraipur.ac.in', '', '', '', '', 'Keval', NULL, 'Boricha', 1, 'Raipur', 'Indian Institute Of Management Raipur', '2015-10-27 23:14:04', 1)