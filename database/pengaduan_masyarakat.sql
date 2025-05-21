-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 01:59 AM
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
-- Database: `pengaduan_masyarakat`
--

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `isi_kontak` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `nama`, `email`, `isi_kontak`) VALUES
(2, 'rangga', 'bronjames@gmail.com', 'makansianggratis\r\n'),
(3, 'rangga', 'bronjames@gmail.com', 'makansianggratis\r\n'),
(4, 'rangga', 'bronjames@gmail.com', 'maknaananan'),
(5, 'penthouse', 'playa@gmail.com', 'clique');

-- --------------------------------------------------------

--
-- Table structure for table `masyarakat`
--

CREATE TABLE `masyarakat` (
  `id_masyarakat` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `email` varchar(25) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(225) DEFAULT NULL,
  `telp` varchar(15) NOT NULL,
  `level` varchar(25) NOT NULL DEFAULT 'masyarakat',
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masyarakat`
--

INSERT INTO `masyarakat` (`id_masyarakat`, `nik`, `email`, `nama`, `username`, `password`, `telp`, `level`, `reset_token`, `token_expiry`) VALUES
(14, '9919281929192981', 'user1@gmail.com', 'user', 'user', '$2y$10$rdYJSRWR5e7oJB/lqiFL3uqznMoeJyqYaIrUK5iCN9CWEm/.d/qgq', '081234567788', 'masyarakat', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `judul_laporan` varchar(255) NOT NULL,
  `tgl_pengaduan` date DEFAULT NULL,
  `nik` char(16) DEFAULT NULL,
  `isi_laporan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kategori` varchar(16) NOT NULL,
  `status` enum('diproses','ditolak','selesai') DEFAULT 'diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `judul_laporan`, `tgl_pengaduan`, `nik`, `isi_laporan`, `foto`, `kategori`, `status`) VALUES
(21, 'tolong dongg', '2025-05-18', '9919281929192981', 'tolong tolong lagu banda neira terlalu bggagus', 'fBCBLbC5ZACebst4mCS9.png', '', 'selesai'),
(25, 'wc kotor, ada yg merokok', '2025-05-12', '9919281929192981', 'gdsa', '1800DcLz2HTfORXnP7oI.jpg', '', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_petugas` varchar(50) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `level` enum('admin','petugas') DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nik`, `nama_petugas`, `email`, `username`, `password`, `telp`, `level`, `reset_token`, `token_expiry`) VALUES
(12, '1312131213121312', 'leflaur leflah eshkoshka', 'helterskelter@gmail.com', 'leflaur leflah eshkoshka', '$2y$10$KWRTy0LgyXunmztrdx1fF.Lk55Z7MxVL8.5.cNlNE2VrzWcUtyUdi', '881882881882', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_pengaduan` int(11) DEFAULT NULL,
  `tgl_tanggapan` date DEFAULT NULL,
  `tanggapan` text DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_pengaduan`, `tgl_tanggapan`, `tanggapan`, `id_petugas`) VALUES
(32, 21, '2025-05-18', 'siip akan segera meluncur untuk mendengarkan', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `masyarakat`
--
ALTER TABLE `masyarakat`
  ADD PRIMARY KEY (`id_masyarakat`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `FK_pengaduan_masyarakat` (`nik`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`),
  ADD KEY `pengaduan_tanggapan` (`id_pengaduan`),
  ADD KEY `tanggapan_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `masyarakat`
--
ALTER TABLE `masyarakat`
  MODIFY `id_masyarakat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `FK_pengaduan_masyarakat` FOREIGN KEY (`nik`) REFERENCES `masyarakat` (`nik`) ON DELETE CASCADE;

--
-- Constraints for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD CONSTRAINT `pengaduan_tanggapan` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tanggapan_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
