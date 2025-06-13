<?php
session_start();
require "function.php";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'SuperAdmin') {
  header("Location: admin/home.php");
} else if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
  header("Location: admin/home.php");
} else if (isset($_SESSION['role']) && $_SESSION['role'] === 'User') {
  header("Location: index.php");
}

$error = false;
if (isset($_POST["login"])) {
    $email = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user 
    JOIN role ON user.id_role = role.id_role
    WHERE email_user = '$email' and password_user = '$password'");
    
    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['nama'] = $data['nama_user'];
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $data['nama_role'];

        if (isset($_SESSION["role"])) {
          if ($_SESSION["role"] == "SuperAdmin") {
            header("Location: admin/home.php");
          } else if ($_SESSION["role"] == "Admin") {
            header("Location: admin/home.php");
          } else {
            header("Location: user/lapangan.php");
          }
        }
        exit;
    } else {
      echo "<div class='alert alert-warning'>Username atau Password salah</div>
      <meta http-equiv='refresh' content='2'>";
    }

    $error = true;
}



?>

<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login Sport Center</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body class="login">
  <div class="center">
   
    <h1>Login</h1>
    <form method="POST">
      <div class="txt_field">
        <input type="email" name="username" required>
        <span></span>
        <label>Email</label>
      </div>
      <div class="txt_field">
        <input type="password" name="password" required>
        <span></span>
        <label>Password</label>
      </div>
      <div class="pass">Lupa Sandi?</div>
      <button class="button btn-inti" name="login" id="login">Login</button>
      <div class="signup_link">
        Belum punya akun? <a href="user/daftar.php">Daftar</a>
      </div>
    </form>
  </div>

</body>

</html>