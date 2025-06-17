<?php
session_start();
require "../function.php";

$loggedIn = isset($_SESSION['role']);
$lapangan = query("SELECT * FROM lapangan");

// Ambil jadwal dari database
$jadwal = [];
$jadwalQuery = query("SELECT * FROM jadwal");
foreach ($jadwalQuery as $row) {
  $jadwal[$row['hari_buka']] = $row;
}

if (isset($_POST["simpan"])) {
  if (edit($_POST) > 0) {
    echo "<script>
          alert('Berhasil Diubah');
          </script>";
  } else {
    echo "<script>
          alert('Gagal Diubah');
          </script>";
  }
}



if (isset($_POST["pesan"])) {

  if (addreservasi($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiPesan');
          document.location.href = 'lapangan.php';
          </script>";
  } else {
    echo "<script>
          alert('Jadwal Sudah Di Booking');
          </script>";
  }
}

function generateCheckboxJam($jam_buka, $jam_tutup, $hari, $lapangan_id)
{
  // Format jam buka & tutup ke integer jam saja
  $start = (int)substr($jam_buka, 0, 2);
  $end = (int)substr($jam_tutup, 0, 2);

  $html = '<div class="row">';
  for ($i = $start; $i <= $end; $i++) {
    $jam = sprintf('%02d:00', $i);
    $name = "jam_{$hari}_{$jam}_lap{$lapangan_id}";
    $html .= '<div class="col-3 mb-2">';
    $html .= "<div class=\"form-check\">";
    $html .= "<input class=\"form-check-input\" type=\"checkbox\" name=\"jam_checked[]\" value=\"$jam\" id=\"$name\">";
    $html .= "<label class=\"form-check-label\" for=\"$name\">$jam</label>";
    $html .= "</div></div>";
  }
  $html .= '</div>';
  return $html;
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
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <img src="../assets/img/hero-bg.jpg" alt="">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Lapangan</h1>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Page Title -->
    <section id="courses" class="courses section">
      <div class="container">
        <div class="row gy-4">
          <?php foreach ($lapangan as $row) : ?>
            <div class="col-6 col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
              <div class="course-item">
                <img src="../img/lapangan/<?= $row["foto_lapangan"]; ?>" class="img-fluid" alt="..." style="width: 300px; height: 200px; object-fit: cover;">
                <div class="p-3 text-content">
                  <h3><?= $row["nama_lapangan"]; ?></h3>
                  <?php if ($loggedIn) : ?>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pesanModal<?= $row["id_lapangan"]; ?>">Pesan</button>
                  <?php else : ?>
                    <a href="#" class="btn btn-success" onclick="notiflogin()">Pesan</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Modal Pesan -->
            <div class="modal fade" id="pesanModal<?= $row["id_lapangan"]; ?>" tabindex="-1" aria-labelledby="pesanModalLabel<?= $row["id_lapangan"]; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel<?= $row["id_lapangan"]; ?>">Pesan <?= $row["nama_lapangan"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="" method="post">
                    <div class="row justify-content-center align-items-center">
                      <input type="hidden" name="id_lapangan" class="form-control" id="id_lapangan" value="<?= $row["id_lapangan"]; ?>">
                      <input type="hidden" name="harga_lapangan" class="form-control" id="harga_lapangan" value="<?= $row["harga_lapangan"]; ?>">
                      <div class="mb-3">
                        <img src="../img/Lapangan/<?= $row["foto_lapangan"]; ?>" alt="gambar lapangan" class="img-fluid">
                      </div>
                      
                      <div class="row mt-3">
                        <div class="col-6">
                          <label class="form-label">Tanggal Main</label>
                          <input type="date" name="tgl_main" class="form-control tgl-main btn-outline-dark" id="tgl_main_<?= $row["id_lapangan"]; ?>" required>
                        </div>
                        <div class="col-6">
                          <label class="form-label">Jam Main</label>
                          <input type="button" value="Cek Ketersediaan" class="form-control btn-outline-dark cek-jam-btn" data-lapangan="<?= $row["id_lapangan"]; ?>" id="cek_ketersediaan_<?= $row["id_lapangan"]; ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <!-- Jam List akan tampil di sini -->
                          <div id="jamCheckboxContainer<?= $row["id_lapangan"]; ?>" class="mt-3"></div>
                          <input type="hidden" name="jam_mulai" id="jam_mulai_input<?= $row["id_lapangan"]; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary" name="pesan" id="pesan">Pesan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal Cek Jam -->
            <div class="modal fade" id="cekJamModal<?= $row["id_lapangan"]; ?>" tabindex="-1" aria-labelledby="cekJamModalLabel<?= $row["id_lapangan"]; ?>" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="cekJamModalLabel<?= $row["id_lapangan"]; ?>">Cek Ketersediaan Jam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="jamCheckboxContainer<?= $row["id_lapangan"]; ?>">
                    <!-- Checkbox jam akan di-load via JS -->
                    <div class="text-center text-muted">Pilih tanggal terlebih dahulu</div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary pilih-jam-btn" data-lapangan="<?= $row["id_lapangan"]; ?>" data-bs-dismiss="modal">Pilih Jam</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Jadwal -->
            <div class="modal fade" id="jadwalModal<?= $row["id_lapangan"]; ?>" tabindex="-1" aria-labelledby="jadwalModalLabel<?= $row["id_lapangan"]; ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="jadwalModalLabel<?= $row["id_lapangan"]; ?>">Jadwal Lapangan <?= $row["212279_nama"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="table-primary">
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Tanggal Pesan</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Jam Mulai</th>
                          <th scope="col">Lama Sewa</th>
                          <th scope="col">Jam Habis</th>
                        </tr>
                      </thead>
                      <tbody id="jadwalTabelBody<?= $row["id_lapangan"]; ?>">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <section>
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
  <script src="../assets/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    function notiflogin() {
      alert("Silakan login terlebih dulu sebelum melakukan pemesanan.");
    }
  </script>

  <script>
    $(document).ready(function() {
      $('.cek-jam-btn').click(function() {
        var lapId = $(this).data('lapangan');
        var tgl = $('#tgl_main_' + lapId).val();
        if (!tgl) {
          $('#jamCheckboxContainer' + lapId).html('<div class="text-danger">Silakan pilih tanggal terlebih dahulu!</div>');
          return;
        }
        $.get('./controller/cekKetersediaan.php', {
          tgl: tgl,
          id_lapangan: lapId
        }, function(data) {
          $('#jamCheckboxContainer' + lapId).html(data);
        });
      });

      // Update hidden input jika checkbox berubah
      $(document).on('change', '[id^=jamCheckboxContainer] input[type=checkbox]', function() {
        var lapId = $(this).closest('div[id^=jamCheckboxContainer]').attr('id').replace('jamCheckboxContainer', '');
        var checked = [];
        $('#jamCheckboxContainer' + lapId + ' input[type=checkbox]:checked').each(function() {
          checked.push($(this).val());
        });
        $('#jam_mulai_input' + lapId).val(checked.join(','));
      });
    });
  </script>
</body>

</html> 