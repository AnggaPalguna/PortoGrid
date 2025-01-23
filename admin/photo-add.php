<?php
session_start();
include "./photo-add-process.php";

// Memastikan pengguna sudah login
if (!isset($_SESSION['login'])) {
    echo "<script> window.location.href = 'login.php'; </script>";
    exit;
}

// Mengambil data kategori
$kategoriList = getKategori();

// Memproses form jika tombol submit ditekan
if (isset($_POST['submit'])) {
    // Memanggil fungsi tambah dan mengecek keberhasilannya
    if (tambah($_POST)) {
        echo "<script> 
            alert('Data berhasil ditambahkan!'); 
            window.location.href = 'photo.php'; 
        </script>";
    } else {
        echo "<script> 
            alert('Gagal menambahkan data.'); 
            window.location.href = 'photo-add.php'; 
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortoGrid - Collections Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <div class="sidebar-brand-text mx-3"><a class="navbar-brand" href="dashboard.php"><span class="text-primary font-weight-bold text-uppercase">Porto</span><span class="text-warning font-weight-bold text-uppercase">Grid</span></a></div>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="photo.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Collections</span></a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="feedback.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Feedback</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="lo"></i>
                    <span>Log Out</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">


        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 font-weight-bold text-uppercase">Collections</h1>

                    <!-- Form -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Tambah Data Photo</h3>
                                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                                        <div class="form-group">
                                            <label>Judul</label>
                                            <input type="text" name="judul" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label>File Gambar</label>
                                            <input type="file" name="photo" class="form-control" accept="image/*" required />
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-select form-select-sm" name="category_id" required>
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    <?php
                                                    $kategoriList = getKategori();
                                                    foreach ($kategoriList as $kategori) :
                                                    ?>
                                                        <option value="<?= $kategori['id']; ?>"><?= htmlspecialchars($kategori['name']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select class="form-select form-select-sm" name="status" required>
                                                <option value="1">On</option>
                                                <option value="0">Off</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Simpan</button>
                                            <a class="btn btn-danger" href="photo.php">Batal</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; All Right Reserved @PORTOGRID</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>