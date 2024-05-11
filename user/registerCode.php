<?php
ini_set('display_errors',  true);
error_reporting(E_ALL);

session_start();
include('../server/koneksi.php');

require '../assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendemail_verify($email, $verify_token)
{
    $mail = new PHPMailer(true);
    
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->Username   = 'alif.billah122014@gmail.com';          //SMTP username
    $mail->Password   = 'ijkr ynzb bghy njdk';                  //SMTP password
    
    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('alif.billah122014@gmail.com');
    $mail->addAddress($email);                                  //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Email verification of registration AksiKita';
   
    $email_template = "
    <h2> Kamu berhasil mendaftar dengan AksiKita</h2>
    <h5>Verifikasi email kamu untuk login pada link dibawah ini</h5>
    <br/><br/>
    <a href='/user/register.php/verify-email.php/token=$verify_token'> Click Me </a>

    ";

    $mail->Body = $email_template;
    $mail->send();

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Email has been sent";
    }
    // echo "Message has been sent";
    

}

if(isset($_POST['register_btn']))
{
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['pass'];
    $address = $_POST['address'];
    $userStatus = $_POST['user_status'];
    $verify_token = md5(rand());

    sendemail_verify($email, $verify_token);
    echo "sent or not?";

    if (!empty($gender)) {
        // Memeriksa dan menyimpan data ke database
        if ($gender === 'Male' || $gender === 'Female') {
            // Query untuk menyimpan data ke dalam database
            $query = "INSERT INTO users(userName, userEmail, userGender, userPassword, userAddress, userStatus, verifyOtp)
                      VALUES ('$name', '$email', '$gender', '$password', '$address', '$userStatus', '$verify_token')";

            $query_run = mysqli_query($conn, $query);

            if($query_run){
                sendemail_verify("$email", "$verify_token");

                $_SESSION['status'] = "Registrasi berhasil! Verifikasi alamat email anda.";
                header("Location: register.php");
            } else {
                $_SESSION['status'] = "Registrasi gagal.";
                header("Location: register.php");
            }
        } else {
            // Jika nilai gender tidak valid
            $_SESSION['status'] = "Error: Nilai gender tidak valid.";
            header("Location: register.php");
        }
    } else {
        // Jika gender tidak dipilih
        $_SESSION['status'] = "Error: Gender harus dipilih.";
        header("Location: register.php");
    }
} else {
    // Jika tombol register tidak diklik, jalankan kode lainnya
    // Contoh: Cek apakah email sudah terdaftar sebelumnya
    $checkEmail = "SELECT userEmail FROM users WHERE userEmail = '$email' LIMIT 1";
    $checkEmailQuery = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($checkEmailQuery) > 0)
    {
        $_SESSION['status'] = "Email sudah terdaftar";
        header('Location: register.php'); 
    } else {
        // Jika email belum terdaftar, lanjutkan kode lainnya seperti biasa
        // Contoh: Tampilkan formulir pendaftaran
    }
}

    // // Cek email terdaftar atau tidak
    // $checkEmail = "SELECT userEmail FROM users WHERE userEmail = '$email' LIMIT 1";
    // $checkEmailQuery = mysqli_query($conn, $checkEmail);

    // if(mysqli_num_rows($checkEmailQuery) > 0)
    // {
    //     $_SESSION['status'] = "Email sudah terdaftar";
    //     header('Location: register.php'); 
    // } else {

    //     $query = "INSERT INTO users(userName, userEmail, userGender, userPassword, userAddress, userStatus, verifyOtp)
    //     VALUES ('$name', '$email', '$gender', '$password', '$address', '$userStatus', '$verify_token')";

    //     $query_run = mysqli_query($conn, $query);

    //     if($query_run){
    //         sendemail_verify("$email", "$verify_token");

    //         $_SESSION['status'] = "Registrasi berhasil! Verifikasi alamat email anda.";
    //         header("Location: register.php");
    //     } else {
    //         $_SESSION['status'] = "Registrasi gagal.";
    //         header("Location: register.php");
    //     }
    // }



?>