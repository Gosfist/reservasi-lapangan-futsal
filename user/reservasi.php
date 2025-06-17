<?php
session_start();
require "../function.php";

$id_user = $_SESSION['id_user'];

if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}

$reservasi = query("SELECT reservasi.*, user.nama_user, lapangan.nama_lapangan 
                    FROM reservasi 
                    JOIN user ON reservasi.id_user = user.id_user 
                    JOIN lapangan ON reservasi.id_lapangan = lapangan.id_lapangan 
                    WHERE reservasi.id_user = $id_user ORDER BY id_reservasi DESC");


if (isset($_POST["konfirmasibayar"])) {
  if (konfirmasibayar($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Bayar!');
          document.location.href = 'reservasi.php';
          </script>";
  } else {
    var_dump(konfirmasibayar($_POST));
    echo "<script>
          alert('Gagal Bayar!');
          </script>";
  }
}


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
              <h1>Reservasi</h1>
              <p class="mb-0">Reservasi anda</p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Page Title -->

    <div class="container">


        <div class="table-responsive">
          <table class="table table-responsive my-3">
            <thead>
              <tr class="align-middle text-center">
                <th scope="col">No</th>
                <th scope="col">Nama Lapangan</th>
                <th scope="col">Tgl Dipesan</th>
                <th scope="col text-center">Tgl Booking</th>
                <th scope="col">Jam Booking</th>
                <th scope="col">Lama Sewa</th>
                <th scope="col">Harga</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody id="content">
              <?php $i = 1; ?>
              <?php foreach ($reservasi as $row) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td class="align-middle text-center"><?= $row["nama_lapangan"]; ?></td>
                  <td class="align-middle text-center"><?= $row["tanggal_dipesan"]; ?></td>
                  <td class="align-middle text-center"><?= $row["tanggal_booking"]; ?></td>
                  <td class="align-middle text-center"><?= formatJamBooking($row["jam_booking"]); ?></td>
                  <td class="align-middle text-center"><?php
                                                        $toarray = explode(',', $row["jam_booking"]);
                                                        $lamasewa = count($toarray);
                                                        echo "$lamasewa Jam" ?>
                  </td>
                  <td class="align-middle text-center"><?= $row["harga"]; ?></td>
                  <td class="align-middle text-center"><?= $row["status"]; ?></td>
                  <td class="align-middle text-center">
                    <?php
                    $id_reservasi = $row["id_reservasi"];
                    if ($row["status"] == "lunas" || $row["status"] == "proses") {
                      echo '
                      <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailreservasi' . $row["id_reservasi"] . '">Detail</button>';
                    } else {
                      // tampilkan tombol Detail
                      echo '
                      <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#bayarreservasi' . $row["id_reservasi"] . '">Bayar</button>
                       <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal' . $row["id_reservasi"] . '">Cancel</button>';
                    }
                    ?>
                  </td>
                  <!-- Edit Modal -->
                  <div class="modal fade" id="bayarreservasi<?= $row["id_reservasi"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Bayar <?= $row["nama_lapangan"]; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                          </div>
                          <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_reservasi" value="<?= $row["id_reservasi"]; ?>">
                            <div class="modal-body">
                              <div class="row justify-content-center align-items-center">
                                <div class="col">
                                  <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Tanggal Booking</label>
                                    <input type="date" name="tgl_main" class="form-control" id="exampleInputPassword1" value="<?= $row["tanggal_booking"]; ?>" disabled>
                                  </div>
                                  <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Jam Booking</label>
                                    <input type="text" name="jam_habis" class="form-control" id="exampleInputPassword1" value="<?= formatJamBooking($row["jam_booking"]); ?>" disabled>
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Lama Main</label>
                                    <input type="text" name="jam_mulai" class="form-control" id="exampleInputPassword1" value="<?php $toarray = explode(',', $row["jam_booking"]);
                                                                                                                                $lamasewa = count($toarray);
                                                                                                                                echo "$lamasewa Jam" ?>" disabled>
                                  </div>
                                  <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Harga</label>
                                    <input type="number" name="212279_harga" class="form-control" id="exampleInputPassword1" value="<?= $row["harga"]; ?>" disabled>
                                  </div>
                                </div>
                                <div class="mt-3">
                                  <label for="exampleInputPassword1" class="form-label">Transfer ke : BRI 0892322132 a/n Sport Center</label>
                                </div>
                                <div class="mt-3">
                                  <label for="bukti_pembayaran" class="form-label">Upload Bukti</label>
                                  <input type="file" name="bukti_pembayaran" class="form-control" id="bukti_pembayaran">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success" name="konfirmasibayar">Bayar</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div id="detailModal"></div>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="hapusModal<?= $row["id_reservasi"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hapusModalLabel">Hapus Pesanan <?= $row["nama_user"]; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>Anda yakin ingin membatalkan pesanan ini?</p>
                          </div>
                          <div class="modal-footer">
                            <a href="./controller/batalkanreservasi.php?id=<?= $row["id_reservasi"]; ?>" class="btn btn-danger">Iya Batalkan</a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="detailreservasi<?= $row["id_reservasi"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Detail Id Reservasi: <?= $row["id_reservasi"]; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="mb-3">
                            <img src="../img/Bukti/<?= $row["bukti_pembayaran"]; ?>" alt="gambar bukti pembayaran" class="img-fluid">
                          </div>
                          <input type="hidden" name="id_reservasi" value="<?= $row["id_reservasi"]; ?>">
                          <div class="modal-body">
                            <div class="row justify-content-center align-items-center">

                              <div class="col">
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Nama Customer</label>
                                  <input type="text" name="tgl_main" class="form-control" id="exampleInputPassword1" value="<?= $row["nama_user"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Tanggal Booking</label>
                                  <input type="date" name="tgl_main" class="form-control" id="exampleInputPassword1" value="<?= $row["tanggal_booking"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Lama Main</label>
                                  <input type="text" name="jam_mulai" class="form-control" id="exampleInputPassword1" value="<?php $toarray = explode(',', $row["jam_booking"]);
                                                                                                                              $lamasewa = count($toarray);
                                                                                                                              echo "$lamasewa Jam" ?>" disabled>
                                </div>
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Nama Lapangan</label>
                                  <input type="text" name="tgl_main" class="form-control" id="exampleInputPassword1" value="<?= $row["nama_lapangan"]; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Jam Booking</label>
                                  <input type="text" name="jam_habis" class="form-control" id="exampleInputPassword1" value="<?= formatJamBooking($row["jam_booking"]); ?>" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Harga</label>
                                  <input type="number" name="212279_harga" class="form-control" id="exampleInputPassword1" value="<?= $row["harga"]; ?>" disabled>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php endforeach; ?>

            </tbody>
          </table>
          <!-- Pagination -->
          <div id="pagination"></div>
          <!-- Pagination -->
        </div>
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