<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
include('../server/koneksi.php');

require '../assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function getUserData($email) {
    // Buat koneksi ke database (sesuaikan dengan konfigurasi database Anda)
    global $conn; // Asumsikan koneksi database ada di $conn yang diinisialisasi di koneksi.php

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk mendapatkan data user berdasarkan email
    $sql = "SELECT * FROM users WHERE userEmail = ?";
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

    $userName = $user['userName'];

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
            <p style='color: #555;'>Anda telah mendaftar sebagai relawan di website yang dikelola oleh <strong>Aksi Kita</strong></p>
            <p style='color: #555;'>Verifikasikan akun anda dengan klik tombol berikut ini.</p>
            <a href='http://localhost:3000/user/verify-email.php?token=$verify_token' style='display: inline-block; padding: 10px 20px; margin: 20px 0; color: #fff; background-color: #d9534f; text-decoration: none; border-radius: 5px;'>Verifikasi</a>
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
        $_SESSION['statusDanger'] = "Kata sandi tidak cocok!";
        header('location: register.php');
        exit();
    } else if (strlen($password) < 6) {
        $_SESSION['statusDanger'] = "Kata sandi minimal harus 6 karakter";
        header('location: register.php');
        exit();
    }

    if (!empty($gender) && ($gender === 'Male' || 'Female')) {
        $query = "INSERT INTO users (userName, userEmail, userGender, userPassword, userAddress, userStatus, userBirthdate, userBio, userProfession, userProvince, userTown, userPostalCode, verifyOtp)
                  VALUES ('$name', '$email', '$gender', '$hashed_password', '$address', '$userStatus', NULL, NULL, NULL, NULL, NULL, NULL, '$verify_token')";

        if (mysqli_query($conn, $query)) {
            sendemail_verify($email, $verify_token);

            $_SESSION['statusSuccess'] = "Registrasi berhasil! <br> Periksa alamat email anda untuk verifikasi!";
            header("Location: register.php");
            exit();
        } else {
            $_SESSION['statusDanger'] = "Registrasi gagal: " . mysqli_error($conn);
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['statusDanger'] = "Nilai gender tidak valid.";
        header("Location: register.php");
        exit();
    }
}
