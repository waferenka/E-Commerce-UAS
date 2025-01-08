<?php
    require 'php.php';

    if (isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']);

        $query = "DELETE FROM products WHERE id = '$product_id'";

        if (mysqli_query($conn, $query)) {
            header("Location: ../index_p.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "ID produk tidak ditemukan.";
    }
?>
