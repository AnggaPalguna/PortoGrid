<?php
if (isset($_POST['submit'])) {
    require '../includes/koneksi.php';

    // Membuat instance dari class Koneksi
    $koneksi = new Koneksi();
    $con = $koneksi->getConnection();

    // Mengamankan input
    $id = $con->real_escape_string($_POST['id']);
    $judul = $con->real_escape_string($_POST['judul']);
    $status = $con->real_escape_string($_POST['status']);
    $category_id = $con->real_escape_string($_POST['category_id']);

    // Validasi input
    if (!$judul || ($status !== '0' && $status !== '1') || !$category_id) {
        echo "<script>
            alert('Input tidak valid.');
            window.location.href = 'photo-edit.php';
        </script>";
        exit;
    }

    if (!empty($_FILES['photo']['tmp_name'])) {
        // Proses jika ada file foto yang diupload
        $target_dir = "../uploads/";
        $photo_name = basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $photo_name;

        // Validasi tipe file
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $allowed_types)) {
            echo "<script>
                alert('Hanya file dengan ekstensi jpg, jpeg, png, dan gif yang diperbolehkan.');
                window.location.href = 'photo-edit.php';
            </script>";
            exit;
        }

        // Validasi ukuran file (maksimal 5MB)
        if ($_FILES["photo"]["size"] > 5 * 1024 * 1024) {
            echo "<script>
                alert('Ukuran file terlalu besar (maksimal 5MB).');
                window.location.href = 'photo-edit.php';
            </script>";
            exit;
        }

        // Memindahkan file
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Query untuk update termasuk foto
            $sql = "UPDATE tb_portofolio SET photo = ?, judul = ?, photoaktif = ?, category_id = ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssii", $photo_name, $judul, $status, $category_id, $id);
        } else {
            echo "<script>
                alert('Gagal mengupload file.');
                window.location.href = 'photo-edit.php';
            </script>";
            exit;
        }
    } else {
        // Query untuk update tanpa foto
        $sql = "UPDATE tb_portofolio SET judul = ?, photoaktif = ?, category_id = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssii", $judul, $status, $category_id, $id);
    }

    // Mengeksekusi query
    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil diperbarui!');
            window.location.href = 'photo.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
