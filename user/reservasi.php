<?php
session_start();
require "../function.php";

$loggedIn = isset($_SESSION['role']);

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
                <th scope="col">Tanggal Pesan</th>
                <th scope="col">Nama Lapangan</th>
                <th scope="col">Jam Main</th>
                <th scope="col">Lama Sewa</th>
                <th scope="col">jam Habis</th>
                <th scope="col">Total</th>
                <th scope="col">Konfirmasi</th>
              </tr>
            </thead>
            <tbody id="content">

              <div id="bayarModal"></div>

              <div id="detailModal"></div>

              <div id="hapusModal"></div>
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

  <script>
    $(document).ready(function() {
      function loadPage(page) {
        $.ajax({
          url: 'ambil.php',
          type: 'GET',
          dataType: 'json',
          data: {
            halaman: page
          },
          success: function(response) {

            var content = '';
            var bayarModal = '';
            var hapusModal = '';
            var detailModal = '';
            if (response.data.length > 0) {
              response.data.forEach(function(item, index) {
                content += '<tr>';
                content += '<th scope="row">' + ((page - 1) * 5 + index + 1) + '</th>';
                content += '<td>' + item['212279_tanggal_pesan'] + '</td>';
                content += '<td>' + item['212279_nama'] + '</td>';
                content += '<td>' + item['212279_jam_mulai'] + '</td>';
                content += '<td>' + item['212279_lama_sewa'] + ' Jam</td>';
                content += '<td>' + item['212279_jam_habis'] + '</td>';
                content += '<td>' + item['212279_total'] + '</td>';

                // Menampilkan tombol berdasarkan konfirmasi
                if (item['212279_konfirmasi'] === "Sudah Bayar" || item['212279_konfirmasi'] === "Terkonfirmasi") {
                  content += '<td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal' + item['212279_id_sewa'] + '">Detail</button></td>';
                } else {
                  content += '<td>' +
                    '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bayarModal' + item['212279_id_sewa'] + '">Bayar</button> ' +
                    '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal' + item['212279_id_sewa'] + '">Hapus</button>' +
                    '</td>';
                }

                content += '</tr>';

                // Menambahkan modal ke string modals
                bayarModal += `
                <div class="modal fade" id="bayarModal${item['212279_id_sewa']}" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Bayar Lapangan ${item['212279_nama']}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_sewa" value="${item['212279_id_sewa']}">
                        <div class="modal-body">
                          <div class="row justify-content-center align-items-center">
                              <div class="col">
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Jam Main</label>
                                  <input type="datetime-local" name="tgl_main" class="form-control" id="exampleInputPassword1" value="${item['212279_jam_mulai']}" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Jam Habis</label>
                                  <input type="datetime-local" name="jam_habis" class="form-control" id="exampleInputPassword1" value="${item['212279_jam_habis']}" disabled>
                                </div>
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Lama Main</label>
                                  <input type="text" name="jam_mulai" class="form-control" id="exampleInputPassword1" value="${item['212279_lama_sewa']} jam" disabled>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label">Harga</label>
                                  <input type="number" name="212279_harga" class="form-control" id="exampleInputPassword1" value="${item['212279_harga']}" disabled>
                                </div>
                              </div>
                              <div class="input-group ">
                                <div class="input-group-prepend border border-danger">
                                  <span class="input-group-text">Total</span>
                                </div>
                                <input type="number" name="total" class="form-control border border-danger" id="exampleInputPassword1" value="${item['212279_total']}" disabled>
                              </div>
                              <div class="mt-3">
                                <label for="exampleInputPassword1" class="form-label">Transfer ke : BRI 0892322132 a/n Sport Center</label>
                              </div>
                              <div class="mt-3">
                                <label for="exampleInputPassword1" class="form-label">Upload Bukti</label>
                                <input type="file" name="foto" class="form-control" id="exampleInputPassword1">
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success" name="bayar_212279">Bayar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                `;

                hapusModal +=
                  `<div class="modal fade" id="hapusModal${item['212279_id_sewa']}" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus Data</h5>
                    </div>
                    <div class="modal-body">
                      <p>Anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <a href="controller/hapus.php?id=${item['212279_id_sewa']}" class="btn btn-danger">Hapus</a>
                    </div>
                  </div>
                </div>
              </div>
                  `;

                detailModal += `
              <div class="modal fade" id="detailModal${item['212279_id_sewa']}" tabindex="-1" role="dialog" aria-labelledby="bayarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Detail Pembayaran Lapangan ${item['212279_nama']}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                      <div class="modal-body">
                        <!-- konten form modal -->
                        <div class="row justify-content-center align-items-center">
                          <div class="mb-3">
                            <img src="../img/${item['212279_bukti']}" alt="gambar lapangan_212279" class="img-fluid">
                          </div>
                          <div class="col">
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Jam Main</label>
                              <input type="datetime-local" name="tgl_main" class="form-control" id="exampleInputPassword1" value="${item['212279_jam_mulai']}" disabled>
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Jam Habis</label>
                              <input type="datetime-local" name="jam_habis" class="form-control" id="exampleInputPassword1" value="${item['212279_jam_habis']}" disabled>
                            </div>
                          </div>
                          <div class="col">
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Lama Main</label>
                              <input type="text" name="jam_mulai" class="form-control" id="exampleInputPassword1" value="${item['212279_lama_sewa']} jam" disabled>
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Harga</label>
                              <input type="number" name="212279_harga" class="form-control" id="exampleInputPassword1" value="${item['212279_harga']}" disabled>
                            </div>
                          </div>
                          <div class="input-group ">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Total</span>
                            </div>
                            <input type="number" name="total" class="form-control " id="exampleInputPassword1" value="${item['212279_total']}" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mx-3">
                        <h6 class="text-center border border-danger">Status : ${item['212279_konfirmasi']}</h6>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              `;


              });
            } else {
              content += '<tr><td colspan="10" class="text-center">Belum Ada Pesanan</td></tr>';

            }
            $('#content').html(content);
            $('#bayarModal').html(bayarModal);
            $('#hapusModal').html(hapusModal);
            $('#detailModal').html(detailModal);


            var pagination = '';

            if (page > 1) {
              pagination += '<li class="page-item"><a href="#" class="page-link" data-page="' + (page - 1) + '">Previous</a></li>';
            } else {
              pagination += '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
            }

            for (var i = 1; i <= response.totalPages; i++) {
              if (i === page) {
                pagination += '<li class="page-item active"><a href="#" class="page-link" data-page="' + i + '">' + i + '</a></li>';
              } else {
                pagination += '<li class="page-item"><a href="#" class="page-link" data-page="' + i + '">' + i + '</a></li>';
              }
            }

            if (page < response.totalPages) {
              pagination += '<li class="page-item"><a href="#" class="page-link" data-page="' + (page + 1) + '">Next</a></li>';
            } else {
              pagination += '<li class="page-item disabled"><span class="page-link">Next</span></li>';
            }

            $('#pagination').html('<ul class="pagination">' + pagination + '</ul>');
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('Terjadi kesalahan saat memuat data.');
          }
        });
      }

      loadPage(1);

      $('#pagination').on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadPage(page);
      });

      // Hapus modal action
      $(document).on('click', '.btn-danger', function() {
        var id_sewa = $(this).data('id'); // Ambil ID dari data attribute
        $('#hapusModal' + id_sewa).modal('show'); // Tampilkan modal hapus
      });
    });
  </script>

</body>

</html>