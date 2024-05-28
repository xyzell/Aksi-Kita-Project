<?php
ob_start();
session_start();
include('layouts/header.php');

// Cek apakah admin sudah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Jika parameter `organizerId` ada, ambil data organizer untuk diedit
if (isset($_GET['organizerId'])) {
    $organizer_id = $_GET['organizerId'];
    $query_edit_organizer = "SELECT * FROM organizer WHERE organizerId = ?";
    $stmt_edit_organizer = $conn->prepare($query_edit_organizer);
    $stmt_edit_organizer->bind_param('i', $organizer_id);
    $stmt_edit_organizer->execute();
    $organizer = $stmt_edit_organizer->get_result()->fetch_assoc();
} elseif (isset($_POST['edit_btn'])) {
    // Jika form edit di-submit, update data organizer
    $o_id = $_POST['organizerId'];
    $o_name = $_POST['organizerName'];
    $o_email = $_POST['organizerEmail'];
    $o_phone = $_POST['organizerPhoneNum'];
    $o_kind = $_POST['organizerKind'];
    $o_address = $_POST['organizerAddress'];
    $o_website = $_POST['organizerWebsite'];
    $o_logo = $_POST['organizerLogo'];

    $query_update_organizer = "UPDATE organizer SET organizerName = ?, organizerEmail = ?, organizerPhoneNum = ?, organizerKind = ?, organizerAddress = ?, organizerWebsite = ?, organizerLogo = ? WHERE organizerId = ?";
    $stmt_update_organizer = $conn->prepare($query_update_organizer);
    $stmt_update_organizer->bind_param('sssssssi', $o_name, $o_email, $o_phone, $o_kind, $o_address, $o_website, $o_logo, $o_id);

    if ($stmt_update_organizer->execute()) {
        header('Location: user.php?success_status=Organizer has been updated successfully');
    } else {
        header('Location: user.php?fail_status=Could not update organizer!');
    }
    exit();
} else {
    header('Location: user.php');
    exit();
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Organizer</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="user.php">Users</a></li>
            <li class="breadcrumb-item active">Edit Organizer</li>
        </ol>
    </nav>

    <!-- Edit Organizer Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Organizer</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="edit-form" method="POST" action="edit_organizer.php">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Organizer ID</label>
                                    <input type="hidden" name="organizerId" value="<?php echo htmlspecialchars($organizer['organizerId']); ?>" />
                                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($organizer['organizerId']); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Name</label>
                                    <input class="form-control" type="text" name="organizerName" value="<?php echo htmlspecialchars($organizer['organizerName']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Email</label>
                                    <input class="form-control" type="email" name="organizerEmail" value="<?php echo htmlspecialchars($organizer['organizerEmail']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Phone Number</label>
                                    <input class="form-control" type="text" name="organizerPhoneNum" value="<?php echo htmlspecialchars($organizer['organizerPhoneNum']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Kind</label>
                                    <input class="form-control" type="text" name="organizerKind" value="<?php echo htmlspecialchars($organizer['organizerKind']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Address</label>
                                    <input class="form-control" type="text" name="organizerAddress" value="<?php echo htmlspecialchars($organizer['organizerAddress']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Website</label>
                                    <input class="form-control" type="text" name="organizerWebsite" value="<?php echo htmlspecialchars($organizer['organizerWebsite']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organizer Logo</label>
                                    <input class="form-control" type="text" name="organizerLogo" value="<?php echo htmlspecialchars($organizer['organizerLogo']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="organizer.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
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
