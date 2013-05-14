-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2013 at 10:16 AM
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
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_name` (`account_name`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `project_id`, `account_name`) VALUES
(1, 1, 'Superuser'),
(2, 1, 'Subsuperuser'),
(3, 1, 'Auditor'),
(4, 1, 'Boss'),
(5, 1, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `kpi_id` int(11) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`),
  KEY `kpi_id` (`kpi_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `kpi_id`, `field_name`, `type`, `active`) VALUES
(1, 9, 'No. of standard processes per core system across all CU''s', 'int', 1),
(2, 10, 'No. of students doing transactions online', 'int', 1),
(3, 10, 'No. of processes online', 'int', 1),
(4, 11, 'No. of Faculty doing transactions online', 'int', 1),
(5, 11, 'No. of Admin staff and REPS doing transactions online', 'int', 1),
(6, 11, 'Total alumni transactions done online', 'int', 1),
(7, 12, 'Total processing per major transactinos', 'int', 1),
(8, 13, 'No. of paper based transactions done online per system', 'int', 1),
(9, 14, 'No. of Campuses accessed to online journals per CU', 'int', 1),
(10, 15, 'No. of CUs with ICT tools in Research Laboratories', 'int', 1),
(11, 15, 'No. of Highschool teachers that integrate IT in their classes', 'int', 1),
(12, 15, 'No. of highschools using ICT Tools', 'int', 1),
(13, 15, 'No. of ICT equipments in K+12 laboratory schools', 'int', 1),
(14, 16, 'No. of transaction volume per admin per system quarterly', 'int', 1),
(15, 17, 'No. of faculty using ICT in teaching per CU', 'int', 1),
(16, 17, 'No. of faculty using ICT in research per CU', 'int', 1),
(17, 18, 'No. of Admin staff using ICT per CU', 'int', 1),
(18, 18, 'No. of REPS using ICT per CU', 'int', 1),
(19, 19, 'No. of students accessing online learning portals per CU', 'int', 1),
(20, 20, 'No. of school services across CU', 'int', 1),
(21, 20, 'No. of campuses using shared services (google docs, moodle) per CU', 'int', 1),
(22, 21, 'Total no. of standard reports per system', 'int', 1),
(23, 21, 'Total no. of Standard Documents (Records and Registries)', 'int', 1),
(24, 21, 'Total no. of standard dictionary being used per system', 'int', 1),
(25, 21, 'Total no. of standard forms per system. (e.g. for students academics, # of standard change Mat forms', 'int', 1),
(26, 22, 'No. of portals using Content Management System (CMS) per CU', 'int', 1),
(27, 22, 'No. of available centralized portales per CU', 'int', 1),
(28, 23, 'Total no. of donors using online system', 'int', 1),
(29, 24, 'Total Expenditures per Cost Center/Year', 'int', 1),
(30, 24, 'Annual allocated budget per cost center', 'int', 1),
(31, 24, 'Savings per Cost Center per Annum', 'int', 1),
(32, 24, 'Income generated per cost centers per annum', 'int', 1),
(33, 25, 'Time to generate a specific report requested by higher officials', 'int', 1),
(34, 26, 'No. of available dashboards for officials', 'int', 1),
(35, 27, 'Total no. of reports available per system', 'int', 1),
(36, 27, 'Total no. of data centers across all CUs', 'int', 1),
(37, 28, 'Total no. of PCs available to stakeholders per CU', 'int', 1),
(38, 28, 'Improvement of Bandwidth to all stakeholders (student, faculty, officials, academic community, and o', 'int', 1),
(39, 28, 'No. of servers housed per CU', 'int', 1),
(40, 28, 'No. of server rooms per Campus', 'int', 1),
(41, 29, 'Clearly defined plantilla of all ICT personell per CU', 'int', 1),
(42, 29, 'Clearly defined plantilla of personnel doing ICT work per CU', 'int', 1);

-- --------------------------------------------------------

--
-- Table structure for table `field_values`
--

CREATE TABLE IF NOT EXISTS `field_values` (
  `value_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `results_id` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `value_id` (`value_id`,`field_id`),
  KEY `field_id` (`field_id`),
  KEY `user_id` (`user_id`,`results_id`),
  KEY `results_id` (`results_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  `output_id` int(11) NOT NULL,
  PRIMARY KEY (`file_id`),
  KEY `output_id` (`output_id`),
  KEY `output_id_2` (`output_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iscu`
--

CREATE TABLE IF NOT EXISTS `iscu` (
  `iscu_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `iscu` varchar(100) NOT NULL,
  PRIMARY KEY (`iscu_id`),
  UNIQUE KEY `iscu` (`iscu`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1003 ;

--
-- Dumping data for table `iscu`
--

INSERT INTO `iscu` (`iscu_id`, `project_id`, `iscu`) VALUES
(1, 1, 'Admin'),
(1001, 1, 'FMIS');

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
-- Table structure for table `iscu_updates`
--

CREATE TABLE IF NOT EXISTS `iscu_updates` (
  `iscu_id` int(11) NOT NULL,
  `updates_id` int(11) NOT NULL,
  KEY `iscu_id` (`iscu_id`,`updates_id`),
  KEY `updates_id` (`updates_id`),
  KEY `updates_id_2` (`updates_id`)
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
  UNIQUE KEY `kpi_name` (`kpi_name`),
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
(6, 1, 'Increased Savings and Revenue', 0, 0),
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
-- Table structure for table `output`
--

CREATE TABLE IF NOT EXISTS `output` (
  `output_id` int(11) NOT NULL AUTO_INCREMENT,
  `output_name` varchar(100) NOT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`output_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `output_results`
--

CREATE TABLE IF NOT EXISTS `output_results` (
  `output_id` int(11) NOT NULL,
  `results_id` int(11) NOT NULL,
  KEY `output_id` (`output_id`,`results_id`),
  KEY `results_id` (`results_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `results_id` int(11) NOT NULL AUTO_INCREMENT,
  `results_name` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`results_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`results_id`, `results_name`, `active`, `project_id`) VALUES
(1, 'baseline', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `iscu_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_4` (`email`),
  KEY `info_sys` (`iscu_id`),
  KEY `email_2` (`email`),
  KEY `email_3` (`email`),
  KEY `account_id` (`account_id`),
  KEY `status_id` (`status_id`),
  KEY `status_id_2` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `iscu_id`, `account_id`, `email`, `fname`, `lname`, `status_id`) VALUES
(3, 1, 1, 'jasper.cacbay@gmail.com', 'Jasper', 'Cacbay', 1),
(4, 1001, 5, 'testkpi123@gmail.com', 'Test', 'User', 2),
(5, NULL, NULL, 'minnie.pangilinan@gmail.com', 'minnie', 'pangilinan', 3),
(6, NULL, NULL, 'asdf@qwer.zxcv', 'asdf', 'qwer', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE IF NOT EXISTS `user_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` text NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`status_id`, `status_name`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'To confirm');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`kpi_id`) REFERENCES `kpi` (`kpi_id`);

--
-- Constraints for table `field_values`
--
ALTER TABLE `field_values`
  ADD CONSTRAINT `field_values_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`),
  ADD CONSTRAINT `field_values_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `field_values_ibfk_4` FOREIGN KEY (`results_id`) REFERENCES `results` (`results_id`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`output_id`) REFERENCES `output` (`output_id`);

--
-- Constraints for table `iscu`
--
ALTER TABLE `iscu`
  ADD CONSTRAINT `iscu_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `iscu_field`
--
ALTER TABLE `iscu_field`
  ADD CONSTRAINT `iscu_field_ibfk_1` FOREIGN KEY (`iscu_id`) REFERENCES `iscu` (`iscu_id`),
  ADD CONSTRAINT `iscu_field_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`);

--
-- Constraints for table `iscu_updates`
--
ALTER TABLE `iscu_updates`
  ADD CONSTRAINT `iscu_updates_ibfk_1` FOREIGN KEY (`iscu_id`) REFERENCES `iscu` (`iscu_id`),
  ADD CONSTRAINT `iscu_updates_ibfk_2` FOREIGN KEY (`updates_id`) REFERENCES `updates` (`update_id`);

--
-- Constraints for table `kpi`
--
ALTER TABLE `kpi`
  ADD CONSTRAINT `kpi_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `output`
--
ALTER TABLE `output`
  ADD CONSTRAINT `output_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `output_results`
--
ALTER TABLE `output_results`
  ADD CONSTRAINT `output_results_ibfk_1` FOREIGN KEY (`results_id`) REFERENCES `results` (`results_id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`iscu_id`) REFERENCES `iscu` (`iscu_id`),
  ADD CONSTRAINT `users_ibfk_5` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `users_ibfk_6` FOREIGN KEY (`status_id`) REFERENCES `user_status` (`status_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
