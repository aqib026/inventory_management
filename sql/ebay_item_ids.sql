-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2017 at 11:03 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hawaveec_fsd`
--

-- --------------------------------------------------------

--
-- Table structure for table `ebay_item_ids`
--

CREATE TABLE `ebay_item_ids` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `ebay_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ebay_item_ids`
--

INSERT INTO `ebay_item_ids` (`id`, `item_id`, `ebay_id`, `created_at`, `updated_at`) VALUES
(2, 874, 110221284878, '2017-08-27 08:20:54', '2017-08-27 08:20:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ebay_item_ids`
--
ALTER TABLE `ebay_item_ids`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ebay_item_ids`
--
ALTER TABLE `ebay_item_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;