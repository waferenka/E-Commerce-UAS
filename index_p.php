<?php
	session_start();
	// PHP Data Js Search
	include('php/php.php');
	
	// Periksa apakah user sudah login
	if (!isset($_SESSION['userid'])) {
		header("Location: login/login_form.php");
		exit;
	}

    if ($_SESSION['level'] != "penjual") {
        header("Location: login/login_form.php");
        exit;
    }

	$userid = $_SESSION['userid']; // Ambil user ID dari session

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
    .navbar-brand {
        display: inline !important;
    }

    .categories {
        margin-top: 3.5rem;
    }

    .d-flex {
        display: flex;
        justify-content: flex-end;
        margin-left: auto;
    }

    @media (max-width: 436px) {
        .d-flex {
            justify-content: flex-start;
            margin: auto 0;
        }

        .d-flex a {
            font-size: 14px;
        }
    }
    </style>
    <title>Alzi Petshop</title>
</head>

<body>
    <!-- Navbar, Search, Keranjang, User -->
    <?php require('php/navbar.php'); ?>

    <!-- Tombol Kategori -->
    <div class="categories">
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
                    echo ' <div class="ppp">
                        <img src="' . htmlspecialchars($row['image']) . '" loading:="lazy" alt="' . htmlspecialchars($row['name']) . '">
                        </div>
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
            window.location.href = `edit.php?product_id=${productId}`;
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