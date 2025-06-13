<?php
require "../../function.php";
$id_reservasi = $_GET["id"];

if (hapusReservasi($id_reservasi) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
    document.location.href = '../reservasi.php'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = '../reservasi.php'; 
  </script>
  ";
}
