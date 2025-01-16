<?php

session_start();

// Koneksi ke database
require('php/php.php');

// Periksa apakah user sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: landing_page.php");
    exit;
}

if ($_SESSION['level'] != "pembeli") {
    header("Location: login/login_form.php");
    exit;
}

$userid = $_SESSION['userid']; // Ambil user ID dari session

// Query untuk mengambil data dari kedua tabel
$sql = "SELECT u.id, u.nama, u.email, u.level, d.foto, d.jenis_kelamin, d.tanggal_lahir, d.alamat, d.no_telepon 
FROM tbluser u 
LEFT JOIN user_detail d ON u.id = d.id 
WHERE u.id = '$userid'";

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
$row = mysqli_fetch_assoc($result);
$foto = $row['foto'];
$nama = $row['nama'];
$email = $row['email'];
$level = $row['level'];
$jenis_kelamin = $row['jenis_kelamin'];
$tanggal_lahir = $row['tanggal_lahir'];
$alamat = $row['alamat'];
$no_telepon = $row['no_telepon'];
} else {
echo "Data user tidak ditemukan.";
}


// Mengambil order_id dengan GET
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : '';

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
        t.item_details,
        t.snap_token
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
        $snap_token = htmlspecialchars($row['snap_token']);
    } else {
        $name = htmlspecialchars($row['name']);
        $transaction_status = htmlspecialchars($row['transaction_status']);
        $gross_amount = htmlspecialchars($row['gross_amount']);
        $shipping_status = htmlspecialchars($row['shipping_status']);
        $shipping_status_id = intval($row['shipping_status_id']);
        $payment_time = htmlspecialchars($row['payment_time']);
        $item_details = json_decode($row['item_details'], true);
        $snap_token = htmlspecialchars($row['snap_token']);
        echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
        echo $name;
        echo $transaction_status;
        echo $gross_amount;
        echo $shipping_status;
        echo $shipping_status_id;
        echo $payment_time;
        echo $item_details;
        echo $snap_token;
        exit;
    }

    $stmt->close();
} else {
    echo '<div class="alert alert-danger">Kesalahan dalam menyiapkan query.</div>';
    exit;
}
//Nama Depan
function getFirstName($fullName) {
    $parts = explode(" ", $fullName);
    return $parts[0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <!-- Metadata -->
    <?php include('metadata.php'); ?>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- My Style -->
    <link rel="stylesheet" href="../css/bootstrap_style.css">
    <style>
    html,
    body {
        overflow-y: auto;
    }

    .navbar {
        position: sticky;
        z-index: 1000;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    footer {
        width: 100%;
        background-color: white;
    }
    </style>
</head>

<body class="mt-5">
    <!-- Navbar start -->
    <?php require('php/navbar.php'); ?>
    <!-- Navbar End -->
    <div class="container vh-100 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Detail Transaksi</h3>
                    </div>
                    <div class="card-body">
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
                            <?php if ($transaction_status === "success"): ?>
                            <tr>
                                <th>Waktu Pembayaran</th>
                                <td><?= $payment_time ?></td>
                            </tr>
                            <?php endif; ?>
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
    <!-- Footer start -->
    <footer class="text-center">
        <p>Create by Alzi Petshop | &copy 2024</p>
    </footer>
    <!-- Footer End -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>