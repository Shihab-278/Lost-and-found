-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2024 at 07:05 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lost`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `post` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `post`) VALUES
(30, 'Watch', 1),
(31, 'Accessories', 5),
(32, 'Mobile', 1),
(33, 'Books', 0),
(34, 'Bag Pack', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `post_date` varchar(50) NOT NULL,
  `author` int(11) NOT NULL,
  `post_img` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `description`, `category`, `post_date`, `author`, `post_img`) VALUES
(36, 'I lost my wallet', 'juhdsusd', '30', '10 Jun, 2023', 1, '1686359775-trust.png'),
(37, 'Charger !', '                    A Samsung black color 18 watt charger was lost from the library.                ', '31', '10 Jun, 2023', 2, '1686539700-1686373044-download (1).jpg'),
(38, 'Mobile', '                    mobile jnusagc abgst cfvabhcsbv atsv cahvs                          ', '32', '11 Jun, 2023', 1, '1686539640-download (1).jpg'),
(39, 'Aa', 'knajsbja', '31', '12 Jun, 2023', 1, '1686541413-1686359775-trust.png'),
(40, 'Zooss', 'This is just test purpose.', '31', '12 Jun, 2023', 1, '1709531465-post_1.jpg'),
(41, ' Lost Black Backpack - CHEM 101 Lecture Hall (February 28th)', '                                        Black Jansport backpack with a small tear on the right strap. Contains a blue water bottle, chemistry textbook, and a pair of noise-canceling headphones. Lost during CHEM 101 lecture on February 28th. \r\n<br>\r\nPlease contact if found. <br>\r\nAbir Hossain <br>\r\nID-2014751194 <br>\r\nMobile No.- 01928382722                                ', '34', '04 Mar, 2024', 1, '1709531232-bag 1.jpeg'),
(42, 'Missing Set of Keys - Library Study Room (March 2nd)', ' Silver keyring with a University ID tag and two house keys. Lost in a study room on the second floor of the library on March 2nd.\r\nPlease contact if it found. <br>\r\nSarah <br>\r\nID- 206172616277 <br>\r\nMobile No. - 01726261762  ', '31', '04 Mar, 2024', 1, '1709531406-keys.jpeg'),
(43, 'Found ! Unidentified Water Bottle - Main Gym Locker Room (March 1st)', 'Blue metal water bottle with a dented cap. Found in a locker room stall in the Main Gym on March 1st. Please claim at the Lost and Found office in the University Police Department with a valid ID.', '31', '04 Mar, 2024', 1, '1709531595-bottol.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `username`, `password`, `role`) VALUES
(1, 'shihab', 'ahmed', 'shihab', '123', 1),
(2, 'Abir', 'Hossain', 'ahabir', '1122', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
