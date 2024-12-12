<?php
// Mengaktifkan session pada PHP
session_start();

// Menghubungkan PHP dengan koneksi database
include '../koneksi.php';

// Menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = sha1($_POST['password']);

// Menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($conn, "SELECT * FROM tbluser WHERE username='$username' AND password='$password'");
// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// Cek apakah username dan password ditemukan pada database
if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    // Buat session login dan username
    $_SESSION['username'] = $username;
    $_SESSION['level'] = $data['level'];

    // Cek jika user login sebagai admin
    if ($data['level'] == "admin") {
        // Alihkan ke halaman dashboard admin
        header("Location: ../index.php");
    // Cek jika user login sebagai dosen
    } elseif ($data['level'] == "dosen") {
        // Alihkan ke halaman dashboard dosen
        header("Location: ../index_dosen.php");
    // Cek jika user login sebagai mahasiswa
    } elseif ($data['level'] == "mahasiswa") {
        // Alihkan ke halaman dashboard mahasiswa
        header("Location: ../index_mahasiswa.php");
    } else {
        // Alihkan ke halaman login kembali dengan pesan error
        header("Location: login_form.php?error=Invalid user level");
    }
} else {
    // Alihkan ke halaman login kembali dengan pesan error
    header("Location: login_form.php?error=Username atau password salah");
}
?>