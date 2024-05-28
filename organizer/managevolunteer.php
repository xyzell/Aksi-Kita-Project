<?php

include('../server/koneksi.php');

session_start();
include('converter.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['userStatus'] != 'organizer') {
    header('location: login.php');
    exit;
}

$campaign = $_REQUEST['campaign'];

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
                <h1 class="pt-1 text-center fs-3">Manage Volunteer</h1>
            </th>
            <th scope="col" class="col-1"></th>
        </table>
    </div>

    <div class="container shadow rounded-3 pt-1 pb-0 px-4 mt-2 bg-white">
        <table class="table">
            <tr scope="row" class="col-1">
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </table>
    </div>

    <div class="container shadow rounded-3 pt-1 pb-0 px-4 mt-2 bg-white">
        <table class="table">
            <tr scope="row" class="col-1">
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </table>
    </div>
</body>

</html>