<?php 

require("../inc/show_time.php");
include("excel_reader2.php");
$admin = is_admin_logged();
if(!$admin){
header("Location: index.php");
}else{
global $back_page;
if(isset($_SERVER['HTTP_REFERER'])){
$back_page = $_SERVER['HTTP_REFERER'];
}
else{
$back_page = $_SERVER['PHP_SELF'];
}

global $username, $status,$date_reg,$fullname,$passport;
$username = $_SESSION['pms_admin_user'];
$_SESSION['passport'] = "../dp/admin.png";
$status = $_SESSION['pms_admin_role'];
$date = $_SESSION['pms_timestamp'];
$date_reg = date("F j, Y",$date);
$detail = $_SESSION['details'];
$details = json_decode($detail,true);
$fullname = $details['fullname'];
$passport = $_SESSION['passport'];

$logged_in = is_user_logged_in_already($username);
if(!$logged_in){
echo '

<script type="text/javascript">
alert("Admin User has been logged out elsewhere");
window.location = "../admin/";
</script>';

//header("Location: index.php");
}


if($logged_in)
{ 
    $ses = $_SESSION['cop_user']; //tell freichat the userid of the current user
    setcookie("freichat_user", "LOGGED_IN", time()+3600, "/"); // *do not change -> freichat code
}
else {
    $ses = null; //tell freichat that the current user is a guest

    setcookie("freichat_user", null, time()+3600, "/"); // *do not change -> freichat code
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

       if(is_file("../freichat/hardcode.php")){

               require "../freichat/hardcode.php";

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
<script type="text/javascript" language="javascipt" src="../freichat/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
	<link rel="stylesheet" href="../freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
<!--===========================FreiChatX=======END=========================-->                            
        <meta charset="UTF-8">
        <title>COP Admin | Draft</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
       <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
		<link rel="stylesheet" href="../freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		 <link href="../css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.../js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue"   onload="processajax ('notification', '../catacata.php?note')">
        <!-- header logo: style can be found in header.less -->
         <header class="header">
            <a href="dashboard.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                COP Admin
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
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $fullname; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo $_SESSION['passport']; ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo ucword($username).' - '.ucword($status) ?>
                                        <small>Member since <?php echo  $date_reg; ?></small>
                                    </p>
                                </li>
                               
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
                            <img src="<?php echo $_SESSION['passport']; ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo ucword($username); ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    
                   
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                     <?php include("sidebar.php"); ?>
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
				
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
			
    
	
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
					dealing_with_modal($username,$fullname);
if(isset($_POST['delete_mail'])){
$checkbox = $_POST['checkbox'];
$tablename = "drafts";
$id_row = "draftsid";
$flag = 0;
$counter = 0;
$noexists = 0;
$minus = 0;
foreach($checkbox as $id){
$real_id = decoder($id);
$is_id = is_id_before_deletion($tablename,$id_row,$real_id);
if($is_id){
$result = delete_messages($tablename,$id_row,$real_id);
if($result){
$counter = $counter + 1;
}else{
$minus = $minus + 1;
}
}else{
$noexists = $noexists + 1;
}
}
echo '<div class="alert alert-info alert-dismissable" style="width:80%; margin: 0 auto;">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> '.$counter.' draft(s) has been deleted while '.$minus.' draft(s) was not deleted. '.$noexists.' draft(s) not found in the database. It might have been deleted before.
                                    </div>';
}
else if(isset($_POST['move_junk'])){
$checkbox = $_POST['checkbox'];
$tablename = "drafts";
$id_row = "draftsid";
$flag = 0;
$counter = 0;
$noexists = 0;
$minus = 0;
foreach($checkbox as $id){
$real_id = decoder($id);
$is_id = is_id_before_deletion($tablename,$id_row,$real_id);
if($is_id){
$mover = move_to_junk($username,$tablename,$id_row,$real_id);

if($mover){
$result = delete_messages($tablename,$id_row,$real_id);
$counter = $counter + 1;
}else{
$minus = $minus + 1;
}
}else{
$noexists = $noexists + 1;
}
}
echo '<div class="alert alert-info alert-dismissable" style="width:80%; margin: 0 auto;">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> '.$counter.' draft(s) has been moved to junk '.$minus.' draft(s) was not moved. '.$noexists.' draft(s) not found in the database. It might have been deleted before.
                                    </div>';
}
	


					?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- MAILBOX BEGIN -->
                    <div class="mailbox row">
                        <div class="col-xs-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                            <!-- BOXES are complex enough to move the .box-header around.
                                                 This is an example of having the box header within the box body -->
                                            <div class="box-header">
                                                <i class="fa fa-pencil-square-o"></i>
                                                <h3 class="box-title">Drafts</h3>
                                            </div>
                                            <!-- compose message btn -->
                                            <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i> Compose Message</a>
                                            <!-- Navigation - folders-->
                                            <div style="margin-top: 15px;">
                                                 <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Folders</li>
                                                    <li ><a href="inbox.php"><i class="fa fa-inbox"></i> Inbox (<?php get_unread_messages($username); ?>)</a></li>
                                                    <li class="active"><a href="draft.php"><i class="fa fa-pencil-square-o"></i> Drafts</a></li>
                                                    <li><a href="sent.php"><i class="fa fa-mail-forward"></i> Sent</a></li>
                                                    
                                                    <li><a href="junk.php"><i class="fa fa-folder"></i> Junk</a></li>
                                                </ul>
                                            </div>
                                        </div><!-- /.col (LEFT) -->
                                      <?php 
									  if(isset($_GET['shakidraftkey'])){
									   $id = stripslashes($_GET['shakidraftkey']);
								   $id = decoder($id);
								   individual_draft($id,$back_page);
									  }
									  else if(isset($_GET['current_page'])){
											$currpage = mysql_real_escape_string(stripslashes($_GET['current_page']));
bring_drafts_listing($username,$currpage,$back_page);
										
										}
									else if(isset($_POST['search'])){
									$search = mysql_real_escape_string(stripslashes($_POST['mixedval']));
									$currpage = 0;
									bring_searched_drafts_listing($username,$currpage,$back_page,$search);
									}
								else if(isset($_GET['current_pages']) && isset($_GET['search'])){
								$mixedval = mysql_real_escape_string(stripslashes($_GET['search']));
								$currpage = mysql_real_escape_string(stripslashes($_GET['current_pages']));
								bring_searched_drafts_listing($username,$currpage,$back_page,$mixedval);
								}	
								
									  else{
									  $currpage = 0;
									  bring_drafts_listing($username,$currpage,$back_page);
									  }
									  ?>
                            </div><!-- /.box -->
                        </div><!-- /.col (MAIN) -->
                    </div>
                    <!-- MAILBOX END -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- COMPOSE MESSAGE MODAL -->
       <?php 
form_modal();

}
?>
<style type="text/css">
#forward{
display:none;
visibility:hidden;
}
</style>
<script language="Javascript">
function show_forward(){
//alert("show");
document.getElementById("forward").style.visibility = "visible";
document.getElementById("forward").style.display = "block";
}
function hide_forward(){
document.getElementById("forward").style.visibility = "hidden";
document.getElementById("forward").style.display = "none";
}
</script>
                            
                 
 <!-- jQuery 2.0.2 -->
        <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
		<script src="../js/xmlhttps.js" type="text/javascript"></script>
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
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
		 <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
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
		<link rel="stylesheet" href="../freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
    </body>
</html>