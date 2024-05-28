<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit(); 
}

include('layouts/header.php');

$query_comments = "SELECT * FROM comments";
$stmt_comments = $conn->prepare($query_comments);
$stmt_comments->execute();
$comments = $stmt_comments->get_result();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Comments</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="comments.php">Comments</a></li>
            <li class="breadcrumb-item active">Comments list</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
        </div>
        <div class="card-body">
            <?php 
            $messages = [
                'success_delete_message' => 'info',
                'fail_delete_message' => 'danger',
            ];

            foreach ($messages as $message => $alertType) {
                if (isset($_GET[$message])) { ?>
                    <div class="alert alert-<?php echo $alertType; ?>" role="alert">
                        <?php echo htmlspecialchars($_GET[$message]); ?>
                    </div>
            <?php 
                }
            } 
            ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($comment['commentId']); ?></td>
                                <td><?php echo htmlspecialchars($comment['commentItself']); ?></td>
                                <td><?php echo htmlspecialchars($comment['commentDate']); ?></td>
                                <td class="text-center">
                                    <a href="edit_comment.php?commentId=<?php echo htmlspecialchars($comment['commentId']); ?>" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_comment.php?commentId=<?php echo htmlspecialchars($comment['commentId']); ?>" class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>
