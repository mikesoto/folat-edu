-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2015 at 08:24 AM
-- Server version: 5.6.11-log
-- PHP Version: 5.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `folat`
--
CREATE DATABASE IF NOT EXISTS `folat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `folat`;

-- --------------------------------------------------------

--
-- Table structure for table `folat_categories`
--

DROP TABLE IF EXISTS `folat_categories`;
CREATE TABLE IF NOT EXISTS `folat_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(128) NOT NULL,
  `cat_description` text NOT NULL,
  `cat_slug` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `folat_categories`
--

INSERT INTO `folat_categories` (`id`, `cat_name`, `cat_description`, `cat_slug`) VALUES
(1, 'Technology', 'Courses related to science and technology', 'technology'),
(2, 'Languages', 'Courses related to languages', 'languages'),
(3, 'Business', 'Courses related to business', 'business'),
(4, 'Arts', 'courses related to the arts', 'arts'),
(5, 'Health & Fitness', 'Courses related to Health', 'health-and-fitness');

-- --------------------------------------------------------

--
-- Table structure for table `folat_content_text_slides`
--

DROP TABLE IF EXISTS `folat_content_text_slides`;
CREATE TABLE IF NOT EXISTS `folat_content_text_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `order_num` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `refs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `folat_content_text_slides`
--

