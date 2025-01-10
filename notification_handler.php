<?php
// Mulai session jika diperlukan
session_start();

// Pastikan content type adalah JSON
header("Content-Type: application/json");

// Ambil input JSON dari request body
$input = file_get_contents('php://input');

// Log request untuk debug
file_put_contents('notification_log.txt', $input . PHP_EOL, FILE_APPEND);

// Decode input JSON menjadi array
$data = json_decode($input, true);

if ($data) {
    // Ekstrak data dari notifikasi Midtrans
    $transaction_id = $data['transaction_id'] ?? '';
    $order_id = $data['order_id'] ?? '';
    $payment_type = $data['payment_type'] ?? '';
    $transaction_status = $data['transaction_status'] ?? '';
    $gross_amount = $data['gross_amount'] ?? '0.00';
    $settlement_time = $data['transaction_time'] ?? null; // Gunakan transaction_time karena settlement_time tidak selalu tersedia

    // Tentukan status transaksi
    $status = match ($transaction_status) {
        'settlement' => 'success',
        'pending' => 'pending',
        'expire' => 'expire',
        'cancel' => 'cancel',
        default => 'pending',
    };

    // Koneksi database menggunakan mysqli
    include 'php/php.php'; // Koneksi ke database

    // Persiapkan query untuk insert/update data transaksi
    $stmt = $conn->prepare("
        INSERT INTO transactions (transaction_id, order_id, payment_type, transaction_status, gross_amount, payment_time)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        transaction_status = ?, 
        gross_amount = ?, 
        update_time = CURRENT_TIMESTAMP()
    ");

    // Bind parameters untuk query
    $stmt->bind_param(
        'sssssss', // Tipe data untuk parameter (string untuk semua)
        $transaction_id, $order_id, $payment_type, $status, $gross_amount, $settlement_time, $status, $gross_amount
    );

    // Eksekusi query
    if ($stmt->execute()) {
        echo json_encode(["message" => "Notification handled successfully."]);
    } else {
        echo json_encode(["error" => "Failed to update database."]);
    }

    // Tutup statement
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid input received."]);
}
?>