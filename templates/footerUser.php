<footer id="footer" class="footer bg-light py-5">
  <div class="container">
    <div class="row gy-4 align-items-start">
      
      <!-- Kolom Kiri: Info Basecamp -->
      <div class="col-md-4 text-start">
        <a href="index.php" class="logo d-flex align-items-center mb-3">
          <span class="sitename fs-4 fw-bold text-dark">Basecamp</span>
        </a>
        <p class="mb-2 fs-6 text-muted">
          Jalan Brigjen Katamso KAV. Mbah, Gg. Mangun No.43,<br>
          Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316
        </p>
        <p class="mb-1 fs-6"><strong>Phone:</strong> <span>+62 831 1036 1634</span></p>
        <p class="fs-6"><strong>Email:</strong> <span>bascmpsc@gmail.com</span></p>
        <div class="social-links d-flex gap-3 mt-3">
          <a href="#"><i class="bi bi-geo-alt fs-5 text-dark"></i></a>
          <a href="#"><i class="bi bi-telephone fs-5 text-dark"></i></a>
          <a href="#"><i class="bi bi-envelope fs-5 text-dark"></i></a>
        </div>
      </div>

      <!-- Kolom Tengah: Navigasi -->
      <div class="col-md-4 d-flex flex-column align-items-center">
        <h5 class="fw-semibold mb-3">Navigasi</h5>
          <ul class="list-unstyled fs-6 text-center">
            <li class="mb-2"><a href="../index.php" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="mb-2"><a href="../user/lapangan.php" class="text-decoration-none text-muted">Lapangan</a></li>
            <li class="mb-2"><a href="../user/kontak.php" class="text-decoration-none text-muted">Kontak</a></li>
          <?php if (isset($_SESSION['id_user'])): ?>
            <li class="mb-2"><a href="../user/reservasi.php" class="text-decoration-none text-muted">Reservasi</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Kolom Kanan: Syarat & Ketentuan, agak ke tengah -->
      <div class="col-md-4 d-flex flex-column align-items-center">
        <h5 class="fw-semibold mb-3">Syarat & Ketentuan</h5>
        <ul class="list-unstyled fs-6">
          <li><a href="../user/syaratKetentuan.php" class="text-decoration-none text-muted">Lihat Syarat & Ketentuan</a></li>
        </ul>
      </div>

    </div>
  </div>
</footer>