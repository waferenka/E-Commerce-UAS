<?php
include('php/php.php');
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$new_status = "Success";

$sql = "UPDATE transactions SET transaction_status = ? WHERE order_id = ?";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ss", $new_status, $order_id);
        if ($stmt->execute()) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    } else {
        echo "Gagal memperbarui transaction status: " . $stmt->error;
    }
    
    // Tutup statement
    $stmt->close();
} else {
    echo "Gagal mempersiapkan statement: " . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
