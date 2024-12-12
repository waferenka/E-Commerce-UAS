<!-- Seesion Start -->
<?php
session_start();
if (isset($_SESSION['email'])) {
    if ($_SESSION['level'] == "admin") {
        header("Location: ../index.php");
    } elseif ($_SESSION['level'] == "penjual") {
        header("Location: ../index_dosen.php");
    } elseif ($_SESSION['level'] == "pembeli") {
        header("Location: ../index_mahasiswa.php");
    } else {
        header("Location: login_form.php");
    }
    exit;
}
?>
<!-- Session End -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- My Style -->
    <link rel="stylesheet" href="../css/bootstrap_style.css">
</head>

<body>
    <!-- Navbar Start -->
    <nav class=" navbar navbar-expand-lg bg-body-secondary">
        <div class="container-fluid ms-3 me-3">
            <a class="navbar-brand me-4 logo" href="../index.php">
                <img class="me-3" src="../favicon.ico" alt="">Alzi Petshop</a>
        </div>
    </nav>
    <!-- Navbar End -->
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 25rem;">
            <div class="card-body"">
                <h2 class=" text-center mt-2 mb-4">Login</h2>
                <?php
                if (isset($_GET['error']) && $_GET['error'] != '') {
                    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_GET['error']) . '</div>';
                }
                ?>
                <form action="login_proses.php" method="post">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group text-center mb-3">
                        <button type="submit" class="btn btn-warning form-control">Login</button>
                    </div>
                    <div class="form-group text-center">
                        <p class="mb-0">Anda tidak punya akun? <a href="www.google.com">Klik disini</a></p>
                    </div>
                </form>
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