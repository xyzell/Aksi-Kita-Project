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
    $mail->Username   = 'aksik1taaa@gmail.com';                 //SMTP username
    $mail->Password   = 'mzpj jnsa yvrv ancx';                  //SMTP password
    
    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('aksik1taaa@gmail.com');
    $mail->addAddress($email);                                  //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Email verification of registration AksiKita';
   
    $email_template = "
    <h2> Kamu berhasil mendaftar dengan AksiKita</h2>
    <h5>Verifikasi email kamu untuk login pada link dibawah ini</h5>
    <br/><br/>
    <a href='http://localhost:8082/user/verify-email.php?token=$verify_token'> Click Me </a>
    ";

    $mail->Body = $email_template;
    $mail->send();

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Email has been sent";
    }
    
    
}

if (isset($_POST['register_btn'])) {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['pass']; 
    $confirm_pass = $_POST['passConfirm'];    
    $address = $_POST['address'];
    $userStatus = $_POST['user_status'];
    $verify_token = md5(rand());

    // Hash password sebelum menyimpannya ke database
    $hashed_password = md5($password);

    $checkEmailQuery = "SELECT userEmail FROM users WHERE userEmail = '$email' LIMIT 1";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $_SESSION['status'] = "Email sudah terdaftar";
        header('Location: register.php');
        exit();
    }

    if ($password !== $confirm_pass) {
        header('location: register.php?error=Kata sandi tidak cocok!');
        exit();
    } else if (strlen($password) < 6) {
        header('location: register.php?error=Kata sandi minimal harus 6 karakter');
        exit();
    }

    if (!empty($gender) && ($gender === 'Male' || 'Female')) {
        $query = "INSERT INTO users (userName, userEmail, userGender, userPassword, userAddress, userStatus, userBirthdate, userBio, userProfession, userProvince, userTown, userPostalCode, verifyOtp)
                  VALUES ('$name', '$email', '$gender', '$hashed_password', '$address', '$userStatus', NULL, NULL, NULL, NULL, NULL, NULL, '$verify_token')";

        if (mysqli_query($conn, $query)) {
            sendemail_verify($email, $verify_token);

            $_SESSION['status'] = "Registrasi berhasil! <br> Periksa alamat email anda untuk verifikasi!";
            header("Location: register.php");
            exit();
        } else {
            $_SESSION['status'] = "Registrasi gagal: " . mysqli_error($conn);
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Error: Nilai gender tidak valid.";
        header("Location: register.php");
        exit();
    }
}
