<?php
session_start();
include('../server/koneksi.php'); 
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminName = trim($_POST['adminName']);
    $adminEmail = trim($_POST['adminEmail']);
    $adminPhone = trim($_POST['adminPhone']);
    $password = trim($_POST['password']);
    $repeatPassword = trim($_POST['repeatPassword']);

    if (empty($adminName) || empty($adminEmail) || empty($adminPhone) || empty($password) || empty($repeatPassword)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif ($password !== $repeatPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // If validation is successful, proceed to insert data into database
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO admin (admin_name, admin_email, admin_phone, admin_password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $adminName, $adminEmail, $adminPhone, $hashedPassword);
        
        if ($stmt->execute()) {
            header('location: login.php?success_message=Account created successfully');
            exit();
        } else {
            $errors[] = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5" style="max-width: 40rem; margin: auto;">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php
                            if (!empty($errors)) {
                                echo '<div class="alert alert-danger">';
                                foreach ($errors as $error) {
                                    echo '<p>' . htmlspecialchars($error) . '</p>';
                                }
                                echo '</div>';
                            }
                            ?>
                            <form class="user" method="POST" action="">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="adminName" placeholder="Admin Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="form-control form-control-user" name="adminEmail" placeholder="Email Address" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="adminPhone" placeholder="Phone Number" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="repeatPassword" placeholder="Repeat Password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
