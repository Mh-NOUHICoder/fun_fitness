-- FUN FITNESS Database Structure
-- Version: 1.0
-- Created: 2024

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `fun_fitness`

-- Table structure for table `users`
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `login` varchar(100) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `members`
CREATE TABLE `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(150) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `email` text,
  `phone_num` text,
  `address` text,
  `membership_id` int(11) DEFAULT NULL,
  `join_date` text,
  `gender` text NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `staff`
CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `hire_date` date NOT NULL,
  `role` varchar(50) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `instructors`
CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(150) DEFAULT NULL,
  `l_name` varchar(150) DEFAULT NULL,
  `bio` text,
  `image` text,
  PRIMARY KEY (`instructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `classes`
CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `instructor_id` int(11) DEFAULT NULL,
  `day` varchar(100) DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  KEY `fkey_inst_classes` (`instructor_id`),
  CONSTRAINT `fkey_inst_classes` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `enrollement`
CREATE TABLE `enrollement` (
  `enrollement_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `enrollement_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`enrollement_id`),
  KEY `fkey_mem_enro` (`member_id`),
  KEY `fkey_class_enro` (`class_id`),
  CONSTRAINT `fkey_class_enro` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  CONSTRAINT `fkey_mem_enro` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `prices`
CREATE TABLE `prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` text,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `memberships`
CREATE TABLE `memberships` (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `description` text,
  `duration` int(11) DEFAULT NULL,
  `id_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`membership_id`),
  KEY `fkey_prices_memberships` (`id_price`),
  CONSTRAINT `fkey_prices_memberships` FOREIGN KEY (`id_price`) REFERENCES `prices` (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Sample data insertion (optional - remove for production)
INSERT INTO `users` (`id_user`, `name`, `login`, `pwd`, `role`) VALUES
(1, 'mohamed', 'mhnouhi', '1011', 'admin');

COMMIT;