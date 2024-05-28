<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

include('layouts/header.php');

if (isset($_GET['commentId'])) {
    $commentId = $_GET['commentId'];
    $query_edit_comment = "SELECT * FROM comments WHERE commentId = ?";
    $stmt_edit_comment = $conn->prepare($query_edit_comment);
    $stmt_edit_comment->bind_param('i', $commentId);
    $stmt_edit_comment->execute();
    $comment = $stmt_edit_comment->get_result()->fetch_assoc();
} elseif (isset($_POST['edit_btn'])) {
    $commentId = $_POST['commentId'];
    $commentItself = $_POST['commentItself'];

    $query_update_comment = "UPDATE comments SET commentItself = ? WHERE commentId = ?";
    $stmt_update_comment = $conn->prepare($query_update_comment);
    $stmt_update_comment->bind_param('si', $commentItself, $commentId);

    if ($stmt_update_comment->execute()) {
        header('location: comments.php?success_status=Comment has been updated successfully');
    } else {
        header('location: comments.php?fail_status=Could not update comment!');
    }
    exit;
} else {
    header('location: comments.php');
    exit;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Comment</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="comments.php">Comments</a></li>
            <li class="breadcrumb-item active">Edit Comment</li>
        </ol>
    </nav>

    <!-- Edit Comment Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Comment</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="edit-form" method="POST" action="edit_comment.php">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="hidden" name="commentId" value="<?php echo htmlspecialchars($comment['commentId']); ?>" />
                                    <label>Comment</label>
                                    <textarea class="form-control" name="commentItself" rows="5" required><?php echo htmlspecialchars($comment['commentItself']); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="comments.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
                            <button type="submit" class="btn btn-primary submit-btn" name="edit_btn">Update <i class="fas fa-share-square"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>
