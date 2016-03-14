<?php 
include("inc/show_time.php");
$logged = is_cop_user_enter();
if(!$logged){
header("Location: index.php");
}


global $username,$matric,$fullname,$date_reg,$passport,$surname,$firstname,$other_name;

$username = $_SESSION['cop_user'];
$all_details = get_details_user($username);
$surname = $all_details['surname'];
$firstname = $all_details['firstname'];
$other_name = $all_details['othername'];
$passport = $all_details['passport'];
if($passport==""){
$_SESSION['passport'] = "dp/user.png";
}else{
$_SESSION['passport'] = "dp/".$passport;
}

$fullname = $surname.' '.$firstname;
$timer = $all_details['timestamp'];
//$matric = $all_details['matric'];
$date_reg = date("F j, Y",$timer);

$logged_in = is_student_user_in_already($username);

if(!$logged_in){
echo '

<script type="text/javascript">
alert("Student User has been logged out elsewhere");
window.location = "index.php";
</script>';

//header("Location: index.php");
}

if($logged)
{ 
    $ses = $_SESSION['cop_user']; //tell freichat the userid of the current user
    setcookie("freichat_user", "LOGGED_IN", time()+600, "/"); // *do not change -> freichat code
}
else {
    $ses = 'set'; //tell freichat that the current user is a guest

    setcookie("freichat_user", null, time()+600, "/"); // *do not change -> freichat code
}

?>

<!DOCTYPE html>
<html>
    <head>
                    <!--===========================FreiChat=======START=========================-->
<!--	For uninstalling ME , first remove/comment all FreiChat related code i.e below code
	 Then remove FreiChat tables frei_session & frei_chat if necessary
         The best/recommended way is using the module for installation                         -->

<?php
$ses=null;

if(!function_exists("freichatx_get_hash")){
function freichatx_get_hash($ses){

       if(is_file("freichat/hardcode.php")){

               require "freichat/hardcode.php";

               $temp_id =  $ses . $uid;

               return md5($temp_id);

       }
       else
       {
               echo "<script>alert('module freichatx says: hardcode.php file not
found!');</script>";
       }

       return 0;
}
}
?>
<script type="text/javascript" language="javascipt" src="freichat/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
	<link rel="stylesheet" href="freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
<!--===========================FreiChatX=======END=========================-->                            
        <meta charset="UTF-8">
        <title>Cooperative Loan  User | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
       <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
		<link rel="stylesheet" href="freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		 <link href="css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue"   onload="processajax ('notification', 'catacata.php?note')">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="user.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                cop User
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
						<li class="dropdown messages-menu" id="notification" >
						</li>
						
                        <!-- Tasks: style can be found in dropdown.less -->
                        
                        <!-- Tasks: style can be found in dropdown.less -->
                        
                       <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php $fullname; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/avatar5.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $fullname; ?>
                                        <small> Member since <?php echo $date_reg; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                               
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    
                                    <div class="pull-right">
                                        <a href="index.php?out" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                   
					</ul>
                </div>
            
			</nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/avatar5.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo ucword($username); ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    
                   
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="cop_user.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
					<li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Profile</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="?edit_p_pix"><i class="fa fa-angle-double-right"></i> Edit Passport</a></li>
                                <li><a href="?requested_book"><i class="fa fa-angle-double-right"></i> Edit Personal Details</a></li>
                               
                               
                            </ul>
                        </li>
						
                       <li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Books</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="?book_search"><i class="fa fa-angle-double-right"></i>Search Book</a></li>
                                <li <?php if(isset($_GET['requested_book'])){ echo 'class="active"';} ?>><a href="?requested_book"><i class="fa fa-angle-double-right"></i> Check Borrow History</a></li>
                                <li <?php if(isset($_GET['book_borrow'])){ echo 'class="active"';} ?>><a href="?book_borrow"><i class="fa fa-angle-double-right"></i> Check return History</a></li>
                                <li <?php if(isset($_GET['return_books'])){ echo 'class="active"';} ?>><a href="?return_books"><i class="fa fa-angle-double-right"></i> Check dk</a></li>
                               
                            </ul>
                        </li>
						
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span>Mailbox</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="inbox.php"><i class="fa fa-angle-double-right"></i> Inbox ()</a></li>
                                <li><a href="draft.php"><i class="fa fa-angle-double-right"></i> Drafts ()</a></li>
                                <li><a href="sent.php"><i class="fa fa-angle-double-right"></i> Sent ()</a></li>
                                <li><a href="junk.php"><i class="fa fa-angle-double-right"></i> Junk ()</a></li>
                               
                            </ul>
                        </li>
						
		
                        
                    </ul>
                
				</section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
					<?php if($passport==""){
echo '<marquee scrolldelay="50" id="scroll_news"><div onMouseOver="document.getElementbyId(\'scroll_news\').stop();" onMouseOut="document.getElementById(\'scroll_news\').start();">You have not uploaded your Passport. Update your <a href="">profile here</a></div></marquee>' ;
	
	}
	
	?>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
				<?php 
				dealing_with_modal($username,$fullname);
				?>
    
	
                    <!-- Small boxes (Stat box) -->
                   
                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                         
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                       <?php 
					   if(isset($_GET['book_search'])){
					  student_book_view();
				}
				else if(isset($_GET['edit_p_pix'])){
				edit_pix_form();
				}
					   
					   ?>
                            
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
<?php 
form_modal();
?>
 <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
		<script src="js/xmlhttps.js" type="text/javascript"></script>
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
<style type="text/css">
input[type="text"]{
min-height:25px;
}
</style>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
		 <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(function() {

                "use strict";

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });

                //When unchecking the checkbox
                $("#check-all").on('ifUnchecked', function(event) {
                    //Uncheck all checkboxes
                    $("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
                });
                //When checking the checkbox
                $("#check-all").on('ifChecked', function(event) {
                    //Check all checkboxes
                    $("input[type='checkbox']", ".table-mailbox").iCheck("check");
                });
                //Handle starring for glyphicon and font awesome
                $(".fa-star, .fa-star-o, .glyphicon-star, .glyphicon-star-empty").click(function(e) {
                    e.preventDefault();
                    //detect type
                    var glyph = $(this).hasClass("glyphicon");
                    var fa = $(this).hasClass("fa");

                    //Switch states
                    if (glyph) {
                        $(this).toggleClass("glyphicon-star");
                        $(this).toggleClass("glyphicon-star-empty");
                    }

                    if (fa) {
                        $(this).toggleClass("fa-star");
                        $(this).toggleClass("fa-star-o");
                    }
                });

                //Initialize WYSIHTML5 - text editor
                $("#email_message").wysihtml5();
            });
        </script>
		<link rel="stylesheet" href="freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
    </body>
</html>