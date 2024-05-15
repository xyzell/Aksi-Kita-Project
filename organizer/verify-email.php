
<?php 
session_start();
include('../server/koneksi.php');

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $verify_query = "SELECT verifyOtp, verifyStatus FROM organizer WHERE verifyOtp='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if(mysqli_num_rows($verify_query_run) > 0) 
    {
        $row = mysqli_fetch_array($verify_query_run);
        if($row['verifyStatus'] == "0")
        {
            $clicked_token = $row['verifyOtp'];
            $update_query = "UPDATE organizer SET verifyStatus='1' WHERE verifyOtp='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);
            
            if($update_query_run){
                $_SESSION['status'] = "Akun anda telah sukses diverifikasi!";
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Verifikasi gagal!";
                header("Location: login.php");
            }

        } else {
            $_SESSION['status'] = "Email telah diverifikasi. <br> Harap login kembali";
            header("Location: login.php");
            exit(0);
        }
    }
} else
{
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
}

?>