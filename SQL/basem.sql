-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2019 at 08:37 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basem`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(11) CHARACTER SET utf8 NOT NULL,
  `UserName` varchar(55) CHARACTER SET utf8 NOT NULL,
  `UserPassword` varchar(55) CHARACTER SET utf8 NOT NULL,
  `UserPhone` varchar(11) DEFAULT NULL,
  `UserJob` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `UserAddDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserAcs` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `UserPassword`, `UserPhone`, `UserJob`, `UserAddDate`, `UserAcs`) VALUES
('123ee', 'Admin', '123', '01117565755', 'admin', '2019-03-14 22:37:53', 1),
('lmVcJIf8Xy', 'power', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '01010112633', 'developer', '2019-03-15 07:59:57', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`,`UserPhone`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
