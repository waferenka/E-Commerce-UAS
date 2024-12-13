<?php
session_start();
include 'koneksi.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['userid'])) {
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- My Style -->
    <link rel="stylesheet" href="css/bootstrap_style.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    html,
    body {
        overflow-y: hidden;
        width: 100%;
        height: 100%;
    }

    .container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    h4 {
        text-align: center;
        font-weight: bold;
    }

    table a {
        color: var(--secondary-color);
        text-decoration: none;
    }

    table a:hover {
        color: black;
    }

    form {
        width: 100%;
        height: 50%;
    }

    .img-user {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .row {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
    }

    @media (max-width: 768px) {

        html,
        body {
            overflow-y: auto;
        }

        .container {
            margin-top: 5rem;
        }

        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            display: flex;
        }

        #user {
            display: inline;
        }

        footer {
            position: static;
            bottom: 0;
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <!-- Navbar, Search, Keranjang, User -->
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
                    <a href="#"><img class="me-3" src="imgs/cart.png"></a>
                    <a href="detail.php"><img src="<?php echo $foto; ?>"
                            class="rounded-circle me-2"><?php echo $nama; ?></a>
                </div>
            </div>
    </nav>
    <!-- End Navbar, Search, Keranjang, User -->
    <div class="container">
        <div class="row">
            <div class="col-md-3 pe-5">
                <div class="img-user text-center">
                    <img src="<?php echo $foto; ?>" class="profile-img" alt="Foto Profil">
                    <h3 class="mt-3"><?php echo $nama; ?></h3>
                    <a href="#" class="container-fluid btn btn-warning mt-3">Ubah Foto Profil</a>
                    <a href="#" class="container-fluid btn btn-warning mt-2">Ubah Kata Sandi</a>
                </div>
            </div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="4">
                                <h4>Profile Saya</h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td><?php echo $nama; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td><?php echo $email; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>:</td>
                            <td><?php echo $level; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>:</td>
                            <td><?php echo $jenis_kelamin; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>:</td>
                            <td><?php echo $tanggal_lahir; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>:</td>
                            <td><?php echo $alamat; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>:</td>
                            <td><?php echo $no_telepon; ?></td>
                            <td><a href="#">ubah</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <p>Create by Alzi Petshop | &copy 2024</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>