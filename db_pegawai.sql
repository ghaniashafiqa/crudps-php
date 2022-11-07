-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2022 at 01:35 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pegawai`
--

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `Nama` varchar(20) NOT NULL,
  `NIK` int(50) NOT NULL,
  `Telp` varchar(20) NOT NULL,
  `Jabatan` varchar(50) NOT NULL,
  `Gaji` bigint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`Nama`, `NIK`, `Telp`, `Jabatan`, `Gaji`) VALUES
('Jeni', 2001038179, '081514237883', 'Staff', 8300000),
('Tiffany Y', 2005623067, '081517252633', 'Manajer', 16700000),
('Taeyeon Kim', 2007412050, '081313152677', 'Direktur', 27500000),
('Yoona Im', 2103429062, '081517193305', 'Staff', 8750000),
('Ghania Shafiqa Raisa', 2107412053, '91314152801', 'Direktur', 37000000),
('Fiqa', 2107412055, '81315126600', 'Manajer', 20500000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`NIK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `NIK` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2107412056;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
