-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2024 at 06:38 PM
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
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `party_size` int(11) NOT NULL,
  `special_requests` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `table_id`, `rs_id`, `customer_name`, `contact_number`, `email`, `booking_date`, `booking_time`, `party_size`, `special_requests`) VALUES
(4, 4, 50, 'himanshu rajendra kawale', '7558213669', 'himanshukawale@gmail.com', '2024-01-09', '12:02:00', 4, 'Silence needed'),
(5, 9, 8, 'mahesh chaudhari', '9551759845', 'maheshchau@gmail.com', '2024-02-12', '12:00:00', 5, 'silence needed with fast services on the occasion of birthday');

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
(27, 9, 'kaju kari', 'Roasted cashew nuts [kaju] cooked in a tomato, onion and spices based rich and creamy sauce.', '280.00', '65737526f3ad9.png'),
(29, 8, 'paneer angara', 'The spicy gravy in this paneer recipe is made with a base of onions and tomatoes.', '260.00', '65c3d190710c4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `name` text,
  `feedback_email` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `message` text,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `rs_id`, `name`, `feedback_email`, `rating`, `message`, `submission_date`) VALUES
(1, 8, 'himanshu rajendra kawale', 'himanshukawale882@gmail.com', 4, 'Good food at all! Good quality and affordable!', '2023-12-30 17:41:23'),
(2, 50, 'ritika suryavanshi', 'ritikasuryavanshi@gmail.com', 4, 'Good restaurant at all !', '2024-01-24 06:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_inventory`
--

CREATE TABLE `inventory_inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `reorder_point` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_order_items`
--

CREATE TABLE `inventory_order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_products`
--

CREATE TABLE `inventory_products` (
  `product_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_products`
--

INSERT INTO `inventory_products` (`product_id`, `title`, `description`, `category`, `unit_price`, `supplier_id`, `rs_id`, `created_at`, `updated_at`) VALUES
(1, '10 kg oil', 'pure oil ', 'grocery', '1000.00', 3, 8, '2024-02-10 05:12:09', '2024-02-10 05:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_purchase_orders`
--

CREATE TABLE `inventory_purchase_orders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_purchase_orders`
--

INSERT INTO `inventory_purchase_orders` (`order_id`, `product_id`, `supplier_id`, `order_date`, `delivery_date`, `total_amount`, `rs_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-02-16', '2024-02-16', '1000.00', 8, '2024-02-10 06:06:10', '2024-02-26 15:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_suppliers`
--

CREATE TABLE `inventory_suppliers` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_suppliers`
--

INSERT INTO `inventory_suppliers` (`supplier_id`, `name`, `contact_person`, `email`, `phone`, `address`, `rs_id`, `created_at`, `updated_at`) VALUES
(1, 'tata industries', 'ratan tata', 'ratantata@gmail.com', '8974748372', 'mj college, jalgaon', 8, '2024-02-10 04:08:11', '2024-02-10 04:08:11'),
(3, 'adani grocery', 'gautam adani', 'gautamadani@gmail.com', '9898078879', 'csmt,mumbai', 8, '2024-02-10 04:45:04', '2024-02-10 04:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `transaction_type` enum('purchase','sale','adjustment') DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `notes` text,
  `rs_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_transactions`
--

INSERT INTO `inventory_transactions` (`transaction_id`, `product_id`, `transaction_type`, `quantity`, `transaction_date`, `notes`, `rs_id`, `created_at`) VALUES
(1, 1, 'purchase', 1, '2024-03-12', 'for 10 kg oil', 8, '2024-02-26 17:14:51'),
(2, 1, 'sale', 2, '2024-04-13', 'ynf', 8, '2024-02-26 17:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `l_id` int(11) NOT NULL,
  `rs_id` int(11) NOT NULL,
  `loc` text NOT NULL,
  `lattitude` text NOT NULL,
  `longitude` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`l_id`, `rs_id`, `loc`, `lattitude`, `longitude`) VALUES
(1, 8, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6264.2908779599!2d75.58952296224278!3d21.001869192104692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd90f1baab5ba4d%3A0x250e3fd87aa52598!2sHOTEL%20GAURAV!5e0!3m2!1sen!2sin!4v1704199703364!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '20.8752721', '75.7939938'),
(2, 9, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29797.50034458635!2d75.5601597743164!3d21.005158500000018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd90f056c2135a5%3A0xb15b876ddb93b9e4!2sHotel%20Sandeep%20Food%20Plaza!5e0!3m2!1sen!2sin!4v1704202326444!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '21.0042138', '75.5979893'),
(3, 48, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13629.57107565218!2d75.56228668715819!3d31.348139000000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5b23bc25b145%3A0x101c999a632ac673!2sHARI%20BURGER!5e0!3m2!1sen!2sin!4v1704203441414!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '31.3260152', '75.5761829'),
(4, 49, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224119.4943573677!2d76.92869688671873!3d28.633745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd481be10e37%3A0x379fb83057de230f!2sThe%20Great%20Kabab%20Factory!5e0!3m2!1sen!2sin!4v1704203517402!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '28.5438333', '77.1201521'),
(5, 50, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27265.630888342184!2d75.53176609893642!3d31.325742612244888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5afeb2e15555%3A0x1d939895320e39a9!2sAAR%20KAY%20VAISHNO%20DHABA!5e0!3m2!1sen!2sin!4v1704203625625!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '31.3119681', '75.5647688'),
(6, 52, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3408.2811069257914!2d75.56958488885498!3d31.32360890000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5bf74efdc1dd%3A0x2245be3de9e920d3!2sLovely%20Sweets!5e0!3m2!1sen!2sin!4v1704204039515!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '31.3236089', '75.574091'),
(7, 51, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3423.5419275435784!2d75.82317083982271!3d30.899472974610347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a83c621b4feb5%3A0x79946e1f31de9c90!2sMartini%20In%20The%20Clouds!5e0!3m2!1sen!2sin!4v1704203901334!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '30.8883034', '75.8401776'),
(8, 53, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112033.48342827838!2d77.0825548433594!3d28.6583306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd0fdf000001%3A0x6bfed72db371d515!2sHotel%20India!5e0!3m2!1sen!2sin!4v1704204227620!5m2!1sen!2sin\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '28.6139391', '77.2090212');

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
(78, 46, 'closed', 'dsadf', '2023-12-13 11:20:42'),
(79, 397, 'in process', 'Thank you', '2024-01-11 14:12:06'),
(80, 333, 'in process', 'Thanks', '2024-01-22 12:34:06'),
(81, 528, 'in process', 'thanks', '2024-01-23 19:52:40'),
(82, 528, 'closed', 'Thanks for order', '2024-01-23 19:53:57'),
(83, 527, 'in process', 'Stay Healthy!', '2024-01-23 19:55:59'),
(84, 527, 'closed', 'Welcome to our community', '2024-01-23 19:57:52'),
(85, 527, 'in process', 'bye', '2024-01-23 19:59:36'),
(86, 527, 'in process', 'bye', '2024-01-23 20:00:03'),
(87, 537, 'in process', '!thanks you have a good day !', '2024-02-01 13:33:56'),
(88, 538, 'closed', 'thanks you have a good day !', '2024-02-01 13:34:38'),
(89, 536, 'closed', 'thanks you have a good day', '2024-02-01 13:35:21'),
(90, 535, 'in process', 'thanks you have a good day', '2024-02-01 13:35:52'),
(91, 402, 'closed', 'done', '2024-02-07 16:27:26');

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
(8, 9, 'Gaurav Hotel,jalgaon', 'kiranpatil23@gmail.com', '9823248333', 'http://gauravhotel.com', '6am', '3pm', 'mon-tue', '2H4Q+R94, Unnamed Road, Ayodhya Nagar, Old MIDC, Jalgaon, Maharashtra 425003', '657356854df58.jpg', '2024-02-07 15:32:40'),
(9, 0, 'hotel sandeep food plaza', 'hotelsandeep@gmail.com', '8983123022', 'http://hotelsandeep.com', '10am', '8pm', 'mon-sat', 'Beside Godawari egineering collage, Jalgaon Bhusawal, Road, Jalgaon, Maharashtra 425001', '657354aa97ceb.jpg', '2024-01-25 13:29:38'),
(48, 5, 'Hari Burger', 'HariBurger@gmail.com', ' 090412 64676', 'HariBurger.com', '7am', '4pm', 'mon-tue', ' Palace,   natwar jalandhar', '5ad74ce37c383.jpg', '2018-04-18 13:49:23'),
(49, 5, 'The Great Kabab Factory', 'kwbab@gmail.com', '011 2677 9070', 'kwbab.com', '6am', '5pm', 'mon-fri', 'Radisson Blu Plaza Hotel, Delhi Airport, NH-8, New Delhi, 110037', '5ad74de005016.jpg', '2018-04-18 13:53:36'),
(50, 6, 'Aarkay Vaishno Dhaba', 'Vaishno@gmail.com', '090410 35147', 'Vaishno.com', '6am', '6pm', 'mon-sat', 'Bhargav Nagar, Jalandhar - Nakodar Rd, Jalandhar, Punjab 144003', '5ad74e5310ae4.jpg', '2018-04-18 13:55:31'),
(51, 7, 'Martini', 'martin@gmail.com', '3454345654', 'martin.com', '8am', '4pm', 'mon-thu', '399 L Near Apple Showroom, Model Town,', '5ad74ebf1d103.jpg', '2018-04-18 13:57:19'),
(52, 8, 'hudson', 'hud@gmail.com', '2345434567', 'hudson.com', '6am', '7pm', 'mon-fri', 'Opposite Lovely Sweets, Nakodar Road, Jalandhar, Punjab 144001', '5ad756f1429e3.jpg', '2018-04-18 14:32:17'),
(53, 9, 'kriyana store', 'kari@gmail.com', '4512545784', 'kari.com', '7am', '7pm', 'mon-sat', 'near kalu gali hotel delhi', '5ad79e7d01c5a.jpg', '2024-01-25 12:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_admins`
--

CREATE TABLE `restaurant_admins` (
  `ad_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_admins`
--

INSERT INTO `restaurant_admins` (`ad_id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `gender`, `rs_id`, `address`) VALUES
(1, 'himanshu', '4122ea4f5490094a33d7cdba65136cf8', 'himanshukawale@gmail.com', 'himanshu', 'kawale', '7558213669', 'Male', 8, 'Khalchi aali,mahajan wada,nashirabad');

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
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `rs_id` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `is_booked` tinyint(1) DEFAULT '0',
  `table_name` varchar(50) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `rs_id`, `capacity`, `is_booked`, `table_name`, `description`) VALUES
(2, 48, 15, 0, 'Hari bhai', 'Amazing natural view'),
(3, 8, 10, 1, 'flying corner', 'beautiful view'),
(4, 50, 4, 1, 'table1', 'good'),
(8, 8, 5, 0, 'table1', 'fastest service '),
(9, 8, 10, 1, 'AC luxary', 'luxarious table with AC ');

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
(44, 'Dj', 'himanshu', 'kawale', 'himanshukawale89@gmail.com', '07558213669', '06dbae8c51f7955dd72b1c4b5c46d581', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-27 07:07:21'),
(45, 'Dj', 'himanshu', 'kawale', 'himanshukawale@gmail.com', '0558213669', 'a7448722577f85abf82e1ba83b26685d', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-31 08:32:16'),
(46, 'Dj', 'himanshu', 'kawale', 'himanshukawale@gmail.com', '07558213669', 'b2c9b42ab887477f53314e41fc3ffd33', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-31 11:16:43'),
(47, 'Dj', 'himanshu', 'kawale', 'himanshukawale@gmail.com', '07558213669', '739d78ee700d4e590a9d762039f37deb', 'khalchi aali , nashirabad\r\nkhalchi aali , nashirabad', 1, '2023-12-31 16:46:11'),
(48, 'Dj', 'Dj', 'Alok', 'djalok559552@gmail.com', '', 'a89c12d70c3192c9b99951330100b10a', '', 1, '2024-01-01 07:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `d_id` int(11) NOT NULL,
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

INSERT INTO `users_orders` (`o_id`, `d_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`, `rs_id`) VALUES
(37, 17, 31, 'jklmno', 5, '245.00', 'closed', '2024-01-31 14:55:53', 8),
(38, 14, 31, 'Red Robins Chick on a Stick', 2, '34.99', 'in process', '2024-01-31 14:54:18', 8),
(39, 11, 33, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(40, 12, 33, 'Hard Rock Cafe', 1, '22.12', 'closed', '2024-01-31 14:53:05', 8),
(43, 15, 38, 'Lyfe Kitchens Tofu Taco', 1, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(45, 11, 38, 'Bonefish', 1, '55.77', 'closed', '2024-01-31 14:51:53', 48),
(46, 11, 38, 'Bonefish', 2, '55.77', 'closed', '2024-01-31 14:51:53', 48),
(47, 11, 39, 'Bonefish', 1, '55.77', 'closed', '2024-01-31 14:51:53', 48),
(49, 11, 41, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(51, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', 'in process', '2024-01-31 14:53:46', 8),
(52, 16, 39, 'Houlihans Mini Cheeseburger', 2, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(53, 16, 39, 'Houlihans Mini Cheeseburger', 2, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(54, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(55, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(56, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(57, 12, 39, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(58, 12, 39, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(59, 12, 39, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(60, 12, 39, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(61, 12, 39, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(62, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(63, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(64, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(65, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(66, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(67, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(68, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(69, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(70, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(71, 15, 43, 'Lyfe Kitchens Tofu Taco', 7, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(72, 11, 44, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(73, 12, 44, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(74, 11, 44, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(75, 12, 44, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(76, 11, 44, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(77, 12, 44, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', 8),
(78, 27, 44, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(79, 27, 44, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(80, 27, 44, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(81, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(82, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(83, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(84, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(85, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(86, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(87, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(88, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(89, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(90, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(91, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(92, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(93, 27, 39, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(94, 27, 39, 'kaju kari', 3, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(95, 27, 39, 'kaju kari', 5, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(96, 27, 39, 'kaju kari', 5, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(97, 27, 39, 'kaju kari', 5, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(98, 27, 39, 'kaju kari', 5, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(99, 27, 39, 'kaju kari', 5, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(100, 27, 39, 'kaju kari', 7, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(101, 27, 39, 'kaju kari', 7, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(102, 27, 39, 'kaju kari', 7, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(103, 15, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(104, 15, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(105, 15, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(106, 15, 39, 'Lyfe Kitchens Tofu Taco', 19, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(107, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(108, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(109, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', 'in process', '2024-01-31 14:54:18', 8),
(110, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(111, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', 'in process', '2024-01-31 14:54:18', 8),
(112, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(113, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', 'in process', '2024-01-31 14:54:18', 8),
(114, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(115, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(116, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(117, 15, 39, 'Lyfe Kitchens Tofu Taco', 20, '11.99', 'in process', '2024-01-31 14:54:46', 8),
(118, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(119, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(120, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(121, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(122, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(123, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(124, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(125, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(126, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(127, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(128, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(129, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(130, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(131, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(132, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(133, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(134, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(135, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(136, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(137, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(138, 27, 45, 'kaju kari', 2, '280.00', 'closed', '2024-02-09 16:44:18', 9),
(139, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(140, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(141, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(142, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(143, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(144, 27, 45, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(145, 23, 45, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(146, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(147, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(148, 27, 45, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(149, 27, 46, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(150, 27, 46, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(151, 27, 46, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(152, 27, 46, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(153, 27, 46, 'kaju kari', 1, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(154, 27, 46, 'kaju kari', 2, '280.00', 'in process', '2024-02-07 16:26:24', 9),
(155, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(156, 25, 39, 'Paneer Lababdar', 1, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(157, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(158, 25, 39, 'Paneer Lababdar', 1, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(159, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(160, 25, 39, 'Paneer Lababdar', 1, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(161, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(162, 25, 39, 'Paneer Lababdar', 1, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(163, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(164, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(165, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(166, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(167, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(168, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(169, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(170, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(171, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(172, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(173, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(174, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(175, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(176, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(177, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(178, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(179, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(180, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(181, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(182, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(183, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(184, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(185, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(186, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(187, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(188, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(189, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(190, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(191, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(192, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(193, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(194, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(195, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(196, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(197, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(198, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(199, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(200, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(201, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(202, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(203, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(204, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(205, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(206, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(207, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(208, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(209, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(210, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(211, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(212, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(213, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(214, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(215, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(216, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(217, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(218, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(219, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(220, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(221, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(222, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(223, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(224, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(225, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(226, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(227, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(228, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(229, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(230, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(231, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(232, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(233, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(234, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(235, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(236, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(237, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(238, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(239, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(240, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(241, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(242, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(243, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(244, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(245, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(246, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(247, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(248, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(249, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(250, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(251, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(252, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(253, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(254, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(255, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(256, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(257, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(258, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(259, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(260, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(261, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(262, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(263, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(264, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(265, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(266, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(267, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(268, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(269, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(270, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(271, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(272, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(273, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(274, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(275, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(276, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(277, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(278, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(279, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(280, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(281, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(282, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(283, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(284, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(285, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(286, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(287, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(288, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(289, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(290, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(291, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(292, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(293, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(294, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(295, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(296, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(297, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(298, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(299, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(300, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(301, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(302, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(303, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(304, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(305, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(306, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(307, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(308, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(309, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(310, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(311, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(312, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(313, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(314, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(315, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(316, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(317, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(318, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(319, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(320, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(321, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(322, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(323, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(324, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(325, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(326, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(327, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(328, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(329, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(330, 24, 39, 'Tandoori Chicken', 2, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(331, 25, 39, 'Paneer Lababdar', 2, '275.00', 'in process', '2024-01-31 15:04:09', 8),
(332, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(333, 11, 47, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(334, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(335, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(336, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(337, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(338, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(339, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(340, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(341, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(342, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(343, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(344, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(345, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(346, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(347, 24, 39, 'Tandoori Chicken', 1, '270.00', 'in process', '2024-01-31 14:47:41', 8),
(348, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', 'in process', '2024-01-31 14:55:15', 8),
(349, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(350, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(351, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(352, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(353, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(354, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(355, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(356, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(357, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(358, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(359, 17, 39, 'jklmno', 1, '17.99', 'in process', '2024-01-31 14:55:53', 8),
(360, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(361, 17, 39, 'jklmno', 1, '17.99', 'in process', '2024-01-31 14:55:53', 8),
(362, 11, 39, 'Bonefish', 1, '55.77', 'in process', '2024-01-31 14:51:53', 48),
(363, 17, 39, 'jklmno', 1, '17.99', 'in process', '2024-01-31 14:55:53', 8),
(364, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(365, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(366, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(367, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(368, 17, 39, 'jklmno', 1, '17.99', NULL, '2024-01-31 14:55:53', NULL),
(369, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(370, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(371, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(372, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(373, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(374, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(375, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(376, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(377, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(378, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(379, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(380, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(381, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(382, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(383, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(384, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(385, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(386, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(387, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(388, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(389, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(390, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(391, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(392, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(393, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(394, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(395, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(396, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(397, 16, 39, 'Houlihans Mini Cheeseburger', 5, '22.55', 'in process', '2024-01-31 14:55:15', NULL),
(398, 16, 39, 'Houlihans Mini Cheeseburger', 5, '22.55', NULL, '2024-01-31 14:55:15', NULL),
(399, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(400, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(401, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(402, 25, 39, 'Paneer Lababdar', 1, '275.00', 'closed', '2024-02-07 16:27:26', 8),
(403, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(404, 15, 39, 'Lyfe Kitchens Tofu Taco', 4, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(405, 15, 39, 'Lyfe Kitchens Tofu Taco', 4, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(406, 15, 39, 'Lyfe Kitchens Tofu Taco', 4, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(407, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(408, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(409, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(410, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', NULL, '2024-01-31 14:55:15', NULL),
(411, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(412, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(413, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(414, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(415, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(416, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(417, 13, 39, 'Uno Pizzeria & Grill', 3, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(418, 15, 39, 'Lyfe Kitchens Tofu Taco', 1, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(419, 16, 39, 'Houlihans Mini Cheeseburger', 5, '22.55', NULL, '2024-01-31 14:55:15', NULL),
(420, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(421, 15, 39, 'Lyfe Kitchens Tofu Taco', 1, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(422, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(423, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(424, 14, 39, 'Red Robins Chick on a Stick', 3, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(425, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(426, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(427, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(428, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(429, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(430, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(431, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(432, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(433, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(434, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(435, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(436, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(437, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(438, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(439, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(440, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(441, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(442, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(443, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(444, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(445, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(446, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(447, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(448, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(449, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(450, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(451, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(452, 12, 39, 'Hard Rock Cafe', 18, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(453, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(454, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(455, 15, 39, 'Lyfe Kitchens Tofu Taco', 1, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(456, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(457, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(458, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(459, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(460, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(461, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(462, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(463, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(464, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(465, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(466, 15, 39, 'Lyfe Kitchens Tofu Taco', 3, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(467, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(468, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(469, 13, 39, 'Uno Pizzeria & Grill', 4, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(470, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(471, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(472, 13, 39, 'Uno Pizzeria & Grill', 2, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(473, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(474, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(475, 12, 39, 'Hard Rock Cafe', 2, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(476, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(477, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(478, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(479, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(480, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(481, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', NULL, '2024-01-31 14:55:15', NULL),
(482, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(483, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(484, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(485, 14, 39, 'Red Robins Chick on a Stick', 1, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(486, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(487, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(488, 27, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(489, 16, 39, 'Houlihans Mini Cheeseburger', 6, '22.55', NULL, '2024-01-31 14:55:15', NULL),
(490, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(491, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(492, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(493, 15, 39, 'Lyfe Kitchens Tofu Taco', 4, '11.99', NULL, '2024-01-31 14:54:46', NULL),
(494, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(495, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(496, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(497, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(498, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(499, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(500, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(501, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(502, 16, 39, 'Houlihans Mini Cheeseburger', 1, '22.55', NULL, '2024-01-31 14:55:15', NULL),
(503, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(504, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(505, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(506, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', NULL, '2024-01-31 14:53:46', NULL),
(507, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(508, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(509, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(510, 14, 39, 'Red Robins Chick on a Stick', 2, '34.99', NULL, '2024-01-31 14:54:18', NULL),
(511, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(512, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(513, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(514, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(515, 24, 39, 'Tandoori Chicken', 18, '270.00', NULL, '2024-02-07 16:25:06', 8),
(516, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(517, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(518, 25, 39, 'Paneer Lababdar', 1, '275.00', NULL, '2024-02-07 16:25:59', 8),
(519, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(520, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(521, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(522, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(523, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(524, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(525, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(526, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(527, 12, 39, 'Hard Rock Cafe', 1, '22.12', 'in process', '2024-01-31 14:53:05', NULL),
(528, 13, 39, 'Uno Pizzeria & Grill', 1, '12.35', 'closed', '2024-01-31 14:53:46', NULL),
(529, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(530, 12, 39, 'Hard Rock Cafe', 1, '22.12', NULL, '2024-01-31 14:53:05', NULL),
(531, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(532, 11, 39, 'Bonefish', 1, '55.77', NULL, '2024-01-31 14:51:53', NULL),
(533, 23, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(534, 24, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(535, 0, 39, 'Sev Bhaji', 2, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(536, 0, 39, 'Tandoori Chicken', 1, '270.00', 'closed', '2024-02-07 16:25:06', 8),
(537, 0, 39, 'Paneer Lababdar', 1, '275.00', 'in process', '2024-02-07 16:25:59', 8),
(538, 0, 39, 'kaju kari', 2, '280.00', 'closed', '2024-02-07 16:26:24', 9),
(539, 0, 39, 'kaju kari', 2, '280.00', NULL, '2024-02-07 16:26:24', 9),
(540, 0, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(541, 0, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(542, 0, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(543, 0, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(545, 0, 39, 'Sev Bhaji', 1, '130.00', 'closed', '2024-02-07 16:54:52', 8),
(546, 0, 39, 'Tandoori Chicken', 1, '270.00', NULL, '2024-02-07 16:25:06', 8),
(547, 0, 39, 'kaju kari', 1, '280.00', NULL, '2024-02-07 16:26:24', 9),
(548, 0, 39, 'paneer angara', 1, '260.00', NULL, '2024-02-09 13:32:12', NULL),
(549, 24, 39, 'Tandoori Chicken', 1, '270.00', 'closed', '2024-02-09 16:42:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_employees`
--

CREATE TABLE `user_employees` (
  `user_emp_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `rs_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `website_feedbacks`
--

CREATE TABLE `website_feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `ease_of_use` int(11) NOT NULL,
  `design_feedback` text NOT NULL,
  `suggestions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `website_feedbacks`
--

INSERT INTO `website_feedbacks` (`id`, `name`, `email`, `rating`, `ease_of_use`, `design_feedback`, `suggestions`, `created_at`) VALUES
(1, 'himanshu', 'himanshukawale89@gmail.com', 3, 4, 'l;j', 'ljkl', '2023-12-30 13:36:47'),
(2, 'varad', 'himanshukawale@gmail.com', 3, 9, 'asddfd', 'asdasd', '2023-12-30 13:38:48'),
(3, 'himanshu rajendra kawale', 'himanshukawale89@gmail.com', 4, 4, 'asfdszfdsf', 'dfsdfdsf', '2023-12-30 13:39:11'),
(4, 'himanshu', 'himanshukawale89@gmail.com', 5, 2, 'hg', 'jh', '2023-12-30 13:41:18'),
(5, 'himanshu rajendra kawale', 'himanshukawale45@gmail.com', 3, 2, 'hgfh', 'fhfghf', '2023-12-30 13:45:30'),
(6, 'himanshu', 'himanshukawale@gmail.com', 2, 2, 'sdadas', 'dasda', '2023-12-30 13:46:14'),
(7, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:19'),
(8, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:21'),
(9, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:22'),
(10, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:22'),
(11, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:29'),
(12, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:30'),
(13, 'varad', 'himanshukawale45@gmail.com', 5, 7, 'gfdggdf', 'gfdgd', '2023-12-30 13:47:30'),
(14, 'varad', 'himanshukawale45@gmail.com', 4, 2, 'cfgghfh', 'fghfg', '2023-12-30 13:48:10'),
(15, 'Mohit Chaudhari', 'himanshukawale@gmail.com', 2, 5, 'dasdad', 'dsafa', '2023-12-30 13:48:31'),
(16, 'dasd', 'himanshukawale89@gmail.com', 3, 1, 'dsadada', 'dsaddas', '2023-12-30 13:49:16'),
(17, 'varad', 'himanshukawale@gmail.com', 2, 5, 'asdfa', 'sadda', '2023-12-30 13:49:52');

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
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk_bookings_tables` (`table_id`),
  ADD KEY `fk_bookings_restaurants` (`rs_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_inventory`
--
ALTER TABLE `inventory_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `inventory_order_items`
--
ALTER TABLE `inventory_order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `inventory_products`
--
ALTER TABLE `inventory_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `inventory_purchase_orders`
--
ALTER TABLE `inventory_purchase_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`l_id`);

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
-- Indexes for table `restaurant_admins`
--
ALTER TABLE `restaurant_admins`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `rs_id` (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`),
  ADD KEY `rs_id` (`rs_id`);

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
-- Indexes for table `user_employees`
--
ALTER TABLE `user_employees`
  ADD PRIMARY KEY (`user_emp_id`);

--
-- Indexes for table `website_feedbacks`
--
ALTER TABLE `website_feedbacks`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_inventory`
--
ALTER TABLE `inventory_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_order_items`
--
ALTER TABLE `inventory_order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_products`
--
ALTER TABLE `inventory_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_purchase_orders`
--
ALTER TABLE `inventory_purchase_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_suppliers`
--
ALTER TABLE `inventory_suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `restaurant_admins`
--
ALTER TABLE `restaurant_admins`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=550;

--
-- AUTO_INCREMENT for table `user_employees`
--
ALTER TABLE `user_employees`
  MODIFY `user_emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_feedbacks`
--
ALTER TABLE `website_feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_restaurants` FOREIGN KEY (`rs_id`) REFERENCES `restaurant` (`rs_id`),
  ADD CONSTRAINT `fk_bookings_tables` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`);

--
-- Constraints for table `restaurant_admins`
--
ALTER TABLE `restaurant_admins`
  ADD CONSTRAINT `restaurant_admins_ibfk_1` FOREIGN KEY (`rs_id`) REFERENCES `restaurant` (`rs_id`);

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_ibfk_1` FOREIGN KEY (`rs_id`) REFERENCES `restaurant` (`rs_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
