-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 06:56 AM
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
-- Database: `alzipetshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(6) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`) VALUES
(1, 'Bolt - Makanan Kucing', 'Berikan nutrisi terbaik untuk kucing kesayangan Anda dengan WhiskerMeal Premium Cat Food! Diformulasikan khusus dengan bahan-bahan berkualitas tinggi, makanan ini memberikan asupan gizi seimbang yang mendukung kesehatan dan energi kucing sepanjang hari.\r\n\r\nKeunggulan Produk:\r\n🐾 Protein Berkualitas Tinggi: Mengandung salmon dan tuna asli untuk memenuhi kebutuhan protein harian dan menjaga otot kucing tetap kuat.\r\n🐾 Vitamin & Mineral Lengkap: Diperkaya dengan vitamin A, D, E, serta kalsium untuk mendukung tulang, mata, dan sistem kekebalan tubuh.\r\n🐾 Kaya Omega 3 & 6: Membantu menjaga kesehatan kulit dan bulu agar tetap lembut serta berkilau.\r\n🐾 Tanpa Pewarna & Pengawet Buatan: Aman dikonsumsi setiap hari, bahkan untuk kucing yang sensitif.\r\n🐾 Cocok untuk Semua Usia: Ideal untuk anak kucing hingga kucing dewasa.\r\n\r\nKelezatan dalam Setiap Gigitan:\r\nTekstur renyah yang disukai kucing dengan aroma menggoda membuat kucing Anda selalu bersemangat saat waktu makan tiba.\r\n\r\nKemasan: Tersedia dalam ukuran 1 kg, praktis disimpan dan mudah dibawa.', 12000, 'imgs/a1.png', 'd2'),
(2, 'Lezato - Makanan Kucing', 'makanan', 12000, 'imgs/a2.png', 'd1'),
(3, 'Ori Cat - Makanan Kucing', 'makanan', 12000, 'imgs/a3.png', 'd1'),
(4, 'Cat Choise - Makanan Kucing', 'makanan', 12000, 'imgs/a4.png', 'd1'),
(5, 'Whiskas - Makanan Kucing', 'makanan', 12000, 'imgs/a5.png', 'd1'),
(6, 'Royal Canin - Makanan Kucing', 'makanan', 12000, 'imgs/a6.png', 'd1'),
(7, 'Kandang Kucing', 'Peralatan', 13000, 'imgs/b1.png', 'd3');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(3) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('admin','penjual','pembeli') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `nama`, `email`, `password`, `level`) VALUES
(1, 'Rangga Ayi Pratama', 'rangga@gmail.com', '76e8cc8d7c24f7811041ccb0a1e04e4290bda083', 'admin'),
(2, 'Aditiya Alif As Siddiq', 'adit@gmail.com', 'a368402126ad9e4704fbb1ceac9367ad4e2ccf5f', 'penjual'),
(3, 'M. Andriano Alfarazi', 'aji@gmail.com', '7c33489720fccf682f22f2efb2cefc7aee7de177', 'pembeli'),
(4, 'Tri Ambar Ningtias', 'ambar@gmail.com', '008599efdcb7822df1c91508d4ab3ee9622b6d5d', 'pembeli'),
(7, 'Aditiya Alif As Siddiq', 'adit@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'pembeli'),
(9, 'aaaa', 'adit2@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'pembeli');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `id` int(3) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`id`, `foto`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_telepon`) VALUES
(1, 'imgs/a1.png', 'Laki-laki', '1990-01-01', 'Jl. Contoh No. 1', '08123456789'),
(2, 'imgs/a2.png', 'Laki-laki', '1992-02-02', 'Jl. Contoh No. 2', '08123456780'),
(3, 'path/to/foto3.jpg', 'Laki-laki', '1993-03-03', 'Jl. Contoh No. 3', '08123456781'),
(4, 'path/to/foto4.jpg', 'Perempuan', '1994-04-04', 'Jl. Contoh No. 4', '08123456782'),
(7, 'imgs/user.png', 'Laki-laki', '2005-12-08', 'Kalimantan', '083192655757'),
(9, 'imgs/user.png', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
