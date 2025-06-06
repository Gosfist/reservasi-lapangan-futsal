<?php
require "../../function.php";
$id_lapangan = $_GET["id"];



if (hapusLpg($id_lapangan) > 0) {
  echo "
  <script>
    alert('Data Berhasil Dihapus');
    document.location.href = '../lapangan.php'; 
  </script>
  ";
} else {
  echo "
  <script>
    alert('Data Gagal Dihapus');
    document.location.href = '../lapangan.php'; 
  </script>
  ";
}

