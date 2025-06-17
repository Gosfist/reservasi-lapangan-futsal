<aside id="sidebar">
  <div class="d-flex">
    <button class="toggle-btn" type="button">
      <i class="fa-solid fa-bars"></i>
    </button>

    <div class="sidebar-logo">
      <?php if ($role == "SuperAdmin") : ?>
        <span><?= $_SESSION['role']; ?></span>
      <?php endif; ?>

      <?php if ($role == "Admin") : ?>
        <span><?= $_SESSION['nama']; ?></span>
      <?php endif; ?>

    </div>
  </div>

  <ul class="sidebar-nav">
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a href="home.php" class="sidebar-link d-flex align-items-center">
          <i class="fa-solid fa-house fa-fw me-3"></i>
          <span>Beranda</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a href="reservasi.php" class="sidebar-link d-flex align-items-center">
          <i class="fa-solid fa-money-bills fa-fw me-3"></i>
          <span>Reservasi</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a href="#akunCollapse" data-bs-toggle="collapse" class="sidebar-link d-flex align-items-center" aria-expanded="false">
          <i class="fa-solid fa-user-circle fa-fw me-3"></i>
          <span>Akun</span>
        </a>
        <ul class="collapse list-unstyled" id="akunCollapse">
          <?php if ($role == "SuperAdmin") : ?>
            <li class="ps-4">
              <a href="admin.php" class="sidebar-link d-flex align-items-center">
                <i class="fa-solid fa-user-tie fa-fw me-3"></i>
                <span>Admin</span>
              </a>
            </li>
          <?php endif; ?>
          <li class="ps-4">
            <a href="member.php" class="sidebar-link d-flex align-items-center">
              <i class="fa-solid fa-user fa-fw me-3"></i>
              <span>Member</span>
            </a>
          </li>
          <li class="ps-4">
            <a href="#" class="sidebar-link d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editProfilModal">
              <i class="fa-solid fa-user-edit fa-fw me-3"></i>
              <span>Edit Profile</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="sidebar-item">
        <a href="#dataCollapse" data-bs-toggle="collapse" class="sidebar-link d-flex align-items-center" aria-expanded="false">
          <i class="fa-solid fa-database fa-fw me-3"></i>
          <span>Data</span>
        </a>
        <ul class="collapse list-unstyled" id="dataCollapse">
          <li class="ps-4">
            <a href="lapangan.php" class="sidebar-link d-flex align-items-center">
              <i class="fa-solid fa-dumbbell fa-fw me-3"></i>
              <span>Lapangan</span>
            </a>
          </li>
          <li class="ps-4">
            <a href="jadwal.php" class="sidebar-link d-flex align-items-center">
              <i class="fa-solid fa-calendar-check fa-fw me-3"></i>
              <span>Jadwal</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="sidebar-item">
        <a href="../index.php" class="sidebar-link d-flex align-items-center">
          <i class="fa-solid fa-globe fa-fw me-3"></i>
          <span>Website</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a href="../logout.php" class="sidebar-link d-flex align-items-center">
          <i class="fa-solid fa-right-from-bracket fa-fw me-3"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </ul>

</aside>


<!-- Edit profil -->

<?php
$iduserprofile = $_SESSION['id_user'];
$editprofiles = query("SELECT * FROM user WHERE id_user = $iduserprofile");

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
          <input type="hidden" name="id_reservasi" value="<?= $row["id_reservasi"]; ?>">
          <div class="modal-body">
            <div class="row justify-content-center align-items-center">
              <input type="hidden" name="id_user" class="form-control" id="exampleInputPassword1" value="<?= $editprofile["id_user"]; ?>">
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