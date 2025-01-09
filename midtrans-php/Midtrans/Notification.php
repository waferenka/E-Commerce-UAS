<?php

namespace Midtrans;

class Notification
{
    private $response;

    public function __construct($input_source = "php://input")
    {
        // Membaca payload dari input
        $raw_notification = file_get_contents($input_source);

        // Log payload mentah untuk debugging
        file_put_contents("notification_log.txt", "RAW PAYLOAD: " . $raw_notification . PHP_EOL, FILE_APPEND);

        // Periksa jika payload kosong
        if (!$raw_notification || trim($raw_notification) === '') {
            file_put_contents("notification_log.txt", "ERROR: Empty notification payload received" . PHP_EOL, FILE_APPEND);
            throw new \Exception("Empty notification payload received");
        }
        

        // Decode JSON payload
        $decoded_notification = json_decode($raw_notification, true);

        // Log hasil decoding
        if (json_last_error() !== JSON_ERROR_NONE) {
            file_put_contents("notification_log.txt", "JSON DECODE ERROR: " . json_last_error_msg() . PHP_EOL, FILE_APPEND);
            throw new \Exception("Invalid JSON payload: " . json_last_error_msg());
        }

        // Periksa apakah transaction_id ada
        if (empty($decoded_notification['transaction_id'])) {
            throw new \Exception("Transaction ID is missing in the notification payload");
        }

        // Ambil status transaksi dari Midtrans
        try {
            $status_response = Transaction::status($decoded_notification['transaction_id']);
        } catch (\Exception $e) {
            file_put_contents("notification_log.txt", "API ERROR: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
            throw new \Exception("Failed to fetch transaction status: " . $e->getMessage());
        }

        // Periksa jika respons dari API tidak valid
        if (!$status_response || !is_object($status_response)) {
            throw new \Exception("Invalid response from Midtrans API");
        }

        // Set response ke properti
        $this->response = $status_response;
    }

    // Mengambil properti secara dinamis
    public function __get($name)
    {
        if (isset($this->response->$name)) {
            return $this->response->$name;
        }
    }

    // Mengambil seluruh respons
    public function getResponse()
    {
        return $this->response;
    }
}