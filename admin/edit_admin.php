<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];
    $query_edit_admin = "SELECT * FROM admin WHERE admin_id = ?";
    $stmt_edit_admin = $conn->prepare($query_edit_admin);
    $stmt_edit_admin->bind_param('i', $admin_id);
    $stmt_edit_admin->execute();
    $admin = $stmt_edit_admin->get_result()->fetch_assoc();
} elseif (isset($_POST['edit_btn'])) {
    $a_id = $_POST['admin_id'];
    $a_name = $_POST['admin_name'];
    $a_email = $_POST['admin_email'];
    $a_phone = $_POST['admin_phone'];

    $query_update_admin = "UPDATE admin SET admin_name = ?, admin_email = ?, admin_phone = ? WHERE admin_id = ?";
    $stmt_update_admin = $conn->prepare($query_update_admin);
    $stmt_update_admin->bind_param('sssi', $a_name, $a_email, $a_phone, $a_id);

    if ($stmt_update_admin->execute()) {
        header('location: admin.php?success_status=Admin has been updated successfully');
    } else {
        header('location: admin.php?fail_status=Could not update admin!');
    }
    exit;
} else {
    header('location: admin.php');
    exit;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Admin</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="admin.php">Admin</a></li>
            <li class="breadcrumb-item active">Edit Admin</li>
        </ol>
    </nav>

    <!-- Edit Admin Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Admin</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="edit-form" method="POST" action="edit_admin.php">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Admin ID</label>
                                    <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($admin['admin_id']); ?>" />
                                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($admin['admin_id']); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Admin Name</label>
                                    <input class="form-control" type="text" name="admin_name" value="<?php echo htmlspecialchars($admin['admin_name']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Admin Email</label>
                                    <input class="form-control" type="email" name="admin_email" value="<?php echo htmlspecialchars($admin['admin_email']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Admin Phone</label>
                                    <input class="form-control" type="text" name="admin_phone" value="<?php echo htmlspecialchars($admin['admin_phone']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="admin.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
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
