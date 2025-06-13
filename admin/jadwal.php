<?php
session_start();
require "../session.php";
require "../function.php";

if ($role !== 'SuperAdmin' && $role !== 'Admin') {
    header("location:../index.php");
}


$jadwal = query("SELECT 
    id_jadwal, hari_buka, DATE_FORMAT(jam_buka, '%H:%i') AS jam_buka, 
    DATE_FORMAT(jam_tutup, '%H:%i') AS jam_tutup FROM jadwal;");

if (isset($_POST["edit"])) {
    if (editJadwal($_POST) > 0) {
        echo "<script>
  alert('Berhasil Di Edit');
  window.location.href = 'jadwal.php';
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
                <h3 class="mt-4">Data Jam Operasional</h3>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead class="table-inti">
                            <tr>
                                <th style="width:5%;" scope="col">No</th>
                                <th style="width:25%;" scope="col">Hari</th>
                                <th style="width:25%;" scope="col">Jam Buka</th>
                                <th style="width:25%;" scope="col">Jam Tutup</th>
                                <th style="width:20%;" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($jadwal as $row) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $row["hari_buka"]; ?></td>
                                    <td><?= $row["jam_buka"]; ?></td>
                                    <td><?= $row["jam_tutup"]; ?></td>
                                    <td>
                                        <button class="btn btn-inti" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id_jadwal"]; ?>">Edit</button>
                                    </td>

                                    <!-- Edit Jadwal -->
                                    <div class="modal fade" id="editModal<?= $row["id_jadwal"]; ?>" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tambahModalLabel">Edit Hari <?= $row["hari_buka"]; ?></h5>
                                                </div>
                                                <form action="" method="post">
                                                    <input type="hidden" name="edit_id_jadwal" class="form-control" id="exampleInputPassword1" value="<?= $row["id_jadwal"]; ?>">
                                                    <input type="hidden" name="edit_hari_buka" class="form-control" id="exampleInputPassword1" value="<?= $row["hari_buka"]; ?>">
                                                    <div class="modal-body">
                                                        <!-- konten form modal -->
                                                        <div class="row justify-content-center align-items-center">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="edit_jam_buka" class="form-label">Jam Buka</label>
                                                                    <select class="form-control" name="edit_jam_buka">
                                                                        <?php for ($a = 0; $a <= 24; $a++): ?>
                                                                            <?php $jam = str_pad($a, 2, "0", STR_PAD_LEFT) . ":00"; ?>
                                                                            <option value="<?= $jam ?>" <?= ($jam == $row["jam_buka"]) ? 'selected' : '' ?>><?= $jam ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>

                                                                    <!-- <input type="time" name="edit_jam_buka" class="form-control" id="edit_jam_buka" value="<?= $row["jam_buka"]; ?>"> -->
                                                                </div>

                                                            </div> 
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="edit_jam_tutup" class="form-label">Jam Tutup</label>
                                                                    <select class="form-control" name="edit_jam_tutup">
                                                                        <?php for ($b = 0; $b <= 24; $b++): ?>
                                                                            <?php $jam = str_pad($b, 2, "0", STR_PAD_LEFT) . ":00"; ?>
                                                                            <option value="<?= $jam ?>" <?= ($jam == $row["jam_tutup"]) ? 'selected' : '' ?>><?= $jam ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
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
            function editJamTutup() {
                var jamBuka = document.getElementById("edit_jam_buka").value;
                var jamTutupSelect = document.getElementById("edit_jam_tutup");

                // Kosongkan opsi jam tutup
                jamTutupSelect.innerHTML = "";

                // Ambil nilai jam dari inputan jam buka
                var jamBukaInt = parseInt(jamBuka.split(":")[0]);

                // Tambahkan opsi jam tutup yang lebih besar dari jam buka
                <?php
                echo "var options = '';";
                for ($i = 0; $i <= 24; $i++) {
                    $jam = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";
                    echo "if ($i > jamBukaInt) options += '<option value=\"$jam\">$jam</option>'; ";
                }
                echo "jamTutupSelect.innerHTML = options;";
                ?>
            }
        </script>

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