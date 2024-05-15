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
    <a href='http://localhost:3000/user/verify-email.php?token=$verify_token'> Click Me </a>
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
    $password = md5($_POST['pass']);
    $address = $_POST['address'];
    $userStatus = $_POST['user_status'];
    $verify_token = md5(rand());

    sendemail_verify($email, $verify_token);
    echo "sent or not?";

    // Periksa apakah email sudah terdaftar sebelumnya
    $checkEmailQuery = "SELECT userEmail FROM users WHERE userEmail = '$email' LIMIT 1";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if(mysqli_num_rows($checkEmailResult) > 0) {
        // Jika email sudah terdaftar, beri pesan kesalahan
        $_SESSION['status'] = "Email sudah terdaftar";
        header('Location: register.php'); 
        exit(); // Hentikan eksekusi kode selanjutnya
    }

    // Validasi nilai gender
    if (!empty($gender) && ($gender === 'Male' || $gender === 'Female')) {
        // Query untuk menyimpan data ke dalam database
        $query = "INSERT INTO users(userName, userEmail, userGender, userPassword, userAddress, userStatus, verifyOtp)
                  VALUES ('$name', '$email', '$gender', '$password', '$address', '$userStatus', '$verify_token')";

        // Jalankan query
        if(mysqli_query($conn, $query)){
            // Kirim email verifikasi
            sendemail_verify($email, $verify_token);

            $_SESSION['status'] = "Registrasi berhasil! <br> Periksa alamat email anda untuk verifikasi!";
            header("Location: register.php");
            exit(); // Hentikan eksekusi kode selanjutnya setelah mengalihkan pengguna
        } else {
            $_SESSION['status'] = "Registrasi gagal: " . mysqli_error($conn); // Tangkap pesan kesalahan MySQL
            header("Location: register.php");
            exit(); // Hentikan eksekusi kode selanjutnya setelah mengalihkan pengguna
        }
    } else {
        // Jika nilai gender tidak valid
        $_SESSION['status'] = "Error: Nilai gender tidak valid.";
        header("Location: register.php");
        exit(); // Hentikan eksekusi kode selanjutnya setelah mengalihkan pengguna
    }
}
