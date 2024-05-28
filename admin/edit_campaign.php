<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['campaignId'])) {
    $campaignId = $_GET['campaignId'];
    $query_edit_campaign = "SELECT * FROM campaign WHERE campaignId = ?";
    $stmt_edit_campaign = $conn->prepare($query_edit_campaign);
    $stmt_edit_campaign->bind_param('i', $campaignId);
    $stmt_edit_campaign->execute();
    $campaign = $stmt_edit_campaign->get_result()->fetch_assoc();
} elseif (isset($_POST['edit_btn'])) {
    $campaignId = $_POST['campaignId'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $campaignDate = $_POST['campaignDate'];
    $location = $_POST['location'];

    $query_update_campaign = "UPDATE campaign SET title = ?, description = ?, campaignDate = ?, location = ? WHERE campaignId = ?";
    $stmt_update_campaign = $conn->prepare($query_update_campaign);
    $stmt_update_campaign->bind_param('ssssi', $title, $description, $campaignDate, $location, $campaignId);

    if ($stmt_update_campaign->execute()) {
        header('location: campaign.php?success_status=Campaign has been updated successfully');
    } else {
        header('location: campaign.php?fail_status=Could not update campaign!');
    }
    exit;
} else {
    header('location: campaign.php');
    exit;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Campaign</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="campaign.php">Campaign</a></li>
            <li class="breadcrumb-item active">Edit Campaign</li>
        </ol>
    </nav>

    <!-- Edit Campaign Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Campaign</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="edit-form" method="POST" action="edit_campaign.php">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Campaign ID</label>
                                    <input type="hidden" name="campaignId" value="<?php echo htmlspecialchars($campaign['campaignId']); ?>" />
                                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($campaign['campaignId']); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" type="text" name="title" value="<?php echo htmlspecialchars($campaign['title']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3" required><?php echo htmlspecialchars($campaign['description']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Campaign Date</label>
                                    <input class="form-control" type="date" name="campaignDate" value="<?php echo htmlspecialchars($campaign['campaignDate']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" type="text" name="location" value="<?php echo htmlspecialchars($campaign['location']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="campaignlist.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
                            <button type="submit" class="btn btn-primary submit-btn" name="edit_btn">Update <i class="fas fa-share-square"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include('layouts/footer.php'); ?>
