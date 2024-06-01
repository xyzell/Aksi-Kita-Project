<?php
ini_set('display_errors',  true);
error_reporting(E_ALL);

session_start();
include('../server/koneksi.php');

require '../assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function getUserData($email) {
    
    global $conn;

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "SELECT * FROM organizer WHERE organizerEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data user
        return $result->fetch_assoc();
    } else {
        return null;
    }

    $stmt->close();
}

function sendemail_verify($email, $verify_token)
{
    $user = getUserData($email);

    if ($user === null) {
        echo "User tidak ditemukan";
        return;
    }

    $userName = $user['organizerName'];

    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->Username   = 'aksik1taaa@gmail.com';                 //SMTP username
        $mail->Password   = 'mzpj jnsa yvrv ancx';                  //SMTP password
        
        $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('aksik1taaa@gmail.com', 'AksiKita');
        $mail->addAddress($email);                                  //Add a recipient

        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Email verification of registration AksiKita';

        $email_template = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #e0e0e0;'>
            <h2 style='color: #333;'>Halo $userName,</h2>
            <p style='color: #555;'>Anda telah mendaftar sebagai organizer di website yang dikelola oleh <strong>Aksi Kita</strong></p>
            <p style='color: #555;'>Verifikasikan akun anda dengan klik tombol berikut ini.</p>
            <a href='http://localhost:3000/organizer/verify-email.php?token=$verify_token' style='display: inline-block; padding: 10px 20px; margin: 20px 0; color: #fff; background-color: #d9534f; text-decoration: none; border-radius: 5px;'>Verifikasi</a>
            <p style='color: #555;'>Salam hangat,<br/>Aksi Kita</p>
        </div>
        ";

        $mail->Body = $email_template;

        if ($mail->send()) {
            echo "Email has been sent";
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

if (isset($_POST['registerBtn'])) {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['pnumber'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['passConfirm'];
    $kindOrg = $_POST['orgTipe'];
    $description = $_POST['desc'];
    $address = $_POST['address'];
    $website = $_POST['website'];    
    $userStatus = $_POST['user_status'];
    $verify_token = md5(rand());

    $photo = $_FILES['logo_organisasi']['tmp_name'];

    $photo_name = str_replace(' ', '_', $name) . ".jpg";

    move_uploaded_file($photo, "../assets/images/profiles/" . $photo_name);
 
    if ($password !== $confirm_password) {
        $_SESSION['statusDanger'] = "Kata sandi tidak cocok!";
        header('location: register.php');

    } else if (strlen($password) < 6) {
        $_SESSION['statusDanger'] = "Kata sandi minimal 6 karakter";
        header('location: register.php');

    } else {
        $query_check_user = "SELECT COUNT(*) FROM organizer WHERE organizerEmail = ?";

        $stmt_check_user = $conn->prepare($query_check_user);
        $stmt_check_user->bind_param('s', $email);
        $stmt_check_user->execute();
        $stmt_check_user->bind_result($num_rows);
        $stmt_check_user->store_result();
        $stmt_check_user->fetch();

        
        if ($num_rows !== 0) {
            $_SESSION['statusDanger'] = "Email sudah terdaftar!";
            header('location: register.php');
        

        } else {
            $query = "INSERT INTO organizer (organizerName, organizerEmail, organizerPhoneNum, organizerPass, organizerKind, organizerDesc,	organizerAddress, organizerWebsite, organizerLogo, userStatus, verifyOtp) 
                                VALUES ('$name', '$email', '$phone', '$password', '$kindOrg', '$description', '$address', '$website', '$photo_name','$userStatus', '$verify_token')";

            if(mysqli_query($conn, $query)){        
                sendemail_verify($email, $verify_token);

                $_SESSION['status'] = "Registrasi berhasil! <br> Periksa alamat email anda untuk verifikasi!";
                header("Location: login.php");
                exit(); 
            } else {
                $_SESSION['statusDanger'] = "Registrasi gagal: " . mysqli_error($conn); 
                header("Location: register.php");
                exit(); 
            }
        }
    }
}


?>