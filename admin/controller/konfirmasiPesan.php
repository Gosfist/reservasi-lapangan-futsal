<?php
require "../../function.php";
$id_reservasi = $_GET["id"];

if (konfirmasiReservasi($id_reservasi) > 0) {
  echo "
  <script>
    alert('Data Berhasil DiKonfirmasi');
    document.location.href = '../reservasi.php'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dikonfirmasi');
    document.location.href = '../reservasi.php'; 
  </script>
  ";
}
