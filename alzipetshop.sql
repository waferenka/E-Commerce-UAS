-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 09:33 AM
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
  `category` enum('Makanan','Peralatan','Aksesoris','Kesehatan','Kebersihan') DEFAULT NULL,
  `satuan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `satuan`) VALUES
(1, 'Bolt - Makanan Kucing', 'Bolt Premium Cat Food adalah pilihan terbaik untuk memenuhi kebutuhan nutrisi harian kucing Anda. Diperkaya dengan formula lengkap dan seimbang, Bolt dirancang untuk menjaga kesehatan kucing Anda, dari bulu yang berkilau hingga energi yang optimal setiap harinya.\r\n\r\nKeunggulan Produk:\r\n\r\nProtein Berkualitas Tinggi: Membantu mendukung pertumbuhan otot yang kuat dan kesehatan tubuh.\r\nKandungan Omega 3 & 6: Memperindah bulu dan menjaga kulit tetap sehat.\r\nSerat Alami: Membantu menjaga sistem pencernaan yang sehat dan mencegah hairball.\r\nVitamin & Mineral Lengkap: Mendukung kekebalan tubuh dan vitalitas kucing Anda.\r\nRasa Lezat: Disukai oleh kucing, membuat waktu makan menjadi momen yang menyenangkan.\r\nTersedia Dalam Berbagai Pilihan Rasa:\r\n\r\nAyam\r\nSalmon\r\nTuna\r\nDaging Sapi\r\nKemasan Praktis:\r\nBolt hadir dalam berbagai ukuran (500g, 1kg, dan 5kg) untuk memenuhi kebutuhan Anda, baik untuk kucing rumahan maupun pemilik dengan banyak kucing.\r\n\r\nDengan Bolt Premium Cat Food, pastikan kucing kesayangan Anda mendapatkan asupan terbaik untuk hidup sehat, bahagia, dan aktif sepanjang hari. 🌟\r\n\r\n\"Bolt, pilihan cerdas untuk kucing sehat dan bahagia!\"', 20000, './imgs/bolt.jpeg', 'Makanan', 'bungkus'),
(2, 'Lezato - Makanan Kucing', 'Lezato Cat Food adalah solusi sempurna untuk kebutuhan nutrisi harian kucing Anda. Dibuat dengan bahan-bahan berkualitas tinggi, Lezato memastikan setiap gigitan dipenuhi dengan kebaikan yang diperlukan untuk kesehatan dan kebahagiaan kucing Anda.\r\n\r\nKeunggulan Produk:\r\n\r\nKaya Protein: Mendukung pertumbuhan otot yang kuat dan memberikan energi optimal.\r\nAsam Lemak Omega: Membantu menjaga bulu tetap lebat dan berkilau, serta kulit sehat.\r\nSerat Alami: Membantu meningkatkan pencernaan dan mencegah masalah hairball.\r\nRasa yang Disukai Kucing: Dengan aroma dan rasa yang menggoda, kucing Anda akan makan dengan lahap.\r\nVitamin dan Mineral Lengkap: Menunjang daya tahan tubuh dan kesehatan organ dalam.\r\nPilihan Rasa yang Menggugah Selera:\r\n\r\nIkan Laut\r\nAyam Kampung\r\nTuna Segar\r\nKemasan Tersedia:\r\nLezato hadir dalam berbagai ukuran kemasan (1kg, 3kg, dan 10kg), cocok untuk kucing tunggal hingga pemilik dengan banyak kucing.\r\n\r\nDengan Lezato Cat Food, berikan kasih sayang terbaik kepada kucing kesayangan Anda dengan makanan bernutrisi tinggi dan rasa lezat yang akan mereka cintai.\r\n\r\n\"Lezato, solusi lezat untuk kucing sehat dan aktif setiap hari!\" 🐾', 22000, './imgs/lezato.jpeg', 'Makanan', 'bungkus'),
(3, 'Ori Cat - Makanan Kucing', 'Ori Cat Food adalah pilihan sempurna untuk pemilik kucing yang mencari makanan berkualitas tinggi dengan harga terjangkau. Diformulasikan secara khusus untuk mendukung kebutuhan gizi kucing Anda, Ori Cat memastikan setiap gigitan memberikan nutrisi seimbang untuk kesehatan dan kebahagiaan mereka.\r\n\r\nKeunggulan Produk:\r\n\r\nProtein Berkualitas Tinggi: Menunjang pertumbuhan dan menjaga kesehatan otot kucing.\r\nFormula Rendah Lemak: Membantu menjaga berat badan ideal dan mencegah obesitas.\r\nKandungan Serat Alami: Membantu memperlancar pencernaan dan mengurangi hairball.\r\nRasa yang Disukai Kucing: Aroma dan rasa yang menggoda, cocok untuk kucing yang pemilih.\r\nDiperkaya Vitamin dan Mineral: Mendukung sistem kekebalan tubuh dan kesehatan gigi.\r\nVarian Rasa yang Tersedia:\r\n\r\nAyam Panggang\r\nIkan Tuna\r\nDaging Sapi\r\nPilihan Kemasan:\r\nOri Cat tersedia dalam berbagai ukuran kemasan (500g, 1kg, dan 5kg) yang sesuai dengan kebutuhan Anda.\r\n\r\nBerikan kasih sayang terbaik untuk kucing Anda dengan Ori Cat Food yang lezat, bernutrisi, dan cocok untuk semua jenis kucing, baik anak kucing maupun dewasa.\r\n\r\n\"Ori Cat, pilihan bijak untuk kucing sehat dan bahagia setiap hari!\" 🐾', 18000, './imgs/oricat.jpeg', 'Makanan', 'bungkus'),
(4, 'Cat Choise - Makanan Kucing', 'Cat Choice Food adalah makanan kucing premium yang dirancang untuk memenuhi kebutuhan nutrisi kucing Anda secara menyeluruh. Dengan bahan-bahan pilihan dan formula khusus, Cat Choice memastikan kucing Anda tetap sehat, aktif, dan bahagia.\r\n\r\nKeunggulan Produk:\r\n\r\nKaya Protein Berkualitas: Membantu mendukung pertumbuhan otot dan kesehatan kucing.\r\nOmega 3 & 6: Untuk menjaga kesehatan kulit dan bulu agar tetap lembut dan berkilau.\r\nSerat Alami: Membantu mengurangi hairball dan menjaga pencernaan yang sehat.\r\nDiperkaya dengan Taurin: Mendukung kesehatan mata dan jantung kucing.\r\nRasa Lezat yang Disukai Kucing: Membuat waktu makan menjadi momen yang dinantikan.\r\nPilihan Varian Rasa:\r\n\r\nAyam\r\nIkan Salmon\r\nDaging Kelinci\r\nKemasan yang Praktis:\r\nCat Choice hadir dalam berbagai ukuran (500g, 1kg, dan 3kg) yang sesuai untuk kebutuhan harian atau stok jangka panjang.\r\n\r\nCocok untuk:\r\n\r\nSemua jenis kucing, baik anak kucing, kucing dewasa, maupun kucing senior.\r\nPemilik yang ingin memberikan makanan bernutrisi tinggi tanpa menguras kantong.\r\n\"Cat Choice, karena kucing Anda layak mendapatkan pilihan terbaik!\" 🐱', 25000, './imgs/catchoise.jpg', 'Makanan', 'bungkus'),
(5, 'Whiskas - Makanan Kucing', 'Whiskas Cat Food adalah makanan kucing terpercaya yang diformulasikan khusus untuk memenuhi kebutuhan gizi kucing pada setiap tahap kehidupannya. Dengan rasa yang lezat dan tekstur yang menarik, Whiskas menjadi pilihan favorit bagi pemilik kucing di seluruh dunia.\r\n\r\nKeunggulan Produk:\r\n\r\nNutrisi Lengkap dan Seimbang: Mendukung kesehatan dan vitalitas kucing setiap hari.\r\nKaya Vitamin dan Mineral: Untuk tulang yang kuat, sistem imun yang sehat, dan energi optimal.\r\nDiperkaya Taurin: Membantu menjaga penglihatan yang tajam dan kesehatan jantung.\r\nOmega 3 & 6: Mendukung kulit sehat dan bulu yang berkilau.\r\nBeragam Tekstur: Tersedia dalam bentuk kering, basah, dan pouch untuk memenuhi preferensi kucing Anda.\r\nPilihan Varian Rasa:\r\n\r\nIkan Tuna\r\nAyam\r\nIkan Laut\r\nDaging Sapi\r\nKemasan yang Praktis dan Beragam:\r\nTersedia dalam ukuran mulai dari 85g hingga 10kg, cocok untuk konsumsi harian atau persediaan jangka panjang.\r\n\r\nCocok untuk:\r\n\r\nAnak kucing, kucing dewasa, hingga kucing senior.\r\nKucing dengan berbagai selera dan kebutuhan khusus.\r\n\"Whiskas, pilihan yang alami untuk kucing kesayangan Anda!\" 🐾', 28000, './imgs/whiskas.jpg', 'Makanan', 'bungkus'),
(7, 'Kandang Kucing', 'Peralatan', 170000, './imgs/kandang.jpg', 'Peralatan', 'buah'),
(13, 'Royal Canin 2KG - Makanan Kucing', 'Royal Canin Cat Food adalah makanan premium yang dirancang khusus untuk memenuhi kebutuhan spesifik kucing berdasarkan usia, ras, gaya hidup, hingga kondisi kesehatannya. Dengan formula yang didukung oleh penelitian ilmiah, Royal Canin menjadi pilihan ideal untuk memberikan nutrisi terbaik bagi kucing kesayangan Anda.\r\n\r\nKeunggulan Produk:\r\n\r\nFormulasi Berdasarkan Kebutuhan Spesifik: Tersedia untuk kucing persia, maine coon, siam, dan ras lainnya, serta kucing dengan kondisi tertentu seperti obesitas atau masalah pencernaan.\r\nNutrisi Lengkap dan Seimbang: Mendukung kesehatan jangka panjang, sistem imun, dan fungsi tubuh optimal.\r\nProtein Berkualitas Tinggi: Sumber energi untuk pertumbuhan dan aktivitas kucing.\r\nKombinasi Vitamin & Mineral yang Tepat: Menjaga kesehatan kulit, bulu, tulang, dan gigi.\r\nTekstur dan Ukuran Kibble Disesuaikan: Mempermudah kucing dalam mengunyah sesuai bentuk rahangnya.\r\nVarian Utama:\r\n\r\nKitten Formula: Untuk mendukung pertumbuhan anak kucing.\r\nAdult Formula: Nutrisi lengkap untuk kucing dewasa aktif.\r\nIndoor Formula: Mengurangi bau feses, ideal untuk kucing yang tidak keluar rumah.\r\nHairball Care: Membantu mencegah hairball pada kucing berbulu panjang.\r\nUrinary Care: Mendukung kesehatan saluran kemih.\r\nKemasan yang Tersedia:\r\nUkuran mulai dari 400g hingga 10kg, cocok untuk kebutuhan harian dan persediaan dalam jumlah besar.\r\n\r\nCocok untuk:\r\n\r\nSemua jenis kucing berdasarkan kebutuhan spesifiknya.\r\nPemilik yang mengutamakan nutrisi premium bagi kucing peliharaan.\r\n\"Royal Canin, pilihan profesional untuk kesehatan kucing yang optimal.\" 🐾', 250000, './imgs/royalcanin.jpg', 'Makanan', 'bungkus');

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
(4, 'Tri Ambar Ningtias', 'ambar@gmail.com', '008599efdcb7822df1c91508d4ab3ee9622b6d5d', 'pembeli');

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
(4, 'path/to/foto4.jpg', 'Perempuan', '1994-04-04', 'Jl. Contoh No. 4', '08123456782');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
