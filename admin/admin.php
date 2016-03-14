<?php

require("../inc/show_time.php");
include("excel_reader2.php");
$admin = is_admin_logged();
if(!$admin){
header("Location: index.php");
}else{


global $username, $status,$date_reg,$fullname;
$username = $_SESSION['pms_admin_user'];
$_SESSION['passport'] = "../dp/admin.png";
$status = $_SESSION['pms_admin_role'];
$date = $_SESSION['pms_timestamp'];
$date_reg = date("F j, Y",$date);
$detail = $_SESSION['details'];
$details = json_decode($detail,true);
$fullname = $details['fullname'];
//echo 'This is the same date '. date("h:i A, M j, Y","1430078937");

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

}
//echo 'The nuller '.$ses;
?>
<!DOCTYPE html>
<html>
    <head>
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
        <title>Cop Admin | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
       <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- DATA TABLES -->
        <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.../js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue" onload="processajax ('notification', '../catacata.php?note')">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="dashboard.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Cop Admin
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
                                    <img src="../img/avatar3.png" class="img-circle" alt="User Image" />
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
                            <img src="../img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo ucword($username);?></p>

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

                  
                   
                    <div class="row">
                        <!-- Left col -->
						<div id="response" style="width:70%; margin: 0 auto;" onchange=""></div>
                      <?php 
					if(isset($_GET['add_admin'])){
add_admin("","");
}
else if(isset($_GET['view_admin'])){
view_all_admin();
}
else if(isset($_GET['add_int_rate'])){
add_loan_interest_rate();
}
else if(isset($_GET['view_int_rate'])){
view_interest_rate();
}
else if(isset($_GET['edit_rate'])){
$id = decoder($_GET['edit_rate']);
update_($id);
}

