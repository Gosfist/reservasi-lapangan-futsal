<?php
session_start();
require "function.php";

$query = mysqli_query($conn, "SELECT * FROM lapangan");
$lapangan = mysqli_fetch_all($query, MYSQLI_ASSOC);

$query = mysqli_query($conn, "SELECT COUNT(*) AS total_member FROM user"); // atau ganti 'user' jadi 'member' jika nama tabelmu beda
$data = mysqli_fetch_assoc($query);
$jumlah_member = $data['total_member'];

$queryLapangan = mysqli_query($conn, "SELECT COUNT(*) AS total_lapangan FROM lapangan");
$dataLapangan = mysqli_fetch_assoc($queryLapangan);
$jumlah_lapangan = $dataLapangan['total_lapangan'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Basecamp Sport Center</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <!-- navbar -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.png" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Beranda<br></a></li>
          <li><a href="user/lapangan.php">Lapangan</a></li>
          <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'User' || $_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin')) : ?>
            <li class="nav-item">
              <a class="nav-link" href="user/reservasi.php">Reservasi</a>
            </li>
          <?php endif; ?>
          <li><a href="./user/kontak.php">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin')) : ?>
        <a href="./admin/home.php" class="btn-getstarted">
          <i class="bi bi-person"></i> Dashboard
        </a>
      <?php endif; ?>

      <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'User')) : ?>
        <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#editProfilModal">
          <i class="bi bi-person"></i> Profile
        </a>
      <?php endif; ?>

      <?php if (!isset($_SESSION['role'])) : ?>
        <a href="login.php" class="btn-getstarted">
          <i class="bi bi-person"></i> Login
        </a>
      <?php endif; ?>


    </div>
  </header>

  <!-- Edit profil -->

  <?php
  $iduserprofile = $_SESSION['id_user'];
  $editprofiles = query("SELECT * FROM user WHERE id_user = $iduserprofile");

  ?>
  <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $i = 1; ?>
        <?php foreach ($editprofiles as $editprofile) : ?>
          <form action="" method="post">
            <input type="hidden" name="id_user" value="<?= $editprofile["id_user"]; ?>">
            <div class="modal-body">
              <div class="row justify-content-center align-items-center">
                <input type="hidden" name="id_user" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["id_user"]; ?>">
                <div class="col">
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["nama_user"]; ?>" require>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["email_user"]; ?>" require>
                  </div>
                </div>
                <div class="col">
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">No Wa</label>
                    <input type="number" name="nowa" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["no_wa_user"]; ?>" require>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="text" name="pass" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["password_user"]; ?>" require>
                  </div>
                </div>
                <div class="modal-footer">
                <a href="../logout.php" class="btn btn-danger">Logout</a>
                  <button type="submit" class="btn btn-primary" name="editprofile" id="editprofile">Simpan</button>
                </div>
              </div>
            </div>
          </form>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <?php
  if (isset($_POST["editprofile"])) {
    if (editprofile($_POST) > 0) {
      echo "<script>
  alert('Berhasil Di Edit');
  window.location.href = 'index.php';
</script>";
    } else {
      echo "<script>
  alert('Gagal Di Edit');
</script>";
    }
  }
  ?>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">Sehatkan Dirimu Dengan<br>Berolahraga di <span class="text-"> Basecamp </span> <br> Sport Center</h2>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="user/lapangan.php" class="btn-get-started">Booking Sekarang <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2 my-auto" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Basecamp Sport Center Hadir Untuk Anda</h3>
            <p class="fst-italic">
              Temukan pengalaman olahraga yang luar biasa dengan fasilitas premium kami.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Fasilitas olahraga terbaru dan terlengkap untuk latihan yang lebih efektif.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Pelatih profesional yang siap membantu Anda mencapai tujuan dengan strategi yang terbukti.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Lingkungan yang mendukung dan nyaman, menciptakan suasana positif untuk setiap latihan.</span></li>
            </ul>
            <a href="#" class="read-more "><span>Pelajari Lebih Lanjut</span><i class="bi bi-arrow-right"></i></a>
          </div>


        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Counts Section -->
    <section id="counts" class="section counts light-background"><br>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="row justify-content-center">
            <div class="col-6 col-lg-3 col-md-6">
              <div class="shadow rounded stats-item text-center w-100 h-100 p-3">
                <span data-purecounter-start="0" data-purecounter-end="<?= $jumlah_member; ?>" data-purecounter-duration="1" class="purecounter display-4"></span>
                <p>Pelanggan</p>
              </div>
            </div><!-- End Stats Item -->


            <div class="col-6 col-lg-3 col-md-6">
              <div class="shadow rounded stats-item text-center w-100 h-100 p-3">
                <span data-purecounter-start="0" data-purecounter-end="<?= $jumlah_lapangan; ?>" data-purecounter-duration="1" class="purecounter display-4"></span>
                <p>Lapangan</p>
              </div>
            </div><!-- End Stats Item -->

          </div>
        </div>

      </div>

    </section><!-- /Counts Section -->

    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <!-- Section Title -->
      <div class="container d-flex justify-content-between align-items-center" data-aos="fade-up">
        <div class="left section-title">
          <h2>Lapangan</h2>
          <p>Lapangan Terbaik</p>
        </div>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <?php foreach ($lapangan as $row) : ?>

            <div class="col-6 col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
              <div class="course-item">
                <img src="img/lapangan/<?= !empty($row["foto_lapangan"]) ? $row["foto_lapangan"] : 'default.jpg'; ?>" class="img-fluid" alt="...">
                <div class="course-content">
                </div>
                <div class="p-3 text-content">
                  <h3><a href="user/lapangan.php"><?= $row["nama_lapangan"]; ?></a></h3>
                </div>
              </div>
            </div>

          <?php endforeach; ?>

        </div>

      </div>

    </section><!-- /Courses Section -->

  </main>

  <footer id="footer" class="footer bg-light py-5">
    <div class="container">
      <div class="row gy-4 align-items-start">

        <!-- Kolom Kiri: Info Basecamp -->
        <div class="col-md-4 text-start">
          <a href="index.php" class="logo d-flex align-items-center mb-3">
            <span class="sitename fs-4 fw-bold text-dark">Basecamp</span>
          </a>
          <p class="mb-2 fs-6 text-muted">
            Jalan Brigjen Katamso KAV. Mbah, Gg. Mangun No.43,<br>
            Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316
          </p>
          <p class="mb-1 fs-6"><strong>Phone:</strong> <span>+62 831 1036 1634</span></p>
          <p class="fs-6"><strong>Email:</strong> <span>bascmpsc@gmail.com</span></p>
          <div class="social-links d-flex gap-3 mt-3">
            <a href="#"><i class="bi bi-geo-alt fs-5 text-dark"></i></a>
            <a href="#"><i class="bi bi-telephone fs-5 text-dark"></i></a>
            <a href="#"><i class="bi bi-envelope fs-5 text-dark"></i></a>
          </div>
        </div>

        <!-- Kolom Tengah: Navigasi -->
        <div class="col-md-4 d-flex flex-column align-items-center">
          <h5 class="fw-semibold mb-3">Navigasi</h5>
          <ul class="list-unstyled fs-6 text-center">
            <li class="mb-2"><a href="index.php" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="mb-2"><a href="user/lapangan.php" class="text-decoration-none text-muted">Lapangan</a></li>
            <li class="mb-2"><a href="user/kontak.php" class="text-decoration-none text-muted">Kontak</a></li>
            <?php if (isset($_SESSION['id_user'])): ?>
              <li class="mb-2"><a href="user/reservasi.php" class="text-decoration-none text-muted">Reservasi</a></li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Kolom Kanan: Syarat & Ketentuan, agak ke tengah -->
        <div class="col-md-4 d-flex flex-column align-items-center">
          <h5 class="fw-semibold mb-3">Syarat & Ketentuan</h5>
          <ul class="list-unstyled fs-6">
            <li><a href="user/syaratKetentuan.php" class="text-decoration-none text-muted">Lihat Syarat & Ketentuan</a></li>
          </ul>
        </div>

      </div>
    </div>
  </footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>