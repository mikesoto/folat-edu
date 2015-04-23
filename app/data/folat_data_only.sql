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

--
-- Dumping data for table `folat_categories`
--

INSERT INTO `folat_categories` (`id`, `cat_name`, `cat_description`, `cat_slug`) VALUES
(1, 'Technology', 'Courses related to science and technology', 'technology'),
(2, 'Languages', 'Courses related to languages', 'languages'),
(3, 'Business', 'Courses related to business', 'business'),
(4, 'Arts', 'courses related to the arts', 'arts'),
(8, 'Health & Fitness', 'Courses related to Health', 'health-and-fitness');

--
-- Dumping data for table `folat_content_text_slides`
--

INSERT INTO `folat_content_text_slides` (`id`, `module_id`, `title`, `body`, `order_num`, `refs`) VALUES
(1, 1, 'A little bit of History', 'PHP development began in 1994 when Rasmus Lerdorf wrote a series of Common Gateway Interface (CGI) binaries in C, which he used to maintain his personal homepage. He extended them to add the ability to work with web forms and to communicate with databases, and called this implementation "Personal Home Page/Forms Interpreter" or PHP/FI.', 1, 'Wikipedia. 2014. PHP [Online]. Available at: http://en.wikipedia.org/wiki/PHP#History [Accessed: 22 Jan 2015].'),
(2, 1, 'A little bit more History', 'PHP/FI could be used to build simple, dynamic web applications. Lerdorf initially announced the release of PHP/FI as "Personal Home Page Tools (PHP Tools) version 1.0" publicly to accelerate bug location and improve the code, on the Usenet discussion group comp.infosystems.www.authoring.cgi on June 8, 1995. This release already had the basic functionality that PHP has as of 2013. This included Perl-like variables, form handling, and the ability to embed HTML. The syntax resembled that of Perl but was simpler, more limited and less consistent.', 2, 'Wikipedia. 2014. PHP [Online]. Available at: http://en.wikipedia.org/wiki/PHP#History [Accessed: 22 Jan 2015].'),
(3, 1, 'How PHP Works', 'PHP is a Server Side Programming language. This means that everything it does happens before the web-page is sent to the user''s browser.\n\nIt''s like a middle man between the database and the web-server. The database stores all of your websites information and PHP retrieves that data and builds the HTML which the web server then passes to the users browser.\n\nSo when the user visits a URL, they are requesting a page. PHP then runs the appropriate functions to build that page and sends the resulting HTML through the Web Server which then serves the response (The Web Page) to the user''s Browser.', 3, ''),
(4, 1, 'Installing and configuring PHP', 'There are many ways to install php and get it running on your development computer. However, we will focus on the easiest way to install PHP and get it working with a local web server (Apache) and a local database server (MySql). This is known as a LAMP stack; which stands for Linux, Apache, MySql, PHP. You might also see LAMPP stack where the second P stands for Pearl, but we won''t need to worry about the Pearl Scripting Language for this course. If you are running on a Windows or a Mac machine you will need to install the WAMP versions for Windows and MAMP versions for Mac. There are a variety of providers that let you download a free installer program that requires very little configuration if any. Two of the most popular ones are http://www.easyphp.org/ for windows users and http://www.mamp.info/ for mac users. Be sure to download the correct version for your processor (x86 or 64bit).  MAMP offers a free and Pro version but the free version should be enough if you are just learning', 4, '');

--
-- Dumping data for table `folat_courses`
--

