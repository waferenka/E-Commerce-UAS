<?php
session_start();
include 'koneksi.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: login/login_form.php");
    exit;
}

$userid = $_SESSION['userid']; // Ambil user ID dari session

// Query untuk mengambil data user dari database
$sql = "SELECT u.id, u.nama, u.email, d.jenis_kelamin, d.tanggal_lahir, d.alamat, d.no_telepon 
        FROM tbluser u 
        LEFT JOIN user_detail d ON u.id = d.id 
        WHERE u.id = '$userid'";

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama = $row['nama'];
    $email = $row['email'];
    $jenis_kelamin = $row['jenis_kelamin'];
    $tanggal_lahir = $row['tanggal_lahir'];
    $alamat = $row['alamat'];
    $no_telepon = $row['no_telepon'];
} else {
    echo "Data user tidak ditemukan.";
}

// Proses update data user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_baru = $_POST['nama'];
    $email_baru = $_POST['email'];
    $jenis_kelamin_baru = $_POST['jenis_kelamin'];
    $tanggal_lahir_baru = $_POST['tanggal_lahir'];
    $alamat_baru = $_POST['alamat'];
    $no_telepon_baru = $_POST['no_telepon'];

    // Update tbluser
    $sql_update_user = "UPDATE tbluser SET nama = ?, email = ? WHERE id = ?";
    $stmt_user = $conn->prepare($sql_update_user);
    $stmt_user->bind_param('ssi', $nama_baru, $email_baru, $userid);
    $stmt_user->execute();

    // Update user_detail
    $sql_update_detail = "UPDATE user_detail SET jenis_kelamin = ?, tanggal_lahir = ?, alamat = ?, no_telepon = ? WHERE id = ?";
    $stmt_detail = $conn->prepare($sql_update_detail);
    $stmt_detail->bind_param('ssssi', $jenis_kelamin_baru, $tanggal_lahir_baru, $alamat_baru, $no_telepon_baru, $userid);
    $stmt_detail->execute();

    // Redirect setelah update
    header("Location: detail.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Metadata -->
    <?php include('metadata.php'); ?>
    <title>Ubah Data</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- My Style -->
    <link rel="stylesheet" href="css/bootstrap_style.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    html,
    body {
        width: 100%;
    }

    .navbar {
        position: fixed;
    }


    footer {
        width: 100%;
    }

    h4 {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand ms-2 font-weight-bold" href="index.php">
                Alzi Petshop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <div class="navbar-item">
                    <a href="#"><img class="me-3" src="imgs/keranjang.png"></a>
                    <a href="detail.php"><img src="<?php echo $foto; ?>"
                            class="rounded-circle me-2"><?php echo $nama; ?></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">Ubah Data</h4>
                        <form method="post" action="">
                            <div class="form-group mb-3">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="<?php echo $nama; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jenis_kelamin">Jenis Kelamin:</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki"
                                        <?php if ($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                    <option value="Perempuan"
                                        <?php if ($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_lahir">Tanggal Lahir:</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="<?php echo $tanggal_lahir; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat:</label>
                                <textarea class="form-control" id="alamat" name="alamat"
                                    required><?php echo $alamat; ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="no_telepon">No. Telepon:</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                    value="<?php echo $no_telepon; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                            <a href="detail.php" class="btn btn-danger">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <p class="p-3">Create by Alzi Petshop | &copy 2024</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>