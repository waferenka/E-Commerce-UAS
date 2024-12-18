<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tidak Berizin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            position: relative;
            height: 100vh;
        }

        .item {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
        }

        @media (max-width: 436px) {
            .item {
                font-size: 14px;
                width: 90%;
            }
            .btn {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="item">
        <h2 class="text-center text-danger">Akses Ditolak</h2>
        <p class="text-center">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="text-center">
            <a href="logout.php" class="btn btn-primary">Kembali ke Login</a>
        </div>
    </div>
    </div>
</body>
</html>
