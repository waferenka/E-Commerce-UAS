<?php
session_start();
// Koneksi database
require 'koneksi.php';
if (!isset($_SESSION['userid'])) {
    header("Location: login/login_form.php");
    exit;
}

$userid = $_SESSION['userid']; // Ambil user ID dari session

// Menangkap data yang dikirim dari form
if (isset($_POST["submit"])) {
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validasi password lama
    $sql = "SELECT password FROM tbluser WHERE id = '$userid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (sha1($old_password) === $row['password']) {
        if ($new_password === $confirm_password) {
            $new_password_encrypted = sha1($new_password);
            $update_sql = "UPDATE tbluser SET password='$new_password_encrypted' WHERE id='$userid'";

            if (mysqli_query($conn, $update_sql)) {
                echo "<script>
                        alert('Kata sandi berhasil diubah');
                        document.location='index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Konfirmasi kata sandi tidak cocok.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Kata sandi lama tidak cocok.');
                window.history.back();
              </script>";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kata Sandi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Ubah Kata Sandi</h2>
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="old_password" class="form-label">Kata Sandi Lama</label>
                <input type="password" class="form-control" name="old_password" id="old_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Kata Sandi Baru</label>
                <input type="password" class="form-control" name="new_password" id="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi Baru</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Ubah Kata Sandi</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>