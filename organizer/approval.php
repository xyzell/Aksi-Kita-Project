<?php
include('../server/koneksi.php');

$campaign = $_GET['campaign'];
$id = $_GET['id'];
$approve = $_GET['approve'];

if ($approve == 1) {
    $query = "UPDATE joincampaign SET status = 'volunteer' WHERE joinId = $id";
} else if ($approve == 0) {
    $query = "DELETE from joincampaign WHERE joinId = $id";
}

$result = mysqli_query($conn, $query);

header("location: manageregistrant.php?campaign=" . $campaign);
