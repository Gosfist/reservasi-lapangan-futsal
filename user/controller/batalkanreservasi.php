<?php
require "../../function.php";
$id_reservasi = $_GET["id"];

if (hapusReservasi($id_reservasi) > 0) {
  echo "
  <script>
    alert('Pesanan Berhasil Dibatalkan');
    document.location.href = '../reservasi.php'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Pesanan Gagal Dibatalkan Hubungi Kontak Admin');
    document.location.href = '../reservasi.php'; 
  </script>
  ";
}
