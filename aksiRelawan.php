<?php
session_start();
include './server/koneksi.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userLoggedIn = isset($_SESSION['userId']);
$userId = $userLoggedIn ? $_SESSION['userId'] : '';

$campaignId = isset($_GET['campaignId']) ? $_GET['campaignId'] : '';

$campaign = null;
$alreadyRegistered = false;

if (!empty($campaignId)) {
  $query = "SELECT campaign.*, organizer.organizerName, organizer.organizerEmail, organizer.organizerPhoneNum, organizer.organizerKind, organizer.organizerDesc, organizer.organizerAddress, organizer.organizerWebsite, organizer.organizerLogo 
              FROM campaign 
              INNER JOIN organizer ON campaign.organizerId = organizer.organizerId 
              WHERE campaign.campaignId = '" . $conn->real_escape_string($campaignId) . "'";

  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $campaign = $result->fetch_assoc();
  }

  if ($userLoggedIn) {
    $checkRegistrationQuery = "SELECT * FROM joinCampaign WHERE userId = '" . $conn->real_escape_string($userId) . "' AND campaignId = '" . $conn->real_escape_string($campaignId) . "'";
    $registrationResult = $conn->query($checkRegistrationQuery);
    if ($registrationResult->num_rows > 0) {
      $alreadyRegistered = true;
    }
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>AksiKita &mdash; Go for action!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />
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
      <a class="navbar-brand" href="../index.html">
        <div class="logo-header"><img src="/assets/images/logo/whiteLogo.png" alt="" width="126" height="45"></div>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
          <li class="nav-item active"><a href="cariAksi.php" class="nav-link">Cari Aksi</a></li>
          <li class="nav-item"><a href="../about.php" class="nav-link">Tentang Kami</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">FAQ</a></li>
          <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user fa-sm"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="myProfile.php">Dashboard</a></li>
                <li><a class="dropdown-item" href="../user/logout.php">Logout</a></li>
              </ul>
            </li>
          <?php else : ?>
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

  <div class="unique-event-page">
    <?php if ($campaign) : ?>
      <div class="unique-event-content">
        <div class="unique-banner">
          <img src="assets/images/campaign/<?php echo htmlspecialchars($campaign['banner']); ?>" alt="Banner">
        </div>
      </div>
      <div class="unique-description">
        <p><?php echo nl2br(htmlspecialchars($campaign['description'])); ?></p>
      </div>
      <div class="unique-event-details">
        <h1 class="unique-h1"><?php echo htmlspecialchars($campaign['title']); ?></h1>
        <div class="unique-details">
          <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($campaign['location']); ?></p>
          <p><strong>Tanggal:</strong> <?php echo date("d M Y, H:i", strtotime($campaign['campaignDate'])); ?></p>
        </div>
        <div class="unique-action-buttons">
          <button id="openModalBtn" class="open-modal-btn">Jadi Relawan</button>
          <button id="contactOrganizerBtn" type="button">Kontak Organisasi</button>
        </div>
      </div>
    <?php else : ?>
      <h2 class="unique-h2">Detail kampanye tidak ditemukan</h2>
    <?php endif; ?>
  </div>

  <!-- Modal Pendaftaran -->
  <div id="modalForm" class="unique-custom-modal">
    <div class="unique-custom-modal-content">
      <span class="unique-custom-close">&times;</span>
      <h2 class="unique-h2">Daftar Aktivitas</h2>
      <form id="volunteerForm" method="POST" action="joinCampaign.php">
        <input type="hidden" name="status" value="registrant">
        <div class="unique-custom-form-group">
          <label for="kepada" class="unique-custom-label">Kepada</label>
          <div class="unique-input-container">
            <img id="organizerLogo" src="assets/images/profiles/<?php echo htmlspecialchars($campaign['organizerLogo']); ?>" alt="<?php echo htmlspecialchars($campaign['organizerName']); ?>" class="unique-custom-logo">
            <span id="organizationName" class="organization-name"><?php echo htmlspecialchars($campaign['organizerName']); ?></span>
          </div>
        </div>
        <div class="unique-custom-form-group">
          <label for="subyek" class="unique-custom-label">Subyek</label>
          <input type="text" id="subyek" class="unique-custom-input" value="<?php echo htmlspecialchars($campaign['title']); ?>" disabled>
        </div>
        <div class="unique-custom-form-group">
          <label for="question1" class="unique-custom-label">Mengapa Anda tertarik untuk menjadi relawan pada aktivitas ini?</label>
          <textarea id="question1" name="desc1" class="unique-custom-textarea" required></textarea>
        </div>
        <div class="unique-custom-form-group">
          <label for="question2" class="unique-custom-label">Mengapa Anda adalah relawan yang tepat untuk aktivitas ini?</label>
          <textarea id="question2" name="desc2" class="unique-custom-textarea" required></textarea>
        </div>
        <input type="hidden" name="campaignId" value="<?php echo htmlspecialchars($campaignId); ?>">
        <div class="unique-custom-submit-container">
          <button type="submit" id="submitBtn" class="unique-custom-submit-btn" <?php if (!$userLoggedIn || $alreadyRegistered) echo 'disabled'; ?>>Kirim Formulir Pendaftaran</button>
        </div>
      </form>
    </div>
  </div>


  <!-- Modal Pendaftaran Sukses -->
  <div id="successModal" class="unique-custom-modal">
    <div class="unique-custom-modal-content unique-custom-modal-content-success">
      <span class="unique-custom-close">&times;</span>
      <h2 class="unique-h2">Pendaftaran Sukses</h2>
      <p>Formulir pendaftaran Anda telah berhasil dikirim.</p>
      <button id="unique-closeSuccessModalBtn" class="unique-custom-submit-btn">Tutup</button>
    </div>
  </div>

  <!-- Modal Kontak Organisasi -->
  <div id="contactModal" class="unique-custom-modal">
    <div class="unique-custom-modal-content unique-custom-modal-fit-content">
      <div class="unique-custom-modal-header">
        <span class="unique-custom-close">&times;</span>
        <h2 class="unique-h2">Kontak Organisasi</h2>
      </div>
      <div class="unique-custom-modal-body">
        <div class="unique-contact-content">
          <img id="organizerLogo" src="assets/images/profiles/<?php echo htmlspecialchars($campaign['organizerLogo']); ?>" alt="Logo Penyelenggara" class="unique-custom-logo">
          <div class="unique-contact-field">
            <strong>Nama Organisasi:</strong>
            <div class="unique-contact-value"><?php echo htmlspecialchars($campaign['organizerName']); ?></div>
          </div>
          <div class="unique-contact-field">
            <strong>Email Organisasi:</strong>
            <div class="unique-contact-value"><?php echo htmlspecialchars($campaign['organizerEmail']); ?></div>
          </div>
          <div class="unique-contact-field">
            <strong>Telepon Organisasi:</strong>
            <div class="unique-contact-value"><?php echo htmlspecialchars($campaign['organizerPhoneNum']); ?></div>
          </div>
          <div class="unique-contact-field">
            <strong>Website Organisasi:</strong>
            <div class="unique-contact-value"><a href="#" id="organizerWebsiteLink" style="color: #10439F !important;"><?php echo htmlspecialchars($campaign['organizerWebsite']); ?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal user sudah mendaftar -->
  <div id="alreadyRegisteredModal" class="unique-custom-modal unique-custom-modal-centered">
    <div class="unique-custom-modal-content unique-custom-modal-centered-content">
      
      <span class="unique-custom-close">&times;</span>
      <h2 class="unique-h2">Informasi</h2>
      <p>Anda sudah terdaftar dalam kampanye ini.</p>
      <button id="closeAlreadyRegisteredModalBtn" class="unique-custom-submit-btn">Tutup</button>
    </div>
  </div>

  <script src="script.js"></script>

  <footer class="footer">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-6 col-lg-4">
          <h3 class="heading-section">About Us</h3>
          <p style="text-align: justify; font-size: 15px" class="lead">AksiKita didirikan untuk mengoordinasikan aksi relawan dalam menanggapi
            masalah sosial, lingkungan, dan kemanusiaan. Kami berkembang pesat dengan membuka cabang,
            melatih relawan, dan mendapatkan pengakuan dari pemerintah dan media. </p>
          <p style="text-align: justify; font-size: 15px" class="mb-5">Sekarang, fokus kami adalah pada proyek jangka panjang untuk pembangunan masyarakat,
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
      </div>
    </div>
  </footer>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


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
    $(document).ready(function() {
      $("#loginButton").click(function() {
        $("#loginModal").modal();
      });
    });
  </script>

  <script>
    var userLoggedIn = <?php echo json_encode($userLoggedIn); ?>;
    var alreadyRegistered = <?php echo json_encode($alreadyRegistered); ?>;
  </script>

</body>

</html>