INSERT INTO `folat_content_text_slides` (`id`, `module_id`, `order_num`, `length`, `title`, `body`, `refs`) VALUES
(1, 1, 1, 5, 'A little bit of History', 'PHP development began in 1994 when Rasmus Lerdorf wrote a series of Common Gateway Interface (CGI) binaries in C, which he used to maintain his personal homepage. He extended them to add the ability to work with web forms and to communicate with databases, and called this implementation "Personal Home Page/Forms Interpreter" or PHP/FI.', 'Wikipedia. 2014. PHP [Online]. Available at: http://en.wikipedia.org/wiki/PHP#History [Accessed: 22 Jan 2015].'),
(2, 1, 2, 5, 'A little bit more History', 'PHP/FI could be used to build simple, dynamic web applications. Lerdorf initially announced the release of PHP/FI as "Personal Home Page Tools (PHP Tools) version 1.0" publicly to accelerate bug location and improve the code, on the Usenet discussion group comp.infosystems.www.authoring.cgi on June 8, 1995.<br/>This release already had the basic functionality that PHP has as of 2013. This included Perl-like variables, form handling, and the ability to embed HTML. The syntax resembled that of Perl but was simpler, more limited and less consistent.', 'Wikipedia. 2014. PHP [Online]. Available at: http://en.wikipedia.org/wiki/PHP#History [Accessed: 22 Jan 2015].'),
(3, 1, 3, 20, 'How PHP Works', 'PHP is a Server Side Scripting language. This means that everything it does happens before the web-page is sent to the user''s browser. It''s like a middle man between the database and the web-server. <br/><br/>The database (MySQL) stores all of your websites data and PHP retrieves that data to build HTML pages.<br/><br/>So when the user visits a URL, they are sending a request to the server. All PHP does is builds an HTML response for that request. The web server (Apache) then passes the rendered HTML page (the response) to the users browser and Voila!', ''),
(4, 2, 1, 3, 'Installing and configuring PHP', 'If you already have your development set up you can skip this module. <br/>There are many ways to install PHP and get it running on your development computer.However, we will focus on the easiest way to install PHP and get it working with a local web server (Apache) and a local database server (MySql). This is known as a LAMP stack; which stands for Linux, Apache, MySql, PHP. You might also see LAMPP stack where the second P can stand for Pearl or Python but we won''t need to worry about those Languages for this course. If you are running on a Windows or a Mac machine you will need to install the WAMP versions for Windows and MAMP versions for Mac.', ''),
(5, 2, 3, 3, 'Installing and configuring PHP Part 3', 'If you''ve downloaded and installed your XAMP stack (the X can be L,W, or M depending on your Operating System), than you should be able to access your localhost and view pages programed in PHP. If you don''t have a test page it''s very easy to create one. In your localhost''s public directory (this could be httpdocs/ or localweb/) add a file called test.php and add the following code to it. <br/><br/><pre class="linenums">&lt;?php<br/>phpinfo();<br/>?&gt;<br/></pre><br/>Now save the page and go to your localhost''s URL. This might be something like http://localhost/test.php<br/><br/>You should see a generated PHP info page with all of the information related to your server''s PHP installation. If you don''t see anything than there might be a problem with your XAMP stack installation. Refer to the documentation for your particular provider for help with troubleshooting any problems.', 'http://www.easyphp.org/ http://www.mamp.info/'),
(15, 4, 1, 5, 'The coolest thing I''ve ever done.', 'The coolest thing I''ve ever done is jump off a burning truck onto a helicopter while texting my mom about dinner.', 'Watch my movies dammit!'),
(16, 4, 2, 5, 'Hottest Chicks I''ve ever dated', 'One of the hottest chicks I''ve ever dated was Cameron Díaz.', 'Vanilla Sky'),
(17, 1, 5, 5, 'What Makes PHP So Great?', 'PHP became popular for web programming because of it''s small learning curve and ease of use. Unlike other programming languages that have to be compiled, PHP can just run directly on the server; just FTP the file to the server and view the results. <br/><br/>Additionally, other languages may need special OBDC drivers to be installed to work with popular database engines like MySQL. PHP works right out of the box with these types of databases and you can even use tools like PHPMyAdmin to easily edit and manage your databases. <br/><br/>PHP has been around since 1995 and has grown an extensive user base, great documentation, examples, tutorials, and a novice-friendly community that is always willing to help. Many popular CMS''s and Frameworks like Wordpress, Drupal, Joomla, Symfony, CodeIgniter, and Prestashop all run on PHP.<br/><br/>Since PHP is stable on both Linux and Windows, many web servers have support for it and there is no problem to find hosting with Apache, MySQL, and PHP pre-installed.', ''),
(18, 2, 2, 5, 'Installing and configuring PHP Part 2', 'There are a variety of providers that let you download a free installer program that requires very little configuration (if any). Two of the most popular ones are http://www.easyphp.org/ for windows users and http://www.mamp.info/ for mac users. Be sure to download the correct version for your processor (x86 or 64bit).  MAMP offers a free and Pro version but the free version should be enough if you are just learning. Go ahead and download the installer for your OS and run it to install your Apache web-server with PHP and MySQL. (* If you are running Mac OS X Yosemite you should be able to use the included Apache / PHP /MySQL configuration.)', 'http://www.easyphp.org/<br/>http://www.mamp.info/'),
(19, 2, 4, 5, 'Installing and configuring PHP Part 4', 'If you created the test.php file in the 3rd step you should be able to see all of your PHP installation variables. The one we are concerned with now is called the <strong>Loaded Configuration File</strong> and will tell you the location of your php.ini file. The php.ini is a configuration file that lets you change how PHP will run on your server. Since this is a local server for development purposes, we will activate the <strong>error_reporting</strong> setting by setting it to <strong>E_ALL</strong>. Make sure there is not a <strong>;</strong> before the error_reporting variable or it will be ignored. <br/>Also make sure the display_errors is set to on.<br/>The setting in php.ini should look like this<br/><br/><pre>error_reporting = E_ALL</pre><br/>...<br/><pre>display_errors = On</pre><br/><br/>These errors will help greatly when troubleshooting your code as it will provide some clues as to where and when the errors occurred.', ''),
(20, 3, 1, 5, 'Hello World', 'Let''s start with the simplest thing: A "Hello World" application. <br/><br/>We are going to create a simple php script which prints out some text. <br/>Start by creating a file in your localhost directory called hello_world.php.<br/><br/>In it we are goint to start with the open and close tags for php <br/><pre>&lt;?php <br/><br/>?&gt;<br/></pre><br/>Everything inside the open and close tags will be treated as PHP. This is called Parsing PHP which simply means that the Web Server will read this information differently than the rest of the text on your page such as HTML. It will not be displayed to the user in the resulting web page or in the source code. You can test this by saving the file as it is now and going to http://localhost/hello_world.php  (or wherever you saved the document) and you should get a nice blank page. If you inspect the source code by right clicking anywhere on the page and selecting "view page source" you will see that no code is visible. Now let''s add some text.', ''),
(21, 3, 2, 5, 'Hello World Part 2', 'In order to write text to our document we will use the <strong>echo</strong> command to output our text string to the page. Update your hello_world.php file like so:<br/><pre>&lt;?php <br/>    echo ''Hello World'';<br/></pre><br/>Now save the file and visit the url for the file again: http://localhost/hello_world.php and you should see the text displayed. Great! now let''s look at the syntax. when you echo something to the page it should always be in single or double quotes and you always have to end the command with a (;) semicolon. If you don''t wrap your text string with quotes or double quotes, php will give you a syntax error. Since our script only has one line of code, we could get away with leaving out the semicolon at the end, however it is always a good habit to end your commands with semicolons, in case you add more code later.', ''),
(22, 3, 3, 5, 'Hello World Part 3', 'Now let''s try something else. Let''s define a string variable to hold some data and then use it in our echo command. create a new variable called $name like so:<br/><pre>&lt;?php<br/>   $name = ''Joe'';<br/>   echo ''Hello World'';<br/>?&gt;<br/></pre><br/>In PHP, variables are just containers for things such as text (strings), numbers (integers, floats, etc.), and other types of data. Variable names always start with $ the dollar sign as this identifies them as data containers and not functions.<br/><br/>The $name variable has been created but doesn''t actually do anything yet. Let''s add it to our echo statement so that it get''s displayed: <br/><pre>&lt;?php<br/>   $name = ''Joe'';<br/>   echo ''Hello World and ''.$name;<br/>?&gt;<br/></pre><br/>We have used a (.) period, to add the contents of our variable "Joe" to the end of the string. If you save the file and refresh your browser you should now see "Hello World and Joe". Great! Let''s keep going.', ''),
(26, 7, 1, 5, 'Diferentes etapas informativas en la comunicación.', 'Diferentes etapas informativas en la comunicación.', ''),
(27, 7, 2, 5, 'Problemática', 'Problemática', ''),
(28, 7, 3, 5, 'Casos Prácticos', 'Casos Prácticos', '');

