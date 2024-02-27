<?php
session_start();
error_reporting(1);
include 'includes/dbconnection.php';
if($_SESSION['id']==0)
{
    header('location:logout.php');
}
else
{
    if(isset($_POST['submit']))
  {
    $id=$_SESSION['id'];
    $Name=$_POST['Name'];
  $enrollmentNo=$_POST['enrollmentNo'];
  $email=$_POST['email'];
  $sql="update registeration set name='$Name',enrollmentNo='$id',email='$email' where enrollmentNo=$id";
     $query=mysqli_query($conn,$sql);
     if(isset($query)){
    echo '<script>alert("Detail has been Updated.")</script>';
echo "<script>window.location.href ='dashboard.php'</script>";
}
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  }
  ?>
<!doctype html>
<html lang="en">

<head>
<title>Student Portal || Student Profile</title>

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
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="../assets/images/thumbnail.png" width="48" height="48" alt="Mplify"></div>
        <p>Please wait...</p>
    </div>
</div>

<div class="overlay" style="display: none;"></div>

<div id="wrapper">

   <?php include_once('includes/header.php');?>

  <?php include_once('includes/sidebar.php');?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2>Student Profile</h2>
                    </div>            
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Student Profile</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Student Profile</h2>
                        </div>
                        <div class="body">
                            <?php
$id=$_SESSION['id'];
$sql="SELECT * from  registeration where enrollmentNo=$id";
$cnt=1;
  $query=mysqli_query($conn,$sql);
  $result=mysqli_fetch_array($query);
if(mysqli_num_rows($query)> 0)
{
             ?>
                            <form id="basic-form" method="post">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="Name" value="<?php  echo strtoupper($result['name']);?>" class="form-control" required='true'></div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" name="enrollmentNo" value="<?php  echo $result['enrollmentNo'];?>"  class="form-control" maxlength='12' required='true'>
                                </div>
                                <div class="form-group">
                                   <label>Email</label>
                                    <input type="email" name="email" value="<?php  echo $result['email'];?>" class="form-control" required='true'>
                                </div>
                                 <div class="form-group">
                                   <label>Address</label>
                                    <input type="text" name="" value="<?php  echo $result['Address'];?>" class="form-control" required='true' readonly='true'>
                                </div>
                               <?php $cnt=$cnt+1;} ?> 
                                <br>
                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Update</button>
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
    $(function() {
        // validation needs name of the element
        $('#food').multiselect();

        // initialize after multiselect
        $('#basic-form').parsley();
    });
    </script>
</body>
</html>

<?php }  ?>