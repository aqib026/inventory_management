-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2017 at 06:04 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hawaveec_fsd`
--

-- --------------------------------------------------------

--
-- Table structure for table `ebay_templates`
--

CREATE TABLE `ebay_templates` (
  `id` int(11) NOT NULL,
  `template_name` varchar(256) NOT NULL,
  `item_description` text NOT NULL,
  `user_member_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ebay_templates`
--

INSERT INTO `ebay_templates` (`id`, `template_name`, `item_description`, `user_member_id`, `updated_at`, `created_at`) VALUES
(3, 'Temp1', '<h2>This is an Amazing product</h2>\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>\r\n<p><img src="http://lorempixel.com/640/480/sports/" /> <img src="http://lorempixel.com/640/480/people/" /> <img src="http://lorempixel.com/640/480/sports/" /></p>', 85, '2017-08-17 12:51:17', '2017-08-10 13:32:41'),
(4, 'temp 2', 'this is my desxription', 85, '2017-08-10 13:37:34', '2017-08-10 13:37:34'),
(5, 'temp 4', 'this is my new new template', 85, '2017-08-10 13:46:45', '2017-08-10 13:46:45'),
(6, 'temp 6', 'this is for testing', 85, '2017-08-10 13:51:20', '2017-08-10 13:51:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ebay_templates`
--
ALTER TABLE `ebay_templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ebay_templates`
--
ALTER TABLE `ebay_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;