-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 07:34 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_rest`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(6, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin@gmail.com', '', '2018-04-09 07:36:18'),
(8, 'abc888', '6d0361d5777656072438f6e314a852bc', 'abc@gmail.com', 'QX5ZMN', '2018-04-13 18:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `admin_codes`
--

CREATE TABLE `admin_codes` (
  `id` int(222) NOT NULL,
  `codes` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_codes`
--

INSERT INTO `admin_codes` (`id`, `codes`) VALUES
(1, 'QX5ZMN'),
(2, 'QFE6ZM'),
(3, 'QMZR92'),
(4, 'QPGIOV'),
(5, 'QSTE52'),
(6, 'QMTZ2J');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(11, 48, 'Bonefish', 'Three ounces of lightly seasoned fresh tilapia ', '55.77', '5ad7582e2ec9c.jpg'),
(12, 48, 'Hard Rock Cafe', 'A mix of chopped lettuces, shredded cheese, chicken cubes', '22.12', '5ad7590d9702b.jpg'),
(13, 49, 'Uno Pizzeria & Grill', 'Kids can choose their pasta shape, type of sauce, favorite veggies (like broccoli or mushrooms)', '12.35', '5ad7597aa0479.jpg'),
(14, 50, 'Red Robins Chick on a Stick', 'Plain grilled chicken breast? Blah.', '34.99', '5ad759e1546fc.jpg'),
(15, 51, 'Lyfe Kitchens Tofu Taco', 'This chain, known for a wide selection of vegetarian and vegan choices', '11.99', '5ad75a1869e93.jpg'),
(16, 52, 'Houlihans Mini Cheeseburger', 'Creekstone Farms, where no antibiotics or growth hormones are used', '22.55', '5ad75a5dbb329.jpg'),
(17, 53, 'jklmno', 'great taste great whatever', '17.99', '5ad79fcf59e66.jpg'),
(23, 8, 'Sev Bhaji', 'Shev is added to spicy gravy', '130.00', '65735784bf89a.jpg'),
(24, 8, 'Tandoori Chicken', 'Tandoori chicken is a chicken dish prepared by roasting chicken marinated in yoghurt and spices in a tandoor', '270.00', '6573576aa3939.jpg'),
(25, 8, 'Paneer Lababdar', 'Paneer ', '275.00', '65735a15a70bf.jpg'),
(27, 9, 'kaju kari', 'Roasted cashew nuts [kaju] cooked in a tomato, onion and spices based rich and creamy sauce.', '280.00', '65737526f3ad9.png');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(62, 32, 'in process', 'hi', '2018-04-18 17:35:52'),
(63, 32, 'closed', 'cc', '2018-04-18 17:36:46'),
(64, 32, 'in process', 'fff', '2018-04-18 18:01:37'),
(65, 32, 'closed', 'its delv', '2018-04-18 18:08:55'),
(66, 34, 'in process', 'on a way', '2018-04-18 18:56:32'),
(67, 35, 'closed', 'ok', '2018-04-18 18:59:08'),
(68, 37, 'in process', 'on the way!', '2018-04-18 19:50:06'),
(69, 37, 'rejected', 'if admin cancel for any reason this box is for remark only for buter perposes', '2018-04-18 19:51:19'),
(70, 37, 'closed', 'delivered success', '2018-04-18 19:51:50'),
(71, 39, 'closed', 'Thanks for ordering from our site', '2023-11-26 12:20:29'),
(72, 40, 'closed', 't', '2023-11-26 16:37:10'),
(73, 39, 'in process', 'bhsa', '2023-11-27 10:56:56'),
(74, 41, 'closed', 'thansk', '2023-12-03 13:50:42'),
(75, 42, 'closed', 'th', '2023-12-03 13:52:02'),
(76, 45, 'closed', 'Thanks', '2023-12-07 18:48:05'),
(77, 47, 'closed', 'Thanks', '2023-12-08 08:11:59'),
(78, 46, 'closed', 'dsadf', '2023-12-13 11:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(8, 9, 'Gaurav Hotel', 'kiranpatil23@gmail.com', '9823248333', 'http://gauravhotel.com', '10am', '8pm', 'mon-sat', ' gat No 133/1 Plot No 2 Bhusawal Rd. Near Khedi Bridge Jalgaon, Jalgaon, Maharashtra 425001 ', '657356854df58.jpg', '2023-12-08 17:46:45'),
(9, 0, 'hotel sandeep food plaza', 'hotelsandeep@gmail.com', '8983123022', 'http://hotelsandeep.com', '10am', '8pm', 'mon-sat', ' Beside Godavari egineering collage, Jalgaon Bhusawal, Road, Jalgaon, Maharashtra 425001 ', '657354aa97ceb.jpg', '2023-12-08 17:38:50'),
(48, 5, 'Hari Burger', 'HariBurger@gmail.com', ' 090412 64676', 'HariBurger.com', '7am', '4pm', 'mon-tue', ' Palace,   natwar jalandhar', '5ad74ce37c383.jpg', '2018-04-18 13:49:23'),
(49, 5, 'The Great Kabab Factory', 'kwbab@gmail.com', '011 2677 9070', 'kwbab.com', '6am', '5pm', 'mon-fri', 'Radisson Blu Plaza Hotel, Delhi Airport, NH-8, New Delhi, 110037', '5ad74de005016.jpg', '2018-04-18 13:53:36'),
(50, 6, 'Aarkay Vaishno Dhaba', 'Vaishno@gmail.com', '090410 35147', 'Vaishno.com', '6am', '6pm', 'mon-sat', 'Bhargav Nagar, Jalandhar - Nakodar Rd, Jalandhar, Punjab 144003', '5ad74e5310ae4.jpg', '2018-04-18 13:55:31'),
(51, 7, 'Martini', 'martin@gmail.com', '3454345654', 'martin.com', '8am', '4pm', 'mon-thu', '399 L Near Apple Showroom, Model Town,', '5ad74ebf1d103.jpg', '2018-04-18 13:57:19'),
(52, 8, 'hudson', 'hud@gmail.com', '2345434567', 'hudson.com', '6am', '7pm', 'mon-fri', 'Opposite Lovely Sweets, Nakodar Road, Jalandhar, Punjab 144001', '5ad756f1429e3.jpg', '2018-04-18 14:32:17'),
(53, 9, 'kriyana store', 'kari@gmail.com', '4512545784', 'kari.com', '7am', '7pm', 'mon-sat', 'near kalu gali hotel india what everrrr.', '5ad79e7d01c5a.jpg', '2018-04-18 19:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(5, 'grill', '2018-04-14 18:45:28'),
(6, 'pizza', '2018-04-14 18:44:56'),
(7, 'pasta', '2018-04-14 18:45:13'),
(8, 'thaifood', '2018-04-14 18:32:56'),
(9, 'fish', '2018-04-14 18:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(1, 'navjot890', 'nav', 'singh', 'nds949405@gmail.com', '6232125458', '6d0361d5777656072438f6e314a852bc', 'badri col phase 1', 1, '2023-12-03 13:24:37'),
(38, 'Dj', 'himanshu', 'kawale', 'himanshukawale@gmail.com', '07558213669', 'f99ff3361fbc2f3d4cbee63c7ef17c86', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-08 11:43:44'),
(39, 'himanshu', 'himanshu', 'kawale', 'himanshukawale@gmail.com', '07558213669', '4122ea4f5490094a33d7cdba65136cf8', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-03 16:06:18'),
(40, 'sagar', 'sagar', 'kawale', 'sagar@gmail.com', '9778457894', 'edebbca907363cb32d973620797525ad', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-06 19:08:45'),
(41, 'Dj', 'himanshu', 'kawale', 'himanshukawale@gmail.com', '07558213669', 'b5e1ef45bb48bc069c484e69f7811aab', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-08 17:10:25'),
(42, 'Dj', 'himanshu', 'kawale', 'himanshukawale89@gmail.com', '07558213669', '16cbea6a406113640207fcd3a672743f', '', 1, '2023-12-26 15:08:34'),
(43, 'Dj', 'himanshu', 'kawale', 'himanshukawale89@gmail.com', '07558213669', '1e36dd471b271a66b5e1bd9dd1bba51f', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-27 06:13:07'),
(44, 'Dj', 'himanshu', 'kawale', 'himanshukawale89@gmail.com', '07558213669', '06dbae8c51f7955dd72b1c4b5c46d581', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-27 07:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rs_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`, `rs_id`) VALUES
(37, 31, 'jklmno', 5, '17.99', 'closed', '2018-04-18 19:51:50', NULL),
(38, 31, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2018-04-18 19:52:34', NULL),
(39, 33, 'Bonefish', 1, '55.77', 'in process', '2023-11-27 10:56:56', NULL),
(40, 33, 'Hard Rock Cafe', 1, '22.12', 'closed', '2023-11-26 16:37:10', NULL),
(43, 38, 'Lyfe Kitchens Tofu Taco', 1, '11.99', NULL, '2023-12-03 13:51:34', NULL),
(45, 38, 'Bonefish', 1, '55.77', 'closed', '2023-12-07 18:48:05', NULL),
(46, 38, 'Bonefish', 2, '55.77', 'closed', '2023-12-13 11:20:42', NULL),
(47, 39, 'Bonefish', 1, '55.77', 'closed', '2023-12-08 08:11:59', NULL),
(48, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-08 08:11:08', NULL),
(49, 41, 'Bonefish', 1, '55.77', NULL, '2023-12-08 17:10:40', NULL),
(50, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', NULL, '2023-12-08 17:12:53', NULL),
(51, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2023-12-08 17:12:54', NULL),
(52, 39, 'Houlihans Mini Cheeseburger', 2, '22.55', NULL, '2023-12-13 10:29:51', NULL),
(53, 39, 'Houlihans Mini Cheeseburger', 2, '22.55', NULL, '2023-12-13 11:21:18', NULL),
(54, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2023-12-13 11:21:18', NULL),
(55, 39, 'Sev Bhaji', 1, '130.00', NULL, '2023-12-27 05:50:34', NULL),
(56, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 05:52:11', NULL),
(57, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 06:03:32', NULL),
(58, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 06:11:23', NULL),
(59, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 06:11:23', NULL),
(60, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 06:11:23', NULL),
(61, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 06:11:23', NULL),
(62, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:14:02', NULL),
(63, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:14:57', NULL),
(64, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:15:10', NULL),
(65, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:19:41', NULL),
(66, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:19:41', NULL),
(67, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:37:03', NULL),
(68, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:37:42', NULL),
(69, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:38:32', NULL),
(70, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:38:42', NULL),
(71, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', NULL, '2023-12-27 06:45:38', NULL),
(72, 44, 'Bonefish', 1, '55.77', NULL, '2023-12-27 07:08:44', NULL),
(73, 44, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 07:08:44', NULL),
(74, 44, 'Bonefish', 1, '55.77', NULL, '2023-12-27 07:09:34', NULL),
(75, 44, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 07:09:34', NULL),
(76, 44, 'Bonefish', 1, '55.77', NULL, '2023-12-27 07:09:39', NULL),
(77, 44, 'Hard Rock Cafe', 1, '22.12', NULL, '2023-12-27 07:09:39', NULL),
(78, 44, 'kaju kari', 2, '280.00', NULL, '2023-12-27 07:11:27', NULL),
(79, 44, 'kaju kari', 2, '280.00', NULL, '2023-12-27 07:12:16', NULL),
(80, 44, 'kaju kari', 2, '280.00', NULL, '2023-12-27 07:14:06', NULL),
(81, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2023-12-27 14:51:05', NULL),
(82, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 14:51:05', NULL),
(83, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2023-12-27 14:52:25', NULL),
(84, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 14:52:25', NULL),
(85, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:13:15', NULL),
(86, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:15:23', NULL),
(87, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:24:00', NULL),
(88, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:24:31', NULL),
(89, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:31:11', NULL),
(90, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:31:12', NULL),
(91, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:31:12', NULL),
(92, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:31:32', NULL),
(93, 39, 'kaju kari', 1, '280.00', NULL, '2023-12-27 15:31:40', NULL),
(94, 39, 'kaju kari', 3, '280.00', NULL, '2023-12-27 15:32:02', NULL),
(95, 39, 'kaju kari', 5, '280.00', NULL, '2023-12-27 15:37:38', NULL),
(96, 39, 'kaju kari', 5, '280.00', NULL, '2023-12-27 15:40:18', NULL),
(97, 39, 'kaju kari', 5, '280.00', NULL, '2023-12-27 15:50:00', NULL),
(98, 39, 'kaju kari', 5, '280.00', NULL, '2023-12-27 15:50:00', NULL),
(99, 39, 'kaju kari', 5, '280.00', NULL, '2023-12-27 15:50:29', NULL),
(100, 39, 'kaju kari', 7, '280.00', NULL, '2023-12-27 15:50:48', NULL),
(101, 39, 'kaju kari', 7, '280.00', NULL, '2023-12-27 15:51:36', NULL),
(102, 39, 'kaju kari', 7, '280.00', NULL, '2023-12-27 15:51:46', NULL),
(103, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', NULL, '2023-12-29 06:50:23', NULL),
(104, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', NULL, '2023-12-29 06:50:35', NULL),
(105, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', NULL, '2023-12-29 06:50:40', NULL),
(106, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', NULL, '2023-12-29 06:52:18', NULL),
(107, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 06:52:40', NULL),
(108, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 06:57:54', NULL),
(109, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2023-12-29 06:57:54', NULL),
(110, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 07:00:52', NULL),
(111, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2023-12-29 07:00:52', NULL),
(112, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 07:01:28', NULL),
(113, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2023-12-29 07:01:28', NULL),
(114, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 07:11:16', NULL),
(115, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 07:12:44', NULL),
(116, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 07:12:46', NULL),
(117, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', NULL, '2023-12-29 07:13:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `admin_codes`
--
ALTER TABLE `admin_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin_codes`
--
ALTER TABLE `admin_codes`
  MODIFY `id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
