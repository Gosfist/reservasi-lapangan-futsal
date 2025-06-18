<?php
session_start();
require "../function.php";
require "../session.php";

if ($role !== 'SuperAdmin' && $role !== 'Admin') {
  header("location:../index.php");
}

$user = query("SELECT COUNT(id_role) AS jml_user FROM user WHERE id_role = 3")[0];
$lapangan = query("SELECT COUNT(id_lapangan) AS jml_lapangan FROM lapangan")[0];
$reservasi = query("SELECT COUNT(id_reservasi) AS jml_reservasi FROM reservasi WHERE status = 'lunas'")[0];
$penghasilan = query("SELECT SUM(harga) AS jml_penghasilan FROM reservasi WHERE status = 'lunas'")[0];


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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="../assets/img/logo.png" rel="icon">
  
  <title>Home</title>
</head>

<body>
  <div class="wrapper">
    <!-- navbar -->
    <?php require_once '../templates/navbarAdmin.php'; ?>

    <!-- konten home -->
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

      <h3 class="container mt-4">Beranda</h3>
      <hr>
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-xl-6">
            <div class="card bg-c-blue order-card">
              <div class="card-block">
                <h6>Member</h6>
                <h2 class="text-right flex-center"><i class="fa fa-user me-3"></i><span><?= $user["jml_user"]; ?></span></h2>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-xl-6">
            <div class="card bg-c-green order-card">
              <div class="card-block">
                <h6>Reservasi</h6>
                <h2 class="text-right flex-center"><i class="fa fa-cart-plus me-3"></i><span><?= $reservasi["jml_reservasi"]; ?></span></h2>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-xl-6">
            <div class="card bg-c-yellow order-card">
              <div class="card-block">
                <h6>Lapangan</h6>
                <h2 class="text-right flex-center"><i class="fa fa-dumbbell me-3"></i><span><?= $lapangan["jml_lapangan"]; ?></span></h2>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-xl-6">
            <div class="card bg-c-pink order-card">
              <div class="card-block">
                <h6>Penjualan</h6>
                <h3 class="text-right flex-center"><i class="fa fa-money-bills me-3"></i><?= $penghasilan["jml_penghasilan"]; ?></h2>
              </div>
            </div>
          </div>
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