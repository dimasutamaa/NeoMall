-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 09:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neomall_online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `phone`, `gender`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@neomall.com', '1234567890', 'Male', '$2y$10$vW1LhmBjmKiJIfeG3ZOnIeBJDR5/qJdQuvBc4N3t49ii1nZtYegT2', 'admin', '2024-08-11 17:26:09', '2024-08-11 17:26:09'),
(39, 'second admin', 'admin2@neomall.com', '1234567890', 'Female', '$2y$10$DBu17NmHRGBZZ9XUuUPm6OjMcXHSoCG5Id4Hoz9qyWMuPl5edxj1W', 'admin', '2024-08-11 17:21:26', '2024-08-11 17:21:26'),
(43, 'third admin', 'admin3@neomall.com', '1234567890', 'Male', '$2y$10$s3XdTnuWTvSZuTxqhdsh4uUUU.31Pq9E8LNWddpmSExDN4HJip.M6', 'admin', '2024-08-11 17:27:04', '2024-08-11 17:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `product_id`, `size`, `quantity`, `created_at`) VALUES
(53, 1, 5, 'XL', 1, '2024-09-21 21:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Top', 'Yes', '2024-08-07 15:32:51'),
(26, 'Outer', 'Yes', '2024-08-07 16:42:08'),
(119, 'Pants', 'No', '2024-09-22 13:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'bondol', 'bondol@gmail.com', '$2y$10$gXRJf1jz0Z7xYHnCV1LA4eZD/OqfCdd94vfIal8XqlUqboy0a5/XK', 'customer', '2024-08-05 12:48:53', '2024-08-05 12:48:53'),
(4, 'dimas', 'dimas@gmail.com', '$2y$10$cPB51LIbg/tszFd83tWqW.V3gcSiiKh0Kh1AgOGU.DPsXemuQ4ykG', 'customer', '2024-08-05 13:56:29', '2024-08-05 13:56:29'),
(6, 'boundy', 'boundy@gmail.com', '$2y$10$IBAr.zRak8t9sLwf.6V8i.xfhSEJKnERA8ZDJ7M3mTVVTKEav5/mu', 'customer', '2024-08-15 13:40:35', '2024-08-15 13:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `additional_information` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `customer_id`, `first_name`, `last_name`, `address`, `email`, `phone`, `additional_information`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bondol', '', 'Dummy Address', 'bondol@gmail.com', '1234567890', '', '2024-08-18 23:28:59', '2024-08-18 23:28:59'),
(8, 4, 'Dimas', 'Utama', 'Dummy Address', 'dimas@gmail.com', '1234567890', '', '2024-08-19 19:33:44', '2024-08-19 19:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipping_type` varchar(50) NOT NULL,
  `shipping_price` int(11) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `additional_info` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `shipping_type`, `shipping_price`, `sub_total`, `grand_total`, `payment`, `first_name`, `last_name`, `address`, `email`, `phone`, `additional_info`, `created_at`) VALUES
(1, 1, 'Economy', 7500, '1000000', '1007500', 'QRIS', 'Bondol', '', 'Dummy Address', 'bondol@gmail.com', '1234567890', '', '2024-08-22 12:34:31'),
(2, 4, 'Same Day', 30000, '400000', '430000', 'QRIS', 'Dimas', 'Utama', 'Dummy Address', 'dimas@gmail.com', '1234567890', '', '2024-08-22 12:37:56'),
(3, 6, 'Same Day', 30000, '650000', '680000', 'GoPay', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-08-22 22:23:19'),
(4, 4, 'Economy', 7500, '250000', '257500', 'QRIS', 'Dimas', 'Utama', 'Dummy Address', 'dimas@gmail.com', '1234567890', '', '2024-08-23 16:54:45'),
(5, 4, 'Economy', 7500, '250000', '257500', 'QRIS', 'Dimas', 'Utama', 'Dummy Address', 'dimas@gmail.com', '1234567890', '', '2024-08-23 20:36:11'),
(6, 6, 'Reguler', 12000, '250000', '262000', 'GoPay', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-08-23 20:57:05'),
(7, 1, 'Economy', 7500, '250000', '257500', 'QRIS', 'Bondol', '', 'Dummy Address', 'bondol@gmail.com', '1234567890', '', '2024-08-23 21:34:01'),
(8, 1, 'Reguler', 12000, '250000', '262000', 'Debit', 'Bondol', '', 'Dummy Address', 'bondol@gmail.com', '1234567890', '', '2024-08-23 21:35:30'),
(9, 4, 'Economy', 7500, '350000', '357500', 'QRIS', 'Dimas', 'Utama', 'Dummy Address', 'dimas@gmail.com', '1234567890', '', '2024-08-23 22:59:47'),
(10, 6, 'Economy', 7500, '700000', '707500', 'QRIS', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-08-23 23:06:43'),
(11, 4, 'Same Day', 30000, '1050000', '1080000', 'QRIS', 'Dimas', 'Utama', 'Dummy Address', 'dimas@gmail.com', '1234567890', '', '2024-08-23 23:12:15'),
(12, 6, 'Economy', 7500, '500000', '507500', 'GoPay', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-08-28 13:11:02'),
(13, 1, 'Reguler', 12000, '700000', '712000', 'GoPay', 'Bondol', '', 'Dummy Address', 'bondol@gmail.com', '1234567890', '', '2024-08-28 14:36:29'),
(14, 6, 'Economy', 7500, '1100000', '1107500', 'QRIS', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-08-30 14:49:14'),
(15, 6, 'Economy', 7500, '150000', '157500', 'Debit', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-09-22 13:37:05'),
(16, 6, 'Same Day', 30000, '700000', '730000', 'Debit', 'Boundy', '', 'Dummy Address', 'boundy@gmail.com', '1234567890', '', '2024-09-22 13:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `size` varchar(50) NOT NULL,
  `total` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `quantity`, `price`, `size`, `total`, `status`, `created_at`) VALUES
(1, 1, 3, 'Dummy Product 2', '1', '250000', 'S', '250000', 'inProgress', '2024-08-22 12:34:31'),
(2, 1, 5, 'Dummy Product 3', '3', '250000', 'M', '750000', 'inProgress', '2024-08-22 12:34:31'),
(3, 2, 2, 'Dummy Product', '1', '150000', 'M', '150000', 'inProgress', '2024-08-22 12:37:56'),
(4, 2, 3, 'Dummy Product 2', '1', '250000', 'XL', '250000', 'new', '2024-08-22 12:37:56'),
(5, 3, 9, 'Dummy Product 4', '1', '350000', 'S', '350000', 'new', '2024-08-22 22:23:19'),
(6, 3, 2, 'Dummy Product', '2', '150000', 'S', '300000', 'new', '2024-08-22 22:23:19'),
(7, 4, 3, 'Dummy Product 2', '1', '250000', 'M', '250000', 'new', '2024-08-23 16:54:45'),
(8, 5, 5, 'Dummy Product 3', '1', '250000', 'M', '250000', 'completed', '2024-08-23 20:36:11'),
(9, 6, 3, 'Dummy Product 2', '1', '250000', 'XL', '250000', 'completed', '2024-08-23 20:57:05'),
(10, 7, 3, 'Dummy Product 2', '1', '250000', 'XL', '250000', 'completed', '2024-08-23 21:34:01'),
(11, 8, 5, 'Dummy Product 3', '1', '250000', 'XL', '250000', 'completed', '2024-08-23 21:35:30'),
(12, 9, 9, 'Dummy Product 4', '1', '350000', 'M', '350000', 'new', '2024-08-23 22:59:47'),
(13, 3, 9, 'Dummy Product 4', '2', '350000', 'XL', '700000', 'new', '2024-08-23 23:06:43'),
(14, 11, 9, 'Dummy Product 4', '3', '350000', 'M', '1050000', 'completed', '2024-08-23 23:12:15'),
(15, 12, 3, 'Dummy Product 2', '2', '250000', 'S', '500000', 'new', '2024-08-28 13:11:02'),
(16, 13, 9, 'Dummy Product 4', '2', '350000', 'S', '700000', 'new', '2024-08-28 14:36:29'),
(17, 14, 3, 'Dummy Product 2', '1', '250000', 'XL', '250000', 'new', '2024-08-30 14:49:14'),
(18, 14, 5, 'Dummy Product 3', '2', '250000', 'M', '500000', 'completed', '2024-08-30 14:49:14'),
(19, 14, 9, 'Dummy Product 4', '1', '350000', 'S', '350000', 'new', '2024-08-30 14:49:14'),
(20, 15, 2, 'Dummy Product', '1', '150000', 'XL', '150000', 'completed', '2024-09-22 13:37:05'),
(21, 16, 9, 'Dummy Product 4', '2', '350000', 'M', '700000', 'completed', '2024-09-22 13:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `username`, `email`, `phone`, `logo`, `password`, `role`, `created_at`, `updated_at`) VALUES
(6, 'ABCPartner', 'ABCPartner@gmail.com', '1234567890', '../assets/logo/user-icon.png', '$2y$10$Uq17.RTF9LEQqKeZTP7VA.w0agDCwsL6qUJodjEDMr4hXZBjMnpj2', 'partner', '2024-08-10 19:46:40', '2024-08-10 19:46:40'),
(8, 'XYZPartner', 'GHIPartner@gmail.com', '1234567890', '../assets/logo/user-icon-1.png', '$2y$10$9jWVY6I0YWX.3r8GojeB6O51tfr5cLKDUq7FY0oKfPnmKV8Y56rVu', 'partner', '2024-08-10 20:25:46', '2024-08-10 20:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `partner_id`, `category_id`, `name`, `price`, `description`, `picture`, `created_at`) VALUES
(2, 6, 1, 'Dummy Product', 150000, 'Dummy Description', '../assets/product/150x150.png', '2024-08-12 16:58:37'),
(3, 6, 26, 'Dummy Product 2', 250000, 'Dummy Description', '../assets/product/100x100.png', '2024-08-12 17:08:42'),
(5, 6, 26, 'Dummy Product 3', 250000, 'Dummy Description', '../assets/product/50x50.png', '2024-08-12 20:33:34'),
(9, 8, 1, 'Dummy Product 4', 350000, 'Dummy Description', '../assets/product/130x170.png', '2024-08-15 14:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `type`, `price`, `created_at`) VALUES
(1, 'Reguler', 12000, '2024-08-21 16:47:20'),
(2, 'Economy', 7500, '2024-08-21 16:47:25'),
(3, 'Same Day', 30000, '2024-08-21 16:47:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
