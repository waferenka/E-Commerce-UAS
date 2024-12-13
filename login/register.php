<?php
require '../koneksi.php';

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $level = "Pembeli";

    $query = "INSERT INTO tbluser (nama, email, password, level) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $nama, $email, $password, $level);

    if ($stmt->execute()) {
        header('Location: login_form.php');
        exit;
    } else {
        $error = "Pendaftaran gagal. Email mungkin sudah digunakan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- My Style -->
    <link rel="stylesheet" href="../css/bootstrap_style.css">

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
        justify-content: center;
        align-items: center;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    form {
        width: 80%;
        height: 50%;
    }

    .table_custom {
        /* --bs-table-bg: transparent !important; */
    }

    th {
        text-align: center;
        vertical-align: middle;
    }

    th .form-label {
        display: block;
        text-align: center;
    }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar Start -->
    <nav class="navbar bg-body-secondary">
        <div class="container-fluid ms-3 me-3">
            <a class="navbar-brand me-4 logo" href="#">
                <img class="me-3" src="../favicon.ico" alt="">Alzi Petshop</a>
        </div>
    </nav>
    <!-- Navbar End -->
    <div class="container">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
        <?php endif; ?>
        <form action="#" method="post">
            <table class="table table-bordered table_custom">
                <tbody>
                    <tr>
                        <th colspan="2" scope="row">
                            <h2 class="text-center">Register</h2>
                        </th>
                    </tr>
                    <tr>
                        <th scope="row"><label for="nama" class="form-label">Nama</label></th>
                        <td><input type="text" name="nama" id="nama" class="form-control" required></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email" class="form-label">Email</label></th>
                        <td><input type="email" name="email" id="email" class="form-control" required></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="password" class="form-label">Password</label></th>
                        <td><input type="password" name="password" id="password" class="form-control" required></td>
                    </tr>

                    <tr>
                        <th scope="row"><a href="../index.php" type="reset" name="cancel"
                                class="btn btn-danger w-100 mt-2">Cancel</a></th>
                        <td><button type="submit" name="register" class="btn btn-warning w-100 mt-2">Register</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <footer class="text-center">
        <p>Create by Alzi Petshop | &copy 2024</p>
    </footer>
</body>

</html>