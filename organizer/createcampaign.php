<?php

include('../server/koneksi.php');

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
  header('location: login.php');
  exit;
}

$organizer = $_SESSION['organizerId'];
$image = null;

if (isset($_POST['submit'])) {
  $path = "../assets/images/" . basename($_FILES['image-data']['name']);
  $image = $_FILES['image-data']['name'];

  $title = $_POST['title'];
  $desc = $_POST['desc'];
  $date = $_POST['date'];
  $location = $_POST['loc'];

  $queryInsert = "INSERT INTO campaign VALUES ('', ?, ?, ?, ?, ?, ?)";

  if ($stmt_insert = $conn->prepare($queryInsert)) {
    $stmt_insert->bind_param("sssssi", $title, $image, $desc, $date, $location, $organizer);
    $stmt_insert->execute();
    $stmt_insert->close();
  }

  move_uploaded_file($_FILES['image-data']['tmp_name'], $path);

  header("location: homepage.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>Create a Campaign</title>
  <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="organizer-css/bootstrap5/bootstrap.css" />
  <link rel="stylesheet" href="organizer-css/createcampaigncss.css" />
</head>

<body class="pb-5 mb-2">
  <div class="container shadow rounded-3 pt-2 pb-4 px-4 mt-5">
    <!-- Title and Back Button -->
    <table class="table border-bottom border-2 border-warning border-opacity-75">
      <th scope="col" class="col-1">
        <a href="homepage.php">
          <i class="fs-1 link-secondary opacity-75 fa fa-angle-left"></i>
        </a>
      </th>
      <th scope="col">
        <h1 class="pt-1 text-center fs-3">Create Your Own Campaign!</h1>
      </th>
      <th scope="col" class="col-1"></th>
    </table>

    <!-- Form -->
    <div>
      <form action="" method="post" enctype="multipart/form-data">
        <!-- Image Banner -->
        <p class=" mb-2 fw-medium text-secondary">Campaign Banner</p>
        <label for="input-image" id="drop-area" class="w-100">
          <input type="file" accept="image/*" id="input-image" name="image-data" hidden required oninvalid="noImage()" />
          <div id="image-view" id="drop-area" class="image-box input-cursor container rounded-3 d-flex justify-content-center align-items-center">
            <p class="text-center text-secondary">
              <i class="fs-1 text-color-secondary fa fa-image"></i><br />
              Drop Your Image or Click Here to Upload Your Image
            </p>
          </div>
        </label>

        <!-- Checker Input -->
        <input type="file" accept="image/*" id="check" hidden />

        <!-- Title -->
        <p class="mb-1 mt-3 fw-medium text-secondary">Campaign Title</p>
        <input onclick="clickTitle()" oninvalid="noTitle()" required type="text" name="title" id="title" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal" maxlength="120" oninput="countTextTitle()" autocomplete="off" />
        <div class="d-flex justify-content-end fw-medium text-secondary fs-6 margin-bottom-20" id="title-max">
          <p class="text-end" id="title-char">0</p>
          <p>/120</p>
        </div>

        <!-- Desc -->
        <p class="mb-1 mt-1 fw-medium text-secondary">Campaign Description</p>
        <textarea onclick="clickDesc()" oninvalid="noDesc()" required type="text" name="desc" id="desc" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active h-desc fw-normal" maxlength="3000" oninput="countTextDesc()" autocomplete="off"></textarea>
        <div class="d-flex justify-content-end fw-medium text-secondary fs-6 margin-bottom-30" id="desc-max">
          <p class="text-end" id="desc-char">0</p>
          <p>/3000</p>
        </div>

        <!-- Organizer Name
          <p class="mb-1 mt-3 fw-medium text-secondary">Organizer Name</p>
          <input
            type="text"
            name="organizer"
            id="organizer"
            class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal"
            maxlength="50"
            oninput="countTextOrganizer()"
            autocomplete="off"
          />
          <div
            class="d-flex justify-content-end fw-medium text-secondary fs-6 margin-bottom-20"
            id="organizer-max"
          >
            <p class="text-end" id="organizer-char">0</p>
            <p>/50</p>
          </div> -->

        <!-- Date & Location -->
        <div class="row" style="margin-top: -30px">
          <div class="col">
            <p class="mb-1 mt-3 fw-medium text-secondary">Campaigns Date</p>
            <input onclick="clickDate()" oninvalid="noDate()" required type="date" name="date" id="date" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb" oninput="countTextOrganizer()" autocomplete="off" />
          </div>

          <div class="col">
            <p class="mb-1 mt-3 fw-medium text-secondary">
              Campaign Location
            </p>
            <input onclick="clickLocation()" oninvalid="noLocation()" required type="text" name="loc" id="loc" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb" maxlength="40" oninput="countTextLoc()" autocomplete="off" />
            <div class="d-flex justify-content-end fw-medium text-secondary fs-6" id="loc-max">
              <p class="text-end" id="loc-char">0</p>
              <p>/40</p>
            </div>
          </div>
        </div>

        <!-- Button -->
        <div class="d-flex justify-content-center">
          <input type="submit" value="Submit" name="submit" id="submit" class="w-100 rounded-pill border-0 bg-warning bg-opacity-75 h-button mt-2 fw-bolder fs-6 text-white" />
        </div>
      </form>
    </div>
  </div>

  <script src="organizer-js/createcampaignjs.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>