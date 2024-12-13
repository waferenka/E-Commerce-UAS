<?php
    require '../koneksi.php';

    if (isset($_POST['register'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = sha1($_POST['password'], PASSWORD_BCRYPT);
        $level = "Pembeli";

        $query = "INSERT INTO tbluser (nama, email, password, level) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $nama, $email, $password, $level);

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
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>
        <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
        <?php endif; ?>
        <form action="#" method="post">
            <div class="form-group mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-warning w-100">Register</button>
        </form>
    </div>
</body>

</html>