<?php
session_start();
include('./server/koneksi.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_POST['update_btn'])) {
    $userId = $_SESSION['userId'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userGender = $_POST['userGender'];
    $userAddress = $_POST['userAddress'];
    $userBirthdate = $_POST['userBirthdate'];
    $userBio = $_POST['userBio'];
    $userProfession = $_POST['userProfession'];
    $userProvince = $_POST['userProvince'];
    $userTown = $_POST['userTown'];
    $userPostalCode = $_POST['userPostalCode'];

    $query = "UPDATE users SET userName=?, userEmail=?, userGender=?, userAddress=?, userBirthdate=?, userBio=?, userProfession=?, userProvince=?, userTown=?, userPostalCode=? WHERE userId=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssssssi', $userName, $userEmail, $userGender, $userAddress, $userBirthdate, $userBio, $userProfession, $userProvince, $userTown, $userPostalCode, $userId);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Profil berhasil diperbarui!";
        header('location: myProfile.php');
        exit();
    } else {
        $_SESSION['status'] = "Gagal memperbarui profil: " . $stmt->error;
        header('location: myProfile.php');
        exit();
    }
}
?>
