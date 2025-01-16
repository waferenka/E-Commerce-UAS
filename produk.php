<?php
    session_start();
    include('php/php.php');
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if (!isset($_SESSION['userid'])) {
        header("Location: login/login_form.php");
        exit;
    }

    if ($_SESSION['level'] != "pembeli") {
        header("Location: login/login_form.php");
        exit;
    }

    $userid = $_SESSION['userid'];

    // hitung ongkir
$sql = "SELECT * FROM detail_address WHERE user_id = ?";
// Persiapkan statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // "i" berarti integer
// Eksekusi statement
$stmt->execute();
// Ambil hasilnya
$result = $stmt->get_result();

$shipping_cost = 0; // Inisialisasi nilai shipping_cost

if ($result->num_rows > 0) {
    // Menampilkan data
    while ($row = $result->fetch_assoc()) {
        $lat1 = -3.0113878;
        $lon1 = 104.6895402;
        $lat2 = $row["latitude"];
        $lon2 = $row["longitude"];
        // Haversine Formula
        function haversine($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Radius of the earth in km
            $latDiff = deg2rad($lat2 - $lat1);
            $lonDiff = deg2rad($lon2 - $lon1);
            $a = sin($latDiff / 2) * sin($latDiff / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
                sin($lonDiff / 2) * sin($lonDiff / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c; // Distance in km
            return $distance;
        }
        $distance = haversine($lat1, $lon1, $lat2, $lon2);
        $costPerKm = 5000; // Biaya per km (contoh)
        // Jika jarak kurang dari 1km, tetap dihitung Rp5000
        if ($distance < 1) {
            $shipping_cost = 5000;
        } else {
            $shipping_cost = round($distance * $costPerKm); // Dibulatkan ke integer terdekat
        }
    }
}

    $sql = "SELECT u.id, u.nama, u.email, u.level, d.foto, d.jenis_kelamin, d.tanggal_lahir, d.alamat, d.no_telepon 
    FROM tbluser u 
    LEFT JOIN user_detail d ON u.id = d.id 
    WHERE u.id = '$userid'";

    $result = mysqli_query($conn, $sql);

    if ($result && $result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];
        $nama = $row['nama'];
        $email = $row['email'];
        $phone = $row['no_telepon'];
        $address = $row['alamat'];
        $level = $row['level'];
    } else {
        echo "Data user tidak ditemukan.";
    }

    $query = "SELECT id, name, price, image FROM products";
    $result = $conn->query($query);

    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

    $data = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
    $productd = mysqli_fetch_assoc($data);
    if ($result && $result->num_rows > 0) {
        $nama_p = $productd['name'];
        $harga_p = $productd['price'];
        $satuan_p = $productd['satuan'];
    }

    

    require 'midtrans_config.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['buy_now'])) {
            // hitung ongkir
            $sql = "SELECT * FROM detail_address WHERE user_id = ?";
            // Persiapkan statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userid);  // "i" berarti integer
            // Eksekusi statement
            $stmt->execute();
            // Ambil hasilnya
            $result = $stmt->get_result();

            $shipping_cost = 0; // Inisialisasi nilai shipping_cost

            if ($result->num_rows > 0) {
                // Menampilkan data
                while ($row = $result->fetch_assoc()) {
                    $lat1 = -3.0113878;
                    $lon1 = 104.6895402;
                    $lat2 = $row["latitude"];
                    $lon2 = $row["longitude"];
                    // Haversine Formula
                    function haversine($lat1, $lon1, $lat2, $lon2) {
                        $earthRadius = 6371; // Radius of the earth in km
                        $latDiff = deg2rad($lat2 - $lat1);
                        $lonDiff = deg2rad($lon2 - $lon1);
                        $a = sin($latDiff / 2) * sin($latDiff / 2) +
                            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
                            sin($lonDiff / 2) * sin($lonDiff / 2);
                        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                        $distance = $earthRadius * $c; // Distance in km
                        return $distance;
                    }
                    $distance = haversine($lat1, $lon1, $lat2, $lon2);
                    $costPerKm = 5000; // Biaya per km (contoh)
                    // Jika jarak kurang dari 1km, tetap dihitung Rp5000
                    if ($distance < 1) {
                        $shipping_cost = 5000;
                    } else {
                        $shipping_cost = round($distance * $costPerKm); // Dibulatkan ke integer terdekat
                    }
                }
            }
            $user_id = $_SESSION['userid'];
            $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
            $user_query = "SELECT nama FROM tbluser WHERE id = ?";
            $user_stmt = $conn->prepare($user_query);
            $user_stmt->bind_param("i", $user_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user_name = $user_result->fetch_assoc()['nama'];
            $product_query = "SELECT name, price FROM products WHERE id = ?";
            $product_stmt = $conn->prepare($product_query);
            $product_stmt->bind_param("i", $product_id);
            $product_stmt->execute();
            $product_result = $product_stmt->get_result();
            $product = $product_result->fetch_assoc();
            $product_name = $product['name'];
            $price = $product['price'] * $quantity;
            $items = [];
            $total_price_midtrans = 0;
            if ($product['price'] > 0 && $quantity > 0) {
                $total_price_midtrans = $shipping_cost + $price;
                $items[] = [
                    'id' => $product_id,
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'name' => $product_name
                ];
            }
            // Tambahkan ongkir sebagai item
            $items[] = [
                'id' => 'shipping',
                'price' => $shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim'
            ];
            header('Content-Type: application/json');

            $snap_token = null;
            if (!empty($items) && $total_price_midtrans > 0) {
                $transaction_details = [
                    'order_id' => rand(),
                    'gross_amount' => $total_price_midtrans
                ];
                $customer_details = [
                    'first_name' => $nama,
                    'email' => $email,
                    'phone' => $phone,
                    'shipping_address' => $address
                ];
                $transaction_data = [
                    'transaction_details' => $transaction_details,
                    'customer_details' => $customer_details,
                    'item_details' => $items
                ];
                try {
                    $item_details_json = json_encode($items);
                    $stmt = $conn->prepare("INSERT INTO transactions (order_id, user_id, transaction_status, gross_amount, item_details) 
                        VALUES (?, ?, ?, ?, ?)");
                    $payment_status = 'Pending';
                    $stmt->bind_param("sssss", 
                        $transaction_details['order_id'],
                        $userid,
                        $payment_status, 
                        $transaction_details['gross_amount'],
                        $item_details_json
                    );
                    $stmt->execute();
                    $stmt->close();
                    $snap_token = \Midtrans\Snap::getSnapToken($transaction_data);
                    echo json_encode(['success' => true, 'snap_token' => $snap_token, 'order_id' => $transaction_details['order_id']]);
                    exit;
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Keranjang kosong atau total harga tidak valid.']);
                exit;
            }
            $user_stmt->close();
            $product_stmt->close();
        }

        if (isset($_POST['action']) && $_POST['action'] === 'add_cart') {
            // Ambil data dari form
            $user_id = $_SESSION['userid'];
            $quantity = (int) $_POST['quantity'];

            // Ambil nama user berdasarkan user_id
            $user_query = "SELECT nama FROM tbluser WHERE id = ?";
            $user_stmt = $conn->prepare($user_query);
            $user_stmt->bind_param("i", $user_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user_name = $user_result->fetch_assoc()['nama'];

            // Ambil nama produk dan harga berdasarkan product_id
            $product_query = "SELECT name, price FROM products WHERE id = ?";
            $product_stmt = $conn->prepare($product_query);
            $product_stmt->bind_param("i", $product_id);
            $product_stmt->execute();
            $product_result = $product_stmt->get_result();
            $product = $product_result->fetch_assoc();
            $product_name = $product['name'];
            $price = $product['price'] * $quantity;

            // Cek apakah kombinasi user_id dan product_id sudah ada di tabel cart
            $check_query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $user_id, $product_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                // Jika data sudah ada, lakukan update pada kolom quantity
                $existing_data = $check_result->fetch_assoc();
                $new_quantity = $existing_data['quantity'] + $quantity;

                $update_query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);

                if ($update_stmt->execute()) {
                    header("Location: #");
                    exit;
                } else {
                    
                }
                $update_stmt->close();
            } else {
                // Jika data tidak ada, lakukan insert
                $insert_query = "INSERT INTO cart (user_id, user_name, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("isissi", $user_id, $user_name, $product_id, $product_name, $quantity, $price);

                if ($insert_stmt->execute()) {
                    header("Location: #");
                    exit;
                } else {
                    
                }
                $insert_stmt->close();
            }

            $check_stmt->close();
            $user_stmt->close();
            $product_stmt->close();
        }
    }
    
    //Nama Depan
    function getFirstName($fullName) {
        $parts = explode(" ", $fullName);
        return $parts[0];
    }

    require("php/navbar.php");
    $conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Metadata -->
    <?php include('metadata.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .deskripsi-terbatas {
        cursor: pointer;
        position: relative;
        padding-bottom: 1rem;
    }

    .deskripsi-terbatas span {
        display: block;
    }

    .deskripsi-terbatas button {
        color: #007bff;
        text-decoration: underline;
        border: none;
        background: transparent;
    }

    .dropdown-menu {
        width: 100%;
        border: none;
        box-shadow: 0 -4px 4px rgba(0, 0, 0, 0.05);
    }

    .message-image {
        width: auto;
        height: 40px;
        display: block;
        border: 1.5px rgb(255, 180, 0) solid;
        border-radius: 6px;
    }

    @media (max-width: 436px) {
        #container-p {
            padding-bottom: 4rem;
        }

        .item-konten-p {
            padding: 1rem 1.5rem 0rem 1.5rem;
        }

        .item-button-mobile {
            display: flex;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.4rem 0.8rem;
            background-color: white;
            justify-content: center;
            z-index: 1000;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }

        .item-button-tabdesk {
            display: none;
        }

        .btn-keranjang,
        .btn-beli {
            flex: 1;
        }
    }

    @media (min-width: 436px) {
        .item-button-tabdesk {
            display: block;
        }

        .item-button-mobile {
            display: none;
        }
    }

    footer {
        background-color: white;
        margin-top: 2rem;
        padding: 1rem 0 3rem 0;
        width: 100%;
    }
    </style>
    <title>Alzi Petshop</title>
