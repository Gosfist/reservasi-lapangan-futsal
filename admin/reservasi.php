<?php
session_start();
require "../session.php";
require "../function.php";

if ($role !== 'SuperAdmin' && $role !== 'Admin') {
  header("location:../index.php");
}

$reservasi = query("SELECT reservasi.*, user.nama_user, lapangan.nama_lapangan 
                    FROM reservasi 
                    JOIN user ON reservasi.id_user = user.id_user 
                    JOIN lapangan ON reservasi.id_lapangan = lapangan.id_lapangan");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="../assets/img/logo.png" rel="icon">

  <style>
    .btn-sm {
      min-width: 60px;
    }
  </style>

  <title>Homes</title>
</head>

<body>
  <div class="wrapper">
    <!-- navbar -->
    <?php require_once '../templates/navbarAdmin.php'; ?>
    <div class="main">
      <nav class="navbar bg-light shadow">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <?php if ($role == "SuperAdmin") : ?>
              <img src="../assets/img/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
              SuperAdmin Dashboard
            <?php endif; ?>

            <?php if ($role == "Admin") : ?>
              <img src="../assets/img/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
              Admin Dashboard
            <?php endif; ?>
          </a>
        </div>
      </nav>

      <!-- Konten -->
      <div class="container">
        <!-- Konten -->
        <h3 class="mt-4">Data Reservasi</h3>
        <hr>
        <a href="export.php" class="btn btn-success mb-2">Download</a>
        <div class="table-responsive">
          <table class="table table-hover text-center">
            <thead class="table-inti">
              <tr class="align-middle">
                <th scope="col">No</th>
                <th scope="col">Nama<br>Customer</th>
                <th scope="col">Nama<br>Lapangan</th>
                <th scope="col">Tanggal<br>Dipesan</th>
                <th scope="col text-center">Tanggal<br> Booking</th>
                <th scope="col">Jam<br> Booking</th>
                <th scope="col">Lama<br>Sewa</th>
                <th scope="col">Harga</th>
                <th scope="col">Bukti</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $reservasi = array_reverse($reservasi);
              $i = count($reservasi);
              foreach ($reservasi as $row) : ?>
                <tr>
                  <td><?= $i--; ?></td>
                  <td><?= $row["nama_user"]; ?></td>
                  <td><?= $row["nama_lapangan"]; ?></td>
                  <td><?= $row["tanggal_dipesan"]; ?></td>
                  <td><?= $row["tanggal_booking"]; ?></td>
                  <td><?= formatJamBooking($row["jam_booking"]); ?></td>
                  <td><?php
                      $toarray = explode(',', $row["jam_booking"]);
                      $lamasewa = count($toarray);
                      echo "$lamasewa Jam" ?>
                  </td>
                  <td><?= $row["harga"]; ?></td>
                  <td><img src="../img/Bukti/<?= $row["bukti_pembayaran"]; ?>" width="50" height="50"></td>
                  <td><?= $row["status"]; ?></td>
                  <td>
                    <?php
                    $id_reservasi = $row["id_reservasi"];
                    if ($row["status"] == "lunas") {
                      echo '
                      <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailreservasi' . $id_reservasi . '">Detail</button>
                      <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal' . $id_reservasi . '">Hapus</button>';
                    } else {
                      // tampilkan tombol Detail
                      echo '
                      <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#konfirmasiModal' . $id_reservasi . '">Konfir</button>
                      <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal' . $id_reservasi . '">Hapus</button>';
                    }
                    ?>
                  </td>
                </tr>
                <!-- Modal Konfirmasi -->
                <div class="modal fade" id="konfirmasiModal<?= $row["id_reservasi"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pesanan <?= $row["nama_user"]; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Anda yakin ingin mengkonfirmasi pesanan ini?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="./controller/konfirmasiPesan.php?id=<?= $row["id_reservasi"]; ?>" class="btn btn-primary">Konfirmasi</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Konfirmasi -->

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

                <!-- Modal Hapus -->
                <div class="modal fade" id="hapusModal<?= $row["id_reservasi"]; ?>" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="hapusModalLabel">Hapus Pesanan <?= $row["nama_user"]; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Anda yakin ingin menghapus pesanan ini?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="./controller/hapusPesan.php?id=<?= $row["id_reservasi"]; ?>" class="btn btn-danger">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Konfirmasi -->
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>


      </div>
    </div>

    <script>
      const hamBurger = document.querySelector(".toggle-btn");
      const sidebar = document.querySelector("#sidebar");

      // Fungsi ini akan berjalan setiap kali halaman dimuat
      document.addEventListener("DOMContentLoaded", function() {
        // 1. Periksa apakah ada status 'sidebarState' yang tersimpan di localStorage
        if (localStorage.getItem("sidebarState") === "expanded") {
          // 2. Jika ada dan nilainya 'expanded', tambahkan class 'expand' ke sidebar
          sidebar.classList.add("expand");
        }
      });

      // Fungsi ini tetap berjalan saat tombol hamburger di-klik
      hamBurger.addEventListener("click", function() {
        // Toggle class seperti biasa
        sidebar.classList.toggle("expand");

        // 3. Setelah mengubah tampilan, simpan statusnya ke localStorage
        if (sidebar.classList.contains("expand")) {
          // Jika sidebar sekarang memiliki class 'expand', simpan statusnya
          localStorage.setItem("sidebarState", "expanded");
        } else {
          // Jika tidak, hapus statusnya dari localStorage
          localStorage.removeItem("sidebarState");
        }
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>