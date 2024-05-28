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
</head>

<body class="bg-danger bg-opacity-10">
    <div class="container shadow rounded-3 pt-1 pb-0 px-4 mt-5 bg-white">
        <table class="table" style="border-bottom: hidden;">
            <th scope="col" class="col-1">
                <a href="campaignview.php?campaign=<?php echo $campaign ?>">
                    <i class="fs-1 link-secondary opacity-75 fa fa-angle-left"></i>
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
                        <th scope="col" class="col-4 bg-warning bg-opacity-10">Username</th>
                        <th scope="col" class="col-4 bg-warning bg-opacity-10">Email</th>
                        <th scope="col" class="col-1 text-center bg-warning bg-opacity-10">details</th>
                        <th scope="col" colspan="2" class="col-1 text-center bg-warning bg-opacity-10">Approval</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr scope="row">
                            <th scope="col" class="col-1 fw-normal text-center"><?= $row['joinId'] ?></th>
                            <th scope="col" class="col-4 fw-normal"><?= $row['userName'] ?></th>
                            <th scope="col" class="col-3 fw-normal"><?= $row['userEmail'] ?></th>
                            <th scope="col" class="col-1 text-center fw-normal"><i class="bg-primary bg-opacity-75 px-2 py-1 rounded-2 text-white fa fa-ellipsis-h"></i></th>
                            <th scope="col" class="col-1 text-center fw-normal"><a href="approval.php?approve=0&id=<?= $row['joinId'] ?>&campaign=<?= $campaign ?>" style="cursor: pointer;"><i class="bg-danger bg-opacity-75 px-2 py-1 rounded-2 text-white fa fa-close"></i></a></th>
                            <th scope="col" class="col-1 text-center fw-normal"><a href="approval.php?approve=1&id=<?= $row['joinId'] ?>&campaign=<?= $campaign ?>" style="cursor: pointer;"><i class="bg-success bg-opacity-75 px-2 py-1 rounded-2 text-white fa fa-check"></i></a></th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>