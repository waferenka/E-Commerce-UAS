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
    } else {
        $target_file = "";
    }

    $query = "INSERT INTO products (id, name, description, price, image, category, satuan) 
            VALUES ('$id', '$name', '$description', '$price', '$target_file', '$category', '$satuan')";

    mysqli_query($conn, $query);

    header("Location: ../index_p.php");
}
?>
