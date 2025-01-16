<?php
// Set API credentials
$serverKey = 'SB-Mid-server-hI81QFjkGWJvQmZhcWea5GUU'; // Ganti dengan server key Anda
$snapToken = 'e43f78fa-182c-4d26-8702-31de9ba96fa2'; // Ganti dengan snap token yang akan diverifikasi

// Setup cURL request
$url = "https://api.sandbox.midtrans.com/v2/{$snapToken}/status"; // Endpoint untuk status transaksi

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode($serverKey . ":")
]);

// Execute request and capture response
$response = curl_exec($ch);
curl_close($ch);

// Decode JSON response
$responseData = json_decode($response, true);

// Check if the response is valid
if ($responseData['status_code'] === '200') {
    echo "Token valid. Status: " . $responseData['transaction_status'];
} else {
    echo "Error: " . $responseData['status_message'];
}
?>