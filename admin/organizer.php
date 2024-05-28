<?php
session_start();

// Cek apakah admin sudah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<?php include('layouts/header.php'); ?>

<?php
// Query untuk mengambil data organizer
$query_organizer = "SELECT organizerId, organizerName, organizerEmail, organizerPhoneNum, organizerKind, organizerAddress, organizerWebsite, organizerLogo FROM `organizer` ORDER BY organizerId DESC";

$stmt_organizer = $conn->prepare($query_organizer);
$stmt_organizer->execute();
$organizer = $stmt_organizer->get_result();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Organizer</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Organizer</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Organizer</h6>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['success_status'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $_GET['success_status']; ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_status'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['fail_status']; ?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Kind</th>
                            <th>Address</th>
                            <th>Website</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($organizer as $organizer) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($organizer['organizerId']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerName']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerEmail']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerPhoneNum']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerKind']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerAddress']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerWebsite']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['organizerLogo']); ?></td>
                                <td class="text-center">
                                    <a href="edit_organizer.php?organizerId=<?php echo htmlspecialchars($organizer['organizerId']); ?>" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
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
<!-- /.container-fluid -->

<?php include('layouts/footer.php'); ?>
