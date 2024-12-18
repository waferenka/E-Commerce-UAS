<?php
session_start();
// Koneksi database
require 'koneksi.php';
if (!isset($_SESSION['userid'])) {
    header("Location: login/login_form.php");
    exit;
}

$userid = $_SESSION['userid']; // Ambil user ID dari session

// Ambil email user dari database
$query = "SELECT email FROM tbluser WHERE id = '$userid'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$email = $user['email'];

// Fungsi untuk membersihkan email menjadi nama file yang valid
function sanitize_filename($filename) {
    // Ganti karakter yang tidak valid dengan _
    return preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename);
}

if (isset($_POST["submit"])) {
    $target_dir = "imgs/user/";
    $sanitized_email = sanitize_filename($email); // Sanitize email untuk digunakan sebagai nama file
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $sanitized_email . "." . $imageFileType;
    $uploadOk = 1;

    // Cek apakah file gambar adalah gambar asli atau bukan
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Batasi format file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Cek apakah $uploadOk bernilai 0 karena error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // Jika semua cek lolos, coba upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            
            // Update path foto di database
            $sql = "UPDATE user_detail SET foto='$target_file' WHERE id='$userid'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Foto profil berhasil diubah');
                        document.location='index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Terjadi kesalahan saat mengubah foto profil. Silakan coba lagi.');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Foto Profil</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Ubah Foto Profil</h2>
        <form action="ubah_foto.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fileToUpload" class="form-label">Pilih file gambar untuk diupload:</label>
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Upload Gambar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>