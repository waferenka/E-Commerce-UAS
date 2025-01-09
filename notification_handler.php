<?php
require_once 'midtrans-php/Midtrans.php';
require('php/php.php');

// Konfigurasi Midtrans
require('midtrans_config.php');

// Baca payload JSON
$json_body = file_get_contents('php://input');
file_put_contents('notification_debug_log.txt', $json_body . PHP_EOL, FILE_APPEND);


$notification = json_decode($json_body, true);


// Validasi jenis payload
if (isset($notification['transaction_status'])) {
    // Transaksi reguler
    $order_id = $notification['order_id'];
    $transaction_status = $notification['transaction_status'];
    $payment_type = $notification['payment_type'];
    $gross_amount = $notification['gross_amount'];
    $transaction_time = $notification['transaction_time'];
    $customer_email = $notification['customer_details']['email'] ?? 'Unknown';
    echo "k";
    echo `$order_id , $transaction_status , $payment_type , $gross_amount , $transaction_time`;
    // Simpan ke database
    save_transaction($order_id, $transaction_status, $payment_type, $gross_amount, $transaction_time, $customer_email);

} elseif (isset($notification['account_status'])) {
    // Notifikasi akun (account_linked)
    $account_status = $notification['account_status'];
    file_put_contents('notification_account_log.txt', "Account Status: $account_status" . PHP_EOL, FILE_APPEND);
    echo "b";
} elseif (isset($notification['schedule'])) {
    // Notifikasi subscription
    $subscription_id = $notification['id'];
    $status = $notification['status'];
    $amount = $notification['amount'];
    file_put_contents('notification_subscription_log.txt', "Subscription: $subscription_id, Status: $status, Amount: $amount" . PHP_EOL, FILE_APPEND);
    echo "c";
} else {
    $order_id = $notification['order_id'];
    $transaction_status = $notification['transaction_status'];
    $payment_type = $notification['payment_type'];
    $gross_amount = $notification['gross_amount'];
    $transaction_time = $notification['transaction_time'];
    $customer_email = $notification['customer_details']['email'] ?? 'Unknown';
    echo "z";
    echo `$order_id, $transaction_status, $payment_type, $gross_amount, $transaction_time, $customer_email`;
    // Notifikasi tidak dikenal
    file_put_contents('notification_unknown_log.txt', $json_body . PHP_EOL, FILE_APPEND);
}

// Respon sukses ke Midtrans
http_response_code(200);
echo json_encode(['message' => 'Notification handled successfully']);

// Fungsi untuk menyimpan transaksi ke database
function save_transaction($order_id, $transaction_status, $payment_type, $amount, $time, $email) {
    require('php/php.php');
    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk menyimpan data
    $sql = "INSERT INTO transaction (order_id, transaction_status, payment_type, amount, transaction_time, email)
            VALUES ('$order_id', '$transaction_status', '$payment_type', '$amount', '$time', '$email')";

    if ($conn->query($sql) === TRUE) {
        file_put_contents('transaction_log.txt', "Transaction saved: $order_id" . PHP_EOL, FILE_APPEND);
        echo "abc";
    } else {
        file_put_contents('transaction_log.txt', "Error: " . $conn->error . PHP_EOL, FILE_APPEND);
        echo "def";
    }

    $conn->close();
}
?>