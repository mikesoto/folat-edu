-- phpMyAdmin SQL Dump
-- version 4.3.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 23, 2015 at 02:50 AM
-- Server version: 5.6.22
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `folat`
--

-- --------------------------------------------------------

--
-- Table structure for table `folat_categories`
--

DROP TABLE IF EXISTS `folat_categories`;
CREATE TABLE IF NOT EXISTS `folat_categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(128) NOT NULL,
  `cat_description` text NOT NULL,
  `cat_slug` varchar(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_content_text_slides`
--

DROP TABLE IF EXISTS `folat_content_text_slides`;
CREATE TABLE IF NOT EXISTS `folat_content_text_slides` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `order_num` int(11) NOT NULL,
  `refs` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_courses`
--

DROP TABLE IF EXISTS `folat_courses`;
CREATE TABLE IF NOT EXISTS `folat_courses` (
  `id` int(11) NOT NULL,
  `course_category_id` int(11) NOT NULL,
  `course_subcat_id` int(11) NOT NULL,
  `course_teacher_id` int(11) NOT NULL,
  `course_title` varchar(128) NOT NULL,
  `course_slug` varchar(145) NOT NULL,
  `course_description` text NOT NULL,
  `enrollment_status` int(3) NOT NULL DEFAULT '0',
  `course_featured` tinyint(1) NOT NULL DEFAULT '0',
  `course_length` int(11) NOT NULL DEFAULT '0',
  `course_image` varchar(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_enrollment`
--

DROP TABLE IF EXISTS `folat_enrollment`;
CREATE TABLE IF NOT EXISTS `folat_enrollment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` datetime NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_instruct`
--

DROP TABLE IF EXISTS `folat_instruct`;
CREATE TABLE IF NOT EXISTS `folat_instruct` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_modules`
--

DROP TABLE IF EXISTS `folat_modules`;
CREATE TABLE IF NOT EXISTS `folat_modules` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `chapter` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `summary` text NOT NULL,
  `length` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_module_types`
--

DROP TABLE IF EXISTS `folat_module_types`;
CREATE TABLE IF NOT EXISTS `folat_module_types` (
  `id` int(11) NOT NULL,
  `name` varchar(145) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_review_questions`
--

DROP TABLE IF EXISTS `folat_review_questions`;
CREATE TABLE IF NOT EXISTS `folat_review_questions` (
  `id` int(11) NOT NULL,
  `slide_id` int(11) NOT NULL,
  `question` varchar(145) NOT NULL,
  `answer` varchar(145) NOT NULL,
  `wrong_1` varchar(145) NOT NULL,
  `wrong_2` varchar(145) NOT NULL,
  `wrong_3` varchar(145) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folat_subcategories`
--

DROP TABLE IF EXISTS `folat_subcategories`;
CREATE TABLE IF NOT EXISTS `folat_subcategories` (
  `id` int(11) NOT NULL,
  `subcat_parent_id` int(11) NOT NULL,
  `subcat_name` varchar(145) NOT NULL,
  `subcat_description` text NOT NULL,
  `subcat_slug` varchar(155) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `folat_users`
--

DROP TABLE IF EXISTS `folat_users`;
CREATE TABLE IF NOT EXISTS `folat_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `user_lastname` varchar(128) NOT NULL,
  `user_email` varchar(145) NOT NULL,
  `user_username` varchar(45) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_about` text,
  `user_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `folat_categories`
--
ALTER TABLE `folat_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_content_text_slides`
--
ALTER TABLE `folat_content_text_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_courses`
--
ALTER TABLE `folat_courses`
  ADD PRIMARY KEY (`id`), ADD KEY `course_category_id` (`course_category_id`), ADD KEY `course_subcat_id` (`course_subcat_id`);

--
-- Indexes for table `folat_enrollment`
--
ALTER TABLE `folat_enrollment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_instruct`
--
ALTER TABLE `folat_instruct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_modules`
--
ALTER TABLE `folat_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_module_types`
--
ALTER TABLE `folat_module_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_review_questions`
--
ALTER TABLE `folat_review_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_subcategories`
--
ALTER TABLE `folat_subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folat_users`
--
ALTER TABLE `folat_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `folat_categories`
--
ALTER TABLE `folat_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `folat_content_text_slides`
--
ALTER TABLE `folat_content_text_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `folat_courses`
--
ALTER TABLE `folat_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `folat_enrollment`
--
ALTER TABLE `folat_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `folat_instruct`
--
ALTER TABLE `folat_instruct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `folat_modules`
--
ALTER TABLE `folat_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `folat_module_types`
--
ALTER TABLE `folat_module_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `folat_review_questions`
--
ALTER TABLE `folat_review_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `folat_subcategories`
--
ALTER TABLE `folat_subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `folat_users`
--
ALTER TABLE `folat_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
