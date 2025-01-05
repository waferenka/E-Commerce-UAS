<?php
    session_start();
    // PHP Data Js Search
    include('php/php.php');
    
    // Periksa apakah user sudah login
    if (!isset($_SESSION['userid'])) {
        header("Location: login/login_form.php");
        exit;
    }

    if ($_SESSION['level'] != "pembeli") {
        header("Location: login/login_form.php");
        exit;
    }

    $userid = $_SESSION['userid']; // Ambil user ID dari session
    $user_id = $_SESSION['userid'];

    // Query untuk mengambil data dari kedua tabel
    $sql = "SELECT u.id, u.nama, u.email, u.level, d.foto, d.jenis_kelamin, d.tanggal_lahir, d.alamat, d.no_telepon 
            FROM tbluser u 
            LEFT JOIN user_detail d ON u.id = d.id 
            WHERE u.id = '$userid'";

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];
        $nama = $row['nama'];
        $email = $row['email'];
        $level = $row['level'];
        $jenis_kelamin = $row['jenis_kelamin'];
        $tanggal_lahir = $row['tanggal_lahir'];
        $alamat = $row['alamat'];
        $no_telepon = $row['no_telepon'];
    } else {
        echo "Data user tidak ditemukan.";
    }

    $query = "SELECT id, name, price, image FROM products";
    $result = $conn->query($query);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Query untuk mengambil data dari tabel cart berdasarkan user_id
    $querycart = "
        SELECT c.product_id, p.name AS product_name, p.image, c.quantity, p.price, (c.quantity * p.price) AS total_price 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = '$user_id'
    ";
    $resultcart = mysqli_query($conn, $querycart);
    $total_price = 0;

    //Nama Depan
    function getFirstName($fullName) {
        $parts = explode(" ", $fullName);
        return $parts[0];
    }
?>
<!-- End PHP Data Js Search -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Metadata -->
    <?php include('metadata.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
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

.cart-actions button {
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
}
    </style>
    <title>Alzi Petshop</title>
</head>

<body>
    <script src="script/script.js"></script>
    <!-- Navbar, Search, Keranjang, User -->
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand ms-2 font-weight-bold" href="index_p.php">
                Alzi Petshop
            </a>
            <div class="search-box me-3">
                <input type="text" id="searchInput" placeholder="Cari produk..." autocomplete="off">
                <div class="search-dropdown" id="searchResults"></div>
            </div>
            <div class="navbar-item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#keranjangModal">
                <img src="imgs/cart.png" alt="Keranjang" class="me-2">
            </a>
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
                    <form method="post" action="update_cart.php">
                        <?php while ($row = mysqli_fetch_assoc($resultcart)): ?>
                        <div class="cart-item">
                            <div class="cart-image">
                                <img src="<?= $row['image']; ?>" alt="<?= $row['product_name']; ?>">
                            </div>
                            <div class="cart-details">
                                <p class="product-name"><?= $row['product_name']; ?></p>
                                <p class="product-price">Rp<?= number_format($row['price'], 0, ',', '.'); ?></p>
                                <div class="quantity-control">
                                    <input type="number" id="quantity-<?= $row['product_id']; ?>" name="quantity[<?= $row['product_id']; ?>]" 
                                           value="<?= $row['quantity']; ?>" min="1">
                                </div>
                                <a href="delete_cart_item.php?product_id=<?= $row['product_id']; ?>" 
                                   onclick="return confirm('Hapus produk ini?')" class="delete-link">Hapus</a>
                            </div>
                        </div>
                        <?php $total_price += $row['total_price']; ?>
                        <?php endwhile; ?>
                        <p class="total-price">Total Belanja: Rp<?= number_format($total_price, 0, ',', '.'); ?></p>
                        <div class="cart-actions">
                            <button type="submit" formaction="checkout.php">Checkout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End keranjang -->

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
    </script>
    <!-- End Js Search -->
    <!-- Slider Otomatis Carousel Bootstrap v5.3 -->
    <div class="container mt-5 pt-4">
        <div id="carouselExampleSlidesOnly" class="carousel slide my-1 position-relative" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="imgs/slide1.jpg" class="d-block w-100" loading:="lazy" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="imgs/slide2.jpg" class="d-block w-100" loading:="lazy" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="imgs/slide3.jpg" class="d-block w-100" loading:="lazy" alt="...">
                </div>
                <div class="carousel-caption-custom">
                    <h1>Alzi Petshop</h1>
                    <p>Belanja Kebutuhan Kucingmu Disini!</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Slider Otomatis Carousel Bootstrap v5.3 -->
    <!-- Tombol Kategori -->
    <div class="categories">
        <h2>Kategori Produk</h2>
        <div class="category-list">
            <div class="category" style="background-color: #ff6c59" data-category="Makanan">
                Makanan
            </div>
            <div class="category" style="background-color: #ffada2" data-category="Peralatan">
                Peralatan
            </div>
            <div class="category" style="background-color: #ffd3a2" data-category="Aksesoris">
                Aksesoris
            </div>
            <div class="category" style="background-color: #f2d7b7" data-category="Kesehatan">
                Kesehatan
            </div>
            <div class="category" style="background-color: #b4b7f0" data-category="Kebersihan">
                Kebersihan
            </div>
        </div>
    </div>
    <!-- End Tombol Kategori -->
    <!-- List Produk Sesuai Kategori -->
    <div class="products" id="product-list">
        <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product" data-id="' . htmlspecialchars($row['id']) . '" data-category="' . htmlspecialchars($row['category']) . '">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" loading:="lazy" alt="' . htmlspecialchars($row['name']) . '">
                          <h3>' . htmlspecialchars($row['name']) . '</h3>
                          <p>' . rupiah($row['price']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products available.</p>';
            }

            $conn->close();
        ?>
    </div>

    <script>
    const products_l = document.querySelectorAll('.product');

    products_l.forEach(product => {
        product.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            window.location.href = `produk.php?product_id=${productId}`;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const defaultCategory = 'Makanan';
        showCategory(defaultCategory);

        document.querySelectorAll('.category').forEach(category => {
            category.addEventListener('click', function() {
                const selectedCategory = this.getAttribute('data-category');
                showCategory(selectedCategory);

                document.querySelectorAll('.category').forEach(cat => {
                    cat.classList.remove('active');
                });

                this.classList.add('active');
            });
        });

        function showCategory(category) {
            document.querySelectorAll('.product').forEach(product => {
                product.classList.remove('active');
            });

            document.querySelectorAll(`.product[data-category="${category}"]`).forEach(product => {
                product.classList.add('active');
            });

            document.querySelectorAll('.category').forEach(cat => {
                if (cat.getAttribute('data-category') === category) {
                    cat.classList.add('active');
                } else {
                    cat.classList.remove('active');
                }
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
    const keranjangButton = document.querySelector('#keranjangButton'); // ID tombol keranjang
    const keranjangModal = new bootstrap.Modal(document.getElementById('keranjangModal'));

    keranjangButton.addEventListener('click', function() {
        keranjangModal.show();
    });
});

    </script>
    <!-- List Produk Sesuai Kategori -->

    <!-- Footer start -->
    <footer class="text-center">
        <p>Create by Alzi Petshop | &copy 2024</p>
    </footer>
    <!-- Footer End -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
