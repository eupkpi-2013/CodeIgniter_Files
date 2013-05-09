-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2013 at 05:06 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `testkpi`
--

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `kpi_id` int(11) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`field_id`),
  KEY `kpi_id` (`kpi_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `field_values`
--

CREATE TABLE IF NOT EXISTS `field_values` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`value_id`),
  KEY `field_id` (`field_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iscu`
--

CREATE TABLE IF NOT EXISTS `iscu` (
  `iscu_id` int(11) NOT NULL AUTO_INCREMENT,
  `iscu` varchar(100) NOT NULL,
  PRIMARY KEY (`iscu_id`),
  KEY `info_sys` (`iscu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iscu_field`
--

CREATE TABLE IF NOT EXISTS `iscu_field` (
  `iscu_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  KEY `iscu_id` (`iscu_id`,`field_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kpi`
--

CREATE TABLE IF NOT EXISTS `kpi` (
  `kpi_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `kpi_name` varchar(100) DEFAULT NULL,
  `leaf_node` tinyint(1) DEFAULT NULL,
  `parent_kpi` int(11) NOT NULL,
  PRIMARY KEY (`kpi_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `output`
--

CREATE TABLE IF NOT EXISTS `output` (
  `output_id` int(11) NOT NULL AUTO_INCREMENT,
  `kpi_id` int(11) NOT NULL,
  `output_name` varchar(100) NOT NULL,
  `done` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`output_id`),
  KEY `kpi_id` (`kpi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `iscu_id` int(11) DEFAULT NULL,
  `update_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`update_id`),
  KEY `iscu_id` (`iscu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `iscu_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `project_id` (`project_id`),
  KEY `info_sys` (`iscu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`kpi_id`) REFERENCES `kpi` (`kpi_id`);

--
-- Constraints for table `field_values`
--
ALTER TABLE `field_values`
  ADD CONSTRAINT `field_values_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`),
  ADD CONSTRAINT `field_values_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `iscu_field`
--
ALTER TABLE `iscu_field`
  ADD CONSTRAINT `iscu_field_ibfk_1` FOREIGN KEY (`iscu_id`) REFERENCES `iscu` (`iscu_id`),
  ADD CONSTRAINT `iscu_field_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`);

--
-- Constraints for table `kpi`
--
ALTER TABLE `kpi`
  ADD CONSTRAINT `kpi_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `output`
--
ALTER TABLE `output`
  ADD CONSTRAINT `output_ibfk_1` FOREIGN KEY (`kpi_id`) REFERENCES `kpi` (`kpi_id`);

--
-- Constraints for table `updates`
--
ALTER TABLE `updates`
  ADD CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`iscu_id`) REFERENCES `iscu` (`iscu_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`iscu_id`) REFERENCES `iscu` (`iscu_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
