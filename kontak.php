<?php


session_start();
require "function.php";

// $loggedIn = isset($_SESSION['role']);

// if ($loggedIn) {

//   $id_user = $_SESSION["id_user"];

//   // Melakukan query hanya jika $_SESSION["id_user"] sudah terdefinisi
//   $profil = query("SELECT * FROM user_212279 WHERE 212279_id_user = '$id_user'")[0];
// }

// if (isset($_POST["simpan"])) {
//   if (edit($_POST) > 0) {
//     echo "<script>
//           alert('Berhasil Diubah');
//           </script>";
//   } else {
//     echo "<script>
//           alert('Gagal Diubah');
//           </script>";
//   }
// }
?>
<?php
if (isset($_POST['kirim_wa'])) {
    $nama   = htmlspecialchars($_POST['nama']);
    $pesan  = htmlspecialchars($_POST['pesan']);

    $no_admin = "6283110361634"; // Nomor WhatsApp admin
    $text = "Halo Admin Basecamp%20Sport%20Center,%0ASaya ingin menghubungi Anda:%0A%0ANama: $nama%0APesan: $pesan";

    $url = "https://wa.me/6283110361634?text"  . urlencode($text);

    echo "<script>window.open('$url', '_blank');</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Basecamp Sport Center</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


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

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/logo.png" alt="">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Beranda<br></a></li>
                    <li><a href="user/lapangan.php">Lapangan</a></li>
                    <li><!-- Jika belum login, tampilkan tombol login -->
            <a href="login.php" class="btn-getstarted" type="submit">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a></li>
                    <?php if ($loggedIn): ?>
            <li class="nav-item">
              <a class="nav-link" href="user/pesanan.php">Pesanan</a>
            </li>
        <?php endif; ?>
                    <li><a href="kontak.php" class="active">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <?php if ($loggedIn): ?>
            <!-- Jika sudah login, tampilkan tombol profil -->
            <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#profilModal">
                <i class="bi bi-person"></i> Profil
            </a>
        <?php else: ?>
            
        <?php endif; ?>



        </div>
    </header>

      <!-- Modal Profil -->
      <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="profilModalLabel">Profil Pengguna</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <div class="row">
                  <div class="col-4 my-5">
                    <img src="img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
                  </div>
                  <div class="col-8">
                    <h5 class="mb-3"><?= $profil["212279_nama_lengkap"]; ?></h5>
                    <p><?= $profil["212279_jenis_kelamin"]; ?></p>
                    <p><?= $profil["212279_email"]; ?></p>
                    <p><?= $profil["212279_no_handphone"]; ?></p>
                    <p><?= $profil["212279_alamat"]; ?></p>
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                    <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-inti">Edit Profil</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Modal Profil -->

      <!-- Edit profil -->
  <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog edit modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_foto"]; ?>">
          <div class="modal-body">
            <div class="row justify-content-center align-items-center">
              <div class="mb-3">
                <img src="img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                  <input type="text" name="212279_nama_lengkap" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_nama_lengkap"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if ($profil['212279_jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($profil['212279_jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="212279_no_handphone" class="form-label">No Telp</label>
                  <input type="number" name="212279_no_handphone" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_no_handphone"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_email"]; ?>">
                </div>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">alamat</label>
                <input type="text" name="212279_alamat" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_alamat"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Foto : </label>
                <input type="file" name="212279_foto" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-inti" name="simpan" id="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Edit Modal -->


   <main class="main">
   <section id="contact" class="contact section">

<div class="mb-5" data-aos="fade-up" data-aos-delay="200">
<iframe style="border:0; width: 100%; height: 300px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31598.125999591968!2d113.1852795743164!3d-8.125315799999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65d9db1a4f8b1%3A0xb5afd8c6c89a11fd!2sPOEKIZ%20FUTSAL%20LUMAJANG!5e0!3m2!1sid!2sid!4v1749124145266!5m2!1sid!2sid" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div><!-- End Google Maps -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="row gy-4">
  <!-- Kiri: Informasi Kontak -->
  <div class="col-lg-6">
    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
      <i class="bi bi-geo-alt flex-shrink-0"></i>
      <div>
        <h3>Address</h3>
        <p>Jalan Brigjen Katamso KAV. Mbah, Gg. Mangun No.43, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316</p>
      </div>
    </div>
    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
      <i class="bi bi-telephone flex-shrink-0"></i>
      <div>
        <h3>Call Us</h3>
        <p>+6283110361634</p>
      </div>
    </div>
    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
      <i class="bi bi-envelope flex-shrink-0"></i>
      <div>
        <h3>Email Us</h3>
        <p>wisnu@gmail.com</p>
      </div>
    </div>
  </div>

  <!-- Kanan: Form Kontak -->
  <div class="col-lg-6">
    <form method="GET" action="https://wa.me/6283110361634" target="_blank" onsubmit="return sendToWA();">
      <div class="form-group mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" required>
      </div>
      <div class="form-group mb-3">
        <label>Pesan</label>
        <textarea name="pesan" id="pesan" class="form-control" rows="5" placeholder="Pesan" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Kirim via WhatsApp</button>
    </form>
  </div>
</div>

<script>
function sendToWA() {
    const nama = document.getElementById('nama').value;
    const pesan = document.getElementById('pesan').value;

    const text = `Halo Admin Basecamp Sport Center,%0ASaya ingin menghubungi Anda:%0A%0ANama: ${encodeURIComponent(nama)}%0APesan: ${encodeURIComponent(pesan)}`;
    const url = `https://wa.me/6283110361634?text=${text}`;

    window.open(url, '_blank');
    return false; // mencegah form submit default
}
</script>


    </div><!-- End Contact Form -->

  </div>

</div>

</section><!-- /Contact Section -->
   </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-6 col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">Basecamp</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>Indonesia</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-whatsapp"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class=" col-6 col-lg-4 col-md-6 footer-links">
                    <h4>Navigasi</h4>
                    <div class="row">
                        <div class="col-6 col-lg-4">
                            <ul>
                                <li><a href="#">Beranda</a></li>
                                <li><a href="#">Lapangan</a></li>
                                <li><a href="#">Membership</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-lg-4">
                            <ul>
                                <li><a href="#">Tournament</a></li>
                                <li><a href="#">Promo</a></li>
                                <li><a href="#">Kontak</a></li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-6 col-lg-4 col-md-6 footer-links">
                    <h4>Syarat & Ketentuan</h4>
                    <ul>
                        <li><a href="#">Lihat Syarat & Ketentuan</a></li>
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