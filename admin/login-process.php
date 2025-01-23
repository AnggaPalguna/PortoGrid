<?php
session_start();

require '../includes/koneksi.php';

$koneksi = new Koneksi();
$con = $koneksi->getConnection(); // Mendapatkan koneksi database menggunakan metode getConnection().

// Mengamankan input dari pengguna dengan fungsi real_escape_string untuk mencegah SQL Injection.
$username = mysqli_real_escape_string($con,  $_POST['username']); // Mengamankan input username dari form login.
$password = mysqli_real_escape_string($con, $_POST['password']); // Mengamankan input password dari form login.

// Query SQL untuk memeriksa apakah ada data login yang cocok di database.
$query = mysqli_query($con, "select * from tb_login where username='$username' and password='$password'");

// Mengecek jumlah baris yang dikembalikan dari query.
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    // Jika ada kecocokan, buat sesi login untuk pengguna.
    $_SESSION['login'] = $username;
    // Arahkan pengguna ke halaman dashboard.php.
    header("location:dashboard.php");
} else {
    // Jika login gagal, tampilkan pesan error dan arahkan kembali ke halaman login.
    echo " <script> alert('Login Gagal');
    windows:location='login.php' </script> ";
}
