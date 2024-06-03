<?php

include('../server/koneksi.php');

session_start();
include('converter.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
    header('location: login.php');
    exit;
}

$campaign = $_REQUEST['campaign'];

$dataPerPage = 10;
$totalData = mysqli_query($conn, "select * from users JOIN joinCampaign ON users.userId = joincampaign.userId WHERE campaignId = $campaign AND status = 'volunteer'");
$totalData = mysqli_num_rows($totalData);
$totalPage = ceil($totalData / $dataPerPage);

$querySelectData = "SELECT 
joinId,
userName,
userEmail,
userGender,
userAddress,
desc1,
desc2
FROM users JOIN joinCampaign ON users.userId = joincampaign.userId
WHERE campaignId = $campaign AND status = 'volunteer' LIMIT 0, $dataPerPage";

$result = mysqli_query($conn, $querySelectData);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Manage Volunteer</title>
    <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="organizer-css/bootstrap5/bootstrap.css" />
    <link rel="stylesheet" href="organizer-css/managevolunteercss.css" />
</head>

<body class="bg-warning bg-opacity-50">
    <div class="container shadow rounded-3 pt-1 pb-0 px-4 mt-5 bg-dark">
        <table class="table table-dark" style="border-bottom: hidden;">
            <th scope="col" class="col-1">
                <a href="campaignview.php?campaign=<?php echo $campaign ?>">
                    <i class="fs-1 text-white opacity-100 fa fa-angle-left"></i>
                </a>
            </th>
            <th scope="col">
                <h1 class="pt-1 text-center fs-3">Manage Registrant</h1>
            </th>
            <th scope="col" class="col-1"></th>
        </table>
    </div>

    <div class="container shadow rounded-3 pt-3 pb-3 px-4 mt-2 bg-white">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <input class="ps-2 rounded-2 search-color" type="text" placeholder="Search..." style="height: 30px; outline: none;">
                <button class="pt-0 pb-1 ms-2 rounded-2 bg-warning bg-opacity-75 border-0" style="height: 30px; width: 30px;"><i class="text-white fa fa-arrow-right"></i></button>
            </div>
            <div class=" d-flex">
                <p class="pb-0" style="padding-top: 2px;"><strong>Filter : </strong></p>
                <input type="button" value="Activity Uploaded" class="activity-filter ms-2 px-2 pt-0 rounded-pill border-2 fw-medium" style="height: 30px;">
                <input type="button" value="With Cerificate" class="certificate-filter ms-2 px-2 pt-0 rounded-pill border-2 fw-medium" style="height: 30px;">
            </div>
        </div>

        <div class="border rounded-2 p-0 mt-1">
            <table class="table" style="border-radius: 6px !important;">
                <thead>
                    <tr scope="row">
                        <th scope="col" class="col-1 text-center bg-warning bg-opacity-10">No.</th>
                        <th scope="col" class="col-4 bg-warning bg-opacity-10">Name</th>
                        <th scope="col" class="col-4 bg-warning bg-opacity-10">Email</th>
                        <th scope="col" class="col-3 text-center bg-warning bg-opacity-10"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $num++;
                    ?>
                        <tr scope="row">
                            <th scope="col" class="col-1 fw-normal text-center"><?= $num ?></th>
                            <th scope="col" class="col-4 fw-normal"><?= $row['userName'] ?></th>
                            <th scope="col" class="col-3 fw-normal"><?= $row['userEmail'] ?></th>
                            <th scope="col" class="col-1 text-end fw-normal">
                                <button class="rounded-2 bg-info text-white border-0 pb-1 px-3">Activity</button>
                                <button class="rounded-2 bg-info text-white border-0 pb-1 px-3">Certificate</button>
                                <button style="height: 29px; width: 29px; padding-bottom: 2px;" class="border-0 bg-primary bg-opacity-75 px-2 rounded-2 text-white fa fa-ellipsis-h"></button>
                            </th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <i class="fa fa-chevron-left" style="padding-top: 6px; cursor: pointer;"></i>
                <p class="fw-bold mx-4 text-secondary" style="cursor: default;">1</p>
                <i class="fa fa-chevron-right" style="padding-top: 6px; cursor: pointer;"></i>
            </div>
        </div>
    </div>
    </div>

</body>

</html>