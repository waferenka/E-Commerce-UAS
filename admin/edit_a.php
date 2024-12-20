<?php
include 'php/php.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data produk berdasarkan ID
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $satuan = $_POST['satuan'];

    // Query untuk update data produk
    $sql = "UPDATE products SET name='$name', description='$description', price=$price, category='$category', satuan='$satuan' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: product_a.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Produk</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description"
                    name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price"
                    value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <select class="form-control" id="category" name="category">
                    <option value="Makanan" <?php echo ($product['category'] == 'Makanan') ? 'selected' : ''; ?>>Makanan
                    </option>
                    <option value="Peralatan" <?php echo ($product['category'] == 'Peralatan') ? 'selected' : ''; ?>>
                        Peralatan</option>
                    <option value="Aksesoris" <?php echo ($product['category'] == 'Aksesoris') ? 'selected' : ''; ?>>
                        Aksesoris</option>
                    <option value="Kesehatan" <?php echo ($product['category'] == 'Kesehatan') ? 'selected' : ''; ?>>
                        Kesehatan</option>
                    <option value="Kebersihan" <?php echo ($product['category'] == 'Kebersihan') ? 'selected' : ''; ?>>
                        Kebersihan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan"
                    value="<?php echo htmlspecialchars($product['satuan']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="product_a.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>