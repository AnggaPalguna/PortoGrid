<?php

require '../includes/koneksi.php';

// Membuat instance dari class Koneksi
$koneksi = new Koneksi();
$con = $koneksi->getConnection();

// Mendapatkan file yang akan dihapus
if (isset($_GET['photo'], $_GET['id'])) {
    $photoPath = 'C:/xampp/htdocs/PortoGrid/uploads/' . $_GET['photo'];
    $id = $con->real_escape_string($_GET['id']);

    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM tb_portofolio WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);

    // Mengeksekusi query
    if ($stmt->execute()) {
        // Menghapus file foto jika query berhasil
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
        header('Location: photo.php');
    } else {
        echo "<script>
            alert('Gagal menghapus data.');
            window.location.href = 'photo.php';
            </script>";
    }
} else {
    echo "<script>
        alert('ID atau file tidak ditemukan.');
        window.location.href = 'photo.php';
        </script>";
}
