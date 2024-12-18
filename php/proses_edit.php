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
        $target_dir = "imgs/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $query = "UPDATE products SET 
                  name = '$name', description = '$description', price = '$price', image = '$target_file', category = '$category', satuan = '$satuan'
                  WHERE id = '$id'";
    } else {
        $query = "UPDATE products SET 
                  name = '$name', description = '$description', price = '$price', category = '$category', satuan = '$satuan'
                  WHERE id = '$id'";
    }

    mysqli_query($conn, $query);

    header("Location: index_p.php");
}
?>

