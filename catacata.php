<?php
include("inc/show_time.php");
$logged = is_cop_user_enter();

if(isset($_GET['check_matric'])){
$matric = stripslashes($_GET['check_matric']);
$is_matric = is_matric_student($matric);
if($is_matric){

echo "<span style='color:green;'> <i class='fa fa-check'></i> Matric Number registered </span>";

}else{
echo "<span style='color:red;'> <i class='fa fa-ban'></i> Matric is Not Registered </span>";

}
}
else if(isset($_GET['check_username'])){
$username = strtolower(addslashes($_GET['check_username']));
$is_stu_username = is_student_username($username);
$is_admin_username = is_admin_username($username);
if($is_stu_username ||  $is_admin_username){
echo "<span style='color:red;'> <i class='fa fa-ban'></i> Username exists in the database. Try another username </span>";

}else{
echo "<span style='color:green;'> <i class='fa fa-check'></i> Username valid </span>";

}
}
else if(isset($_POST['add_interest_rate'])){
$cat_id = $_POST['loan_cat'];
$amount = $_POST['amount'];
$interest_rate = $_POST['interest_rate'];
$percent_amount = ($interest_rate/100);
$checker = check_amount_id($cat_id,$amount);
$timestamp = time();
if($checker){
//echo "<span style='color:red;'> <i class='fa fa-ban'></i> This amount has been added to this category earlier. <a href='?view_int_rate'>Click View Interest Rate</a> to edit existing interest rate for various category</span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> This amount has been added to this category earlier. <a href=\'?view_int_rate\'>Click View Interest Rate</a> to edit existing interest rate for various category
                                    </div>';
									
}else{
$result =  add_interest_rate_db($cat_id,$amount,$interest_rate,$timestamp);
if($result){
//echo "<span style='color:green;'> <i class='fa fa-check'></i> Interest Rate has been added successfully</span>";

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Interest Rate has been added successfully...
                                    </div>';
									
}else{
//echo "<span style='color:red;'> <i class='fa fa-ban'></i>  Operation failed.. Couldn't add interest rate...</span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Operation failed.. Couldn\'t add interest rate...
                                    </div>';
									
}


}
}
else if(isset($_POST['loan_cat_update'])){
$cat_name = addslashes($_POST['cat_name']);
$id = decoder($_POST['id']);
$res = check_if_category_id($cat_name,$id);
$description = addslashes($_POST['description']);
if($res){
//echo "<span style='color:red;'> <i class='fa fa-ban'></i> Category exists in the database... </span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category exists in the database...
                                    </div>';

}else{
$result = update_category_name($id,$cat_name,$description);
if($result){
//echo "<span style='color:green;'> <i class='fa fa-check'></i> Category update successfully... </span>";
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category update successfully...
                                    </div>';
}else{
//echo "<span style='color:red;'> <i class='fa fa-ban'></i> Category couldn't be updated </span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category couldn\'t be updated
                                    </div>';
}
}
}
else if(isset($_POST['update_interest_rate'])){
$id = decoder($_POST['id']);
$interest_rate = $_POST['interest_rate'];
$result = update_rate($id,$interest_rate);

if($result){
//echo "<span style='color:green;'> <i class='fa fa-check'></i> Interest rate updated....</span>";

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Interest rate updated....
                                    </div>';

}else{
//echo "<span style='color:red;'> <i class='fa fa-ban'></i> System failed to update interest rate... </span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> System failed to update interest rate...
                                    </div>';
}
}
else if(isset($_POST['apply_for_loan'])){
$username = $_POST['username'];
$loan_category = $_POST['loan_cat'];
$amount_loan = $_POST['amount_loan'];
$amount_array = explode(':',$amount_loan);
$amount = $amount_array[0];
$interest_rate = $amount_array[1];
$interest = ($interest_rate/100) * $amount;
$expected_amount  = $amount + $interest;
$timestamp = time();
$result = insert_new_loan_apply($username,$loan_category,$amount,$interest_rate,$interest,$expected_amount,$timestamp);
if($result){
//echo "<span style='color:green;'> <i class='fa fa-check'></i> Loan Application successful......</span>";

echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Loan application successful.....
                                    </div>';
}else{
//echo "<span style='color:red;'> <i class='fa fa-ban'></i> Loan Application Failed... </span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Loan Application Failed...
                                    </div>';


}
}
else if(isset($_GET['select_drop_down'])){

$id = $_GET['select_drop_down'];
 echo '<select name="amount_loan"  class="form-control" required>';
										   
echo '<option value="">-- choose --</option>';
bring_other_part($id);
echo '</select>';
echo '<i><em>Amount ------ Interest rate</em></i>';
}
else if(isset($_POST['loan_cat'])){
$cat = addslashes($_POST['cat_name']);
$description = addslashes($_POST['description']);
$res = check_if_category($cat);
$timestamp = time();
if($res){
//echo "<span style='color:red;'> <i class='fa fa-ban'></i> Category exists in the database... </span>";

echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category exists in the database...
                                    </div>';

}else{
$result = insert_new_loan_cat($cat,$description,$timestamp);
if($result){
//echo "<span style='color:green;'> <i class='fa fa-check'></i> Category has been registered successfully... </span>";
 echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category has been registered successfully...
                                    </div>';
}else{
  echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Category couldn\'t be registered
                                    </div>';
}
}
}
else if(isset($_POST['savings_cat'])){
$cat_name  = trim(addslashes($_POST['cat_name']));
$description = addslashes($_POST['description']);
$def_amount = addslashes($_POST['def_amount']);
$start_date = addslashes($_POST['start_date']);
$end_date = addslashes($_POST['end_date']);
$username = $_SESSION['pms_admin_user'];
$is_savings = check_deduction_cat($cat_name,$description);
if($is_savings){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> This Savings Category exists in the database already
                                    </div>';
}else{

$result = add_category_savings($cat_name,$description,$def_amount,$start_date,$end_date,$username);
if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Savings category successfully added to the database
                                    </div>';
									$sqldd = "ALTER TABLE  `ledger` ADD  `$cat_name` BIGINT NOT NULL";
									query($sqldd);
									$sql = "ALTER TABLE  `users` ADD  `$cat_name` BIGINT NOT NULL";
									$show = query($sql);
									if($show){
									$sqls = "UPDATE `users` SET `$cat_name`='{$def_amount}' ";
query($sqls);									
									}
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> System unable to add Savings category
                                    </div>';
}
}

}
else if(isset($_POST['sign_me_up'])){
$surname = mysql_real_escape_string(addslashes($_POST['surname']));
$firstname = mysql_real_escape_string(addslashes($_POST['firstname']));
$other_name = mysql_real_escape_string(addslashes($_POST['other_name']));
$gender = mysql_real_escape_string(addslashes($_POST['gender']));

$phone_number = mysql_real_escape_string(addslashes($_POST['phone_number']));

$username = mysql_real_escape_string(strtolower(addslashes($_POST['username'])));
$email = mysql_real_escape_string(strtolower(addslashes($_POST['email'])));
$password = $_POST['password'];
$pass = md5($password);
$timestamp = time();
$is_admin_username = is_admin_username($username);
//$is_student_reg_before = is_student_reg_before($matric);

if(is_student_username($username) || $is_admin_username){
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Username exists in the database
   
   </div>';
}
else if(filter_var($email, FILTER_VALIDATE_EMAIL)===false){
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Error!</b> Email Not a Valid One
   
   </div>';
}
else if(is_student_email($email)){
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Email Exists in the database
   
   </div>';
}
/*
else if($is_student_reg_before){
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> User has been registered before. Contact the administrator if this persists
   
   </div>';
}*/
else{
$result = update_student_reg($surname,$firstname,$other_name,$gender,$phone_number,$username,$pass,$email,$timestamp);
if($result){

echo '<div class="alert alert-success alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Account Created. Username is <b>'.$username.'</b> and Password is <b>'.$password.'</b>. <a href="index.php">Proceed to log in</a>
   
   </div>';
   
   $message = "You have been registered as a cop  loan cooperative member. Your Username is :$username".PHP_EOL."Your Password is: $password";
  
   
   send_sms($phone_number,$message);
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Error!</b> Account Not Opened. try again..
   
   </div>';
}


}

}
else if(isset($_POST['update_profile'])){
if($logged){
$firstname = addslashes($_POST['firstname']);
$surname = addslashes($_POST['surname']);
$othername = addslashes($_POST['othername']);
$phone_number = addslashes($_POST['phonenumber']);
$address = addslashes($_POST['address']);
$username = $_SESSION['cop_user'];

$result = update_parse_data($username,$surname,$firstname,$othername,$phone_number,$address);
if($result){
echo '<div class="alert alert-success alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Profile Update Successful. 
   
   </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Update not successful...
   
   </div>';
}
}
}
else if(isset($_POST['sign_in_me'])){
$username = strtolower(addslashes($_POST['username']));
$password = md5($_POST['password']);
$signal = check_user_log_in_him($username,$password);
$is_activate = check_if_user_is_activated($username);
if($is_activate){


if($signal){
$inside = is_student_user_in_already($username);
$encoded = encoder($username);
if($inside){
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> User is logged in elsewhere. <a href="?outs='.$encoded.'">Log out</a>. Then try to log in back.
   
   </div>';
}
else {
$_SESSION['cop_user'] = $username;
@reset_user_student($username,'true');
echo '<div class="alert alert-success alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Log in Successful. <a href="dashboard.php">Proceed</a>
   
   </div>';
   echo '<meta http-equiv=REFRESH CONTENT=3;url=dashboard.php>';

   }
}
else{
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Wrong Username or Password
   
   </div>';
}
}else{
if($signal && !$is_activate){
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> User details correct, but user has been deactivated. Contact the administrator. Via contact support section.
   
   </div>';
}
}
}
else if(isset($_POST['resetp_email'])){
$username = mysql_real_escape_string(strtolower(addslashes($_POST['username'])));
$email = mysql_real_escape_string(strtolower(addslashes($_POST['email'])));
$there = forgot_pass_check($username,$email);
if($there){
$random = random_password();
$message = "Your Account's Password has been reset. Your New Password is ".$random;
$sent_mail = @mail_send($subject,$email,$message);
if($sent_mail){
$pass = md5($random);
$is_done = update_record_email($username,$pass);
if($is_done){
echo '<div class="alert alert-success alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> Mail Sent and Password Changed. Check Your email to access your new password.
   
   </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Error!</b> Mail sent but password not reset
   
   </div>';
}
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Error!</b> Mail not sent
   
   </div>';
}
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:100%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Error!</b> Wrong Combination of Email and Username
   
   </div>';
}
}
else if(isset($_GET['check_email'])){
$email = strtolower(addslashes($_GET['check_email']));
//$validate = FILTER_VALIDATE_EMAIL($email);
if(!filter_var($email, FILTER_VALIDATE_EMAIL)===false){
$is_email = is_student_email($email);
if($is_email){
echo "<span style='color:red;'> <i class='fa fa-ban'></i> Email exists in the database. Try another email </span>";

}else{
echo "<span style='color:green;'> <i class='fa fa-check'></i> Email Valid and Unique </span>";

}

}else{
echo "<span style='color:red;'> <i class='fa fa-ban'></i> Email not valid. Enter a valid email. </span>";

}
}

else if(isset($_GET['note'])){
if(isset($_SESSION['cop_user']) && isset($_SESSION['pms_admin_user'])){
$username= $_SESSION['pms_admin_user'];
?>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success"><?php get_unread_messages($username); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have <?php get_unread_messages($username); ?> messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <!-- end message -->
                                       
                                       
                                       
                                      <?php  get_latest_four($username); ?>
                                    </ul>
                                </li>
                                <li class="footer"><a href="inbox.php">See All Messages</a></li>
                            </ul>
<?php

}
else if(isset($_SESSION['cop_user'])){
$username= $_SESSION['cop_user'];
?>
 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success"><?php get_unread_messages($username); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have <?php get_unread_messages($username); ?> messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <!-- end message -->
                                       
                                       
                                       
                                      <?php  get_latest_four($username); ?>
                                    </ul>
                                </li>
                                <li class="footer"><a href="inbox.php">See All Messages</a></li>
                            </ul>
<?php

}
else{

}

}
?>