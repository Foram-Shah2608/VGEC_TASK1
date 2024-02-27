<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Include PHPMailer library for sending emails via SMTP
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to generate OTP
function generateOTP($length = 6) {
    return rand(pow(10, $length-1), pow(10, $length)-1);
}

// Function to send OTP via email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings (adjust these according to your SMTP provider)
        $mail->isSMTP(true);
        $mail->Host       = 'smtp.gmail.com'; // Change to localhost or your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shahforam.kep26@gmail.com'; // Change to your email address
        $mail->Password   = 'yfkv phve xtyu lmme'; // Change to your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';

        // Email content
        $mail->setFrom('shahforam.kep26@gmail.com','Password Reset');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password OTP';
        $mail->Body    = 'Your OTP for resetting password is: ' . $otp;

        // Send email
        $mail->send();

        return true;
    } catch (Exception $e) {
        // Handle exceptions and display error message
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        return false;
    }
}

// Handle form submission
if(isset($_POST['submit'])) {
    // Fetch user's email and OTP from the submitted form
    $email = $_POST['email'];
    $enteredOTP = $_POST['otp'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid Email Address. Please enter a valid email address."); window.location.href = window.location.href;</script>';
        exit(); // Prevent further execution
    }

    // Fetch OTP from the database for the user's email
    $sql = "SELECT otp FROM registeration WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $storedOTP = $row['otp'];

    // Check if entered OTP matches the stored OTP
    if ($enteredOTP == $storedOTP) {
        // OTP matches, proceed to password reset
        session_start();
        $_SESSION['email'] = $email;
        header("Location:update_password.php");
        exit();
    } else {
        echo '<script>alert("Incorrect OTP. Please try again."); window.location.href = window.location.href;</script>';
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Student Portal || Forgot Password</title>
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">
<script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
</head>
<body class="theme-blue">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="mobile-logo"><a href="index.html"><img src="../assets/images/logo-icon.svg" alt="Mplify"></a></div>
                    <div class="auth-left">
                        <div class="left-top">
                            <span>Student Portal</span>
                        </div>
                        <div class="left-slider">
                            <img src="img/Sign.jpg" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="auth-right">
                        <div class="card">
                            <div class="header">
                                <p class="lead">Validation</p>
                            </div>
                            <div class="body">
                                <form class="form-auth-small" action="" method="post" name="chngpwd" onSubmit="return valid();">
                                    <div class="form-group">
                                        <label for="signin-email" class="control-label sr-only">Email</label>
                                        <input type="text" class="form-control" placeholder="Email Address" required="true" name="email">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="otp" class="control-label sr-only">OTP</label>
                                        <input type="text" class="form-control" placeholder="Enter OTP" required="true" name="otp">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">Verify OTP</button>
                                    <div class="bottom">
                                        <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="login.php">Sign in</a></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
</body>
</html>
