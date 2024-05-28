<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

include('../server/koneksi.php');

if (isset($_GET['commentId'])) {
    $commentId = $_GET['commentId'];
    $query_delete_comment = "DELETE FROM comments WHERE commentId = ?";
    $stmt_delete_comment = $conn->prepare($query_delete_comment);
    $stmt_delete_comment->bind_param('i', $commentId);

    if ($stmt_delete_comment->execute()) {
        header("location: comments.php?success_delete_message=Comment deleted successfully");
        exit();
    } else {
        header("location: comments.php?fail_delete_message=Failed to delete comment");
        exit();
    }
} else {
    header("location: comments.php?fail_delete_message=No comment ID provided");
    exit();
}
?>
