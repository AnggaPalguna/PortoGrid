<?php
session_start();

// Memastikan pengguna sudah login
if (!isset($_SESSION['login'])) {
    header("location: login.php");
    exit;
} elseif (!isset($_GET['id'])) {
    header('Location: photo.php');
    exit;
}

require '../includes/koneksi.php';

// Membuat instance dari class Koneksi
$koneksi = new Koneksi();
$con = $koneksi->getConnection();

// Menggunakan prepared statement untuk mengambil data berdasarkan id
$id = $con->real_escape_string($_GET['id']);
$sql = "SELECT * FROM tb_portofolio WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Menyimpan data yang ditemukan dalam array
$data = $result->fetch_assoc();
if (!$data) {
    echo "<script>
        alert('Data tidak ditemukan.');
        window.location.href = 'photo.php';
    </script>";
    exit;
}

// Mendapatkan daftar kategori
$sqlKategori = "SELECT id, name FROM tb_category";
$resultKategori = $con->query($sqlKategori);
$kategoriList = [];
while ($kategori = $resultKategori->fetch_assoc()) {
    $kategoriList[] = $kategori;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Collections - PortoGrid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <div class="sidebar-brand-text mx-3">
                <a class="navbar-brand" href="dashboard.php">
                    <span class="text-primary font-weight-bold text-uppercase">Porto</span>
                    <span class="text-warning font-weight-bold text-uppercase">Grid</span>
                </a>
            </div>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Interface</div>
            <li class="nav-item active">
                <a class="nav-link" href="photo.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Collections</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="feedback.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Feedback</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="lo"></i>
                    <span>Log Out</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800 font-weight-bold text-uppercase">Edit Collections</h1>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="photo-edit-process.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
                                        <div class="form-group mb-3">
                                            <label>Judul</label>
                                            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']); ?>" required />
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>File Gambar</label>
                                            <input type="file" name="photo" class="form-control" />
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Status</label>
                                            <select class="form-select" name="status" required>
                                                <option value="1" <?= $data['photoaktif'] == 1 ? 'selected' : ''; ?>>On</option>
                                                <option value="0" <?= $data['photoaktif'] == 0 ? 'selected' : ''; ?>>Off</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Kategori</label>
                                            <select class="form-select" name="category_id" required>
                                                <?php foreach ($kategoriList as $kategori) : ?>
                                                    <option value="<?= $kategori['id']; ?>" <?= $data['category_id'] == $kategori['id'] ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($kategori['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                        <a class="btn btn-danger" href="photo.php">Batal</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Preview</h3>
                                    <img class="w-100" src="../uploads/<?= htmlspecialchars($data['photo']); ?>" alt="Preview Image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; All Right Reserved @PORTOGRID</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>