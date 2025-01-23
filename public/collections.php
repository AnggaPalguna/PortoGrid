<?php
require_once 'getimg.php'; // Mengimpor file getimg.php yang berisi class getImage.
$portofolio = new getImage(); // Membuat instance dari class getImage.
$data = $portofolio->getAllPortofolio(); // Mengambil semua data portofolio dari method getAllPortofolio().
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PortoGrid</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><span class="text-primary">Porto</span><span class="text-warning">Grid</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">Previews</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">Feedback</a>
          </li>
        </ul>
        <div class="nav-item">
          <a class="nav-link custom-portfolio" href="collections.php"><span class="text-primary">Collections</span></a>
        </div>
      </div>
    </div>
  </nav>

  <section id="Home" class="Home-section-padding">
    <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active c-item">
          <img src="img/img4.jpg" class="d-block w-100 c-img" alt="Slide 1">
          <div class="carousel-caption top-1 mt-4 text-center">
            <h1 class="display-2 fw-bolder text-uppercase">Collections</h1>
            <p class="mt-3 fs-4 ">Here Our Collections</p>
            <a href="#collections" class="btn btn-primary px-3 py-2 fs-6 fw-bolder text-uppercase">Read More</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="collections">
    <div class="container py-5 text-center">
      <div class="row">
        <?php
        foreach ($data as $image) {
          // Memastikan hanya gambar aktif yang ditampilkan.
          if ($image['photoaktif']) {
        ?>
            <a class="col-md-12 col-lg-4 img-fluid py-2 imgtho" href="uploads/<?= $image['photo'] ?>" data-toggle="lightbox">
              <img src="uploads/<?= $image['photo'] ?>" alt="random img" class="img-fluid">
            </a>
          <?php
          } else { ?>
        <?php }
        }
        ?>
      </div>
    </div>
  </section>

  <footer class="bg-dark p-2 text-center">
    <div class="container">
      <p class="text-white">
        All Right Reserved @PORTOGRID
      </p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
</body>

</html>