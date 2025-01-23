<?php
// Memulai sesi untuk mengecek status login
session_start();

// Mengecek apakah variabel sesi 'login' sudah diset atau belum.
// Jika belum, arahkan pengguna ke halaman login.php.
if (!isset($_SESSION['login'])) {
    header('Location: login.php'); // Mengarahkan ke halaman login
    exit; // Menghentikan eksekusi skrip setelah pengalihan
}

// Jika sudah login, arahkan ke halaman dashboard.php
header('Location: dashboard.php');
exit; // Menghentikan eksekusi skrip setelah pengalihan
