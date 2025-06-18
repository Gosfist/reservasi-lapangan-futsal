<?php
session_start();
require "../function.php";
?>
<!DOCTYPE html>
<html lang="en">

<!-- header -->
<?php require_once '../templates/headUser.php'; ?>

<body class="index-page">

  <?php require_once '../templates/navbarUser.php'; ?>


  <main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <img src="../assets/img/hero-bg.jpg" alt="">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Syarat & Kententuan</h1>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Page Title -->

    <div class="container py-4">
    <ol class="fs-5 text-muted">
      <li>Pemesanan lapangan dapat dilakukan secara online melalui situs resmi <strong>Basecamp Sport Center</strong>.</li>
      <li>Pengguna wajib melakukan registrasi dan login sebelum melakukan reservasi.</li>
      <li>Pemesanan hanya dianggap sah setelah menerima konfirmasi dari pihak pengelola.</li>
      <li>Pembayaran dilakukan maksimal 1x24 jam setelah melakukan reservasi, jika tidak maka reservasi akan dibatalkan otomatis.</li>
      <li>Pengguna diwajibkan datang tepat waktu sesuai dengan jadwal yang telah dipesan.</li>
      <li>Tidak diperkenankan membawa makanan dan minuman dari luar ke area lapangan tanpa izin pengelola.</li>
      <li>Pembatalan pemesanan dapat dilakukan maksimal 12 jam sebelum jadwal main, dan pengembalian dana mengikuti kebijakan pengelola.</li>
      <li>Kerusakan fasilitas yang disebabkan oleh pengguna menjadi tanggung jawab pengguna sepenuhnya.</li>
      <li>Pengelola berhak menolak layanan kepada pengguna yang melanggar aturan dan tata tertib.</li>
    </ol>
  </div>
  </main>



  <!-- Footer -->
  <?php require_once '../templates/footerUser.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    function notiflogin() {
      alert("Silakan login terlebih dulu sebelum melakukan pemesanan.");
    }
  </script>

  <script>
    $(document).ready(function() {
      $('.cek-jam-btn').click(function() {
        var lapId = $(this).data('lapangan');
        var tgl = $('#tgl_main_' + lapId).val();
        if (!tgl) {
          $('#jamCheckboxContainer' + lapId).html('<div class="text-danger">Silakan pilih tanggal terlebih dahulu!</div>');
          return;
        }
        $.get('./controller/cekKetersediaan.php', {
          tgl: tgl,
          id_lapangan: lapId
        }, function(data) {
          $('#jamCheckboxContainer' + lapId).html(data);
        });
      });

      // Update hidden input jika checkbox berubah
      $(document).on('change', '[id^=jamCheckboxContainer] input[type=checkbox]', function() {
        var lapId = $(this).closest('div[id^=jamCheckboxContainer]').attr('id').replace('jamCheckboxContainer', '');
        var checked = [];
        $('#jamCheckboxContainer' + lapId + ' input[type=checkbox]:checked').each(function() {
          checked.push($(this).val());
        });
        $('#jam_mulai_input' + lapId).val(checked.join(','));
      });
    });
  </script>
</body>

</html> 