<?php
session_start();
require "../session.php";
require "../function.php";

if ($role !== 'SuperAdmin' && $role !== 'Admin') {
  header("location:../index.php");
}

$lapangan = query("SELECT * FROM lapangan");

if (isset($_POST["simpan"])) {
  if (tambahLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil DiTambahkan');
          window.location.href = 'lapangan.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal DiTambahkan');
          </script>";
  }
}

if (isset($_POST["edit"])) {
  if (editLpg($_POST) > 0) {
    echo "<script>
          alert('Berhasil Di Ubah');
          window.location.href = 'lapangan.php';
          </script>";
  } else {
    echo "<script>
          alert('Gagal Di Ubah');
          </script>";
  }
}

if (isset($_POST["editprofile"])) {
  if (editprofile($_POST) > 0) {
    echo "<script>
  alert('Berhasil Di Edit');
  window.location.href = 'lapangan.php';
</script>";
  } else {
    echo "<script>
  alert('Gagal Di Edit');
</script>";
  }
}

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

  <title>Home</title>
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
        <h3 class="mt-4">Data Lapangan</h3>
        <hr>
        <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#tambahModal1">Tambah</button>
        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahModal1" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Lapangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <!-- konten form modal -->
                  <div class="row justify-content-center align-items-center">
                    <div class="col">
                      <div class="mb-3">
                        <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
                        <input type="text" name="nama_lapangan" class="form-control" id="nama_lapangan">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="harga_lapangan" class="form-label">Harga</label>
                        <input type="number" name="harga_lapangan" class="form-control" id="harga_lapangan">
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="foto_lapangan" class="form-label">Foto</label>
                      <input type="file" name="foto_lapangan" class="form-control" id="foto_lapangan">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary" name="simpan" id="simpan">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal Tambah -->
        <div class="table-responsive">
          <table class="table table-hover text-center">
            <thead class="table-inti">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Lapangan</th>
                <th scope="col">Harga</th>
                <th scope="col">Foto</th>
                <th style="width:15%;" scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($lapangan as $row) : ?>
                <tr>

                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $row["nama_lapangan"]; ?></td>
                  <td><?= $row["harga_lapangan"]; ?></td>
                  <td><img src="../img/Lapangan/<?= $row["foto_lapangan"]; ?>" width="50" height="50"></td>
                  <td>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id_lapangan"]; ?>">Edit</button>
                    <a href="./controller/hapusLpg.php?id=<?= $row["id_lapangan"]; ?>" class="btn btn-danger btn-sm">Hapus</a>
                  </td>
                  <!-- Edit Modal -->
                  <div class="modal fade" id="editModal<?= $row["id_lapangan"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="tambahModalLabel">Edit Lapangan <?= $row["nama_lapangan"]; ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id_lapangan" class="form-control" id="exampleInputPassword1" value="<?= $row["id_lapangan"]; ?>">
                          <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $row["foto_lapangan"]; ?>">
                          <div class="modal-body">
                            <!-- konten form modal -->
                            <div class="row justify-content-center align-items-center">
                              <div class="mb-3">
                                <img src="../img/Lapangan/<?= $row["foto_lapangan"]; ?>" alt="gambar lapangan" class="img-fluid">
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="edit_nama_lapangan" class="form-label">Nama Lapangan</label>
                                  <input type="text" name="nama_lapangan" class="form-control" id="edit_nama_lapangan" value="<?= $row["nama_lapangan"]; ?>">
                                </div>
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="edit_harga_lapangan" class="form-label">Harga</label>
                                  <input type="number" name="harga_lapangan" class="form-control" id="edit_harga_lapangan" value="<?= $row["harga_lapangan"]; ?>">
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="edit_foto_lapangan" class="form-label">Foto : </label>
                                <input type="file" name="foto_lapangan" class="form-control" id="edit_foto_lapangan" value="<?= $row["foto_lapangan"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="edit" id="edit">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Tambah -->
                </tr>
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