-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2017 at 03:20 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ec`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE IF NOT EXISTS `assessment` (
  `assess_code` int(20) NOT NULL AUTO_INCREMENT,
  `assess_type` varchar(50) DEFAULT NULL,
  `assess_due_date` date DEFAULT NULL,
  `assess_final_date` date NOT NULL,
  `dep_name` varchar(64) DEFAULT NULL,
  `mod_title` varchar(64) DEFAULT NULL,
  `semister_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`assess_code`),
  KEY `Mod_Code` (`mod_title`),
  KEY `fk_assessment_semister_id` (`semister_id`),
  KEY `assessment_dep_name` (`dep_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`assess_code`, `assess_type`, `assess_due_date`, `assess_final_date`, `dep_name`, `mod_title`, `semister_id`) VALUES
(14, 'assignment', '2017-04-20', '2017-04-30', 'Computer Science and Engineering', 'C programmimg', 1),
(15, 'exam', '2017-04-25', '2017-05-05', 'Computer Science and Engineering', 'Data structure', 1),
(16, 'exam', '2017-04-30', '2017-05-10', 'English', 'English grammer', 1),
(17, 'exam', '2017-04-27', '2017-05-07', 'English', 'English for Academic purpose', 1),
(18, 'exam', '2017-09-27', '2017-10-07', 'Computer Science and Engineering', 'Algorithm', 2),
(19, 'assignment', '2017-09-20', '2017-09-28', 'Computer Science and Engineering', 'Introduce to Network', 2),
(20, 'exam', '2017-09-30', '2017-10-10', 'English', 'Advance literature', 2),
(21, 'assignment', '2017-08-31', '2017-09-09', 'English', 'DELS', 2),
(22, 'assignment', '2018-04-30', '2018-05-10', 'Computer Science and Engineering', 'Web design', 3),
(23, 'assignment', '2018-04-20', '2018-04-30', 'Computer Science and Engineering', 'Introduce to Python', 3);

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

CREATE TABLE IF NOT EXISTS `claim` (
  `claim_no` int(20) NOT NULL AUTO_INCREMENT,
  `claim_details` varchar(200) DEFAULT NULL,
  `ec_type` varchar(64) NOT NULL,
  `module_title` varchar(64) NOT NULL,
  `assessment` varchar(64) NOT NULL,
  `claim_date` date NOT NULL,
  `last_date` date NOT NULL,
  `evidance_details` varchar(256) NOT NULL DEFAULT 'no exists',
  `file_name` varchar(128) DEFAULT NULL,
  `file_path` varchar(128) DEFAULT NULL,
  `std_id` int(11) NOT NULL,
  `claim_feedback` varchar(64) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`claim_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `claim`
--

INSERT INTO `claim` (`claim_no`, `claim_details`, `ec_type`, `module_title`, `assessment`, `claim_date`, `last_date`, `evidance_details`, `file_name`, `file_path`, `std_id`, `claim_feedback`) VALUES
(17, 'accident, admitted in the hospital', 'accident', 'C programmimg', 'assignment', '2017-03-30', '2017-04-15', 'exists', '58dd2ba73f36a4.25681976.jpg', 'draco/58dd2ba73f36a4.25681976.jpg', 7, 'processing'),
(19, 'extra', 'finance', 'Advance literature', 'exam', '2017-04-05', '2017-04-19', 'no exists', NULL, NULL, 12, 'pending'),
(23, 'financial problem', 'finance', 'Data structure', 'exam', '2017-04-06', '2017-04-20', 'no exists', NULL, NULL, 7, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `dep_name` varchar(100) NOT NULL,
  `fac_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dep_name`),
  KEY `Fac_Name` (`fac_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_name`, `fac_name`) VALUES
('Accounting & Information Systems', 'Business Studies'),
('Management', 'Business Studies'),
('Marketing', 'Business Studies'),
('English', 'humanities'),
('History', 'humanities'),
('Law', 'humanities'),
('Computer Science and Engineering', 'science'),
('Mathematics', 'science'),
('Statistics', 'science');

-- --------------------------------------------------------

--
-- Table structure for table `ecmanager`
--

CREATE TABLE IF NOT EXISTS `ecmanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ecmanager`
--

INSERT INTO `ecmanager` (`id`, `name`, `email`, `password`, `salt`, `joined`, `group`) VALUES
(1, 'ecmanager', 'ecmanager@gmail.com', 'db98fd6751c59253b3afa7569f8273db307b378e121a5d68f94cb71ae58200cb', 'ü!üíp÷‘¶—ÄKHæÚuÌnÏ%þNÇÖi17è%', '2017-03-14 12:38:56', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ec_coo`
--

CREATE TABLE IF NOT EXISTS `ec_coo` (
  `coo_name` varchar(50) DEFAULT NULL,
  `coo_id` int(20) NOT NULL AUTO_INCREMENT,
  `coo_email` varchar(50) DEFAULT NULL,
  `coo_password` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `fac_name` varchar(50) DEFAULT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY (`coo_id`),
  UNIQUE KEY `coo_email` (`coo_email`),
  KEY `Fac_Name` (`fac_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `ec_coo`
--

INSERT INTO `ec_coo` (`coo_name`, `coo_id`, `coo_email`, `coo_password`, `salt`, `fac_name`, `joined`, `group`, `code`) VALUES
('Admin', 7, 'admin@gmail.com', 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', NULL, '0000-00-00 00:00:00', 2, 0),
('EC Manager ', 8, 'mhsporsho05@outlook.com', '2e63880b5396074379c7f61af6ae763cc3d0c5bff95f921f4ca1f55db5ebcb68', 't»Vœl•Qé,µò‡ä>o×6\n—À’ZÜ?²NÁäæÍ', NULL, '0000-00-00 00:00:00', 3, 39010),
('coordinator 2', 10, 'coordinator2@gmail.com', 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', 'Business Studies', '0000-00-00 00:00:00', 4, 0),
('coordinator 3', 12, 'coordinator3@gmail.com', 'b3a0658eb1da6266ff212907cde12c87d9722a3de4e6c919478081b59418b64c', '=`Ú‰cÞ7i*ž•È©\0‘¡`u ‘\\èü¨‹\rÙ%', 'humanities', '0000-00-00 00:00:00', 4, 0),
('coordinator 1', 18, 'coordinator1@gmail.com', '726aa06683d6a7ee52054c697b73a3545f9009cd65fd40054572a7c2b18a3302', '$z	 kcužùÂÔM7”ÍUv#9j™«*è¦[á¶', 'science', '0000-00-00 00:00:00', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `evidance`
--

CREATE TABLE IF NOT EXISTS `evidance` (
  `ev_no` int(20) NOT NULL AUTO_INCREMENT,
  `ev_details` varchar(50) DEFAULT NULL,
  `ev_type` varchar(50) DEFAULT NULL,
  `claim_no` int(20) DEFAULT NULL,
  PRIMARY KEY (`ev_no`),
  KEY `Claim_NO` (`claim_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `fac_name` varchar(100) NOT NULL,
  PRIMARY KEY (`fac_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`fac_name`) VALUES
('Arts'),
('Business Studies'),
('humanities'),
('science');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'standard_User', ''),
(2, 'admin', '{"admin": 1}'),
(3, 'ecmanager', '{"ecmanager": 1}'),
(4, 'coordinator', '{"coordinator": 1}');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `mod_title` varchar(50) NOT NULL,
  `dep_name` varchar(128) DEFAULT NULL,
  `semister_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mod_title`),
  KEY `Course_Name` (`dep_name`),
  KEY `fk_semister_id_semister` (`semister_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`mod_title`, `dep_name`, `semister_id`) VALUES
(' Linear Algebra', 'Statistics', 2),
(' Probability and Inference 2', 'Statistics', 3),
('Advance literature', 'English', 2),
('Algebra.', 'Mathematics', 1),
('Algorithm', 'Computer Science and Engineering', 2),
('Business Law', 'Management', 2),
('Business Research', 'Management', 1),
('C programmimg', 'Computer Science and Engineering', 1),
('Calculas', 'Mathematics', 1),
('Calculus of Several Variables', 'Statistics', 2),
('Combinatorics', 'Mathematics', 2),
('Computer System Fundamental', 'Computer Science and Engineering', 2),
('Constitutional Law', 'Law', 2),
('Consumer Behaviour', 'Marketing', 2),
('Criminal law', 'Law', 2),
('Data structure', 'Computer Science and Engineering', 1),
('DELS', 'English', 2),
('Economics of Innovation and Entrepreneurship', 'Management', 2),
('English for Academic purpose', 'English', 1),
('English grammer', 'English', 1),
('Entrepreneurship', 'Marketing', 1),
('Foundations of Marketing', 'Management', 3),
('Geometry and topology', 'Mathematics', 2),
('International Marketing', 'Marketing', 1),
('Introduce to Network', 'Computer Science and Engineering', 2),
('Introduce to Python', 'Computer Science and Engineering', 3),
('Introduction to Strategic Thinking', 'Management', 1),
('Islamic History', 'History', 2),
('Law and Society', 'Law', 3),
('Liberation war ', 'History', 1),
('Literature', 'English', 1),
('Logic', 'Mathematics', 3),
('Management of Financial Institutions', 'Management', 1),
('Marketing Laws', 'Marketing', 3),
('Marketing Research', 'Marketing', 2),
('Marketing Strategies', 'Marketing', 3),
('Networking', 'Computer Science and Engineering', 3),
('Novel', 'English', 3),
('Number Theroy', 'Mathematics', 3),
('Orientation to Law, Legal System and Legal History', 'Law', 3),
('Past age 1', 'History', 3),
('Phonetics ', 'English', 3),
('Political Science', 'Law', 1),
('Probability and Inference', 'Statistics', 1),
('Psudocode', 'Computer Science and Engineering', 2),
('Regression', 'Statistics', 3),
('Second World War', 'History', 2),
('Sociology', 'Law', 1),
('Statistical Computing', 'Statistics', 1),
('Water lu', 'History', 3),
('Web design', 'Computer Science and Engineering', 2),
('Web Development', 'Computer Science and Engineering', 3),
('World War 1', 'History', 1);

-- --------------------------------------------------------

--
-- Table structure for table `semister`
--

CREATE TABLE IF NOT EXISTS `semister` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semister_name` varchar(32) NOT NULL,
  `closure_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `semister_name` (`semister_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `semister`
--

INSERT INTO `semister` (`id`, `semister_name`, `closure_date`) VALUES
(1, '1st semister', '2017-05-10'),
(2, '2nd semister', '2017-11-10'),
(3, '3rd semister', '2018-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `std_first_name` varchar(50) DEFAULT NULL,
  `std_sur_name` varchar(50) DEFAULT NULL,
  `std_id` int(20) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(64) NOT NULL,
  `semister_id` int(11) DEFAULT NULL,
  `std_batch` varchar(50) DEFAULT NULL,
  `std_email` varchar(50) DEFAULT NULL,
  `std_dob` date DEFAULT NULL,
  `std_gender` varchar(50) DEFAULT NULL,
  `std_uname` varchar(50) DEFAULT NULL,
  `std_password` varchar(64) DEFAULT NULL,
  `salt` varchar(64) NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  `code` int(11) NOT NULL,
  PRIMARY KEY (`std_id`),
  UNIQUE KEY `std_email` (`std_email`),
  KEY `FK_student_department_dep_name` (`dep_name`),
  KEY `student_semister_semister_id` (`semister_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`std_first_name`, `std_sur_name`, `std_id`, `dep_name`, `semister_id`, `std_batch`, `std_email`, `std_dob`, `std_gender`, `std_uname`, `std_password`, `salt`, `joined`, `group`, `code`) VALUES
('MH', 'Dip', 7, 'Computer Science and Engineering', 1, NULL, 'mhsporsho05@outlook.com', NULL, 'male', NULL, 'd4082feccd341944fa0f2d8e4d2e826e1b8aa2a8b202998ef634d3b67896c716', 'ågi"¤‚…á¿«+£ÞÀHfÖÇüîmÀ|Þ', '2017-03-29 00:00:00', 1, 41717),
('Raju', NULL, 8, 'Marketing', 3, NULL, 'raju6647@gmail.com', NULL, 'male', NULL, 'd4082feccd341944fa0f2d8e4d2e826e1b8aa2a8b202998ef634d3b67896c716', 'ågi"¤‚…á¿«+£ÞÀHfÖÇüîmÀ|Þ', '2017-03-29 00:00:00', 1, 0),
('Minhaz', NULL, 9, 'Computer Science and Engineering', 1, NULL, 'Shaon.minhaz@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('Apu', NULL, 10, 'English', 1, NULL, 'apum3552@gmail.com', NULL, NULL, '', 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('student 5', NULL, 11, 'Marketing', 1, NULL, 'student5@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('student 6', NULL, 12, 'Marketing', 1, NULL, 'student6@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('student 7', NULL, 13, 'English', 1, NULL, 'student7@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('Student 8', NULL, 14, 'Marketing', 2, NULL, 'student8@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('Student 9', NULL, 15, 'Computer Science and Engineering', 2, NULL, 'student9@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('student 10', NULL, 16, 'English', 2, NULL, NULL, NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('Student 11', NULL, 17, 'Marketing', 3, NULL, 'student11@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0),
('Student12', NULL, 18, 'Computer Science and Engineering', 3, NULL, 'Student12@gmail.com', NULL, NULL, NULL, 'bd920dbd156f67a1af2d87b1c337464404042d48e0bb69cba21a54d516ff47b3', ',µ¬ÙïÀLl}é³{C-ÛiµZ³*yª”cö¡’É§', '0000-00-00 00:00:00', 1, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `assessment_dep_name` FOREIGN KEY (`dep_name`) REFERENCES `department` (`dep_name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `assessment_ibfk_1` FOREIGN KEY (`mod_title`) REFERENCES `module` (`mod_title`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_assessment_semister_id` FOREIGN KEY (`semister_id`) REFERENCES `semister` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`fac_name`) REFERENCES `faculty` (`fac_name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ec_coo`
--
ALTER TABLE `ec_coo`
  ADD CONSTRAINT `ec_coo_ibfk_1` FOREIGN KEY (`fac_name`) REFERENCES `faculty` (`fac_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_semister_id_semister` FOREIGN KEY (`semister_id`) REFERENCES `semister` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`dep_name`) REFERENCES `department` (`dep_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_student_department_dep_name` FOREIGN KEY (`dep_name`) REFERENCES `department` (`dep_name`),
  ADD CONSTRAINT `student_semister_semister_id` FOREIGN KEY (`semister_id`) REFERENCES `semister` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
