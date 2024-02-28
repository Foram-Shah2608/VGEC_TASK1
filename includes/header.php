 <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-brand">
                <a href="dashboard.php"> <span class="name">Dabbawalla</span>
                </a>
            </div>
            <div class="navbar-right">
                <ul class="list-unstyled clearfix mb-0">
                    <li>
                        <div class="navbar-btn btn-toggle-show">
                            <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                        </div>                        
                        <a href="javascript:void(0);" class="btn-toggle-fullwidth btn-toggle-hide"><i class="fa fa-bars"></i></a>
                    </li>
                   
                    <li>
                        <div id="navbar-menu">
                            <ul class="nav navbar-nav"> 
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                        <img class="rounded-circle" src="assets/images/download.png" width="30" alt="">
                                    </a>
                                    <div class="dropdown-menu animated flipInY user-profile">
                                        <div class="d-flex p-3 align-items-center">
                                            <?php
$id=$_SESSION['id'];
$sql="SELECT Name,email from  registeration where enrollmentNo=$id";
$query=mysqli_query($conn,$sql);
$results=mysqli_fetch_array($query);
$newcomp=mysqli_num_rows($query);
if($newcomp > 0)
{
            ?>
                                            <div class="drop-left m-r-10">
                                                <img src="../assets/images/user.jpg" class="rounded" width="50" alt="">
                                            </div>
                                            <div class="drop-right">

                                                <h4><?php  echo $results['Name'];?></h4>
                                                <p class="user-name"><?php  echo $results['email'];?></p>
                                            </div>
                                        </div>
                                        <?php $cnt=1; $cnt=$cnt+1;} ?>
                                        <div class="m-t-10 p-3 drop-list">
                                            <ul class="list-unstyled">
                                                <li><a href="user-profile.php"><i class="icon-user"></i>My Profile</a></li>
                                                
  <li class="divider"></li>
                                                <li><a href="logout.php"><i class="icon-power"></i>Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                               
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>