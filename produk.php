<?php
    session_start();
    // PHP Data Js Search
    include('php/php.php');

    // Periksa apakah user sudah login
    if (!isset($_SESSION['userid'])) {
        header("Location: login/login_form.php");
        exit;
    }

    $userid = $_SESSION['userid']; // Ambil user ID dari session

    // Query untuk mengambil data user
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
        $level = $row['level'];
    } else {
        echo "Data user tidak ditemukan.";
    }

    // Ambil semua produk untuk pencarian
    $query = "SELECT id, name, price, image FROM products";
    $result = $conn->query($query);

    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Ambil produk berdasarkan ID dari parameter URL
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

    $data = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
    $productd = mysqli_fetch_assoc($data);
    if ($result && $result->num_rows > 0) {
        $nama_p = $productd['name'];
        $satuan_p = $productd['satuan'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $quantity = intval($_POST['quantity']);
        $action = $_POST['action'];

        if ($action === 'buy_now') {
            $url = "https://api.whatsapp.com/send?phone=6283161076087&text=Halo saya $nama ingin memesan $nama_p sebanyak $quantity $satuan_p";
            header("Location: $url");
        }
    }

    //Nama Depan
    function getFirstName($fullName) {
        $parts = explode(" ", $fullName);
        return $parts[0];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.ico" />
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

            .dropdown-menu{
                width: 100%;
                border: none;
                box-shadow: 0 -4px 4px rgba(0, 0, 0, 0.05);
            }

            @media (max-width: 436px) {
              #container-p {
                padding-bottom: 4rem;
              }
              .item-konten-p {
                padding: 1rem 1.5rem 0rem 1.5rem;
              }
              #item-button-mobile {
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
              #item-button-tabdesk {
                display: none;
              }
              .btn-keranjang,
              .btn-beli {
                flex: 1;
              }
            }

            @media (min-width: 436px) {
              #item-button-tabdesk {
                display: block;
              }
              #item-button-mobile {
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
        <!-- Navbar, Search, Keranjang, User -->
        <nav class="navbar">
            <div class="container-fluid">
                <a class="navbar-brand ms-2 font-weight-bold" href="index.php">Alzi Petshop</a>
                <div class="search-box me-3">
                    <input type="text" id="searchInput" placeholder="Cari produk...">
                    <div class="search-dropdown" id="searchResults"></div>
                </div>
                <div class="navbar-item">
                    <a href="detail.php">
                        <img src="<?php echo $foto; ?>" class="rounded-circle me-2">
                        <span id="user"><?php echo getFirstName($nama); ?></span>
                    </a>
                </div>
            </div>
        </nav>
        <!-- Detail Produk -->
        <div id="container-p" class="container mt-5" style="padding-top: 1.5rem; color: black;">
            <?php if ($productd): ?>
                <div class="row">
                    <!-- Gambar Produk -->
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $productd['image']; ?>" alt="<?php echo $productd['name']; ?>" class="product-image">
                    </div>

                    <!-- Detail Produk -->
                    <div class="col-md-6 item-konten-p">
                        <h4 class="nama-p"><?php echo htmlspecialchars($productd['name']); ?></h4>
                        <h2 class="harga-p">Rp<?php echo number_format($productd['price'], 0, ',', '.'); ?></h2>
                        <form method="POST">
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
                                    <button id="toggle-desc" type="button" class="btn btn-link p-0" style="pointer-events: none; text-decoration: none; color: rgb(255, 180, 0); font-weight: bold;">Lihat Selengkapnya</button>
                                <?php endif; ?>
                            </div>
                            <!-- Tombol Mobile -->
                            <div id="item-button-mobile" class="gap-3">
                                <!-- Tombol Beli Sekarang -->
                                <button type="button" class="btn-beli" id="beliButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Beli Sekarang
                                </button>
                                <!-- Div Dropdown -->
                                <div class="dropdown-menu p-4" aria-labelledby="beliButton" id="beliDropdown">
                                    <h6>Konfirmasi Pembelian</h6>
                                    <!-- Jumlah Barang -->
                                    <div class="d-flex align-items-center my-3">
                                        <label for="quantity" class="me-2">Jumlah:</label>
                                        <div class="quantity-box d-flex">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control mx-2">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                                        </div>
                                    </div>
                                    <button type="submit" name="action" value="buy_now" class="btn-beli px-4">Beli</button>
                                </div>
                            </div>
                            <!-- Tombol Tablet + Dekstop -->
                            <div id="item-button-tabdesk" class="gap-3">
                                <!-- Jumlah Barang -->
                                <div class="d-flex align-items-center my-3">
                                    <label for="quantity" class="me-2">Jumlah:</label>
                                    <div class="quantity-box d-flex">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                                        <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control mx-2">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                                    </div>
                                </div>
                                <!-- Tombol Beli Sekarang -->
                                <button type="submit" name="action" value="buy_now" class="btn-beli">
                                    Beli Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-danger">Produk tidak ditemukan.</p>
            <?php endif; ?>
        </div>

        <!-- Js -->
        <script>
            // Search
            const products = <?php echo json_encode($products); ?>;
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');

            searchInput.addEventListener('input', function () {
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
                                <img src="${product.image}" alt="${product.name}" class="item-image">
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

            // Kuantitas/Jumlah Barang
            function changeQuantity(amount) {
                const quantityInput = document.getElementById('quantity');
                let value = parseInt(quantityInput.value) || 1;
                value = Math.max(1, value + amount);
                quantityInput.value = value;
            }

            const quantityInput = document.getElementById('quantity');
            quantityInput.addEventListener('keydown', function (e) {
                let value = parseInt(quantityInput.value) || 1;
                if (e.key === 'ArrowRight') {
                    quantityInput.value = value + 1;
                } else if (e.key === 'ArrowLeft') {
                    quantityInput.value = Math.max(1, value - 1);
                }
            });

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

            // Dropdown Beli
            const beliButton = document.querySelector('#beliButton');
            const beliDropdown = document.querySelector('#beliDropdown');

            beliButton.addEventListener('click', function(event) {
                const isOpen = beliDropdown.classList.contains('show');
                if (!isOpen) {
                    const dropdown = new bootstrap.Dropdown(beliButton);
                    dropdown.show();
                } else {
                    event.stopPropagation();
                }
            });

            beliDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            document.addEventListener('click', function(e) {
                if (!beliButton.contains(e.target) && !beliDropdown.contains(e.target)) {
                    const dropdown = new bootstrap.Dropdown(beliButton);
                    dropdown.hide();
                }
            });
        </script>
        <!-- End Js Search -->
        <!-- Sementara tanpa footer -->
        <!-- <footer class="text-center">
            <p>Create by Alzi Petshop | &copy 2024</p>
        </footer> -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    </body>
</html>