else if(isset($_GET['del_rate'])){
$id = decoder($_GET['del_rate']);
$result = delete_ids_del_rate($id);
if($result){

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Interest rate successfully, deleted... 
                                    </div>';

}else{

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Interest rate not  deleted...
                                    </div>';
}
view_interest_rate();
}
else if(isset($_GET['throw'])){
from_the_form();
}
else if(isset($_GET['app_loan'])){
all_lona_look_up();
}
else if(isset($_GET['loan_approve'])){
$id = decoder($_GET['loan_approve']);
$loanDetails = getLoanDetailsOfId($id);
$userUsername = $loanDetails['username'];
if(checkIfUserStillHasALoan($userUsername)){
	echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> This user still has a loan that has not been totally cleared... unable to approve loan
                                    </div>';
									all_lona_look_up();
	}else{
loan_date_display($id);
	}
}
else if(isset($_GET['loan_decline'])){
$id = decoder($_GET['loan_decline']);
$result = decline_this_loan($id);
$row = select_return_id($id);
$cat_name = $row['cat_name'];
$amount = $row['amount'];
$rec = $row['username'];
$phone_number = $row['phone_number'];
$message = "Your Loan of category ".$cat_name." of &#8358 ".$amount." has been declined by the administrator";
$subject = "Loan Declination!";
$flag = 0;
$filepath = "";
$timestamp = time();
if($result){


echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Loan declined successfully... 
                                    </div>';
send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);
send_sms($phone_number,$message);
}else{

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Loan declination not successful...
                                    </div>';
}
all_lona_look_up();
}
else if(isset($_GET['edit_admin'])){
$adminid = stripslashes($_GET['edit_admin']);
$id = decoder($adminid);
$details = array();
$details = admin_edit_details($id);
$fullname = $details['fullname'];
$username = $details['username'];
$access_level = $details['access_level'];

edit_form_admin($fullname,$username,$access_level,$id);
}
else if(isset($_GET['make_payment'])){
$id = decoder($_GET['make_payment']);
this_is_for_payment($id);
all_lona_look_up();
}
else if(isset($_POST['make_loan_payment'])){
$id = decoder($_POST['id']);
$amount_now = $_POST['amount'];
$row = select_return_id($id);
$user_username = $row['username'];
$rec = $row['username'];
$cat_name = $row['cat_name'];
$admin_name = $fullname;
$balance_debt = $row['balance_debt'];
$payment_amount = $row['payment_amount'];
$phone_number = $row['phone_number'];
$balance_debt = $balance_debt - $amount_now;
$timestamp = time();
$subject = "Loan Payment";
$message = "Admin ".$fullname." has made &#8358 ".$amount_now." payment on your behalf for your ".$cat_name." loan";
$payment_amount  = $payment_amount + $amount_now;
$filepath = "";
$flag = 0;
$checker = check_with_timestamp($timestamp);
if(!$checker){
$result = make_payment_db($id,$amount_now,$user_username,$admin_name,$timestamp,$balance_debt,$payment_amount);
if($result){
send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);
send_sms($phone_number,$message);

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Payment successfully made already... 
                                    </div>';
}else{
	
	echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Payment not successfully made...
                                    </div>';


}

}else{

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> This record exists in the database already...
                                    </div>';

}
all_lona_look_up();
}
else if(isset($_GET['pay_history'])){
payment_history("");
}
else if(isset($_GET['all_sav_cat'])){
add_savings_categories();
}
else if(isset($_POST['forward_push'])){
$bf = $_POST['bf'];
$month = $_POST['month'];
$year = $_POST['year'];
$dates = $year.'-'.$month.'-01';
//echo $dates;
//print_r($bf);
$next_month = strtotime(date("Y-m-d",strtotime($dates))."+1 month");
$next_month = date("Y-m-d",$next_month);
$period = explode("-",$next_month);
$year_next = $period[0];
$month_next = $period[1];
$is_there = check_for_this_month_bf($month_next,$year_next);
if(!$is_there){
$usernames = array();
$keys = array_keys($bf);
$timestamp = time();
$usernames = select_all_users_username();
$length = sizeof($keys);
for($i=0;$i<$length;$i++){
$username = $keys[$i];
$bfs = $bf["".$username.""];

$insert = insert_into__new_bf($username,$bfs,$year_next,$month_next,$timestamp);
}
if($insert){
echo '<div class="alert alert-success alert-dismissable" style="width:70%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Balance Brought Forward successfully pushed into the database..
   
   </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:70%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Balance brought couldn\'t be saved...
   
   </div>';
}
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:70%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Balance brought forward for this month has been recorded earlier. <a href="?view_generated_ledger"> View generated Ledger</a>..
   
   </div>';
}
//print_r($bf);
}
else if(isset($_GET['view_generated_ledger'])){
show_me_the_form_generator();
}
else if(isset($_GET['log_in_bf'])){
show_me_form_ledger_bf();
}
else if(isset($_POST['view_ledger_bf_push'])){
$period = $_POST['period'];
$periods = explode("/",$period);
$year = $periods[1];
$month = $periods[0];
$dates = $year.'-'.$month.'-01';
$next_month = strtotime(date("Y-m-d",strtotime($dates))."+1 month");
$next_month = date("Y-m-d",$next_month);
$periode = explode("-",$next_month);
$year_next = $periode[0];
$month_next = $periode[1];
$is_there = check_for_this_month_bf($month_next,$year_next);
if($is_there){
echo '<div class="alert alert-danger alert-dismissable" style="width:70%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Balance brought forward for this month has been recorded earlier. <a href="?view_generated_ledger"> View generated Ledger</a>..
   
   </div>';
}else{
method_for_put_in_val($period,5);
}
}
else if(isset($_POST['view_ledger_period'])){
show_me_the_form_generator();
$period = $_POST['period'];
$year = date('Y');
$link = "printer.php?period=$period";
echo '<p align="right" style="padding-right:10%;font-weight:bold;"><a href="'.$link.'" target="_blank">Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#">Export to Excel</a></p>';
$periodArray = explode("/",trim($period));
if($period=="annual"){
get_annual_period_ledger($year,1);
}
else if($period=="biannual"){
get_annual_period_ledger($year,2);
}
else if($period=="5_years"){
get_annual_period_ledger($year,3);
}
else if($period=="so_far"){
get_annual_period_ledger($year,4);
}
else if(count($periodArray)!=2){
	
	}
else{
get_annual_period_ledger($period,5);
}
}
else if(isset($_POST['approve_loan'])){
$date_value = $_POST['date'];
$id = decoder($_POST['id']);
$amount = stripslashes($_POST['amount']);
$result = update_all_loan_approve($username,$date_value,$id,$amount);
$row = select_return_id($id);
$cat_name = $row['cat_name'];
$amount = $row['amount'];
$rec = $row['username'];
$phone_number = $row['phone_number'];
$message = "Your Loan of category ".$cat_name." of &#8358 ".$amount." has been approved by the administrator";
$subject = "Loan Approval!";
$flag = 0;
$filepath = "";
$timestamp = time();
if($result){

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b>Loan approval successful...
                                    </div>';
send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);
send_sms($phone_number,$message);
}else{

echo '<div class="alert alert-danger alert-dismissable" style="width:70%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Loan approval not successful...
   
   </div>';
}
//formay year-month-day

