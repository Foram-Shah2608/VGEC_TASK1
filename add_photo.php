<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    $enrollmentNo = $_SESSION['id'];
    if (isset($_POST['submit'])) {
        $files = $_FILES['photo'];
        $filename = $files['name'];
        $fileerror = $files['error'];
        $filestmpname = $files['tmp_name'];
        $filext = explode('.', $filename);
        $filecheck = strtolower(end($filext));
        $filextstored = array('png', 'jpg', 'jpeg');
        if (in_array($filecheck, $filextstored)) {
            $destinationfile = 'assets/images/' . $filename;
            move_uploaded_file($filestmpname, $destinationfile);
            $sql1 = "INSERT INTO images (enrollmentNo, photoName) VALUES ('$enrollmentNo', '$filename')";
            $query1 = mysqli_query($conn, $sql1);
            if ($query1) {
                echo '<script>alert("Your photo has been successfully added")</script>';
                echo "<script>window.location.href ='view-photo.php'</script>";
            } else {
                echo '<script>alert("Your photo has not been added")</script>';
            }
        } else {
            echo '<script>alert("Invalid file type. Only PNG, JPG, and JPEG files are allowed.")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Student Profile || Add Photo</title>

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/color_skins.css">
</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="../assets/images/thumbnail.png" width="48" height="48" alt="Mplify"></div>
        <p>Please wait...</p>
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay" style="display: none;"></div>
<div id="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <h2>Add Photo</h2>
                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Add Photo</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add Photo</h2>
                        </div>
                        <div class="body">
                            <form id="basic-form" method="post" enctype="multipart/form-data" action="">
                                <div class="form-group">
                                    <label>Select Your Photo</label>
                                    <input type="file" id="photo" name="photo" class="form-control" required="true" accept=".jpg,.png,.jpeg">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Javascript -->
<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/parsleyjs/js/parsley.min.js"></script>

<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/bundles/morrisscripts.bundle.js"></script>
<script>
    $(function () {
        // validation needs name of the element
        $('#food').multiselect();

        // initialize after multiselect
        $('#basic-form').parsley();
    });
</script>
</body>
</html>
