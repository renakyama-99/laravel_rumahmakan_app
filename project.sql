-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Okt 2023 pada 03.20
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cob`
--

CREATE TABLE `cob` (
  `code` varchar(5) NOT NULL,
  `tgl` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cob`
--

INSERT INTO `cob` (`code`, `tgl`) VALUES
('P0001', NULL),
('P0001', '2023-09-30 10:50:34'),
('P0001', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblprimary`
--

CREATE TABLE `tblprimary` (
  `kode_temp` varchar(5) NOT NULL,
  `nama_temp` text NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telpon` varchar(14) NOT NULL,
  `kode_pos` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tblprimary`
--

INSERT INTO `tblprimary` (`kode_temp`, `nama_temp`, `alamat`, `email`, `no_telpon`, `kode_pos`) VALUES
('P0001', 'SOP SAUDARA YUSUF BAUTY', 'JL YUSUF BAUTY BLOK A 1 NO 5', 'ren.akyama@gmail.com', '082337005702', '92113');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `kode_temp` varchar(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `level` varchar(10) NOT NULL,
  `verifyat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`kode_temp`, `email`, `user_id`, `password`, `level`, `verifyat`) VALUES
('P0001', 'ren.akyama@gmail.com', 'naim001', 'e10adc3949ba59abbe56e057f20f883e', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tblprimary`
--
ALTER TABLE `tblprimary`
  ADD PRIMARY KEY (`kode_temp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
