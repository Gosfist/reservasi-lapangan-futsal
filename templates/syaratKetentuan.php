<?php
// syarat-ketentuan.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Syarat & Ketentuan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/img/logo.png" rel="icon">
</head>
<body>

  <!-- Header atau Navbar (opsional) -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">Basecamp Sport Center</a>

    </div>
  </nav>

  <!-- Konten Utama -->
  <div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Syarat & Ketentuan Pemesanan Lapangan</h2>
    <ol class="fs-5 text-muted">
      <li>Pemesanan lapangan dapat dilakukan secara online melalui situs resmi <strong>Basecamp Sport Center</strong>.</li>
      <li>Pengguna wajib melakukan registrasi dan login sebelum melakukan reservasi.</li>
      <li>Pemesanan hanya dianggap sah setelah menerima konfirmasi dari pihak pengelola.</li>
      <li>Pembayaran dilakukan maksimal 1x24 jam setelah melakukan reservasi, jika tidak maka reservasi akan dibatalkan otomatis.</li>
      <li>Pengguna diwajibkan datang tepat waktu sesuai dengan jadwal yang telah dipesan.</li>
      <li>Tidak diperkenankan membawa makanan dan minuman dari luar ke area lapangan tanpa izin pengelola.</li>
      <li>Pembatalan pemesanan dapat dilakukan maksimal 12 jam sebelum jadwal main, dan pengembalian dana mengikuti kebijakan pengelola.</li>
      <li>Kerusakan fasilitas yang disebabkan oleh pengguna menjadi tanggung jawab pengguna sepenuhnya.</li>
      <li>Pengelola berhak menolak layanan kepada pengguna yang melanggar aturan dan tata tertib.</li>
    </ol>
    <div class="mt-4 text-center">
      <a href="../index.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-light text-center text-muted py-4 mt-5">
    <div class="container">
      &copy; <?= date('Y') ?> Basecamp Sport Center. All rights reserved.
    </div>
  </footer>

  <!-- Script Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
