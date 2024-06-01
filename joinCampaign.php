<?php
session_start();
include './server/koneksi.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desc1 = $conn->real_escape_string($_POST['desc1']);
    $desc2 = $conn->real_escape_string($_POST['desc2']);
    $status = $conn->real_escape_string($_POST['status']);
    $userId = $_SESSION['userId'];  
    $campaignId = $conn->real_escape_string($_POST['campaignId']);

    $sql = "INSERT INTO joinCampaign (desc1, desc2, status, userId, campaignId) VALUES ('$desc1', '$desc2', '$status', '$userId', '$campaignId')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>