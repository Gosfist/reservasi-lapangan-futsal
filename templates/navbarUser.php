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
      <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#cekProfilModal">
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

<!-- Edit profil -->

<?php
$iduserprofile = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

if ($iduserprofile !== null) {
    $editprofiles = query("SELECT * FROM user WHERE id_user = $iduserprofile");
} else {
    // Tangani kasus ketika id_user tidak tersedia
    $editprofiles = null;
}

?>
<div class="modal fade" id="cekProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php $i = 1; ?>
      <?php foreach ($editprofiles as $editprofile) : ?>
        <input type="hidden" name="id_user" value="<?= $editprofile["id_user"]; ?>">
        <div class="modal-body">
          <div class="row justify-content-center align-items-center">
            <input type="hidden" name="id_user" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["id_user"]; ?>" disabled>
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["nama_user"]; ?>" disabled>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["email_user"]; ?>" disabled>
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">No Wa</label>
                <input type="number" name="nowa" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["no_wa_user"]; ?>" disabled>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="text" name="pass" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["password_user"]; ?>" disabled>
              </div>
            </div>
            <div class="modal-footer">
              <a href="../logout.php" class="btn btn-danger">Logout</a>
              <a class="btn-getstarted btn btn-success" data-bs-toggle="modal" data-bs-target="#editProfilModal">Ubah</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php
$iduserprofile = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

if ($iduserprofile !== null) {
    $editprofiles = query("SELECT * FROM user WHERE id_user = $iduserprofile");
} else {
    // Tangani kasus ketika id_user tidak tersedia
    $editprofiles = null;
}

?>
<div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php $i = 1; ?>
      <?php foreach ($editprofiles as $editprofile) : ?>
        <form action="" method="post">
          <input type="hidden" name="id_user" value="<?= $editprofile["id_user"]; ?>">
          <div class="modal-body">
            <div class="row justify-content-center align-items-center">
              <input type="hidden" name="id_user" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["id_user"]; ?>" require>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Nama</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["nama_user"]; ?>" require>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["email_user"]; ?>" require>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">No Wa</label>
                  <input type="number" name="nowa" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["no_wa_user"]; ?>" require>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="text" name="pass" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["password_user"]; ?>" require>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="editprofile" id="editprofile">Simpan</button>
              </div>
            </div>
          </div>
        </form>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php
if (isset($_POST["editprofile"])) {
  if (editprofile($_POST) > 0) {
    echo "<script>
  alert('Berhasil Di Edit');
  window.location.href = 'lapangan.php';
</script>";
  } else {
    echo "<script>
  alert('Gagal Di Edit');
</script>";
  }
}
?>