<?php
require '../koneksi.php';

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $level = "pembeli";
    $default_foto = 'imgs/user.png'; // Path foto default

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Insert ke table tbluser
        $query = "INSERT INTO tbluser (nama, email, password, level) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $nama, $email, $password, $level);

        if (!$stmt->execute()) {
            throw new Exception("Pendaftaran gagal. Email mungkin sudah digunakan.");
        }

        // Dapatkan ID user yang baru dimasukkan
        $user_id = $stmt->insert_id;

        // Insert ke table user_detail dengan foto default
        $query_detail = "INSERT INTO user_detail (id, foto) VALUES (?, ?)";
        $stmt_detail = $conn->prepare($query_detail);
        $stmt_detail->bind_param('is', $user_id, $default_foto);

        if (!$stmt_detail->execute()) {
            throw new Exception("Gagal menyimpan detail pengguna.");
        }

        // Jika semua berhasil, commit transaksi
        $conn->commit();
        header('Location: login_form.php');
        exit;
    } catch (Exception $e) {
        // Jika terjadi kesalahan, rollback transaksi
        $conn->rollback();
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Metadata -->
    <?php include('../metadata.php'); ?>
    <title>Login</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- My Style -->
    <link rel="stylesheet" href="../css/bootstrap_style.css">
    <style>
    @font-face {
        font-family: Rubik;
        src: url("../font/Rubik-Regular.ttf");
    }

    html,
    body {
        font-family: Rubik;
        overflow-y: auto;
    }

    .navbar {
        position: fixed;
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

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <div class="container-fluid ms-3 me-3">
            <a class="navbar-brand" style="font-weight: bold;" href="#">
                Alzi Petshop
            </a>
        </div>
    </nav>
    <!-- Navbar End -->
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 33rem;">
            <div class="card-body">
                <h2 class=" text-center font-weight-bold mt-2 mb-4">Register</h2>
                <?php
                    if (isset($error) && $error != '') {
                        echo '<div class="alert alert-danger text-center">' . htmlspecialchars($error) . '</div>';
                    }
                ?>
                <form action="#" method="post">
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group text-center mb-3">
                        <div class="form-group text-center mb-3">
                            <button type="submit" name="register" class="btn btn-warning form-control">Register</button>
                            <a href="../index.php" type="reset" name="cancel"
                                class="btn btn-danger w-100 mt-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br><br><br>
    <footer class="fixed-bottom text-center">
        <p class="pt-3">Create by Alzi Petshop | &copy 2024</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>