</head>

<body>
    <script src="script/script.js"></script>
    <!-- Detail Produk -->
    <div id="container-p" class="container mt-5 vh-100" style="padding-top: 1.5rem; color: black;">
        <?php if ($productd): ?>
        <div class="row">
            <!-- Gambar Produk -->
            <div class="col-md-6 text-center">
                <img src="<?php echo $productd['image']; ?>" alt="<?php echo $productd['name']; ?>"
                    class="product-image">
            </div>
            <!-- Detail Produk -->
            <div class="col-md-6 item-konten-p">
                <h4 class="nama-p"><?php echo htmlspecialchars($productd['name']); ?></h4>
                <h2 class="harga-p">Rp<?php echo number_format($productd['price'], 0, ',', '.'); ?></h2>
                <form method="POST" action="">
                    <!-- Deskripsi -->
                    <div id="description" class="deskripsi-terbatas" onclick="toggleDescription()">
                        <?php 
                            $maxLength = 200;
                            $description = nl2br(htmlspecialchars($productd['description']));
                            $shortDesc = substr($description, 0, $maxLength);
                            $isTruncated = strlen($description) > $maxLength;

                            echo '<span id="short-desc">' . $shortDesc . ($isTruncated ? '...' : '') . '</span>';
                            echo '<span id="full-desc" style="display:none;">' . $description . '</span>';
                        ?>
                        <?php if ($isTruncated): ?>
                        <button id="toggle-desc" type="button" class="btn btn-link p-0"
                            style="pointer-events: none; text-decoration: none; color: rgb(255, 180, 0); font-weight: bold;">Lihat
                            Selengkapnya</button>
                        <?php endif; ?>
                    </div>
                    <!-- Tombol Mobile -->
                    <form action="produk.php" method="POST">
                        <div id="A" class="d-flex align-items-center gap-2 item-button-mobile">
                            <a href="https://api.whatsapp.com/send?phone=6283192655757">
                                <img src="imgs/message.jpg" class="message-image">
                            </a>
                            <button type="button" class="btn-keranjang" id="cartButton" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                + Keranjang
                            </button>
                            <button type="button" class="btn-beli" id="beliButton" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Beli Sekarang
                            </button>
                            <div class="dropdown-menu p-4" aria-labelledby="beliButton" id="beliDropdown">
                                <h6>Konfirmasi Pembelian</h6>
                                <!-- Jumlah Barang -->
                                <div class="d-flex align-items-center my-3">
                                    <label for="quantity" class="me-2">Jumlah:</label>
                                    <div class="quantity-box d-flex">
                                        <button type="button" class="btn btn-outline-secondary decreaseBtn">-</button>
                                        <input type="number" class="quantityInput form-control mx-2" name="quantity"
                                            id="quantity" min="1" value="1">
                                        <button type="button" class="btn btn-outline-secondary increaseBtn">+</button>
                                    </div>
                                </div>
                                <button type="submit" name="action" value="add_cart" class="btn-keranjang">Masukkan
                                    Keranjang</button>
                                <button class="btn-beli" type="buy_now" id="beli_sekarang">Beli Sekarang</button>
                            </div>
                        </div>
                        <!-- Tombol Tablet + Dekstop -->
                        <div id="B" class="gap-3 item-button-tabdesk">
                            <!-- Jumlah Barang -->
                            <div class="d-flex align-items-center my-3">
                                <label for="quantity" class="me-2">Jumlah:</label>
                                <div class="quantity-box d-flex">
                                    <button type="button" class="btn btn-outline-secondary decreaseBtn">-</button>
                                    <input type="number" class="quantityInput form-control mx-2" name="quantity"
                                        id="quantity" min="1" value="1" />
                                    <button type="button" class="btn btn-outline-secondary increaseBtn">+</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start gap-2 action-row">
                                <a href="https://api.whatsapp.com/send?phone=6283192655757">
                                    <img src="imgs/message.jpg" class="message-image" />
                                </a>
                                <button type="submit" name="action" value="add_cart" class="btn-keranjang">+
                                    Keranjang</button>
                                <button class="btn-beli" type="buy_now" id="beli_sekarangs">Beli Sekarang</button>
                            </div>
                        </div>
                    </form>
                </form>
            </div>
        </div>
        <?php else: ?>
        <p class="text-danger">Produk tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Js -->
    <script>
    // Order
    document.getElementById('beli_sekarang').addEventListener('click', function(event) {
        event.preventDefault(); // Cegah refresh halaman
        const quantity = document.getElementById('quantity').value;
        fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `buy_now=true&quantity=${encodeURIComponent(quantity)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Panggil Snap Midtrans
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            alert("Pembayaran berhasil!");
                            console.log(result);
                            window.location.href = "success.php";
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
                } else {
                    alert("Gagal memproses transaksi: " + data.message);
                }
            })

    });

    document.getElementById('beli_sekarangs').addEventListener('click', function(event) {
        event.preventDefault(); // Cegah refresh halaman
        const quantity = document.getElementById('quantity').value;
        fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `buy_now=true&quantity=${encodeURIComponent(quantity)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Panggil Snap Midtrans
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href =
                                `proses_status.php?order_id=${encodeURIComponent(data.order_id)}`;
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
                } else {
                    alert("Gagal memproses transaksi: " + data.message);
                }
            })

    });
    // Kuantitas/Jumlah Barang
    document.addEventListener("DOMContentLoaded", function() {
        const decreaseBtns = document.querySelectorAll('.decreaseBtn');
        const increaseBtns = document.querySelectorAll('.increaseBtn');
        const quantityInputs = document.querySelectorAll('.quantityInput');
        const form = document.querySelector('form'); // Ambil form

        // Fungsi untuk mengurangi jumlah
        decreaseBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                let quantity = parseInt(quantityInputs[index].value);
                if (quantity > 1) {
                    quantityInputs[index].value = quantity - 1;
                }
            });
        });

        // Fungsi untuk menambah jumlah
        increaseBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                let quantity = parseInt(quantityInputs[index].value);
                quantityInputs[index].value = quantity + 1;
            });
        });

        // Saat form disubmit, pastikan value quantity yang terbaru dikirimkan
        form.addEventListener('submit', function() {
            const quantity = quantityInputs[0].value; // Ambil nilai dari input pertama
            console.log("Form submitted with quantity: " + quantity); // Debug log
        });
    });

    // Hapus Div Width Tertentu
    function checkWidthA() {
        var divA = document.getElementById("A");
        var divB = document.getElementById("B");
        if (window.innerWidth > 436) {
            divA.innerHTML = '';
        } else {
            divB.innerHTML = '';
        }
    }

    window.addEventListener("resize", checkWidthA);
    window.addEventListener("load", checkWidthA);

    // Lihat Selengkapnya
    function toggleDescription() {
        const shortDesc = document.getElementById('short-desc');
        const fullDesc = document.getElementById('full-desc');
        const button = document.getElementById('toggle-desc');

        if (fullDesc.style.display === 'none' || fullDesc.style.display === '') {
            fullDesc.style.display = 'inline';
            shortDesc.style.display = 'none';
            button.textContent = 'Sembunyikan';
        } else {
            fullDesc.style.display = 'none';
            shortDesc.style.display = 'inline';
            button.textContent = 'Lihat Selengkapnya';
        }
    }

    // Dropdown
    const beliButton = document.querySelector('#beliButton');
    const cartButton = document.querySelector('#cartButton');
    const beliDropdown = document.querySelector('#beliDropdown');

    function toggleDropdown(event, button) {
        const isOpen = beliDropdown.classList.contains('show');
        event.stopPropagation();

        if (!isOpen) {
            const dropdown = new bootstrap.Dropdown(button);
            dropdown.hide();
        } else {
            const dropdown = new bootstrap.Dropdown(button);
            dropdown.show();
        }
    }

    beliButton.addEventListener('click', function(event) {
        toggleDropdown(event, beliButton);
    });

    cartButton.addEventListener('click', function(event) {
        toggleDropdown(event, cartButton);
    });

    document.addEventListener('click', function(e) {
        if (!beliButton.contains(e.target) &&
            !cartButton.contains(e.target) &&
            !beliDropdown.contains(e.target)) {
            const dropdown = new bootstrap.Dropdown(beliButton);
            dropdown.hide();
        }
    });

    beliDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    </script>
    <footer class="text-center">
        <p>Create by Alzi Petshop | &copy 2024</p>
    </footer>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>