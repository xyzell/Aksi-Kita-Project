<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "aksiKita"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['campaignId'])) {
    $campaignId = $_GET['campaignId'];
    
    $conn->begin_transaction();

    try {
        $query_joincampaign = "DELETE FROM joincampaign WHERE campaignId = ?";
        $stmt_joincampaign = $conn->prepare($query_joincampaign);
        $stmt_joincampaign->bind_param("i", $campaignId);
        $stmt_joincampaign->execute();
        
        $query_campaign = "DELETE FROM campaign WHERE campaignId = ?";
        $stmt_campaign = $conn->prepare($query_campaign);
        $stmt_campaign->bind_param("i", $campaignId);
        $stmt_campaign->execute();

        $conn->commit();

        header("location: campaignlist.php?success_delete_message=Campaign deleted successfully");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        header("location: campaign.php?fail_delete_message=Failed to delete campaign. Error: " . $e->getMessage());
        exit();
    }
} else {
    header("location: campaign.php?fail_delete_message=No campaign ID provided");
    exit();
}
?>
