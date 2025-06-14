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
    
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'Admin')) : ?>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-4 my-5">
              <img src="img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
            </div>
            <div class="col-8">
              <h5 class="mb-3"><?= $profil["212279_nama_lengkap"]; ?></h5>
              <p><?= $profil["212279_jenis_kelamin"]; ?></p>
              <p><?= $profil["212279_email"]; ?></p>
              <p><?= $profil["212279_no_handphone"]; ?></p>
              <p><?= $profil["212279_alamat"]; ?></p>
              <a href="../logout.php" class="btn btn-danger">Logout</a>
              <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-inti">Edit Profil</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Profil -->

<!-- Edit profil -->
<div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
  <div class="modal-dialog edit modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_foto"]; ?>">
        <div class="modal-body">
          <div class="row justify-content-center align-items-center">
            <div class="mb-3">
              <img src="img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                <input type="text" name="212279_nama_lengkap" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_nama_lengkap"]; ?>">
              </div>
              <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                  <option value="Laki-laki" <?php if ($profil['212279_jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                  <option value="Perempuan" <?php if ($profil['212279_jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="212279_no_handphone" class="form-label">No Telp</label>
                <input type="number" name="212279_no_handphone" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_no_handphone"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_email"]; ?>">
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">alamat</label>
              <input type="text" name="212279_alamat" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_alamat"]; ?>">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Foto : </label>
              <input type="file" name="212279_foto" class="form-control" id="exampleInputPassword1">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-inti" name="simpan" id="simpan">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Edit Modal -->