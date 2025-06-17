<?php
require "../function.php";

if (isset($_POST["daftar"])) {
  if (tambahMember($_POST) > 0) {
    echo "<script>
      alert('Registrasi berhasil');
      window.location.href = '../login.php';
    </script>";
  } else {
    echo "<script>
      alert('Registrasi Gagal');
    </script>";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="../assets/img/logo.png" rel="icon">
 
</head>

<body class="login">
  <div class="full-height">
<div class="container ">
  <div class="row justify-content-center ">
    <div class="col-lg-8 col-md-11 col-sm-11">
      <form action="" method="post" enctype="multipart/form-data" class="bg-light py-2 px-4 rounded">
        <h1 class="regis mb-3">Registrasi</h1>
        <div class="row">
          <div class="col-lg-6 col-6 mb-2">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_user" class="form-control" id="nama" required>
          </div>
          <div class="col-lg-6 col-6 mb-2">
            <label for="hp" class="form-label">No Wa Aktif</label>
            <input type="number" name="no_wa_user" class="form-control" id="hp" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
          </div>
          <div class="col-lg-6 col-6 mb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email_user" class="form-control" id="email" required>
          </div>
          
          <div class="col-lg-6 col-6 mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password_user" class="form-control" id="password" required>
          </div>

          <div class="col-12 my-2 text-center">
            <button class="button btn-inti" name="daftar" id="daftar">Daftar</button>
            <p class="mt-2">Sudah punya akun ? <a href="../login.php">Login</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</body>

</html>