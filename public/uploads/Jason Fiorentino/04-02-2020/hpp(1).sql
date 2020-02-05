-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2019 at 03:37 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hpp`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `Id_Aktivitas` int(10) UNSIGNED NOT NULL,
  `Nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aktivitas`
--

INSERT INTO `aktivitas` (`Id_Aktivitas`, `Nama`, `Total`, `created_at`, `updated_at`) VALUES
(1, 'Memotong', 90, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `Id_Bahan_Baku` int(10) UNSIGNED NOT NULL,
  `Nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Harga` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`Id_Bahan_Baku`, `Nama`, `Harga`, `created_at`, `updated_at`) VALUES
(1, 'Kapas', 90, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_penolong`
--

CREATE TABLE `bahan_penolong` (
  `Id_Bahan_Penolong` int(10) UNSIGNED NOT NULL,
  `Nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Harga` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_aktivitas`
--

CREATE TABLE `detail_aktivitas` (
  `Id_Detail_Aktivitas` int(10) UNSIGNED NOT NULL,
  `Id_Overhead` int(10) UNSIGNED NOT NULL,
  `Id_Aktivitas` int(10) UNSIGNED NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_aktivitas`
--

INSERT INTO `detail_aktivitas` (`Id_Detail_Aktivitas`, `Id_Overhead`, `Id_Aktivitas`, `Total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_bahan_baku`
--

CREATE TABLE `detail_bahan_baku` (
  `Id_Detail_Bahan_Baku` int(10) UNSIGNED NOT NULL,
  `Id_Bahan_Baku` int(10) UNSIGNED NOT NULL,
  `Id_Pemesanan` int(10) UNSIGNED NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_bahan_baku`
--

INSERT INTO `detail_bahan_baku` (`Id_Detail_Bahan_Baku`, `Id_Bahan_Baku`, `Id_Pemesanan`, `Jumlah`, `Total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_bp`
--

CREATE TABLE `detail_bp` (
  `Id_Detail_BP` int(10) UNSIGNED NOT NULL,
  `Id_Bahan_Penolong` int(10) UNSIGNED NOT NULL,
  `Id_Detail_Aktivitas` int(10) UNSIGNED NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_overhead`
--

CREATE TABLE `detail_overhead` (
  `Id_Detail_Overhead` int(10) UNSIGNED NOT NULL,
  `Id_Overhead` int(10) UNSIGNED NOT NULL,
  `Nama_Detail_Overhead` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Harga_Detail_Overhead` double NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_overhead`
--

INSERT INTO `detail_overhead` (`Id_Detail_Overhead`, `Id_Overhead`, `Nama_Detail_Overhead`, `Harga_Detail_Overhead`, `Jumlah`, `Total`, `created_at`, `updated_at`) VALUES
(1, 1, 'Biaya Listrik', 2, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_tkl`
--

CREATE TABLE `detail_tkl` (
  `Id_Detail_TKL` int(10) UNSIGNED NOT NULL,
  `Id_TKL` int(10) UNSIGNED NOT NULL,
  `Id_Pemesanan` int(10) UNSIGNED NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_tktl`
--

CREATE TABLE `detail_tktl` (
  `Id_Detail_TKTL` int(10) UNSIGNED NOT NULL,
  `Id_User` int(10) UNSIGNED NOT NULL,
  `Id_Pemesanan` int(10) UNSIGNED NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konsumen`
--

CREATE TABLE `konsumen` (
  `Id_Konsumen` int(10) UNSIGNED NOT NULL,
  `Nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `No_HP` int(11) NOT NULL,
  `Alamat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Jenis_Kelamin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `konsumen`
--

INSERT INTO `konsumen` (`Id_Konsumen`, `Nama`, `No_HP`, `Alamat`, `Jenis_Kelamin`, `created_at`, `updated_at`) VALUES
(1, 'Loly Elia Tamba', 890909090, 'Perempuan', 'Jalan Babarsari', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_06_30_001_create_aktivitas_table', 1),
(2, '2019_06_30_002_create_bahan_penolongs_table', 1),
(3, '2019_06_30_004_create_bahan_bakus_table', 1),
(4, '2019_06_30_005_create_roles_table', 1),
(5, '2019_06_30_006_create_users_table', 1),
(6, '2019_06_30_007_create_konsumens_table', 1),
(7, '2019_06_30_008_create_t_k_l_s_table', 1),
(8, '2019_06_30_009_create_pemesanans_table', 1),
(9, '2019_06_30_010_create_detail_t_k_l_s_table', 1),
(10, '2019_06_30_011_create_detail_t_k_t_l_s_table', 1),
(11, '2019_06_30_012_create_detail_bahan_bakus_table', 1),
(12, '2019_06_30_013_create_overheads_table', 1),
(13, '2019_06_30_014_create_detail_overheads_table', 1),
(14, '2019_06_30_015_create_detail_aktivitas_table', 1),
(15, '2019_06_30_016_create_detail_bahan_penolongs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `overhead`
--

CREATE TABLE `overhead` (
  `Id_Overhead` int(10) UNSIGNED NOT NULL,
  `Id_Pemesanan` int(10) UNSIGNED NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overhead`
--

INSERT INTO `overhead` (`Id_Overhead`, `Id_Pemesanan`, `Total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `Id_Pemesanan` int(10) UNSIGNED NOT NULL,
  `Id_Konsumen` int(10) UNSIGNED NOT NULL,
  `Nama_Produk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tanggal` date NOT NULL,
  `Tanggal_Selesai` date NOT NULL,
  `Lama_Kerja` int(11) NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`Id_Pemesanan`, `Id_Konsumen`, `Nama_Produk`, `Tanggal`, `Tanggal_Selesai`, `Lama_Kerja`, `Jumlah`, `Total`, `created_at`, `updated_at`) VALUES
(1, 1, 'Produk Anying', '0000-00-00', '0000-00-00', 1, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `Id_Role` int(10) UNSIGNED NOT NULL,
  `Roles` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Id_Role`, `Roles`, `created_at`, `updated_at`) VALUES
(1, 'PPC', NULL, NULL),
(2, 'FINANCE', NULL, NULL),
(3, 'PRODUKSI', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tkl`
--

CREATE TABLE `tkl` (
  `Id_TKL` int(10) UNSIGNED NOT NULL,
  `Nama_TKL` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `No_Telp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Alamat_TKL` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Salary` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id_User` int(10) UNSIGNED NOT NULL,
  `Id_Role` int(10) UNSIGNED NOT NULL,
  `Nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Salary` double NOT NULL,
  `No_Telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id_User`, `Id_Role`, `Nama`, `User_Name`, `Password`, `Salary`, `No_Telp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, '11', 'ppc', 'ppc', 10, '1', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`Id_Aktivitas`);

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`Id_Bahan_Baku`);

--
-- Indexes for table `bahan_penolong`
--
ALTER TABLE `bahan_penolong`
  ADD PRIMARY KEY (`Id_Bahan_Penolong`);

--
-- Indexes for table `detail_aktivitas`
--
ALTER TABLE `detail_aktivitas`
  ADD PRIMARY KEY (`Id_Detail_Aktivitas`),
  ADD KEY `detail_aktivitas_id_overhead_foreign` (`Id_Overhead`),
  ADD KEY `detail_aktivitas_id_aktivitas_foreign` (`Id_Aktivitas`);

--
-- Indexes for table `detail_bahan_baku`
--
ALTER TABLE `detail_bahan_baku`
  ADD PRIMARY KEY (`Id_Detail_Bahan_Baku`),
  ADD KEY `detail_bahan_baku_id_pemesanan_foreign` (`Id_Pemesanan`),
  ADD KEY `detail_bahan_baku_id_bahan_baku_foreign` (`Id_Bahan_Baku`);

--
-- Indexes for table `detail_bp`
--
ALTER TABLE `detail_bp`
  ADD PRIMARY KEY (`Id_Detail_BP`),
  ADD KEY `detail_bp_id_bahan_penolong_foreign` (`Id_Bahan_Penolong`),
  ADD KEY `detail_bp_id_detail_aktivitas_foreign` (`Id_Detail_Aktivitas`);

--
-- Indexes for table `detail_overhead`
--
ALTER TABLE `detail_overhead`
  ADD PRIMARY KEY (`Id_Detail_Overhead`),
  ADD KEY `detail_overhead_id_overhead_foreign` (`Id_Overhead`);

--
-- Indexes for table `detail_tkl`
--
ALTER TABLE `detail_tkl`
  ADD PRIMARY KEY (`Id_Detail_TKL`),
  ADD KEY `detail_tkl_id_tkl_foreign` (`Id_TKL`),
  ADD KEY `detail_tkl_id_pemesanan_foreign` (`Id_Pemesanan`);

--
-- Indexes for table `detail_tktl`
--
ALTER TABLE `detail_tktl`
  ADD PRIMARY KEY (`Id_Detail_TKTL`),
  ADD KEY `detail_tktl_id_pemesanan_foreign` (`Id_Pemesanan`),
  ADD KEY `detail_tktl_id_user_foreign` (`Id_User`);

--
-- Indexes for table `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`Id_Konsumen`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overhead`
--
ALTER TABLE `overhead`
  ADD PRIMARY KEY (`Id_Overhead`),
  ADD KEY `overhead_id_pemesanan_foreign` (`Id_Pemesanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`Id_Pemesanan`),
  ADD KEY `pemesanan_id_konsumen_foreign` (`Id_Konsumen`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Id_Role`);

--
-- Indexes for table `tkl`
--
ALTER TABLE `tkl`
  ADD PRIMARY KEY (`Id_TKL`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_User`),
  ADD KEY `user_id_role_foreign` (`Id_Role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `Id_Aktivitas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `Id_Bahan_Baku` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bahan_penolong`
--
ALTER TABLE `bahan_penolong`
  MODIFY `Id_Bahan_Penolong` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_aktivitas`
--
ALTER TABLE `detail_aktivitas`
  MODIFY `Id_Detail_Aktivitas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_bahan_baku`
--
ALTER TABLE `detail_bahan_baku`
  MODIFY `Id_Detail_Bahan_Baku` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_bp`
--
ALTER TABLE `detail_bp`
  MODIFY `Id_Detail_BP` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_overhead`
--
ALTER TABLE `detail_overhead`
  MODIFY `Id_Detail_Overhead` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_tkl`
--
ALTER TABLE `detail_tkl`
  MODIFY `Id_Detail_TKL` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_tktl`
--
ALTER TABLE `detail_tktl`
  MODIFY `Id_Detail_TKTL` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konsumen`
--
ALTER TABLE `konsumen`
  MODIFY `Id_Konsumen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `overhead`
--
ALTER TABLE `overhead`
  MODIFY `Id_Overhead` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `Id_Pemesanan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Id_Role` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tkl`
--
ALTER TABLE `tkl`
  MODIFY `Id_TKL` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id_User` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_aktivitas`
--
ALTER TABLE `detail_aktivitas`
  ADD CONSTRAINT `detail_aktivitas_id_aktivitas_foreign` FOREIGN KEY (`Id_Aktivitas`) REFERENCES `aktivitas` (`Id_Aktivitas`),
  ADD CONSTRAINT `detail_aktivitas_id_overhead_foreign` FOREIGN KEY (`Id_Overhead`) REFERENCES `overhead` (`Id_Overhead`);

--
-- Constraints for table `detail_bahan_baku`
--
ALTER TABLE `detail_bahan_baku`
  ADD CONSTRAINT `detail_bahan_baku_id_bahan_baku_foreign` FOREIGN KEY (`Id_Bahan_Baku`) REFERENCES `bahan_baku` (`Id_Bahan_Baku`),
  ADD CONSTRAINT `detail_bahan_baku_id_pemesanan_foreign` FOREIGN KEY (`Id_Pemesanan`) REFERENCES `pemesanan` (`Id_Pemesanan`);

--
-- Constraints for table `detail_bp`
--
ALTER TABLE `detail_bp`
  ADD CONSTRAINT `detail_bp_id_bahan_penolong_foreign` FOREIGN KEY (`Id_Bahan_Penolong`) REFERENCES `bahan_penolong` (`Id_Bahan_Penolong`),
  ADD CONSTRAINT `detail_bp_id_detail_aktivitas_foreign` FOREIGN KEY (`Id_Detail_Aktivitas`) REFERENCES `detail_aktivitas` (`Id_Detail_Aktivitas`);

--
-- Constraints for table `detail_overhead`
--
ALTER TABLE `detail_overhead`
  ADD CONSTRAINT `detail_overhead_id_overhead_foreign` FOREIGN KEY (`Id_Overhead`) REFERENCES `overhead` (`Id_Overhead`);

--
-- Constraints for table `detail_tkl`
--
ALTER TABLE `detail_tkl`
  ADD CONSTRAINT `detail_tkl_id_pemesanan_foreign` FOREIGN KEY (`Id_Pemesanan`) REFERENCES `pemesanan` (`Id_Pemesanan`),
  ADD CONSTRAINT `detail_tkl_id_tkl_foreign` FOREIGN KEY (`Id_TKL`) REFERENCES `tkl` (`Id_TKL`);

--
-- Constraints for table `detail_tktl`
--
ALTER TABLE `detail_tktl`
  ADD CONSTRAINT `detail_tktl_id_pemesanan_foreign` FOREIGN KEY (`Id_Pemesanan`) REFERENCES `pemesanan` (`Id_Pemesanan`),
  ADD CONSTRAINT `detail_tktl_id_user_foreign` FOREIGN KEY (`Id_User`) REFERENCES `user` (`Id_User`);

--
-- Constraints for table `overhead`
--
ALTER TABLE `overhead`
  ADD CONSTRAINT `overhead_id_pemesanan_foreign` FOREIGN KEY (`Id_Pemesanan`) REFERENCES `pemesanan` (`Id_Pemesanan`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_id_konsumen_foreign` FOREIGN KEY (`Id_Konsumen`) REFERENCES `konsumen` (`Id_Konsumen`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_id_role_foreign` FOREIGN KEY (`Id_Role`) REFERENCES `role` (`Id_Role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
