-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2015 at 12:48 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sosheartv1`
--

-- --------------------------------------------------------

--
-- Table structure for table `caretaker`
--

CREATE TABLE IF NOT EXISTS `caretaker` (
  `cUserName` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `phone` int(10) NOT NULL,
  PRIMARY KEY (`cUserName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `caretaker`
--

INSERT INTO `caretaker` (`cUserName`, `password`, `email`, `phone`) VALUES
('12345678', '12345678', '12345678', 0),
('123456789', '12345678', '12345678', 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE IF NOT EXISTS `detail` (
  `pUserName` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `activity` varchar(20) NOT NULL,
  `arrhythmia` varchar(20) NOT NULL,
  PRIMARY KEY (`pUserName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`pUserName`, `state`, `activity`, `arrhythmia`) VALUES
('ex1', 'healty', 'running', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `pUserName` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `cUserName` varchar(20) NOT NULL,
  `currentStatus` varchar(20) NOT NULL,
  `arrhythmia` varchar(50) NOT NULL,
  PRIMARY KEY (`pUserName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pUserName`, `password`, `email`, `cUserName`, `currentStatus`, `arrhythmia`) VALUES
('ex1', '12345678', '12345678', '12345678', 'healthy', 'none'),
('ex3', '1', '1', '12345678', 'healthy', 'none'),
('ex5', '5', '5', '12345678', 'healthy', 'none'),
('xe2', '1234', '12345', '12345678', 'danger', 'PVC'),
('xe4', '2', '2', '12345678', 'danger', 'PCV');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
