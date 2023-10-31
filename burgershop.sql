-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2023 at 09:31 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `burgershop`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(10) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `notes` varchar(1000) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `bill_number`, `item_name`, `quantity`, `unit`, `price`, `notes`, `status`, `datetime`) VALUES
(1, NULL, 'tset', 11, '1', 1, NULL, 'del', '2023-09-21 00:25:33'),
(2, NULL, 'wer', 232, '12', 2332432, NULL, 'del', '2023-09-21 00:29:05'),
(3, NULL, 'Garam Masala', 50, '10', 500, NULL, 'del', '2023-09-21 10:09:31'),
(4, NULL, 'Buns', 100, '30', 3000, NULL, 'del', '2023-09-21 10:09:42'),
(5, NULL, 'Test', 2, '0', 23, NULL, 'del', '2023-09-26 17:55:42'),
(6, NULL, 'Test', 4, 'kilograms', 3, NULL, 'del', '2023-09-26 17:56:23'),
(7, NULL, 'test2', 2, 'kilograms', 200, NULL, 'del', '2023-09-26 17:57:30'),
(8, '123456', 'Test Item edited', 20, 'grams', 400, 'asdfghjk', 'active', '2023-09-26 18:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `item_price` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_image`, `item_price`, `type_id`, `status`, `datetime`) VALUES
(3, 'Beef Burger', 'static/img/items/beef-burger.png', 699, 1, 'active', '2023-09-15 19:41:04'),
(4, 'Coffee Latte', 'static/img/items/coffee-latte.png', 300, 3, 'active', '2023-09-15 20:07:15'),
(6, 'Ice Chocolte', 'static/img/items/ice-chocolate.png', 299, 3, 'active', '2023-09-19 11:37:10'),
(7, 'Ice Tea', 'static/img/items/ice-tea.png', 149, 3, 'active', '2023-09-19 11:37:21'),
(8, 'Matcha Latte', 'static/img/items/matcha-latte.png', 699, 3, 'active', '2023-09-19 11:37:35'),
(9, 'Chocolate Donut', 'static/img/items/choco-glaze-donut.png', 149, 4, 'active', '2023-09-19 11:38:22'),
(10, 'Croissant', 'static/img/items/croissant.png', 799, 5, 'active', '2023-09-19 11:38:35'),
(11, 'Chocolate Glaze Donut', 'static/img/items/choco-glaze-donut-peanut.png', 179, 4, 'active', '2023-09-19 11:38:56'),
(12, 'Red Glaze Donut', 'static/img/items/red-glaze-donut.png', 179, 4, 'active', '2023-09-19 11:39:09'),
(13, 'Shawarma', 'static/img/items/sawarma.png', 199, 5, 'active', '2023-09-19 11:39:23'),
(14, 'Chicken Sandwith', 'static/img/items/sandwich.png', 249, 5, 'active', '2023-09-19 11:39:46'),
(15, 'Fajita Pizza', 'static/img/items/images.jpeg', 1599, 2, 'active', '2023-09-19 18:09:40'),
(16, 'Zinger Burger', 'static/img/items/download.jpeg', 399, 1, 'del', '2023-09-19 21:28:12'),
(17, 'Item 1', 'static/img/items/', 100, 7, 'del', '2023-10-20 23:49:28'),
(18, 'Item 1', 'static/img/items/', 100, 7, 'del', '2023-10-20 23:49:42'),
(19, 'item 1', 'static/img/items/', 123, 7, 'del', '2023-10-20 23:52:58'),
(20, '123', 'static/img/items/rr.jpg', 123, 7, 'del', '2023-10-20 23:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `net_total` int(11) NOT NULL,
  `sales_tax` int(11) NOT NULL DEFAULT 0,
  `discount_percentage` int(11) NOT NULL DEFAULT 0,
  `discount_amount` int(11) NOT NULL DEFAULT 0,
  `grand_total` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `net_total`, `sales_tax`, `discount_percentage`, `discount_amount`, `grand_total`, `status`, `operator`, `datetime`) VALUES
(1695273259, 0, 0, 0, 0, 1698, 'del', 'admin', '2023-09-21 10:14:19'),
(1695274547, 0, 0, 0, 0, 999, 'del', 'admin', '2023-09-21 10:35:47'),
(1695274549, 0, 0, 0, 0, 448, 'del', 'admin', '2023-09-21 10:35:49'),
(1695274574, 0, 0, 0, 0, 1848, 'del', 'admin', '2023-09-21 10:36:14'),
(1695274611, 0, 0, 0, 0, 777, 'del', 'admin', '2023-09-21 10:36:51'),
(1695274629, 0, 0, 0, 0, 897, 'del', 'admin', '2023-09-21 10:37:09'),
(1695378787, 0, 0, 0, 0, 699, 'active', 'admin', '2023-09-22 15:33:07'),
(1695736582, 0, 0, 0, 0, 3198, 'active', 'admin', '2023-09-26 18:56:22'),
(1695805630, 699, 35, 15, 105, 629, 'active', 'admin', '2023-09-27 14:07:10'),
(1695808978, 1298, 65, 10, 130, 1233, 'active', 'admin', '2023-09-27 15:02:58'),
(1695809372, 1446, 72, 0, 0, 1518, 'active', 'admin', '2023-09-27 15:09:32'),
(1695809485, 1298, 65, 5, 65, 1298, 'del', 'admin', '2023-09-27 15:11:25'),
(1696915542, 1447, 72, 0, 0, 1519, 'active', 'admin', '2023-10-10 10:25:42'),
(1696915565, 1447, 72, 0, 0, 1519, 'del', 'admin', '2023-10-10 10:26:05'),
(1696922867, 1976, 99, 0, 0, 2075, 'del', 'admin', '2023-10-10 12:27:47'),
(1696925862, 3124, 156, 5, 156, 3124, 'del', 'admin', '2023-10-10 13:17:42'),
(1696927422, 599, 30, 0, 0, 629, 'del', 'admin', '2023-10-10 13:43:42'),
(1696927664, 2474, 124, 20, 495, 2103, 'del', 'admin', '2023-10-10 13:47:44'),
(1696927687, 6217, 311, 20, 1243, 5284, 'del', 'admin', '2023-10-10 13:48:07'),
(1696927812, 3124, 156, 20, 625, 2655, 'del', 'admin', '2023-10-10 13:50:12'),
(1697090498, 1447, 72, 25, 362, 1158, 'active', 'admin', '2023-10-12 11:01:38'),
(1697090842, 5121, 256, 20, 1024, 4353, 'active', 'admin', '2023-10-12 11:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`, `unit_price`, `sub_total`, `status`, `datetime`) VALUES
(61, 1695273259, 3, 2, 699, 1398, 'del', '2023-09-21 10:14:19'),
(62, 1695273259, 4, 1, 300, 300, 'del', '2023-09-21 10:14:19'),
(63, 1695274547, 3, 1, 699, 699, 'del', '2023-09-21 10:35:47'),
(64, 1695274547, 4, 1, 300, 300, 'del', '2023-09-21 10:35:47'),
(65, 1695274549, 7, 1, 149, 149, 'del', '2023-09-21 10:35:49'),
(66, 1695274549, 6, 1, 299, 299, 'del', '2023-09-21 10:35:49'),
(67, 1695274574, 15, 1, 1599, 1599, 'del', '2023-09-21 10:36:14'),
(68, 1695274574, 14, 1, 249, 249, 'del', '2023-09-21 10:36:14'),
(69, 1695274611, 12, 1, 179, 179, 'del', '2023-09-21 10:36:51'),
(70, 1695274611, 13, 1, 199, 199, 'del', '2023-09-21 10:36:51'),
(71, 1695274611, 16, 1, 399, 399, 'del', '2023-09-21 10:36:51'),
(72, 1695274629, 6, 3, 299, 897, 'del', '2023-09-21 10:37:09'),
(73, 1695378787, 3, 1, 699, 699, 'active', '2023-09-22 15:33:07'),
(74, 1695736582, 15, 2, 1599, 3198, 'active', '2023-09-26 18:56:22'),
(75, 1695805630, 3, 1, 699, 699, 'active', '2023-09-27 14:07:10'),
(76, 1695808978, 4, 1, 300, 300, 'active', '2023-09-27 15:02:58'),
(77, 1695808978, 3, 1, 699, 699, 'active', '2023-09-27 15:02:58'),
(78, 1695808978, 6, 1, 299, 299, 'active', '2023-09-27 15:02:58'),
(79, 1695809372, 6, 2, 299, 598, 'active', '2023-09-27 15:09:32'),
(80, 1695809372, 7, 1, 149, 149, 'active', '2023-09-27 15:09:32'),
(81, 1695809372, 3, 1, 699, 699, 'active', '2023-09-27 15:09:32'),
(82, 1695809485, 3, 1, 699, 699, 'del', '2023-09-27 15:11:25'),
(83, 1695809485, 4, 1, 300, 300, 'del', '2023-09-27 15:11:25'),
(84, 1695809485, 6, 1, 299, 299, 'del', '2023-09-27 15:11:25'),
(85, 1696915542, 3, 1, 699, 699, 'active', '2023-10-10 10:25:42'),
(86, 1696915542, 4, 1, 300, 300, 'active', '2023-10-10 10:25:42'),
(87, 1696915542, 6, 1, 299, 299, 'active', '2023-10-10 10:25:42'),
(88, 1696915542, 7, 1, 149, 149, 'active', '2023-10-10 10:25:42'),
(89, 1696915565, 3, 1, 699, 699, 'del', '2023-10-10 10:26:05'),
(90, 1696915565, 4, 1, 300, 300, 'del', '2023-10-10 10:26:05'),
(91, 1696915565, 6, 1, 299, 299, 'del', '2023-10-10 10:26:05'),
(92, 1696915565, 7, 1, 149, 149, 'del', '2023-10-10 10:26:05'),
(93, 1696922867, 6, 1, 299, 299, 'del', '2023-10-10 12:27:47'),
(94, 1696922867, 3, 1, 699, 699, 'del', '2023-10-10 12:27:47'),
(95, 1696922867, 11, 1, 179, 179, 'del', '2023-10-10 12:27:47'),
(96, 1696922867, 10, 1, 799, 799, 'del', '2023-10-10 12:27:47'),
(97, 1696925862, 3, 1, 699, 699, 'del', '2023-10-10 13:17:42'),
(98, 1696925862, 4, 1, 300, 300, 'del', '2023-10-10 13:17:42'),
(99, 1696925862, 6, 1, 299, 299, 'del', '2023-10-10 13:17:42'),
(100, 1696925862, 7, 1, 149, 149, 'del', '2023-10-10 13:17:42'),
(101, 1696925862, 10, 1, 799, 799, 'del', '2023-10-10 13:17:42'),
(102, 1696925862, 8, 1, 699, 699, 'del', '2023-10-10 13:17:42'),
(103, 1696925862, 12, 1, 179, 179, 'del', '2023-10-10 13:17:42'),
(104, 1696927422, 4, 1, 300, 300, 'del', '2023-10-10 13:43:42'),
(105, 1696927422, 6, 1, 299, 299, 'del', '2023-10-10 13:43:42'),
(106, 1696927664, 3, 1, 699, 699, 'del', '2023-10-10 13:47:44'),
(107, 1696927664, 4, 1, 300, 300, 'del', '2023-10-10 13:47:44'),
(108, 1696927664, 6, 1, 299, 299, 'del', '2023-10-10 13:47:44'),
(109, 1696927664, 7, 1, 149, 149, 'del', '2023-10-10 13:47:44'),
(110, 1696927664, 11, 1, 179, 179, 'del', '2023-10-10 13:47:44'),
(111, 1696927664, 9, 1, 149, 149, 'del', '2023-10-10 13:47:44'),
(112, 1696927664, 8, 1, 699, 699, 'del', '2023-10-10 13:47:44'),
(113, 1696927687, 3, 3, 699, 2097, 'del', '2023-10-10 13:48:07'),
(114, 1696927687, 4, 1, 300, 300, 'del', '2023-10-10 13:48:07'),
(115, 1696927687, 6, 3, 299, 897, 'del', '2023-10-10 13:48:07'),
(116, 1696927687, 7, 3, 149, 447, 'del', '2023-10-10 13:48:07'),
(117, 1696927687, 11, 1, 179, 179, 'del', '2023-10-10 13:48:07'),
(118, 1696927687, 8, 1, 699, 699, 'del', '2023-10-10 13:48:07'),
(119, 1696927687, 10, 2, 799, 1598, 'del', '2023-10-10 13:48:07'),
(120, 1696927812, 3, 1, 699, 699, 'del', '2023-10-10 13:50:12'),
(121, 1696927812, 4, 1, 300, 300, 'del', '2023-10-10 13:50:12'),
(122, 1696927812, 6, 1, 299, 299, 'del', '2023-10-10 13:50:12'),
(123, 1696927812, 10, 1, 799, 799, 'del', '2023-10-10 13:50:12'),
(124, 1696927812, 8, 1, 699, 699, 'del', '2023-10-10 13:50:12'),
(125, 1696927812, 11, 1, 179, 179, 'del', '2023-10-10 13:50:12'),
(126, 1696927812, 7, 1, 149, 149, 'del', '2023-10-10 13:50:12'),
(127, 1697090498, 3, 1, 699, 699, 'active', '2023-10-12 11:01:38'),
(128, 1697090498, 4, 1, 300, 300, 'active', '2023-10-12 11:01:38'),
(129, 1697090498, 6, 1, 299, 299, 'active', '2023-10-12 11:01:38'),
(130, 1697090498, 7, 1, 149, 149, 'active', '2023-10-12 11:01:38'),
(131, 1697090842, 3, 1, 699, 699, 'active', '2023-10-12 11:07:22'),
(132, 1697090842, 4, 1, 300, 300, 'active', '2023-10-12 11:07:22'),
(133, 1697090842, 6, 1, 299, 299, 'active', '2023-10-12 11:07:22'),
(134, 1697090842, 7, 1, 149, 149, 'active', '2023-10-12 11:07:22'),
(135, 1697090842, 10, 1, 799, 799, 'active', '2023-10-12 11:07:22'),
(136, 1697090842, 9, 1, 149, 149, 'active', '2023-10-12 11:07:22'),
(137, 1697090842, 8, 1, 699, 699, 'active', '2023-10-12 11:07:22'),
(138, 1697090842, 12, 1, 179, 179, 'active', '2023-10-12 11:07:22'),
(139, 1697090842, 14, 1, 249, 249, 'active', '2023-10-12 11:07:22'),
(140, 1697090842, 15, 1, 1599, 1599, 'active', '2023-10-12 11:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `saving_records`
--

CREATE TABLE `saving_records` (
  `id` int(11) NOT NULL,
  `total_sale` int(11) NOT NULL DEFAULT 0,
  `total_savings` int(11) NOT NULL DEFAULT 0,
  `comments` text DEFAULT NULL,
  `operator` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saving_records`
--

INSERT INTO `saving_records` (`id`, `total_sale`, `total_savings`, `comments`, `operator`, `status`, `datetime`) VALUES
(1, 20000, 19989, 'test', 'admin', 'del', '2023-09-21 19:15:21'),
(2, 20000, 19768, '232', 'admin', 'del', '2023-09-21 19:16:48'),
(3, 20000, 19768, '232', 'admin', 'del', '2023-09-21 19:16:49'),
(4, 5770, 5187, 'Testing Purpose', 'admin', 'del', '2023-09-21 19:39:59'),
(5, 5770, 5187, 'Testing Purpose', 'admin', 'del', '2023-09-21 19:40:34'),
(6, 5770, 5193, 'test', 'admin', 'del', '2023-09-21 19:41:16'),
(7, 699, 469, 'One Burger Sale', 'admin', 'del', '2023-09-22 15:34:27'),
(8, 8575, 15575, 'Testing', 'admin', 'del', '2023-09-27 18:05:04'),
(9, 9954, 9954, 'test', 'admin', 'del', '2023-10-12 11:06:28'),
(10, 9954, 7954, '1234', 'admin', 'active', '2023-10-12 11:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `saving_records_items`
--

CREATE TABLE `saving_records_items` (
  `id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_value` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saving_records_items`
--

INSERT INTO `saving_records_items` (`id`, `record_id`, `item_name`, `item_value`, `status`, `datetime`) VALUES
(1, 1, 'test', 11, 'del', '2023-09-21 19:15:21'),
(2, 1, 'test', 11, 'del', '2023-09-21 19:15:21'),
(3, 1, 'test', 11, 'del', '2023-09-21 19:15:21'),
(4, 2, '232', 232, 'del', '2023-09-21 19:16:48'),
(5, 3, '232', 232, 'del', '2023-09-21 19:16:49'),
(6, 4, 'thing1', 230, 'del', '2023-09-21 19:39:59'),
(7, 4, 'thing2', 230, 'del', '2023-09-21 19:39:59'),
(8, 4, 'thing3', 123, 'del', '2023-09-21 19:39:59'),
(9, 5, 'thing1', 230, 'del', '2023-09-21 19:40:34'),
(10, 5, 'thing2', 230, 'del', '2023-09-21 19:40:34'),
(11, 5, 'thing3', 123, 'del', '2023-09-21 19:40:34'),
(12, 6, 'hi there', 234, 'del', '2023-09-21 19:41:16'),
(13, 6, 'test', 343, 'del', '2023-09-21 19:41:16'),
(14, 7, 'Buns', 60, 'del', '2023-09-22 15:34:27'),
(15, 7, 'Lattuce', 40, 'del', '2023-09-22 15:34:27'),
(16, 7, 'Ketchup', 30, 'del', '2023-09-22 15:34:27'),
(17, 7, 'Chicken', 100, 'del', '2023-09-22 15:34:27'),
(18, 8, 'Daal Roti', -2000, 'del', '2023-09-27 18:05:04'),
(19, 8, 'Salary', -5000, 'del', '2023-09-27 18:05:04'),
(20, 9, 'My test expense', 2000, 'del', '2023-10-12 11:06:28'),
(21, 9, 'My test expense 2', -2000, 'del', '2023-10-12 11:06:28'),
(22, 10, 'test', 2000, 'active', '2023-10-12 11:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`, `status`, `datetime`) VALUES
(1, 'Burger', 'active', '2023-09-15 18:07:15'),
(2, 'Pizza', 'active', '2023-09-15 18:07:24'),
(3, 'Beverages', 'active', '2023-09-15 18:30:06'),
(4, 'Sweets', 'active', '2023-09-19 11:38:00'),
(5, 'Others', 'active', '2023-09-19 11:38:06'),
(6, 'Salts', 'del', '2023-10-20 23:48:10'),
(7, 'Category 1', 'del', '2023-10-20 23:48:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_type`, `status`) VALUES
(1, 'admin', 'YWRtaW5AMTIz', 'admin', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `saving_records`
--
ALTER TABLE `saving_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saving_records_items`
--
ALTER TABLE `saving_records_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1697090843;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `saving_records`
--
ALTER TABLE `saving_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `saving_records_items`
--
ALTER TABLE `saving_records_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