//echo "July 1, 2000 is on a " . date("l", mktime(0, 0, 0, 7, 1, 2000));
all_lona_look_up();
}
else if(isset($_GET['view_cat'])){
view_cat();
}
else if(isset($_GET['view_sav_cat'])){
view_all_savings_category();
}
else if(isset($_GET['del_savings'])){
$id = decoder($_GET['del_savings']);

$sql = "DELETE FROM savings WHERE `save_id`='{$id}'";
$result = query($sql);
if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b>Category deleted....
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b>Category not deleted....
                                    </div>';
}
view_all_savings_category();
}
else if(isset($_GET['edit_link_savings'])){
$id = decoder($_GET['edit_link_savings']);
$savings = get_all_from_savings_with_id($id);
$save_id = encoder($id);
$save_name = $savings['save_name'];
$save_description = $savings['save_description'];
$save_def_amount = $savings['save_def_amount'];
$save_start_date = $savings['save_start_date'];
$save_end_date  = $savings['save_end_date'];

edit_savings_id($save_id,$save_name,$save_description,$save_def_amount,$save_start_date,$save_end_date);
}
else if(isset($_GET['generate_ledger'])){
$month = date('m');
$year = date('Y');
$day  = date('d');
$generate = check_for_month_year($month,$year);
if($generate){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Ledger for this month has been generated before..
                                    </div>';
}else{

$date = $year.'-'.$month.'-'.$day;
$result = generate_ledger_for_this_month($month,$year,$day,$username);

if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Ledger generation is successful..
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Ledger generation not successful..
                                    </div>';
}
}
}
else if(isset($_POST['edit_savings_cat'])){
$save_id = decoder($_POST['save_id']);
$save_description = $_POST['save_description'];
$save_def_amount = $_POST['save_def_amount'];
$save_start_date = $_POST['save_start_date'];
$save_end_date = $_POST['save_end_date'];
$result = update_existing_savings($save_id,$save_description,$save_def_amount,$save_start_date,$save_end_date);
if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Savings\' Category updated...
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category not updated....
                                    </div>';
}
view_all_savings_category();
}
else if(isset($_GET['cat_delete'])){
$id = decoder($_GET['cat_delete']);
$result = delete_cat($id);
if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b>Category deleted....
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Problem was encountered while deleting category. Operation not successful...
                                    </div>';
}
view_cat();
}
else if(isset($_POST['edit_admin'])){
$adminid = $_POST['adminid'];
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password= $_POST['password'];
$pword = md5($password);
$access_level  = $_POST['access_level'];
$insert = insert_updated_admin_record($adminid,$fullname,$username,$access_level,$pword);
if($insert){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Admin profile successfully updated. Password is '.$password.'..
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Admin details not updated, try again...
   
   </div>';
}
view_all_admin();
}
else if(isset($_GET['add_loan_cat'])){
add_loan_cat_form();
}
else if(isset($_GET['view_user'])){
view_users();

}
else if(isset($_GET['bush_cat_loan'])){
$id = decoder($_GET['bush_cat_loan']);
$is_id = check_id_loan_cat($id);
if(!$is_id){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category id does not exists
   
   </div>';
}else{
add_loan_cat_form_update($id);
}
}
else if(isset($_POST['add_admin'])){
$username = stripslashes(strtolower($_POST['username']));
$password = $_POST['password'];
$fullname = stripslashes($_POST['fullname']);
$access_level = stripslashes($_POST['access_level']);
$checker = is_admin_username($username);
$time = time();
if($checker){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Admin Username exists in the database, try another username
   
   </div>';
add_admin($fullname,$username);
}else{
$pword = md5($password);
$result = insert_new_admin($fullname,$username,$pword,$access_level,$time);
if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Admin successfully added to the database. Username is '.$username.' and Password is '.$password.'  
                                    </div>';
add_admin("","");
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Admin Registration successful. Something must have been wrong
   
   </div>';
add_admin($fullname,$username);
}

}
}
else if(isset($_GET['reg_user'])){
echo '<iframe src="../index.php?register" width="100%" height="800"></iframe>';
}				  
					  ?>
					</div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


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
			
			function sure_del(){
			var ansa = confirm("Are you sure you want to delete this savings?");
			return ansa;
			}
			function relocate(link){
			window.open(""+$link+"");
			}
			function sure_bf(){
			var ansa = confirm("Are you sure what you want to save is verified? This is irreversible");
			return ansa;
			}
        </script>      
<style type="text/css">
input[type="text"]{
min-height:25px;
}
</style>
    </body>
</html>