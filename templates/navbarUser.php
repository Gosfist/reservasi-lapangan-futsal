<?php
// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../function.php";

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['id_user'];
$conn = mysqli_connect("localhost", "root", "", "futsal");

// Proses simpan jika form disubmit
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_user'];
    $nohp = $_POST['no_wa_user'];
    $email = $_POST['email_user'];
    $password = $_POST['password_user'];

    $update = mysqli_query($conn, "UPDATE user SET 
        nama_user = '$nama',  
        no_wa_user = '$nohp', 
        email_user = '$email',
        password_user = '$password' 
        WHERE id_user = '$userId'");

    if ($update) {
        echo "<script>alert('Profil berhasil diperbarui'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil');</script>";
    }
}

// Ambil data profil
$result = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$userId'");
$profil = mysqli_fetch_assoc($result);
?>

<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="index.php" class="logo d-flex align-items-center me-auto">
      <img src="../assets/img/logo.png" alt="">
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="../index.php">Beranda<br></a></li>
        <li><a href="lapangan.php">Lapangan</a></li>
        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'User' || $_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin')) : ?>
          <li class="nav-item">
            <a class="nav-link" href="reservasi.php">Reservasi</a>
          </li>
        <?php endif; ?>
        <li><a href="kontak.php">Kontak</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'SuperAdmin' || $_SESSION['role'] === 'Admin')) : ?>
      <a href="../admin/home.php" class="btn-getstarted">
        <i class="bi bi-person"></i> Dashboard
      </a>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'User')) : ?>
      <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#profilModal">
        <i class="bi bi-person"></i> Profile
      </a>
    <?php endif; ?>

    <?php if (!isset($_SESSION['role'])) : ?>
      <a href="../login.php" class="btn-getstarted">
        <i class="bi bi-person"></i> Login
      </a>
    <?php endif; ?>


  </div>
</header>

<!-- Modal Profil -->
<div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profilModalLabel">Profil Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_user" class="form-control" 
              value="<?= isset($profil['nama_user']) ? htmlspecialchars($profil['nama_user']) : ''; ?>" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email_user" class="form-control" 
              value="<?= isset($profil['email_user']) ? htmlspecialchars($profil['email_user']) : ''; ?>" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_wa_user" class="form-control" 
              value="<?= isset($profil['no_wa_user']) ? htmlspecialchars($profil['no_wa_user']) : ''; ?>" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password_user" class="form-control"
            value="<?= isset($profil['password_user']) ? htmlspecialchars($profil['password_user']) : ''; ?>" disabled>
          </div>

          <div class="d-flex justify-content-between">
            <a href="../logout.php" class="btn btn-danger">Logout</a>
           <a href="#" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-danger">Edit Profil</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit profil -->
<div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_user" class="form-control" value="<?= htmlspecialchars($profil['nama_user']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">No Telp</label>
            <input type="text" name="no_wa_user" class="form-control" value="<?= htmlspecialchars($profil['no_wa_user']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email_user" class="form-control" value="<?= htmlspecialchars($profil['email_user']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password_user" class="form-control"
            value="<?= isset($profil['password_user']) ? htmlspecialchars($profil['password_user']) : ''; ?>">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Edit Modal -->
