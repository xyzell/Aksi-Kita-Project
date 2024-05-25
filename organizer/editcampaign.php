<?php

include('../server/koneksi.php');

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
    header('location: login.php');
    exit;
}

$campaign = $_REQUEST['campaign'];

$queryBeforeEdit = "SELECT * FROM campaign WHERE campaignId = $campaign LIMIT 1";
$beforeEdit = mysqli_query($conn, $queryBeforeEdit);
$row = mysqli_fetch_assoc($beforeEdit);

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $date = $_POST['date'];
    $location = $_POST['loc'];

    // Check Image Changed or Not
    if ($_FILES['image-data']['name'] == "") {
        $image = $row['banner'];
        $validation = false;
    } else {
        $path = "../assets/images/campaign/" . basename($_FILES['image-data']['name']);
        $path2 = "../assets/images/campaign/" . $row['banner'];
        $image = $_FILES['image-data']['name'];
        $validation = true;
    }

    // Check Title Changed or Not
    if (!isset($title) or trim($title) == '') {
        $title = $row['title'];
    }

    // Check Desc Changed or Not
    if (!isset($desc) or trim($desc) == '') {
        $desc = $row['description'];
    }

    // Check Date Changed or Not
    if (!isset($date) or trim($date) == '') {
        $date = $row['campaignDate'];
    }

    // Check Location Changed or Not
    if (!isset($location) or trim($location) == '') {
        $location = $row['location'];
    }

    $queryUpdate = "UPDATE campaign SET 
    title = ?,
    banner = ?,
    description = ?,
    campaignDate = ?,
    location = ?
    WHERE campaignId = ?";

    if ($stmt_update = $conn->prepare($queryUpdate)) {
        $stmt_update->bind_param("sssssi", $title, $image, $desc, $date, $location, $campaign);
        $stmt_update->execute();
        $stmt_update->close();

        if ($validation) {
            move_uploaded_file($_FILES['image-data']['tmp_name'], $path);

            if (file_exists($path2)) {
                unlink($path2);
            }
        }
    }

    header("location: campaignview.php?campaign=" . $campaign);
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
    <link rel="stylesheet" href="organizer-css/editcampaigncss.css" />
</head>

<body class="pb-5 mb-2">
    <div class="container shadow rounded-3 pt-2 pb-4 px-4 mt-5">
        <!-- Title and Back Button -->
        <table class="table border-bottom border-2 border-warning border-opacity-75">
            <th scope="col" class="col-1">
                <a href="campaignview.php?campaign=<?php echo $campaign ?>">
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
                <!-- Image Banner -->
                <p class="mb-2 fw-medium text-secondary">Campaign Banner</p>
                <label for="input-image" id="drop-area" class="w-100" value="1">
                    <input type="file" accept="image/*" id="input-image" name="image-data" hidden oninvalid="noImage()" />
                    <div id="image-view" id="drop-area" class="image-box input-cursor container rounded-3 d-flex justify-content-center align-items-center">
                        <p class="text-center text-secondary">
                            <i class="fs-1 text-color-secondary fa fa-image"></i><br />
                            Drop Your Image or Click Here to Upload Your Image
                        </p>
                        <script>
                            document.getElementById('image-view').style.backgroundImage = `url(../assets/images/campaign/<?php echo $row['banner'] ?>)`;

                            document.getElementById('image-view').textContent = "";
                            document.getElementById('image-view').style.outlineColor = "";
                            document.getElementById('image-view').style.backgroundColor = "";

                            const imageCheck = "<?php echo $row['banner']; ?>";
                        </script>
                    </div>
                </label>

                <table class="table" style="border-bottom: hidden;">
                    <th scope="col" class="col-3 table-info-height">
                    </th>
                    <th scope="col">
                        <p class="fw-medium text-center text-secondary text-opacity-75 banner-info">Drop Your Image or Click The Banner to Edit The Image</p>
                    </th>
                    <th scope="col" class="col-3">
                        <div class="display-undo-button" id="undo-button">
                            <div class="d-flex justify-content-end">
                                <button type='button' onclick="undoImageChange()" name="check" class="rounded-pill border-0 bg-info bg-opacity-75 text-white fw-bold button-undo-size position-undo-button pb-1">Undo Change</button>
                            </div>
                        </div>
                    </th>
                </table>

                <!-- <div class="w-100 text-center ">
                    <p>Drop Your Image or Click The Banner to Edit The Image</p>
                </div>
                <div class="display-undo-button" id="undo-button">
                    <div class="d-flex justify-content-end mt-1">
                        <button type='button' onclick="undoImageChange()" name="check" class="rounded-pill border-0 bg-info bg-opacity-75 text-white fw-bold button-undo-size pb-1">Undo Change</button>
                    </div>
                </div> -->

                <!-- Checker Input -->
                <input type="file" accept="image/*" id="check" hidden />

                <!-- Title -->
                <div class="margin-top-minus-div">
                    <p class="mb-1 mt-3 fw-medium text-secondary ">Campaign Title</p>
                    <input placeholder="<?php echo htmlentities($row['title']) ?>" value="<?php echo $row['title'] ?>" type="text" name="title" id="title" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal" maxlength="120" oninput="countTextTitle()" autocomplete="off" />
                    <div class="d-flex justify-content-end fw-medium text-secondary fs-6 margin-bottom-20" id="title-max">
                        <p class="text-end" id="title-char">
                        </p>
                        <p>/120</p>
                    </div>

                    <!-- Desc -->
                    <p class="mb-1 mt-1 fw-medium text-secondary">Campaign Description</p>
                    <textarea placeholder="<?php echo htmlentities($row['description']) ?>" type="text" name="desc" id="desc" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active h-desc fw-normal" maxlength="3000" oninput="countTextDesc()" autocomplete="off"><?php echo $row['description'] ?></textarea>
                    <div class="d-flex justify-content-end fw-medium text-secondary fs-6 margin-bottom-30" id="desc-max">
                        <p class="text-end" id="desc-char">
                        </p>
                        <p>/3000</p>
                    </div>

                    <!-- Date & Location -->
                    <div class="row" style="margin-top: -30px">
                        <div class="col">
                            <p class="mb-1 mt-3 fw-medium text-secondary">Campaigns Date</p>
                            <input value="<?php echo $row['campaignDate'] ?>" type="date" name="date" id="date" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb" oninput="countTextOrganizer()" autocomplete="off" />
                        </div>

                        <div class="col">
                            <p class="mb-1 mt-3 fw-medium text-secondary">
                                Campaign Location
                            </p>
                            <input placeholder="<?php echo htmlentities($row['location']) ?>" value="<?php echo $row['location'] ?>" type="text" name="loc" id="loc" class="w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 title-active fw-normal padding-tb" maxlength="40" oninput="countTextLoc()" autocomplete="off" />
                            <div class="d-flex justify-content-end fw-medium text-secondary fs-6" id="loc-max">
                                <p class="text-end" id="loc-char">
                                </p>
                                <p>/40</p>
                            </div>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="d-flex justify-content-center">
                        <input type="submit" value="Submit" name="submit" id="submit" class="w-100 rounded-pill border-0 bg-warning bg-opacity-75 h-button mt-2 fw-bolder fs-6 text-white" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="organizer-js/editcampaignjs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>