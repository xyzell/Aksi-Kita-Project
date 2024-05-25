<?php

include('../server/koneksi.php');

session_start();
include('converter.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
  header('location: login.php');
  exit;
}

$organizerId = $_SESSION['organizerId'];

$queryListCampaign = "SELECT campaignId, title, banner, description, campaignDate, location, organizerName FROM campaign INNER JOIN organizer ON campaign.organizerId = organizer.organizerId WHERE campaign.organizerId = $organizerId LIMIT 8";
$ListCampaignResult = mysqli_query($conn, $queryListCampaign);

$queryTotalCampaign = "SELECT count(*) as count FROM campaign WHERE organizerId = $organizerId";
$result = mysqli_query($conn, $queryTotalCampaign);

$row = mysqli_fetch_assoc($result);
$campaignCount = $row['count'];
$_SESSION['maxCampaign'] = $campaignCount;
?>

<!-- get user and campaign total -->
<?php

$queryUserTotal = "SELECT count(*) as userTotal from users";
$resultUserTotal = mysqli_query($conn, $queryUserTotal);

$rowUser = mysqli_fetch_assoc($resultUserTotal);
$userTotal = $rowUser['userTotal'];

$queryCampaignTotal = "SELECT count(*) as campaignTotal from campaign";
$resultCampaignTotal = mysqli_query($conn, $queryCampaignTotal);

$rowCampaign = mysqli_fetch_assoc($resultCampaignTotal);
$campaignTotal = $rowCampaign['campaignTotal'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>AksiKita Organizer</title>
  <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />
  <link rel="stylesheet" href="organizer-css/homepagecss.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <!-- Header & Banner-->
  <header class="header">
    <img class="logo-img" src="assets/logo.png" alt="" />
    <h1 class="title">Organizer Dashboard</h1>
    <img class="profile" src="../assets/images/gen.jpeg" alt="" />
  </header>
  <div class="banner">
    <p class="subtitle">Total Active Campaigns and Active Users</p>
    <div class="information">
      <p class="campaigns-count"><span id="counter" data-count="<?php echo $campaignTotal ?>">0</span>&nbsp;Campaigns</p>
      <p>|</p>
      <p class="volunteers-count"><span id="counter" data-count="<?php echo $userTotal ?>">0</span>&nbsp;Users</p>
    </div>
  </div>

  <!-- Campaigns List -->
  <section>
    <h1 class="title">My Campaigns</h1>
    <div class="list-container">
      <div class="campaigns-list">
        <?php while ($row = mysqli_fetch_assoc($ListCampaignResult)) { ?>
          <a href="campaignview.php?campaign=<?php echo $row['campaignId'] ?>">
            <div class="campaigns-card">
              <img class="campaigns-image" src="../assets/images/campaign/<?php echo $row['banner'] ?>" alt="">
              <div class="campaigns-info">
                <div class="campaigns-details">
                  <p class="campaigns-organizer"><?php echo htmlentities($row['organizerName']) ?></p>
                  <div class="container-title">
                    <h1 class="campaigns-title"><?php echo htmlentities($row['title']) ?></h1>
                  </div>
                </div>
                <div class="loc-date">
                  <img class="campaigns-location-icon" src="assets/pin.png" alt="">
                  <p class="campaigns-location"><?php echo htmlentities($row['location']) ?></p>
                </div>
                <div class="loc-date">
                  <img class="campaigns-date-icon" src="assets/calendar.png" alt="">
                  <p class="campaigns-date">
                    <?PHP
                    $day = date("d", strtotime($row['campaignDate']));
                    $month = date("n", strtotime($row['campaignDate']));
                    $year = date("Y", strtotime($row['campaignDate']));

                    $month = convertMonth(1, $month);

                    echo $day . " " . $month . " " . $year;
                    ?>
                  </p>
                </div>
              </div>
            </div>
          </a>
        <?php } ?>
      </div>
    </div>

    <hr class="line-bottom">
    </hr>
  </section>

  <!-- Create Campaign Button -->
  <div>
    <?php

    if ($campaignCount < 8) {
      underEight();
    } else {
      eightOrAbove();
    }

    function underEight()
    { ?>
      <p class="add-title">Want to create a new campaign?</p>
      <div class="add-button-position">
        <a href="createcampaign.php" class="add-button-href">
          <button class="add-button-button">+ Create New</button>
        </a>
      </div>
    <?php }
    function eightOrAbove()
    { ?>
      <p class="add-title">Want to create a new campaign?</p>
      <div class="add-button-position">
        <button class="add-button-button" onclick="eightCampaigns()">+ Create New</button>
      </div>
    <?php } ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="organizer-js/homepagejs.js"></script>
</body>

</html>