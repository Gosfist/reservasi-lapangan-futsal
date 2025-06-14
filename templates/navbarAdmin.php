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
    <li class="sidebar-item">
      <a href="home.php" class="sidebar-link d-flex align-items-center">
        <i class="fa-solid fa-house fa-fw me-3"></i>
        <span>Beranda</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="member.php" class="sidebar-link d-flex align-items-center">
        <i class="fa-solid fa-user fa-fw me-3"></i>
        <span>Member</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="lapangan.php" class="sidebar-link d-flex align-items-center">
        <i class="fa-solid fa-dumbbell fa-fw me-3"></i>
        <span>Lapangan</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="jadwal.php" class="sidebar-link d-flex align-items-center">
        <i class="fa-solid fa-calendar-check fa-fw me-3"></i>
        <span>Jadwal</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="reservasi.php" class="sidebar-link d-flex align-items-center">
        <i class="fa-solid fa-money-bills fa-fw me-3"></i>
        <span>Reservasi</span>
      </a>
    </li>

    <?php if ($role == "SuperAdmin") : ?>
      <li class="sidebar-item">
        <a href="admin.php" class="sidebar-link d-flex align-items-center">
          <i class="fa-solid fa-user-tie fa-fw me-3"></i>
          <span>Admin</span>
        </a>
      </li>
    <?php endif; ?>

    <li class="sidebar-item">
      <a href="../index.php" class="sidebar-link d-flex align-items-center">
        <i class="fa-solid fa-globe"></i>
        <span>Website</span>
      </a>
    </li>
  </ul>

  <div class="sidebar-footer">
    <a href="../logout.php" class="sidebar-link">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span>Logout</span>
    </a>
  </div>

</aside>