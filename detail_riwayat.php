<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Detail Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Koneksi ke database
                        require('php/php.php');

                        // Mengambil order_id dengan GET
                        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

                        // Jika tombol konfirmasi diklik
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
                            $update_query = "UPDATE shipping_detail SET status_pengiriman = 6 WHERE order_id = ?";
                            $update_stmt = $conn->prepare($update_query);
                            $update_stmt->bind_param("s", $order_id); // Gunakan tipe data string untuk order_id
                            if ($update_stmt->execute()) {
                                echo '<div class="alert alert-success">Status pengiriman berhasil diperbarui menjadi "Selesai"!</div>';
                            } else {
                                echo '<div class="alert alert-danger">Gagal memperbarui status pengiriman.</div>';
                            }
                            $update_stmt->close();
                        }

                        // Query untuk mengambil data transaksi
                        $query = "
                            SELECT 
                                t.transaction_id,
                                u.nama AS name,
                                t.order_id,
                                t.transaction_status,
                                t.gross_amount,
                                ss.status_pengiriman AS shipping_status,
                                sd.status_pengiriman AS shipping_status_id,
                                t.payment_time,
                                t.update_time,
                                t.item_details
                            FROM transactions t
                            LEFT JOIN tbluser u ON t.user_id = u.id
                            LEFT JOIN shipping_detail sd ON t.order_id = sd.order_id
                            LEFT JOIN shipping_status ss ON sd.status_pengiriman = ss.id
                            WHERE t.order_id = ?
                        ";

                        $stmt = $conn->prepare($query);
                        if ($stmt) {
                            $stmt->bind_param("s", $order_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Cek apakah data ditemukan
                            if ($result && $row = $result->fetch_assoc()) {
                                $name = htmlspecialchars($row['name']);
                                $transaction_status = htmlspecialchars($row['transaction_status']);
                                $gross_amount = htmlspecialchars($row['gross_amount']);
                                $shipping_status = htmlspecialchars($row['shipping_status']);
                                $shipping_status_id = intval($row['shipping_status_id']);
                                $payment_time = htmlspecialchars($row['payment_time']);
                                $item_details = json_decode($row['item_details'], true);
                            } else {
                                echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
                                exit;
                            }

                            $stmt->close();
                        } else {
                            echo '<div class="alert alert-danger">Kesalahan dalam menyiapkan query.</div>';
                            exit;
                        }
                        ?>
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Nama</th>
                                <td><?= $name ?></td>
                            </tr>
                            <tr>
                                <th>Order ID</th>
                                <td><?= $order_id ?></td>
                            </tr>
                            <tr>
                                <th>Status Transaksi</th>
                                <td><?= $transaction_status ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td><?= $gross_amount ?></td>
                            </tr>
                            <?php if ($item_details): ?>
                            <tr>
                                <th>Item Names</th>
                                <td>
                                    <?php
                                        $item_names = array_map(function ($item) {
                                            return htmlspecialchars($item['name']);
                                        }, $item_details);
                                        echo implode(", ", $item_names);
                                        ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Item Quantities</th>
                                <td>
                                    <?php
                                        $item_quantities = array_map(function ($item) {
                                            return htmlspecialchars($item['quantity']);
                                        }, $item_details);
                                        echo implode(", ", $item_quantities);
                                        ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th>Status Pengiriman</th>
                                <td>
                                    <?= $shipping_status ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Waktu Pembayaran</th>
                                <td><?= $payment_time ?></td>
                            </tr>
                        </table>
                        <div class="container-fluid d-flex justify-content-between">
                            <div class="a">
                                <?php if ($shipping_status_id === 5): ?>
                                <form method="post">
                                    <button type="submit" name="confirm" class="btn btn-success mt-3">Konfirmasi
                                        Pengiriman</button>
                                </form>
                                <?php endif; ?>
                            </div>
                            <div class="b">
                                <a href="php/php-dompdf.php?order_id=<?php echo $order_id ?>"
                                    class="btn btn-warning mt-3">Download Invoice</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>