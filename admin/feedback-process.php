<?php
// Menyertakan file koneksi database untuk mengakses class Koneksi.
include '../includes/koneksi.php';

// Membuat instance dari class Koneksi untuk mendapatkan koneksi database.
$koneksi = new Koneksi();
$con = $koneksi->getConnection(); // Memanggil metode getConnection untuk mendapatkan objek koneksi database.

// Mengamankan input pengguna dengan metode real_escape_string untuk mencegah SQL Injection.
$email = $con->real_escape_string($_POST['email']); // Menyaring input email dari form.
$fullname = $con->real_escape_string($_POST['name']); // Menyaring input nama lengkap dari form.
$query = $con->real_escape_string($_POST['query']); // Menyaring input query atau pesan dari form.

// Query SQL untuk menyisipkan data ke tabel tb_feedback menggunakan prepared statement.
$sql = "INSERT INTO tb_feedback (id, name, email, query) VALUES (NULL, ?, ?, ?)";

// Mempersiapkan statement SQL.
$stmt = $con->prepare($sql);

// Mengikat parameter input ($fullname, $email, $query) ke dalam query SQL.
// "sss" menunjukkan bahwa ketiga parameter bertipe string.
$stmt->bind_param("sss", $fullname, $email, $query);

// Menjalankan statement untuk menyisipkan data ke database.
$stmt->execute();

// Mengarahkan pengguna ke halaman index setelah data berhasil disimpan.
header("location:../index.php");
