-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2025 at 11:15 AM
-- Server version: 8.0.40
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` enum('Makanan','Peralatan','Aksesoris','Kesehatan','Kebersihan') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `satuan` varchar(200) COLLATE utf8mb4_general_ci NOT NULL
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
(7, 'Kandang Kucing', 'Kandang Kucing Multifungsi adalah solusi praktis untuk memastikan kenyamanan dan keamanan kucing kesayangan Anda. Dirancang dengan bahan berkualitas dan fitur modern, kandang ini cocok digunakan di dalam maupun luar ruangan. Tersedia dalam berbagai ukuran untuk memenuhi kebutuhan kucing Anda, baik yang masih kitten maupun dewasa.\r\n\r\nKeunggulan Produk:\r\n\r\nBahan Tahan Lama: Terbuat dari besi anti karat atau plastik tebal yang mudah dibersihkan.\r\nDesain Aman: Jarak antar jeruji dirancang aman untuk mencegah kucing terjepit.\r\nVentilasi Maksimal: Memberikan sirkulasi udara yang baik untuk kenyamanan kucing.\r\nPintu Ganda dengan Kunci Pengaman: Memudahkan akses sekaligus menjaga keamanan kucing.\r\nBaki Alas yang Bisa Dilepas: Mempermudah proses pembersihan kotoran.\r\nFitur Lipat (Foldable): Mudah disimpan dan dibawa saat bepergian.\r\nVarian Ukuran:\r\n\r\nKecil (60x40x40 cm): Cocok untuk kitten atau kucing kecil.\r\nSedang (90x60x60 cm): Ideal untuk satu atau dua kucing dewasa.\r\nBesar (120x90x90 cm): Untuk kucing besar atau digunakan sebagai kandang multi-level.\r\nPilihan Fitur Tambahan:\r\n\r\nMulti-Level: Dilengkapi dengan tangga dan platform untuk bermain.\r\nRoda Berputar: Memudahkan Anda memindahkan kandang.\r\nTirai Penutup: Memberikan privasi dan melindungi kucing dari angin atau sinar matahari langsung.\r\nCocok untuk:\r\n\r\nTempat tinggal sementara, saat perjalanan, atau ketika kucing perlu isolasi karena sakit.\r\nPemilik kucing yang mengutamakan kebersihan dan keamanan peliharaan.\r\n\"Kandang kucing yang nyaman dan aman, memberikan ketenangan hati untuk Anda dan kebahagiaan untuk kucing kesayangan.\" 🐾', 170000, './imgs/kandang.jpg', 'Peralatan', 'buah'),
(13, 'Royal Canin 2KG - Makanan Kucing', 'Royal Canin Cat Food adalah makanan premium yang dirancang khusus untuk memenuhi kebutuhan spesifik kucing berdasarkan usia, ras, gaya hidup, hingga kondisi kesehatannya. Dengan formula yang didukung oleh penelitian ilmiah, Royal Canin menjadi pilihan ideal untuk memberikan nutrisi terbaik bagi kucing kesayangan Anda.\r\n\r\nKeunggulan Produk:\r\n\r\nFormulasi Berdasarkan Kebutuhan Spesifik: Tersedia untuk kucing persia, maine coon, siam, dan ras lainnya, serta kucing dengan kondisi tertentu seperti obesitas atau masalah pencernaan.\r\nNutrisi Lengkap dan Seimbang: Mendukung kesehatan jangka panjang, sistem imun, dan fungsi tubuh optimal.\r\nProtein Berkualitas Tinggi: Sumber energi untuk pertumbuhan dan aktivitas kucing.\r\nKombinasi Vitamin & Mineral yang Tepat: Menjaga kesehatan kulit, bulu, tulang, dan gigi.\r\nTekstur dan Ukuran Kibble Disesuaikan: Mempermudah kucing dalam mengunyah sesuai bentuk rahangnya.\r\nVarian Utama:\r\n\r\nKitten Formula: Untuk mendukung pertumbuhan anak kucing.\r\nAdult Formula: Nutrisi lengkap untuk kucing dewasa aktif.\r\nIndoor Formula: Mengurangi bau feses, ideal untuk kucing yang tidak keluar rumah.\r\nHairball Care: Membantu mencegah hairball pada kucing berbulu panjang.\r\nUrinary Care: Mendukung kesehatan saluran kemih.\r\nKemasan yang Tersedia:\r\nUkuran mulai dari 400g hingga 10kg, cocok untuk kebutuhan harian dan persediaan dalam jumlah besar.\r\n\r\nCocok untuk:\r\n\r\nSemua jenis kucing berdasarkan kebutuhan spesifiknya.\r\nPemilik yang mengutamakan nutrisi premium bagi kucing peliharaan.\r\n\"Royal Canin, pilihan profesional untuk kesehatan kucing yang optimal.\" 🐾', 250000, './imgs/royalcanin.jpg', 'Makanan', 'bungkus'),
(14, 'Sekop Pasir Kucing', 'Sekop Pasir Kucing Praktis adalah alat penting untuk menjaga kebersihan litter box kucing Anda. Dirancang khusus dengan bentuk dan ukuran yang memudahkan Anda menyaring kotoran sekaligus menghemat pasir kucing.\r\n\r\nKeunggulan Produk:\r\n\r\nBahan Tahan Lama: Terbuat dari plastik tebal atau logam berkualitas tinggi, sehingga tidak mudah patah atau bengkok.\r\nDesain Ergonomis: Pegangan nyaman untuk digenggam, memudahkan Anda saat membersihkan litter box.\r\nSaringan Optimal: Lubang saringan dengan ukuran yang pas untuk memisahkan kotoran dari pasir.\r\nMudah Dibersihkan: Permukaan sekop anti lengket, sehingga tidak meninggalkan bau atau residu.\r\nRingan dan Praktis: Cocok digunakan di rumah atau saat bepergian.\r\nPilihan Varian:\r\n\r\nSekop Standar: Ukuran sedang untuk litter box kecil atau medium.\r\nSekop Besar: Untuk litter box besar, cocok untuk pemilik beberapa kucing.\r\nSekop dengan Wadah Penampung: Dilengkapi dengan tempat penampungan untuk mempermudah pembuangan kotoran.\r\nManfaat:\r\n\r\nMembantu menjaga kebersihan litter box dengan cepat dan efisien.\r\nMeminimalkan pemborosan pasir kucing.\r\nMencegah bau tidak sedap di sekitar area litter box.\r\nCocok untuk:\r\n\r\nSemua jenis pasir kucing, termasuk pasir gumpal, kristal, atau biodegradable.\r\n\"Bersihkan litter box dengan mudah dan cepat, karena kebersihan adalah kunci kenyamanan kucing Anda!\" 🐾', 6000, './imgs/sekop.jpeg', 'Peralatan', 'buah'),
(15, 'Wadah Pasir', 'Wadah Pasir Kucing Premium adalah perlengkapan esensial untuk menjaga kebersihan dan kenyamanan kucing Anda saat melakukan kebutuhan. Dirancang dengan material berkualitas tinggi dan desain yang fungsional, produk ini cocok untuk segala jenis kucing dan berbagai jenis pasir.\r\n\r\nKeunggulan Produk:\r\n\r\nBahan Berkualitas: Terbuat dari plastik tebal yang tahan lama, tidak mudah retak, dan aman untuk kucing.\r\nDesain Ergonomis:\r\nTepi rendah untuk memudahkan kucing masuk dan keluar.\r\nBeberapa model dilengkapi penutup untuk mengurangi penyebaran bau dan pasir.\r\nAnti Bocor: Permukaan bawah tahan air sehingga menjaga kebersihan lantai rumah Anda.\r\nMudah Dibersihkan: Permukaan halus yang mempermudah proses pencucian.\r\nTersedia dalam Berbagai Ukuran:\r\nUkuran kecil untuk anak kucing atau ruangan terbatas.\r\nUkuran besar untuk kucing dewasa atau multi-kucing.\r\nPilihan Varian:\r\n\r\nWadah Pasir Terbuka: Cocok untuk kucing yang suka ruang terbuka.\r\nWadah Pasir Tertutup: Dilengkapi dengan pintu flap untuk menjaga privasi dan mengurangi bau.\r\nWadah Pasir Otomatis: Dilengkapi dengan fitur penyaringan otomatis untuk kebersihan maksimal.\r\nManfaat:\r\n\r\nMemberikan kenyamanan optimal untuk kucing saat menggunakan litter box.\r\nMenjaga kebersihan lingkungan rumah.\r\nMeminimalkan penyebaran bau dan pasir di sekitar area litter box.\r\n\"Berikan kucing Anda wadah pasir terbaik, karena kenyamanan mereka adalah prioritas utama!\" 🐾', 15000, './imgs/wadahpasir.jpeg', 'Peralatan', 'buah'),
(16, 'Kalung Kucing', 'Kalung Kucing Fashionable adalah aksesori lucu sekaligus fungsional yang dirancang untuk mempercantik penampilan kucing Anda. Tersedia dalam berbagai model dan warna menarik, kalung ini juga memberikan identitas tambahan untuk peliharaan kesayangan Anda.\r\n\r\nKeunggulan Produk:\r\nMaterial Berkualitas:\r\n\r\nTerbuat dari bahan lembut seperti nylon, kulit sintetis, atau kain katun yang nyaman dan tidak menyebabkan iritasi pada leher kucing.\r\nDilengkapi dengan pengunci yang aman dan mudah dilepas pasang.\r\nDesain Menarik:\r\n\r\nBerbagai pilihan motif, seperti polos, bergaris, bunga, hingga karakter lucu.\r\nDilengkapi dengan lonceng kecil yang membantu mengetahui posisi kucing Anda.\r\nUkuran Adjustable:\r\n\r\nDapat disesuaikan dengan ukuran leher kucing, cocok untuk semua ras kucing, mulai dari anak kucing hingga dewasa.\r\nFungsi Tambahan:\r\n\r\nBeberapa model dilengkapi dengan slot untuk menambahkan nama atau nomor telepon pemilik.\r\nOpsi reflective (memantulkan cahaya) untuk memastikan kucing tetap terlihat di malam hari.\r\nRingan dan Aman:\r\n\r\nDesain ringan sehingga kucing tetap nyaman bermain.\r\nPengunci quick-release untuk mencegah kucing terjebak jika kalung tersangkut.', 5000, './imgs/kalung.jpg', 'Aksesoris', 'buah'),
(17, 'Obat Flu dan Pilek', 'Obat Flu Kucing adalah solusi khusus untuk membantu mengatasi flu pada kucing peliharaan Anda. Dirancang oleh ahli kesehatan hewan, obat ini diformulasikan untuk meredakan gejala flu seperti bersin, hidung tersumbat, dan lemas pada kucing, sekaligus meningkatkan daya tahan tubuh mereka.\r\n\r\nKeunggulan Produk:\r\nFormula Khusus:\r\n\r\nMengandung bahan aktif yang aman untuk kucing, seperti vitamin C, ekstrak herbal, dan imunostimulan.\r\nTidak mengandung bahan berbahaya atau menyebabkan ketergantungan.\r\nMeredakan Gejala Flu:\r\n\r\nMembantu mengurangi bersin, hidung berair, mata berair, dan demam.\r\nEfektif mempercepat pemulihan kucing yang terkena flu.\r\nMeningkatkan Imunitas:\r\n\r\nDiperkaya dengan nutrisi tambahan untuk memperkuat daya tahan tubuh.\r\nMembantu mencegah flu berulang.\r\nMudah Digunakan:\r\n\r\nTersedia dalam bentuk sirup cair yang mudah dicampur dengan makanan atau air minum.\r\nBeberapa varian juga tersedia dalam bentuk tablet kecil yang mudah ditelan.\r\nAman untuk Semua Usia:\r\n\r\nCocok digunakan untuk anak kucing hingga kucing dewasa.\r\nPetunjuk Penggunaan:\r\nDosis Umum:\r\nSesuai petunjuk dokter hewan atau instruksi pada kemasan (berdasarkan berat badan kucing).\r\nCara Pemberian:\r\nCampurkan ke makanan atau berikan langsung dengan spuit/dropper.\r\nPastikan kucing minum cukup air selama masa pengobatan.\r\nCatatan Penting:\r\nSebelum menggunakan, konsultasikan dengan dokter hewan jika kucing memiliki riwayat alergi atau sedang mengonsumsi obat lain.\r\nHanya untuk pengobatan flu ringan. Jika gejala berlanjut atau memburuk dalam 2–3 hari, segera bawa kucing ke dokter hewan.\r\n\"Bantu kucing kesayangan Anda kembali aktif dan sehat dengan perawatan terbaik!\" 🐾', 15000, './imgs/flu.jpeg', 'Kesehatan', 'botol'),
(18, 'Obat Batuk', 'Obat Batuk Kucing adalah solusi aman dan efektif untuk membantu mengatasi batuk pada kucing kesayangan Anda. Dirancang dengan formula khusus, obat ini membantu meredakan batuk yang disebabkan oleh infeksi ringan, iritasi tenggorokan, atau alergi, sekaligus meningkatkan kesehatan pernapasan kucing.\r\n\r\nKeunggulan Produk:\r\nFormula Aman dan Efektif:\r\n\r\nMengandung bahan herbal alami seperti ekstrak madu, licorice, dan jahe.\r\nBebas dari bahan kimia keras yang berpotensi berbahaya bagi kucing.\r\nMeredakan Batuk dengan Cepat:\r\n\r\nMembantu mengurangi frekuensi batuk dan menenangkan iritasi tenggorokan.\r\nEfektif untuk batuk basah maupun batuk kering.\r\nMeningkatkan Kesehatan Pernapasan:\r\n\r\nMengandung vitamin dan antioksidan untuk menjaga kesehatan saluran pernapasan.\r\nMudah Digunakan:\r\n\r\nTersedia dalam bentuk sirup cair yang ramah kucing dengan rasa manis alami dari madu.\r\nBeberapa varian juga tersedia dalam bentuk tablet kunyah atau serbuk yang mudah dicampur dengan makanan.\r\nCocok untuk Semua Usia:\r\n\r\nAman digunakan untuk anak kucing, kucing dewasa, maupun kucing senior.\r\nPetunjuk Penggunaan:\r\nDosis Umum:\r\nBerikan sesuai petunjuk dokter hewan atau sesuai instruksi pada kemasan (biasanya berdasarkan berat badan kucing).\r\nCara Pemberian:\r\nBerikan langsung menggunakan spuit/dropper atau campurkan ke makanan basah.\r\nPastikan kucing cukup terhidrasi selama pengobatan.\r\nCatatan Penting:\r\nObat ini dirancang untuk batuk ringan atau sementara.\r\nJika batuk disertai gejala lain seperti demam, lemas, atau sulit bernapas, segera konsultasikan ke dokter hewan.\r\nSimpan di tempat sejuk dan jauh dari jangkauan anak-anak.\r\n\"Bantu kucing Anda bernapas lega dan nyaman dengan perawatan terbaik!\" 🐾', 15000, './imgs/batuk.png', 'Kesehatan', 'botol'),
(19, 'Pasir Kucing', 'Pasir Kucing Berkualitas dirancang untuk memenuhi kebutuhan kucing dan pemiliknya dengan memberikan solusi praktis dan higienis untuk pengelolaan kotoran kucing. Tersedia dalam berbagai jenis dan ukuran, pasir kucing ini memberikan kenyamanan ekstra untuk kucing kesayangan Anda.\r\n\r\nKeunggulan Produk:\r\nDaya Serap Tinggi:\r\n\r\nEfektif menyerap cairan dan mengurangi bau tidak sedap.\r\nMenjaga area tetap kering dan nyaman untuk kucing.\r\nPengendalian Bau Optimal:\r\n\r\nMengandung teknologi deodorizer atau bahan alami untuk mengurangi bau.\r\nCocok untuk digunakan di ruang tertutup.\r\nPilihan Bahan:\r\n\r\nPasir Bentonit: Menggumpal dengan kuat sehingga mudah dibersihkan.\r\nPasir Kristal Silika: Super ringan, tahan lama, dan hemat pemakaian.\r\nPasir Organik (Tofu): Ramah lingkungan, terbuat dari bahan alami seperti kedelai.\r\nPasir Zeolit: Ekonomis dan efektif dalam mengurangi bau.\r\nAman untuk Kucing:\r\n\r\nTidak berdebu sehingga aman untuk pernapasan kucing.\r\nBebas dari bahan kimia berbahaya.\r\nMudah Digunakan:\r\n\r\nGumpalan kotoran mudah dibuang, tidak perlu mengganti semua pasir setiap hari.\r\nTersedia dalam berbagai kemasan sesuai kebutuhan Anda (5 kg, 10 kg, atau lebih).\r\nCara Penggunaan:\r\nIsi wadah pasir dengan pasir setinggi 5–7 cm.\r\nBuang gumpalan kotoran setiap hari menggunakan sekop pasir.\r\nTambahkan pasir baru secara berkala untuk menjaga kebersihan.\r\nGanti seluruh pasir setiap 1–2 minggu untuk hasil terbaik.\r\nTips Memilih Pasir Kucing yang Tepat:\r\nPilih jenis pasir sesuai preferensi kucing Anda.\r\nJika kucing sensitif atau memiliki alergi, pilih pasir organik atau rendah debu.\r\nPertimbangkan tingkat kepraktisan dan kebutuhan, misalnya pasir yang menggumpal untuk pembersihan lebih cepat.\r\n\"Berikan kenyamanan maksimal bagi kucing kesayangan Anda dengan pasir berkualitas tinggi yang praktis dan higienis!\" 🐾', 34000, './imgs/pasir.jpg', 'Kebersihan', 'pack'),
(22, 'ab', 'as', 100, './imgs/CRiMgxd-abstract-wallpaper-hd.jpg', 'Makanan', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('admin','penjual','pembeli') COLLATE utf8mb4_general_ci NOT NULL
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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `transaction_status` enum('pending','settlement','expire','cancel') DEFAULT 'pending',
  `gross_amount` decimal(10,2) NOT NULL,
  `payment_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `id` int NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_telepon` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`id`, `foto`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_telepon`) VALUES
(1, 'imgs/user/rangga_gmail_com.jpg', 'Laki-laki', '1990-01-01', 'Jl. Contoh No. 1', '08123456789'),
(2, 'imgs/a2.png', 'Laki-laki', '1992-02-02', 'Jl. Contoh No. 2', '08123456780'),
(3, 'imgs/user.png', 'Laki-laki', '1993-03-03', 'Jl. Contoh No. 3', '08123456781'),
(4, 'imgs/user.png', 'Perempuan', '1994-04-04', 'Jl. Contoh No. 4', '08123456782');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

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
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
