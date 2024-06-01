<?php

include('../server/koneksi.php');

session_start();
include('converter.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
    header('location: login.php');
    exit;
}

$campaign = $_REQUEST['campaign'];

$querySelectData = "SELECT 
joinId,
userName,
userEmail,
userGender,
userAddress,
desc1,
desc2
FROM users JOIN joinCampaign ON users.userId = joincampaign.userId
WHERE campaignId = $campaign AND status = 'registrant'";

$result = mysqli_query($conn, $querySelectData);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Manage Registrant</title>
    <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="organizer-css/bootstrap5/bootstrap.css" />
    <link rel="stylesheet" href="organizer-css/manageregistrantcss.css" />

    <script src="organizer-js/bootstrap5/bootstrap.bundle.js"></script>
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

    <div class="container shadow rounded-3 py-2 px-2 mt-2 bg-white">
        <div class="border rounded-2 p-0">
            <table class="table" style="border-radius: 6px !important;">
                <thead>
                    <tr scope="row">
                        <th scope="col" class="col text-center bg-warning bg-opacity-10">No.</th>
                        <th scope="col" class="col-4 bg-warning bg-opacity-10">Name</th>
                        <th scope="col" class="col-4 bg-warning bg-opacity-10">Email</th>
                        <th scope="col" class="col-1 text-center bg-warning bg-opacity-10">details</th>
                        <th scope="col" colspan="2" class="col-1 text-center bg-warning bg-opacity-10">Approval</th>
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
                            <th scope="col" class="col-1 text-center fw-normal"><button data-modal-id="profile-modal-<?php echo $row['joinId']; ?>" class="open-modal border-0 bg-primary bg-opacity-75 px-2 py-1 rounded-2 text-white fa fa-ellipsis-h" style="cursor: pointer;"></button></th>
                            <th scope="col" class="col-1 text-center fw-normal"><a href="approval.php?approve=0&id=<?= $row['joinId'] ?>&campaign=<?= $campaign ?>" style="cursor: pointer;"><i class="bg-danger bg-opacity-75 px-2 py-1 rounded-2 text-white fa fa-close"></i></a></th>
                            <th scope="col" class="col-1 text-center fw-normal"><a href="approval.php?approve=1&id=<?= $row['joinId'] ?>&campaign=<?= $campaign ?>" style="cursor: pointer;"><i class="bg-success bg-opacity-75 px-2 py-1 rounded-2 text-white fa fa-check"></i></a></th>
                        </tr>
                        <div id="profile-modal-<?php echo $row['joinId']; ?>" class="profile-modal">
                            <div class="modal-view">
                                <div class="left-container px-3 py-2 rounded-3">
                                    <p class="text-center fs-2 fw-medium">Profile Information</p>
                                    <p><strong>Name<span style="margin-left: 21px;">:</span></strong>&nbsp;<?php echo $row['userName'] ?></p>
                                    <hr>
                                    <p><strong>Email<span style="margin-left: 25px;">:</span></strong>&nbsp;<?php echo $row['userEmail'] ?></p>
                                    <hr>
                                    <p><strong>Gender<span style="margin-left: 11px;">:</span></strong>&nbsp;<?php echo $row['userGender'] ?></p>
                                    <hr>
                                    <p><strong>Andress<span style="margin-left: 6px;">:</span></strong><span>&nbsp;<?php echo $row['userAddress'] ?></span></p>
                                </div>
                                <div class="right-container px-3 py-2 rounded-3">
                                    <p class="mb-1"><strong>Mengapa anda tertarik untuk menjadi relawan pada aktivitas ini?</strong></p>
                                    <div class="overflow-y-scroll mb-0" style="max-height: 100px; height: 100px">
                                        <p><?php echo $row['desc1'] ?></p>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <p class="mb-1"><strong>Mengapa anda adalah relawan yang tepat untuk aktivitas ini?</strong></p>
                                    <div class="overflow-y-scroll" style="max-height: 100px; height: 100px">
                                        <p><?php echo $row['desc2'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="organizer-js/manageregistrantjs.js"></script>
</body>

</html>