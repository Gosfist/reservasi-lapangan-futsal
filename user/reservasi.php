<?php
session_start();
require "../function.php";
require "../session.php";

$id_user = $_SESSION['id_user'];
if ($role !== 'SuperAdmin' && $role !== 'Admin') {
  header("location:../index.php");
}

$reservasi = query("SELECT reservasi.*, user.nama_user, lapangan.nama_lapangan 
                    FROM reservasi 
                    JOIN user ON reservasi.id_user = user.id_user 
                    JOIN lapangan ON reservasi.id_lapangan = lapangan.id_lapangan 
                    WHERE reservasi.id_user = $id_user ORDER BY id_reservasi DESC");

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


// if (isset($_POST["bayar_212279"])) {
//   if (bayar($_POST) > 0) {
//     echo "<script>
//           alert('Berhasil Di Bayar!');
//           document.location.href = 'pesanan.php';
//           </script>";
//   } else {
//     echo "<script>
//           alert('Gagal Bayar!');
//           </script>";
//   }
// }


?>
<!DOCTYPE html>
<html lang="en">

<!-- header -->
<?php require_once '../templates/headUser.php'; ?>

<body class="index-page">

  <?php require_once '../templates/navbarUser.php'; ?>

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
                <img src="../img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col-8">
                <h5 class="mb-3"><?= $profil["212279_nama_lengkap"]; ?></h5>
                <p><?= $profil["212279_jenis_kelamin"]; ?></p>
                <p><?= $profil["212279_email"]; ?></p>
                <p><?= $profil["212279_no_handphone"]; ?></p>
                <p><?= $profil["212279_alamat"]; ?></p>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
                <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-success">Edit Profil</a>
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
                <img src="../img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
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
            <button type="submit" class="btn btn-success" name="simpan" id="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Edit Modal -->


  <main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <img src="../assets/img/hero-bg.jpg" alt="">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Pesanan</h1>
              <p class="mb-0">Pesanan anda</p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Page Title -->

    <div class="container">

      <form action="" method="post" enctype="multipart/form-data">
        <div class="table-responsive">
          <table class="table table-responsive my-3">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Lapangan</th>
                <th scope="col">Tgl Booking</th>
                <th scope="col">jam Booking</th>
                <th scope="col">Lama Sewa</th>
                <th scope="col">Harga</th>
                <th scope="col">Konfirmasi</th>
              </tr>
            </thead>
            <tbody id="content">
              <?php $i = 1; ?>
              <?php foreach ($reservasi as $row) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $row["nama_lapangan"]; ?></td>
                  <td><?= $row["tanggal_booking"]; ?></td>
                  <td><?= formatJamBooking($row["jam_booking"]); ?></td>
                  <td><?php
                      $toarray = explode(',', $row["jam_booking"]);
                      $lamasewa = count($toarray);
                      echo "$lamasewa Jam" ?>
                  </td>
                  <td><?= $row["harga"]; ?></td>
                  <td>
                    <div id="bayarModal"></div>

                    <div id="detailModal"></div>

                    <div id="hapusModal"></div>
                  <?php endforeach; ?>
            </tbody>
          </table>
          <!-- Pagination -->
          <div id="pagination"></div>
          <!-- Pagination -->
        </div>
      </form>
    </div>

  </main>

  <!-- Footer -->
  <?php require_once '../templates/footerUser.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>
