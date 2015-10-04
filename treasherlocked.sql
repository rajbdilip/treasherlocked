-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2015 at 01:05 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `treasherlocked`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_temp`
--

CREATE TABLE IF NOT EXISTS `users_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_type` int(1) NOT NULL DEFAULT '0',
  `oauth_id` bigint(20) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` int(1) NOT NULL,
  `location` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_stats`
--

CREATE TABLE IF NOT EXISTS `user_stats` (
  `user_id` int(11) NOT NULL,
  `level` int(2) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
