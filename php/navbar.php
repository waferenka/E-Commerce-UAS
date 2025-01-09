<?php 
    require 'midtrans_config.php'; // Konfigurasi Midtrans
	$user_id = $_SESSION['userid'];
	$user_level = $_SESSION['level'];
	$restricted_levels = ['admin', 'penjual'];
	// Query untuk mengambil data dari tabel cart berdasarkan user_id

	// Ambil data keranjang untuk Midtrans
	$items = [];
	$total_price_midtrans = 0;  // Total price untuk Midtrans
	$querycart = "
	    SELECT c.product_id, p.name AS product_name, p.image, c.quantity, p.price, (c.quantity * p.price) AS total_price 
	    FROM cart c
	    JOIN products p ON c.product_id = p.id
	    WHERE c.user_id = '$user_id'
	";

	$resultcart = mysqli_query($conn, $querycart);
	while ($rowc = mysqli_fetch_assoc($resultcart)) {
    if ($rowc['price'] > 0 && $rowc['quantity'] > 0) {
        $total_price_midtrans += $rowc['total_price'];
        $items[] = [
            'id' => $rowc['product_id'],
            'price' => $rowc['price'],
            'quantity' => $rowc['quantity'],
            'name' => $rowc['product_name']
        ];
    }
}

	// Ambil data keranjang untuk tampilan modal (tanpa menghitung total price lagi)
	$querycart_display = "
	    SELECT c.id AS cart_id, c.product_id, p.name AS product_name, p.image, c.quantity, p.price 
	    FROM cart c
	    JOIN products p ON c.product_id = p.id
	    WHERE c.user_id = '$user_id'
	";
	$resultcart_display = mysqli_query($conn, $querycart_display);


	$total_price_display = 0; // Total price untuk tampilan modal

	// Ambil informasi user dari tabel tbluser dan user_detail
	$query_user = "
	    SELECT u.nama, u.email, d.alamat, d.no_telepon
	    FROM tbluser u
	    JOIN user_detail d ON u.id = d.id
	    WHERE u.id = '$user_id'
	";
    
	$result_user = mysqli_query($conn, $query_user);
	$user = mysqli_fetch_assoc($result_user);

    // Periksa apakah keranjang kosong
    $snap_token = null; // Default nilai token
    if (!empty($items) && $total_price_midtrans > 0) {
        // Data transaksi jika keranjang tidak kosong
        $transaction_details = [
            'order_id' => rand(),
            'gross_amount' => $total_price_midtrans
        ];

        $customer_details = [
            'first_name' => $user['nama'],
            'email' => $user['email'],
            'phone' => $user['no_telepon'],
            'shipping_address' => $user['alamat']
        ];

       $transaction_data = [
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $items // Ini adalah array data produk
];



        // Dapatkan token Snap dari Midtrans
        try {
            // Ubah items menjadi JSON
$item_details_json = json_encode($items);

// Simpan transaksi ke database
$stmt = $conn->prepare("INSERT INTO transactions (order_id, payment_type, transaction_status, gross_amount, item_details) 
                       VALUES (?, ?, ?, ?, ?)");
$payment_status = 'success'; // Status transaksi awal
$payment_type = 'credit_card'; // Tipe pembayaran yang digunakan
$stmt->bind_param("sssss", 
                  $transaction_details['order_id'],
                  $payment_type,
                  $payment_status, 
                  $transaction_details['gross_amount'],
                  $item_details_json); // Masukkan JSON data produk

$stmt->execute();
$stmt->close();
            $snap_token = \Midtrans\Snap::getSnapToken($transaction_data);
        } catch (Exception $e) {
            error_log("Midtrans Error: " . $e->getMessage());
            $snap_token = null;
        }
    } else {
        // Keranjang kosong, tidak ada transaksi
        $transaction_data = null; // Tidak ada data transaksi
    }


	// Update Cart
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Pastikan data 'quantity' diterima sebagai array
		if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
			foreach ($_POST['quantity'] as $product_id => $quantity) {
				$product_id = intval($product_id); // Pastikan product_id adalah integer
				$quantity = max(1, intval($quantity)); // Pastikan quantity minimal 1
	
				// Update jumlah barang dalam tabel cart
				$updateQuery = "UPDATE cart SET quantity = ?, price = (SELECT price FROM products WHERE id = ?) * ? WHERE product_id = ? AND user_id = ?";
				$stmt = $conn->prepare($updateQuery);
				if ($stmt) {
					$stmt->bind_param("iiiii", $quantity, $product_id, $quantity, $product_id, $user_id);
					$stmt->execute();
					$stmt->close();
				} else {
					echo "Kesalahan saat mempersiapkan query: " . $conn->error;
				}
			}
			header("Location: #"); // Redirect ke halaman keranjang
			exit;
		} else {
			
		}
	}
    $queryriwayat = "SELECT * FROM `transactions`";
    $resultriwayat = $conn->query($queryriwayat);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-A2jiukqkqsZik1Kl">
    </script>
    <style>
    .modal-body {
        font-family: Arial, sans-serif;
    }

    .cart-item {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
    }

    .cart-image img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 10px;
    }

    .cart-details {
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: space-between;
    }

    .product-name {
        font-weight: bold;
        margin-right: auto;
    }

    .product-price {
        margin-left: 10px;
        color: #555;
    }

    .quantity-control {
        display: flex;
        align-items: center;
    }

    .quantity-control input {
        width: 50px;
        margin-left: 5px;
        text-align: center;
    }

    .delete-link {
        color: red;
        text-decoration: none;
        margin-left: 10px;
        font-size: 0.9em;
    }

    .delete-link:hover {
        text-decoration: underline;
    }

    .total-price {
        font-size: 1.2em;
        text-align: right;
        margin-top: 10px;
        font-weight: bold;
    }

    .cart-actions {
        text-align: center;
        margin-top: 15px;
    }

    /* .cart-actions button {
        padding: 10px 20px;
        font-size: 1em;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .cart-actions button:hover {
        background-color: #218838;
    } */
    </style>