-- --------------------------------------------------------

--
-- Table structure for table `folat_courses`
--

DROP TABLE IF EXISTS `folat_courses`;
CREATE TABLE IF NOT EXISTS `folat_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_category_id` int(11) NOT NULL,
  `course_subcat_id` int(11) NOT NULL,
  `course_teacher_id` int(11) NOT NULL,
  `course_title` varchar(128) NOT NULL,
  `course_slug` varchar(145) NOT NULL,
  `course_description` text NOT NULL,
  `enrollment_status` int(3) NOT NULL DEFAULT '0',
  `course_featured` tinyint(1) NOT NULL DEFAULT '0',
  `course_length` int(11) NOT NULL DEFAULT '0',
  `course_image` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_category_id` (`course_category_id`),
  KEY `course_subcat_id` (`course_subcat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `folat_courses`
--

INSERT INTO `folat_courses` (`id`, `course_category_id`, `course_subcat_id`, `course_teacher_id`, `course_title`, `course_slug`, `course_description`, `enrollment_status`, `course_featured`, `course_length`, `course_image`) VALUES
(1, 1, 1, 1, 'Introduction to PHP programming', 'introduction-to-php-programming', 'Short course to help new programmers get started in PHP programming. We will only cover the essentials in this course so if you are an intermediate or advanced programmer, than this is probably not for you. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 1, 1, 'folat_course_1.png'),
(2, 2, 2, 1, 'French 101', 'french-101', 'If you would like to start learning French, this course will get you off to a great start! Learn the basics of gramar, vocabulary, and how to carry on a conversation in French. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 1, 0, 'folat_course_2.png'),
(3, 1, 1, 1, 'Javascript 101', 'javascript-101', 'Short introduction to programming in Javascript.', 1, 1, 0, ''),
(4, 2, 3, 1, 'English Grammar', 'english-grammar', 'Introduction to the English Language.', 0, 0, 0, ''),
(6, 1, 4, 1, 'Web Design Fundamentals', 'web-design-fundamentals', 'The basics of Web Design', 0, 0, 0, ''),
(7, 1, 1, 1, 'MySQL Databases', 'mysql-databases', 'How to use MySQL as a database engine for your apps and websites.', 0, 0, 0, ''),
(22, 1, 1, 1, 'test course', 'test-course', 'Testing Course', 0, 0, 0, 'folat_course_22.png'),
(24, 1, 1, 1, 'testing 2', 'testing-2', 'fdsafdsa', 0, 0, 0, ''),
(25, 4, 5, 1, 'testing 3', 'testing-3', 'Another Test course', 0, 0, 0, ''),
(27, 4, 5, 3, 'Scientology 101', 'Scientology-101', 'Sooo Coool!!!', 0, 0, 0, ''),
(28, 5, 6, 4, 'Psicología Clinica', 'psicolog%C3%ADa-clinica', 'Aplicar el estudio y la exploración médico-psicológica al examen medico-general, para la detección de factores psicológicos y sociales relacionados con la enfermedad. En un marco de principios éticos. \r\n\r\nAdquirir habilidades de expresión verbal, no verbal, y escrita, en forma clara y comprensible en diferentes escenarios. \r\n\r\nAnalizar las aportaciones de la psicoterapia en la medicina general.', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `folat_enrollment`
--

DROP TABLE IF EXISTS `folat_enrollment`;
CREATE TABLE IF NOT EXISTS `folat_enrollment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` datetime NOT NULL,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `folat_enrollment`
--

INSERT INTO `folat_enrollment` (`id`, `user_id`, `course_id`, `enrollment_date`, `status`) VALUES
(1, 1, 1, '2014-10-17 09:34:14', 'Active'),
(2, 1, 2, '2014-10-09 23:38:22', 'Active'),
(7, 1, 3, '2015-01-25 05:01:20', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `folat_instruct`
--

DROP TABLE IF EXISTS `folat_instruct`;
CREATE TABLE IF NOT EXISTS `folat_instruct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

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
(22, 1, 22, '2015-01-20 17:20:00', 'Active'),
(24, 1, 24, '2015-01-26 23:08:53', 'Active'),
(25, 1, 25, '2015-01-26 23:18:04', 'Active'),
(27, 3, 27, '2015-01-28 00:53:52', 'Active'),
(28, 4, 28, '2015-01-31 01:33:39', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `folat_modules`
--

DROP TABLE IF EXISTS `folat_modules`;
CREATE TABLE IF NOT EXISTS `folat_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `chapter` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `summary` text NOT NULL,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `folat_modules`
--

INSERT INTO `folat_modules` (`id`, `course_id`, `type_id`, `title`, `chapter`, `section`, `summary`, `slug`) VALUES
(1, 1, 1, 'So What is PHP?', 1, 1, 'In this section, we will cover a short history of php and what has made it one of the most popular programming languages on the web.', 'so-what-is-php%3F'),
(2, 1, 1, 'Getting Started With PHP', 1, 2, 'In this section we will get our development environment set up to work with Apache,MySQL, and PHP', 'getting-started-with-php'),
(3, 1, 1, 'Let''s Start Programming!', 2, 1, 'In this module, we will start writing our first PHP script and cover some of the basic syntax that you will use regularly when programming in PHP.', 'lets-start-programming%21'),
(4, 27, 1, 'Why Scientology?', 1, 1, 'Because its awesome!!', 'why-scientology%3F'),
(7, 28, 1, 'Historia de la comunicación', 1, 1, 'Conocer la comunicaciÃ³n en la medicina a lo largo de la historia.', 'historia-de-la-comunicaci%C3%B3n'),
(8, 28, 1, 'Procesos de la comunicación', 1, 2, 'Analizar los procesos de la comunicación', 'procesos-de-la-comunicaci%C3%B3n'),
(9, 28, 1, 'Optimizar la comunicación', 1, 3, 'Como optimizar la comunicación medico-paciente.', 'optimizar-la-comunicaci%C3%B3n'),
(10, 28, 1, 'Análisis y manejo de problemas.', 1, 4, 'Analizar y manejar los problemas asociados a la comunicación.', 'an%C3%A1lisis-y-manejo-de-problemas.');

-- --------------------------------------------------------

--
-- Table structure for table `folat_module_types`
--

DROP TABLE IF EXISTS `folat_module_types`;
CREATE TABLE IF NOT EXISTS `folat_module_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `folat_module_types`
--

INSERT INTO `folat_module_types` (`id`, `name`, `description`) VALUES
(1, 'Text Slides', 'Text slides consist of small slides of text (2-3 paragraphs) paired with review questions. The review questions are presented at the end of the module. ');

-- --------------------------------------------------------

--
-- Table structure for table `folat_review_questions`
--

DROP TABLE IF EXISTS `folat_review_questions`;
CREATE TABLE IF NOT EXISTS `folat_review_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) NOT NULL,
  `question` varchar(145) NOT NULL,
  `answer` varchar(145) NOT NULL,
  `wrong_1` varchar(145) NOT NULL,
  `wrong_2` varchar(145) NOT NULL,
  `wrong_3` varchar(145) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `folat_review_questions`
--

INSERT INTO `folat_review_questions` (`id`, `slide_id`, `question`, `answer`, `wrong_1`, `wrong_2`, `wrong_3`) VALUES
(1, 1, 'Who was the original developer of PHP?', 'Rasmus Lerdorf', 'Professor Dumbledorf', 'Lee Raznof', 'George Washington'),
(2, 1, 'What does PHP stand for?', 'Personal Home Page', 'People Have Problems', 'Program Hex Paradigm', 'Pre Historic Phantoms'),
(4, 3, 'At what point does PHP run on the server?', 'Before the web page is sent to the user''s browser', 'After the web page is sent to the user''s browser', 'After the HTML has been created', 'None of these answers is correct'),
(5, 4, 'What does LAMP Stand for?', 'Linux, Apache, MySql, PHP', 'Log, Analyzing, Master, Person', 'Local, Apache, MySql, PHP', 'A thing that you plug into the wall'),
(6, 2, 'In what year was PHP Tools Version 1.0 Released to the public?', '1995', '1965', '1820', '2013'),
(7, 5, 'What does the phpinfo(); function do?', 'Generate a page with your server''s PHP configuration information.', 'Install PHP on your computer', 'Debug your PHP installation', ''),
(8, 15, 'What was I texting my mom about?', 'Dinner', 'Breakfast', '', ''),
(10, 16, 'What was one of the hottest girl''s I''ve dated?', 'Cameron Di­az', 'Pamela Anderson', 'Opra', 'Woopie Golberg'),
(14, 3, 'Which workflow is in the correct order?', 'User Request -> PHP Retrieves Data-> PHP Builds HTML Page -> Web Server Sends Response', 'User Request -> PHP Builds HTML Page -> PHP Retrieves Data -> Web Server Sends Response', 'Web Server Sends Response -> PHP Builds HTML Page -> PHP Retrieves Data -> User Request', 'User Request -> PHP Retrieves Data-> PHP Takes Coffee Break -> Web Server Sends Response'),
(15, 17, 'What is one of the reasons PHP has become so popular?', 'It natively supports OBDC type databases like MySQL', 'It requires drivers, lots of configuration, and compilers to work on the server.', 'It was the only thing available for web-programming at the time.', 'Poor documentation and an anti-noob community.');

-- --------------------------------------------------------

--
-- Table structure for table `folat_subcategories`
--

DROP TABLE IF EXISTS `folat_subcategories`;
CREATE TABLE IF NOT EXISTS `folat_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcat_parent_id` int(11) NOT NULL,
  `subcat_name` varchar(145) NOT NULL,
  `subcat_description` text NOT NULL,
  `subcat_slug` varchar(155) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `folat_subcategories`
--

INSERT INTO `folat_subcategories` (`id`, `subcat_parent_id`, `subcat_name`, `subcat_description`, `subcat_slug`) VALUES
(1, 1, 'Computer Programming', 'Courses related to programming languages, APIs, libraries, and frameworks. ', 'computer-programming'),
(2, 2, 'French', 'Courses covering all levels of the French language. ', 'french'),
(3, 2, 'English', 'Courses covering all levels of the English language. ', 'english'),
(4, 1, 'Web Design', 'Subcategory for courses in Technology specific to Design. ', 'web-design'),
(5, 4, 'Food', 'Courses related to food', 'food'),
(6, 5, 'Psycology', 'Courses related to psycology', 'psycology');

-- --------------------------------------------------------

--
-- Table structure for table `folat_users`
--

DROP TABLE IF EXISTS `folat_users`;
CREATE TABLE IF NOT EXISTS `folat_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(128) NOT NULL,
  `user_lastname` varchar(128) NOT NULL,
  `user_email` varchar(145) NOT NULL,
  `user_username` varchar(45) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_about` text,
  `user_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `folat_users`
--

INSERT INTO `folat_users` (`user_id`, `user_name`, `user_lastname`, `user_email`, `user_username`, `user_password`, `user_about`, `user_image`) VALUES
(1, 'Miguel A.', 'Bonachea', 'desarrollowebuno@gmail.com', 'mikesoto', 'd06b06be888f601407e8703f6c4e0abd', 'I am a LAMP, CodeIgniter and WordPress Programmer with more than 7 Years of Experience in the field of design, interactive media, application development, and server administration.', 'folat_profile_1.png'),
(2, 'Roger', 'Smith', 'rogsmith@test.com', 'rogsmith', '0cb255fa9ab7dc5bd9d7a1d5c6b72082', 'I''m Roger', ''),
(3, 'Tom', 'Cruise', 'tom@cruise.net', 'tomcruise', 'cb1d4fe7870b37759aad7c575ed173d3', 'I am the best Human Being EVER!!!', 'folat_profile_3.jpg'),
(4, 'logoliz', 'Lopez Gonzalez', 'logoliz@hotmail.com', 'logoliz', 'd315b6f172de8ecb14466c8595783172', 'Soy Bonita', ''),
(5, 'test', 'tesst', 'test@test.com', 'tester', 'c06db68e819be6ec3d26c6038d8e8d1f', NULL, NULL),
(6, 'fdsa', 'fdsa', 'fdsa@fdsa.com', 'fdsafdsa', '6b9260b1e02041a665d4e4a5117cfe16', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
