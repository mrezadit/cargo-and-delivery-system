-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Nov 2023 pada 23.39
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengiriman`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `capacity`
--

CREATE TABLE `capacity` (
  `id_capacity` int(11) NOT NULL,
  `schedule` date NOT NULL,
  `id_truck` int(11) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `b_capacity` int(11) NOT NULL,
  `r_capacity` float NOT NULL,
  `t_package` int(11) NOT NULL,
  `receive` int(11) NOT NULL,
  `return` int(11) NOT NULL,
  `cstatus` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `capacity`
--

INSERT INTO `capacity` (`id_capacity`, `schedule`, `id_truck`, `id_driver`, `b_capacity`, `r_capacity`, `t_package`, `receive`, `return`, `cstatus`) VALUES
(1001, '2023-11-12', 1001, 1001, 1500, 5.25, 3, 1, 1, 3),
(1002, '2023-11-11', 1002, 1002, 2800, 12.6, 2, 0, 0, 2),
(1003, '2023-11-13', 1001, 1001, 1550, 4.65, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver`
--

CREATE TABLE `driver` (
  `id_driver` int(11) NOT NULL,
  `driver` varchar(25) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `driver`
--

INSERT INTO `driver` (`id_driver`, `driver`, `phone`, `email`) VALUES
(1001, 'Toreto', '0213231123', 'driver@mail.com'),
(1002, 'Dominic', '0321311', 'drver@mail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kota`
--

CREATE TABLE `kota` (
  `id_kota` int(11) NOT NULL,
  `id_prov` int(11) NOT NULL,
  `kota` varchar(25) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kota`
--

INSERT INTO `kota` (`id_kota`, `id_prov`, `kota`, `priority`) VALUES
(1, 1, 'Tangerang', 1),
(2, 2, 'Jakarta', 2),
(3, 3, 'Bekasi', 3),
(4, 3, 'Depok', 4),
(5, 3, 'Bogor', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `package`
--

CREATE TABLE `package` (
  `id_package` int(11) NOT NULL,
  `no_package` varchar(11) NOT NULL,
  `customer_name` varchar(25) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `address` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `t_kg` int(11) NOT NULL,
  `t_kgv` float NOT NULL,
  `date` date NOT NULL,
  `pstatus` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `package`
--

INSERT INTO `package` (`id_package`, `no_package`, `customer_name`, `phone`, `address`, `id_kota`, `t_kg`, `t_kgv`, `date`, `pstatus`) VALUES
(1001, 'PACK001', 'Reza', '1231231231', 'Tangerang, Banten', 1, 1000, 3.75, '2023-11-11', 4),
(1002, 'PACK002', 'Aditiya', '082132312', 'Jakarta', 2, 500, 1.5, '2023-11-11', 2),
(1003, 'PACK003', 'Rezare', '0984324', 'Tangerang Indah', 1, 1050, 3.15, '2023-11-11', 2),
(1004, 'PACK004', 'Mrezadit', '0896875877', 'Bekasi Bekasi', 3, 2000, 9, '2023-11-11', 2),
(1005, 'PACK005', 'Retza', '027129112', 'Tangerang', 1, 800, 3.6, '2023-11-11', 2),
(1006, 'PACK006', 'Aiya', '098989', 'Tangerang', 1, 250, 0.75, '2023-11-12', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(25) NOT NULL,
  `berat` float NOT NULL,
  `panjang` int(11) NOT NULL,
  `tinggi` int(11) NOT NULL,
  `lebar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id_product`, `product_name`, `berat`, `panjang`, `tinggi`, `lebar`) VALUES
(1001, 'Lemari', 100, 100, 90, 50),
(1002, 'Meja', 50, 100, 30, 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `truck`
--

CREATE TABLE `truck` (
  `id_truck` int(11) NOT NULL,
  `truck` varchar(25) NOT NULL,
  `no_plate` varchar(11) NOT NULL,
  `bmax` int(11) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `truck`
--

INSERT INTO `truck` (`id_truck`, `truck`, `no_plate`, `bmax`, `capacity`) VALUES
(1001, 'Mobil Box', 'B 1234 Tes', 6000, 20),
(1002, 'Mobil Box 2', 'B 1231 DRV', 3000, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL,
  `role` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(3, 'driver', 'driver', 'driver');

-- --------------------------------------------------------

--
-- Struktur dari tabel `v_capacity`
--

CREATE TABLE `v_capacity` (
  `id_vcapacity` int(11) NOT NULL,
  `id_capacity` int(11) NOT NULL,
  `id_package` int(11) NOT NULL,
  `rstatus` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `v_capacity`
--

INSERT INTO `v_capacity` (`id_vcapacity`, `id_capacity`, `id_package`, `rstatus`) VALUES
(1001, 1001, 0, 0),
(1002, 1001, 1001, 2),
(1003, 1001, 1002, 3),
(1005, 1002, 1004, 0),
(1006, 1002, 1005, 0),
(1007, 1003, 1003, 0),
(1008, 1003, 1002, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `v_package`
--

CREATE TABLE `v_package` (
  `id_vpackage` int(11) NOT NULL,
  `id_package` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `t_berat` int(11) NOT NULL,
  `t_volume` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `v_package`
--

INSERT INTO `v_package` (`id_vpackage`, `id_package`, `id_product`, `qty`, `t_berat`, `t_volume`) VALUES
(1001, 1001, 1001, 5, 500, 2.25),
(1002, 1001, 1002, 10, 500, 1.5),
(1003, 1002, 1002, 10, 500, 1.5),
(1004, 1003, 1002, 21, 1050, 3.15),
(1005, 1004, 1001, 20, 2000, 9),
(1006, 1005, 1001, 8, 800, 3.6),
(1007, 1006, 1002, 5, 250, 0.75);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `capacity`
--
ALTER TABLE `capacity`
  ADD PRIMARY KEY (`id_capacity`);

--
-- Indeks untuk tabel `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id_driver`);

--
-- Indeks untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indeks untuk tabel `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id_package`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indeks untuk tabel `truck`
--
ALTER TABLE `truck`
  ADD PRIMARY KEY (`id_truck`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `v_capacity`
--
ALTER TABLE `v_capacity`
  ADD PRIMARY KEY (`id_vcapacity`);

--
-- Indeks untuk tabel `v_package`
--
ALTER TABLE `v_package`
  ADD PRIMARY KEY (`id_vpackage`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
