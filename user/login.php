<?php
  ini_set('display_errors',  true);
  error_reporting(E_ALL);

  session_start();
  include('../server/koneksi.php');

  if (isset($_SESSION['logged_in'])) {
      header('location: cariAksi.html');
      exit;
  }

  if (isset($_POST['login_btn'])) {
      $email = $_POST['email'];
      $password = md5($_POST['pass']);

      $query = "SELECT userId, userName, userEmail, userPassword, userGender, userAddress, userStatus, verifyOtp, verifyStatus FROM users WHERE userEmail = ? AND userPassword = ? LIMIT 1";

      $stmt_login = $conn->prepare($query);
      $stmt_login->bind_param('ss', $email, $password);
      
      if ($stmt_login->execute()) {
          $stmt_login->bind_result($user_id, $name, $userEmail, $userPassword, $gender, $address, $userStatus, $verify_token, $verifyStatus);
          $stmt_login->store_result();

          if ($stmt_login->num_rows() == 1) {
              $stmt_login->fetch();

              $_SESSION['userId'] = $user_id;
              $_SESSION['userName'] = $name;
              $_SESSION['userEmail'] = $userEmail;
              $_SESSION['userGender'] = $gender;
              $_SESSION['userAddress'] = $address;
              $_SESSION['userStatus'] = $userStatus;
              $_SESSION['verifyOtp'] = $verify_token;
              $_SESSION['verifyStatus'] = $verifyStatus;
              $_SESSION['logged_in'] = true;

              header('location: cariAksi.html?message=Logged in successfully');
          } else {
              header('location: login.php?error=Could not verify your account');
          }
      } else {          
          header('location: login.php?error=Something went wrong!');
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>AksiKita &mdash; Go for action!</title>
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
    <script src="https://kit.fontawesome.com/e1612437fd.js" crossorigin="anonymous"></script>

  </head>
  <body>
  
  <!-- START Navbar Section -->
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="../index.html"><div class="logo-header"><img src="/assets/images/logo/whiteLogo.png" alt="" width="126" height="45"></div></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="../index.html" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="how-it-works.html" class="nav-link">Cari Aksi</a></li>          
          <li class="nav-item"><a href="../about.html" class="nav-link">Tentang Kami</a></li>
          <li class="nav-item"><a href="contact.html" class="nav-link">FAQ</a></li>
          <li class="nav-item"><a href="user/login.php" class="nav-link" data-toggle="modal" data-target="#loginModal" id="loginButton">Login</a></li>           
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
  
  <section class="vh-100" style="padding: 150px;">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-7 col-lg-5 col-xl-5 justify-content-center">
          <div class="container">
            <?php
              if(isset($_SESSION['status'])) 
              {
                ?>
                <div class="alert alert-success text-center">
                    <h5><?= $_SESSION['status'];?></h5>
                </div>
                <?php
                unset($_SESSION['status']);
              }
            ?>
            <div class="row mb-3 justify-content-center" style="padding-top: 120px;"> 
              <div class="col-md-8 text-center">
                <h2>LOGIN</h2>        
              </div>        
            </div>
          </div>
          <form id="login-form" method="POST" action="login.php">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label" for="form1Example13">Email</label>
              <input type="email" id="form1Example13" name="email" class="form-control form-control-lg" />
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label" for="form1Example23">Password</label>
              <input type="password" id="form1Example23" name="pass" class="form-control form-control-lg" />
            </div>

            <div class="d-flex justify-content-around align-items-center mb-4">
              <!-- Checkbox -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3"> Ingat Saya </label>
              </div>
              <a href="#!">Lupa Password?</a>
            </div>
            <!-- Submit button -->
            <button type="submit" id="login_btn" name="login_btn" value="login" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block">Login</button>
            <div class="text-center">
                Belum punya akun? <a href="/user/register.php" class="register-link">Ayo Daftar!</a>
            </div>
          </form>
        </div>
    </div>
  </div>
</section> 
<!-- .section -->


  <footer class="footer">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-6 col-lg-4">
          <h3 class="heading-section">About Us</h3>
          <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
          <p class="mb-5">Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
          <p><a href="#" class="link-underline">Read  More</a></p>
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
                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
              </ul>
            </div>
        </div>
        
        
      </div>
      <div class="row pt-5">
        <div class="col-md-12 text-center">
          <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ion-ios-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


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
    $(document).ready(function(){
      $("#loginButton").click(function(){
        $("#loginModal").modal();
      });
    });
  </script>
  </body>
</html>