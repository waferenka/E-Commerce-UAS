<?php
require 'php.php'; // koneksi ke database

if (isset($_POST["id"], $_POST["name"], $_POST["description"], $_POST["price"], $_POST["category"], $_POST["satuan"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $satuan = $_POST["satuan"];

    // Ambil data produk berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $productd = $result->fetch_assoc();

    if ($productd) {
        $image_p = $productd['image'];
    }

    // Direktori gambar
    $target_dir1 = "../imgs/";
    if (!file_exists($target_dir1)) {
        mkdir($target_dir1, 0777, true);
    }

    // Upload gambar jika ada
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $target_file1 = $target_dir1 . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file1);
        $target_file = "./imgs/" . $image;
    } else {
        $target_file = $image_p ?? null;
    }

    // Update data produk
    $query = "UPDATE products SET 
              name = ?, description = ?, price = ?, image = ?, category = ?, satuan = ?
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdsssi", $name, $description, $price, $target_file, $category, $satuan, $id);

    if ($stmt->execute()) {
        // Redirect jika berhasil
        header("Location: ../index_p.php");
        exit();
    } else {
        die("Error updating record: " . $stmt->error);
    }
}
?>