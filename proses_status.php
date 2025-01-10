<?php
include('php/php.php');
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
// Data yang akan diubah
$new_status = "Success"; // Value baru untuk transaction_status

// Query untuk mengganti value transaction_status
$sql = "UPDATE transactions SET transaction_status = ? WHERE order_id = ?";

// Persiapan statement
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind parameter
    $stmt->bind_param("ss", $new_status, $order_id);
    
    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Transaction status berhasil diperbarui.";
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
