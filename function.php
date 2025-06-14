<?php
// koneksi database
$conn = mysqli_connect("localhost", "root", "", "futsal");

// Check eror koneksi database
if (mysqli_connect_errno()) {
  echo 'Koneksi gagal, ada masalah pada : ' . mysqli_connect_error();
  mysqli_close($conn);
  exit();
}

// read (memanggil data)
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

function tambahMember($data)
{
  global $conn;

  $nama = htmlspecialchars($data["nama_user"]);
  $email = htmlspecialchars($data["email_user"]);
  $no_wa = htmlspecialchars($data["no_wa_user"]);
  $password = $data["password_user"];
  $id_role = 3;

  // Validasi email harus @gmail.com
  if (!preg_match('/@gmail\.com$/', $email)) {
    echo "<script>
      alert('Email harus menggunakan domain @gmail.com');
      window.history.back();
    </script>";
    exit;
  }

  $query = "INSERT INTO user (nama_user, email_user, no_wa_user, password_user, id_role)
            VALUES ('$nama', '$email', '$no_wa', '$password', $id_role)";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function daftar($data)
{
  global $conn;

  $nama = htmlspecialchars($data["nama"]);
  $email = strtolower($data["email"]);
  $no_wa = htmlspecialchars($data["hp"]);
  $password = $data["password"];
  $id_role = 3; // Role member biasa

  // Cek apakah email sudah dipakai
  $cek = mysqli_query($conn, "SELECT * FROM user WHERE email_user = '$email'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.');</script>";
    return 0;
  }

  // Masukkan data ke DB
  $query = "INSERT INTO user (nama_user, email_user, no_wa_user, password_user, id_role)
            VALUES ('$nama', '$email', '$no_wa', '$password', $id_role)";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function tambahadmin($data)
{
  global $conn;
  $email = $data["email_user"];
  $password = $data["password_user"];
  $nama = $data["nama_user"];
  $no_wa = $data["no_wa_user"];

  // Validasi email harus @gmail.com
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

function editAdmin($data)
{
  global $conn;
  $id_user = $data["id_user"];
  $id_role = $data["id_role"];
  $email = $data["email_user"];
  $password = $data["password_user"];
  $nama = $data["nama_user"];
  $no_wa = $data["no_wa_user"];

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
    id_role = '$id_role',
    email_user = '$email',
    password_user = '$password',
    nama_user = '$nama',
    no_wa_user  = '$no_wa' 
    WHERE id_user = '$id_user'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function hapusAdmin($data)
{
  global $conn;
  $query = "DELETE FROM user WHERE id_user = '$data'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function hapusMember($data)
{
  global $conn;
  $query = "DELETE FROM user WHERE id_user = '$data'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

function editMember($data)
{
  global $conn;
  $id_user = $data["id_user"];
  $id_role = $data["id_role"];
  $email = $data["email_user"];
  $password = $data["password_user"];
  $nama = $data["nama_user"];
  $no_wa = $data["no_wa_user"];

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
    id_role = '$id_role',
    email_user = '$email',
    password_user = '$password',
    nama_user = '$nama',
    no_wa_user  = '$no_wa' 
    WHERE id_user = '$id_user'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

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

function konfirmasiReservasi($id_reservasi)
{
  global $conn;

  $id = $id_reservasi;

  $tes = mysqli_query($conn, "UPDATE reservasi SET konfirmasi = 'lunas' WHERE id_reservasi = '$id'");

  var_dump($tes);
  return mysqli_affected_rows($conn);
}

function hapusReservasi($id_reservasi)
{
  global $conn;

  $lapangan = query("SELECT bukti_pembayaran FROM reservasi WHERE id_reservasi = $id_reservasi");

  if ($lapangan && !empty($lapangan[0]['bukti_pembayaran'])) {
    $nama_file_foto = $lapangan[0]['bukti_pembayaran'];

    $project_root = __DIR__;
    $path_ke_file = $project_root . '/img/Bukti Pembayaran/' . $nama_file_foto;
    $path_bersih = str_replace('\\', '/', $path_ke_file);

    if (file_exists($path_bersih)) {
      unlink($path_bersih);
    }
  }

  // Hapus data dari tabel database
  mysqli_query($conn, "DELETE FROM reservasi WHERE id_reservasi = $id_reservasi");

  return mysqli_affected_rows($conn);
}
