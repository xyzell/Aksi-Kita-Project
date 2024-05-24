<?php
session_start();

// Cek apakah pengguna sudah login
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('location: login.php?error=Anda harus login terlebih dahulu');
//     exit;
// }

// Mengambil informasi pengguna dari sesi
// $userId = $_SESSION['userId'];
// $userName = $_SESSION['userName'];
// $userEmail = $_SESSION['userEmail'];
// $userGender = $_SESSION['userGender'];
// $userAddress = $_SESSION['userAddress'];
// $userStatus = $_SESSION['userStatus'];
// $verifyOtp = $_SESSION['verifyOtp'];
// $verifyStatus = $_SESSION['verifyStatus'];

include './server/koneksi.php';

if (isset($_POST['search']) && isset($_POST['product_category'])) {
  //Get all products by category
  $category = $_POST['product_category'];
  $query_products = "SELECT * FROM campaign WHERE product_category = ?";
  $stmt_products = $conn->prepare($query_products);
  $stmt_products->bind_param('s', $category);
  $stmt_products->execute();
  $products = $stmt_products->get_result();
} else { 
  //Get all products
  $query_products = "SELECT * FROM campaign";
  $stmt_products = $conn->prepare($query_products);
  $stmt_products->execute();
  $products = $stmt_products->get_result();
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
    <link rel="stylesheet" href="../assets/css/fancybox.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">

  </head>
  <body>
    
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="../index.html"><div class="logo-header"><img src="/assets/images/logo/whiteLogo.png" alt="" width="126" height="45"></div></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
              <li class="nav-item active"><a href="cariAksi.php" class="nav-link">Cari Aksi</a></li>          
              <li class="nav-item"><a href="../about.php" class="nav-link">Tentang Kami</a></li>
              <li class="nav-item"><a href="contact.php" class="nav-link">FAQ</a></li>
              <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user fa-sm"></i>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="my-profile.php">My Profile</a></li>
                    <li><a class="dropdown-item" href="../user/logout.php">Logout</a></li>
                  </ul>
                </li>
              <?php else: ?>
                <li class="nav-item"><a href="../user/login.php" class="nav-link" data-toggle="modal" data-target="#loginModal" id="loginButton">Login</a></li>
              <?php endif; ?>   
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
  
  <div class="block-31" style="position: relative;">
    <div class="owl-carousel loop-block-31 ">    
      
    </div>
  </div>
  
  <div class="site-section">
    <div class="container">
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <form method="POST" action="shop.php">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-heading">
                                            <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                        </div>
                                        <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="shop__sidebar__categories">
                                                    <ul class="nice-scroll">
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="sepatu" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'sepatu') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Sepatu</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="jaket" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'jaket') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Jaket</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="kaos" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'kaos') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Kaos</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="sepatu" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'sepatu') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Sepatu</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="syal" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'syal') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Syal</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-secondary" onClick="history.go(0);">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                            <input type="submit" class="btn btn-primary" name="search" value="Search" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1–12 of 126 results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select>
                                        <option value="">Low To High</option>
                                        <option value="">$0 - $55</option>
                                        <option value="">$55 - $100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <?php while ($row = $products->fetch_assoc()) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" 
                                data-setbg="img/product/<?php echo $row['product_image1']; ?>">
                                    <ul class="product__hover">
                                        <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                        <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a>
                                        </li>
                                        <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><?php echo $row['product_name']; ?></h6>
                                    <h5><?php echo $row['product_brand']; ?></h5>
                                    <a href="<?php echo "shop-details.php?product_id=" . $row['product_id']; ?>" 
                                    class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>                                    
                                    <div class="product__color__select">
                                        <label for="pc-4">
                                            <input type="radio" id="pc-4">
                                        </label>
                                        <label class="active black" for="pc-5">
                                            <input type="radio" id="pc-5">
                                        </label>
                                        <label class="grey" for="pc-6">
                                            <input type="radio" id="pc-6">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                <a class="active" href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <span>...</span>
                                <a href="#">21</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
    </div>
  </div>
    
    <div class="site-section fund-raisers">      
      <!-- <div class="my-2">
          <a class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
          <a class="btn btn-danger" href="?logout">Logout</a>
      </div> -->
    </div> 
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
              <img src="images/img_1.jpg" alt="" class="img-fluid">
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
              <img src="images/img_2.jpg" alt="" class="img-fluid">
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
              <img src="images/img_4.jpg" alt="" class="img-fluid">
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
  <!-- <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div> -->


  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/jquery.waypoints.min.js"></script>
  <script src="assets/js/jquery.stellar.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="https://kit.fontawesome.com/e1612437fd.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery.fancybox.min.js"></script>
  
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/jquery.animateNumber.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="assets/js/google-map.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    function loginAsUser() {
      // Redirect or perform actions for user login
      window.location.href = "user/login.php";
    }

    function loginAsOrganizer() {
      // Redirect or perform actions for organizer login
      // Example: window.location.href = "organizer/login.php";
      window.location.href = "organizer/login.php";
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