</head>

<body>
    <!-- Navbar, Search, Keranjang, User -->
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand ms-2 font-weight-bold" href="index_p.php">
                Alzi Petshop
            </a>
            <?php if (!in_array($user_level, $restricted_levels)): ?>
            <div class="search-box me-3">
                <input type="text" id="searchInput" placeholder="Cari produk..." autocomplete="off">
                <div class="search-dropdown" id="searchResults"></div>
            </div>
            <?php endif; ?>
            <?php if ($user_level == 'penjual'): ?>
            <div class="d-flex">
                <a href="tambah.php" class="btn btn-warning me-1" id="tambah">Tambah</a>
            </div>
            <?php endif; ?>
            <div class="navbar-item">
                <?php if (!in_array($user_level, $restricted_levels)): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#riwayatModal" class="me-3 fw-bold">Riwayat</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#keranjangModal">
                    <img src="imgs/cart.png" alt="Keranjang" class="me-2">
                </a>
                <?php endif; ?>
                <a href="detail.php">
                    <img src="<?php echo $foto; ?>" class="rounded-circle me-2">
                    <span id="user"><?php echo getFirstName($nama); ?></span>
                </a>
            </div>
        </div>
    </nav>
    <!-- End Navbar, Search, Keranjang, User -->
    <!-- Keranjang -->
    <div class="modal fade" id="keranjangModal" tabindex="-1" aria-labelledby="keranjangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="keranjangModalLabel">Keranjang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <?php while ($row = mysqli_fetch_assoc($resultcart_display)): ?>
                        <div class="cart-item">
                            <div class="cart-image">
                                <img src="<?= $row['image']; ?>" alt="<?= $row['product_name']; ?>">
                            </div>
                            <div class="cart-details">
                                <p class="product-name"><?= $row['product_name']; ?></p>
                                <p class="product-price">Rp<?= number_format($row['price'], 0, ',', '.'); ?></p>
                                <div class="quantity-control">
                                    <input type="number" id="quantity-<?= $row['product_id']; ?>"
                                        name="quantity[<?= $row['product_id']; ?>]" value="<?= $row['quantity']; ?>"
                                        min="1">
                                </div>
                                <a href="delete_cart_item.php?product_id=<?= $row['product_id']; ?>"
                                    onclick="return confirm('Hapus produk ini?')" class="delete-link">Hapus</a>
                            </div>
                        </div>
                        <?php 
						    $total_price_display += $row['price'] * $row['quantity']; // Hitung total price untuk tampilan modal
						endwhile; ?>
                        <p class="total-price">Total Belanja: Rp<?= number_format($total_price_display, 0, ',', '.'); ?>
                        </p>
                        <div class="cart-actions container-fluid d-flex justify-content-between">
                            <button class="btn btn-warning" type="submit">Update Keranjang</button>
                            <a class="btn btn-success" type="checkout" id="pay-button">Checkout</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End keranjang -->
    <!-- Modal Riwayat -->
    <div class="modal fade" id="riwayatModal" tabindex="-1" aria-labelledby="riwayatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="riwayatModalLabel">Riwayat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="text-center">Transactions Table</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Transaction ID</th>
            <th>Order ID</th>
            <th>Payment Type</th>
            <th>Transaction Status</th>
            <th>Gross Amount</th>
            <th>Payment Time</th>
            <th>Update Time</th>
            <th>Item Details</th> <!-- Menambahkan kolom untuk item details -->
        </tr>
    </thead>
    <tbody>
        <?php if ($resultriwayat && $resultriwayat->num_rows > 0): ?>
            <?php while ($row = $resultriwayat->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['transaction_id']); ?></td>
                    <td><?= htmlspecialchars($row['order_id']); ?></td>
                    <td><?= htmlspecialchars($row['payment_type']); ?></td>
                    <td><?= htmlspecialchars($row['transaction_status']); ?></td>
                    <td><?= htmlspecialchars($row['gross_amount']); ?></td>
                    <td><?= htmlspecialchars($row['payment_time']); ?></td>
                    <td><?= htmlspecialchars($row['update_time']); ?></td>

                    <?php 
                    // Decode item_details JSON
                    $item_details = json_decode($row['item_details'], true);
                    if ($item_details): ?>
                        <td>
                            <ul>
                                <?php foreach ($item_details as $item): ?>
                                    <li>
                                        <?= htmlspecialchars($item['name']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    <?php else: ?>
                        <td>No items found</td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No transactions found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        window.snap.pay('<?= $snap_token; ?>', {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                console.log(result);
                window.location.href = "#";
            },
            onPending: function(result) {
                alert("Menunggu pembayaran.");
                console.log(result);
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
                console.log(result);
            }
        });
    });
    </script>

    <!-- Js Search -->
    <!-- TODO: Pisahke kode ini di file script yang berbeda(External) -->
    <script>
    const products = <?php echo json_encode($products); ?>;
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value.toLowerCase().trim();

        searchResults.innerHTML = '';

        if (query.length > 0) {
            const filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(query)
            );

            if (filteredProducts.length > 0) {
                searchResults.style.display = 'block';
                filteredProducts.forEach(product => {
                    const item = document.createElement('div');
                    item.classList.add('item');
                    item.innerHTML = `
	                                <img src="${product.image}" loading:="lazy" alt="${product.name}" class="item-image">
	                                <div class="item-details">
	                                    <h5>${product.name}</h5>
	                                    <span>Rp${product.price.toLocaleString()}</span>
	                                </div>
	                            `;
                    item.addEventListener('click', () => {
                        window.location.href = `produk.php?product_id=${product.id}`;
                    });
                    searchResults.appendChild(item);
                });
            } else {
                searchResults.style.display = 'none';
            }
        } else {
            searchResults.style.display = 'none';
        }
    });

    // searchInput.addEventListener('blur', function() {
    //     searchInput.value = '';
    //     searchResults.style.display = 'none';
    // });
    document.addEventListener('DOMContentLoaded', function() {
        const keranjangButton = document.querySelector('#keranjangButton'); // ID tombol keranjang
        const keranjangModal = new bootstrap.Modal(document.getElementById('keranjangModal'));

        keranjangButton.addEventListener('click', function() {
            keranjangModal.show();
        });
    });
    </script>
    <!-- End Js Search -->
</body>

</html>