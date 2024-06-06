-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 08:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kampusmadu`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `harga_barang` decimal(10,2) DEFAULT NULL,
  `jumlah_stok` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_barang`, `jumlah_stok`, `is_deleted`) VALUES
(1, 'Madu Hutan', 95000.00, 42, 0),
(2, 'Madu Randu', 75000.00, 0, 0),
(3, 'Chiaseed', 50000.00, 0, 0),
(4, 'Detox Lemak', 180000.00, 31, 0),
(5, 'Rumput Laut Kering', 30000.00, 18, 0),
(6, 'Madu Klanceng Asli', 160000.00, 100, 0),
(7, 'Ketumbar Organik', 22000.00, 72, 0),
(8, 'Garam Himalaya', 35000.00, 75, 0),
(10, 'Paket Ultimate JSR', 190000.00, 38, 0),
(11, 'Daun Bidara', 30000.00, 100, 0),
(12, 'Temulawak Bubuk', 35000.00, 52, 0),
(13, 'Lemon Kering', 30000.00, 930, 0),
(26, 'Bunga Lawang', 30000.00, 30, 0),
(28, 'Madu new', 1.00, 5, 0),
(29, 'Siomay', 5000.00, 89, 0),
(30, 'Cek Satu Barang', 10000.00, 0, 1),
(31, 'Jeroan', 3000.00, 70, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah_barang_terjual` int(11) DEFAULT NULL,
  `harga_total` decimal(10,2) DEFAULT NULL,
  `tanggal_penjualan` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_barang`, `jumlah_barang_terjual`, `harga_total`, `tanggal_penjualan`, `keterangan`) VALUES
(72, 1, 1, 95000.00, '2024-05-24', ''),
(73, 3, 3, 150000.00, '2024-05-24', 'CAPEk'),
(74, 2, 2, 150000.00, '2024-05-24', 'COBA AAGI'),
(75, 2, 2, 150000.00, '0000-00-00', 'lagilagi\r\n'),
(76, 3, 2, 100000.00, '2024-05-24', ''),
(77, 2, 1, 75000.00, '0000-00-00', ''),
(78, 26, 1, 30000.00, '0000-00-00', ''),
(79, 1, 2, 190000.00, '2024-05-24', ''),
(81, 3, 2, 100000.00, '2024-05-24', 'CEK'),
(82, 28, 3, 3.00, '0000-00-00', 'reseted'),
(83, 4, 1, 180000.00, '0000-00-00', 'terteset'),
(84, 3, 4, 200000.00, '0000-00-00', ''),
(85, 3, 4, 200000.00, '0000-00-00', ''),
(86, 3, 4, 200000.00, '0000-00-00', ''),
(87, 2, 1, 75000.00, '0000-00-00', 'rsetee'),
(88, 4, 1, 180000.00, '0000-00-00', 'rest'),
(89, 26, 2, 60000.00, '2024-05-24', 'ayahu'),
(90, 3, 2, 100000.00, '2024-05-24', 'ayahu'),
(91, 4, 1, 180000.00, '2024-05-24', 'taa'),
(93, 4, 7976, 99999999.99, '2024-05-24', 'wefrewf'),
(94, 4, 2, 0.00, '2024-05-24', 'zs'),
(95, 3, 5, 0.00, '2024-05-24', 'tete'),
(96, 2, 1, 0.00, '2024-05-24', ''),
(97, 3, 2, 0.00, '2024-05-24', ''),
(98, 3, 2, 0.00, '2024-05-24', ''),
(99, 1, 1, 0.00, '2024-05-24', ''),
(100, 29, 1, 0.00, '2024-05-24', ''),
(101, 1, 1, 0.00, '2024-05-24', ''),
(102, 4, 2, 0.00, '2024-05-24', ''),
(103, 1, 1, 0.00, '2024-05-24', ''),
(104, 2, 1, 75000.00, '2024-05-24', 'a'),
(105, 3, 1, 50000.00, '2024-05-24', 'sudah hdden'),
(106, 4, 2, 360000.00, '2024-05-24', 'HIDDEEDEN'),
(107, 2, 2, 150000.00, '2024-05-24', ''),
(108, 2, 2, 150000.00, '2024-05-24', 'tyr'),
(109, 2, 1, 75000.00, '2024-05-24', 'tes 2 08'),
(110, 12, 1, 50000.00, '2024-05-24', 'vaokcoasjcasijjasknjas'),
(111, 31, 3, 9000.00, '2024-05-27', ''),
(112, 2, 2, 150000.00, '2024-05-27', 'cek tanggal'),
(113, 31, 1, 10000.00, '2024-05-27', 'cek'),
(114, 31, 1, 3000.00, '2024-05-27', ''),
(115, 1, 2, 150000.00, '2024-05-27', 'cekkk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
