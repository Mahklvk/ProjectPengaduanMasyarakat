-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2025 pada 08.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

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
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(1, 'Jalan'),
(2, 'Listrik'),
(3, 'air');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `isi_kontak` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `nama`, `email`, `isi_kontak`) VALUES
(2, 'rangga', 'bronjames@gmail.com', 'makansianggratis\r\n'),
(3, 'rangga', 'bronjames@gmail.com', 'makansianggratis\r\n'),
(4, 'rangga', 'bronjames@gmail.com', 'maknaananan'),
(5, 'penthouse', 'playa@gmail.com', 'clique'),
(6, 'Rangga', 'rangga@gmail.com', 'website nya responsif, bagus dan menarik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `masyarakat`
--

CREATE TABLE `masyarakat` (
  `id_masyarakat` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `email` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(225) DEFAULT NULL,
  `telp` varchar(15) NOT NULL,
  `level` varchar(25) NOT NULL DEFAULT 'masyarakat',
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `masyarakat`
--

INSERT INTO `masyarakat` (`id_masyarakat`, `nik`, `email`, `username`, `password`, `telp`, `level`, `reset_token`, `token_expiry`) VALUES
(17, '3204122331123123', 'kelompok4@gmail.com', 'kelompok4', '$2y$10$rIuMlCqif2jhmBRImsx0UOEAWcg6b4igAaSoT.Ywmbep2qkMr1wxO', '085321223122', 'masyarakat', NULL, NULL),
(18, '1291928998899990', 'Rangga@gmail.com', 'rnbhb', '$2y$10$VLnBxRTX2RB4J/DXAxL19Ogn3A.LzjYyNEwpVt84g.kpTxJrc2o0u', '091977777777', 'masyarakat', '493a7d0826e9be3ffe9e200daa21c6418fb368df490d538f511a02a1ac25c959', '2025-06-07 20:22:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `id_pengaduan` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('belum_dibaca','sudah_dibaca') DEFAULT 'belum_dibaca',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipe_notifikasi` enum('diproses','selesai','ditolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `id_pengaduan`, `username`, `pesan`, `status`, `tanggal_dibuat`, `tipe_notifikasi`) VALUES
(1, 41, 'rnbhb', 'Laporan ID 41 Anda sedang diproses oleh petugas dan admin', 'sudah_dibaca', '2025-06-08 03:20:20', 'diproses'),
(2, 41, 'rnbhb', 'Laporan ID 41 Anda telah disetujui oleh admin', 'sudah_dibaca', '2025-06-08 03:21:17', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `judul_laporan` varchar(255) NOT NULL,
  `tgl_pengaduan` date DEFAULT NULL,
  `nik` char(16) DEFAULT NULL,
  `isi_laporan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kategori` varchar(16) NOT NULL,
  `status` enum('diproses','ditolak','selesai') DEFAULT 'diproses',
  `username` varchar(25) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `judul_laporan`, `tgl_pengaduan`, `nik`, `isi_laporan`, `foto`, `kategori`, `status`, `username`, `telp`, `alamat`) VALUES
(32, 'Jalanan Rusak', '2025-05-27', '3204122331123123', 'Jalan Rusak di jalan kebaikan', 'h54QBVapJVr2oI58ryzi.jpg', 'Jalan', 'selesai', 'kelompok4', '085321223122', ''),
(33, 'Kabel semrawut', '2025-05-27', '3204122331123123', 'Kabel semrawut di sini', 'LlFfBcxE6DUzyD8ZXXMQ.jpg', 'Listrik', 'ditolak', 'kelompok4', '085321223122', ''),
(35, 'smkn7', '9898-09-08', '1291928998899990', 'nadax', 'r0a5GZ9JFE2LW3egPHPd.jpg', 'indomaret', 'selesai', 'rnbhb', '091977777777', 'jjason'),
(37, 'sublime', '2025-07-11', '1291928998899990', 'w', 'iB6a5IRusyQweJL3dDoH.jpg', 'o', 'diproses', 'rnbhb', '091977777777', 'w'),
(38, 'wawd', '2025-06-24', '1291928998899990', 'w', '2qesRTgNGFTDUGfUXOV5.png', 'po', 'diproses', 'rnbhb', '091977777777', '123'),
(39, 'tets', '2025-06-08', '1291928998899990', '12', 'k53GM8oPCjsSiV09aLxa.jpg', 'Air', 'diproses', 'rnbhb', '091977777777', '12'),
(40, 'jammin', '2025-06-07', '1291928998899990', '00', 'jj8WnxIYi3A6syqtTCru.jpg', 'Air', 'diproses', 'rnbhb', '091977777777', 'm'),
(41, 'Test', '2025-06-08', '1291928998899990', 'ea', 'sUkBzMSoxz9EsOh0O6cp.jpg', 'notif', 'selesai', 'rnbhb', '091977777777', 'ea');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `email` varchar(191) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `level` enum('admin','petugas') DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nik`, `email`, `username`, `password`, `telp`, `level`, `reset_token`, `token_expiry`) VALUES
(17, '3201234567890123', 'admin@gmail.com', 'Adminm', '$2y$10$bKgafy4BThBpek209EPIU.Jxj8Mnlk62s.YwWRhjLI5WI/Q2P0y..', '081234567890', 'admin', NULL, NULL),
(18, '3204421212122122', 'petugas@gmail.com', 'petugas', '$2y$10$QXYeO6FWg7A9cHVtu2LSIOVD2CdcNhvdnUIr.mb5KdB5DXEHKcLFG', '083221223123', 'petugas', '6251c5ec4d81f4922b9f8e853c9d6c628b5434ea9ec019e0561397a7a825d5fa', '2025-06-06 18:58:07'),
(19, '3201377172771888', 'Petugas2@gmail.com', 'petugas2', '$2y$10$d9xL28PkaPO.8Q1pgPyzKOTDmXCQnpiRYrc8eZF.KaLNxhN5PAeSi', '086727736616', 'petugas', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_pengaduan` int(11) DEFAULT NULL,
  `tgl_tanggapan` date DEFAULT NULL,
  `tanggapan` text DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_pengaduan`, `tgl_tanggapan`, `tanggapan`, `id_petugas`) VALUES
(37, 32, '2025-05-26', 'akan segera di perbaiki', 17),
(38, 33, '2025-05-26', 'tidak valid', 17),
(39, 35, '2025-06-08', 'fr fr fr', 17),
(40, 41, '2025-06-08', 'oke', 17);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `masyarakat`
--
ALTER TABLE `masyarakat`
  ADD PRIMARY KEY (`id_masyarakat`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_telp` (`telp`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `FK_notifikasi_pengaduan` (`id_pengaduan`),
  ADD KEY `FK_notifikasi_username` (`username`);

--
-- Indeks untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `FK_pengaduan_masyarakat` (`nik`),
  ADD KEY `FK_pengaduan_username` (`username`),
  ADD KEY `FK_pengaduan_telp` (`telp`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`),
  ADD KEY `pengaduan_tanggapan` (`id_pengaduan`),
  ADD KEY `tanggapan_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `masyarakat`
--
ALTER TABLE `masyarakat`
  MODIFY `id_masyarakat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `FK_notifikasi_pengaduan` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_notifikasi_username` FOREIGN KEY (`username`) REFERENCES `masyarakat` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `FK_pengaduan_masyarakat_nik` FOREIGN KEY (`nik`) REFERENCES `masyarakat` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_pengaduan_telp` FOREIGN KEY (`telp`) REFERENCES `masyarakat` (`telp`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_pengaduan_username` FOREIGN KEY (`username`) REFERENCES `masyarakat` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD CONSTRAINT `pengaduan_tanggapan` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tanggapan_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
