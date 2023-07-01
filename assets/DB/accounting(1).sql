-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2023 at 11:17 AM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyfactor`
--

CREATE TABLE `buyfactor` (
  `buyfactor_id` int UNSIGNED NOT NULL,
  `buy_date` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `cust_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `warehouse_id` int UNSIGNED NOT NULL,
  `product_qty` int UNSIGNED NOT NULL,
  `factor_fi` int NOT NULL,
  `buy_off` int DEFAULT NULL,
  `buy_sum` int NOT NULL,
  `factor_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `credit_prod_after` bigint UNSIGNED NOT NULL,
  `factor_done` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_editfactor` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `buyfactor`
--

INSERT INTO `buyfactor` (`buyfactor_id`, `buy_date`, `cust_id`, `product_id`, `warehouse_id`, `product_qty`, `factor_fi`, `buy_off`, `buy_sum`, `factor_explanation`, `credit_prod_after`, `factor_done`, `created_at`, `updated_at`, `user_editfactor`) VALUES
(1, '1688209365', 1, 1, 1, 200, 10, 0, 2000, '', 1000, '1', '2023-07-01 11:03:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int UNSIGNED NOT NULL,
  `category_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'خودکار', '2023-06-18 07:14:30', NULL),
(2, 'تکنولوژی', '2023-06-20 08:52:28', NULL),
(3, 'کامپیوتری', '2023-06-25 07:24:01', NULL),
(4, 'کاغذ', '2023-06-25 07:24:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `credit_id` int UNSIGNED NOT NULL,
  `personaccount_id` int UNSIGNED NOT NULL,
  `credit` bigint NOT NULL,
  `transfer_id` int UNSIGNED DEFAULT NULL,
  `buyfactor_id` int UNSIGNED DEFAULT NULL,
  `sellfactor_id` int UNSIGNED DEFAULT NULL,
  `credit_after` bigint NOT NULL,
  `created_at` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_user` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `credits`
--

INSERT INTO `credits` (`credit_id`, `personaccount_id`, `credit`, `transfer_id`, `buyfactor_id`, `sellfactor_id`, `credit_after`, `created_at`, `updated_at`, `edit_user`) VALUES
(1, 1, 2000, NULL, 1, NULL, 2000, '1688209365', '2023-07-01 11:03:00', 1),
(2, 2, -2000, NULL, 1, NULL, -2000, '1688209365', '2023-07-01 11:03:00', 1),
(3, 4, 1000, 1, NULL, NULL, -1000, '1688382235', '2023-07-01 11:04:15', 1),
(4, 1, -1000, 1, NULL, NULL, 1000, '1688382235', '2023-07-01 11:04:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int UNSIGNED NOT NULL,
  `menu_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `ordermenu` int UNSIGNED NOT NULL,
  `permition_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `url`, `ordermenu`, `permition_id`, `created_at`, `updated_at`) VALUES
(1, 'فاکتور خرید', './buyfactor.php', 1, 1, '2023-07-01 07:18:29', NULL),
(2, 'فاکتور خرید', './buyfactor.php', 1, 2, '2023-07-01 07:18:29', NULL),
(3, 'فاکتور خرید', './buyfactor.php', 1, 3, '2023-07-01 07:18:29', NULL),
(4, 'فاکتور فروش', './sellfactor.php', 2, 1, '2023-07-01 07:18:29', NULL),
(5, 'فاکتور فروش', './sellfactor.php', 2, 2, '2023-07-01 07:18:29', NULL),
(6, 'فاکتور فروش', './sellfactor.php', 2, 3, '2023-07-01 07:18:29', NULL),
(7, 'ثبت حواله', './havale.php', 3, 1, '2023-07-01 07:18:29', NULL),
(8, 'ثبت حواله', './havale.php', 3, 2, '2023-07-01 07:18:29', NULL),
(9, 'تعریف طرف حساب جدید و صندوق و بانک', './account.php', 4, 1, '2023-07-01 07:18:29', NULL),
(10, 'تعریف طرف حساب جدید و صندوق و بانک', './account.php', 4, 2, '2023-07-01 07:18:29', NULL),
(11, 'تعریف کالای جدید', './product.php', 5, 1, '2023-07-01 07:18:29', NULL),
(12, 'تعریف کالای جدید', './product.php', 5, 2, '2023-07-01 07:18:29', NULL),
(13, 'تعریف کالای جدید', './product.php', 5, 3, '2023-07-01 07:18:29', NULL),
(14, 'تعریف دسته بندی جدید', './category.php', 6, 1, '2023-07-01 07:18:29', NULL),
(15, 'تعریف دسته بندی جدید', './category.php', 6, 2, '2023-07-01 07:18:29', NULL),
(16, 'تعریف دسته بندی جدید', './category.php', 6, 3, '2023-07-01 07:18:29', NULL),
(17, 'تعریف واحد اندازه گیری جدید', './unit.php', 7, 1, '2023-07-01 07:18:29', NULL),
(18, 'تعریف واحد اندازه گیری جدید', './unit.php', 7, 2, '2023-07-01 07:18:29', NULL),
(19, 'تعریف واحد اندازه گیری جدید', './unit.php', 7, 3, '2023-07-01 07:18:29', NULL),
(20, 'کاردکس اشخاص', './personlist.php', 8, 1, '2023-07-01 07:23:58', NULL),
(21, 'کاردکس اشخاص', './personlist.php', 8, 2, '2023-07-01 07:23:58', NULL),
(22, 'کاردکس صندوق ها و بانک ها', './sandogh.php', 9, 1, '2023-07-01 07:23:58', NULL),
(23, 'کاردکس صندوق ها و بانک ها', './sandogh.php', 9, 2, '2023-07-01 07:23:58', NULL),
(24, 'کاردکس کالاها', './productlist.php', 10, 1, '2023-07-01 07:23:58', NULL),
(25, 'کاردکس کالاها', './productlist.php', 10, 2, '2023-07-01 07:23:58', NULL),
(26, 'لیست فاکتورهای خرید', '', 11, 1, '2023-07-01 07:23:58', NULL),
(27, 'لیست فاکتورهای فروش', '', 12, 1, '2023-07-01 07:23:58', NULL),
(28, 'لیست حواله ها', '', 13, 1, '2023-07-01 07:23:58', NULL),
(29, 'ثبت یوزر جدید سیستم', './user.php', 14, 1, '2023-07-01 07:23:58', NULL),
(30, 'لیست یوزرهای سیستم حسابداری', './usertable.php', 15, 1, '2023-07-01 07:23:58', NULL),
(31, 'خروج', './logout.php', 16, 1, '2023-07-01 07:23:58', NULL),
(32, 'خروج', './logout.php', 16, 2, '2023-07-01 07:23:58', NULL),
(33, 'خروج', './logout.php', 16, 3, '2023-07-01 07:23:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permitions`
--

CREATE TABLE `permitions` (
  `permition_id` int UNSIGNED NOT NULL,
  `permition_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `permitions`
--

INSERT INTO `permitions` (`permition_id`, `permition_name`, `created_at`, `updated_at`) VALUES
(1, 'مدیر', '2023-06-18 07:14:46', NULL),
(2, 'حسابدار', '2023-06-19 06:33:22', NULL),
(3, 'فاکتور زن', '2023-06-19 06:33:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personaccount`
--

CREATE TABLE `personaccount` (
  `cust_id` int UNSIGNED NOT NULL,
  `account_type` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `cust_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `cust_codemeli` int UNSIGNED DEFAULT NULL,
  `cust_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
  `cust_mobile` int DEFAULT NULL,
  `cust_active` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '1',
  `total_credit` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `personaccount`
--

INSERT INTO `personaccount` (`cust_id`, `account_type`, `cust_name`, `cust_codemeli`, `cust_address`, `cust_mobile`, `cust_active`, `total_credit`, `created_at`, `updated_at`) VALUES
(1, '1', 'بهزاد', 123456, 'نارمک', 123, '1', 1000, '2023-06-18 07:15:30', NULL),
(2, '2', 'خرید', NULL, NULL, NULL, '1', -2000, '2023-06-20 04:01:50', NULL),
(3, '2', 'فروش', NULL, NULL, NULL, '1', 0, '2023-06-20 04:01:50', NULL),
(4, '3', 'بانک ملت', 123, '145', NULL, '1', -1000, '2023-06-22 06:35:41', NULL),
(5, '3', 'بانک صادرات', 159, '951', NULL, '1', 0, '2023-06-22 06:35:41', NULL),
(6, '1', 'ستار', NULL, NULL, NULL, '1', 0, '2023-06-24 07:40:44', NULL),
(7, '1', 'حمید', 123, '', 912, '1', 0, '2023-06-25 09:47:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int UNSIGNED NOT NULL,
  `product_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `product_serial` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `unit_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_serial`, `category_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(1, 'خودکار بیک', 123, 1, 1, '2023-06-18 07:16:47', NULL),
(2, 'لپتاپ', 100, 2, 1, '2023-06-20 08:54:25', NULL),
(3, 'موبایل', 784, 2, 1, '2023-06-20 08:54:25', NULL),
(4, 'مانیتور', 47, 2, 1, '2023-06-25 06:29:01', NULL),
(5, 'انار', 789, 2, 1, '2023-06-25 07:58:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sellfactors`
--

CREATE TABLE `sellfactors` (
  `sellfactor_id` int UNSIGNED NOT NULL,
  `sell_date` bigint NOT NULL,
  `cust_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `product_qty` int NOT NULL,
  `factor_fi` bigint NOT NULL,
  `sell_off` bigint UNSIGNED DEFAULT NULL,
  `sell_sum` bigint NOT NULL,
  `factor_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `credit_after_sell` bigint UNSIGNED NOT NULL,
  `factor_done` enum('1','2') COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_editfactor` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int UNSIGNED NOT NULL,
  `stock_productid` int UNSIGNED NOT NULL,
  `stock_wearhouseid` int UNSIGNED NOT NULL,
  `stock` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `stock_productid`, `stock_wearhouseid`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1000, '2023-06-28 08:00:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `transfersend_id` int UNSIGNED NOT NULL,
  `transfersend_date` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `transfersend_from` int UNSIGNED NOT NULL,
  `transfersend_to` int UNSIGNED NOT NULL,
  `transfersend_price` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `useredit_id` int UNSIGNED NOT NULL,
  `transfersend_explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`transfersend_id`, `transfersend_date`, `transfersend_from`, `transfersend_to`, `transfersend_price`, `created_at`, `updated_at`, `useredit_id`, `transfersend_explanation`) VALUES
(1, '1688382235', 4, 1, 1000, '2023-07-01 11:04:15', NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int UNSIGNED NOT NULL,
  `unit_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `created_at`, `updated_at`) VALUES
(1, 'عدد', '2023-06-18 07:15:51', NULL),
(2, 'کیلو', '2023-06-20 08:53:42', NULL),
(3, 'لیتر', '2023-06-20 08:53:42', NULL),
(8, 'جفت', '2023-06-25 07:19:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `user_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `user_firstName` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `user_email` varchar(256) COLLATE utf8mb4_persian_ci NOT NULL,
  `user_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `permition_id` int UNSIGNED NOT NULL,
  `user_active` enum('1','2') COLLATE utf8mb4_persian_ci NOT NULL DEFAULT '2',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_firstName`, `user_email`, `user_password`, `permition_id`, `user_active`, `created_at`, `updated_at`) VALUES
(1, 'behzad', 'behzad', 'behzad.kermanii@gmail.com', '$2y$10$RcxAXEPlaL33QQ.y0RKTeeNZwFr8uzasX2tRbSpNQ52SPAWqVLCIK', 1, '2', '2023-06-18 07:16:21', NULL),
(2, 'fateme', 'فاطمه', 'fateme@gmail.com', '$2y$10$RcxAXEPlaL33QQ.y0RKTeeNZwFr8uzasX2tRbSpNQ52SPAWqVLCIK', 3, '2', '2023-06-25 06:12:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wearhouses`
--

CREATE TABLE `wearhouses` (
  `wearhouse_id` int UNSIGNED NOT NULL,
  `wearhouse_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `wearhouses`
--

INSERT INTO `wearhouses` (`wearhouse_id`, `wearhouse_name`, `created_at`, `updated_at`) VALUES
(1, 'هزاره سوم', '2023-06-18 07:16:34', NULL),
(2, 'مرکزی', '2023-07-01 10:51:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyfactor`
--
ALTER TABLE `buyfactor`
  ADD PRIMARY KEY (`buyfactor_id`),
  ADD KEY `sup_id` (`cust_id`),
  ADD KEY `prod_id` (`product_id`),
  ADD KEY `ware_id` (`warehouse_id`),
  ADD KEY `usr_id` (`user_editfactor`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`credit_id`),
  ADD KEY `edituser` (`edit_user`),
  ADD KEY `transfers_id` (`transfer_id`),
  ADD KEY `cre_id` (`credit_id`) USING BTREE,
  ADD KEY `buyfactor_id` (`buyfactor_id`),
  ADD KEY `sellfactor_id` (`sellfactor_id`),
  ADD KEY `personaccount_id` (`personaccount_id`) USING BTREE;

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `permiti_id` (`permition_id`);

--
-- Indexes for table `permitions`
--
ALTER TABLE `permitions`
  ADD PRIMARY KEY (`permition_id`);

--
-- Indexes for table `personaccount`
--
ALTER TABLE `personaccount`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `cat_id` (`category_id`),
  ADD KEY `uni_id` (`unit_id`);

--
-- Indexes for table `sellfactors`
--
ALTER TABLE `sellfactors`
  ADD PRIMARY KEY (`sellfactor_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_editfactor`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `stock_product` (`stock_productid`),
  ADD KEY `stock_wear` (`stock_wearhouseid`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`transfersend_id`),
  ADD KEY `transfer_from_account` (`transfersend_from`),
  ADD KEY `transfer_to_user` (`transfersend_to`),
  ADD KEY `usersedit_id` (`useredit_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `permit_id` (`permition_id`);

--
-- Indexes for table `wearhouses`
--
ALTER TABLE `wearhouses`
  ADD PRIMARY KEY (`wearhouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyfactor`
--
ALTER TABLE `buyfactor`
  MODIFY `buyfactor_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `credit_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `permitions`
--
ALTER TABLE `permitions`
  MODIFY `permition_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personaccount`
--
ALTER TABLE `personaccount`
  MODIFY `cust_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sellfactors`
--
ALTER TABLE `sellfactors`
  MODIFY `sellfactor_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `transfersend_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wearhouses`
--
ALTER TABLE `wearhouses`
  MODIFY `wearhouse_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyfactor`
--
ALTER TABLE `buyfactor`
  ADD CONSTRAINT `prod_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sup_id` FOREIGN KEY (`cust_id`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usr_id` FOREIGN KEY (`user_editfactor`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ware_id` FOREIGN KEY (`warehouse_id`) REFERENCES `wearhouses` (`wearhouse_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credits`
--
ALTER TABLE `credits`
  ADD CONSTRAINT ` personaccount_id` FOREIGN KEY (`personaccount_id`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buyfactor_id` FOREIGN KEY (`buyfactor_id`) REFERENCES `buyfactor` (`buyfactor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `edituser` FOREIGN KEY (`edit_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellfactor_id` FOREIGN KEY (`sellfactor_id`) REFERENCES `sellfactors` (`sellfactor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_id` FOREIGN KEY (`transfer_id`) REFERENCES `transfer` (`transfersend_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `permiti_id` FOREIGN KEY (`permition_id`) REFERENCES `permitions` (`permition_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uni_id` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sellfactors`
--
ALTER TABLE `sellfactors`
  ADD CONSTRAINT `cust_id` FOREIGN KEY (`cust_id`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_editfactor`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stock_product` FOREIGN KEY (`stock_productid`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_wear` FOREIGN KEY (`stock_wearhouseid`) REFERENCES `wearhouses` (`wearhouse_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `transfer_from_user` FOREIGN KEY (`transfersend_from`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_to_user` FOREIGN KEY (`transfersend_to`) REFERENCES `personaccount` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usersedit_id` FOREIGN KEY (`useredit_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `permit_id` FOREIGN KEY (`permition_id`) REFERENCES `permitions` (`permition_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
