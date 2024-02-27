<?php
// Handle form submission
include('includes/dbconnection.php');
if(isset($_POST['submit'])) {
    // Fetch user's email from the session
    session_start();
    $email = $_SESSION['email'];
    
    // Fetch new password and confirm password from the form
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['confirmpassword'];

    // Check if new password matches confirm password
    if ($newPassword != $confirmPassword) {
        echo '<script>alert("New Password and Confirm Password do not match."); window.location.href = window.location.href;</script>';
        exit(); // Prevent further execution
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password hash in the database
    $sql = "UPDATE registeration SET password = '$hashedPassword' WHERE email = '$email'";

    // Execute the query
    if(mysqli_query($conn, $sql)) {
        $sql = "UPDATE registeration SET otp = '' WHERE email = '$email'";
        mysqli_query($conn, $sql);
        echo '<script>alert("Password updated successfully."); window.location.href = "login.php";</script>';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Student Portal || Reset Password</title>
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">
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
                                <p class="lead">Reset Password</p>
                            </div>
                            <div class="body">
                                <form class="form-auth-small" action="" method="post">
                                    <div class="form-group">
                                        <label for="newpassword" class="control-label sr-only">New Password</label>
                                        <input type="password" class="form-control" placeholder="New Password" required="true" name="newpassword">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword" class="control-label sr-only">Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password" required="true" name="confirmpassword">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">Reset Password</button>
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
