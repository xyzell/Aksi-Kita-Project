<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}


$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "aksiKita"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['campaignId'])) {
    $campaignId = $_GET['campaignId'];
    $query = "DELETE FROM campaign WHERE campaignId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $campaignId);

    if ($stmt->execute()) {
        header("location: campaign.php?success_delete_message=Campaign deleted successfully");
        exit();
    } else {
        header("location: campaign.php?fail_delete_message=Failed to delete campaign");
        exit();
    }
} else {
    header("location: campaign.php?fail_delete_message=No campaign ID provided");
    exit();
}
?>
