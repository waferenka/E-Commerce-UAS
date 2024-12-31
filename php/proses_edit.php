<?php
require 'php.php';
if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["category"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $satuan = $_POST["satuan"];

    // Upload Gambar
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image = basename($_FILES["image"]["name"]);
        $target_dir = "./imgs/";
        $target_dir1 = "../imgs/";

        if (!file_exists($target_dir1)) {
            mkdir($target_dir1, 0777, true);
        }

        $target_file = $target_dir . $image;
        $target_file1 = $target_dir1 . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file1);
        $query = "UPDATE products SET 
                  name = '$name', description = '$description', price = '$price', image = '$target_file', category = '$category', satuan = '$satuan'
                  WHERE id = '$id'";
    } else {
        $query = "UPDATE products SET 
                  name = '$name', description = '$description', price = '$price', category = '$category', satuan = '$satuan'
                  WHERE id = '$id'";
    }

    mysqli_query($conn, $query);

    // Redirect kembali ke halaman sebelumnya
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../index_p.php"); // Fallback URL
    }
}
?>