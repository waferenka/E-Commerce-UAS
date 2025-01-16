<?php
ob_start();  // Mulai output buffering
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Fungsi validasi data transaksi
function validate_data($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$dompdf = new Dompdf();

// Simulasi data transaksi (sesuaikan dengan data real)
$store_name = validate_data("Alzi Petshop");
$order_id = validate_data("12345");
$customer_name = validate_data("John Doe");
$transaction_date = validate_data("2025-01-13");
$items = [
    ['name' => 'Cat Food Premium', 'quantity' => 2, 'unit_price' => 90000, 'total' => 180000],
    ['name' => 'Cat Toy - Mouse', 'quantity' => 1, 'unit_price' => 25000, 'total' => 25000],
];
$total_price = 205000;
$payment_type = validate_data("QRIS");
$transaction_status = validate_data("Success");
$logo_url = "https://via.placeholder.com/150x60?text=Petshop+Logo";

// Buat template HTML
$html = "
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #212529;
        margin: 0;
        padding: 0;
    }
    .invoice-box {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        background: #ffffff;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
    }
    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .invoice-header h1 {
        margin: 0;
        font-size: 28px;
        color: #007bff;
    }
    .invoice-header img {
        height: 60px;
    }
    .invoice-details table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .invoice-details th, .invoice-details td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .invoice-details th {
        background: #007bff;
        color: #ffffff;
    }
    .total {
        font-weight: bold;
        text-align: right;
    }
    .footer {
        text-align: center;
        margin-top: 20px;
        font-size: 12px;
        color: #6c757d;
    }
</style>

<div class='invoice-box'>
    <div class='invoice-header'>
        <h1>Invoice</h1>
        <img src='$logo_url' alt='Petshop Logo'>
    </div>
    <p><strong>$store_name</strong></p>
    <p>Order ID: $order_id</p>
    <p>Customer Name: $customer_name</p>
    <p>Date: $transaction_date</p>
    <div class='invoice-details'>
        <table>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>";

foreach ($items as $item) {
    $html .= "
            <tr>
                <td>" . validate_data($item['name']) . "</td>
                <td>" . validate_data($item['quantity']) . "</td>
                <td>IDR " . number_format($item['unit_price'], 0, ',', '.') . "</td>
                <td>IDR " . number_format($item['total'], 0, ',', '.') . "</td>
            </tr>";
}

$html .= "
            <tr>
                <td colspan='3' class='total'>Total</td>
                <td class='total'>IDR " . number_format($total_price, 0, ',', '.') . "</td>
            </tr>
        </table>
    </div>
    <p>Payment Type: $payment_type</p>
    <p>Status: $transaction_status</p>
    <div class='footer'>
        <p>Thank you for shopping with us!</p>
        <p>Contact us at: support@alzishop.com | +62 812 3456 7890</p>
    </div>
</div>
";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
ob_end_clean();  // Hapus buffer output sebelumnya
$dompdf->stream("invoice_$order_id.pdf", ["Attachment" => true]);
?>