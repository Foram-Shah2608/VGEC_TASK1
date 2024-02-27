<?php
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit']))
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
    $name=$_POST['name'];
    $enrollmentNo=$_POST['enrollmentNor']; // Corrected field name
    $add=$_POST['address'];
    $email=$_POST['email'];
    $password=$_POST['Password']; // Corrected field name

    // Regular expression to match exactly 12 digits
    $pattern = "/^\d{12}$/";
    if (!preg_match($pattern, $enrollmentNo)) {
        echo '<script>alert("Invalid Enrollment Number. Please enter exactly 12 digits.");window.location.href = window.location.href;</script></script>';
        exit(); // Prevent further execution
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid Email Address. Please enter a valid email address.");window.location.href = window.location.href;</script></script>';
        exit(); // Prevent further execution
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  
    $sql = "INSERT INTO registeration VALUES ('$enrollmentNo','$name','$add','$email','$hashed_password')";

    // Execute the query
    try {
        $query = mysqli_query($conn, $sql);

        // Check if the query was successful
        if($query){
            echo '<script>alert("Student Detail has been added."); window.location.href = "login.php";</script>';
            exit();
        } else {
            // Handle the case where the query fails
            echo '<script>alert("Something went wrong while adding student detail."); window.location.href = window.location.href;</script>';
            exit();
        }
    } catch (Exception $e) {
        echo '<script>alert("You have Entered Duplicate Entry."); window.location.href = window.location.href;</script>';
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<title>Student Portal || Registeration</title>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                        <div class="auth-center">
                        <div class="card">
                            <div class="header">
                                <p class="lead">Registration Form</p>
                            </div>
                            <div class="body">
                                    <form id="basic-form" action="registeration.php" method="post">
                                <div class="form-group">
                                    <label>Student Name</label>
                                   <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control" required="true"></div>
                                <div class="form-group">
                                    <label>Enrollment Number</label>
                                    <input type="number" id="enrollmentNo" name="enrollmentNor" placeholder="Enter Enrollment Number" class="form-control" maxlength="12" required="true">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                     <textarea name="address" id="address" placeholder="Enter Address..." class="form-control" required="true"></textarea>
                                </div>                  
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input type="email" id="email" name="email" placeholder="Enter Email ID" class="form-control" required="true">
                                </div> 
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="Password" name="Password" placeholder="Enter Password" class="form-control" maxlength="10" required="true">
                                </div>
                                <div class="form-group">        
                                <div class="g-recaptcha" data-sitekey="6Lejd34pAAAAAPy7Dl0BqvnuqUSewIFrs9MqADo4"></div><br>                
                                </div> <br>
                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Register</button></div>
                            </form>                                
                                        <span class="helper-text m-b-10"><i class="fa fa-home"></i> <a href="../index.php">Back Home</a></span>
                                        <span class="helper-text m-b-10"><i class="fa fa-home"></i> <a href="login.php">Already Register?Click here to Sign In</a></span>
                                       
                                    </div>
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