INSERT INTO `folat_courses` (`id`, `course_category_id`, `course_subcat_id`, `course_teacher_id`, `course_title`, `course_slug`, `course_description`, `enrollment_status`, `course_featured`, `course_length`, `course_image`) VALUES
(1, 1, 1, 1, 'Introduction to PHP programming', 'introduction-to-php-programming', 'Short course to help new programmers get started in PHP programming. We will only cover the essentials in this course so if you are an intermediate or advanced programmer, than this is probably not for you. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 1, 0, 'folat_course_1.png'),
(2, 2, 2, 1, 'French 101', 'french-101', 'If you would like to start learning French, this course will get you off to a great start! Learn the basics of gramar, vocabulary, and how to carry on a conversation in French. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 1, 0, 'folat_course_2.png'),
(3, 1, 1, 1, 'Javascript 101', 'javascript-101', 'Short introduction to programming in Javascript.', 1, 1, 0, ''),
(4, 2, 3, 1, 'English Grammar', 'english-grammar', 'Introduction to the English Language.', 0, 0, 0, ''),
(6, 1, 4, 1, 'Web Design Fundamentals', 'web-design-fundamentals', 'The basics of Web Design', 0, 0, 0, ''),
(7, 1, 1, 1, 'MySQL Databases', 'mysql-databases', 'How to use MySQL as a database engine for your apps and websites.', 0, 0, 0, ''),
(22, 1, 1, 1, 'test course', 'test-course', 'Testing Course', 0, 0, 0, 'folat_course_22.png');

--
-- Dumping data for table `folat_enrollment`
--

INSERT INTO `folat_enrollment` (`id`, `user_id`, `course_id`, `enrollment_date`, `status`) VALUES
(1, 1, 1, '2014-10-17 09:34:14', 'Active'),
(2, 1, 2, '2014-10-09 23:38:22', 'Active'),
(3, 3, 1, '2014-11-04 00:49:43', 'Active'),
(4, 3, 2, '2014-11-04 01:16:30', 'Active'),
(5, 4, 1, '2014-11-26 16:01:41', 'Active'),
(6, 2, 1, '2015-01-14 00:00:00', 'Active');

--
-- Dumping data for table `folat_instruct`
--

INSERT INTO `folat_instruct` (`id`, `user_id`, `course_id`, `date`, `status`) VALUES
(1, 1, 1, '2014-10-01 00:00:00', 'Active'),
(2, 1, 2, '2014-10-02 00:00:00', 'Active'),
(3, 1, 3, '2014-11-27 01:19:54', 'Active'),
(4, 1, 4, '2014-11-27 01:25:48', 'Active'),
(6, 1, 6, '2015-01-16 18:51:48', 'Active'),
(7, 1, 7, '2015-01-19 10:51:23', 'Active'),
(22, 1, 22, '2015-01-20 17:20:00', 'Active');

--
-- Dumping data for table `folat_modules`
--

INSERT INTO `folat_modules` (`id`, `course_id`, `type_id`, `title`, `chapter`, `section`, `summary`, `length`, `slug`) VALUES
(1, 1, 1, 'What is PHP?', 1, 1, 'In this section, we will cover a short history of php and what has made it one of the most popular programming languages on the web.', 30, 'what-is-php%3F'),
(2, 1, 1, 'Fdsa2', 1, 2, 'fdsa', 2, 'fdsa2'),
(3, 1, 1, 'Fdsa3', 2, 1, 'fdsa', 2, 'fdsa3');

--
-- Dumping data for table `folat_module_types`
--

INSERT INTO `folat_module_types` (`id`, `name`, `description`) VALUES
(1, 'Text Slides', 'Text slides consist of small slides of text (2-3 paragraphs) paired with review questions. The review questions are presented at the end of the module. ');

--
-- Dumping data for table `folat_review_questions`
--

INSERT INTO `folat_review_questions` (`id`, `slide_id`, `question`, `answer`, `wrong_1`, `wrong_2`, `wrong_3`) VALUES
(1, 1, 'Who was the original developer of PHP?', 'Rasmus Lerdorf', 'Professor Dumbledorf', 'Lee Raznof', 'George Washington'),
(2, 1, 'What does PHP stand for?', 'Personal Home Page', 'Forms Interpreter', 'People Have Problems', 'Pre HTML Processing'),
(3, 2, 'What is your favorite Color?', 'Blue', 'Yellow', '', ''),
(4, 3, 'When does PHP do its thing?', 'Before the web page is sent to the user''s browser', 'After the web page is sent to the user''s browser', 'After the HTML has been created', 'None of these answers is correct'),
(5, 4, 'What does LAMP Stand for?', 'Linux, Apache, MySql, PHP', 'Log, Analyzing, Master, Person', 'Local, Apache, MySql, PHP', 'A thing that you plug into the wall');

--
-- Dumping data for table `folat_subcategories`
--

INSERT INTO `folat_subcategories` (`id`, `subcat_parent_id`, `subcat_name`, `subcat_description`, `subcat_slug`) VALUES
(1, 1, 'Computer Programming', 'Courses related to programming languages, APIs, libraries, and frameworks. ', 'computer-programming'),
(2, 2, 'French', 'Courses covering all levels of the French language. ', 'french'),
(3, 2, 'English', 'Courses covering all levels of the English language. ', 'english'),
(4, 1, 'Web Design', 'Subcategory for courses in Technology specific to Design. ', 'web-design');

--
-- Dumping data for table `folat_users`
--

INSERT INTO `folat_users` (`user_id`, `user_name`, `user_lastname`, `user_email`, `user_username`, `user_password`, `user_about`, `user_image`) VALUES
(1, 'Miguel A.', 'Bonachea', 'desarrollowebuno@gmail.com', 'mikesoto', 'd06b06be888f601407e8703f6c4e0abd', 'I am a LAMP, CodeIgniter and WordPress Programmer with more than 7 Years of Experience in the field of design, interactive media, application development, and server administration.', 'folat_profile_1.png'),
(2, 'Roger', 'Smith', 'rogsmith@test.com', 'rogsmith', '0cb255fa9ab7dc5bd9d7a1d5c6b72082', 'I''m Roger', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
