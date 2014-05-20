-- phpMyAdmin SQL Dump
-- version 4.0.9deb1.precise~ppa.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2014 at 07:04 PM
-- Server version: 5.5.35-0ubuntu0.12.04.2
-- PHP Version: 5.5.10-1+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wbg-jabber-new`
--

-- --------------------------------------------------------

--
-- Table structure for table `cipc_results`
--

CREATE TABLE IF NOT EXISTS `cipc_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upi` varchar(20) NOT NULL,
  `device` varchar(255) NOT NULL,
  `cluster` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `upi` (`upi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `desc_results`
--

CREATE TABLE IF NOT EXISTS `desc_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` varchar(255) NOT NULL,
  `cluster` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device` (`device`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dp_results`
--

CREATE TABLE IF NOT EXISTS `dp_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` varchar(255) NOT NULL,
  `device_pool` text NOT NULL,
  `cluster` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device` (`device`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `jabber_results`
--

CREATE TABLE IF NOT EXISTS `jabber_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upi` varchar(20) NOT NULL,
  `device` varchar(255) NOT NULL,
  `cluster` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `upi` (`upi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
