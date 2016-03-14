<?php include("../inc/show_time.php");
$admin = is_admin_logged();

if($admin){

global $username, $status,$date_reg,$fullname;
$username = $_SESSION['pms_admin_user'];
$status = $_SESSION['pms_admin_role'];
$date = $_SESSION['pms_timestamp'];
$date_reg = date("F j, Y",$date);
$detail = $_SESSION['details'];
$details = json_decode($detail,true);
$fullname = $details['fullname'];

$logged_in = is_user_logged_in_already($username);
if($logged_in){
header("Location: dashboard.php");
}
}

 ?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>COP | Coperative Loan Management System Admin Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		<style type="text/css">
	
		</style>
    </head>
    <body class="bg-black" >
<?php 
if(isset($_POST['sign_in'])){
$username = strtolower(stripslashes($_POST['username']));
$password = $_POST['password'];
$encoded = encoder($username);
$pword = md5($password);
$user = check_if_admin_exists($username,$pword);
if($user){
$logged_in = is_user_logged_in_already($username);
if($logged_in){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Admin user is logged in from another channel. <a href="?outer='.$encoded.'">log admin out</a>...
   
   </div>';
}else{
$all_details = get_details_admin_username($username);

$_SESSION['cop_user'] = "Admin-".$all_details['username'];
$_SESSION['pms_admin_user'] = $all_details['username'];
$_SESSION['pms_admin_role'] = $all_details['access_level'];
$_SESSION['pms_timestamp'] = $all_details['timestamp'];
$_SESSION['details'] = json_encode($all_details);
set_admin_logged_in_status($username,'true');

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Log in successful  <a href="dashboard.php">Proceed</a>
                                    </div>';
									echo '<meta http-equiv=REFRESH CONTENT=3;url=dashboard.php>';
}

}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Wrong username or Password...
   
   </div>';
}

}
elseif(isset($_GET['outer'])){
$username = decoder($_GET['outer']);
$result = set_admin_logged_in_status($username,'false');
if($result){
echo '

<script type="text/javascript">
alert("Admin User has been logged out. You can now log in");

</script>';
}else{
echo '

<script type="text/javascript">
alert("operation failed. Try again");

</script>';
}
}
else if(isset($_GET['out'])){
set_admin_logged_in_status($_SESSION['pms_admin_user'],'false');
unset($_SESSION['pms_admin_user']);
unset($_SESSION['pms_admin_role']);
unset($_SESSION['cop_user']);

session_unset();
session_destroy();
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> You have successfully log out...
                                    </div>';
}




?>

        <div class="form-box" id="login-box" style="opacity:1.0;">
		<h3 align="center"><a href="../index.php">BACK</a></h3>
            <div class="header" >COP Admin Sign In</div>
            <form action="index.php" method="post" name="">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required/>
                    </div>          
                    
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="sign_in">Sign me in</button>  
                    
                    
                </div>
            </form>

            
        </div>

        <!-- jQuery 2.0.2 -->
        <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>