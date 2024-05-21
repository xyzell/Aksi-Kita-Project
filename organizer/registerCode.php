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
    <a href='http://localhost:3000/organizer/verify-email.php?token=$verify_token'> Click Me </a>
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

    // This is image file
    $photo = $_FILES['logo_organisasi']['tmp_name'];

    // Photo name
    $photo_name = str_replace(' ', '_', $name) . ".jpg";

    // Upload image
    move_uploaded_file($photo, "../assets/images/profiles/" . $photo_name);

    // If password didn't match
    if ($password !== $confirm_password) {
        header('location: register.php?error=Password did not match');

    // If password less than 6 characters
    } else if (strlen($password) < 6) {
        header('location: register.php?error=Password must be at least 6 characters');

    // Inf no error
    } else {
        // Check whether there is a user with this email or not
        $query_check_user = "SELECT COUNT(*) FROM organizer WHERE organizerEmail = ?";

        $stmt_check_user = $conn->prepare($query_check_user);
        $stmt_check_user->bind_param('s', $email);
        $stmt_check_user->execute();
        $stmt_check_user->bind_result($num_rows);
        $stmt_check_user->store_result();
        $stmt_check_user->fetch();

        // If there is a user registered with this email
        if ($num_rows !== 0) {
            header('location: register.php?error=Organizer with this email already exists');
        
        // If no user registered with this email
        } else {
            $query = "INSERT INTO organizer (organizerName, organizerEmail, organizerPhoneNum, organizerPass, organizerKind,	organizerDesc,	organizerAddress, organizerWebsite, organizerLogo, userStatus, verifyOtp) 
                                VALUES ('$name', '$email', '$phone', '$password', '$kindOrg', '$description', '$address', '$website', '$photo_name','$userStatus', '$verify_token')";

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
        }
    }
}


?>