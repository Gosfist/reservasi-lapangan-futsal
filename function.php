<?php
// koneksi database
$conn = mysqli_connect("localhost", "root", "", "futsal");

// Check eror koneksi database
if (mysqli_connect_errno()) {
  echo 'Koneksi gagal, ada masalah pada : ' . mysqli_connect_error();
  mysqli_close($conn);
  exit();
}

function query($data)
{
  global $conn;
  $result = mysqli_query($conn, $data);
  if ($result === false) {
    // DEBUG: tampilkan pesan error SQL
    echo "SQL Error: " . mysqli_error($conn) . "<br>";
    echo "Query: " . htmlspecialchars($data) . "<br>";
    return [];
  }
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}



// user
function editUser($data)
{
  global $conn;
  $id_user = $data["id_user"];
  $email = $data["email_user"];
  $password = $data["password_user"];
  $nama = $data["nama_user"];
  $no_wa = $data["no_wa_user"];

  if (!preg_match('/@gmail\.com$/', $email)) {
    echo "<script>
      alert('Email harus menggunakan domain @gmail.com');
      window.history.back();
    </script>";
    exit;
  }

  $query = "UPDATE user SET 
    email_user = '$email',
    password_user = '$password',
    nama_user = '$nama',
    no_wa_user  = '$no_wa' 
    WHERE id_user = '$id_user'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function hapusUser($data)
{
  global $conn;
  $query = "DELETE FROM user WHERE id_user = '$data'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function tambahadmin($data)
{
  global $conn;
  $email = htmlspecialchars($data["email_user"]);
  $password = htmlspecialchars($data["password_user"]);
  $nama = htmlspecialchars($data["nama_user"]);
  $no_wa = htmlspecialchars($data["no_wa_user"]);

  $cek = mysqli_query($conn, "SELECT * FROM user WHERE email_user = '$email'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>
      alert('Email sudah digunakan, gunakan email lain');
      window.history.back();
    </script>";
    exit;
  }

  if (!preg_match('/@gmail\.com$/', $email)) {
    echo "<script>
      alert('Email harus menggunakan domain @gmail.com');
      window.history.back();
    </script>";
    exit;
  }

  $query = "INSERT INTO user VALUES ('', '2', '$email','$password','$nama','$no_wa')";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function tambahMember($data)
{
  global $conn;

  $nama = htmlspecialchars($data["nama_user"]);
  $email = htmlspecialchars($data["email_user"]);
  $no_wa = htmlspecialchars($data["no_wa_user"]);
  $password = htmlspecialchars($data["password_user"]);

  $cek = mysqli_query($conn, "SELECT * FROM user WHERE email_user = '$email'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>
      alert('Email sudah digunakan, gunakan email lain');
      window.history.back();
    </script>";
    exit;
  }

  if (!preg_match('/@gmail\.com$/', $email)) {
    echo "<script>
      alert('Email harus menggunakan domain @gmail.com');
      window.history.back();
    </script>";
    exit;
  }

  $query = "INSERT INTO user VALUES ('', '3', '$email','$password','$nama','$no_wa')";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

// lapangan
function tambahLpg($data)
{
  global $conn;

  $nama_lapangan = $data["nama_lapangan"];
  $harga_lapangan = $data["harga_lapangan"];

  //Upload Gambar
  $upload = upload();
  if (!$upload) {
    return false;
  }

  $query = "INSERT INTO lapangan VALUES ('','$nama_lapangan','$harga_lapangan','$upload')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function editLpg($data)
{
  global $conn;

  $id = $data["id_lapangan"];
  $nama_lapangan = $data["nama_lapangan"];
  $harga_lapangan = $data["harga_lapangan"];
  $gambarLama =  $data["fotoLama"];

  // Cek apakah User pilih gambar baru
  if ($_FILES["foto_lapangan"]["error"] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }


  $query = "UPDATE lapangan SET 
  nama_lapangan = '$nama_lapangan',
  harga_lapangan = '$harga_lapangan',
  foto_lapangan = '$gambar' 
  WHERE id_lapangan = '$id'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function hapusLpg($id_lapangan)
{
  global $conn;

  $lapangan = query("SELECT foto_lapangan FROM lapangan WHERE id_lapangan = $id_lapangan");

  if ($lapangan && !empty($lapangan[0]['foto_lapangan'])) {
    $nama_file_foto = $lapangan[0]['foto_lapangan'];

    $project_root = __DIR__;
    $path_ke_file = $project_root . '/img/Lapangan/' . $nama_file_foto;
    $path_bersih = str_replace('\\', '/', $path_ke_file);

    if (file_exists($path_bersih)) {
      unlink($path_bersih);
    }
  }

  // Hapus data dari tabel database
  mysqli_query($conn, "DELETE FROM lapangan WHERE id_lapangan = $id_lapangan");

  return mysqli_affected_rows($conn);
}

function upload()
{
  $namaFile = $_FILES['foto_lapangan']['name'];
  $ukuranFile = $_FILES['foto_lapangan']['size'];
  $error = $_FILES['foto_lapangan']['error'];
  $tmpName = $_FILES['foto_lapangan']['tmp_name'];

  // Cek apakah tidak ada gambar yang di upload
  if ($error === 4) {
    echo "<script>
    alert('Pilih gambar terlebih dahulu');
    </script>";
    return false;
  }

  // Cek apakah gambar
  $extensiValid = ['jpg', 'png', 'jpeg'];
  $extensiGambar = explode('.', $namaFile);
  $extensiGambar = strtolower(end($extensiGambar));

  if (!in_array($extensiGambar, $extensiValid)) {
    echo "<script>
    alert('Yang anda upload bukan gambar!');
    </script>";
    return false;
  }

  if ($ukuranFile > 1000000) {
    echo "<script>
    alert('Ukuran Gambar Terlalu Besar!');
    </script>";
    return false;
  }

  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $extensiGambar;
  // Move File
  move_uploaded_file($tmpName, '../img/Lapangan/' . $namaFileBaru);
  return $namaFileBaru;
}

// jadwal
function editJadwal($data)
{
  global $conn;
  $id_jadwal = $data["edit_id_jadwal"];
  $hari_buka = $data["edit_hari_buka"];
  $jam_buka = $data["edit_jam_buka"];
  $jam_tutup = $data["edit_jam_tutup"];

  $query = "UPDATE jadwal SET 
            id_jadwal = '$id_jadwal',
            hari_buka = '$hari_buka',
            jam_buka = '$jam_buka',
            jam_tutup = '$jam_tutup'
            WHERE id_jadwal = '$id_jadwal'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// reservasi
function konfirmasiReservasi($id_reservasi)
{
  global $conn;
  $id = $id_reservasi;
  $query = "UPDATE reservasi SET status = 'lunas' WHERE id_reservasi = '$id'";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function hapusReservasi($id_reservasi)
{
  global $conn;

  $lapangan = query("SELECT bukti_pembayaran FROM reservasi WHERE id_reservasi = $id_reservasi");

  if ($lapangan && !empty($lapangan[0]['bukti_pembayaran'])) {
    $nama_file_foto = $lapangan[0]['bukti_pembayaran'];

    $project_root = __DIR__;
    $path_ke_file = $project_root . '/img/Bukti/' . $nama_file_foto;
    $path_bersih = str_replace('\\', '/', $path_ke_file);

    if (file_exists($path_bersih)) {
      unlink($path_bersih);
    }
  }

  mysqli_query($conn, "DELETE FROM reservasi WHERE id_reservasi = $id_reservasi");

  return mysqli_affected_rows($conn);
}

function addreservasi($data)
{
  global $conn;
  $lapangan = $data["id_lapangan"];
  $user = $_SESSION['id_user'];
  $tanggal_dipesan = date("Y-m-d");
  $tglMain = $data["tgl_main"];
  $jamMulai = $data["jam_mulai"];
  $harga = $data["harga_lapangan"];
  $toarray = explode(',', $jamMulai);
  $hargatotal = count($toarray) * $harga;

  $query = "INSERT INTO reservasi VALUES ('', '$lapangan', '$user','$tanggal_dipesan','$tglMain','$jamMulai','$hargatotal','','belum lunas')";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function formatJamBooking($dbString)
{
  // Jika string kosong, kembalikan string kosong
  if (empty(trim($dbString))) {
    return '';
  }

  $ranges = explode(',', $dbString);

  // 2. Ambil semua jam yang dibooking
  $bookedHours = [];
  foreach ($ranges as $range) {
    $parts = explode('-', trim($range));
    if (count($parts) === 2) {
      $start = (int)$parts[0];
      $end = (int)$parts[1];
      // Tambahkan semua jam dalam rentang ke array
      for ($h = $start; $h < $end; $h++) {
        $bookedHours[] = $h;
      }
    }
  }

  if (empty($bookedHours)) {
    return $dbString; // Kembalikan string asli jika format tidak dikenali
  }

  // 3. Urutkan dan hapus duplikat
  sort($bookedHours);
  $bookedHours = array_unique($bookedHours);

  // 4. Kelompokkan jam-jam yang berurutan
  $groups = [];
  $currentGroup = [];
  $lastHour = -1;

  foreach ($bookedHours as $hour) {
    if ($lastHour !== -1 && $hour > $lastHour + 1) {
      // Jika ada jeda, simpan grup sebelumnya dan mulai grup baru
      $groups[] = $currentGroup;
      $currentGroup = [];
    }
    $currentGroup[] = $hour;
    $lastHour = $hour;
  }
  // Simpan grup terakhir
  $groups[] = $currentGroup;

  // 5. Format setiap grup menjadi string HH:MM
  $outputParts = [];
  foreach ($groups as $group) {
    if (!empty($group)) {
      $startHour = min($group);
      $endHour = max($group) + 1; // Jam selesai adalah jam terakhir + 1
      $outputParts[] = sprintf('%02d:00 - %02d:00', $startHour, $endHour);
    }
  }

  // 6. Gabungkan semua bagian menjadi satu string akhir
  return implode(', ', $outputParts);
}

function konfirmasibayar($data)
{
  global $conn;
  $id_reservasi = $data["id_reservasi"];
  $upload = uploadBukti();
  if (!$upload) {
    return false;
  }

  $query = "UPDATE reservasi SET 
  bukti_pembayaran = '$upload',
  status = 'proses'  
  WHERE id_reservasi = '$id_reservasi'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function uploadBukti()
{
  $namaFile = $_FILES['bukti_pembayaran']['name'];
  $ukuranFile = $_FILES['bukti_pembayaran']['size'];
  $error = $_FILES['bukti_pembayaran']['error'];
  $tmpName = $_FILES['bukti_pembayaran']['tmp_name'];

  // Cek apakah tidak ada gambar yang di upload
  if ($error === 4) {
    echo "<script>
    alert('Pilih gambar terlebih dahulu');
    </script>";
    return false;
  }

  // Cek apakah gambar
  $extensiValid = ['jpg', 'png', 'jpeg'];
  $extensiGambar = explode('.', $namaFile);
  $extensiGambar = strtolower(end($extensiGambar));

  if (!in_array($extensiGambar, $extensiValid)) {
    echo "<script>
    alert('Yang anda upload bukan gambar!');
    </script>";
    return false;
  }

  if ($ukuranFile > 1000000) {
    echo "<script>
    alert('Ukuran Gambar Terlalu Besar!');
    </script>";
    return false;
  }

  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $extensiGambar;
  // Move File
  move_uploaded_file($tmpName, '../img/Bukti/' . $namaFileBaru);
  return $namaFileBaru;
}

// edit profile
function editprofile($data)
{
  global $conn;
  $id_user = $data["id_user"];
  $email = $data["email"];
  $password = $data["pass"];
  $nama = $data["nama"];
  $no_wa = $data["nowa"];

  $cek = mysqli_query($conn, "SELECT * FROM user WHERE email_user = '$email'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>
      alert('Email sudah digunakan, gunakan email lain');
      window.history.back();
    </script>";
    exit;
  }

  // Validasi email harus @gmail.com
  if (!preg_match('/@gmail\.com$/', $email)) {
    echo "<script>
      alert('Email harus menggunakan domain @gmail.com');
      window.history.back();
    </script>";
    exit;
  }

  $query = "UPDATE user SET 
    id_user = '$id_user',
    email_user = '$email',
    password_user = '$password',
    nama_user = '$nama',
    no_wa_user  = '$no_wa' 
    WHERE id_user = '$id_user'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// searching
function cari($data) {

  $query = "SELECT reservasi.*, user.nama_user, lapangan.nama_lapangan 
                    FROM reservasi 
                    JOIN user ON reservasi.id_user = user.id_user 
                    JOIN lapangan ON reservasi.id_lapangan = lapangan.id_lapangan WHERE id_reservasi LIKE '%$data%' ORDER BY id_reservasi DESC ";

  return query($query);

}

function carimember($data) {

  $query = "SELECT * FROM user WHERE id_role = 3 AND email_user LIKE '%$data%'";

  return query($query);

}