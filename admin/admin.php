<?php
session_start();
require "../function.php";
require "../session.php";

if ($role !== 'SuperAdmin') {
  header("location:home.php");
};

$admin = query("SELECT * FROM user WHERE id_role = 2");

if (isset($_POST["tambah"])) {
  if (tambahAdmin($_POST) > 0) {
    echo "<script>
    alert('Admin Berhasil DiTambahkan');
    window.location.href = 'admin.php';
    </script>";
  } else {
    echo "<script>
    alert('Admin Gagal DiTambahkan');
    </script>";
  }
}

if (isset($_POST["edit"])) {
  if (editAdmin($_POST) > 0) {
    echo "<script>
  alert('Berhasil Di Edit');
  window.location.href = 'admin.php';
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
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <title>Home</title>
</head>

<body>
  <div class="wrapper">
    <!-- navbar -->
    <?php require_once '../templates/navbarAdmin.php'; ?>

    <!-- konten -->
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
        <h3 class="mt-4">Data Admin</h3>
        <hr>
        <button class="btn btn-inti mb-2" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah</button>
        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                <div class="modal-body">
                  <!-- konten form modal -->
                  <div class="row justify-content-center align-items-center">
                    <div class="col">
                      <div class="mb-3">
                        <label for="nama_user" class="form-label">Nama</label>
                        <input type="text" name="nama_user" class="form-control" id="nama_user">
                      </div>
                      <div class="mb-3">
                        <label for="email_user" class="form-label">Email</label>
                        <input type="email" name="email_user" class="form-control" id="email_user">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="no_wa_user" class="form-label">No Wa</label>
                        <input type="number" name="no_wa_user" class="form-control" id="no_wa_user">
                      </div>
                      <div class="mb-3">
                        <label for="password_user" class="form-label">Password</label>
                        <input type="password" name="password_user" class="form-control" id="password_user">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary" name="tambah" id="tambah">Tambah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal Tambah -->
        <div class="table-responsive">
          <table class="table table-hover ">
            <thead class="table-inti">
              <tr>
                <th style="width:5%;" scope="col">No</th>
                <th style="width:25%;" scope="col">Nama</th>
                <th style="width:25%;" scope="col">Email</th>
                <th style="width:25%;" scope="col">No Hp</th>
                <th style="width:20%;" scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($admin as $row) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $row["nama_user"]; ?></td>
                  <td><?= $row["email_user"]; ?></td>
                  <td><?= $row["no_wa_user"]; ?></td>
                  <td>

                    <button class="btn btn-inti" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id_user"]; ?>">Edit</button>
                    <a href="./controller/hapusAdmin.php?id=<?= $row["id_user"]; ?>" class="btn btn-danger">Hapus</a>
                  </td>

                  <!-- Edit Modal -->
                  <div class="modal fade" id="editModal<?= $row["id_user"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="tambahModalLabel">Edit Admin <?= $row["nama_user"]; ?></h5>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_user" class="form-control" id="exampleInputPassword1" value="<?= $row["id_user"]; ?>">
                          <input type="hidden" name="id_role" class="form-control" id="exampleInputPassword1" value="<?= $row["id_role"]; ?>">
                          <div class="modal-body">
                            <!-- konten form modal -->
                            <div class="row justify-content-center align-items-center">
                              <div class="col">
                                <div class="mb-3">
                                  <label for="edit_nama_user" class="form-label">Nama</label>
                                  <input type="nama" name="nama_user" class="form-control" id="edit_nama_user" value="<?= $row["nama_user"]; ?>">
                                </div>
                                <div class="mb-3">
                                  <label for="edit_email_user" class="form-label">Email</label>
                                  <input type="email" name="email_user" class="form-control" id="edit_email_user" value="<?= $row["email_user"]; ?>">
                                </div>
                              </div>
                              <div class="col">
                                <div class="mb-3">
                                  <label for="edit_no_wa_user" class="form-label">No Wa</label>
                                  <input type="number" name="no_wa_user" class="form-control" id="edit_no_wa_user" value="<?= $row["no_wa_user"]; ?>">
                                </div>
                                <div class="mb-3">
                                  <label for="edit_password_user" class="form-label">Password</label>
                                  <input type="password" name="password_user" class="form-control" id="edit_password_user" value="<?= $row["password_user"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              <button type="submit" class="btn btn-primary" name="edit" id="edit">Ubah</button>
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