<?php

include('../server/koneksi.php');

session_start();
include('converter.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
    header('location: login.php');
    exit;
}

$id = $_SESSION['organizerId'];
$name = $_SESSION['organizerName'];
$email = $_SESSION['organizerEmail'];
$phone = $_SESSION['organizerPhoneNum'];
$kind = $_SESSION['organizerKind'];
$desc = $_SESSION['organizerDesc'];
$address = $_SESSION['organizerAddress'];
$website = $_SESSION['organizerWebsite'];
$logo = $_SESSION['organizerLogo'];

// change profile picture
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $profileOld = $_SESSION['organizerLogo'];
    $id = $_SESSION['organizerId'];

    $path = "../assets/images/profiles/" . basename($_FILES['input-image']['name']);
    $path2 = "../assets/images/profiles/" . $profileOld;

    $image = $_FILES['input-image']['name'];

    $queryChange = "UPDATE organizer SET organizerLogo = '$image' WHERE organizerId = '$id'";
    $result = mysqli_query($conn, $queryChange);

    move_uploaded_file($_FILES['input-image']['tmp_name'], $path);

    if (file_exists($path2)) {
        unlink($path2);
    }

    $_SESSION['organizerLogo'] = $image;
    echo $_SESSION['organizerLogo'];

    header("Refresh:0");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $name ?></title>

    <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="organizer-css/bootstrap5/bootstrap.css" />
    <link rel="stylesheet" href="organizer-css/organizerprofilcss.css" />

    <script src="organizer-js/bootstrap5/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-warning bg-opacity-50">
    <div class="d-flex justify-content-center align-items-center height-100">
        <div class="row">
            <div class="container bg-dark shadow rounded-3 rounded-3 mb-3">
                <table class="table mb-0 table-dark" style="border-bottom: hidden;">
                    <th scope="col" class="col-1">
                        <a href="homepage.php">
                            <i class="fs-1 text-white fa fa-angle-left"></i>
                        </a>
                    </th>
                    <th scope="col">
                        <h1 class="pt-1 text-center fs-3">Organizer Profile</h1>
                    </th>
                    <th scope="col" class="col-1"></th>
                </table>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-2 profil-card-size bg-white shadow rounded-3 border-0 p-3 text-center">
                        <!-- profile change -->
                        <img class="rounded-circle image-size" id="image-view" src="../assets/images/profiles/<?php echo $logo ?>" alt="">
                        <form action="" name=" profile-change" id="profile-change" method="POST" enctype="multipart/form-data">
                            <label for="input-image" class="mt-4 change-profile-button rounded-pill bg-secondary bg-opacity-75 border-0 text-white fw-medium mb-0" style="cursor: pointer; padding-top: 3px;">
                                Change Photo
                                <input type="file" accept="image/*" id="input-image" name="input-image" hidden />
                            </label>
                        </form>
                    </div>



                    <div class="col info-card-size bg-white shadow rounded-3 ms-3 ps-3 py-2">
                        <p class="fw-medium fs-5 mt-1">Organizer Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-normal fs-6"><?php echo $name ?></span></p>
                        <hr>
                        <p class="fw-medium fs-5 mt-0" style="line-height: 25px;">Organizer Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-normal fs-6"><?php echo $kind ?></span></p>
                        <hr>
                        <p class="fw-medium fs-5 mt-0" style="line-height: 25px;">Organizer Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-normal fs-6"><?php echo $email ?></span></p>
                        <hr>
                        <p class="fw-medium fs-5 mt-0" style="line-height: 25px;">Organizer Phone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="margin-left: 2px;">:</span> <span class="fw-normal fs-6"><?php echo $phone ?></span></p>
                        <hr>
                        <p class="fw-medium fs-5 mt-0" style="line-height: 25px; margin-bottom : -10px;">Organizer Website&nbsp;&nbsp;&nbsp;<span style="margin-left: 2px;">:</span> <a href="http://<?php echo $website ?>" target="_blank" class="fw-normal fs-6"><?php echo $website ?></a></p>
                    </div>
                </div>
            </div>

            <div class="col p-0 border" style="width: 100px;">
                <div class="container bg-white shadow rounded-3 ps-3 py-2 mt-3 m-0" style="max-height: 300px;">
                    <p class="fw-medium fs-4" style="margin-bottom: -5px;">Description</p>
                    <hr>
                    <div class="container overflow-y-scroll ps-0" style="max-height: 200px;">
                        <p style="white-space: pre-line;"><?php echo htmlentities($desc) ?></p>
                    </div>
                </div>
            </div>

            <div class="container mt-3 bg-white shadow rounded-3 rounded-3 mb-3 py-3">
                <div class=" row">
                    <div class="col">
                        <a href="editprofile.php">
                            <button class="button-css w-100 rounded-pill bg-info fw-bold text-white border-0 pb-1" style="margin-left: 0px !important;">
                                Edit
                            </button>
                        </a>
                    </div>
                    <div class="col">
                        <form action="logout.php" method="POST" name="logout" id="logout">
                            <button type="button" id="logout-button" name="logout-button" class="button-css w-100 rounded-pill bg-danger fw-bold text-white border-0 pb-1 delete-button" onclick="logoutClicked()">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="organizer-js/organizerprofiljs.js"></script>
</body>

</html>