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
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambahadmin($data)
{
    global $conn;
    $email = $data["email_user"];
    $password = $data["password_user"];
    $nama = $data["nama_user"];
    $no_wa = $data["no_wa_user"];

    $query = "INSERT INTO user VALUES ('', '2', '$email','$password','$nama','$no_wa')";
    mysqli_query($conn,$query);
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
        
        // --- PATH DINAMIS YANG BENAR UNTUK STRUKTUR ANDA ---

        // KARENA functions.php ADA DI ROOT PROYEK, GUNAKAN __DIR__ SECARA LANGSUNG.
        // Ini akan secara otomatis menunjuk ke folder proyek Anda.
        $project_root = __DIR__; 
        
        // Gabungkan path root proyek dengan path ke folder gambar.
        $path_ke_file = $project_root . '/img/Lapangan/' . $nama_file_foto;

        // --- AKHIR PATH DINAMIS ---

        // Tetap lakukan pembersihan untuk keamanan
        $path_bersih = str_replace('\\', '/', $path_ke_file);
        
        if (file_exists($path_bersih)) {
            unlink($path_bersih);
        }
    }

    // Hapus data dari tabel database
    mysqli_query($conn, "DELETE FROM lapangan WHERE id_lapangan = $id_lapangan");

    return mysqli_affected_rows($conn);
}