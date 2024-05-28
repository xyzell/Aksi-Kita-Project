<?php
session_start();
include './server/koneksi.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desc1 = $conn->real_escape_string($_POST['desc1']);
    $desc2 = $conn->real_escape_string($_POST['desc2']);
    $userId = $_SESSION['userId'];  // Assuming userId is stored in session after login
    $campaignId = $conn->real_escape_string($_POST['campaignId']);

    $sql = "INSERT INTO joinCampaign (desc1, desc2, userId, campaignId) VALUES ('$desc1', '$desc2', '$userId', '$campaignId')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
