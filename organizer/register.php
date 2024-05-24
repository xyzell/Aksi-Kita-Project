<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>AksiKita &mdash;Go for action!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Overpass:300,400,500|Dosis:400,700" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../assets/css/magnific-popup.css">
  <link rel="stylesheet" href="../assets/css/aos.css">
  <link rel="stylesheet" href="../assets/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../assets/css/jquery.timepicker.css">
  <link rel="stylesheet" href="../assets/css/flaticon.css">
  <link rel="stylesheet" href="../assets/css/icomoon.css">

  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

  <!-- START Navbar Section -->
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="../index.html">
        <div class="logo-header"><img src="/assets/images/logo/whiteLogo.png" alt="" width="126" height="45"></div>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="cariAksi.php" class="nav-link">Cari Aksi</a></li>
          <li class="nav-item"><a href="../about.php" class="nav-link">Tentang Kami</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">FAQ</a></li>
          <li class="nav-item active"><a href="../user/login.php" class="nav-link" data-toggle="modal" data-target="#loginModal" id="loginButton">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <!-- START modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Pilih Jenis Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body icon-grid">
          <button type="button" class="btn btn-primary btn-block" onclick="loginAsUser()"><i class="fa-solid fa-user"></i><span>User</span></button>
          <button type="button" class="btn btn-primary btn-block" onclick="loginAsOrganizer()"><i class="fa-solid fa-landmark"></i><span>Organizer</span></button>
        </div>
      </div>
    </div>
  </div>
  <!-- END modal -->


  <div class="site-section fund-raisers">
    <div class="container" style="padding-top: 50px;">
      <div class="row mb-3 justify-content-center">
        <div class="alert">
          <?php
          if (isset($_SESSION['status'])) {
          ?>
            <div class="alert alert-primary text-center">
              <h5><?= $_SESSION['status']; ?></h5>
            </div>
          <?php
            unset($_SESSION['status']);
          }
          ?>
        </div>
      </div>
      <div class="row mb-3 justify-content-center">
        <div class="col-md-8 text-center">
          <h2>FORMULIR REGISTRASI ORGANISASI</h2>
        </div>
      </div>
    </div>
    <div class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <!-- <div class="card-header">
              <h5>Registration Form</h5>
            </div> -->
            <div class="card-body">
              <form action="/organizer/registerCode.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_status" value="organizer">

                <!-- Section 1 -->
                <div class="form-section current">
                  <div class="form-group mb-3">
                    <label for="nama">Nama Organisasi</label>
                    <input type="text" name="nama" class="form-control" placeholder="jhondoe" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="email">Email Organisasi</label>
                    <input type="email" name="email" class="form-control" placeholder="jhon@example.com" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="pnumber">No. Telepon Organisasi</label>
                    <input type="text" name="pnumber" class="form-control" placeholder="0821XXXXXX" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="pass">Password</label>
                    <input type="password" name="pass" class="form-control" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="passConfirm">Konfirmasi Password</label>
                    <input type="password" name="passConfirm" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-primary next-btn">Next</button>
                  </div>
                </div>

                <!-- Section 2 -->
                <div class="form-section">
                  <div class="form-group mb-3">
                    <label for="orgTipe">Tipe Organisasi</label>
                    <select name="orgTipe" class="form-control" required>
                      <option value="" disabled selected>...</option>
                      <option value="Yayasan">Yayasan</option>
                      <option value="Koperasi">Koperasi</option>
                      <option value="Perusahaan">Perusahaan</option>
                      <option value="Umum">Umum</option>
                      <option value="Komunitas">Komunitas</option>
                      <option value="Lembaga Pemerintah">Lembaga Pemerintah</option>
                      <option value="Perkumpulan">Perkumpulan</option>
                      <option value="Lain-lain">Lain-lain</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label for="desc">Deskripsi Organisasi</label>
                    <textarea name="desc" class="form-control" rows="5" placeholder="Deskripsi Organisasi" required></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label for="address">Alamat Organisasi</label>
                    <input type="text" name="address" class="form-control" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="website">Website Organisasi</label>
                    <input type="text" name="website" class="form-control" required>
                  </div>
                  <div class="form-group mb-3">
                    <label for="logo_organisasi">Logo Organisasi</label>
                    <input type="file" name="logo_organisasi" class="form-control-file" accept="image/*" required>
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-secondary prev-btn">Back</button>
                    <button type="submit" name="registerBtn" class="btn btn-primary">Daftar Sekarang</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- .section -->



  <footer class="footer">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-6 col-lg-4">
          <h3 class="heading-section">About Us</h3>
          <p style="text-align: justify;" class="lead">AksiKita didirikan untuk mengoordinasikan aksi relawan dalam menanggapi
            masalah sosial, lingkungan, dan kemanusiaan. Kami berkembang pesat dengan membuka cabang,
            melatih relawan, dan mendapatkan pengakuan dari pemerintah dan media. </p>
          <p style="text-align: justify;" class="mb-5">Sekarang, fokus kami adalah pada proyek jangka panjang untuk pembangunan masyarakat,
            pendidikan, dan pembangunan berkelanjutan demi menciptakan dampak yang berkelanjutan.</p>
          <p><a href="#" class="link-underline">Read More</a></p>
        </div>
        <div class="col-md-6 col-lg-4">
          <h3 class="heading-section">Recent Blog</h3>
          <div class="block-21 d-flex mb-4">
            <figure class="mr-3">
              <img src="../assets/images/img_1.jpg" alt="" class="img-fluid">
            </figure>
            <div class="text">
              <h3 class="heading"><a href="#">Water Is Life. Clean Water In Urban Area</a></h3>
              <div class="meta">
                <div><a href="#"><span class="icon-calendar"></span> July 29, 2018</a></div>
                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
              </div>
            </div>
          </div>

          <div class="block-21 d-flex mb-4">
            <figure class="mr-3">
              <img src="../assets/images/img_2.jpg" alt="" class="img-fluid">
            </figure>
            <div class="text">
              <h3 class="heading"><a href="#">Life Is Short So Be Kind</a></h3>
              <div class="meta">
                <div><a href="#"><span class="icon-calendar"></span> July 29, 2018</a></div>
                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
              </div>
            </div>
          </div>

          <div class="block-21 d-flex mb-4">
            <figure class="mr-3">
              <img src="../assets/images/img_4.jpg" alt="" class="img-fluid">
            </figure>
            <div class="text">
              <h3 class="heading"><a href="#">Unfortunate Children Need Your Love</a></h3>
              <div class="meta">
                <div><a href="#"><span class="icon-calendar"></span> July 29, 2018</a></div>
                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="block-23">
            <h3 class="heading-section">Get Connected</h3>
            <ul>
              <li><span class="icon icon-map-marker"></span><span style="text-align: justify;" class="text">Jl. Khp Hasan Mustopa No.23, Neglasari, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40124</span></li>
              <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
              <li><a href="#"><span class="icon icon-envelope"></span><span class="text">Aksik1taaa@gmail.com</span></a></li>
            </ul>
          </div>
        </div>

        <!-- loader -->
        <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
          </svg></div>


        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/jquery-migrate-3.0.1.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.easing.1.3.js"></script>
        <script src="../assets/js/jquery.waypoints.min.js"></script>
        <script src="../assets/js/jquery.stellar.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/jquery.magnific-popup.min.js"></script>
        <script src="../assets/js/bootstrap-datepicker.js"></script>

        <script src="../assets/js/jquery.fancybox.min.js"></script>

        <script src="../assets/js/aos.js"></script>
        <script src="../assets/js/jquery.animateNumber.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
        <script src="../assets/js/google-map.js"></script>
        <script src="../assets/js/main.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const nextBtn = document.querySelector('.next-btn');
            const prevBtn = document.querySelector('.prev-btn');
            const formSections = document.querySelectorAll('.form-section');
            let currentSectionIndex = 0;

            nextBtn.addEventListener('click', function() {
              formSections[currentSectionIndex].classList.remove('current');
              currentSectionIndex++;
              formSections[currentSectionIndex].classList.add('current');
            });

            prevBtn.addEventListener('click', function() {
              formSections[currentSectionIndex].classList.remove('current');
              currentSectionIndex--;
              formSections[currentSectionIndex].classList.add('current');
            });
          });
        </script>
        <script>
          function loginAsUser() {
            // Redirect or perform actions for user login
            window.location.href = "user/login.php";
          }

          function loginAsOrganizer() {
            // Redirect or perform actions for organizer login
            // Example: window.location.href = "organizer/login.php";
            window.location.href = "../organizer/register.php";
            // alert("Fitur ini belum tersedia");
          }
        </script>
        <script>
          $(document).ready(function() {
            $("#loginButton").click(function() {
              $("#loginModal").modal();
            });
          });
        </script>
</body>

</html>