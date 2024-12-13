<?php include('php/php.php');?>
<!-- PHP Data Js Search -->
<?php
	$query = "SELECT id, name, price, image FROM products";
	$result = $conn->query($query);

	$products = [];
	if ($result->num_rows > 0) {
	    while ($row = $result->fetch_assoc()) {
	        $products[] = $row;
	    }
	}
?>
<!-- End PHP Data Js Search -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<title>Alzi Petshop</title>
	</head>
	<body>
		<script src="script/script.js"></script>
		<!-- Navbar, Search, Keranjang, User -->
		<nav class="navbar">
		    <div class="container-fluid">
		        <a class="navbar-brand ms-2 font-weight-bold" href="#">
		            Alzi Petshop
		        </a>
		        <div class="search-box me-3">
		            <input type="text" id="searchInput" placeholder="Cari produk...">
		            <div class="search-dropdown" id="searchResults"></div>
		        </div>
		        <div class="navbar-item">
		            <a href="#" class="me-2"><img src="imgs/cart.png"></a>
		            <a href="#"><img src="imgs/a1.png" class="rounded-circle"></a>
		            <a href="#" id="user">User</a>
		        </div>
		    </div>
		</nav>
		<!-- End Navbar, Search, Keranjang, User -->
		<!-- Js Search -->
		<!-- TODO: Pisahke kode ini di file script yang berbeda(External) -->
		<script>
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
		                        window.location.href = `shopping_page.php?product_id=${product.id}`;
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

		    searchInput.addEventListener('blur', function () {
		        searchInput.value = '';
		        searchResults.style.display = 'none';
		    });
		</script>
		<!-- End Js Search -->
		<!-- Slider Otomatis Carousel Bootstrap v5.3 -->
		<div class="container mt-5 pt-4">
			<div id="carouselExampleSlidesOnly" class="carousel slide my-1 position-relative" data-bs-ride="carousel">
			    <div class="carousel-inner">
			        <div class="carousel-item active">
			            <img src="imgs/slide1.png" class="d-block w-100" alt="...">
			        </div>
			        <div class="carousel-item">
			            <img src="imgs/slide2.png" class="d-block w-100" alt="...">
			        </div>
			        <div class="carousel-item">
			            <img src="imgs/slide3.png" class="d-block w-100" alt="...">
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
		<section class="categories">
	        <h2>Kategori Produk</h2>
	        <div class="category-list">
				<div class="category" style="background-color: #ff6c59" data-category="d1">
					Makanan
				</div>
				<div class="category" style="background-color: #ffada2" data-category="d2">
					Peralatan
				</div>
				<div class="category" style="background-color: #ffd3a2" data-category="d3">
					Aksesoris
				</div>
				<div class="category" style="background-color: #f2d7b7" data-category="d4" >
					Kesehatan
				</div>
				<div class="category" style="background-color: #b4b7f0" data-category="d5" >
					Kebersihan
				</div>
	        </div>
	      </section>
	      <!-- End Tombol Kategori -->
	      <!-- List Produk Sesuai Kategori -->
	      <div class="products" id="product-list">
	        <?php
	        	$sql = "SELECT * FROM products";
    			$result = $conn->query($sql);
		        
		        if ($result->num_rows > 0) {
		            while ($row = $result->fetch_assoc()) {
		                echo '<div class="product" data-category="' . htmlspecialchars($row['category']) . '">';
		                echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
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
	    	<!-- List Produk Sesuai Kategori -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>
