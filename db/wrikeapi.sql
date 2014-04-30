-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: internal-db.s149580.gridserver.com
-- Generation Time: Apr 26, 2014 at 02:49 AM
-- Server version: 5.1.63-rel13.4
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db149580_wrikereporter`
--

-- --------------------------------------------------------

--
-- Table structure for table `wrikeapi`
--

CREATE TABLE IF NOT EXISTS `wrikeapi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sendto` varchar(50) NOT NULL,
  `sendfrom` varchar(50) NOT NULL,
  `organizationname` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `apikey` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wrikeapi`
--

INSERT INTO `wrikeapi` (`id`, `sendto`, `sendfrom`, `organizationname`, `message`, `apikey`) VALUES
(2, 'Dan F', 'dan@webversed.co.uk', 'Webversed', 'Dan testing default message 2', 'cf1026e6-eda0-4e47-9918-f496da9d0487');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
