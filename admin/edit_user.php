<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['userId'])) {
    $user_id = $_GET['userId'];
    $query_edit_user = "SELECT * FROM users WHERE userId = ?";
    $stmt_edit_user = $conn->prepare($query_edit_user);
    $stmt_edit_user->bind_param('i', $user_id);
    $stmt_edit_user->execute();
    $user = $stmt_edit_user->get_result()->fetch_assoc();
} elseif (isset($_POST['edit_btn'])) {
    $u_id = $_POST['userId'];
    $u_name = $_POST['userName'];
    $u_email = $_POST['userEmail'];
    $u_gender = $_POST['userGender'];
    $u_address = $_POST['userAddress'];
    $u_status = $_POST['userStatus'];

    $query_update_user = "UPDATE users SET userName = ?, userEmail = ?, userGender = ?, userAddress = ?, userStatus = ? WHERE userId = ?";
    $stmt_update_user = $conn->prepare($query_update_user);
    $stmt_update_user->bind_param('sssssi', $u_name, $u_email, $u_gender, $u_address, $u_status, $u_id);

    if ($stmt_update_user->execute()) {
        header('location: user.php?success_status=User has been updated successfully');
    } else {
        header('location: user.php?fail_status=Could not update user!');
    }
    exit;
} else {
    header('location: user.php');
    exit;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="user.php">Users</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>

    <!-- Edit User Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="edit-form" method="POST" action="edit_user.php">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>User ID</label>
                                    <input type="hidden" name="userId" value="<?php echo $user['userId']; ?>" />
                                    <input class="form-control" type="text" value="<?php echo $user['userId']; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input class="form-control" type="text" name="userName" value="<?php echo $user['userName']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>User Email</label>
                                    <input class="form-control" type="email" name="userEmail" value="<?php echo $user['userEmail']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>User Gender</label>
                                    <select class="form-control" name="userGender" required>
                                        <option value="male" <?php if ($user['userGender'] == 'male') echo 'selected'; ?>>Male</option>
                                        <option value="female" <?php if ($user['userGender'] == 'female') echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>User Address</label>
                                    <input class="form-control" type="text" name="userAddress" value="<?php echo $user['userAddress']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>User Status</label>
                                    <select class="form-control" name="userStatus" required>
                                        <option value="active" <?php if ($user['userStatus'] == 'active') echo 'selected'; ?>>Active</option>
                                        <option value="inactive" <?php if ($user['userStatus'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="user.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
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
