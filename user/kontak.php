<?php
session_start();
require "../function.php";

?>

<!DOCTYPE html>
<html lang="en">

<!-- header -->
<?php require_once '../templates/headUser.php'; ?>

<body class="index-page">
  <!-- navbar  -->
  <?php require_once '../templates/navbarUser.php'; ?>

  <main class="main">
    <section id="contact" class="contact section">

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe style="border:0; width: 100%; height: 300px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31598.125999591968!2d113.1852795743164!3d-8.125315799999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65d9db1a4f8b1%3A0xb5afd8c6c89a11fd!2sPOEKIZ%20FUTSAL%20LUMAJANG!5e0!3m2!1sid!2sid!4v1749124145266!5m2!1sid!2sid" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Address</h3>
                <p>A108 Adam Street, New York, NY 535022</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+1 5589 55488 55</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>info@example.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-12">
                  <input type="text" name="name" class="form-control rounded" placeholder="Nama Lengkap" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control rounded" name="message" rows="6" placeholder="Pesan" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">

                  <button type="submit">Kirim via whatsapp</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->
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

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>