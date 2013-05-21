-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2013 at 02:34 AM
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
  KEY `kpi_id` (`kpi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `kpi_id`, `field_name`, `type`) VALUES
(1, 9, 'No. of standard processes per core system across all CU''s', 'int'),
(2, 10, 'No. of students doing transactions online', 'int'),
(3, 10, 'No. of processes online', 'int'),
(4, 11, 'No. of Faculty doing transactions online', 'int'),
(5, 11, 'No. of Admin staff and REPS doing transactions online', 'int'),
(6, 11, 'Total alumni transactions done online', 'int'),
(7, 12, 'Total processing per major transactinos', 'int'),
(8, 13, 'No. of paper based transactions done online per system', 'int'),
(9, 14, 'No. of Campuses accessed to online journals per CU', 'int'),
(10, 15, 'No. of CUs with ICT tools in Research Laboratories', 'int'),
(11, 15, 'No. of Highschool teachers that integrate IT in their classes', 'int'),
(12, 15, 'No. of highschools using ICT Tools', 'int'),
(13, 15, 'No. of ICT equipments in K+12 laboratory schools', 'int'),
(14, 16, 'No. of transaction volume per admin per system quarterly', 'int'),
(15, 17, 'No. of faculty using ICT in teaching per CU', 'int'),
(16, 17, 'No. of faculty using ICT in research per CU', 'int'),
(17, 18, 'No. of Admin staff using ICT per CU', 'int'),
(18, 18, 'No. of REPS using ICT per CU', 'int'),
(19, 19, 'No. of students accessing online learning portals per CU', 'int'),
(20, 20, 'No. of school services across CU', 'int'),
(21, 20, 'No. of campuses using shared services (google docs, moodle) per CU', 'int'),
(22, 21, 'Total no. of standard reports per system', 'int'),
(23, 21, 'Total no. of Standard Documents (Records and Registries)', 'int'),
(24, 21, 'Total no. of standard dictionary being used per system', 'int'),
(25, 21, 'Total no. of standard forms per system. (e.g. for students academics, # of standard change Mat forms', 'int'),
(26, 22, 'No. of portals using Content Management System (CMS) per CU', 'int'),
(27, 22, 'No. of available centralized portales per CU', 'int'),
(28, 23, 'Total no. of donors using online system', 'int'),
(29, 24, 'Total Expenditures per Cost Center/Year', 'int'),
(30, 24, 'Annual allocated budget per cost center', 'int'),
(31, 24, 'Savings per Cost Center per Annum', 'int'),
(32, 24, 'Income generated per cost centers per annum', 'int'),
(33, 25, 'Time to generate a specific report requested by higher officials', 'int'),
(34, 26, 'No. of available dashboards for officials', 'int'),
(35, 27, 'Total no. of reports available per system', 'int'),
(36, 27, 'Total no. of data centers across all CUs', 'int'),
(37, 28, 'Total no. of PCs available to stakeholders per CU', 'int'),
(38, 28, 'Improvement of Bandwidth to all stakeholders (student, faculty, officials, academic community, and o', 'int'),
(39, 28, 'No. of servers housed per CU', 'int'),
(40, 28, 'No. of server rooms per Campus', 'int'),
(41, 29, 'Clearly defined plantilla of all ICT personell per CU', 'int'),
(42, 29, 'Clearly defined plantilla of personnel doing ICT work per CU', 'int');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `kpi`
--

INSERT INTO `kpi` (`kpi_id`, `project_id`, `kpi_name`, `leaf_node`, `parent_kpi`) VALUES
(1, 1, 'Simplified Operations', 0, 0),
(2, 1, 'Improved Efficiency', 0, 0),
(3, 1, 'Optimal Utilization of ICT Resources', 0, 0),
(4, 1, 'Increased Productivity', 0, 0),
(5, 1, 'Extensive Sharing of Information', 0, 0),
(6, 1, 'Increased Savings/Revenue', 0, 0),
(7, 1, 'Improved Decision Making Capability', 0, 0),
(8, 1, 'Improve ICT Infrastructure', 0, 0),
(9, 1, 'Process Standardization across Constituent Universities', 1, 1),
(10, 1, 'Student Transactions Done Online', 1, 1),
(11, 1, 'Faculty, Staff and Alumni Transactions Done Online', 1, 1),
(12, 1, 'Reduction in transaction processing time', 1, 2),
(13, 1, 'Reduction of paper based transaction', 1, 2),
(14, 1, 'Access to faculty, staff and students to learning materials', 1, 3),
(15, 1, 'Utilization of ICT tools in laboratory schools', 1, 3),
(16, 1, 'Increase in transaction volume per office', 1, 4),
(17, 1, 'Faculty members using technology for teaching and research', 1, 4),
(18, 1, 'Administrative staff and REPS using eUP for greater productivity', 1, 4),
(19, 1, 'Students using eUP for learning', 1, 4),
(20, 1, 'Shared services across constituent universities', 1, 5),
(21, 1, 'Data standardization', 1, 5),
(22, 1, 'Online portals using content management systems', 1, 5),
(23, 1, 'Increase in donations, grants, and endowments', 1, 6),
(24, 1, 'Tracking of cost centers', 1, 6),
(25, 1, 'Decisions based on timely and accurate data', 1, 7),
(26, 1, 'Business intelligence software used for decision making', 1, 7),
(27, 1, 'Single source of truth', 1, 7),
(28, 1, 'Availability of ICT tools for infrastructure operations', 1, 8),
(29, 1, 'ICT Manpower consolidation at the level of the constituent universities', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `kpi_account`
--

CREATE TABLE IF NOT EXISTS `kpi_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `kpi_id` int(11) DEFAULT NULL,
  `info_sys` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  KEY `kpi_id` (`kpi_id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`) VALUES
(1, 'eup kpi');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `update_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`update_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `project_id` (`project_id`),
  KEY `info_sys` (`account_id`),
  KEY `account_id` (`account_id`),
  KEY `account_id_2` (`account_id`)
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
-- Constraints for table `kpi`
--
ALTER TABLE `kpi`
  ADD CONSTRAINT `kpi_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `kpi_account`
--
ALTER TABLE `kpi_account`
  ADD CONSTRAINT `kpi_account_ibfk_1` FOREIGN KEY (`kpi_id`) REFERENCES `kpi` (`kpi_id`);

--
-- Constraints for table `output`
--
ALTER TABLE `output`
  ADD CONSTRAINT `output_ibfk_1` FOREIGN KEY (`kpi_id`) REFERENCES `kpi` (`kpi_id`);

--
-- Constraints for table `updates`
--
ALTER TABLE `updates`
  ADD CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `kpi_account` (`account_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `users` (`account_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
