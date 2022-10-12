-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 11, 2022 at 11:54 PM
-- Server version: 5.7.23-23
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wamtsol_bilaltraders`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `is_petty_cash` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `title`, `type`, `description`, `balance`, `is_petty_cash`, `status`, `ts`) VALUES
(2, 'CASH', 0, '', '0.00', 0, 1, '2022-10-10 10:39:37'),
(3, 'ABID ALI SHAH (JAZZ CASH)', 0, '', '22336.00', 0, 1, '2022-10-10 10:42:34'),
(4, 'MALIK BILAL SHAHID (JAZZ CASH)', 0, '', '0.00', 0, 1, '2022-10-10 10:42:58'),
(5, 'MALIK BILAL SHAHID (EASYPAISA)', 0, '', '0.00', 0, 1, '2022-10-10 10:44:13'),
(6, 'MALIK BILAL SHAHID (MPBL)', 0, '', '0.00', 0, 1, '2022-10-10 10:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_type_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_type_id`, `username`, `email`, `name`, `password`, `status`) VALUES
(1, 1, 'admin', 'admin@gmail.com', 'Admin', '5693c9e93d11afc857373e0d6fb9c053', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_type`
--

CREATE TABLE `admin_type` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `can_add` int(11) NOT NULL DEFAULT '0',
  `can_edit` int(11) NOT NULL DEFAULT '0',
  `can_delete` int(11) NOT NULL DEFAULT '0',
  `can_read` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_type`
--

INSERT INTO `admin_type` (`id`, `title`, `can_add`, `can_edit`, `can_delete`, `can_read`, `status`, `ts`) VALUES
(1, 'Administrator', 1, 1, 1, 1, 1, '2022-09-17 10:48:52'),
(3, 'Computer Operator', 1, 1, 0, 1, 1, '2022-09-17 10:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `config_type`
--

CREATE TABLE `config_type` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `sortorder` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config_type`
--

INSERT INTO `config_type` (`id`, `title`, `sortorder`) VALUES
(1, 'General Settings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `config_variable`
--

CREATE TABLE `config_variable` (
  `id` int(11) NOT NULL,
  `config_type_id` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `notes` varchar(512) NOT NULL,
  `type` varchar(200) NOT NULL,
  `default_values` text NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` text NOT NULL,
  `sortorder` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config_variable`
--

INSERT INTO `config_variable` (`id`, `config_type_id`, `title`, `notes`, `type`, `default_values`, `key`, `value`, `sortorder`) VALUES
(1, 1, 'Site URL', '', 'text', '', 'site_url', 'http://wamtsol.com/clients/bilaltraders', 2),
(2, 1, 'Site Title', '', 'text', '', 'site_title', 'Bilal Traders', 1),
(3, 1, 'Admin Logo', '', 'file', '', 'admin_logo', '', 4),
(11, 1, 'Thermal Printer Title', 'Enter the thermal printer installed on your pc. You can find it in your control panel settings', 'text', '', 'thermal_printer_title', 'BlackCopper 80mm Series', 6),
(10, 1, 'Currency Symbol', '', 'text', '', 'currency_symbol', 'Rs', 5),
(7, 1, 'Admin Email', 'Main Email Address where all the notifications will be sent.', 'text', '', 'admin_email', 'admin@gmail.com', 3),
(12, 1, 'Thermal Printer Width', 'enter width in mm (e.g. 80)', 'text', '', 'thermal_printer_width', '80', 7),
(13, 1, 'Barcode Printer Title', 'Enter the barcode printer installed on your pc. You can find it in your control panel settings', 'text', '', 'barcode_printer_title', 'Bar Code Printer G210', 8),
(14, 1, 'Barcode Receipt Width', 'enter width in mm (e.g. 32)', 'text', '', 'barcode_printer_width', '34', 9),
(15, 1, 'Barcode Receipt Height', 'enter width in mm (e.g. 24)', 'text', '', 'barcode_printer_height', '24', 10),
(16, 1, 'Login Logo', '', 'file', '', 'login_logo', '', 11),
(20, 1, 'Reciept Logo', '', 'file', '', 'reciept_logo', '', 12),
(22, 1, 'Address Phone', '', 'textarea', '', 'address_phone', 'Address: Shop # 4, Hyderabad.\r\nPhone:090078601', 13),
(23, 1, 'Business Opening Hour', 'When shop/office is opened daily 1-24?', 'text', '', 'opening_hour', '09', 14);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `status` int(1) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `business_name`, `customer_name`, `city`, `state`, `country`, `address`, `phone`, `balance`, `status`, `ts`) VALUES
(1, NULL, 'Walk-In Customer', NULL, NULL, NULL, NULL, '', '0.0000', 1, '2022-09-23 09:28:55'),
(22, 'AAFAQ SANITARY', ' AAFAQ & ASHFAQ  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'BEHAR COLONY', '03153666300', '52381.0000', 1, '2022-10-01 06:59:25'),
(23, 'ABDUL JABBAR SANITARY', ' IRFAN BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #7', '03123645349', '18354.0000', 1, '2022-10-01 07:00:20'),
(24, 'ADNAN SANITARY', 'ADNAN', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #11', '03313679050', '197526.0000', 1, '2022-10-02 05:59:05'),
(25, 'AGHA SANITARY HALA NAKA', ' RAFIQ SOOMRO  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HALA NAKA', '03456396109', '21139.0000', 1, '2022-10-02 05:59:45'),
(26, 'AHMED HARDWARE', ' ABBAS TOPI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SADAR', '03332666417', '-552.0000', 1, '2022-10-02 06:01:04'),
(27, 'AHMED SANITARY', ' AHMED & HAMZA  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03323931750', '83335.0000', 1, '2022-10-01 15:10:30'),
(28, 'AHSAN SANITRAY', ' AHSAN BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'QASIMABAD', '03332633710', '4702.0000', 1, '2022-10-02 06:16:57'),
(29, 'AIJAZ SANITARY', ' AIJAZ  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LIAQAT COLONY', '03161319313', '6600.0000', 1, '2022-10-01 07:22:53'),
(30, 'AL-MADINA SANITARY ALAMDAR CHOCK', ' SHIRAZ JAMALI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'QASIMABAD', '03073047234', '640867.0000', 1, '2022-10-02 06:18:33'),
(31, 'AL-MADINA SANITARY BEHAR COLONY', ' ZAHID SOOMRO  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'BEHAR COLONY', '03123828189', '7919.0000', 1, '2022-10-02 06:19:45'),
(32, 'AL-MADINA SANITARY HALA NAKA', ' MAZHAR  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HALA NAKA', '03332058485', '4527.0000', 1, '2022-10-02 06:21:19'),
(33, 'AL-MADINA SANITARY LATIFABAD #6', ' MUNEEM  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #6', '03113768415', '13303.0000', 1, '2022-10-02 06:21:58'),
(34, 'AL-NOOR SANITARY TAY', ' HASNAIN  ', 'TANDO ALAHYAR', 'SINDH', 'PAKISTAN', 'TANDO ALAHYAR', '03111849995', '54576.0000', 1, '2022-10-02 06:23:15'),
(35, 'AL-REHAN SANITARY', ' REHAN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03128118224', '57444.0000', 1, '2022-10-02 06:24:11'),
(36, 'ANWER MALLAH SANNITARY', ' MUNAWWAR MALAH  ', 'TANDO MUHAMMAD KHAN', 'SINDH', 'PAKISTAN', 'TANDO MUHAMMAD KHAN', '03332818520', '96968.0000', 1, '2022-10-02 06:26:32'),
(37, 'ASGHAR SANITARY', ' ASGHAR  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'BEHAR COLONY', '03143850517', '180010.0000', 1, '2022-10-02 06:29:02'),
(38, 'ASIF NAZWAZ', ' ASIF NAZAW  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HALA NAKA', '3108781381', '0.0000', 1, '2022-09-23 09:28:55'),
(39, 'AWAIS & ALI SANITARY', ' AWAIS & Ali  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'QASIMABAD', '03003231429', '18635.0000', 1, '2022-10-02 06:30:40'),
(40, 'AYYOB CORPORATION', ' HAJI AYYOB  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'RISALA ROAD', '03103506466', '56856.0000', 1, '2022-10-02 06:33:27'),
(41, 'AZIZ SANITARY', ' AZIZ BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LIAQAT COLONY', '03223019882', '26486.0000', 1, '2022-10-02 06:35:16'),
(42, 'BABA SANITARY', ' ABDUL RAFEY  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03133277907', '22112.0000', 1, '2022-10-02 06:36:07'),
(43, 'BASHIR SANITARY MATYARI', ' AZHAR & UZAIR  ', 'MATYARI', 'SINDH', 'PAKISTAN', 'MATYARI', '03043708431', '0.0000', 1, '2022-09-23 09:28:55'),
(44, 'BHAVESH SANITARY TMK', ' BHAVESH  ', 'TANDO MUHAMMAD KHAN', 'SINDH', 'PAKISTAN', 'TANDO MUHAMMAD KHAN', '03332813955', '65029.0000', 1, '2022-10-02 06:37:32'),
(45, 'BHITAI SANITARY', ' BADSHAH & RAJA  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'GIDDU CHOCK', '03153029153', '4651.0000', 1, '2022-10-02 06:38:34'),
(46, 'BILAL SANITARY LATIFABAD #5', ' ABDUL MAJID & RASHID MALIK  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #5', '03332739366', '339463.0000', 1, '2022-10-02 06:39:52'),
(47, 'BILAL SANITARY SHIDI GOTH', ' TARIQ SHAIKH  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SHIDI GOTH', '03125008438', '2336.0000', 1, '2022-10-02 06:40:36'),
(48, 'BISMILLAH SANITARY CITIZEN COLONY', ' SAJID MEMON  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'CITIZEN COLONY', '03113002424', '24026.0000', 1, '2022-10-02 06:41:20'),
(49, 'DATA SANITARY', ' IMRAN & HASHIR  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HALA NAKA', '03110307502', '49992.0000', 1, '2022-10-02 06:42:31'),
(50, 'DIAMOND SANITARY', ' FAROOQ & AMEER  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HIRABAD', '03363034799', '30306.0000', 1, '2022-10-01 15:10:29'),
(51, 'FATIMA SANITARY', ' SHAKEEL  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03103226552', '64946.0000', 1, '2022-10-02 06:44:00'),
(52, 'FAZAL SANITARY', ' ZAID & SHEHERYAR  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'KOTRI', '03443422950', '31606.0000', 1, '2022-10-02 06:44:41'),
(53, 'FEROZ SANITARY', ' FARAZ  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'BEHAR COLONY', '03212994520', '690.0000', 1, '2022-10-02 06:46:01'),
(54, 'FINE SANITARY', ' ABDUL MAJID  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #8', '03147801110', '6169.0000', 1, '2022-10-02 06:50:45'),
(55, 'FOJI SANITARY', ' MANSOOR KHORO  ', 'JAMSHORO', 'SINDH', 'PAKISTAN', 'JAMSHORO', '03043881386', '2395.0000', 1, '2022-10-02 06:51:37'),
(56, 'GM & SONS TMK', ' GOVIND KUMAR  ', 'TANDO MUHAMMAD KHAN', 'SINDH', 'PAKISTAN', 'TANDO MUHAMMAD KHAN', '03002863426', '3607.0000', 1, '2022-10-02 06:52:18'),
(57, 'GM SANITARY', ' MUSTAFA  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #8', '03150321766', '116396.0000', 1, '2022-10-02 06:53:22'),
(58, 'GN SANITARY', ' ZAHEER  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'KOTRI', '03033385934', '425.0000', 1, '2022-10-02 06:54:52'),
(59, 'GOLDEN SANITARY', ' SHARIF BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03412802723', '34409.0000', 1, '2022-10-02 06:56:10'),
(60, 'HAJI MEHMOOD SANITARY', ' AMJAD  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HALI ROAD', '03110138987', '251.0000', 1, '2022-10-02 06:56:49'),
(61, 'HARIS TRADERS', ' ASAD  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'KOTRI', '03203036566', '15297.0000', 1, '2022-10-01 15:10:29'),
(62, 'AM/HASSAN SANITARY', ' WALEED & HASSAN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03313060488', '236.0000', 1, '2022-10-02 06:25:31'),
(63, 'HUSSAIN PAINTS', ' MOAZZAM SOOMRO  ', 'JAMSORO', 'SINDH', 'PAKISTAN', 'JAMSORO', '03013522373', '177707.0000', 1, '2022-10-02 06:58:24'),
(64, 'IBRAHEEM SANITARY', ' ABDUL HAFEEZ  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SHIDI GOTH', '03173022278', '19984.0000', 1, '2022-10-02 06:59:38'),
(65, 'IMRAN/NAWAZ SANITARY LATIFABAD #10', ' ARSLAN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03133536417', '43565.0000', 1, '2022-10-02 07:01:36'),
(66, 'IMRAN SANITARY NASIM NAGAR', ' ARIF BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'NASIM NAGAR', '03073227039', '173282.0000', 1, '2022-10-01 15:10:29'),
(67, 'INDUS ELECTRIC', ' DARSHAN BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'QASIMABAD', '03332790258', '16190.0000', 1, '2022-10-02 07:02:15'),
(68, 'IRFAN SANITARY LATIFABAD #8', ' FAISAL  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #8', '03332651912', '28514.0000', 1, '2022-10-01 15:10:29'),
(69, 'IRFAN SANITARY TAY', ' AFNAN  ', 'TANDO ALAHYAR', 'SINDH', 'PAKISTAN', 'TANDO ALAHYAR', '03163962516', '41086.0000', 1, '2022-10-01 15:10:29'),
(70, 'JASKANI SANITARY', ' TARIQ JASKANI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'GIDDU CHOCK', '03123521030', '94277.0000', 1, '2022-10-02 07:14:43'),
(71, 'JEELANI SANITARY', ' JAVED  ', 'THATTA', 'SINDH', 'PAKISTAN', 'THATTA', '03213718335', '9467.0000', 1, '2022-10-02 07:16:29'),
(72, 'JM SANITARY', ' JOHNSON  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SHIDI GOTH', '03120401936', '72894.0000', 1, '2022-10-02 07:17:36'),
(73, 'JUGNU SANITARY', 'MAJID', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'BYE PASS', '03041313853', '34701.0000', 1, '2022-10-01 15:10:29'),
(74, 'KASHIF SANITARY LATIFABAD #10', ' KASHIF  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03453645125', '38181.0000', 1, '2022-10-02 07:19:30'),
(75, 'KASHIF SANITARY LATIFABAD #7', ' KASHIF  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #7', '03332633509', '25923.0000', 1, '2022-10-01 15:10:29'),
(76, 'ARSLAN/KASHIF SANITARY TJ', ' ARSLAN/KASHIF  ', 'TANDO JAM', 'SINDH', 'PAKISTAN', 'TANDO JAM', '03131304751', '175098.0000', 1, '2022-10-02 06:28:19'),
(77, 'KHAN RAJPUT SANITARY', ' RASHID  ', 'MORO', 'SINDH', 'PAKISTAN', 'MORO', '03133608304', '6845.0000', 1, '2022-10-02 07:21:12'),
(78, 'KHAN TILES', ' FAHEEM  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SADAR', '03132877025', '98203.0000', 1, '2022-10-02 07:22:42'),
(79, 'KHANZADA SANITARY', 'FARHAN KHANZADA', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #6', '03133060803', '264960.0000', 1, '2022-10-02 07:23:26'),
(80, 'KHILJI SANITARY', ' ABDUL QADIR  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'FAQIR KA PIRH', '03142613741', '24535.0000', 1, '2022-10-02 07:24:14'),
(81, 'LAL BAKSH SANITARY', 'ISMAIL', 'JAMSHORO', 'SINDH', 'PAKISTAN', 'JAMSHORO', '03136593913', '67106.0000', 1, '2022-10-02 07:25:35'),
(82, 'M. BILAL ELECTRIC', ' ABDUL KAREEM  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SHIDI GOTH', '03160317280', '806.0000', 1, '2022-10-01 15:10:28'),
(83, 'MADINA SANITARY LATIFABAD #7', ' HAMID BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #7', '03463920901', '6469.0000', 1, '2022-10-02 07:27:18'),
(84, 'MADINA SANITARY MPK', ' ABDUL HAMEED  ', 'MIRPURKHAS', 'SINDH', 'PAKISTAN', 'MIRPURKHAS', '03133138938', '0.0000', 1, '2022-09-23 09:28:55'),
(85, 'MASHA ALLAH SANITARY', 'ALI RAZA', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'NASIM NAGAR', '03111388554', '63189.0000', 1, '2022-10-02 07:28:19'),
(86, 'MASHA ALLAH SANITARY LATIFABAD #11', ' ARSLAN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #11', '03443478227', '7919.0000', 1, '2022-10-02 07:28:58'),
(87, 'MEHERBAN SANITARY', ' IFRAN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'NOORANI BASTI', '0313898073', '9240.0000', 1, '2022-10-02 07:29:59'),
(88, 'MEHRAN SANITARY', ' NAFEES  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'PHULELI', '03163387406', '56320.0000', 1, '2022-10-02 07:31:20'),
(89, 'MOHSIN ELECTRIC', ' AYAZ  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SHIDI GOTH', '03022347194', '43345.0000', 1, '2022-10-02 07:32:16'),
(90, 'MOHSIN SANITARY', ' MOHSIN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03173140808', '87137.0000', 1, '2022-10-01 15:10:28'),
(91, 'MUNEEB SANITARY', ' MUNEEB  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #5', '03425434230', '325.0000', 1, '2022-10-02 07:34:34'),
(92, 'NASIR BROTHERS', ' BILAL  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HUSSAINABAD', '03453596540', '47404.0000', 1, '2022-10-02 07:35:30'),
(93, 'NEW ANWAR-UL-MADINA SANITARY', ' MUBASHIR  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'KOHSAR', '03332628489', '11150.0000', 1, '2022-10-02 07:36:40'),
(94, 'NEW MUSLIM SANITARY TMK', ' FEROZ  ', 'TANDO MUHAMMAD KHAN', 'SINDH', 'PAKISTAN', 'TANDO MUHAMMAD KHAN', '1234567', '33586.0000', 1, '2022-10-02 07:37:50'),
(95, 'NEW SINDH SANITARY MPK', ' NOMAN  ', 'MIRPURKHAS', 'SINDH', 'PAKISTAN', 'MIRPURKHAS', '03333096621', '22847.0000', 1, '2022-10-01 15:10:28'),
(96, 'NEW SINDH ELECTRIC NASIM NAGAR', ' AMJAD MEMON  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'NASIM NAGAR', '03153290110', '156200.0000', 1, '2022-10-01 15:10:28'),
(97, 'NEW TAHIRI SANITARY', 'POPI & SANNY', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #6', '03123064929', '93719.0000', 1, '2022-10-02 07:40:04'),
(98, 'NEW UNITED ELECTRIC MATYARI', 'SHEHZAD', 'MATYARI', 'SINDH', 'PAKISTAN', 'MATYARI', '03003087004', '12441.0000', 1, '2022-10-01 15:10:28'),
(99, 'NIAZ BROTHERS', ' NIAZ  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SADAR', '03213046941', '20455.0000', 1, '2022-10-02 07:41:49'),
(100, 'NIGAH-E- MUSTAFA TRADERS', ' MOHAN BHAI  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'NASIM NAGAR', '03123766479', '65372.0000', 1, '2022-10-02 07:42:49'),
(101, 'NOOR SHAH TILES MPK', ' RIAZ  ', 'MIRPURKHAS', 'SINDH', 'PAKISTAN', 'MIRPURKHAS', '03153732814', '70422.0000', 1, '2022-10-02 07:44:00'),
(102, 'NOORANI SANITARY MUSTAFA PARK', ' FAHEEM  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'MUSTAFA PARK', '03150329941', '39876.0000', 1, '2022-10-03 06:51:02'),
(103, 'NOORANI SANITARY PHULELI', ' SHOAIB  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'PHULELI', '03133901852', '90512.0000', 1, '2022-10-02 07:45:46'),
(104, 'OKAI SANITARY MATLI', 'ADNAN', 'MATLI', 'SINDH', 'PAKISTAN', 'MATLI', '03332803433', '42120.0000', 1, '2022-10-01 15:10:28'),
(105, 'PAK SANITARY SHAHAB CENIMA', 'JAHANGEER', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'SHAHAB CENIMA', '03142842451', '82077.0000', 1, '2022-10-01 15:10:27'),
(106, 'PAK SANITARY ZEAL PAK', ' ASHRAF  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'ZEAL PAK', '03472422202', '60422.0000', 1, '2022-10-01 15:10:27'),
(107, 'PAKISTAN SANITARY LATIFABAD #10', ' RASHID  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #10', '03463910626', '10310.0000', 1, '2022-10-02 07:54:12'),
(108, 'PAKISTAN SANITARY TMK', ' SHAHID  ', 'TANDO MUHAMMAD KHAN', 'SINDH', 'PAKISTAN', 'TANDO MUHAMMAD KHAN', '03332802569', '90644.0000', 1, '2022-10-02 07:54:51'),
(109, 'PARAS SANITARY', ' PARSHANT  ', 'THATTA', 'SINDH', 'PAKISTAN', 'THATTA', '03213712550', '2490.0000', 1, '2022-10-02 07:56:13'),
(110, 'QASIM SANITARY', ' QASIM  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #11', '03112407256', '7464.0000', 1, '2022-10-02 07:56:59'),
(111, 'RAFIA SANITARY', 'JAHANGEER', 'KOTRI', 'SINDH', 'PAKISTAN', 'KOTRI', '03144288611', '50267.0000', 1, '2022-10-02 07:57:43'),
(112, 'SHERJEEL SANITARY', 'TANVEER', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'ZEAL PAK', '03125946466', '24128.0000', 1, '2022-10-02 07:58:30'),
(113, 'SALEEM SANITARY', ' SALEEM  ', 'USMAN SHAH HORI', 'SINDH', 'PAKISTAN', 'USMAN SHAH HORI', '03003006717', '10986.0000', 1, '2022-10-02 07:59:14'),
(114, 'SAMAD/NOORANI ELECTRIC', ' SAMAD  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'QASIMABAD', '03063047124', '59730.0000', 1, '2022-10-01 15:10:27'),
(115, 'SHAH JEE SANITARY', ' HYDER  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HALI ROAD', '03123012726', '36303.0000', 1, '2022-10-01 15:10:27'),
(116, 'SHEERAZ SANITARY', ' SHEERAZ  ', 'MATLI', 'SINDH', 'PAKISTAN', 'MATLI', '03063219104', '86418.0000', 1, '2022-10-02 08:01:05'),
(117, 'SINDH SANITARY BHIT SHAH', ' GULZAR  ', 'BHIT SHAH', 'SINDH', 'PAKISTAN', 'BHIT SHAH', '03073535039', '47112.0000', 1, '2022-10-02 08:02:05'),
(118, 'SINDH SANITARY MATLI', 'RIZWAN', 'MATLI', 'SINDH', 'PAKISTAN', 'MATLI', '03003073275', '70780.0000', 1, '2022-10-02 08:02:47'),
(119, 'SOOMRA SANITARY', ' SALEH  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'NASIM NAGAR', '03103719723', '17890.0000', 1, '2022-10-02 08:03:32'),
(120, 'SOOMRO SANITARY', ' ALI SOOMRO  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HUSSAINABAD', '03323499003', '41476.0000', 1, '2022-10-02 08:04:55'),
(121, 'UMAIR SANITARY', ' UMAIR  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'KOTRI', '03123091391', '8530.0000', 1, '2022-10-02 08:05:41'),
(122, 'UMAR ADIL SANITARY', ' UMAR ADIL  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'LATIFABAD #5', '03343260697', '10105.0000', 1, '2022-10-02 08:06:57'),
(123, 'UNITED SANITARY MATIYARI', ' HAFIZ NISAR  ', 'MATYARI', 'SINDH', 'PAKISTAN', 'MATYARI', '3128237354', '8610.0000', 1, '2022-10-02 08:07:42'),
(124, 'UNITED SANITARY MPK', ' ADNAN  ', 'MIRPURKHAS', 'SINDH', 'PAKISTAN', 'MIRPURKHAS', '03128914420', '7919.0000', 1, '2022-10-02 08:08:39'),
(125, 'WALKIN CUSTOMER', ' WALKIN  ', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'HYDERABAD', '000', '0.0000', 1, '2022-09-23 09:28:55'),
(126, 'ZAFAR ELECTRIC', ' SHEHERYAR  ', 'KOTRI', 'SINDH', 'PAKISTAN', 'KOTRI', '03332750979', '0.0000', 1, '2022-09-23 09:28:55'),
(127, 'ZAIN SANITARY TMK', 'AYAZ', 'TANDO MUHAMMAD KHAN', 'SINDH', 'PAKISTAN', 'TANDO MUHAMMAD KHAN', '3332805535', '57479.0000', 1, '2022-10-02 08:10:33'),
(131, 'AYAN SANITARY LATIFABAD #5', 'DANIYAL', 'HYDERABAD', 'SINDH', 'PAKISTAN', 'lATIFABAD # 5', '03107054312', '13722.0000', 1, '2022-10-02 11:00:56'),
(132, NULL, 'MR Adil Baig', NULL, NULL, NULL, NULL, '123456', '0.0000', 1, '2022-09-23 09:28:55'),
(133, NULL, 'MR Abdul Aleem', NULL, NULL, NULL, NULL, '123456', '0.0000', 1, '2022-09-23 09:28:55'),
(134, NULL, 'Dr Arif', NULL, NULL, NULL, NULL, '123456', '0.0000', 1, '2022-09-23 09:28:55'),
(136, 'A.S TRADERS', 'ZAID', 'KHIPRO', 'SINDH', 'PAKISTAN', 'KHIPRO', '03323811363', '66450.0000', 1, '2022-10-02 11:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

CREATE TABLE `customer_payment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `account_id` int(11) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_payment`
--

INSERT INTO `customer_payment` (`id`, `customer_id`, `datetime_added`, `amount`, `account_id`, `details`, `status`, `ts`) VALUES
(2, 2, '2022-09-18 13:33:00', '10000.00', 0, '', 1, '2022-09-18 08:33:23'),
(3, 70, '2022-10-01 11:10:00', '4000.00', 0, 'Bilal cash', 1, '2022-10-03 06:14:55'),
(4, 92, '2022-10-01 11:15:00', '2000.00', 0, 'Bilal cash', 1, '2022-10-03 06:15:48'),
(5, 24, '2022-10-01 11:16:00', '4000.00', 0, 'Bilal easy pesa', 1, '2022-10-03 06:16:49'),
(6, 68, '2022-10-01 11:17:00', '6000.00', 0, 'Bilal easy pesa', 1, '2022-10-03 06:18:44'),
(7, 72, '2022-10-01 11:18:00', '5000.00', 0, 'Bilal easy pesa', 1, '2022-10-03 06:19:19'),
(8, 136, '2022-10-01 11:19:00', '20000.00', 0, 'HMB', 1, '2022-10-03 06:20:17'),
(9, 89, '2022-10-02 11:22:00', '5000.00', 0, 'Bilal cash', 1, '2022-10-03 06:23:19'),
(10, 71, '2022-10-02 11:24:00', '9000.00', 0, 'Bilal easy pesa', 1, '2022-10-03 06:24:33'),
(11, 24, '2022-10-02 11:25:00', '4000.00', 0, 'Abid Shah cash', 1, '2022-10-03 06:25:53'),
(12, 65, '2022-10-02 11:26:00', '3000.00', 0, 'Abid Shah cash', 1, '2022-10-03 06:28:14'),
(13, 35, '2022-10-02 11:28:00', '3000.00', 0, 'Abid Shah cash', 1, '2022-10-03 06:29:14'),
(14, 51, '2022-10-02 11:29:00', '5000.00', 0, 'Abid Shah cash', 1, '2022-10-03 06:30:14'),
(15, 86, '2022-10-02 11:30:00', '3000.00', 0, 'Abid Shah cash', 1, '2022-10-03 06:31:49'),
(16, 27, '2022-10-02 11:32:00', '5000.00', 0, 'HMB', 1, '2022-10-03 06:32:40'),
(17, 30, '2022-10-02 11:33:00', '35000.00', 0, 'Bilal cash', 1, '2022-10-03 06:33:54'),
(18, 92, '2022-10-03 16:23:00', '2000.00', 0, 'Bilal cash', 1, '2022-10-04 11:24:32'),
(19, 120, '2022-10-03 16:24:00', '5000.00', 0, 'Bilal cash', 1, '2022-10-04 11:25:38'),
(20, 24, '2022-10-03 16:25:00', '4000.00', 0, 'Bilal easy pesa', 1, '2022-10-04 11:26:18'),
(21, 44, '2022-10-03 16:26:00', '10000.00', 0, 'Bilal easy pesa', 1, '2022-10-04 11:27:12'),
(22, 101, '2022-10-03 16:27:00', '10000.00', 0, 'HMB', 1, '2022-10-04 11:28:00'),
(23, 69, '2022-10-03 16:28:00', '10000.00', 0, 'Bilal easy pesa', 1, '2022-10-04 11:28:29'),
(24, 34, '2022-10-03 16:28:00', '4000.00', 0, 'Bilal easy pesa', 1, '2022-10-04 11:29:01'),
(25, 123, '2022-10-03 16:29:00', '7000.00', 0, 'Fayyaz bhai Online ', 1, '2022-10-04 11:30:14'),
(26, 67, '2022-10-03 16:30:00', '1500.00', 0, 'Bilal easy pesa', 1, '2022-10-04 11:30:51'),
(27, 85, '2022-10-03 16:31:00', '4000.00', 0, 'Bilal easy pesa', 1, '2022-10-04 11:31:47'),
(28, 64, '2022-10-04 10:43:00', '5000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:09:38'),
(29, 117, '2022-10-04 10:44:00', '20000.00', 3, 'Abid Shah jazz cash', 1, '2022-10-11 11:09:12'),
(30, 46, '2022-10-04 10:44:00', '20000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:09:27'),
(31, 112, '2022-10-04 10:45:00', '3000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:08:47'),
(32, 106, '2022-10-04 10:46:00', '6000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:08:17'),
(33, 115, '2022-10-04 10:46:00', '4000.00', 2, 'Bilal cash', 1, '2022-10-11 11:08:26'),
(34, 80, '2022-10-04 10:46:00', '2000.00', 2, 'Bilal cash', 1, '2022-10-11 11:08:38'),
(35, 103, '2022-10-04 10:47:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:07:56'),
(36, 87, '2022-10-04 10:47:00', '2650.00', 2, 'Bilal cash', 1, '2022-10-11 11:08:04'),
(37, 88, '2022-10-04 10:48:00', '2500.00', 2, 'Bilal cash', 1, '2022-10-11 11:07:28'),
(38, 102, '2022-10-04 10:48:00', '7000.00', 2, 'Bilal cash', 1, '2022-10-11 11:07:37'),
(39, 29, '2022-10-04 10:48:00', '2000.00', 2, 'Bilal cash', 1, '2022-10-11 11:07:46'),
(40, 41, '2022-10-04 10:49:00', '2000.00', 2, 'Bilal cash', 1, '2022-10-11 11:06:58'),
(41, 105, '2022-10-04 10:49:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:07:07'),
(42, 24, '2022-10-04 10:49:00', '4000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:07:16'),
(43, 42, '2022-10-04 10:50:00', '2000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:06:38'),
(44, 74, '2022-10-04 10:50:00', '1000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:06:47'),
(45, 76, '2022-10-04 10:51:00', '17000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:06:28'),
(46, 75, '2022-10-04 10:53:00', '2000.00', 3, 'Abid Shah jazz cash', 1, '2022-10-11 11:06:15'),
(47, 131, '2022-10-04 10:54:00', '5000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:06:07'),
(48, 70, '2022-10-05 10:41:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 11:05:49'),
(49, 61, '2022-10-05 10:41:00', '3000.00', 2, 'Bilal cash', 1, '2022-10-11 11:05:58'),
(50, 111, '2022-10-05 10:42:00', '4000.00', 2, 'Bilal cash', 1, '2022-10-11 11:05:16'),
(51, 52, '2022-10-05 10:42:00', '4000.00', 2, 'Bilal cash', 1, '2022-10-11 11:05:26'),
(52, 121, '2022-10-05 10:42:00', '2000.00', 2, 'Bilal cash', 1, '2022-10-11 11:05:37'),
(53, 37, '2022-10-05 10:43:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:04:58'),
(54, 22, '2022-10-05 10:43:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 11:05:07'),
(55, 24, '2022-10-05 10:44:00', '4000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:04:32'),
(56, 122, '2022-10-05 10:44:00', '1000.00', 2, 'Bilal cash', 1, '2022-10-11 11:04:42'),
(57, 32, '2022-10-05 10:44:00', '2000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:04:50'),
(58, 114, '2022-10-06 10:58:00', '3000.00', 2, 'Bilal cash', 1, '2022-10-11 11:04:02'),
(59, 67, '2022-10-06 10:58:00', '1500.00', 2, 'Bilal cash', 1, '2022-10-11 11:04:24'),
(60, 100, '2022-10-06 10:59:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:45'),
(61, 66, '2022-10-06 10:59:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:54'),
(62, 96, '2022-10-06 11:00:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:19'),
(63, 48, '2022-10-06 11:00:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:27'),
(64, 81, '2022-10-06 11:00:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:37'),
(65, 63, '2022-10-06 11:01:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:02:53'),
(66, 49, '2022-10-06 11:01:00', '8000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:01'),
(67, 50, '2022-10-06 11:01:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 11:03:10'),
(68, 40, '2022-10-06 11:02:00', '3000.00', 2, 'Bilal cash', 1, '2022-10-11 11:02:43'),
(69, 24, '2022-10-06 11:03:00', '3000.00', 2, 'Bilal', 1, '2022-10-11 11:02:32'),
(70, 90, '2022-10-06 11:04:00', '5000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:02:12'),
(71, 97, '2022-10-06 11:05:00', '5000.00', 2, 'Abid Shah cash', 1, '2022-10-11 11:02:04'),
(72, 125, '2022-10-06 11:18:00', '2280.00', 2, 'Abid Shah Cash', 1, '2022-10-11 11:01:54'),
(73, 82, '2022-10-07 11:04:00', '5000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:01:44'),
(74, 70, '2022-10-08 11:04:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 11:01:35'),
(75, 95, '2022-10-08 11:05:00', '10000.00', 3, 'Abid Shah jazz cash', 1, '2022-10-11 11:01:18'),
(76, 64, '2022-10-08 11:05:00', '3000.00', 3, 'Abid Shah jazz cash', 1, '2022-10-11 11:01:27'),
(77, 39, '2022-10-08 11:06:00', '1500.00', 2, 'Bilal cash', 1, '2022-10-11 11:00:47'),
(78, 114, '2022-10-08 11:06:00', '2000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:00:57'),
(79, 89, '2022-10-08 11:06:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 11:01:06'),
(80, 30, '2022-10-08 11:07:00', '24000.00', 2, 'Bilal cash', 1, '2022-10-11 11:00:07'),
(81, 24, '2022-10-08 11:07:00', '4000.00', 5, 'Bilal easy pesa', 1, '2022-10-11 11:00:19'),
(82, 85, '2022-10-08 11:07:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 11:00:27'),
(83, 92, '2022-10-08 11:08:00', '2000.00', 2, 'Bilal cash', 1, '2022-10-11 10:59:44'),
(84, 27, '2022-10-08 11:08:00', '15000.00', 6, 'HMB', 1, '2022-10-11 10:59:56'),
(85, 125, '2022-10-08 15:40:00', '6500.00', 2, 'Payment against Sales #37', 1, '2022-10-11 06:00:17'),
(86, 118, '2022-10-10 10:56:00', '20000.00', 2, 'Bilal cash', 1, '2022-10-11 05:57:19'),
(87, 116, '2022-10-10 10:57:00', '20000.00', 2, 'Bilal cash', 1, '2022-10-11 05:58:06'),
(88, 108, '2022-10-10 11:00:00', '8000.00', 2, 'Bilal cash', 1, '2022-10-11 06:01:15'),
(89, 36, '2022-10-10 11:01:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 06:01:38'),
(90, 94, '2022-10-10 11:01:00', '10000.00', 2, 'Bilal cash', 1, '2022-10-11 06:02:02'),
(91, 51, '2022-10-10 11:02:00', '5000.00', 2, 'Bilal cash', 1, '2022-10-11 06:02:28'),
(92, 92, '2022-10-10 11:02:00', '2000.00', 2, 'Abid Shah cash', 1, '2022-10-11 06:03:07'),
(93, 120, '2022-10-10 11:03:00', '5000.00', 2, 'Abid Shah', 1, '2022-10-11 06:03:34'),
(94, 104, '2022-10-10 11:03:00', '10760.00', 2, 'Bilal', 1, '2022-10-11 06:03:55'),
(95, 85, '2022-10-10 11:04:00', '5000.00', 5, 'Bilal', 1, '2022-10-11 06:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `datetime_added`, `expense_category_id`, `account_id`, `details`, `amount`, `added_by`, `status`, `ts`) VALUES
(2, '2022-10-01 12:42:00', 22, 0, 'Haifa\'s tution fee', '500.00', 1, 1, '2022-10-05 07:43:21'),
(3, '2022-10-01 12:46:00', 25, 0, 'Milk 340 Bann 80', '420.00', 1, 1, '2022-10-05 07:46:42'),
(4, '2022-10-01 12:47:00', 22, 0, 'Pampers & Wipes', '490.00', 1, 1, '2022-10-05 07:47:37'),
(5, '2022-10-01 12:50:00', 11, 0, 'Anus 200 Jalam & Nehal 200', '400.00', 1, 1, '2022-10-05 07:50:58'),
(6, '2022-10-01 12:51:00', 6, 0, 'Mazdori 6 nug', '420.00', 1, 1, '2022-10-05 07:51:47'),
(7, '2022-10-01 12:53:00', 26, 0, 'Reck karaya Gadha Gari', '500.00', 1, 1, '2022-10-05 07:54:46'),
(8, '2022-10-01 13:26:00', 1, 0, 'Black tape', '40.00', 1, 1, '2022-10-05 08:26:53'),
(9, '2022-10-01 13:27:00', 26, 0, 'Hotel', '100.00', 1, 1, '2022-10-05 08:27:30'),
(10, '2022-10-02 13:29:00', 17, 0, 'Nehari', '365.00', 1, 1, '2022-10-05 08:30:18'),
(11, '2022-10-02 13:30:00', 25, 0, 'Milk', '425.00', 1, 1, '2022-10-05 08:31:35'),
(12, '2022-10-02 13:31:00', 4, 0, 'Abid Shah', '60.00', 1, 1, '2022-10-05 08:32:06'),
(13, '2022-10-02 13:32:00', 18, 0, 'Tala & Nehal medicines', '633.00', 1, 1, '2022-10-05 08:32:50'),
(14, '2022-10-03 13:34:00', 13, 0, 'Kherat', '10.00', 1, 1, '2022-10-05 08:34:45'),
(15, '2022-10-03 13:36:00', 18, 0, 'Rumessa doctor fee & medicines', '415.00', 1, 1, '2022-10-05 08:36:39'),
(16, '2022-10-03 13:37:00', 25, 0, 'Milk 170 bread 80', '250.00', 1, 1, '2022-10-05 08:37:45'),
(17, '2022-10-03 13:37:00', 22, 0, 'Paaper', '15.00', 1, 1, '2022-10-05 08:38:13'),
(18, '2022-10-03 13:40:00', 27, 0, 'Income tax return filed fee', '3000.00', 1, 1, '2022-10-05 08:40:51'),
(19, '2022-10-04 13:42:00', 20, 0, 'Nasha', '200.00', 1, 1, '2022-10-05 08:42:44'),
(20, '2022-10-04 13:42:00', 11, 0, 'Anus 150 Jamal & nehal 300\r\n', '450.00', 1, 1, '2022-10-05 08:51:51'),
(21, '2022-10-04 13:43:00', 4, 0, 'Abid Shah', '150.00', 1, 1, '2022-10-05 08:44:07'),
(22, '2022-10-04 13:44:00', 25, 0, 'Milk 340 eggs 260 Khala\'s pestri', '760.00', 1, 1, '2022-10-05 08:48:26'),
(23, '2022-10-04 13:45:00', 3, 0, 'Lassi', '100.00', 1, 1, '2022-10-05 08:45:52'),
(24, '2022-10-04 13:45:00', 13, 0, 'Kherat', '20.00', 1, 1, '2022-10-05 08:46:09'),
(25, '2022-10-05 13:42:00', 22, 0, 'Haifa anaar', '120.00', 1, 1, '2022-10-06 08:43:33'),
(26, '2022-10-05 13:43:00', 25, 0, 'Bann & Buscuit 100 Milk 510', '610.00', 1, 1, '2022-10-06 08:44:39'),
(27, '2022-10-05 13:44:00', 3, 0, 'Hotal', '80.00', 1, 1, '2022-10-06 08:45:13'),
(28, '2022-10-05 13:45:00', 6, 0, 'Mazdori 17 nug', '1190.00', 1, 1, '2022-10-06 08:46:19'),
(29, '2022-10-06 11:22:00', 13, 2, 'Kherat', '5.00', 1, 1, '2022-10-11 06:22:37'),
(30, '2022-10-06 11:24:00', 11, 2, 'Abid Shah 5000 Anus 150', '5150.00', 1, 1, '2022-10-11 06:25:10'),
(31, '2022-10-06 11:25:00', 21, 2, 'Noodles', '975.00', 1, 1, '2022-10-11 06:26:44'),
(32, '2022-10-06 11:26:00', 6, 5, 'Week ki tamam builties clear ki', '7880.00', 1, 1, '2022-10-11 06:42:20'),
(33, '2022-10-06 11:42:00', 4, 2, 'Abid Shah', '40.00', 1, 1, '2022-10-11 06:43:09'),
(34, '2022-10-06 11:43:00', 25, 2, 'Milk', '340.00', 1, 1, '2022-10-11 06:43:48'),
(35, '2022-10-06 11:44:00', 19, 2, 'CCTV camera  repair', '300.00', 1, 1, '2022-10-11 06:45:11'),
(36, '2022-10-07 11:54:00', 3, 2, 'Family', '2130.00', 1, 1, '2022-10-11 06:54:31'),
(37, '2022-10-07 11:54:00', 22, 2, 'Izyaan\'s lectogen', '1590.00', 1, 1, '2022-10-11 06:55:27'),
(38, '2022-10-07 11:55:00', 22, 2, 'Rumesa & Haifa rides', '120.00', 1, 1, '2022-10-11 06:56:19'),
(39, '2022-10-07 11:56:00', 25, 2, 'Milk', '510.00', 1, 1, '2022-10-11 06:57:04'),
(40, '2022-10-07 11:57:00', 13, 2, 'Masjid ', '100.00', 1, 1, '2022-10-11 06:57:43'),
(41, '2022-10-07 11:57:00', 20, 2, 'Nasha', '30.00', 1, 1, '2022-10-11 06:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`id`, `title`, `status`, `ts`) VALUES
(1, 'General', 1, '2022-10-05 06:55:29'),
(3, 'Refreshment', 1, '2022-10-05 06:54:23'),
(4, 'Petrol', 1, '2022-10-05 06:55:53'),
(5, 'Tour', 1, '2022-10-05 06:56:08'),
(6, 'Builty/Mazdori', 1, '2022-10-05 06:54:47'),
(7, 'Mobile', 1, '2022-10-05 06:56:23'),
(9, 'HESCO', 1, '2022-10-05 07:00:28'),
(10, 'Stationary', 1, '2022-10-05 07:00:41'),
(11, 'Staff/Salary', 1, '2022-10-05 07:01:03'),
(12, 'Water Expense', 1, '2022-09-17 10:48:52'),
(13, 'Charity', 1, '2022-10-05 07:01:29'),
(17, 'Family', 1, '2022-10-05 06:52:17'),
(18, 'Health Care', 1, '2022-10-05 07:15:42'),
(19, 'Maintenance/Repair', 1, '2022-10-05 07:05:35'),
(20, 'Personal', 1, '2022-10-05 07:03:12'),
(21, 'Grocery', 1, '2022-10-05 07:08:49'),
(22, 'Children', 1, '2022-10-05 07:10:04'),
(23, 'Fruits/Vegetables', 1, '2022-10-05 07:10:28'),
(24, 'SSGC', 1, '2022-10-05 07:11:58'),
(25, 'Bakery & Dairy', 1, '2022-10-05 07:45:24'),
(26, 'Miscellaneous', 1, '2022-10-05 07:53:24'),
(27, 'Tax', 1, '2022-10-05 08:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(10) DEFAULT NULL,
  `item_category_id` int(10) UNSIGNED DEFAULT NULL,
  `alert_quantity` decimal(22,4) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` decimal(11,0) NOT NULL,
  `sortorder` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `unit_id`, `item_category_id`, `alert_quantity`, `unit_price`, `sale_price`, `quantity`, `sortorder`, `status`, `ts`) VALUES
(1091, 'AUTOMATIC HAND DRYER', 1, 1, '2.0000', '4480.00', '0.00', '4', 0, 1, '2022-10-01 14:13:14'),
(1092, 'BALL COCK (COMMODE)', 1, 2, '24.0000', '120.00', '0.00', '10', NULL, 1, '2022-10-01 14:13:15'),
(1093, 'BALL COCK 1\" SHAHID', 1, 3, '12.0000', '460.00', '0.00', '59', NULL, 1, '2022-10-01 14:13:15'),
(1094, 'BALL COCK 1/2\" SHAHID', 1, 3, '24.0000', '348.75', '0.00', '42', NULL, 1, '2022-10-01 14:13:15'),
(1095, 'BALL COCK 3/4\" SHAHID', 1, 3, '24.0000', '386.25', '0.00', '24', NULL, 1, '2022-10-01 14:13:15'),
(1096, 'BALL VALVE UNION 25 MM', 1, 4, '10.0000', '820.00', '0.00', '10', NULL, 1, '2022-10-01 14:13:15'),
(1097, 'BALL VALVE UNION 32 MM', 1, 4, '10.0000', '820.00', '0.00', '10', NULL, 1, '2022-10-01 14:13:15'),
(1098, 'BASIN MIXTURE NEELAM', 1, 5, '10.0000', '1780.00', '0.00', '13', NULL, 1, '2022-10-01 14:13:15'),
(1099, 'BASIN MIXTURE VIVA', 1, 5, '0.0000', '1700.00', '0.00', '1', NULL, 1, '2022-10-01 14:13:15'),
(1100, 'BASIN MIXTURE MASTER', 1, 5, '10.0000', '1320.00', '0.00', '33', NULL, 1, '2022-10-01 14:13:15'),
(1101, 'BASIN MIXTURE S. ASIA', 1, 5, '5.0000', '1080.00', '0.00', '18', NULL, 1, '2022-10-01 14:13:15'),
(1102, 'BASIN MIXTURE P. ASIA', 1, 5, '0.0000', '1500.00', '0.00', '11', NULL, 1, '2022-10-01 14:13:15'),
(1103, 'BASIN MIXTURE ASIA MIX', 1, 5, '0.0000', '860.00', '0.00', '4', NULL, 1, '2022-09-26 10:05:12'),
(1104, 'BASIN MIXTURE FAUCET', 1, 5, '2.0000', '2310.00', '0.00', '2', NULL, 1, '2022-10-01 14:13:15'),
(1105, 'BASIN MIXTURE PEAK (COLOR)', 1, 5, '0.0000', '500.00', '0.00', '173', NULL, 1, '2022-10-06 11:24:19'),
(1106, 'BASIN MIXTURE PARAGON (COLOR)', 1, 5, '0.0000', '1018.75', '0.00', '65', NULL, 1, '2022-10-01 14:13:15'),
(1107, 'BASIN MIXTURE TEHZEEB (COLOR)', 1, 5, '0.0000', '575.00', '0.00', '161', 0, 1, '2022-10-04 11:07:04'),
(1108, 'BASIN MIXTURE PEAK (CP)', 1, 5, '10.0000', '750.00', '0.00', '0', NULL, 1, '2022-10-06 11:24:19'),
(1109, 'BASIN MIXTURE CHINA', 1, 5, '2.0000', '1400.00', '0.00', '8', NULL, 1, '2022-10-01 14:13:15'),
(1110, 'BATH ACCESSARY SET ICON (CP AAM)', 1, 1, '6.0000', '810.00', '0.00', '22', NULL, 1, '2022-10-01 14:13:15'),
(1111, 'BATH ACCESSORIES SET MORNING (COLOR)', 1, 1, '0.0000', '2400.00', '0.00', '16', NULL, 1, '2022-10-01 14:13:15'),
(1112, 'BATH ACCESSORIES SET VIGO (COLOR)', 1, 1, '0.0000', '1800.00', '0.00', '30', NULL, 1, '2022-10-03 12:15:00'),
(1114, 'BATH ACCESSORIES SET MASTER (COLOR)', 1, 1, '0.0000', '550.00', '0.00', '4', NULL, 1, '2022-10-01 14:13:15'),
(1115, 'BATH ACCESSORIES SET TAPSUN (COLOR)', 1, 1, '0.0000', '360.00', '0.00', '117', NULL, 1, '2022-10-05 12:20:09'),
(1116, 'BATH ACCESSORIES SET (CP PROFESSIONAL)', 1, 1, '2.0000', '1920.00', '0.00', '0', NULL, 1, '2022-10-01 14:13:15'),
(1117, 'BATH ACCESSORIES SET ICON (CP BHARI)', 1, 1, '6.0000', '780.00', '0.00', '7', NULL, 1, '2022-10-01 14:13:15'),
(1118, 'BATH ACCESSORIES SET TAPSUN (CP BHARI)', 1, 1, '6.0000', '1380.00', '0.00', '16', NULL, 1, '2022-10-01 14:13:15'),
(1119, 'BATH ACCESSORIES SET (CP KING)', 1, 1, '2.0000', '2160.00', '0.00', '2', NULL, 1, '2022-10-01 14:13:15'),
(1120, 'BATH ACCESSORIES SET TAPSUN (CP AAM)', 1, 1, '0.0000', '720.00', '0.00', '0', NULL, 1, '2022-10-01 14:13:15'),
(1121, 'BATH ACCESSORIES SET (CP VICTORIA)', 1, 1, '2.0000', '2250.00', '0.00', '14', NULL, 1, '2022-10-01 14:13:16'),
(1122, 'BIB COCK NEELAM', 1, 5, '24.0000', '684.00', '0.00', '136', NULL, 1, '2022-10-01 14:13:16'),
(1123, 'BIB COCK VIVA', 1, 5, '0.0000', '530.00', '0.00', '4', NULL, 1, '2022-10-01 14:13:16'),
(1124, 'BIB COCK MASTER', 1, 5, '60.0000', '510.00', '0.00', '169', NULL, 1, '2022-10-06 11:24:19'),
(1125, 'BIB COCK S. ASIA', 1, 5, '60.0000', '415.00', '0.00', '354', NULL, 1, '2022-10-06 11:24:19'),
(1126, 'BIB COCK ILMAS', 1, 5, '0.0000', '850.00', '0.00', '12', NULL, 1, '2022-10-01 14:13:16'),
(1127, 'BIB COCK PARAGON (ABS COLOR)', 1, 5, '0.0000', '190.00', '0.00', '206', NULL, 1, '2022-10-04 10:43:38'),
(1128, 'BIB COCK PEAK (COLOR)', 1, 5, '0.0000', '140.00', '0.00', '96', NULL, 1, '2022-10-08 10:41:58'),
(1129, 'BIB COCK TEHZEEB (COLOR)', 1, 5, '0.0000', '160.00', '0.00', '822', 0, 1, '2022-10-11 12:04:35'),
(1130, 'BIB COCK PEAK (BRASS BUSH COLOR)', 1, 5, '0.0000', '150.00', '0.00', '103', NULL, 1, '2022-10-01 14:13:16'),
(1131, 'BIB COCK UROOJ (COLOR)', 1, 5, '0.0000', '135.00', '0.00', '0', NULL, 1, '2022-10-08 10:41:58'),
(1132, 'BIB COCK PEAK (CP)', 1, 5, '24.0000', '165.00', '0.00', '0', NULL, 1, '2022-10-03 12:15:00'),
(1133, 'BIB COCK PARAGON (KS COLOR)', 1, 5, '0.0000', '260.00', '0.00', '52', NULL, 1, '2022-10-01 14:13:16'),
(1134, 'BIB COCK (PLASTIC SPANDLE COLOR)', 1, 5, '120.0000', '40.00', '0.00', '330', NULL, 1, '2022-10-01 14:13:16'),
(1135, 'BIB COCK (PVC PAKISTANI COLOR)', 1, 5, '120.0000', '60.00', '0.00', '852', NULL, 1, '2022-10-01 14:13:16'),
(1136, 'BLACK TAPE 1.5\"', 1, 6, '60.0000', '75.00', '0.00', '162', NULL, 1, '2022-10-01 14:13:16'),
(1137, 'BLACK TAPE 2\"', 1, 6, '60.0000', '90.00', '0.00', '42', NULL, 1, '2022-10-01 14:13:16'),
(1138, 'BOLT KIT BELLO', 1, 7, '50.0000', '53.00', '0.00', '182', NULL, 1, '2022-10-06 09:35:50'),
(1139, 'BOLT KIT DELUX', 1, 7, '0.0000', '36.00', '0.00', '103', NULL, 1, '2022-10-01 14:13:16'),
(1140, 'BOLT KIT CAPTAN (BRASS NUT BHARI)', 1, 7, '24.0000', '120.00', '0.00', '118', NULL, 1, '2022-10-06 09:35:50'),
(1141, 'BOLT KIT DELUX (BRASS NUT AAM)', 1, 7, '50.0000', '100.00', '0.00', '46', NULL, 1, '2022-10-08 10:41:58'),
(1142, 'BOLT KIT (CARD MS)', 1, 7, '50.0000', '58.00', '0.00', '40', NULL, 1, '2022-10-01 14:13:17'),
(1143, 'BOLT KIT (CARD SS)', 1, 7, '24.0000', '108.00', '0.00', '161', NULL, 1, '2022-10-01 14:13:17'),
(1144, 'CATCHER (CHORUS)', 1, 8, '100.0000', '6.00', '0.00', '732', NULL, 1, '2022-10-01 14:13:17'),
(1145, 'CATCHER (INDUS)', 1, 8, '100.0000', '6.00', '0.00', '738', NULL, 1, '2022-10-01 14:13:17'),
(1146, 'CATCHER (MASTER)', 1, 8, '100.0000', '6.00', '0.00', '1217', NULL, 1, '2022-10-01 14:13:17'),
(1147, 'CHAL NIPPLE 4\"x1/2\"', 2, 9, '5.0000', '240.00', '0.00', '0', NULL, 1, '2022-10-01 14:20:22'),
(1148, 'CHAL NIPPLE 4\"x3/4\"', 2, 9, '5.0000', '300.00', '0.00', '0', NULL, 1, '2022-10-01 14:20:22'),
(1149, 'CHAL NIPPLE 5\"x1/2\"', 2, 9, '5.0000', '360.00', '0.00', '0', NULL, 1, '2022-10-01 14:20:23'),
(1150, 'CHAL NIPPLE 5\"x3/4\"', 2, 9, '5.0000', '360.00', '0.00', '1', NULL, 1, '2022-10-01 14:20:23'),
(1151, 'CHAL NIPPLE 6\"x1/2\"', 2, 9, '5.0000', '350.00', '0.00', '9', NULL, 1, '2022-10-01 14:20:23'),
(1152, 'CHAL NIPPLE 6\"x3/4\"', 2, 9, '5.0000', '435.00', '0.00', '5', NULL, 1, '2022-10-01 14:20:23'),
(1153, 'CHECK VALVE KITZ (BHARI) 3/4\"', 1, 4, '0.0000', '350.00', '0.00', '12', NULL, 1, '2022-10-01 14:20:23'),
(1154, 'CHECK VALVE RBS 1\"', 1, 4, '24.0000', '500.00', '0.00', '47', NULL, 1, '2022-10-01 14:20:23'),
(1155, 'CHECK VALVE FLY 1\"', 1, 4, '12.0000', '660.00', '0.00', '15', NULL, 1, '2022-10-01 14:20:23'),
(1156, 'CHECK VALVE KHALIL (KHARA) 1.5\"', 1, 4, '0.0000', '1600.00', '0.00', '3', NULL, 1, '2022-10-01 14:20:23'),
(1157, 'CHECK VALVE KITZ (AAM) 1/2\"', 1, 4, '0.0000', '240.00', '0.00', '24', NULL, 1, '2022-10-01 14:20:23'),
(1158, 'CHECK VALVE FLY 1/2\"', 1, 4, '24.0000', '390.00', '0.00', '87', NULL, 1, '2022-10-01 14:20:23'),
(1159, 'CHECK VALVE  RBS 1/2\"', 1, 4, '48.0000', '285.00', '0.00', '166', NULL, 1, '2022-10-04 11:07:04'),
(1160, 'CHECK VALVE KHALIL 2.5\"', 1, 4, '0.0000', '2000.00', '0.00', '1', NULL, 1, '2022-10-01 14:20:23'),
(1161, 'CHECK VALVE KHALIL 3\"', 1, 4, '0.0000', '2500.00', '0.00', '3', NULL, 1, '2022-10-01 14:20:23'),
(1162, 'CHECK VALVE FLY 3/4\"', 1, 4, '36.0000', '480.00', '0.00', '37', NULL, 1, '2022-10-01 14:20:23'),
(1163, 'CHECK VALVE RBS 3/4\"', 1, 4, '60.0000', '337.50', '0.00', '78', NULL, 1, '2022-10-06 11:24:19'),
(1164, 'CHECK VALVE KHALIL (KHARA) 3/4\"', 1, 4, '36.0000', '500.00', '0.00', '24', NULL, 1, '2022-10-06 11:30:55'),
(1165, 'CHECK VALVE KHALIL (KHARA AAM) 1\"', 1, 4, '36.0000', '570.00', '0.00', '54', NULL, 1, '2022-10-01 14:20:23'),
(1166, 'CHECK VALVE KHALIL (KHARA) 1\"', 1, 4, '36.0000', '730.00', '0.00', '30', NULL, 1, '2022-10-06 11:30:55'),
(1167, 'CHECK VALVE KHALIL (KHARA) 1.25\"', 1, 4, '0.0000', '1000.00', '0.00', '1', NULL, 1, '2022-10-01 14:20:23'),
(1168, 'CHECK VALVE KHALIL (KHARA) 1/2\"', 1, 4, '36.0000', '355.00', '0.00', '0', NULL, 1, '2022-10-01 14:20:23'),
(1169, 'CHINA COCK 1/4\"', 1, 4, '250.0000', '80.00', '0.00', '144', NULL, 1, '2022-10-04 11:20:22'),
(1170, 'CHUTKI NUT', 3, 14, '2.0000', '650.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:14'),
(1171, 'FLOOR WASTE CLASSIC (COLOR)', 1, 1, '0.0000', '45.00', '0.00', '1981', NULL, 1, '2022-10-08 10:41:58'),
(1172, 'MIXTURE TUBE (CHABI COLOR) 18\"', 1, 10, '50.0000', '84.00', '0.00', '221', NULL, 1, '2022-10-01 14:24:14'),
(1173, 'MIXTURE TUBE (CHABI COLOR) 24\"', 1, 10, '50.0000', '90.00', '0.00', '569', NULL, 1, '2022-10-01 14:24:14'),
(1174, 'MIXTURE TUBE (CHABI COLOR) 36\"', 1, 10, '50.0000', '105.00', '0.00', '154', NULL, 1, '2022-10-01 14:24:14'),
(1175, 'COLOR TUBE 1.25 METER MORNING (COLOR)', 1, 10, '200.0000', '225.00', '0.00', '198', NULL, 1, '2022-10-01 14:24:14'),
(1176, 'COLOR TUBE 1.5 METER MORNING (COLOR)', 1, 10, '150.0000', '250.00', '0.00', '209', NULL, 1, '2022-10-01 14:24:14'),
(1177, 'COLOR TUBE 1 METER MORNING (COLOR)', 1, 10, '400.0000', '185.00', '0.00', '443', NULL, 1, '2022-10-01 14:24:14'),
(1178, 'COMMODE HANDLE 10\"', 1, 2, '10.0000', '260.00', '0.00', '58', NULL, 1, '2022-10-01 14:24:14'),
(1179, 'COMMODE HANDLE 12\"', 1, 2, '10.0000', '280.00', '0.00', '35', NULL, 1, '2022-10-01 14:24:14'),
(1180, 'COMMODE HANDLE 8\"', 1, 2, '10.0000', '240.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:14'),
(1181, 'COMMODE KIT (CARD MS)', 1, 7, '50.0000', '27.00', '0.00', '116', NULL, 1, '2022-10-01 14:24:14'),
(1182, 'COMMODE SEAT COVER IFO', 1, 2, '70.0000', '420.00', '0.00', '125', NULL, 1, '2022-10-01 14:24:14'),
(1183, 'COMMODE SEAT COVER AQUA', 1, 2, '70.0000', '800.00', '0.00', '61', NULL, 1, '2022-10-01 14:24:14'),
(1184, 'COMMODE SEAT COVER VIP PORTA', 1, 2, '70.0000', '800.00', '0.00', '97', NULL, 1, '2022-10-01 14:24:15'),
(1185, 'COMPLETE BATH SET COLOR (PARAGON)', 1, 11, '35.0000', '3750.00', '0.00', '71', 0, 1, '2022-10-08 07:24:28'),
(1186, 'COMPLETE BATH SET BUNTY LEVER (NEELAM)', 1, 11, '2.0000', '9300.00', '0.00', '4', 0, 1, '2022-10-06 06:10:21'),
(1187, 'COMPLETE BATH SET CLASSIC DRONE LEVER (WONDER)', 1, 11, '2.0000', '9700.00', '0.00', '2', 0, 1, '2022-10-06 06:09:44'),
(1188, 'COMPLETE BATH SET CROWN CP (Y.S)', 1, 11, '0.0000', '6500.00', '0.00', '1', 0, 1, '2022-10-06 06:11:39'),
(1189, 'COMPLETE BATH SET GROHI CP', 1, 11, '4.0000', '7200.00', '0.00', '7', 0, 1, '2022-10-06 06:16:14'),
(1190, 'COMPLETE BATH SET CRYSTAL CP (NEELAM)', 1, 11, '2.0000', '10080.00', '0.00', '1', 0, 1, '2022-10-06 06:07:47'),
(1191, 'COMPLETE BATH SET CRYSTAL HEAVY (VIVA)', 1, 11, '0.0000', '7600.00', '0.00', '1', 0, 1, '2022-10-06 06:16:39'),
(1192, 'COMPLETE BATH SET DIAMOND CP (NEELAM)', 1, 11, '2.0000', '6850.00', '0.00', '0', 0, 1, '2022-10-06 06:17:12'),
(1193, 'COMPLETE BATH SET DIAMOND HEAD (VIVA)', 1, 11, '0.0000', '6900.00', '0.00', '2', 0, 1, '2022-10-06 06:17:42'),
(1194, 'COMPLETE BATH SET DRONE CP (NEELAM)', 1, 11, '2.0000', '9100.00', '0.00', '1', 0, 1, '2022-10-06 06:18:45'),
(1195, 'COMPLETE BATH SET DRONE LEVER (TAPSUN)', 1, 11, '2.0000', '8900.00', '0.00', '4', 0, 1, '2022-10-06 06:19:14'),
(1196, 'COMPLETE BATH SET DRONE LEVER SMALL (TAPSUN)', 1, 11, '0.0000', '8500.00', '0.00', '2', 0, 1, '2022-10-06 06:19:36'),
(1197, 'COMPLETE BATH SET F-1', 1, 11, '2.0000', '7700.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:15'),
(1198, 'COMPLETE BATH SET F-10', 1, 11, '2.0000', '15600.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:15'),
(1199, 'COMPLETE BATH SET F-16', 1, 11, '2.0000', '8450.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:15'),
(1200, 'COMPLETE BATH SET F-3', 1, 11, '2.0000', '8900.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:15'),
(1201, 'COMPLETE BATH SET F-7', 1, 11, '2.0000', '9800.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:15'),
(1202, 'COMPLETE BATH SET FPH', 1, 11, '2.0000', '6500.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:15'),
(1203, 'COMPLETE BATH SET FUH', 1, 11, '2.0000', '7050.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:15'),
(1204, 'COMPLETE BATH SET FULL DIAMOND PRIME LEVER CP (GREAT)', 1, 11, '2.0000', '15000.00', '0.00', '0', 0, 1, '2022-10-06 06:20:26'),
(1205, 'COMPLETE BATH SET LEVER CLASSIC (NEELAM)', 1, 11, '2.0000', '8500.00', '0.00', '2', 0, 1, '2022-10-06 06:20:58'),
(1206, 'COMPLETE BATH SET LEVER CLASSIC (WONDER)', 1, 11, '2.0000', '9000.00', '0.00', '2', 0, 1, '2022-10-06 06:21:29'),
(1207, 'COMPLETE BATH SET LEVER COCA F-9 (NEELAM)', 1, 11, '2.0000', '9030.00', '0.00', '1', 0, 1, '2022-10-06 06:21:54'),
(1208, 'COMPLETE BATH SET LEVER F-9 (NEELAM)', 1, 11, '2.0000', '8820.00', '0.00', '5', 0, 1, '2022-10-06 06:22:22'),
(1209, 'COMPLETE BATH SET MEDIUM COLOR (MASTER)', 1, 11, '0.0000', '4800.00', '0.00', '32', 0, 1, '2022-10-08 07:24:28'),
(1210, 'COMPLETE BATH SET OCEAN LEVER DIAMOND (WONDER)', 1, 11, '2.0000', '10000.00', '0.00', '5', 0, 1, '2022-10-06 06:23:28'),
(1211, 'COMPLETE BATH SET SHAHEEN CP (GREAT)', 1, 11, '2.0000', '11500.00', '0.00', '1', 0, 1, '2022-10-06 06:24:10'),
(1212, 'COMPLETE BATH SET SIGMA GROHI (TAPSUN)', 1, 11, '2.0000', '11000.00', '0.00', '3', 0, 1, '2022-10-06 06:24:37'),
(1213, 'COMPLETE BATH SET SONIC HEAD (VIVA)', 1, 11, '0.0000', '8600.00', '0.00', '2', 0, 1, '2022-10-06 06:25:02'),
(1214, 'COMPLETE BATH SET SONICS HEAD QUEEN (TAPSUN)', 1, 11, '0.0000', '8100.00', '0.00', '1', 0, 1, '2022-10-06 06:25:31'),
(1215, 'COMPLETE BATH SET SUPER DRONE DIAMOND LEVER (NEELAM)', 1, 11, '2.0000', '13000.00', '0.00', '3', 0, 1, '2022-10-06 06:25:58'),
(1216, 'COMPLETE BATH SET SUPER DRONE DIAMOND LEVER (TAPSUN)', 1, 11, '2.0000', '13500.00', '0.00', '2', 0, 1, '2022-10-06 06:26:44'),
(1217, 'COMPLETE BATH SET SUPER DRONE LEVER (TAPSUN)', 1, 11, '2.0000', '12000.00', '0.00', '4', 0, 1, '2022-10-06 06:27:34'),
(1218, 'COMPLETE BATH SET COLOR (PEL)', 1, 11, '0.0000', '8800.00', '0.00', '1', 0, 1, '2022-10-06 06:28:28'),
(1219, 'COMPLETE BATH SET ZERO SIZE COLOR  (MASTER)', 1, 11, '50.0000', '4200.00', '0.00', '40', 0, 1, '2022-10-06 06:29:11'),
(1220, 'COMPLETE MUSLIM SHOWER PARAGON (COLOR)', 1, 12, '0.0000', '400.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:16'),
(1221, 'COMPLETE MUSLIM SHOWER MORNING (COLOR)', 1, 12, '200.0000', '450.00', '0.00', '491', NULL, 1, '2022-10-10 09:44:00'),
(1222, 'COMPLETE MUSLIM SHOWER PEAK (CP)', 1, 12, '25.0000', '440.00', '0.00', '9', NULL, 1, '2022-10-06 11:24:19'),
(1223, 'COMPLETE MUSLIM SHOWER TAPSUN (COLOR)', 1, 12, '0.0000', '300.00', '0.00', '62', NULL, 1, '2022-10-01 14:24:16'),
(1224, 'COMPLETE MUSLIM SHOWER VITAL (COLOR)', 1, 12, '0.0000', '240.00', '0.00', '43', NULL, 1, '2022-10-01 14:24:16'),
(1225, 'COMPLETE MUSLIM SHOWER MORNING (CP)', 1, 12, '50.0000', '600.00', '0.00', '98', NULL, 1, '2022-10-10 09:35:57'),
(1226, 'COMPLETE MUSLIM SHOWER PEAK (VIP COLOR)', 1, 12, '200.0000', '320.00', '0.00', '353', NULL, 1, '2022-10-08 10:41:58'),
(1227, 'CONNECTION PIPE (STEEL NUT) 18\"', 1, 10, '50.0000', '80.00', '0.00', '172', NULL, 1, '2022-10-01 14:24:16'),
(1228, 'CONNECTION PIPE (STEEL NUT) 24\"', 1, 10, '50.0000', '90.00', '0.00', '93', NULL, 1, '2022-10-01 14:24:16'),
(1229, 'COOLER TOTI LEVER', 1, 5, '50.0000', '35.00', '0.00', '444', NULL, 1, '2022-10-01 14:24:16'),
(1230, 'CORNER CABINET MORNING (COLOR)', 1, 1, '0.0000', '1450.00', '0.00', '21', NULL, 1, '2022-10-01 14:24:16'),
(1231, 'CORNER STEEL SHELF 10\"', 1, 1, '5.0000', '640.00', '0.00', '21', NULL, 1, '2022-10-01 14:24:16'),
(1232, 'CORNER STEEL SHELF 12\"', 1, 1, '5.0000', '810.00', '0.00', '17', NULL, 1, '2022-10-01 14:24:16'),
(1233, 'CP CHAIN 1.25 METER', 1, 10, '20.0000', '225.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:16'),
(1234, 'CP CHAIN 1.5 METER', 1, 10, '20.0000', '250.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:16'),
(1235, 'CP CHAIN 1 METER', 1, 10, '30.0000', '185.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:16'),
(1236, 'CP PIYALA CUP (SS)', 4, 13, '10.0000', '50.00', '0.00', '49', NULL, 1, '2022-10-01 14:24:17'),
(1237, 'CP JUMBO CUP (SS)', 4, 13, '10.0000', '100.00', '0.00', '16', NULL, 1, '2022-10-01 14:24:17'),
(1238, 'CP NIPPLE 1\" (BHARI)', 1, 9, '100.0000', '72.00', '0.00', '513', NULL, 1, '2022-10-06 11:30:55'),
(1239, 'CP NIPPLE 1.5\" (BHARI)', 1, 9, '72.0000', '84.00', '0.00', '251', NULL, 1, '2022-10-06 11:30:55'),
(1240, 'CP NIPPLE 2\" (AAM)', 1, 9, '0.0000', '65.00', '0.00', '428', NULL, 1, '2022-10-01 14:24:17'),
(1241, 'CP NIPPLE 2\" (AAM)', 1, 9, '0.0000', '65.00', '0.00', '75', NULL, 1, '2022-10-01 14:24:17'),
(1242, 'CP NIPPLE 2\" (BHARI)', 1, 9, '48.0000', '90.00', '0.00', '36', NULL, 1, '2022-10-06 11:30:55'),
(1243, 'CP NIPPLE 3\" (AAM)', 1, 9, '0.0000', '118.00', '0.00', '48', NULL, 1, '2022-10-01 14:24:17'),
(1244, 'CP NIPPLE 3\" (BHARI)', 1, 9, '24.0000', '156.00', '0.00', '36', NULL, 1, '2022-10-01 14:24:17'),
(1245, 'CP NIPPLE 4\" (AAM)', 1, 9, '0.0000', '145.00', '0.00', '88', NULL, 1, '2022-10-01 14:24:17'),
(1246, 'CP NIPPLE 4\" (BHARI)', 1, 9, '24.0000', '209.00', '0.00', '131', NULL, 1, '2022-10-01 14:24:17'),
(1247, 'CP NIPPLE 6\" (BHARI)', 1, 9, '12.0000', '274.00', '0.00', '24', NULL, 1, '2022-10-01 14:24:17'),
(1248, 'CP PLATE (MS)', 2, 13, '24.0000', '66.00', '0.00', '38', NULL, 1, '2022-10-01 14:24:17'),
(1249, 'CP PLATE (SS)', 2, 13, '24.0000', '114.00', '0.00', '46', NULL, 1, '2022-10-01 14:24:17'),
(1250, 'CP PLATE (SS)', 2, 13, '0.0000', '215.00', '0.00', '46', NULL, 1, '2022-10-01 14:24:17'),
(1251, 'FLOOR WASTE CRYSTAL ( COLOR)', 1, 1, '0.0000', '55.00', '0.00', '809', NULL, 1, '2022-10-01 14:24:17'),
(1252, 'CRYSTAL JET SHOWER GOL (COLOR)', 1, 12, '70.0000', '126.00', '0.00', '227', NULL, 1, '2022-10-01 14:24:17'),
(1253, 'D-SINK MIXTURE', 1, 5, '2.0000', '4080.00', '0.00', '4', NULL, 1, '2022-10-06 09:52:52'),
(1254, 'DHAGA (BARA)', 1, 6, '20.0000', '108.00', '0.00', '96', NULL, 1, '2022-10-01 14:24:17'),
(1255, 'DHAGA (CHOTA)', 3, 6, '0.0000', '150.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:17'),
(1256, 'DHAGA (JUMBO)', 3, 6, '0.0000', '220.00', '0.00', '6', NULL, 1, '2022-10-03 09:37:12'),
(1257, 'FLOOR WASTE DIAMOND (COLOR)', 1, 1, '300.0000', '65.00', '0.00', '663', NULL, 1, '2022-10-01 14:24:17'),
(1258, 'DIVIDER IDREES', 1, 5, '6.0000', '720.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:17'),
(1259, 'DIVIDER TAPSUN', 1, 5, '6.0000', '700.00', '0.00', '14', NULL, 1, '2022-10-03 08:55:53'),
(1260, 'DIVIDER (BHARI) J.S', 1, 5, '0.0000', '700.00', '0.00', '6', NULL, 1, '2022-10-01 14:24:17'),
(1261, 'DOUBLE BIB COCK NEELAM', 1, 5, '10.0000', '1170.00', '0.00', '15', NULL, 1, '2022-10-01 14:24:17'),
(1262, 'DOUBLE BIB COCK VIVA', 1, 5, '0.0000', '1400.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:17'),
(1263, 'DOUBLE BIB COCK MASTER', 1, 5, '10.0000', '830.00', '0.00', '17', NULL, 1, '2022-10-01 14:24:17'),
(1264, 'DOUBLE BIB COCK S. ASIA', 1, 5, '8.0000', '720.00', '0.00', '16', NULL, 1, '2022-10-01 14:24:18'),
(1265, 'DOUBLE BIB COCK P. ASIA', 1, 5, '0.0000', '910.00', '0.00', '14', NULL, 1, '2022-10-01 14:24:18'),
(1266, 'DOUBLE BIB COCK WONDER', 1, 5, '0.0000', '1000.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1267, 'DOUBLE BIB COCK ASIA MIX', 1, 5, '0.0000', '870.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1268, 'DOUBLE BIB COCK BURAQ', 1, 5, '0.0000', '870.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:18'),
(1269, 'DOUBLE BIB COCK (COLOR) PEAK', 1, 5, '0.0000', '340.00', '0.00', '251', NULL, 1, '2022-10-01 14:24:18'),
(1270, 'DOUBLE BIB COCK (COLOR) PARAGON', 1, 5, '0.0000', '465.00', '0.00', '64', NULL, 1, '2022-10-01 14:24:18'),
(1271, 'DOUBLE BIB COCK (COLOR)TEHZEEB', 1, 5, '70.0000', '350.00', '0.00', '193', NULL, 1, '2022-10-01 14:24:18'),
(1272, 'DOUBLE BIB COCK (CP) PEAK', 1, 5, '10.0000', '450.00', '0.00', '37', NULL, 1, '2022-10-01 14:24:18'),
(1273, 'DOUBLE CHAND SARI (BRASS)', 1, 14, '50.0000', '45.00', '0.00', '119', NULL, 1, '2022-10-03 12:21:33'),
(1274, 'DOUBLE CHAND SARI (SS)', 1, 14, '50.0000', '40.00', '0.00', '274', NULL, 1, '2022-10-01 14:24:18'),
(1275, 'DOUBLE SINK BOWL 68\"x45\"x20\"', 1, 15, '2.0000', '6750.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1276, 'DOUBLE SINK BOWL 75\"x40\"x20\"', 1, 15, '2.0000', '8100.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1277, 'DOUBLE SINK BOWL 78\"x43\"x20\"', 1, 15, '2.0000', '8775.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:18'),
(1278, 'DOUBLE SINK BOWL 82\"x45\"x20\"', 1, 15, '2.0000', '8910.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1279, 'DOUBLE SINK BOWL 82\"x45\"x22\"', 1, 15, '2.0000', '9720.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1280, 'FLUSH TANK (COLOR) MORNING', 1, 29, '45.0000', '1200.00', '0.00', '85', NULL, 1, '2022-10-01 14:24:18'),
(1281, 'FLUSH TANK (COLOR) GRACE', 1, 29, '45.0000', '1350.00', '0.00', '83', NULL, 1, '2022-10-01 14:24:18'),
(1282, 'FLOOR WASTE (COLOR) PARAGON', 1, 1, '0.0000', '145.00', '0.00', '75', NULL, 1, '2022-10-01 14:24:18'),
(1283, 'FLOOR WASTE (COLOR) AGS/SNS', 1, 1, '0.0000', '60.00', '0.00', '91', NULL, 1, '2022-10-06 11:24:19'),
(1284, 'FLOOR WASTE (COLOR) SALEEM', 1, 1, '0.0000', '40.00', '0.00', '396', NULL, 1, '2022-10-06 11:24:19'),
(1285, 'FLOOR WASTE (COLOR) MORNING', 1, 1, '400.0000', '165.00', '0.00', '481', NULL, 1, '2022-10-03 12:21:33'),
(1286, 'FLOOR WASTE (STEEL) TAPSUN', 1, 1, '20.0000', '150.00', '0.00', '15', NULL, 1, '2022-10-01 14:24:18'),
(1287, 'FLOOR WASTE (STEEL) NAZIR & SONS', 1, 1, '0.0000', '210.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:18'),
(1288, 'FLOOR WASTE (STEEL) ARHAM', 1, 1, '0.0000', '210.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:18'),
(1289, 'FLOOR WASTE (STEEL) LG', 1, 1, '0.0000', '210.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:18'),
(1290, 'FLOOR WASTE (STEEL) BOSS', 1, 1, '0.0000', '200.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:18'),
(1291, 'FLOOR WASTE (STEEL HOLE) TAPSUN', 1, 1, '20.0000', '150.00', '0.00', '34', NULL, 1, '2022-10-01 14:24:19'),
(1292, 'FLUSH BUTTON (DOUBLE BUSH)', 1, 2, '20.0000', '200.00', '0.00', '69', NULL, 1, '2022-10-01 14:24:19'),
(1293, 'FLUSH BUTTON (SINGLE BUSH)', 1, 2, '20.0000', '120.00', '0.00', '69', NULL, 1, '2022-10-01 14:24:19'),
(1294, 'FOOT VALVE 1\" RBS', 1, 4, '100.0000', '270.00', '0.00', '301', NULL, 1, '2022-10-05 12:20:09'),
(1295, 'FOOT VALVE 1\" ALPHA', 1, 4, '50.0000', '570.00', '0.00', '144', NULL, 1, '2022-10-01 14:24:19'),
(1296, 'FOOT VALVE 1\" GRACE', 1, 4, '0.0000', '290.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:19'),
(1297, 'FOOT VALVE 1.25\" RBS', 1, 4, '25.0000', '450.00', '0.00', '33', NULL, 1, '2022-10-01 14:24:19'),
(1298, 'FOOT VALVE 1.25\" ALPHA', 1, 4, '15.0000', '810.00', '0.00', '86', NULL, 1, '2022-10-01 14:24:19'),
(1299, 'FOOT VALVE 1.25\" GRACE', 1, 4, '0.0000', '340.00', '0.00', '20', NULL, 1, '2022-10-01 14:24:19'),
(1300, 'FOOT VALVE 1.5\" RBS', 1, 4, '10.0000', '550.00', '0.00', '22', NULL, 1, '2022-10-01 14:24:19'),
(1301, 'FOOT VALVE 1.5\" ALPHA', 1, 4, '10.0000', '1100.00', '0.00', '36', NULL, 1, '2022-10-01 14:24:19'),
(1302, 'FOOT VALVE 1.5\" GRACE', 1, 4, '0.0000', '520.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:19'),
(1303, 'FOOT VALVE 1.5\" STAR', 1, 4, '0.0000', '700.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:19'),
(1304, 'FOOT VALVE 2\" RBS', 1, 4, '5.0000', '750.00', '0.00', '9', NULL, 1, '2022-10-01 14:24:19'),
(1305, 'FOOT VALVE 2\" ALPHA', 1, 4, '5.0000', '1500.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:19'),
(1306, 'FOOT VALVE 2\" GRACE', 1, 4, '0.0000', '735.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:19'),
(1307, 'FOOT VALVE 2.5\" RBS', 1, 4, '0.0000', '1500.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:19'),
(1308, 'FOOT VALVE 3\" RBS', 1, 4, '0.0000', '1900.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:19'),
(1309, 'FOOT VALVE (PVC) 1\" SHAKEEL', 1, 4, '24.0000', '140.00', '0.00', '152', NULL, 1, '2022-10-01 14:24:19'),
(1310, 'FOOT VALVE (PVC) 1.25\" SHAKEEL', 1, 4, '12.0000', '170.00', '0.00', '51', NULL, 1, '2022-10-01 14:24:19'),
(1311, 'FOOT VALVE (PVC) 2\" SHAKEEL', 1, 4, '12.0000', '400.00', '0.00', '49', NULL, 1, '2022-10-01 14:24:20'),
(1312, 'FOOT VALVE (PVC) 3/4\" SHAKEEL', 1, 4, '24.0000', '140.00', '0.00', '126', NULL, 1, '2022-10-01 14:24:20'),
(1313, 'GAS COCK 1/4\"', 1, 3, '20.0000', '150.00', '0.00', '152', NULL, 1, '2022-10-01 14:24:20'),
(1314, 'GAS COCK 1/2\"', 1, 3, '20.0000', '270.00', '0.00', '119', NULL, 1, '2022-10-01 14:24:20'),
(1315, 'GATE VALVE 1/2\"', 1, 4, '0.0000', '250.00', '0.00', '14', NULL, 1, '2022-10-01 14:24:20'),
(1316, 'GEEZER PIPE 18\"', 4, 10, '50.0000', '110.00', '0.00', '196', NULL, 1, '2022-10-06 11:05:55'),
(1317, 'GEEZER PIPE 24\"', 4, 10, '50.0000', '120.00', '0.00', '41', NULL, 1, '2022-10-06 11:05:55'),
(1318, 'GI HOOK 1\"', 3, 16, '10.0000', '780.00', '0.00', '15', NULL, 1, '2022-10-01 14:24:20'),
(1319, 'GI HOOK 1.5\"', 3, 16, '5.0000', '1020.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:20'),
(1320, 'GI HOOK 1/2\"', 3, 16, '10.0000', '840.00', '0.00', '33', NULL, 1, '2022-10-01 14:24:20'),
(1321, 'GI HOOK 2\"', 3, 16, '5.0000', '1020.00', '0.00', '6', NULL, 1, '2022-10-01 14:24:20'),
(1322, 'GODAY (AAM BRASS)', 4, 17, '25.0000', '255.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:20'),
(1323, 'GODAY (BARAY BRASS)', 4, 17, '25.0000', '315.00', '0.00', '72', NULL, 1, '2022-10-01 14:24:20'),
(1324, 'GODAY (BRASS)', 4, 17, '0.0000', '560.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:20'),
(1325, 'GODAY (LONG BRASS)', 4, 17, '50.0000', '240.00', '0.00', '95', NULL, 1, '2022-10-01 14:24:20'),
(1326, 'GODAY (SMALL BRASS)', 4, 17, '50.0000', '180.00', '0.00', '151', NULL, 1, '2022-10-01 14:24:20'),
(1327, 'GODAY (SS CHINA)', 4, 17, '50.0000', '140.00', '0.00', '198', NULL, 1, '2022-10-01 14:24:20'),
(1328, 'HANDLE VALVE 1\" SHOUKAT', 1, 4, '0.0000', '560.00', '0.00', '74', NULL, 1, '2022-10-01 14:24:20'),
(1329, 'HANDLE VALVE 1\" MASTER', 1, 4, '50.0000', '390.00', '0.00', '54', NULL, 1, '2022-10-06 09:42:08'),
(1330, 'HANDLE VALVE 1\" FAZAL', 1, 4, '50.0000', '470.00', '0.00', '98', NULL, 1, '2022-10-06 09:42:08'),
(1331, 'HANDLE VALVE 1\" GEO', 1, 4, '0.0000', '620.00', '0.00', '51', NULL, 1, '2022-10-01 14:24:20'),
(1332, 'HANDLE VALVE 1\" RBS', 1, 4, '50.0000', '660.00', '0.00', '119', NULL, 1, '2022-10-01 14:24:20'),
(1333, 'HANDLE VALVE 1.25\" ARSLAN MASTER', 1, 4, '2.0000', '1150.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:20'),
(1334, 'HANDLE VALVE 1.25\" IA HERO', 1, 4, '2.0000', '1620.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:20'),
(1335, 'HANDLE VALVE 1.5\" ARSLAN MASTER', 1, 4, '2.0000', '1650.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:20'),
(1336, 'HANDLE VALVE 1.5\" IA HERO', 1, 4, '2.0000', '2160.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:20'),
(1337, 'HANDLE VALVE 1/2\" MZ HERO', 1, 4, '100.0000', '250.00', '0.00', '414', NULL, 1, '2022-10-03 12:03:12'),
(1338, 'HANDLE VALVE 1/2\" SHOUKAT', 1, 4, '0.0000', '280.00', '0.00', '27', NULL, 1, '2022-10-01 14:24:20'),
(1339, 'HANDLE VALVE 1/2\" MASTER', 1, 4, '100.0000', '175.00', '0.00', '210', NULL, 1, '2022-10-10 09:19:16'),
(1340, 'HANDLE VALVE 1/2\" FAZAL', 1, 4, '100.0000', '250.00', '0.00', '82', NULL, 1, '2022-10-10 09:40:02'),
(1341, 'HANDLE VALVE 1/2\" YOUSUF CLASSIC', 1, 4, '0.0000', '290.00', '0.00', '65', NULL, 1, '2022-10-01 14:24:21'),
(1342, 'HANDLE VALVE 1/2\" YOUSAF BLACK', 1, 4, '0.0000', '305.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:21'),
(1343, 'HANDLE VALVE 1/2\" GEO', 1, 4, '0.0000', '270.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:21'),
(1344, 'HANDLE VALVE 1/2\" LATIF KITZ', 1, 4, '0.0000', '180.00', '0.00', '100', NULL, 1, '2022-10-01 14:24:21'),
(1345, 'HANDLE VALVE 1/2\" RBS', 1, 4, '100.0000', '330.00', '0.00', '324', NULL, 1, '2022-10-10 09:24:20'),
(1346, 'HANDLE VALVE 1/4\" MASTER', 1, 4, '0.0000', '155.00', '0.00', '70', NULL, 1, '2022-10-08 07:24:28'),
(1347, 'HANDLE VALVE 1/4\" SUPER LATIF MASTER', 1, 4, '0.0000', '155.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:21'),
(1348, 'HANDLE VALVE 1/4\" AHS', 1, 4, '50.0000', '170.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:21'),
(1349, 'HANDLE VALVE 2\" ARSLAN MASTER', 1, 4, '2.0000', '2150.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:21'),
(1350, 'HANDLE VALVE 2\" IA HERO', 1, 4, '2.0000', '2640.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:21'),
(1351, 'HANDLE VALVE 3/4\" MZ HERO', 1, 4, '100.0000', '310.00', '0.00', '262', NULL, 1, '2022-10-03 12:03:12'),
(1352, 'HANDLE VALVE 3/4\" SHOUKAT', 1, 4, '0.0000', '420.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:21'),
(1353, 'HANDLE VALVE 3/4\" MASTER', 1, 4, '100.0000', '205.00', '0.00', '263', NULL, 1, '2022-10-06 11:30:55'),
(1354, 'HANDLE VALVE 3/4\" FAZAL', 1, 4, '100.0000', '310.00', '0.00', '108', NULL, 1, '2022-10-10 09:40:02'),
(1355, 'HANDLE VALVE 3/4\" YOUSAF BLACK', 1, 4, '0.0000', '370.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:21'),
(1356, 'HANDLE VALVE 3/4\" NAGINA', 1, 4, '0.0000', '345.00', '0.00', '94', NULL, 1, '2022-10-01 14:24:21'),
(1357, 'HANDLE VALVE 3/4\" FLY', 1, 4, '0.0000', '340.00', '0.00', '50', NULL, 1, '2022-10-01 14:24:21'),
(1358, 'HANDLE VALVE 3/4\" RBS', 1, 4, '100.0000', '427.50', '0.00', '338', NULL, 1, '2022-10-10 09:19:16'),
(1359, 'HEAD (COLOR) MASTER', 1, 18, '250.0000', '30.00', '0.00', '755', NULL, 1, '2022-10-01 14:24:21'),
(1360, 'HEAD (CP) MASTER', 1, 18, '48.0000', '41.00', '0.00', '103', NULL, 1, '2022-10-01 14:24:21'),
(1361, 'HEAD (CP) SAWANA', 1, 18, '48.0000', '42.00', '0.00', '65', NULL, 1, '2022-10-01 14:24:21'),
(1362, 'HIGH PRESSURE BALL COCK (COMPLETE SET)', 1, 2, '10.0000', '1000.00', '0.00', '17', NULL, 1, '2022-10-01 14:24:21'),
(1363, 'HOCKEY PIPE FLEXIBLE (COLOR)', 1, 19, '250.0000', '45.00', '0.00', '320', NULL, 1, '2022-10-04 10:43:38'),
(1364, 'HOCKEY PIPE HARD (COLOR)', 1, 19, '200.0000', '60.00', '0.00', '189', NULL, 1, '2022-10-01 14:24:21'),
(1365, 'HOCKEY PIPE (STEEL)', 1, 19, '50.0000', '230.00', '0.00', '59', NULL, 1, '2022-10-10 09:40:02'),
(1366, 'HYDROLIC SEAT COVER', 1, 2, '50.0000', '1200.00', '0.00', '40', NULL, 1, '2022-10-01 14:24:22'),
(1367, 'INJECTOR (BRASS SEALED) 1\"x1.25\"', 1, 20, '50.0000', '280.00', '0.00', '63', NULL, 1, '2022-10-01 14:24:22'),
(1368, 'INJECTOR (BRASS SEALED) 3/4\"x1\"', 1, 20, '25.0000', '225.00', '0.00', '25', NULL, 1, '2022-10-01 14:24:22'),
(1369, 'INJECTOR (BRASS SEALED ANOKHA SIZE) 1\"x1.25\"', 1, 20, '50.0000', '280.00', '0.00', '55', NULL, 1, '2022-10-01 14:24:22'),
(1370, 'INJECTOR (PLASTIC SEALED) 1\"x1.25\"', 1, 20, '25.0000', '210.00', '0.00', '13', NULL, 1, '2022-10-01 14:24:22'),
(1371, 'J LEVER', 1, 2, '50.0000', '30.00', '0.00', '123', NULL, 1, '2022-10-01 14:24:22'),
(1372, 'JAZZ COCK (COLOR)', 1, 5, '0.0000', '440.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:22'),
(1373, 'JET SHOWER (STEEL) 4\"x4\"', 1, 30, '20.0000', '130.00', '0.00', '55', NULL, 1, '2022-10-03 07:51:24'),
(1374, 'JET SHOWER (STEEL) 6\"x6\"', 1, 30, '20.0000', '200.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:22'),
(1375, 'JET SHOWER CHORUS AGS (COLOR)', 1, 30, '0.0000', '110.00', '0.00', '237', NULL, 1, '2022-10-08 10:41:58'),
(1376, 'JET SHOWER CHORUS (COLOR)', 1, 30, '50.0000', '175.00', '0.00', '206', NULL, 1, '2022-10-01 14:24:22'),
(1377, 'JET SHOWER CHORUS (COLOR) U MASTER', 1, 30, '0.0000', '125.00', '0.00', '8', NULL, 1, '2022-10-01 14:24:22'),
(1378, 'JET SHOWER GOL (COLOR) MORNING', 1, 30, '70.0000', '280.00', '0.00', '213', NULL, 1, '2022-10-03 08:55:53'),
(1379, 'JET SHOWER GOL (CP) MORNING', 1, 30, '20.0000', '330.00', '0.00', '23', NULL, 1, '2022-10-03 08:55:53'),
(1380, 'JOBLI CLIP 1\"', 5, 16, '0.0000', '940.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:22'),
(1381, 'JOBLI CLIP 5/8\"', 5, 16, '0.0000', '780.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:22'),
(1382, 'K-3 KILLI 3 HOOKS', 1, 16, '12.0000', '130.00', '0.00', '16', NULL, 1, '2022-10-01 14:24:22'),
(1383, 'K-3 KILLI 4 HOOKS', 1, 16, '12.0000', '175.00', '0.00', '20', NULL, 1, '2022-10-01 14:24:22'),
(1384, 'K-3 KILLI 5 HOOKS', 1, 16, '12.0000', '220.00', '0.00', '11', NULL, 1, '2022-10-01 14:24:22'),
(1385, 'K-3 KILLI 6 HOOKS', 1, 16, '12.0000', '265.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:22'),
(1386, 'K-4 KILLI 3 HOOKS', 1, 16, '12.0000', '165.00', '0.00', '8', NULL, 1, '2022-10-01 14:24:22'),
(1387, 'K-4 KILLI 4 HOOKS', 1, 16, '12.0000', '220.00', '0.00', '62', NULL, 1, '2022-10-01 14:24:22'),
(1388, 'K-4 KILLI 5 HOOKS', 1, 16, '12.0000', '270.00', '0.00', '33', NULL, 1, '2022-10-01 14:24:22'),
(1389, 'K-4 KILLI 6 HOOKS', 1, 16, '12.0000', '325.00', '0.00', '24', NULL, 1, '2022-10-01 14:24:22'),
(1390, 'K-5 KILLI 4 HOOKS', 1, 16, '12.0000', '230.00', '0.00', '18', NULL, 1, '2022-10-01 14:24:22'),
(1391, 'K-5 KILLI 5 HOOKS', 1, 16, '12.0000', '290.00', '0.00', '18', NULL, 1, '2022-10-01 14:24:22'),
(1392, 'K-5 KILLI 6 HOOKS', 1, 16, '12.0000', '345.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:22'),
(1393, 'K-7 KILLI 3 HOOKS', 1, 16, '12.0000', '175.00', '0.00', '16', NULL, 1, '2022-10-01 14:24:22'),
(1394, 'K-7 KILLI 4 HOOKS', 1, 16, '12.0000', '230.00', '0.00', '24', NULL, 1, '2022-10-01 14:24:22'),
(1395, 'K-7 KILLI 5 HOOKS', 1, 16, '12.0000', '290.00', '0.00', '43', NULL, 1, '2022-10-01 14:24:23'),
(1396, 'K-7 KILLI 6 HOOKS', 1, 16, '12.0000', '345.00', '0.00', '22', NULL, 1, '2022-10-01 14:24:23'),
(1397, 'KARI HEAD (COLOR)', 1, 18, '150.0000', '30.00', '0.00', '228', NULL, 1, '2022-10-01 14:24:23'),
(1398, 'KARIZMA SINK MIXTURE', 1, 5, '2.0000', '3500.00', '0.00', '6', NULL, 1, '2022-10-01 14:24:23'),
(1399, 'LEVER BASIN MIXTURE CHINA', 1, 5, '2.0000', '3010.00', '0.00', '6', NULL, 1, '2022-10-01 14:24:23'),
(1400, 'LEVER HEAD (AAM BHARI)', 1, 18, '6.0000', '145.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:23'),
(1401, 'LEVER HEAD (BAREY BHARI)', 1, 18, '6.0000', '195.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:23'),
(1402, 'LEVER HEAD (DIAMOND)', 1, 18, '6.0000', '720.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:23'),
(1403, 'LEVER HEAD (KHALA HEAVY)', 1, 18, '6.0000', '210.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:23'),
(1404, 'LEVER HEAD (REMIX)', 1, 18, '6.0000', '210.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:23'),
(1405, 'LEVER HEAD (TIKKI)', 1, 18, '6.0000', '130.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:23'),
(1406, 'LEVER SINK MIXTURE PAKISTANI', 1, 5, '2.0000', '4970.00', '0.00', '7', NULL, 1, '2022-10-01 14:24:23'),
(1407, 'LEVER SINK MIXTURE CHINA', 1, 5, '2.0000', '2250.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:23'),
(1408, 'LINE CLAMP 12\"x3/4\"', 1, 16, '24.0000', '460.00', '0.00', '6', NULL, 1, '2022-10-04 11:02:11'),
(1409, 'LINE CLAMP 2\"x1/2\"', 1, 16, '24.0000', '180.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:23'),
(1410, 'LINE CLAMP 2\"x3/4\"', 1, 16, '24.0000', '145.00', '0.00', '15', NULL, 1, '2022-10-03 12:03:12'),
(1411, 'LINE CLAMP 3\"x1/2\"', 1, 16, '24.0000', '190.00', '0.00', '29', NULL, 1, '2022-10-01 14:24:23'),
(1412, 'LINE CLAMP 3\"x3/4\"', 1, 16, '24.0000', '190.00', '0.00', '38', NULL, 1, '2022-10-04 11:02:11'),
(1413, 'LINE CLAMP 4\"x1/2\"', 1, 16, '24.0000', '190.00', '0.00', '34', NULL, 1, '2022-10-01 14:24:23'),
(1414, 'LINE CLAMP 4\"x3/4\"', 1, 16, '24.0000', '190.00', '0.00', '44', NULL, 1, '2022-10-04 11:07:04'),
(1415, 'LINE CLAMP 6\"x1/2\"', 1, 16, '24.0000', '220.00', '0.00', '25', NULL, 1, '2022-10-01 14:24:23'),
(1416, 'LINE CLAMP 6\"x3/4\"', 1, 16, '24.0000', '220.00', '0.00', '57', NULL, 1, '2022-10-04 11:02:11'),
(1417, 'LINE CLAMP 8\"x1/2\"', 1, 16, '12.0000', '340.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:23'),
(1418, 'LINE CLAMP 8\"x3/4\"', 1, 16, '12.0000', '340.00', '0.00', '12', NULL, 1, '2022-10-04 11:02:11'),
(1419, 'LINE CLAMP PACKING (FOAM)', 1, 16, '20.0000', '60.00', '0.00', '50', NULL, 1, '2022-09-26 10:05:41'),
(1420, 'LINE CLAMP PACKING (RUBBER)', 1, 16, '6.0000', '180.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:23'),
(1421, 'MAIN HOLE COVER (PVC) 12\"x12\" PERFECT', 1, 21, '24.0000', '220.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:23'),
(1422, 'MAIN HOLE COVER (PVC) 12\"x12\" MASTER', 1, 21, '24.0000', '230.00', '0.00', '46', NULL, 1, '2022-10-11 12:04:35'),
(1423, 'MAIN HOLE COVER (PVC) 15\"x15\" PERFECT', 1, 21, '12.0000', '470.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:23'),
(1424, 'MAIN HOLE COVER (PVC) 18\"x18\" PERFECT', 1, 21, '12.0000', '660.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:23'),
(1425, 'MAIN HOLE COVER (PVC) 18\"x18\" VOLVO', 1, 21, '12.0000', '660.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:23'),
(1426, 'MAIN HOLE COVER (PVC) 18\"x18\" ICS', 1, 21, '12.0000', '660.00', '0.00', '27', NULL, 1, '2022-10-10 11:19:46'),
(1427, 'MAIN HOLE COVER (PVC) 24\"x24\" PERFECT', 1, 21, '12.0000', '1440.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:24'),
(1428, 'MAIN HOLE COVER (PVC) 24\"x24\" VOLVO', 1, 21, '12.0000', '1440.00', '0.00', '20', NULL, 1, '2022-10-11 12:04:35'),
(1429, 'MAIN HOLE COVER (PVC) 6\"x6\" PERFECT', 1, 21, '24.0000', '75.00', '0.00', '13', NULL, 1, '2022-10-04 11:02:11'),
(1430, 'MAIN HOLE COVER (PVC) 9\"x9\" PERFECT', 1, 21, '24.0000', '135.00', '0.00', '22', NULL, 1, '2022-10-04 11:02:11'),
(1431, 'MAIN HOLE COVER (PVC BHARI) 12\"x12\" PERFECT', 1, 21, '24.0000', '460.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:24'),
(1432, 'MAIN HOLE COVER (PVC BHARI) 9\"x9\" PERFECT', 1, 21, '24.0000', '390.00', '0.00', '18', NULL, 1, '2022-10-01 14:24:24'),
(1433, 'MAIN HOLE COVER (STEEL) 12\"x12\" SIRONA', 1, 21, '0.0000', '720.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:24'),
(1434, 'MAIN HOLE COVER (STEEL) 12\"x12\" SUPER DIAMOND', 1, 21, '0.0000', '400.00', '0.00', '8', NULL, 1, '2022-10-10 09:34:44'),
(1435, 'MAIN HOLE COVER (STEEL) 15\"x15\" SUPER DIAMOND', 1, 21, '0.0000', '700.00', '0.00', '0', NULL, 1, '2022-10-11 12:06:48'),
(1436, 'MAIN HOLE COVER (STEEL) 18\"x18\" SIRONA', 1, 21, '0.0000', '1290.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:24'),
(1437, 'MAIN HOLE COVER (STEEL) 18\"x18\" EMPERIAL', 1, 21, '0.0000', '1290.00', '0.00', '0', NULL, 1, '2022-10-11 12:06:48'),
(1438, 'MAIN HOLE COVER (STEEL) 24\"x24\" SIRONA', 1, 21, '0.0000', '2220.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:24'),
(1439, 'MAIN HOLE COVER (STEEL) 9\"x9\" SUPER DIAMOND', 1, 21, '0.0000', '280.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:24'),
(1440, 'MASTER CHAND SARI', 1, 14, '50.0000', '80.00', '0.00', '105', NULL, 1, '2022-10-01 14:24:24'),
(1441, 'METER LOCK 1/2\"', 1, 3, '20.0000', '270.00', '0.00', '124', NULL, 1, '2022-10-01 14:24:24'),
(1442, 'METER LOCK 3/4\"', 1, 3, '20.0000', '120.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:24'),
(1443, 'MIRROR (COLOR)', 1, 1, '100.0000', '432.00', '0.00', '132', NULL, 1, '2022-10-05 12:20:09'),
(1444, 'MIXTURE TUBE (4\" NOZZLE) 18\"', 4, 10, '50.0000', '160.00', '0.00', '335', NULL, 1, '2022-10-01 14:24:24'),
(1445, 'MIXTURE TUBE (4\" NOZZLE) 24\"', 4, 10, '50.0000', '170.00', '0.00', '90', NULL, 1, '2022-10-01 14:24:24'),
(1446, 'MIXTURE TUBE (BRASS NOZZLE) 18\"', 4, 10, '50.0000', '140.00', '0.00', '195', NULL, 1, '2022-10-01 14:24:24'),
(1447, 'MIXTURE TUBE (BRASS NOZZLE) 24\"', 4, 10, '50.0000', '155.00', '0.00', '206', NULL, 1, '2022-10-01 14:24:24'),
(1448, 'BASIN MIXTURE (NALKA 1\') CHINA', 1, 5, '2.0000', '1470.00', '0.00', '9', NULL, 1, '2022-10-01 14:24:24'),
(1449, 'NECK (CP)', 1, 5, '0.0000', '700.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:24'),
(1450, 'NECK FILTER (IRON)', 1, 5, '100.0000', '102.00', '0.00', '172', NULL, 1, '2022-10-06 11:30:55'),
(1451, 'NYLON CONNECTION 18\"', 1, 10, '200.0000', '30.00', '0.00', '542', NULL, 1, '2022-10-06 11:30:55'),
(1452, 'NYLON CONNECTION 24\"', 1, 10, '200.0000', '35.00', '0.00', '600', NULL, 1, '2022-10-06 11:30:55'),
(1453, 'NYLON CONNECTION 36\"', 1, 10, '100.0000', '45.00', '0.00', '156', NULL, 1, '2022-10-06 11:30:55'),
(1454, 'NYLON CONNECTION 48\"', 1, 10, '50.0000', '58.00', '0.00', '97', NULL, 1, '2022-10-01 14:24:25'),
(1455, 'P-TRAP 3.5\"', 1, 22, '36.0000', '150.00', '0.00', '90', 0, 1, '2022-10-03 08:55:53'),
(1456, 'P-TRAP 4\" (FLAT)', 1, 22, '150.0000', '180.00', '0.00', '15', NULL, 1, '2022-10-03 12:21:33'),
(1457, 'P-TRAP 4\" (FLAT)', 1, 22, '150.0000', '145.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:25'),
(1458, 'P-TRAP 4\" (FULL)', 1, 22, '150.0000', '180.00', '0.00', '45', 0, 1, '2022-10-11 12:14:57'),
(1459, 'P-TRAP 4\" (FULL)', 1, 22, '150.0000', '145.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:25'),
(1460, 'P-TRAP 3\" (MEDIUM)', 1, 22, '360.0000', '120.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:25'),
(1461, 'P-TRAP 3\" (MEDIUM)', 1, 22, '360.0000', '95.00', '0.00', '49', 0, 1, '2022-10-11 12:14:57'),
(1462, 'P-TRAP (TEDI)', 1, 22, '84.0000', '70.00', '0.00', '0', 0, 1, '2022-10-03 06:44:44'),
(1463, 'SAFETY VALVE 1\" RBS', 1, 4, '25.0000', '275.00', '0.00', '35', NULL, 1, '2022-10-01 14:24:25'),
(1464, 'SAFETY VALVE 1\" NBS', 1, 4, '0.0000', '260.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:25'),
(1465, 'SAFETY VALVE 1\" (SPECIAL) RBS', 1, 4, '0.0000', '530.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:25'),
(1466, 'SAFETY VALVE 3/4\" RBS', 1, 4, '25.0000', '250.00', '0.00', '42', NULL, 1, '2022-10-05 12:20:09'),
(1467, 'SAME VALVE (PVC) 1\"', 1, 4, '50.0000', '115.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:25'),
(1468, 'SAME VALVE (PVC) 1.25\"', 1, 4, '12.0000', '130.00', '0.00', '26', NULL, 1, '2022-10-01 14:24:25'),
(1469, 'SAME VALVE (PVC) 2\"', 1, 4, '12.0000', '435.00', '0.00', '14', NULL, 1, '2022-10-01 14:24:25'),
(1470, 'SAME VALVE (PVC)3/4\"', 1, 4, '50.0000', '115.00', '0.00', '34', NULL, 1, '2022-10-01 14:24:25'),
(1471, 'SENSOR BASIN MIXTURE CHINA', 1, 5, '2.0000', '4480.00', '0.00', '6', NULL, 1, '2022-10-01 14:24:25'),
(1472, 'SHAM', 1, 5, '0.0000', '325.00', '0.00', '50', NULL, 1, '2022-10-01 14:24:26'),
(1473, 'SHOWER NECK (CP)', 1, 5, '25.0000', '290.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:26'),
(1474, 'SHOWER ROD (BRASS BUSH) COLOR', 1, 5, '100.0000', '70.00', '0.00', '232', NULL, 1, '2022-10-08 10:41:58'),
(1475, 'SHOWER ROD (CP) ILMAS', 1, 5, '0.0000', '670.00', '0.00', '20', NULL, 1, '2022-10-01 14:24:26'),
(1476, 'SHOWER ROD (CP) CHINA', 1, 5, '0.0000', '150.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:26'),
(1477, 'SHOWER ROD (CP) TAPSUN', 1, 5, '50.0000', '190.00', '0.00', '64', NULL, 1, '2022-10-01 14:24:26'),
(1478, 'SHOWER ROD (PLASTIC COLOR)', 1, 5, '120.0000', '27.00', '0.00', '1114', NULL, 1, '2022-10-01 14:24:26'),
(1479, 'SIDE PILLAR COCK NEELAM', 1, 5, '12.0000', '1030.00', '0.00', '42', NULL, 1, '2022-10-01 14:24:26'),
(1480, 'SIDE PILLAR COCK VIVA', 1, 5, '0.0000', '1400.00', '0.00', '57', NULL, 1, '2022-10-01 14:24:26'),
(1481, 'SIDE PILLAR COCK MASTER', 1, 5, '24.0000', '830.00', '0.00', '23', NULL, 1, '2022-10-01 14:24:26'),
(1482, 'SIDE PILLAR COCK S. ASIA', 1, 5, '12.0000', '640.00', '0.00', '21', NULL, 1, '2022-10-01 14:24:26'),
(1483, 'SIDE PILLAR COCK POWER', 1, 5, '0.0000', '1020.00', '0.00', '28', NULL, 1, '2022-10-01 14:24:26'),
(1484, 'SIDE PILLAR COCK P. ASIA', 1, 5, '0.0000', '910.00', '0.00', '9', NULL, 1, '2022-10-01 14:24:26'),
(1485, 'SIDE PILLAR COCK (COLOR) PEAK', 1, 5, '0.0000', '240.00', '0.00', '71', NULL, 1, '2022-10-08 10:41:58'),
(1486, 'SIDE PILLAR COCK (COLOR) PARAGON', 1, 5, '0.0000', '415.00', '0.00', '104', NULL, 1, '2022-10-08 06:17:06'),
(1487, 'SIDE PILLAR COCK (COLOR) TEHZEEB', 1, 5, '100.0000', '310.00', '0.00', '381', 0, 1, '2022-10-06 11:24:19'),
(1488, 'SIDE PILLAR COCK (COLOR) UROOJ', 1, 5, '0.0000', '195.00', '0.00', '0', NULL, 1, '2022-10-08 10:41:58'),
(1489, 'SIDE PILLAR COCK (CP) PEAK', 1, 5, '12.0000', '240.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:26'),
(1490, 'SINGLE BATH SET COLOR (PARAGON)', 1, 11, '50.0000', '2100.00', '0.00', '7', 0, 1, '2022-10-06 06:29:39'),
(1491, 'SINGLE CHAND SARI (BRASS)', 1, 14, '50.0000', '45.00', '0.00', '75', NULL, 1, '2022-10-01 14:24:26'),
(1492, 'SINGLE MUSLIM SHOWER MORNING (COLOR)', 1, 12, '300.0000', '190.00', '0.00', '636', NULL, 1, '2022-10-01 14:24:27'),
(1493, 'SINGLE MUSLIM SHOWER PEAK (COLOR)', 1, 12, '300.0000', '130.00', '0.00', '67', NULL, 1, '2022-10-08 10:41:58'),
(1494, 'SINGLE MUSLIM SHOWER TAPSUN (BRASS)', 1, 12, '20.0000', '540.00', '0.00', '62', NULL, 1, '2022-10-01 14:24:27'),
(1495, 'SINGLE MUSLIM SHOWER TAPSUN (COLOR)', 1, 12, '0.0000', '96.00', '0.00', '408', NULL, 1, '2022-10-08 10:41:58'),
(1496, 'SINGLE MUSLIM SHOWER VITAL (COLOR)', 1, 12, '0.0000', '90.00', '0.00', '10', NULL, 1, '2022-10-08 10:41:58'),
(1497, 'SINGLE MUSLIM SHOWER MORNING (CP)', 1, 12, '50.0000', '300.00', '0.00', '123', NULL, 1, '2022-10-01 14:24:27'),
(1498, 'SINGLE MUSLIM SHOWER PEAK (CP)', 1, 12, '50.0000', '180.00', '0.00', '143', NULL, 1, '2022-10-06 11:24:19'),
(1499, 'SINGLE MUSLIM SHOWER UNIQUE (CP)', 1, 12, '0.0000', '120.00', '0.00', '58', NULL, 1, '2022-10-01 14:24:27'),
(1500, 'SINK BOWL 15\"x30\" AFZAL', 1, 15, '0.0000', '1020.00', '0.00', '1', NULL, 1, '2022-10-11 12:06:48'),
(1501, 'SINK BOWL 18\"x22\" SIRONA', 1, 15, '0.0000', '1620.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:27'),
(1502, 'SINK BOWL (BLUE PATTI) 13\"x16\"', 1, 15, '0.0000', '890.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:27'),
(1503, 'SINK BOWL (MACHINE MADE) 50\"x40\"', 1, 15, '5.0000', '2220.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:27'),
(1504, 'SINK BOWL (MACHINE MADE) 58\"x43\"', 1, 15, '5.0000', '2700.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:27'),
(1505, 'SINK BOWL (MACHINE MADE)) 60\"x45\"', 1, 15, '5.0000', '2940.00', '0.00', '5', NULL, 1, '2022-10-01 14:24:27'),
(1506, 'SINK BOWL (MACHINE MADE) 68\"x45\"', 1, 15, '5.0000', '3780.00', '0.00', '20', NULL, 1, '2022-10-01 14:24:27'),
(1507, 'SINK BOWL (MACHINE MADE) 75\"x40\"', 1, 15, '5.0000', '4440.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:27'),
(1508, 'SINK BOWL (MACHINE MADE) 81\"x43\"', 1, 15, '5.0000', '5160.00', '0.00', '6', NULL, 1, '2022-10-01 14:24:27'),
(1509, 'SINK BOWL (GREEN PATTI) 13\"x16\"', 1, 15, '10.0000', '770.00', '0.00', '22', NULL, 1, '2022-10-01 14:24:28'),
(1510, 'SINK BOWL (GREEN PATTI) 14\"x17\"', 1, 15, '10.0000', '1320.00', '0.00', '21', NULL, 1, '2022-10-08 10:41:58'),
(1511, 'SINK COCK NEELAM', 1, 5, '10.0000', '1030.00', '0.00', '35', NULL, 1, '2022-10-01 14:24:28'),
(1512, 'SINK COCK VIVA', 1, 5, '0.0000', '1400.00', '0.00', '38', NULL, 1, '2022-10-01 14:24:28'),
(1513, 'SINK COCK MASTER', 1, 5, '20.0000', '830.00', '0.00', '27', NULL, 1, '2022-10-01 14:24:28'),
(1514, 'SINK COCK S. ASIA', 1, 5, '10.0000', '640.00', '0.00', '26', NULL, 1, '2022-10-08 07:24:28'),
(1515, 'SINK COCK POWER', 1, 5, '0.0000', '1020.00', '0.00', '20', NULL, 1, '2022-10-01 14:24:28'),
(1516, 'SINK COCK P. ASIA', 1, 5, '0.0000', '910.00', '0.00', '15', NULL, 1, '2022-10-01 14:24:28'),
(1517, 'SINK COCK ASIA MIX', 1, 5, '0.0000', '620.00', '0.00', '5', NULL, 1, '2022-09-26 10:05:32'),
(1518, 'SINK COCK (COLOR) PEAK', 1, 5, '0.0000', '240.00', '0.00', '28', NULL, 1, '2022-10-08 10:41:58'),
(1519, 'SINK COCK (COLOR) PARAGON', 1, 5, '0.0000', '430.00', '0.00', '56', NULL, 1, '2022-10-01 14:24:28'),
(1520, 'SINK COCK (COLOR) TEHZEEB', 1, 5, '100.0000', '310.00', '0.00', '239', 0, 1, '2022-10-04 11:07:04'),
(1521, 'SINK COCK (CP) PEAK', 1, 5, '10.0000', '370.00', '0.00', '35', NULL, 1, '2022-10-01 14:24:28'),
(1522, 'SINK MIXTURE NEELAM', 1, 5, '10.0000', '1780.00', '0.00', '23', NULL, 1, '2022-10-01 14:24:28'),
(1523, 'SINK MIXTURE VIVA', 1, 5, '0.0000', '1700.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:28'),
(1524, 'SINK MIXTURE MASTER', 1, 5, '10.0000', '1320.00', '0.00', '27', NULL, 1, '2022-10-05 12:30:17'),
(1525, 'SINK MIXTURE S. ASIA', 1, 5, '6.0000', '1080.00', '0.00', '14', NULL, 1, '2022-10-01 14:24:28'),
(1526, 'SINK MIXTURE WONDER', 1, 5, '0.0000', '1300.00', '0.00', '5', 0, 1, '2022-10-06 07:16:43'),
(1527, 'SINK MIXTURE TAPSUN', 1, 5, '0.0000', '3000.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:29'),
(1528, 'SINK MIXTURE FAUCET', 1, 5, '4.0000', '2170.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:29'),
(1529, 'SINK MIXTURE HIGH END', 1, 5, '4.0000', '2170.00', '0.00', '2', NULL, 1, '2022-10-01 14:24:29'),
(1530, 'SINK MIXTURE (COLOR) PEAK', 1, 5, '0.0000', '660.00', '0.00', '155', NULL, 1, '2022-10-06 11:24:19'),
(1531, 'SINK MIXTURE (COLOR) PARAGON', 1, 5, '0.0000', '900.00', '0.00', '63', NULL, 1, '2022-10-10 09:22:38'),
(1532, 'SINK MIXTURE (COLOR) TEHZEEB', 1, 5, '50.0000', '770.00', '0.00', '169', 0, 1, '2022-10-02 08:34:42'),
(1533, 'SINK MIXTURE (CP) PEAK', 1, 5, '0.0000', '870.00', '0.00', '4', NULL, 1, '2022-10-06 11:24:19'),
(1534, 'SOAP DISH (CHORUS)', 1, 1, '24.0000', '110.00', '0.00', '55', NULL, 1, '2022-10-01 14:24:29'),
(1535, 'SOAP DISH (CHORUS)', 1, 1, '24.0000', '110.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:29'),
(1536, 'SOAP DISH (GOL)', 1, 1, '0.0000', '105.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:29'),
(1537, 'SOLUTION (50 GRAM)', 1, 6, '60.0000', '20.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:29'),
(1538, 'SPANDLE (2 IN 1)', 1, 17, '200.0000', '105.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:29'),
(1539, 'SPANDLE SCREW (BRASS)', 3, 17, '20.0000', '320.00', '0.00', '80', NULL, 1, '2022-10-01 14:24:29'),
(1540, 'SPANDLE (INDUS GROUP)', 1, 17, '200.0000', '105.00', '0.00', '41', NULL, 1, '2022-10-06 11:05:55'),
(1541, 'SPANDLE (LAMBAY/CONSEALED)', 1, 17, '100.0000', '120.00', '0.00', '87', NULL, 1, '2022-10-10 09:24:20'),
(1542, 'SPANDLE (MIX)', 1, 17, '0.0000', '145.00', '0.00', '164', NULL, 1, '2022-10-01 14:24:29'),
(1543, 'SPANDLE VALVE/GOTI (NO:3)', 1, 17, '100.0000', '28.00', '0.00', '351', NULL, 1, '2022-10-01 14:24:30'),
(1544, 'SPANDLE VALVE/GOTI (NO:4)', 1, 17, '100.0000', '32.00', '0.00', '408', NULL, 1, '2022-10-01 14:24:30'),
(1545, 'SPANDLE VALVE/GOTI (NO:5)', 1, 17, '100.0000', '35.00', '0.00', '604', NULL, 1, '2022-10-01 14:24:30'),
(1546, 'SPANDLE VALVE/GOTI (NO:6)', 1, 17, '100.0000', '39.00', '0.00', '628', NULL, 1, '2022-10-01 14:24:30'),
(1547, 'SPANDLE VALVE/GOTI (NO:7)', 1, 17, '100.0000', '42.00', '0.00', '149', NULL, 1, '2022-10-01 14:24:30'),
(1548, 'STEEL JALI GOL 3\" (SS)', 2, 1, '6.0000', '120.00', '0.00', '18', NULL, 1, '2022-10-01 14:24:30'),
(1549, 'STEEL JALI GOL 4\" (MS)', 2, 1, '10.0000', '130.00', '0.00', '32', NULL, 1, '2022-10-06 11:05:55'),
(1550, 'STEEL JALI GOL 4\" (SS)', 2, 1, '10.0000', '240.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:30'),
(1551, 'STEEL JALI GOL 4\" HOLE (MS)', 2, 1, '10.0000', '130.00', '0.00', '47', NULL, 1, '2022-10-01 14:24:30'),
(1552, 'STEEL JALI GOL 4\" HOLE (SS)', 2, 1, '10.0000', '240.00', '0.00', '11', NULL, 1, '2022-10-01 14:24:30'),
(1553, 'STEEL JALI GOL 5\" (MS)', 2, 1, '10.0000', '160.00', '0.00', '17', NULL, 1, '2022-10-06 11:05:55');
INSERT INTO `items` (`id`, `title`, `unit_id`, `item_category_id`, `alert_quantity`, `unit_price`, `sale_price`, `quantity`, `sortorder`, `status`, `ts`) VALUES
(1554, 'STEEL JALI GOL 5\" (SS)', 2, 1, '10.0000', '280.00', '0.00', '11', NULL, 1, '2022-10-01 14:24:30'),
(1555, 'STEEL JALI GOL 5\" HOLE (MS)', 2, 1, '10.0000', '225.00', '0.00', '18', NULL, 1, '2022-10-01 14:24:30'),
(1556, 'STEEL JALI GOL 5\" HOLE (SS)', 2, 1, '10.0000', '280.00', '0.00', '21', NULL, 1, '2022-10-01 14:24:30'),
(1557, 'STEEL JALI GOL 6\" (MS)', 2, 1, '10.0000', '375.00', '0.00', '35', NULL, 1, '2022-10-05 12:30:17'),
(1558, 'STEEL JALI GOL 6\" (SS)', 2, 1, '10.0000', '525.00', '0.00', '18', NULL, 1, '2022-10-01 14:24:30'),
(1559, 'STEEL JALI GOL 6\" HOLE (MS)', 2, 1, '10.0000', '235.00', '0.00', '19', NULL, 1, '2022-10-01 14:24:30'),
(1560, 'STEEL JALI GOL 6\" HOLE (SS)', 2, 1, '10.0000', '280.00', '0.00', '4', NULL, 1, '2022-10-01 14:24:30'),
(1561, 'STEEL SHELF', 1, 1, '6.0000', '250.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:30'),
(1562, 'STOP COCK NEELAM', 1, 5, '10.0000', '550.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:30'),
(1563, 'STOP COCK VIVA', 1, 5, '0.0000', '530.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:31'),
(1564, 'STOP COCK MASTER', 1, 5, '10.0000', '450.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:31'),
(1565, 'STOP COCK P. ASIA', 1, 5, '0.0000', '450.00', '0.00', '3', NULL, 1, '2022-10-01 14:24:31'),
(1566, 'STOP COCK 1/2\" S. ASIA', 1, 5, '12.0000', '395.00', '0.00', '60', 0, 1, '2022-10-06 06:38:59'),
(1567, 'STOP COCK 3/4\" S.ASIA', 1, 5, '12.0000', '420.00', '0.00', '24', NULL, 1, '2022-10-01 14:24:31'),
(1568, 'SUPER JET SHOWER CHORUS (COLOR)', 1, 12, '100.0000', '110.00', '0.00', '93', NULL, 1, '2022-10-01 14:24:31'),
(1569, 'T-ARM (CP) 12\"', 1, 5, '10.0000', '300.00', '0.00', '19', NULL, 1, '2022-10-01 14:24:31'),
(1570, 'T-ARM (CP) 18\"', 1, 5, '10.0000', '440.00', '0.00', '22', NULL, 1, '2022-10-01 14:24:31'),
(1571, 'T-ARM (CP) 8\"', 1, 5, '10.0000', '265.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:31'),
(1572, 'T-COCK ILMAS', 1, 5, '0.0000', '850.00', '0.00', '24', NULL, 1, '2022-10-01 14:24:31'),
(1573, 'T-COCK NEELAM', 1, 5, '25.0000', '550.00', '0.00', '45', NULL, 1, '2022-10-01 14:24:31'),
(1574, 'T-COCK VIVA', 1, 5, '0.0000', '530.00', '0.00', '102', NULL, 1, '2022-10-01 14:24:31'),
(1575, 'T-COCK MASTER', 1, 5, '36.0000', '450.00', '0.00', '122', NULL, 1, '2022-10-03 12:21:33'),
(1576, 'T-COCK S. ASIA', 1, 5, '24.0000', '395.00', '0.00', '168', NULL, 1, '2022-10-06 11:24:19'),
(1577, 'T-COCK P. ASIA', 1, 5, '0.0000', '450.00', '0.00', '39', NULL, 1, '2022-10-01 14:24:31'),
(1578, 'T-COCK CROWN', 1, 5, '0.0000', '450.00', '0.00', '40', NULL, 1, '2022-10-01 14:24:31'),
(1579, 'T-COCK UMAR SAGA', 1, 5, '0.0000', '490.00', '0.00', '38', NULL, 1, '2022-10-01 14:24:31'),
(1580, 'T-COCK (COLOR) PEAK', 1, 5, '0.0000', '140.00', '0.00', '212', NULL, 1, '2022-10-06 11:24:19'),
(1581, 'T-COCK (COLOR) PARAGON', 1, 5, '0.0000', '190.00', '0.00', '394', NULL, 1, '2022-10-05 12:32:02'),
(1582, 'T-COCK (COLOR) TEHZEEB', 1, 5, '100.0000', '160.00', '0.00', '596', 0, 1, '2022-10-03 12:15:00'),
(1583, 'T-COCK (COLOR) UROOJ', 1, 5, '0.0000', '125.00', '0.00', '0', NULL, 1, '2022-10-08 10:41:58'),
(1584, 'T-COCK (COLOR) SIRONA', 1, 5, '0.0000', '160.00', '0.00', '60', NULL, 1, '2022-10-01 14:24:31'),
(1585, 'T-COCK (CP) PEAK', 1, 5, '20.0000', '165.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:31'),
(1586, 'T-SAFETY VALVE 1\"', 1, 4, '15.0000', '480.00', '0.00', '9', NULL, 1, '2022-10-05 12:20:09'),
(1587, 'TAFLON TAPE (COLOR)', 1, 6, '1000.0000', '18.00', '0.00', '1480', NULL, 1, '2022-10-04 11:21:03'),
(1588, 'TAFLON TAPE (YELLOW)', 1, 6, '500.0000', '11.00', '0.00', '5473', NULL, 1, '2022-10-10 06:44:41'),
(1589, 'TANKI BUSH 1/2\"x3/4\" (BHARI)', 1, 23, '50.0000', '80.00', '0.00', '125', NULL, 1, '2022-10-04 11:02:11'),
(1590, 'TANKI BUSH 1/2\"x3/4\" (AAM)', 1, 23, '100.0000', '55.00', '0.00', '182', NULL, 1, '2022-10-04 11:02:11'),
(1591, 'TANKI BUSH 3/4\"x1\" (BHARI)', 1, 23, '50.0000', '105.00', '0.00', '222', NULL, 1, '2022-10-01 14:24:31'),
(1592, 'TANKI BUSH 3/4\"x1\" (AAM)', 1, 23, '100.0000', '80.00', '0.00', '208', NULL, 1, '2022-10-04 11:02:11'),
(1593, 'THUMBLE (PVC) UNIQUE', 1, 2, '50.0000', '350.00', '0.00', '46', NULL, 1, '2022-10-01 14:24:32'),
(1594, 'THUMBLE (PVC AAM) STEEL-X', 1, 2, '50.0000', '75.00', '0.00', '44', NULL, 1, '2022-10-06 09:35:50'),
(1595, 'TISSUE HOLDER (CP)', 1, 1, '20.0000', '160.00', '0.00', '23', NULL, 1, '2022-10-01 14:24:32'),
(1596, 'TOTI 2.5 NO (CROME)', 1, 5, '50.0000', '230.00', '0.00', '103', NULL, 1, '2022-10-01 14:24:32'),
(1597, 'TOTI 2.5 NO (GOLDEN)', 1, 5, '100.0000', '190.00', '0.00', '297', NULL, 1, '2022-10-01 14:24:32'),
(1598, 'TOTI 3 NO (CROME)', 1, 5, '25.0000', '290.00', '0.00', '72', NULL, 1, '2022-10-01 14:24:32'),
(1599, 'TOTI 3 NO (GOLDEN)', 1, 5, '50.0000', '280.00', '0.00', '304', NULL, 1, '2022-10-01 14:24:32'),
(1600, 'TOTI (CHINA HEAD)', 1, 5, '100.0000', '110.00', '0.00', '12', NULL, 1, '2022-10-01 14:24:32'),
(1601, 'TOTI (PLASTIC) TAJ', 1, 5, '120.0000', '200.00', '0.00', '80', NULL, 1, '2022-10-01 14:24:32'),
(1602, 'TOTI (PLASTIC) ABT', 1, 5, '100.0000', '23.00', '0.00', '188', NULL, 1, '2022-10-01 14:24:32'),
(1603, 'TOWEL RING (CP)', 1, 1, '10.0000', '200.00', '0.00', '15', NULL, 1, '2022-10-01 14:24:32'),
(1604, 'TOWEL ROD (CP)', 1, 1, '10.0000', '190.00', '0.00', '30', NULL, 1, '2022-10-01 14:24:32'),
(1605, 'U NECK (BARI)', 1, 5, '50.0000', '230.00', '0.00', '137', NULL, 1, '2022-10-06 11:05:55'),
(1606, 'U NECK (CHOTI)', 1, 5, '50.0000', '170.00', '0.00', '158', NULL, 1, '2022-10-05 12:20:09'),
(1607, 'U NECK (DERMIANI)', 1, 5, '50.0000', '195.00', '0.00', '78', NULL, 1, '2022-10-01 14:24:32'),
(1608, 'UNDER GROUND 1/2\"', 1, 5, '12.0000', '780.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:32'),
(1609, 'UNDER GROUND 3/4\" MASTER', 1, 5, '10.0000', '780.00', '0.00', '42', NULL, 1, '2022-10-01 14:24:32'),
(1610, 'UNION CHECK VALVE', 1, 4, '0.0000', '1700.00', '0.00', '7', NULL, 1, '2022-10-01 14:24:32'),
(1611, 'UNION CHECK VALVE 25 MM', 1, 4, '0.0000', '950.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:32'),
(1612, 'UNION CHECK VALVE 32 MM', 1, 4, '0.0000', '950.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:32'),
(1613, 'VANITY MIXTURE (CP LONG)', 1, 5, '4.0000', '1800.00', '0.00', '9', NULL, 1, '2022-10-01 14:24:32'),
(1614, 'VANITY MIXTURE (PULL OUT)', 1, 5, '4.0000', '2400.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:32'),
(1615, 'VANITY MIXTURE (SUS304)', 1, 5, '4.0000', '1820.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:32'),
(1616, 'FLOOR WASTE VIP/SAMEER (COLOR)', 1, 1, '0.0000', '72.00', '0.00', '439', NULL, 1, '2022-10-01 14:24:32'),
(1617, 'WALL SHOWER LEG', 1, 5, '6.0000', '290.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:32'),
(1618, 'WALL SHOWER ROD 4 FOOT (COLOR AAM)', 1, 24, '70.0000', '240.00', '0.00', '176', NULL, 1, '2022-10-01 14:24:32'),
(1619, 'WALL SHOWER ROD 5 FOOT (COLOR BHARI)', 1, 24, '50.0000', '300.00', '0.00', '69', NULL, 1, '2022-10-01 14:24:32'),
(1620, 'WALL SHOWER ROD 4 FOOT (CP AAM)', 1, 24, '10.0000', '160.00', '0.00', '47', NULL, 1, '2022-10-01 14:24:32'),
(1621, 'WALL SHOWER ROD 4 FOOT (CP BHARI)', 1, 24, '10.0000', '220.00', '0.00', '74', NULL, 1, '2022-10-01 14:24:32'),
(1622, 'WALL SHOWER ROD 5 FOOT (CP AAM)', 1, 24, '10.0000', '220.00', '0.00', '28', NULL, 1, '2022-10-01 14:24:33'),
(1623, 'WALL SHOWER ROD 5 FOOT (CP BHARI)', 1, 24, '10.0000', '260.00', '0.00', '33', NULL, 1, '2022-10-01 14:24:33'),
(1624, 'WASHER (GODAY)', 6, 8, '10.0000', '110.00', '0.00', '46', NULL, 1, '2022-10-01 14:24:33'),
(1625, 'WASHER (NYLON CONNECTION)', 6, 8, '20.0000', '60.00', '0.00', '132', NULL, 1, '2022-10-10 11:19:46'),
(1626, 'WASHER (SINK MIXTURE)', 6, 8, '10.0000', '110.00', '0.00', '362', NULL, 1, '2022-10-01 14:24:33'),
(1627, 'WASTE (CROME BRASS)', 1, 25, '10.0000', '235.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:33'),
(1628, 'WASTE (GOLDEN BRASS)', 1, 25, '10.0000', '265.00', '0.00', '36', NULL, 1, '2022-10-01 14:24:33'),
(1629, 'WASTE PIPE (CP)', 1, 19, '25.0000', '140.00', '0.00', '119', NULL, 1, '2022-10-01 14:24:33'),
(1630, 'WASTE PIPE (GREY) AAM', 1, 19, '100.0000', '63.00', '0.00', '46', NULL, 1, '2022-10-06 09:42:08'),
(1631, 'WASTE PIPE (GREY) BHARI', 1, 19, '100.0000', '76.00', '0.00', '209', NULL, 1, '2022-10-06 09:35:50'),
(1632, 'WASTE PIPE (WHITE) MANAV', 1, 19, '100.0000', '71.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:33'),
(1633, 'WASTE PIPE (GREY) WITHOUT WASTE', 1, 19, '100.0000', '39.00', '0.00', '320', NULL, 1, '2022-10-05 12:32:02'),
(1634, 'WASTE (PLASTIC)', 1, 25, '120.0000', '50.00', '0.00', '312', NULL, 1, '2022-10-06 09:42:08'),
(1635, 'COMPLETE BATH SET DIAMOND CP  (MASTER)', 1, 11, '4.0000', '5100.00', '0.00', '4', 0, 1, '2022-10-06 06:30:07'),
(1636, 'STEEL JALI GOOL 3\" (MS)', 2, 1, '5.0000', '120.00', '0.00', '0', NULL, 1, '2022-10-01 14:24:33'),
(1637, 'STEEL JALI GOL 3\"(MS)', 2, 1, '5.0000', '120.00', '0.00', '10', NULL, 1, '2022-10-01 14:24:33'),
(1638, 'SINK BOWL 14\"x17\" SUPREME AFZAL', 1, 15, NULL, '1375.00', '0.00', '1', NULL, 1, '2022-10-01 14:24:33'),
(1639, 'COLOR TUBE 24\" MORNING', 1, NULL, '0.0000', '162.50', '0.00', '0', NULL, 1, '2022-10-01 14:24:33'),
(1640, 'MAIN HOLE COVER (PVC) 15\"x15\" GOOD LUCK MASTER', 1, 21, '12.0000', '580.00', '0.00', '14', NULL, 1, '2022-10-10 09:34:44'),
(1641, 'SINGLE MUSLIM SHOWER TAPSUN (CP)', 1, 30, NULL, '162.50', '0.00', '1', NULL, 1, '2022-10-01 14:24:33'),
(1642, 'COMPLETE MUSLIM SHOWER RSS (COLOR)', 1, 30, NULL, '512.50', '0.00', '3', NULL, 1, '2022-10-01 14:24:33'),
(1643, 'JET SHOWER CHORUS TESLA (COLOR)', 1, 30, NULL, '162.50', '0.00', '4', NULL, 1, '2022-10-01 14:24:33'),
(1644, 'FLOOR WASTE ICON (STEEL)', 1, 1, NULL, '206.25', '0.00', '49', NULL, 1, '2022-10-01 14:24:33'),
(1645, 'VANITY MIXTURE BLACK', 1, 5, '0.0000', '2600.00', '0.00', '1', 0, 1, '2022-10-03 07:39:43'),
(1646, 'VANITY MIXTURE CP CHORUS', 1, 5, '0.0000', '2600.00', '0.00', '4', 0, 1, '2022-10-03 07:35:30'),
(1647, 'VANITY MIXTURE NEW (BLACK)', 1, 5, '0.0000', '1400.00', '0.00', '1', 0, 1, '2022-10-03 07:36:22'),
(1648, 'DIVIDER PVC', 1, 5, '0.0000', '200.00', '0.00', '0', 0, 1, '2022-10-04 09:21:42'),
(1649, 'COMPLETE BATH SET CHORUS CP (MASTER)', 1, 11, '4.0000', '5300.00', '0.00', '8', 0, 1, '2022-10-06 06:30:38'),
(1650, 'COMPLETE BATH SET GROHI CP (MASTER)', 1, 11, '4.0000', '5300.00', '0.00', '3', 0, 1, '2022-10-06 06:31:11'),
(1651, 'COMPLETE BATH SET MOON CP (MASTER)', 1, 11, '4.0000', '5300.00', '0.00', '5', 0, 1, '2022-10-06 06:31:31'),
(1652, 'COMPLETE BATH SET ROSE CP (MASTER)', 1, 11, '4.0000', '5300.00', '0.00', '1', 0, 1, '2022-10-06 06:31:49'),
(1653, 'COMPLETE BATH SET PROJECT CP (MASTER)', 1, 11, '4.0000', '5300.00', '0.00', '0', 0, 1, '2022-10-06 06:32:12'),
(1654, 'STOP COCK 3/4\" S. ASIA', 1, 5, '12.0000', '330.00', '0.00', '24', 0, 1, '2022-10-06 06:40:01'),
(1655, 'BASIN MIXTURE UMAR SAGA', 1, 5, '0.0000', '800.00', '0.00', '1', 0, 1, '2022-10-06 06:42:24'),
(1656, 'SINK COCK UROOJ', 1, 5, '0.0000', '155.00', '0.00', '10', 0, 1, '2022-10-08 10:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `title`, `status`, `ts`) VALUES
(1, 'BATH/KITCHEN ACCESSORIES', 1, '2022-09-23 08:36:37'),
(2, 'COMMODE ACCESSORIES', 1, '2022-09-23 08:36:37'),
(3, 'LOCKS & COCKS', 1, '2022-09-23 08:36:37'),
(4, 'VALVES', 1, '2022-09-23 08:36:37'),
(5, 'FITTINGS', 1, '2022-09-23 08:36:37'),
(6, 'TAPE & SOLUTION', 1, '2022-09-23 08:36:37'),
(7, 'BOLT KIT', 1, '2022-09-23 08:36:37'),
(8, 'WASHER & CATCHER', 1, '2022-09-23 08:36:37'),
(9, 'NIPPLES', 1, '2022-09-23 08:36:37'),
(10, 'TUBES', 1, '2022-09-23 08:36:37'),
(11, 'BATH SET', 1, '2022-09-23 08:36:37'),
(12, 'SHOWER', 1, '2022-09-23 08:36:37'),
(13, 'CP PLATES', 1, '2022-09-23 08:36:37'),
(14, 'NUTS', 1, '2022-09-23 08:36:37'),
(15, 'BOWLS', 1, '2022-09-23 08:36:37'),
(16, 'CLIPS & HOOKS', 1, '2022-09-23 08:36:37'),
(17, 'GODAY & SPADLES', 1, '2022-09-23 08:36:37'),
(18, 'HEADS', 1, '2022-09-23 08:36:37'),
(19, 'PIPES', 1, '2022-09-23 08:36:37'),
(20, 'INJECTORS', 1, '2022-09-23 08:36:37'),
(21, 'COVERS', 1, '2022-09-23 08:36:37'),
(22, 'P-TRAPS', 1, '2022-09-23 08:36:37'),
(23, 'BUSH', 1, '2022-09-23 08:36:37'),
(24, 'RODS', 1, '2022-09-23 08:36:37'),
(25, 'WASTE', 1, '2022-09-23 08:36:37'),
(26, 'PVC', 1, '2022-09-23 08:36:37'),
(27, 'BRASS', 1, '2022-09-23 08:36:37'),
(28, 'CP', 1, '2022-09-23 08:36:37'),
(29, 'TANKS', 1, '2022-09-23 08:36:37'),
(30, 'SHOWERS', 1, '2022-09-23 08:36:37');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `sortorder` int(11) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `small_icon` varchar(200) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `url`, `parent_id`, `depth`, `sortorder`, `icon`, `small_icon`) VALUES
(1, 'Dashboard', '#', 0, 0, 1, 'dashboard.png', 'home'),
(18, 'Manage Purchases', 'purchase_manage.php', 15, 1, 9, 'manage-purchases.png', 'truck'),
(17, 'Manage Supplier', 'supplier_manage.php', 15, 1, 10, 'manage-supplier.jpg', 'users'),
(19, 'Sales', '#', 0, 0, 12, 'sales.jpg', 'print'),
(20, ' Manage Customer', 'customer_manage.php', 19, 1, 14, 'manage-customer.jpg', 'street-view'),
(8, 'Administrator', 'admin_manage.php', 1, 1, 3, 'administrator.png', 'user'),
(7, 'General Settings', 'config_manage.php?config_id=1', 1, 1, 2, 'general-settings.png', 'adjust'),
(15, 'Inventory', '#', 0, 0, 8, 'inventory.jpg', 'glass'),
(16, 'Manage Sales', 'sales_manage.php', 19, 1, 13, 'manage-sales.png', 'shopping-cart'),
(33, 'Manage Items', 'items_manage.php', 27, 1, 22, 'manage-items.png', 'repeat'),
(32, 'Customer Payment', 'customer_payment_manage.php', 19, 1, 22, 'customer-payment.png', 'cc-mastercard'),
(21, 'Supplier Payment', 'supplier_payment_manage.php', 15, 1, 11, 'supplier-payment.png', 'money'),
(22, 'Reports', '#', 0, 0, 15, 'reports.png', 'list-alt'),
(23, 'Balance Sheet', 'report_manage.php?tab=balance_sheet', 22, 1, 16, 'balance-sheet.png', 'file-o'),
(24, 'Item Category', 'item_category_manage.php', 27, 1, 6, 'item-category.png', 'renren'),
(25, 'Manage Expense', 'expense_manage.php', 28, 1, 17, 'manage-expense.png', 'money'),
(26, 'Admin Type', 'admin_type_manage.php', 1, 1, 4, 'admin-type.jpg', 'unlock'),
(27, 'Items', '#', 0, 0, 5, 'items.jpg', 'cogs'),
(28, 'Accounts', '#', 0, 0, 19, 'accounts.jpg', 'industry'),
(29, 'Expense Category', 'expense_category_manage.php', 28, 1, 20, 'expense-category.jpg', 'cog'),
(30, 'Manage Account', 'account_manage.php', 28, 1, 21, 'manage-account.jpg', 'glass'),
(31, 'Manage Transaction', 'transaction_manage.php', 28, 1, 22, 'manage-transaction.jpg', 'cart-plus'),
(36, 'Sales Report', 'report_manage.php?tab=sales', 22, 1, 25, 'sales-report.jpg', 'inbox'),
(37, 'General Journal', 'report_manage.php?tab=general_journal', 22, 1, 26, 'general-journal.jpg', 'road'),
(39, 'Stock Report', 'stock_manage.php', 22, 1, 28, 'stock-report.jpg', 'th-list'),
(41, 'Income Report', 'report_manage.php?tab=income', 22, 1, 29, 'income-report.jpg', 'check'),
(42, 'Units', 'unit_manage.php', 27, 1, 27, 'units.gif', 'th-list');

-- --------------------------------------------------------

--
-- Table structure for table `menu_2_admin_type`
--

CREATE TABLE `menu_2_admin_type` (
  `menu_id` int(11) NOT NULL,
  `admin_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_2_admin_type`
--

INSERT INTO `menu_2_admin_type` (`menu_id`, `admin_type_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(4, 3),
(4, 4),
(5, 1),
(5, 3),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(12, 1),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(17, 1),
(17, 3),
(18, 1),
(18, 3),
(19, 1),
(20, 1),
(21, 1),
(21, 3),
(22, 1),
(23, 1),
(24, 1),
(24, 3),
(25, 1),
(26, 1),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(36, 1),
(36, 3),
(37, 1),
(37, 3),
(38, 1),
(38, 3),
(39, 1),
(39, 3),
(40, 1),
(40, 3),
(41, 1),
(41, 3),
(42, 1),
(42, 3);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `total_items` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `net_price` decimal(10,2) NOT NULL,
  `notes` text,
  `added_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `datetime_added`, `supplier_id`, `total_items`, `total_price`, `discount`, `net_price`, `notes`, `added_by`, `status`, `ts`) VALUES
(1, '2022-10-01 15:58:00', 2, 198, '67400.00', '0.00', '67400.00', 'Bill # 2124\n05-10-2022 New Sitara Goods\n5 Bundle Main Hole Cover 2 Torey\n1970+490=2460', 1, 1, '2022-10-10 11:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `item_id` varchar(100) DEFAULT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` float NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `quantity_sold` int(11) DEFAULT NULL,
  `is_return` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `item_category_id`, `item_id`, `purchase_price`, `sale_price`, `quantity`, `total`, `quantity_sold`, `is_return`) VALUES
(4, 1, NULL, '1422', '220.00', '270.00', 50, '11000.00', NULL, 0),
(5, 1, NULL, '1426', '600.00', '750.00', 24, '14400.00', NULL, 0),
(6, 1, NULL, '1428', '1500.00', '1875.00', 24, '36000.00', NULL, 0),
(7, 1, NULL, '1625', '60.00', '75.00', 100, '6000.00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_items` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `net_price` decimal(10,2) NOT NULL,
  `customer_payment_id` int(11) DEFAULT NULL,
  `notes` text,
  `shipping_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `added_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `datetime_added`, `customer_id`, `total_items`, `total_price`, `discount`, `net_price`, `customer_payment_id`, `notes`, `shipping_charges`, `added_by`, `status`, `ts`) VALUES
(1, '2022-10-01 12:11:00', 97, 6, '4200.00', '0.00', '4200.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 07:16:09'),
(2, '2022-10-01 12:37:00', 68, 73, '9300.00', '0.00', '9300.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 07:39:43'),
(3, '2022-10-02 12:48:00', 46, 8, '7030.00', '0.00', '7030.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 07:51:24'),
(4, '2022-10-02 13:48:00', 64, 208, '48780.00', '0.00', '48780.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 08:55:53'),
(5, '2022-10-02 14:30:00', 97, 8, '2080.00', '0.00', '2080.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 09:37:12'),
(6, '2022-10-03 14:41:00', 46, 1, '2200.00', '0.00', '2200.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 09:42:31'),
(7, '2022-10-03 16:52:00', 101, 3, '13950.00', '0.00', '13950.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 11:55:15'),
(8, '2022-10-03 17:00:00', 100, 158, '52980.00', '0.00', '52980.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 12:03:12'),
(9, '2022-10-03 17:06:00', 136, 75, '21000.00', '0.00', '21000.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 12:07:07'),
(10, '2022-10-03 17:12:00', 66, 91, '28910.00', '0.00', '28910.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 12:15:00'),
(11, '2022-10-03 17:15:00', 82, 156, '39738.00', '0.00', '39738.00', NULL, NULL, '0.00', 1, 1, '2022-10-03 12:21:33'),
(12, '2022-10-04 14:21:00', 72, 1, '300.00', '0.00', '300.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 09:21:42'),
(13, '2022-10-04 15:41:00', 79, 53, '11044.00', '0.00', '11044.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 10:43:38'),
(14, '2022-10-04 15:45:00', 87, 340, '77662.00', '0.00', '77662.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 11:02:11'),
(15, '2022-10-04 16:02:00', 111, 44, '13612.00', '0.00', '13612.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 11:07:04'),
(16, '2022-10-04 16:09:00', 106, 10, '3400.00', '0.00', '3400.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 11:10:13'),
(17, '2022-10-04 16:10:00', 41, 37, '5470.00', '0.00', '5470.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 11:20:22'),
(18, '2022-10-04 16:20:00', 46, 100, '2300.00', '0.00', '2300.00', NULL, NULL, '0.00', 1, 1, '2022-10-04 11:21:03'),
(19, '2022-10-05 16:41:00', 122, 12, '1296.00', '0.00', '1296.00', NULL, 'Bill # 20/85', '0.00', 1, 1, '2022-10-05 11:44:10'),
(20, '2022-10-05 16:49:00', 111, 25, '3230.00', '0.00', '3230.00', NULL, 'Bill # 21/90', '0.00', 1, 1, '2022-10-05 11:51:53'),
(21, '2022-10-05 17:11:00', 85, 43, '15272.00', '0.00', '15272.00', NULL, 'Bill # 21/74', '0.00', 1, 1, '2022-10-05 12:20:09'),
(22, '2022-10-05 17:23:00', 97, 6, '720.00', '0.00', '720.00', NULL, 'Bill # 21/98', '0.00', 1, 1, '2022-10-05 12:24:18'),
(23, '2022-10-05 17:25:00', 46, 4, '17200.00', '0.00', '17200.00', NULL, 'Bill # 22/07', '0.00', 1, 1, '2022-10-05 12:26:01'),
(24, '2022-10-05 17:28:00', 121, 4, '3960.00', '0.00', '3960.00', NULL, 'Bill # 22/08', '0.00', 1, 1, '2022-10-05 12:30:17'),
(25, '2022-10-05 17:30:00', 79, 30, '2850.00', '0.00', '2850.00', NULL, 'Bill # 22/01', '0.00', 1, 1, '2022-10-08 06:11:25'),
(26, '2022-10-06 14:29:00', 92, 66, '8968.00', '0.00', '8968.00', NULL, 'Bill # 21/56', '0.00', 1, 1, '2022-10-06 09:35:50'),
(27, '2022-10-06 14:37:00', 48, 93, '15770.00', '0.00', '15770.00', NULL, 'Bill # 21/93', '0.00', 1, 1, '2022-10-06 09:42:08'),
(28, '2022-10-06 14:51:00', 81, 45, '32532.00', '0.00', '32532.00', NULL, 'Bill # 22/09', '0.00', 1, 1, '2022-10-08 07:21:18'),
(29, '2022-10-06 15:53:00', 42, 57, '10054.00', '0.00', '10054.00', NULL, 'Bill # 22/10', '0.00', 1, 1, '2022-10-06 11:05:55'),
(30, '2022-10-06 16:07:00', 70, 135, '38247.00', '0.00', '38247.00', NULL, 'Bill # 22/10+11', '0.00', 1, 1, '2022-10-06 11:24:19'),
(31, '2022-10-06 16:24:00', 32, 120, '20066.00', '0.00', '20066.00', NULL, 'Bill # 22/13', '0.00', 1, 1, '2022-10-06 11:30:55'),
(33, '2022-10-06 11:12:00', 46, 1, '470.00', '0.00', '470.00', NULL, 'Bill # 22/07', '0.00', 1, 1, '2022-10-08 06:12:51'),
(34, '2022-10-06 11:15:00', 125, 2, '2280.00', '0.00', '2280.00', NULL, 'Shahid Qureshi c/o Nasir Brothers Hussainabad\nBill # 22/14', '0.00', 1, 1, '2022-10-08 06:17:06'),
(35, '2022-10-06 11:48:00', 63, -19, '-20992.00', '0.00', '-20992.00', NULL, 'Yeh stock Hussain Paints Jamshoro se lerker Lal Baksh Jamshoro ko dia hay\nBill # 22/09', '0.00', 1, 1, '2022-10-08 07:24:28'),
(36, '2022-10-08 15:32:00', 24, 223, '37565.00', '0.00', '37565.00', NULL, 'Bill # 22/15+16', '0.00', 1, 1, '2022-10-08 10:41:58'),
(37, '2022-10-08 11:42:00', 125, 500, '6500.00', '0.00', '6500.00', 85, 'Bill # 20/86\nShehbaz Fridge Latifabad # 7', '0.00', 1, 1, '2022-10-10 10:40:27'),
(38, '2022-10-10 14:16:00', 116, 142, '41656.00', '0.00', '41656.00', NULL, 'Bill # 21/49', '0.00', 1, 1, '2022-10-10 09:19:16'),
(39, '2022-10-10 14:21:00', 46, 6, '6360.00', '0.00', '6360.00', NULL, 'Bill # 22/07', '0.00', 1, 1, '2022-10-11 11:50:35'),
(40, '2022-10-10 14:22:00', 51, 18, '5316.00', '0.00', '5316.00', NULL, 'Bill # 22/17', '0.00', 1, 1, '2022-10-11 11:51:37'),
(41, '2022-10-10 14:29:00', 112, 28, '27320.00', '0.00', '27320.00', NULL, 'Bill # 22/18', '0.00', 1, 1, '2022-10-11 12:06:48'),
(42, '2022-10-10 14:34:00', 104, 19, '10760.00', '0.00', '10760.00', NULL, 'Bill # 22/19', '0.00', 1, 1, '2022-10-10 09:35:57'),
(43, '2022-10-10 14:37:00', 89, 84, '20520.00', '0.00', '20520.00', NULL, 'Bill # 22/20', '0.00', 1, 1, '2022-10-11 12:14:57'),
(44, '2022-10-10 14:43:00', 40, 18, '1800.00', '0.00', '1800.00', NULL, 'Bill # 22/21', '0.00', 1, 1, '2022-10-10 09:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `is_return` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `sales_id`, `item_category_id`, `item_id`, `sale_price`, `discount`, `quantity`, `total`, `is_return`) VALUES
(1, 1, 5, 1259, '700.00', '0.00', 6, '4200.00', 0),
(2, 2, 5, 1645, '3000.00', '0.00', 1, '3000.00', 0),
(3, 2, 9, 1238, '75.00', '0.00', 24, '1800.00', 0),
(4, 2, 9, 1239, '87.50', '0.00', 24, '2100.00', 0),
(5, 2, 9, 1242, '100.00', '0.00', 24, '2400.00', 0),
(6, 3, 11, 1185, '4300.00', '0.00', 1, '4300.00', 0),
(7, 3, 30, 1373, '180.00', '0.00', 4, '720.00', 0),
(8, 3, 5, 1259, '670.00', '0.00', 3, '2010.00', 0),
(9, 4, 30, 1379, '400.00', '0.00', 3, '1200.00', 0),
(10, 4, 30, 1378, '370.00', '0.00', 6, '2220.00', 0),
(11, 4, 5, 1127, '235.00', '0.00', 30, '7050.00', 0),
(12, 4, 5, 1129, '165.00', '0.00', 50, '8250.00', 0),
(13, 4, 5, 1582, '165.00', '0.00', 18, '2970.00', 0),
(14, 4, 4, 1339, '195.00', '0.00', 10, '1950.00', 0),
(15, 4, 4, 1353, '240.00', '0.00', 10, '2400.00', 0),
(16, 4, 4, 1340, '300.00', '0.00', 6, '1800.00', 0),
(17, 4, 4, 1354, '360.00', '0.00', 6, '2160.00', 0),
(18, 4, 5, 1259, '700.00', '0.00', 3, '2100.00', 0),
(19, 4, 22, 1456, '280.00', '0.00', 30, '8400.00', 0),
(20, 4, 22, 1455, '230.00', '0.00', 36, '8280.00', 0),
(21, 5, 6, 1256, '200.00', '0.00', 5, '1000.00', 0),
(22, 5, 4, 1163, '360.00', '0.00', 3, '1080.00', 0),
(23, 6, 11, 1490, '2200.00', '0.00', 1, '2200.00', 0),
(24, 7, 11, 1219, '4650.00', '0.00', 3, '13950.00', 0),
(25, 8, 12, 1221, '580.00', '0.00', 23, '13340.00', 0),
(26, 8, 12, 1226, '420.00', '0.00', 23, '9660.00', 0),
(27, 8, 16, 1410, '165.00', '0.00', 12, '1980.00', 0),
(28, 8, 4, 1337, '250.00', '0.00', 50, '12500.00', 0),
(29, 8, 4, 1351, '310.00', '0.00', 50, '15500.00', 0),
(30, 9, 22, 1456, '280.00', '0.00', 75, '21000.00', 0),
(31, 10, 5, 1129, '165.00', '0.00', 28, '4620.00', 0),
(32, 10, 5, 1582, '165.00', '0.00', 28, '4620.00', 0),
(33, 10, 5, 1132, '190.00', '0.00', 28, '5320.00', 0),
(34, 10, 1, 1112, '2050.00', '0.00', 7, '14350.00', 0),
(35, 11, 22, 1456, '270.00', '0.00', 75, '20250.00', 0),
(36, 11, 1, 1285, '170.00', '0.00', 66, '11220.00', 0),
(37, 11, 14, 1273, '68.00', '0.00', 6, '408.00', 0),
(38, 11, 5, 1575, '500.00', '0.00', 6, '3000.00', 0),
(39, 11, 5, 1524, '1620.00', '0.00', 3, '4860.00', 0),
(40, 12, 5, 1648, '300.00', '0.00', 1, '300.00', 0),
(41, 13, 11, 1185, '4350.00', '0.00', 1, '4350.00', 0),
(42, 13, 5, 1127, '235.00', '0.00', 10, '2350.00', 0),
(43, 13, 9, 1242, '130.00', '0.00', 24, '3120.00', 0),
(44, 13, 19, 1363, '68.00', '0.00', 18, '1224.00', 0),
(45, 14, 5, 1124, '500.00', '0.00', 12, '6000.00', 0),
(46, 14, 4, 1339, '200.00', '0.00', 24, '4800.00', 0),
(47, 14, 4, 1353, '250.00', '0.00', 12, '3000.00', 0),
(48, 14, 4, 1329, '520.00', '0.00', 6, '3120.00', 0),
(49, 14, 4, 1340, '295.00', '0.00', 24, '7080.00', 0),
(50, 14, 4, 1354, '365.00', '0.00', 12, '4380.00', 0),
(51, 14, 4, 1330, '600.00', '0.00', 6, '3600.00', 0),
(52, 14, 4, 1169, '80.00', '0.00', 50, '4000.00', 0),
(53, 14, 4, 1159, '304.00', '0.00', 12, '3648.00', 0),
(54, 14, 4, 1163, '360.00', '0.00', 10, '3600.00', 0),
(55, 14, 23, 1590, '75.00', '0.00', 12, '900.00', 0),
(56, 14, 23, 1592, '110.00', '0.00', 12, '1320.00', 0),
(57, 14, 23, 1589, '96.00', '0.00', 12, '1152.00', 0),
(58, 14, 16, 1412, '198.00', '0.00', 12, '2376.00', 0),
(59, 14, 16, 1414, '198.00', '0.00', 12, '2376.00', 0),
(60, 14, 16, 1416, '260.00', '0.00', 9, '2340.00', 0),
(61, 14, 16, 1418, '350.00', '0.00', 6, '2100.00', 0),
(62, 14, 16, 1408, '540.00', '0.00', 6, '3240.00', 0),
(63, 14, 21, 1429, '130.00', '0.00', 12, '1560.00', 0),
(64, 14, 21, 1430, '195.00', '0.00', 12, '2340.00', 0),
(65, 14, 21, 1422, '265.00', '0.00', 8, '2120.00', 0),
(66, 14, 21, 1640, '580.00', '0.00', 3, '1740.00', 0),
(67, 14, 21, 1426, '740.00', '0.00', 3, '2220.00', 0),
(68, 14, 21, 1428, '1800.00', '0.00', 3, '5400.00', 0),
(69, 14, 19, 1630, '65.00', '0.00', 50, '3250.00', 0),
(70, 15, 4, 1159, '352.00', '0.00', 6, '2112.00', 0),
(71, 15, 5, 1520, '320.00', '0.00', 14, '4480.00', 0),
(72, 15, 5, 1487, '320.00', '0.00', 9, '2880.00', 0),
(73, 15, 5, 1107, '580.00', '0.00', 3, '1740.00', 0),
(74, 15, 16, 1414, '200.00', '0.00', 12, '2400.00', 0),
(75, 16, 4, 1294, '340.00', '0.00', 10, '3400.00', 0),
(76, 17, 5, 1129, '170.00', '0.00', 8, '1360.00', 0),
(77, 17, 5, 1487, '325.00', '0.00', 2, '650.00', 0),
(78, 17, 4, 1339, '205.00', '0.00', 4, '820.00', 0),
(79, 17, 4, 1354, '390.00', '0.00', 3, '1170.00', 0),
(80, 17, 4, 1169, '82.00', '0.00', 10, '820.00', 0),
(81, 17, 19, 1630, '65.00', '0.00', 10, '650.00', 0),
(82, 18, 6, 1587, '23.00', '0.00', 100, '2300.00', 0),
(83, 19, NULL, 1540, '108.00', '0.00', 12, '1296.00', 0),
(84, 20, NULL, 1540, '110.00', '0.00', 10, '1100.00', 0),
(85, 20, NULL, 1171, '65.00', '0.00', 12, '780.00', 0),
(86, 20, NULL, 1226, '450.00', '0.00', 3, '1350.00', 0),
(87, 21, NULL, 1340, '310.00', '0.00', 12, '3720.00', 0),
(88, 21, NULL, 1354, '390.00', '0.00', 12, '4680.00', 0),
(89, 21, NULL, 1606, '230.00', '0.00', 6, '1380.00', 0),
(90, 21, NULL, 1294, '340.00', '0.00', 3, '1020.00', 0),
(91, 21, NULL, 1466, '298.00', '0.00', 4, '1192.00', 0),
(92, 21, NULL, 1586, '560.00', '0.00', 2, '1120.00', 0),
(93, 21, NULL, 1115, '540.00', '0.00', 2, '1080.00', 0),
(94, 21, NULL, 1443, '540.00', '0.00', 2, '1080.00', 0),
(95, 22, NULL, 1495, '120.00', '0.00', 6, '720.00', 0),
(96, 23, NULL, 1185, '4300.00', '0.00', 4, '17200.00', 0),
(97, 24, NULL, 1524, '1580.00', '0.00', 2, '3160.00', 0),
(98, 24, NULL, 1557, '400.00', '0.00', 2, '800.00', 0),
(99, 25, NULL, 1581, '235.00', '0.00', 6, '1410.00', 0),
(100, 25, NULL, 1630, '65.00', '0.00', 12, '780.00', 0),
(101, 25, NULL, 1633, '55.00', '0.00', 12, '660.00', 0),
(102, 26, NULL, 1128, '175.00', '0.00', 10, '1750.00', 0),
(103, 26, NULL, 1485, '325.00', '0.00', 2, '650.00', 0),
(104, 26, NULL, 1339, '205.00', '0.00', 6, '1230.00', 0),
(105, 26, NULL, 1329, '520.00', '0.00', 2, '1040.00', 0),
(106, 26, NULL, 1346, '168.00', '0.00', 6, '1008.00', 0),
(107, 26, NULL, 1138, '75.00', '0.00', 6, '450.00', 0),
(108, 26, NULL, 1140, '130.00', '0.00', 6, '780.00', 0),
(109, 26, NULL, 1631, '75.00', '0.00', 12, '900.00', 0),
(110, 26, NULL, 1634, '30.00', '0.00', 12, '360.00', 0),
(111, 26, NULL, 1594, '200.00', '0.00', 4, '800.00', 0),
(112, 27, NULL, 1171, '65.00', '0.00', 6, '390.00', 0),
(113, 27, NULL, 1284, '60.00', '0.00', 12, '720.00', 0),
(114, 27, NULL, 1340, '300.00', '0.00', 10, '3000.00', 0),
(115, 27, NULL, 1354, '380.00', '0.00', 6, '2280.00', 0),
(116, 27, NULL, 1330, '620.00', '0.00', 3, '1860.00', 0),
(117, 27, NULL, 1339, '205.00', '0.00', 10, '2050.00', 0),
(118, 27, NULL, 1353, '245.00', '0.00', 6, '1470.00', 0),
(119, 27, NULL, 1329, '520.00', '0.00', 4, '2080.00', 0),
(120, 27, NULL, 1630, '65.00', '0.00', 24, '1560.00', 0),
(121, 27, NULL, 1634, '30.00', '0.00', 12, '360.00', 0),
(122, 28, NULL, 1540, '110.00', '0.00', 24, '2640.00', 0),
(123, 28, NULL, 1253, '4450.00', '0.00', 2, '8900.00', 0),
(124, 29, NULL, 1316, '125.00', '0.00', 4, '500.00', 0),
(125, 29, NULL, 1317, '150.00', '0.00', 4, '600.00', 0),
(126, 29, NULL, 1540, '108.00', '0.00', 18, '1944.00', 0),
(127, 29, NULL, 1498, '185.00', '0.00', 6, '1110.00', 0),
(128, 29, NULL, 1495, '135.00', '0.00', 6, '810.00', 0),
(129, 29, NULL, 1450, '135.00', '0.00', 6, '810.00', 0),
(130, 29, NULL, 1605, '260.00', '0.00', 6, '1560.00', 0),
(131, 29, NULL, 1226, '440.00', '0.00', 5, '2200.00', 0),
(132, 29, NULL, 1549, '220.00', '0.00', 1, '220.00', 0),
(133, 29, NULL, 1553, '300.00', '0.00', 1, '300.00', 0),
(134, 30, NULL, 1128, '175.00', '0.00', 8, '1400.00', 0),
(135, 30, NULL, 1580, '175.00', '0.00', 14, '2450.00', 0),
(136, 30, NULL, 1485, '325.00', '0.00', 2, '650.00', 0),
(137, 30, NULL, 1533, '1120.00', '0.00', 1, '1120.00', 0),
(138, 30, NULL, 1530, '960.00', '0.00', 2, '1920.00', 0),
(139, 30, NULL, 1108, '970.00', '0.00', 1, '970.00', 0),
(140, 30, NULL, 1105, '830.00', '0.00', 2, '1660.00', 0),
(141, 30, NULL, 1222, '600.00', '0.00', 3, '1800.00', 0),
(142, 30, NULL, 1226, '440.00', '0.00', 6, '2640.00', 0),
(143, 30, NULL, 1498, '195.00', '0.00', 3, '585.00', 0),
(144, 30, NULL, 1493, '135.00', '0.00', 4, '540.00', 0),
(145, 30, NULL, 1495, '135.00', '0.00', 12, '1620.00', 0),
(146, 30, NULL, 1129, '172.00', '0.00', 6, '1032.00', 0),
(147, 30, NULL, 1487, '325.00', '0.00', 2, '650.00', 0),
(148, 30, NULL, 1283, '85.00', '0.00', 12, '1020.00', 0),
(149, 30, NULL, 1284, '65.00', '0.00', 12, '780.00', 0),
(150, 30, NULL, 1375, '160.00', '0.00', 6, '960.00', 0),
(151, 30, NULL, 1124, '530.00', '0.00', 6, '3180.00', 0),
(152, 30, NULL, 1125, '415.00', '0.00', 6, '2490.00', 0),
(153, 30, NULL, 1576, '415.00', '0.00', 6, '2490.00', 0),
(154, 30, NULL, 1345, '360.00', '0.00', 10, '3600.00', 0),
(155, 30, NULL, 1358, '465.00', '0.00', 6, '2790.00', 0),
(156, 30, NULL, 1163, '380.00', '0.00', 5, '1900.00', 0),
(157, 31, NULL, 1340, '295.00', '0.00', 12, '3540.00', 0),
(158, 31, NULL, 1354, '370.00', '0.00', 6, '2220.00', 0),
(159, 31, NULL, 1339, '200.00', '0.00', 12, '2400.00', 0),
(160, 31, NULL, 1353, '245.00', '0.00', 6, '1470.00', 0),
(161, 31, NULL, 1451, '46.00', '0.00', 12, '552.00', 0),
(162, 31, NULL, 1452, '50.00', '0.00', 12, '600.00', 0),
(163, 31, NULL, 1453, '64.00', '0.00', 12, '768.00', 0),
(164, 31, NULL, 1238, '81.67', '0.00', 12, '980.00', 0),
(165, 31, NULL, 1239, '94.17', '0.00', 12, '1130.00', 0),
(166, 31, NULL, 1242, '108.33', '0.00', 12, '1300.00', 0),
(167, 31, NULL, 1450, '135.00', '0.00', 6, '810.00', 0),
(168, 31, NULL, 1166, '884.00', '0.00', 3, '2652.00', 0),
(169, 31, NULL, 1164, '548.00', '0.00', 3, '1644.00', 0),
(173, 34, NULL, 1428, '1800.00', '0.00', 1, '1800.00', 0),
(172, 33, NULL, 1486, '470.00', '0.00', 1, '470.00', 0),
(174, 34, NULL, 1486, '480.00', '0.00', 1, '480.00', 0),
(175, 35, NULL, 1185, '4350.00', '0.00', -2, '-8700.00', 1),
(176, 35, NULL, 1209, '5500.00', '0.00', -1, '-5500.00', 1),
(177, 35, NULL, 1514, '840.00', '0.00', -6, '-5040.00', 1),
(178, 35, NULL, 1346, '165.00', '0.00', -4, '-660.00', 1),
(179, 35, NULL, 1541, '182.00', '0.00', -6, '-1092.00', 1),
(180, 28, NULL, 1185, '4350.00', '0.00', 2, '8700.00', 0),
(181, 28, NULL, 1209, '5500.00', '0.00', 1, '5500.00', 0),
(182, 28, NULL, 1514, '840.00', '0.00', 6, '5040.00', 0),
(183, 28, NULL, 1346, '165.00', '0.00', 4, '660.00', 0),
(184, 28, NULL, 1541, '182.00', '0.00', 6, '1092.00', 0),
(185, 36, NULL, 1141, '115.00', '0.00', 18, '2070.00', 0),
(186, 36, NULL, 1131, '135.00', '0.00', 1, '135.00', 0),
(187, 36, NULL, 1583, '125.00', '0.00', 99, '12375.00', 0),
(188, 36, NULL, 1488, '195.00', '0.00', 6, '1170.00', 0),
(189, 36, NULL, 1128, '175.00', '0.00', 8, '1400.00', 0),
(190, 36, NULL, 1518, '325.00', '0.00', 3, '975.00', 0),
(191, 36, NULL, 1485, '325.00', '0.00', 7, '2275.00', 0),
(192, 36, NULL, 1226, '440.00', '0.00', 6, '2640.00', 0),
(193, 36, NULL, 1493, '140.00', '0.00', 2, '280.00', 0),
(194, 36, NULL, 1171, '65.00', '0.00', 12, '780.00', 0),
(195, 36, NULL, 1129, '170.00', '0.00', 6, '1020.00', 0),
(196, 36, NULL, 1495, '135.00', '0.00', 5, '675.00', 0),
(197, 36, NULL, 1496, '135.00', '0.00', 6, '810.00', 0),
(198, 36, NULL, 1474, '100.00', '0.00', 14, '1400.00', 0),
(199, 36, NULL, 1375, '150.00', '0.00', 13, '1950.00', 0),
(200, 36, NULL, 1340, '310.00', '0.00', 10, '3100.00', 0),
(201, 36, NULL, 1354, '390.00', '0.00', 5, '1950.00', 0),
(202, 36, NULL, 1510, '1280.00', '0.00', 2, '2560.00', 0),
(203, 37, NULL, 1588, '13.00', '0.00', 500, '6500.00', 0),
(204, 38, NULL, 1339, '200.00', '0.00', 50, '10000.00', 0),
(205, 38, NULL, 1340, '300.00', '0.00', 50, '15000.00', 0),
(206, 38, NULL, 1345, '352.00', '0.00', 24, '8448.00', 0),
(207, 38, NULL, 1358, '456.00', '0.00', 18, '8208.00', 0),
(208, 39, NULL, 1531, '1060.00', '0.00', 6, '6360.00', 0),
(209, 40, NULL, 1345, '352.00', '0.00', 12, '4224.00', 0),
(210, 40, NULL, 1541, '182.00', '0.00', 6, '1092.00', 0),
(230, 41, NULL, 1437, '1620.00', '0.00', 4, '6480.00', 0),
(212, 41, NULL, 1640, '590.00', '0.00', 2, '1180.00', 0),
(213, 41, NULL, 1426, '780.00', '0.00', 4, '3120.00', 0),
(214, 41, NULL, 1434, '680.00', '0.00', 4, '2720.00', 0),
(229, 41, NULL, 1435, '980.00', '0.00', 2, '1960.00', 0),
(228, 41, NULL, 1500, '1580.00', '0.00', 2, '3160.00', 0),
(217, 42, NULL, 1225, '680.00', '0.00', 1, '680.00', 0),
(218, 42, NULL, 1221, '560.00', '0.00', 18, '10080.00', 0),
(221, 43, NULL, 1340, '300.00', '0.00', 18, '5400.00', 0),
(222, 43, NULL, 1354, '380.00', '0.00', 12, '4560.00', 0),
(223, 43, NULL, 1365, '360.00', '0.00', 6, '2160.00', 0),
(224, 44, NULL, 1221, '100.00', '0.00', 18, '1800.00', 0),
(225, 41, NULL, 1422, '290.00', '0.00', 4, '1160.00', 0),
(226, 41, NULL, 1428, '1800.00', '0.00', 4, '7200.00', 0),
(227, 41, NULL, 1129, '170.00', '0.00', 2, '340.00', 0),
(231, 43, NULL, 1461, '175.00', '0.00', 48, '8400.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_code` varchar(50) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_code`, `supplier_name`, `phone`, `address`, `balance`, `status`, `ts`) VALUES
(2, '', 'BUTT CORPORATION', '03456605286', 'FAISAL ROAD SIDDIQ COLONY GUJRANWALA,\r\nGUJRANWALA, PUNJAB, PAKISTAN', '2361898.00', 1, '2022-10-02 09:22:02'),
(3, '', 'DAWOOD MUGHAL', '03016690302', 'GUJRANWALA, PUNJAB, PAKISTAN', '0.00', 1, '2022-10-02 09:24:09'),
(4, '', 'LINE CLAMP', '03162276090', 'GOLIMAR KARACHI', '2066.00', 1, '2022-10-02 09:27:01'),
(5, '', 'M. SHEHZAD', '03032389563', 'GOLIMAR,\r\nKARACHI, SINDH, PAKISTAN', '0.00', 1, '2022-10-02 09:28:32'),
(6, '', 'TOUHEED CORPORATION', '03218757908', 'GOLIMAR KARACHI', '0.00', 1, '2022-10-02 09:29:23'),
(7, '', 'WASEEM BALL VALVE', '03006400477', 'GUJRANWALA', '96560.00', 1, '2022-10-02 09:31:34'),
(8, '', 'SHEHBAZ AHMED', '03052570751', 'GUJRANWALA, SINDH, PAKISTAN', '2400.00', 1, '2022-10-02 10:12:51'),
(9, '', 'SAGA FITTINGS', '03364036188', 'GUJRANWALA, SINDH, PAKISTAN', '75750.00', 1, '2022-10-02 10:13:53'),
(10, '', 'RANA SANITAIRY', '03216405689', 'GUJRANWALA, PUNJAB, PAKISTAN', '264478.00', 1, '2022-10-02 10:14:59'),
(11, '', 'QADRI SANITARY', '03122611189', 'GUJRANWALA, SINDH, PAKISTAN', '0.00', 1, '2022-10-02 10:15:46'),
(12, '', 'PEAK PLASTIC INDUSTRY', '03004810578', 'GUJRANWALA, PUNJAB, PAKISTAN', '270749.00', 1, '2022-10-02 10:16:51'),
(13, '', 'PARAGON INDUSTRY', '03003406244', 'GUJRANWALA, PUNJAB, PAKISTAN', '255137.00', 1, '2022-10-02 10:17:44'),
(14, '', 'NADEEM MUGHAL', '03453592886', 'GUJRANWALA, PUNJAB, PAKISTAN', '75866.00', 1, '2022-10-02 10:18:44'),
(15, '', 'MORNING PLASTIC INDUSTRY', '03227945844', 'GUJRANWALA, PUNJAB, PAKISTAN', '555384.00', 1, '2022-10-02 10:19:35'),
(16, '', 'MEHTAB SANITARY', '03012247580', 'GOLIMAR,\r\nKARACHI, SINDH, PAKISTAN', '84099.00', 1, '2022-10-02 10:20:35'),
(17, '', 'KHURRAM KANGRI', '03016485703', 'GUJRANWALA, PUNJAB, PAKISTAN', '39933.00', 1, '2022-10-02 10:21:22'),
(18, '', 'HUSSAIN HOOK', '03222590907', 'KARACHI,\r\nKARACHI, SINDH, PAKISTAN', '18680.00', 1, '2022-10-02 10:22:30'),
(19, '', 'FAISAL MISHOO', '03002920100', 'KARACHI,\r\nKARACHI, SINDH, PAKISTAN', '20.00', 1, '2022-10-02 10:23:15'),
(20, '', 'AFZAL ASIA SINK', '', 'GUJRANWALA, PUNJAB, PAKISTAN', '7350.00', 1, '2022-10-02 10:24:24'),
(21, '', 'BHATTI SANITARY', '03225609417', 'GUJRANWALA, PUNJAB, PAKISTAN', '8995.00', 1, '2022-10-02 10:25:11'),
(22, '', 'AL-SHAIKH SANITARY', '03222264421', 'GUJRANWALA, PUNJAB, PAKISTAN', '10805.00', 1, '2022-10-02 10:25:57'),
(23, '', 'AL-KARAM SANITARY FITTINGS', '03218554573', 'KACHA EMANABAD ROAD,\r\nGUJRANWALA, PUNJAB, PAKISTAN', '38720.00', 1, '2022-10-02 10:27:21'),
(24, '', 'ABDULLAH SANITARY', '03452160521', 'KARACHI,\r\nKARACHI, SINDH, PAKISTAN', '92832.00', 1, '2022-10-02 10:29:30'),
(25, '', '11 STAR CERAMICS', '03008640628', 'GUJRANWALA, PUNJAB, PAKISTAN', '128414.00', 1, '2022-10-02 10:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payment`
--

CREATE TABLE `supplier_payment` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `account_id` int(11) NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_payment`
--

INSERT INTO `supplier_payment` (`id`, `supplier_id`, `datetime_added`, `amount`, `account_id`, `details`, `status`, `ts`) VALUES
(1, 1, '2022-09-18 13:25:00', '100000.00', 1, 'sa', 1, '2022-09-19 12:08:42'),
(2, 2, '2022-10-03 13:58:00', '18000.00', 0, 'Easy pesa account main bheje', 1, '2022-10-06 08:58:37'),
(3, 2, '2022-10-03 13:59:00', '7000.00', 0, 'Hafiz Nisar (Matiyari) ne online kiey', 1, '2022-10-06 08:59:58'),
(4, 13, '2022-10-03 14:00:00', '50000.00', 0, 'Easy pesa account main bheje', 1, '2022-10-06 09:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL DEFAULT '0' COMMENT '0:Debit;1:Credit',
  `datetime_added` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `title`, `short_title`, `status`, `ts`) VALUES
(1, 'PIECES', 'PC', 1, '2022-09-23 10:45:20'),
(2, 'DOZEN', 'DZ', 1, '2022-09-23 10:45:20'),
(3, 'BAG', 'BG', 1, '2022-09-23 10:45:20'),
(4, 'PAIR', 'PR', 1, '2022-09-23 10:45:20'),
(5, 'PACKET', 'PKT', 1, '2022-09-23 10:45:20'),
(6, 'GRUS', 'GS', 1, '2022-09-23 10:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filelocation` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `filename`, `filelocation`) VALUES
(9, 'test', 'test.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_type`
--
ALTER TABLE `admin_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config_type`
--
ALTER TABLE `config_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config_variable`
--
ALTER TABLE `config_variable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payment`
--
ALTER TABLE `customer_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`item_category_id`),
  ADD KEY `products_name_index` (`title`),
  ADD KEY `products_unit_id_index` (`unit_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_2_admin_type`
--
ALTER TABLE `menu_2_admin_type`
  ADD PRIMARY KEY (`menu_id`,`admin_type_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin_type`
--
ALTER TABLE `admin_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `config_type`
--
ALTER TABLE `config_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `config_variable`
--
ALTER TABLE `config_variable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `customer_payment`
--
ALTER TABLE `customer_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1657;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
