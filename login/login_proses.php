<?php
// Mengaktifkan session pada PHP
session_start();

// Menghubungkan PHP dengan koneksi database
include '../php/php.php';

// Menangkap data yang dikirim dari form login
$email = $_POST['email'];
$password = sha1($_POST['password']);

// Menyeleksi data user dengan email dan password yang sesuai
$login = mysqli_query($conn, "SELECT * FROM tbluser WHERE email='$email' AND password='$password'");
// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// Cek apakah email dan password ditemukan pada database
if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    // Buat session login dan user ID
    $_SESSION['userid'] = $data['id'];
    $_SESSION['email'] = $email;
    $_SESSION['level'] = $data['level'];

    // Alihkan ke halaman sesuai level user
    if ($data['level'] == "admin") {
        header("Location: ../index_a.php");
    } elseif ($data['level'] == "penjual") {
        header("Location: ../index_p.php");
    } elseif ($data['level'] == "pembeli") {
        header("Location: ../index.php");
    } else {
        header("Location: login_form.php?error=Invalid user level");
    }
} else {
    header("Location: login_form.php?error=Email atau Password salah");
}
?>