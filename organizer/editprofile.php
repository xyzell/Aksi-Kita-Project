<?php

include('../server/koneksi.php');

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
    header('location: login.php');
    exit;
}

$id = $_SESSION['organizerId'];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $web = $_POST['web'];
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];

    // Check Name Changed or Not
    if (!isset($name) or trim($name) == '') {
        $name = $_SESSION['organizerName'];
    }

    // Check Web Changed or Not
    if (!isset($web) or trim($web) == '') {
        $web = $_SESSION['organizerWebsite'];
    }

    // Check Phone Changed or Not
    if (!isset($phone) or trim($phone) == '') {
        $phone = $_SESSION['organizerPhoneNum'];
    }

    // Check Desc Changed or Not
    if (!isset($desc) or trim($desc) == '') {
        $desc = $_SESSION['organizerDesc'];
    }

    $queryUpdate = "UPDATE organizer SET 
    organizerName = ?,
    organizerWebsite = ?,
    organizerPhoneNum = ?,
    organizerDesc = ?
    WHERE organizerId = ?";

    if ($stmt_update = $conn->prepare($queryUpdate)) {
        $stmt_update->bind_param("ssssi", $name, $web, $phone, $desc, $id);
        $stmt_update->execute();
        $stmt_update->close();

        $_SESSION['organizerName'] = $name;
        $_SESSION['organizerWebsite'] = $web;
        $_SESSION['organizerPhoneNum'] = $phone;
        $_SESSION['organizerDesc'] = $desc;

        header("location: organizerprofile.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Edit Campaign</title>
    <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="organizer-css/bootstrap5/bootstrap.css" />
    <link rel="stylesheet" href="organizer-css/editprofilecss.css" />
</head>

<body class="pb-5 mb-2 bg-info bg-opacity-25">
    <div class="container bg-white shadow rounded-3 pt-2 pb-4 px-4 mt-5">
        <!-- Title and Back Button -->
        <table class="table border-bottom border-2 border-warning border-opacity-75">
            <th scope="col" class="col-1">
                <a href="organizerprofile.php">
                    <i class="fs-1 link-secondary opacity-75 fa fa-angle-left"></i>
                </a>
            </th>
            <th scope="col">
                <h1 class="pt-1 text-center fs-3">Edit Campaign</h1>
            </th>
            <th scope="col" class="col-1"></th>
        </table>

        <!-- Form -->
        <div>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Organizer Name -->
                <div class="" style="margin-top: -5px;">
                    <p class="mb-1 mt-3 fw-medium text-secondary ">Organizer Name</p>
                    <input oninput="nameChange()" placeholder="<?php echo htmlentities($_SESSION['organizerName']) ?>" value="<?php echo $_SESSION['organizerName'] ?>" type="text" name="name" id="name" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal" maxlength="255" autocomplete="off" />
                </div>

                <div class="" style="margin-top: -5px">
                    <div class="row">
                        <div class="col">
                            <p class="mb-1 mt-3 fw-medium text-secondary">
                                Organizer Website
                            </p>
                            <input oninput="webChange()" placeholder="<?php echo htmlentities($_SESSION['organizerWebsite']) ?>" value="<?php echo $_SESSION['organizerWebsite'] ?>" type="text" name="web" id="web" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal" maxlength="255" autocomplete="off" />
                        </div>

                        <div class="col">
                            <p class="mb-1 mt-3 fw-medium text-secondary">
                                Organizer Phone
                            </p>
                            <input oninput="phoneChange()" placeholder="<?php echo htmlentities($_SESSION['organizerPhoneNum']) ?>" value="<?php echo $_SESSION['organizerPhoneNum'] ?>" type="number" name="phone" id="phone" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal" maxlength="30" autocomplete="off" />
                        </div>
                    </div>
                </div>
        </div>

        <!-- Desc -->
        <div class="mt-3">
            <p class="mb-1 mt-1 fw-medium text-secondary">Organizer Description</p>
            <textarea oninput="descChange()" placeholder="<?php echo htmlentities($_SESSION['organizerDesc']) ?>" type="text" name="desc" id="desc" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active h-desc fw-normal" maxlength="10000" autocomplete="off"><?php echo $_SESSION['organizerDesc'] ?></textarea>
        </div>

        <!-- Button -->
        <div class="d-flex justify-content-center">
            <input type="submit" value="Submit" name="submit" id="submit" class="w-100 rounded-pill border-0 bg-warning bg-opacity-75 h-button mt-2 fw-bolder fs-6 text-white" style="height: 28px;" />
        </div>
    </div>
    </form>
    </div>
    </div>

    <script src="organizer-js/editprofilejs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>