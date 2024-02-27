<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
{
    $secretKey = '6Lejd34pAAAAAFddJpdgD6VsV0TRIrv_-Fr0y21V';

    // Verify reCAPTCHA response
    $captchaResponse = $_POST['g-recaptcha-response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secretKey,
        'response' => $captchaResponse
    );
  
    $options = array(
        'http' => array (
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
  
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captchaSuccess = json_decode($verify);
  
    if (!$captchaSuccess->success) {
        echo '<script>alert("reCAPTCHA verification failed. Please try again."); window.location.href = window.location.href;</script>';
        exit();
    }
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    echo $password;
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid Email Address. Please enter a valid email address."); window.location.href = window.location.href;</script>';
        exit(); // Prevent further execution
    }

    // Fetch user from the database
    $sql = "SELECT * FROM registeration WHERE email='$email'";
    $query = mysqli_query($conn, $sql);
    
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            // User found, verify password
            if(password_verify($password, $result['password'])) {
                // Set session variable if login is successful
                $_SESSION['id'] = $result['enrollmentNo'];
                // Remember me functionality
                if(!empty($_POST["remember"])) {
                    // Set cookies for remembering the user
                    setcookie("email", $email, time() + (10 * 365 * 24 * 60 * 60), '/'); // 10 years
                    setcookie("password", $password, time() + (10 * 365 * 24 * 60 * 60), '/'); // 10 years
                } else {
                    // Clear cookies if remember me is not checked
                    setcookie("email", "", time() - 3600, '/'); // Clear the cookie
                    setcookie("password", "", time() - 3600, '/'); // Clear the cookie
                }
                // Redirect user to the dashboard
                header("Location:dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid Password.');</script>";
            }
        } else {
            // No user found for the provided email
            echo "<script>alert('No user found for the provided email.');</script>";
        }
    } else {
        // Error in query execution
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Portal || Login</title>
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/color_skins.css">
    
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="theme-blue">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="mobile-logo"><a href="login.php"><img src="../assets/images/logo-icon.svg" alt="Mplify"></a></div>
                    <div class="auth-left">
                        <div class="left-top">
                            <span>Student Login</span>
                        </div>
                        <div class="left-slider">
                            <img src="img/Sign.jpg" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="auth-right">
                        <div class="card">
                            <div class="header">
                                <p class="lead">Sign in to start your session</p>
                            </div>
                            <div class="body">
                                <form class="form-auth-small" action="" method="post">
                                    <div class="form-group">
                                        <label for="signin-email" class="control-label sr-only">Email-ID</label>
                                        <input type="text" class="form-control" placeholder="Email Id" required="true" name="email" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="signin-password" class="control-label sr-only">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" required="true" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="fancy-checkbox element-left">
                                           <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["email"])) { ?> checked <?php } ?> />
                                            <span>Remember me</span>
                                        </label>                               
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6Lejd34pAAAAAPy7Dl0BqvnuqUSewIFrs9MqADo4"></div>           
                                </div> 
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">LOGIN</button>
                                    <div class="bottom">
                                        <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="forgot-password.php">Forgot password?</a></span>
                                         <span class="helper-text m-b-10"></i> <a href="registeration.php">Not Registered? Click Here to Register</a></span>
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
