CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detail_address` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` enum('Makanan','Peralatan','Aksesoris','Kesehatan','Kebersihan') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `satuan` varchar(200) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `shipping_detail` (
  `id` int NOT NULL,
  `order_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status_pengiriman` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `shipping_status` (
  `id` int NOT NULL,
  `status_pengiriman` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbluser` (
  `id` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('admin','penjual','pembeli') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transactions` (
  `transaction_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transaction_status` enum('pending','success','expire','cancel') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `gross_amount` decimal(10,2) DEFAULT NULL,
  `payment_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `item_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin
) ;

DELIMITER $$
CREATE TRIGGER `after_transaction_insert` AFTER INSERT ON `transactions` FOR EACH ROW BEGIN
  -- Tambahkan data ke tabel shipping_detail
  INSERT INTO `shipping_detail` (`order_id`, `status_pengiriman`)
  VALUES (NEW.order_id, 1); -- 1 adalah ID default dari status 'Menunggu pembayaran' di tabel shipping_status
END
$$
DELIMITER ;

CREATE TABLE `user_detail` (
  `id` int NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_telepon` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `detail_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_address_user` (`user_id`);
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `shipping_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `status_pengiriman` (`status_pengiriman`);
ALTER TABLE `shipping_status`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_transactions_user` (`user_id`),
  ADD KEY `order_id` (`order_id`);
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `detail_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
ALTER TABLE `shipping_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
ALTER TABLE `shipping_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `tbluser`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
ALTER TABLE `transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `detail_address`
  ADD CONSTRAINT `fk_detail_address_user` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
ALTER TABLE `shipping_detail`
  ADD CONSTRAINT `shipping_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `transactions` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_detail_ibfk_2` FOREIGN KEY (`status_pengiriman`) REFERENCES `shipping_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `user_detail`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id`) REFERENCES `tbluser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;