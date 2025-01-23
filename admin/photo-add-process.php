<?php
require '../includes/koneksi.php';

// Membuat instance dari class Koneksi
$koneksi = new Koneksi();
$con = $koneksi->getConnection();

/**
 * Fungsi untuk mengambil data kategori
 */
function getKategori()
{
    global $con;
    $query = "SELECT id, name FROM tb_category";
    $result = $con->query($query);

    if (!$result) {
        die("Error: " . $con->error);
    }

    $kategori = [];
    while ($row = $result->fetch_assoc()) {
        $kategori[] = $row;
    }

    return $kategori;
}

/**
 * Fungsi untuk menambahkan data portofolio
 */
function tambah($post)
{
    global $con;

    // Validasi input
    $judul = filter_var(trim($post['judul']), FILTER_SANITIZE_STRING);
    $status = filter_var(trim($post['status']), FILTER_VALIDATE_INT);
    $category_id = filter_var($post['category_id'], FILTER_VALIDATE_INT);

    if (!$judul || ($status !== 0 && $status !== 1) || !$category_id) {
        echo "Input tidak valid.";
        return false;
    }

    // Mengatur direktori upload
    $target_dir = "../uploads/";
    $file = $_FILES["photo"];
    $file_name = basename($file["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_type, $allowed_types)) {
        echo "Error: Hanya file dengan ekstensi jpg, jpeg, png, dan gif yang diperbolehkan.";
        return false;
    }

    // Validasi ukuran file (contoh: maksimal 5MB)
    if ($file["size"] > 5 * 1024 * 1024) {
        echo "Error: Ukuran file terlalu besar (maksimal 5MB).";
        return false;
    }

    // Memindahkan file yang diupload
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Menggunakan prepared statement untuk mencegah SQL Injection
        $sql = "INSERT INTO tb_portofolio (photo, judul, photoaktif, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            echo "Error: " . $con->error;
            return false;
        }

        $stmt->bind_param("ssii", $file_name, $judul, $status, $category_id);

        // Menjalankan query
        if ($stmt->execute()) {
            echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location.href = 'photo.php';
            </script>";
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    } else {
        echo "Error: Gagal mengupload file.";
        return false;
    }
}
