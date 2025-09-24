-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 02:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_akhir`
--

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `public_key` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `username`, `credential_id`, `public_key`, `created_at`) VALUES
(1, 'admin', 'Z7_ubtbFU432L88b1BkWkP1zNf-66C44iQxCaBZ_e9E', 'o2NmbXRkbm9uZWdhdHRTdG10oGhhdXRoRGF0YVikSZYN5YgOjGh0NBcPZHZgW4/krrmihjLHmVzzuoMdl2NFAAAAAAAAAAAAAAAAAAAAAAAAAAAAIGe/7m7WxVON9i/PG9QZFpD9czX/uuguOIkMQmgWf3vRpQECAyYgASFYIBMQ+bdA8lg34V+6perrRAR0BCGtLSankwCdeFW3xEwWIlgg1Ba/WYSWgBEdBdG1CyKwlh8ajKTpLCQn4w2Y7Ywso8g=', '2025-09-11 18:59:17'),
(2, 'admin', 'mnknxDVwT1HjhHxMGlcG5O2ZC8tpYzivXGtQHyKnhw4', 'o2NmbXRkbm9uZWdhdHRTdG10oGhhdXRoRGF0YVikSZYN5YgOjGh0NBcPZHZgW4/krrmihjLHmVzzuoMdl2NFAAAAAAAAAAAAAAAAAAAAAAAAAAAAIJp5J8Q1cE9R44R8TBpXBuTtmQvLaWM4r1xrUB8ip4cOpQECAyYgASFYIJ22gGV9ESfs7PqHUYVtXpRC7q2qm8LOgbUJLyG98DrUIlggOoRMKIAqvV4toVbgJk/XbfdxiH+ozRo1eMGu31tGAB4=', '2025-09-17 01:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` varchar(5) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `kompetensi_keahlian` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES
('1', 'XII', 'RPL');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tgl_pembayaran` date DEFAULT NULL,
  `bulan_tagihan` varchar(20) NOT NULL,
  `tahun_tagihan` int(4) NOT NULL,
  `id_spp` int(11) NOT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL,
  `no_bayar` varchar(20) DEFAULT NULL,
  `keterangan` varchar(20) NOT NULL DEFAULT 'Ditangguhkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `nisn`, `id_petugas`, `tgl_pembayaran`, `bulan_tagihan`, `tahun_tagihan`, `id_spp`, `jumlah_bayar`, `no_bayar`, `keterangan`) VALUES
(25, '456789', NULL, '2025-09-10', 'Juli', 2025, 1, 90000000, 'PAY-1757484152', 'Lunas'),
(26, '456789', NULL, '2025-09-10', 'Agustus', 2025, 1, 90000000, 'PAY-1757484439', 'Lunas'),
(27, '456789', NULL, '2025-09-10', 'September', 2025, 1, 90000000, 'PAY-1757484622', 'Lunas'),
(28, '456789', NULL, '2025-09-10', 'Oktober', 2025, 1, 90000000, 'PAY-1757485491', 'Lunas'),
(29, '456789', NULL, NULL, 'November', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(30, '456789', NULL, NULL, 'Desember', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(31, '456789', NULL, NULL, 'Januari', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(32, '456789', NULL, NULL, 'Februari', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(33, '456789', NULL, NULL, 'Maret', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(34, '456789', NULL, NULL, 'April', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(35, '456789', NULL, NULL, 'Mei', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(36, '456789', NULL, NULL, 'Juni', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(37, '0909090', NULL, '2025-09-10', 'Juli', 2025, 1, 90000000, 'PAY-1757483434', 'Lunas'),
(38, '0909090', NULL, NULL, 'Agustus', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(39, '0909090', NULL, NULL, 'September', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(40, '0909090', NULL, NULL, 'Oktober', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(41, '0909090', NULL, NULL, 'November', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(42, '0909090', NULL, NULL, 'Desember', 2025, 1, 90000000, NULL, 'Ditangguhkan'),
(43, '0909090', NULL, NULL, 'Januari', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(44, '0909090', NULL, NULL, 'Februari', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(45, '0909090', NULL, NULL, 'Maret', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(46, '0909090', NULL, NULL, 'April', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(47, '0909090', NULL, NULL, 'Mei', 2026, 1, 90000000, NULL, 'Ditangguhkan'),
(48, '0909090', NULL, NULL, 'Juni', 2026, 1, 90000000, NULL, 'Ditangguhkan');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` varchar(5) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(300) NOT NULL,
  `nama_petugas` varchar(35) NOT NULL,
  `level` enum('admin','petugas','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
('', 'kkkk', '827ccb0eea8a706c4c34a16891f84e7b', 'alban', 'petugas'),
('A01', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Danu', 'admin'),
('A02', 'Panss', '$2y$10$jyvc4Ay32qgRJP3LyrNCuuPHp9PS', 'Danu', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nisn` varchar(10) NOT NULL,
  `nis` varchar(8) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `id_kelas` varchar(11) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `id_spp` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES
('0909090', '9237', 'Matt', '1', 'jl.ajshd', '9877834857', '001'),
('456789', '76543', 'Ahmad', '1', 'jl.kaosdji3', '0987654321', '001');

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id_spp` varchar(5) NOT NULL,
  `tahun` int(4) NOT NULL,
  `nominal` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id_spp`, `tahun`, `nominal`) VALUES
('001', 2007, 90000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `nisn` (`nisn`,`id_petugas`,`id_spp`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_spp` (`id_spp`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
