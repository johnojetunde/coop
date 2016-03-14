<?php 
require("inc/show_time.php");
?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>cop | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
	
 <div style="width:60%; margin: 0 auto; margin-top:20;" id="response"></div>
       <?php 
	   if(isset($_GET['register'])){
	   the_registeration_form();
	   }
	   else if(isset($_GET['forgot_pass'])){
	   forgot_password();
	   }
	   else if(isset($_GET['out'])){
	   $username = $_SESSION['cop_user'];
	   @reset_user_student($username,'false');
	   delete_chat($_SESSION['cop_user']);
	   unset($_SESSION['cop_user']);
	    @session_unset();
        @session_destroy();
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> User is successfully logged out... You can now log in
                                    </div>';
								echo '<meta http-equiv=REFRESH CONTENT=3;url=inbox.php>';

	   }
	   else if(isset($_GET['outs'])){
	   $username = decoder($_GET['outs']);
	    @reset_user_student($username,'false');
	   delete_chat($username);
	   echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> User is successfully logged out... You can now log in
                                    </div>';
									echo '<meta http-equiv=REFRESH CONTENT=3;url=inbox.php>';
									
	   }
	    else{
	   user_general_log_in_form();
	   }
	   
	   ?>

        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        
   <script src="js/xmlhttps.js" type="text/javascript"></script>
    </body>
</html>