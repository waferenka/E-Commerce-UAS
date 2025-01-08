<?php
// koneksi.php berisi koneksi ke database
include 'php/php.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'], $_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    
    // Pastikan jumlah kuantitas valid
    if ($quantity > 0) {
        // Query untuk memperbarui jumlah item di tabel cart
        $updateQuery = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $quantity, $cart_id);
        
        if ($stmt->execute()) {
            // Redirect kembali ke halaman keranjang
            header("Location: cart.php");
        } else {
            echo "Gagal memperbarui keranjang.";
        }
        $stmt->close();
    } else {
        echo "Jumlah tidak valid.";
    }
} else {
    echo "Permintaan tidak valid.";
}
$conn->close();
?>