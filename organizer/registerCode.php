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

if (isset($_POST['registerBtn'])) {
    $organizerName = $_POST['nama'];
    $organizerEmail = $_POST['email'];
    $organizerPhoneNum = $_POST['pnumber'];
    $organizerPass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $organizerKind = $_POST['orgTipe'];
    $organizerDesc = $_POST['desc'];
    $organizerAddress = $_POST['address'];
    $organizerWebsite = $_POST['website'];

    // Periksa apakah email sudah terdaftar sebelumnya
    $checkEmailQuery = "SELECT organizerEmail FROM organizer WHERE organizerEmail = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param('s', $organizerEmail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Jika email sudah terdaftar, beri pesan kesalahan
        $_SESSION['status'] = "Email sudah terdaftar";
        header('Location: register.php'); 
        exit(); // Hentikan eksekusi kode selanjutnya
    }

    // Menghandle upload file logo
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["logo_organisasi"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES["logo_organisasi"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["logo_organisasi"]["size"] > 500000) {
        echo "Maaf, file Anda terlalu besar.";
        $uploadOk = 0;
    }

    // Hanya izinkan format gambar tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek apakah $uploadOk bernilai 0
    if ($uploadOk == 0) {
        echo "Maaf, file Anda tidak dapat diunggah.";
    } else {
        if (move_uploaded_file($_FILES["logo_organisasi"]["tmp_name"], $target_file)) {
            $organizerLogo = $target_file;

            // Masukkan data ke database
            $sql = "INSERT INTO organizer (organizerName, organizerEmail, organizerPhoneNum, organizerPass, organizerKind, organizerDesc, organizerAddress, organizerWebsite, organizerLogo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssssssss', $organizerName, $organizerEmail, $organizerPhoneNum, $organizerPass, $organizerKind, $organizerDesc, $organizerAddress, $organizerWebsite, $organizerLogo);

            if ($stmt->execute()) {
                echo "Registrasi berhasil.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }

    $stmt->close();
    $conn->close();
}


?>