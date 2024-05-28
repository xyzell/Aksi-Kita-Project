<?php
include('../server/koneksi.php');

$id = $_POST['campaign-id'];
$banner = $_POST['campaign-banner'];

$queryDelete = "DELETE FROM campaign WHERE campaignId = '$id'";
$result = mysqli_query($conn, $queryDelete);

$path = "../assets/images/campaign/" . $banner;

if (file_exists($path)) {
    unlink($path);
}

header("location: homepage.php");
