<?php
include("image.php");
set_time_limit(0);
session_start();
date_default_timezone_set('Africa/Lagos');
global $today_date,$session,$countdown;
$today_date = date('F,j,Y, g:ia');


$user = "root";
$pass = "";
$host = "localhost";
$dbase = "damisa_coperative";
global $result,$base_url;
$base_url = $_SERVER['DOCUMENT_ROOT'];
$admin_phone_numbers = "2348169013692";
$mysqli = new mysqli($host,$user,$pass,$dbase);
function close_db()
	{
		global $mysqli;
		$mysqli->close();
	}
	

	function query($query)
	{
		global $result, $mysqli;
		$result = $mysqli->query($query);
		return $result;
	}
	function mail_send($subject,$to,$message){

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: support@cop.com.ng' . "\r\n" .
    'Reply-To: support@cop.com.ng' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$answer = @mail($to, $subject, $message, $headers);
return $answer;
}

//echo 'The session is '.$session;
	function random_password(){
$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$limit = strlen($alphabet);

$limit = $limit-1;
for($i=0;$i<20;$i++){
$n = rand(0,$limit);

$pass[$i] = $alphabet[$n];
}
return implode($pass);

}
	function encoder($name){
			$trans = array("a"=>"l", "l"=>"a", "b"=>"z", "z"=>"b", "d"=>"x", "x"=>"d", "g"=>"h", "h"=>"g", "j"=>"m", "m"=>"j",
 "n"=>"o", "o"=>"n", "q"=>"r", "r"=>"q", "s"=>"y", "y"=>"s", "u"=>"v", "v"=>"u", "0"=>"2", "2"=>"0", 
 "4"=>"1", "1"=>"4", "8"=>"6", "6"=>"8","9"=>"3", "3"=>"9");

		$namer = base64_encode(strtr($name, $trans));
		//eturn urlencode($namer);
		return ($namer);
			}
			
	function decoder($namer){
		$untrans = array("a"=>"l", "l"=>"a", "b"=>"z", "z"=>"b", "d"=>"x", "x"=>"d", "g"=>"h", "h"=>"g", "j"=>"m", "m"=>"j",
 "n"=>"o", "o"=>"n", "q"=>"r", "r"=>"q", "s"=>"y", "y"=>"s", "u"=>"v", "v"=>"u", "0"=>"2", "2"=>"0", 
 "4"=>"1", "1"=>"4", "8"=>"6","6"=>"8", "9"=>"3", "3"=>"9");
              $namers = (base64_decode($namer));
			$unamer = strtr($namers, $untrans);
			//echo $unamer; urldecode
			return $unamer;
		
		}

function check_if_admin_exists($username,$pword){
$sql = "SELECT * FROM `admin` WHERE `username`='{$username}' && `password`='{$pword}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function check_with_timestamp($timestamp){
$sql = "SELECT * FROM `payment_history` WHERE `timestamp`='{$timestamp}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function check_for_this_month_bf($month,$year){
$sql = "SELECT * FROM `bf` WHERE `month`='{$month}' AND `year`='{$year}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function get_details_admin_username($username){
$sql = "SELECT * FROM `admin` WHERE `username`='{$username}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
return $row;
}

function is_cop_user_enter(){
if(isset($_SESSION['cop_user'])){
return true;
}else{
return false;
}
}
function get_details_user($username){
$sql = "SELECT * FROM `users` WHERE `username`='{$username}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
//print_r($row);
return $row;

}
function is_admin_username($username){
$sql = "SELECT * FROM `admin` WHERE `username`='{$username}'";
$result1 = query($sql);
$mysql_rows1 = $result1->num_rows;

$sql2 = "SELECT * FROM `users` WHERE `username`='{$username}'";
$result2 = query($sql);
$mysql_rows2 = $result2->num_rows;
if($mysql_rows1==0 && $mysql_rows2==0){
return false;
}
else{
return true;
}

}
function check_deduction_cat($cat_name,$description){
$sql = "SELECT * FROM `savings` WHERE `save_name`='{$cat_name}' || `save_description`='{$description}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;

}
function check_if_book_exists($book_name,$book_author){
$sql = "SELECT * FROM `book` WHERE `book_name`='{$book_name}' && `book_author`='{$book_author}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;

}
function create_insert_library_book($book_name,$book_author,$book_print_year,$book_isbn,$book_location,$book_copies,$book_state,$timestamp){
$sql = "INSERT INTO `book` SET 
`book_name`='{$book_name}',
`book_author`='{$book_author}',
`book_print_year`='{$book_print_year}',
`book_isbn`='{$book_isbn}',
`book_location`='{$book_location}',
`book_copies`='{$book_copies}',
`book_status`='{$book_state}',
`fine_per_book`='',
`timestamp`='{$timestamp}'
";
$result = query($sql);
return $result;
}
function add_interest_rate_db($cat_id,$amount,$interest_rate,$timestamp){
$sql = "INSERT INTO `loan_interest_rate` SET 
`amount`='{$amount}',
`interest_rate`='{$interest_rate}',
`loan_categid`='{$cat_id}',
`timestamp`='{$timestamp}'";
$result = query($sql);
return $result;
}
function get_all_interest($id){
$sql = "SELECT * FROM `loan_interest_rate` left join loan_categ on loan_cat_id=loan_categid WHERE `rate_id`='{$id}'";

$result = query($sql);
$row = $result->fetch_array();
return $row;
}
function delete_ids_del_rate($id){
$sql = "DELETE FROM `loan_interest_rate` WHERE `rate_id`='{$id}'";
$result = query($sql);
return $result;
}
function update_rate($id,$interest_rate){
$sql = "UPDATE `loan_interest_rate` SET `interest_rate`='{$interest_rate}' WHERE `rate_id`='{$id}'";
$result = query($sql);
return $result;
}
function select_all_users(){
$sql = "SELECT * FROM users ORDER BY username DESC";
$result = query($sql);
$mysql_rows = $result->num_rows;
echo '<select name="username" required class="form-control required 
<option value="">-- choose --</option>
';
for($i=0;$i<$mysql_rows;$i++){
$row =$result->fetch_array();
$firstname = $row['firstname'];
$surname = $row['surname'];
$othername = $row['othername'];
$fullname = $surname." ".$firstname." ".$othername;
$username= $row['username'];
echo '<option value="'.$username.'">'.$fullname.'</option>';
}
echo '</select>';
}

function dateData(){
	$timestamp = time();
    $currentMonth = date("m",$timestamp);
    $currentYear = date("Y",$timestamp);
    
   $isDate = check_for_month_year($currentMonth,$currentYear);
   if($isDate){
       
   }else{
      $currentMonth =  date('m', strtotime('last month'));
      $currentYear = date('Y', strtotime('last month'));
      
   }
   $dateData = "01-".$currentMonth."-".$currentYear;
   return $dateData;
	}
function deductionsDisplay(){
	
	$timestamp = time();
    $currentMonth = date("m",$timestamp);
    $currentYear = date("Y",$timestamp);
    
   $isDate = check_for_month_year($currentMonth,$currentYear);
   if($isDate){
       
   }else{
      $currentMonth =  date('m', strtotime('last month'));
      $currentYear = date('Y', strtotime('last month'));
      
   }
   
   $sql = "SELECT * FROM ledger WHERE `month`='{$currentMonth}' AND `year`='{$currentYear}'";
   $result = query($sql);
   $mysql_rows = $result->num_rows;
   $all_sav_cat = get_all_from_savings_cat();
   $data = array();
   foreach($all_sav_cat as $saveName){
	   $data[''.$saveName.''] = 0;
	   }
	   $data['loan'] = 0;
  
   for($i=$mysql_rows;$i<=$mysql_rows;$i++){
	   $rows = $result->fetch_array();
	  // print_r($rows);
	   foreach($all_sav_cat as $saveName){
		   $data[''.$saveName.''] += $rows[''.$saveName.''];
		   }
	       $data['loan'] += $rows['loan']; 
	   }
	return $data;
	

}
function selectAllUsername(){
	$sql = "SELECT * FROM users ORDER BY username DESC";
$result = query($sql);
$mysql_rows = $result->num_rows;
$usernames = array();
for($i=0;$i<$mysql_rows;$i++){
$row =$result->fetch_array();
$firstname = $row['firstname'];
$surname = $row['surname'];
$othername = $row['othername'];
$fullname = $surname." ".$firstname." ".$othername;
$username= $row['username'];
$usernames[] = $username;

}
return $usernames;
	}
function user_apply_form($username){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Apply loan</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="user_loan" onsubmit="submitform (document.getElementById(\'user_loan\'), \'catacata.php\', \'response\'); return false;" name="user_loan" >
<input type="hidden" name="username" value="'.$username.'" required/><div class="form-group">
                                            <label for="Interest Rate">Select Loan Category</label>';
                                           select_drop_down_user();
                                       echo ' </div>
									   <div class="form-group">
                                            <label for="Drop Down">Select Interest Rate </label>
                                           <div  id="amount_loan">
										   </div>
                                        </div>
										
										
										 <div class="box-footer">
                                        <input type="submit" name="apply_for_loan" value="Apply For Loan" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function this_is_for_payment($id){
$id = encoder($id);
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Make Payment as Loan Benefactor</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  >
<input type="hidden" name="id" value="'.$id.'" required/><div class="form-group">
                                            
									   <div class="form-group">
                                            <label for="Drop Down">Type Amount</label>
                                          <input type="number" min="0" name="amount" required class="form-control"/>
										   </div>
                                        </div>
										
										
										 <div class="box-footer">
                                        <input type="submit" name="make_loan_payment" value="Make Payment" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function getLoanDetailsOfId($id){
	$sql = "SELECT * FROM loan_apply WHERE `lapply_id`='{$id}'";
	$result = query($sql);
	$rows = $result->fetch_array();
	return $rows;
		}
function checkIfUserStillHasALoan($userUsername){
	$sql = "SELECT * FROM `loan_apply` WHERE `username`='{$userUsername}' AND `balance_debt`>0 AND `status`='approve'";
	$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
	}
function make_payment_db($id,$amount_now,$user_username,$admin_name,$timestamp,$balance_debt,$payment_amount,$purpose){
$sql = "INSERT INTO `payment_history` SET 
`username`='{$user_username}',
`amount`='{$amount_now}',
`admin_payer`='{$admin_name}',
`purpose`='{$purpose}',
`timestamp`='{$timestamp}'";
$result = query($sql);
if($result){
$sql = "UPDATE `loan_apply` SET 
`payment_amount`='{$payment_amount}',
`balance_debt`='{$balance_debt}' WHERE `lapply_id`='{$id}'";
$result = query($sql);

}else{
$result = false;
}
return $result;
} 
function selectLoanStatuses($username,$field){
	$sql = "SELECT count(*) as COUNT FROM `loan_apply` WHERE status='{$field}' AND username='{$username}'";
	$result = query($sql);
	$row = $result->fetch_array();
	$count = $row['COUNT'];
	return $count;
	}
	
function adminSelectLoanStatuses($field){
	$sql = "SELECT count(*) as COUNT FROM `loan_apply` WHERE status='{$field}'";
	$result = query($sql);
	$row = $result->fetch_array();
	$count = $row['COUNT'];
	return $count;
	}

function loanAmountPaid($username){
	$sql = "SELECT sum(balance_debt) as sum FROM `loan_apply` WHERE status='approve' AND username='{$username}'";
	$result = query($sql);
	$row = $result->fetch_array();
	
	$count = $row['sum'];
	if($count==""){
		$count = 0;
		}
	return $count;
	}
	function adminLoanAmountPaid(){
		$sql = "SELECT sum(balance_debt) as sum FROM `loan_apply` WHERE status='approve' ";
	$result = query($sql);
	$row = $result->fetch_array();
	
	$count = $row['sum'];
	if($count==""){
		$count = 0;
		}
	return $count;
		}

function update_all_loan_approve($username,$date_value,$id,$amount){
$sql = "UPDATE `loan_apply` SET 
`date_expire`='{$date_value}',
`amount_per_month`='{$amount}',
`status`='approve',
`approver`='{$username}' WHERE `lapply_id`='{$id}'";
$result = query($sql);
return $result;
}
function from_the_form(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Apply loan</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="user_loan"  onsubmit="submitform (document.getElementById(\'user_loan\'), \'../catacata.php\', \'response\'); return false;" name="user_loan">
<div class="form-group">
                                            <label for="User">Select User</label>
                                          ';
select_all_users();
echo '
										 </div><div class="form-group">
                                            <label for="Interest Rate">Select Loan category</label>';
                                           select_drop_down_new();
                                       echo ' </div>
									   <div class="form-group">
                                            <label for="Drop Down">Select Amount</label>
                                           <div  id="amount_loan">
										   </div>

                                        </div>
										
										
										 <div class="box-footer">
                                        <input type="submit" name="apply_for_loan" value="Apply For Loan" class="btn btn-primary"/>
                                    </div>

</form></div></div>';

}

function loan_date_display($id){
$id = encoder($id);
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Select Date of when Loan will expire</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="d"   name="user_loan">

					
									   <div class="form-group">
                                            <label for="Drop Down">Amount to be Paid Per Month</label>
                                           <input type="number" name="amount" class="form-control" required placeholder="Amount" />
										   </div>
									   <div class="form-group">
                                            <label for="Drop Down">Select End Date</label>
                                           <input type="date" name="date" format="mm/dd/yyyy" class="form-control" required placeholder="mm/dd/yyyy" />
										   </div>
                                        </div>
										<input type="hidden" name="id" value="'.$id.'" required />
										
										 <div class="box-footer">
                                        <input type="submit" name="approve_loan" value="Approve loan" class="btn btn-success"/>
                                    </div>

</form></div></div>';

}

function update_($id){
$row = get_all_interest($id);
$cat_name = $row['cat_name'];
$amount = $row['amount'];
$ids = encoder($id);
$interest_rate = $row['interest_rate'];
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Update Interest Rate</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="add_cat_int" onsubmit="submitform (document.getElementById(\'add_cat_int\'), \'../catacata.php\', \'response\'); return false;" name="add_cat_int" >
<input type="hidden" name="editMode" id="editMode" value="true"/>
									<div class="form-group">
                                            <label for="Loan Category">Loan\'s Category</label>
                                        <input type="text" class="form-control" name="cat_name" value="'.$cat_name.'" required readonly/>
										</div>
										<div class="form-group">
                                            <label for="Amount">Amount </label>
                                           <input type="number" class="form-control" name="amount"  placeholder="Amount" value="'.$amount.'" readonly/>
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Interest Rate">Interest Rate %</label>
                                           <input type="number" class="form-control" name="interest_rate" value="'.$interest_rate.'" placeholder="Interest Rate"  />
                                         
                                        </div>
										<input type="hidden" value='.$ids.' required name="id" />
										
										 <div class="box-footer">
                                        <input type="submit" name="update_interest_rate" value="Update Interest rate" class="btn btn-primary"/>
                                    </div>

</form></div></div>';

}

function send_sms($phone_number,$message){
$phone_number = format_phone($phone_number);
$ordinary = $message;
$message = urlencode($message);

$sender_id ="Cop Loan";
$id = '18012676';
$sender_id = urlencode($sender_id);
$id = urlencode($id);
$password = 'damilaregrace';
$file = @file_get_contents("http://developers.cloudsms.com.ng/api.php?userid=$id&password=$password&type=5&destination=$phone_number&sender=$sender_id&message=$message");
//echo 'This is the file'.$file;
$new_answer = strpos($file,"101");
if($new_answer !== false){
$status = "Message Sent";
}else{
$status = "Message Not Sent";
}
$current_timestamp = time();
$today = date('F,j,Y, g:ia');

$sql ="INSERT INTO `sms_tracker` SET 
`phone_number`='{$phone_number}',
`message`='{$ordinary}',
`status`='{$status}',
`date`='{$today}',
`timestamp`='{$current_timestamp}'";
query($sql);
}
function ordinary_db_input_sms($phone_number,$message,$file){
	$sms_message = urldecode($message);
$phone_number = format_phone($phone_number);
$new_answer = strpos($file,"101");
if($new_answer !== false){
$status = "Message Sent";
}else{
$status = "Message Not Sent";
}
$current_timestamp = time();
$today = date('F,j,Y, g:ia');

$sql ="INSERT INTO `sms_tracker` SET 
`phone_number`='{$phone_number}',
`message`='{$sms_message}',
`status`='{$status}',
`date`='{$today}',
`timestamp`='{$current_timestamp}'";
query($sql);


}

function add_category_savings($cat_name,$description,$def_amount,$start_date,$end_date,$username){
$sql = "INSERT INTO `savings` SET
`save_name`='{$cat_name}',
`save_description`='{$description}',
`save_def_amount`='{$def_amount}',
`save_start_date`='{$start_date}',
`save_end_date` = '{$end_date}',
`created_by`='{$username}'";
$result = query($sql);
//echo $sql;
return $result;
}
function get_all_from_savings_cat(){
$sql = "SELECT * FROM `savings` ";
$result = query($sql);
$savings  = array();
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$cat_name = trim($row['save_name']);
$savings[] = $cat_name;
}
return $savings;
}
function get_all_from_savings_with_id($id){
$sql = "SELECT * FROM savings WHERE save_id='{$id}'";
$result = query($sql);
$row = $result->fetch_array();
return $row;
}
function update_this_new_savings($new_value,$save_name,$username){
$sql = "UPDATE `users` SET  `$save_name`='{$new_value}' WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}
function view_all_savings_category(){
$sql = "SELECT * FROM savings";
$result = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box-header" style="width:90% !important;margin:0 auto !important;">
                                    <h3 class="box-title">View Savings</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:90% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Name</th>
											<th>Description</th>
											<th>Default Amount</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Created by</th>
											<th>Edit</th>
											<th>Delete</th>
										                                            </tr>
                                        </thead>
                                        <tbody>';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['save_id'];
$links = encoder($id);
$save_name = $row['save_name'];
$save_description = $row['save_description'];
$save_start_date = $row['save_start_date'];
$save_end_date = $row['save_end_date'];
$created_by = $row['created_by'];
$save_def_amount = number_format($row['save_def_amount']);
$linker = "<a href='?edit_link_savings=".$links."'>Edit</a>";
$del = "<a href='?del_savings=".$links."' onclick='return sure_del();'>Delete</a>";
echo '<tr>
<td>'.$save_name.'</td>
<td>'.$save_description.'</td>
<td align="right">'.$save_def_amount.'</td>
<td>'.$save_start_date.'</td>
<td>'.$save_end_date.'</td>
<td>'.$created_by.'</td>
<td>'.$linker.'</td>
<td>'.$del.'</td>
</tr>';

}

echo '</tbody>
                                        <tfoot>
                                             <tr>
											<th>Name</th>
											<th>Description</th>
											<th>Default Amount</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Created by</th>
											<th>Edit</th>
											<th>Delete</th>
										                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function show_us_form_savings($decoder,$username){
$sql = "SELECT * FROM users WHERE username='{$username}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
$value = $row[$decoder];
echo '<div class="box box-primary" style="width:50%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">'.$decoder.'\'s Savings Setting</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post">
<div class="form-group">
                                            <label for="Savings">Savings Value</label>
                                            <input type="number" name="push_push"  value="'.$value.'" required placeholder="" min="0" class="form-control"/>
                                            <input type="hidden" name="save_name" value="'.$decoder.'" required/>
                                        </div>
									

									 <div class="box-footer">
                                        <input type="submit" name="saver_setting" value="Update Settings" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function get_sav_from_db($username){
$savings =  get_all_from_savings_cat();
$sql = "SELECT * FROM users WHERE username='{$username}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
$mysql_rows = $result->num_rows;
echo '<div class="box-header" style="width:90% !important;margin:0 auto !important;">
                                    <h3 class="box-title" >Savings Setting</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:90% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Name</th>
											<th>Monthly Deduct</th>
											<th>Edit</th>
										                                            </tr>
                                        </thead>
                                        <tbody>';
foreach($savings as $save){
$value = $row[$save];
$editlink  = encoder($save);
$link = "<a href='?edit_savings=".$editlink."'>Edit</a>";
echo '<tr>
<th>'.$save.'</th>
<th align="right">'.$value.'</th>
<th>'.$link.'</th>
</tr>';
}
								

echo '</tbody>
                                        <tfoot>
                                            <tr>
											
											<th>Name</th>
											<th>Monthly Deduct</th>		
<th>Edit</th>											
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function select_distinct_dates(){
$sql = "SELECT * FROM ledger";
$result = query($sql);
$dates = array();
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$month = $row['month'];
$year = $row['year'];
$dater = $month."/".$year;
$dates[] = $dater;

}
$datest = array_unique($dates);
return $datest;
}


	
	
	
	
function currentMonthLedgerData($username){
    $timestamp = time();
    $currentMonth = date("m",$timestamp);
    $currentYear = date("Y",$timestamp);
    
   $isDate = check_for_month_year($currentMonth,$currentYear);
   if($isDate){
       
   }else{
      $currentMonth =  date('m', strtotime('last month'));
      $currentYear =   date('Y', strtotime('last month'));
      
   }
   
   $result = selectAllCurrentMonth($currentMonth,$currentYear,$username);
   return $result;
   
    
}


function selectAllCurrentMonth($month,$year,$username){
    $sql = "SELECT * FROM ledger WHERE `month`='{$month}' AND `year`='{$year}' AND `username`='{$username}'";
    $result = query($sql);
    $row = $result->fetch_array();
    return $row;
}

function selectAllSavingsHere($username){
	$sql = "SELECT * FROM ledger WHERE username='{$username}'";
	$result = query($sql);
	$mysql_rows = $result->num_rows;
	$all_sav_cat = get_all_from_savings_cat();
	$saveTotal = 0;
	for($i=0;$i<$mysql_rows;$i++){
		$row = $result->fetch_array();
		foreach($all_sav_cat as $savingsName){
			$saveTotal += $row[''.$savingsName.''];
			}
		
		}
		
		return $saveTotal;
	}
	
	function adminSelectAllSavingsHere(){
		$sql = "SELECT * FROM ledger";
	$result = query($sql);
	$mysql_rows = $result->num_rows;
	$all_sav_cat = get_all_from_savings_cat();
	$saveTotal = 0;
	for($i=0;$i<$mysql_rows;$i++){
		$row = $result->fetch_array();
		foreach($all_sav_cat as $savingsName){
			$saveTotal += $row[''.$savingsName.''];
			}
		
		}
		
		return $saveTotal;
		}
function generate_ledger_for_this_month($month,$year,$day,$admin_user){
$date = $year.'-'.$month.'-'.$day;
$sql = "SELECT * FROM users";
$result  = query($sql);
$mysql_rows = $result->num_rows;
$name = array();
$value = array();
$all_sav_cat = get_all_from_savings_cat();
for($i=0;$i<$mysql_rows;$i++){	
$row = $result->fetch_array();

$username = $row['username'];
$record = insert_new_ledger_record($username,$month,$year,$admin_user);
$savings = get_all_loans_deduction($username,$date);
update_category("loan",$savings,$username,$month,$year);
$name[$username][] = "Loans";
if(checkUserLoanApply($username)){
make_loan_payment_user($username,$month,$year,$admin_user);
}
$value[$username][] = $savings; 
foreach($all_sav_cat as $save_name){
$name[$username][] = $save_name;
$content = get_the_value_savings($save_name,$username);
$saved = update_category($save_name,$content,$username,$month,$year);
$value[$username][] = $content;
}


}
return $record;
//print_r($name);
//echo '<br/><br/>';
//print_r($value);
}

function insert_new_ledger_record($username,$month,$year,$admin_user){
$sql = "INSERT INTO `ledger` SET 
`username`='{$username}',
`month`='{$month}',
`year`='{$year}',
`generated_by`='{$admin_user}'";
$result = query($sql);
return $result;
}
function checkUserLoanApply($username){
	$sql = "SELECT * FROM `loan_apply_view` WHERE `status`='approve' AND `username`='{$username}' AND `balance_debt`>0";
	$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
	}
function make_loan_payment_user($username,$month,$year,$admin_user){
$sql = "SELECT * FROM `loan_apply_view` WHERE status='approve' AND username='{$username}' AND `balance_debt`>0";
//echo $sql."<br/>";
$result = query($sql);

$mysql_rows = $result->num_rows;

for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
//print_r($row);
//echo '<br/>';
$id = $row['lapply_id'];
$amount_now = $row['amount_per_month'];
$user_username = $row['username'];
$rec = $row['username'];
$cat_name = $row['cat_name'];
$admin_name = $admin_user;
$admin  = get_details_admin_username($admin_user);
$fullname = $admin['fullname'];
$balance_debt = $row['balance_debt'];
$payment_amount = $row['payment_amount'];
$phone_number = $row['phone_number'];
$balance_debt = $balance_debt - $amount_now;
$timestamp = time();
$subject = "Loan Payment";
$message = "Admin ".$fullname ." has generated monthly ledger and &#8358 ".number_format($amount_now)." payment on your behalf for your ".$cat_name." loan via monthly payback";
$smsMessage = "Admin ".$fullname ." has generated monthly ledger and N".number_format($amount_now)." payment on your behalf for your ".$cat_name." loan via monthly payback";
$payment_amount  = $payment_amount + $amount_now;
$filepath = "";
$flag = 0;
$purpose = "Loan Payment";
$result = make_payment_db($id,$amount_now,$user_username,$admin_name,$timestamp,$balance_debt,$payment_amount,$purpose);
if($result){
send_message_to($admin_name,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);
send_sms($phone_number,$smsMessage);

}else{


}
}




}
function update_category($save_name,$savings,$username,$month,$year){
$sql  = "UPDATE ledger SET `$save_name`='{$savings}' WHERE `username`='{$username}' AND `month`='{$month}' AND `year`='{$year}'";
$result = query($sql);
return $result;
}
function get_the_value_savings($save_name,$username){
$sql  = "SELECT `$save_name` FROM users WHERE `username`='{$username}'";
$result = query($sql);
$row = $result->fetch_array();
$value = $row[$save_name];
return $value;
}
function get_all_loans_deduction($username,$date){

$sql = "SELECT SUM(amount_per_month) as sum FROM loan_apply WHERE `status`='approve' AND `balance_debt`>0 AND `username`='{$username}'";
$result  = query($sql);
$row = $result->fetch_array();
//print_r($row);
$sum = $row['sum'];
if($sum==""){
$sum = 0;
}
return $sum;
}
function payment_history($username){
if($username==""){
$sql = "SELECT * FROM `payment_history`";
}else{
$sql = "SELECT * FROM `payment_history` WHERE `username`='{$username}'";
}
$result = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box-header" style="width:90% !important;margin:0 auto !important;">
                                    <h3 class="box-title">Payment History</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:90% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>ID</th>
											<th>Username</th>
											<th>Amount ( &#8358 ) </th>
											 <th>Payment Title</th>
                                                <th>Admin Payer</th>
												
												<th>Date of Payment</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['pay_id'];
$amount = $row['amount'];
$username  = $row['username'];
$admin_payer = $row['admin_payer'];
$timestamp = $row['timestamp']; 
$purpose = $row['purpose'];
$timer  = date("h:i A, M j, Y",$timestamp);
echo '<tr>
											
											<td>'.$id.'</td>
											<td>'.$username.'</td>
											<td align="right">'.number_format($amount).'</td>
											 <td>'.$purpose.'</td>
                                                <td>'.$admin_payer.'</td>
												
												<td>'.$timer.'</td>									 
                                            </tr>';
}
echo '</tbody>
                                        <tfoot>
                                            <tr>
											
											<th>ID</th>
											<th>Username</th>
											<th>Amount ( &#8358 ) </th>
											 <th>Payment Title</th>
                                                <th>Admin Payer</th>
												
												<th>Date of Payment</th>									 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}

function all_lona_look_up(){
$sql = "SELECT * FROM loan_apply_view ORDER BY lapply_id DESC";
echo '<div class="box-header" style="width:90% !important;margin:0 auto !important;">
                                    <h3 class="box-title">Loan Look Up</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:90% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>ID</th>
											<th>Fullname</th>
											<th>Username</th>
											 
                                                <th>Category</th>
												<th>Amount ( &#8358 ) </th>
												<th>Interest Rate (%)</th>
												<th>Interest Amount ( &#8358 )</th>
												<th>Final Amount ( &#8358 )</th>
												<th>Date</th>
												<th>Action</th>
												<th>Debt Remaining ( &#8358 )</th>
												<th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
$result = query($sql);
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['lapply_id'];
$encoder = encoder($id);
$firstname = $row['firstname'];
$username = $row['username'];
$category = $row['cat_name'];
$surname = $row['surname'];
$othername = $row['othername'];
$fullname = $surname." ".$firstname." ".$othername;
$amount  = number_format($row['amount']);
$interest_rate = $row['interest_rate'];
$interest_amount = number_format($row['interest_amount']);
$final_amount  = number_format($row['final_amount']);
$timestamp = $row['timestamp'];
$date  = date("m M,Y h:ia",$timestamp);
$status = $row['status'];
$balance_debt = number_format($row['balance_debt']);
$payment_amount = number_format($row['payment_amount']);
$date_expire = $row['date_expire'];
$approver = $row['approver'];
$now_date = date('Y-m-d');
if($date_expire==$now_date){
$expiring= "Loan payment will expire today";
}
else if($date_expire<$now_date){
$expiring= "Loan payment has expired on ".$date_expire;
}
else{
$expiring = "Loan payment will expire on ".$date_expire;
}
if($balance_debt<=0){
$pay_in = "Loan Cleared";
}else{
$pay_in = "<a href='?make_payment=".$encoder."' class='btn btn-xs btn-primary' title='Make Payment'><i class='fa fa-money'></i></a>";

}
$title = "";
$word2 = "";
$approved_by = "";
if($status=="approve"){
$class= "success";
$word = "Approved";
$words = "Approved";
$approved_by = "Approved by: ".$approver;
$title = "Loan expires on ".$date_expire;
//$make_payment = "<a href='?loan_approve=".$encoder."' class='btn btn-small btn-success' title='Approve'><i class='fa fa-check'></i></a>";
}

else {
 if($status=="pending"){
$class = "warning";
$words = "Pending";
$pay_in = "Not Approved";
$expiring = "";
$word2 = "<a href='?loan_decline=".$encoder."' class='btn btn-xs btn-danger' title='Decline' onclick='return sure_decline();'><i class='fa fa-ban'></i></a>";
}
else if($status=="decline"){
$class = "danger";
$words = "Declined";
$pay_in = "Not Approved";
$expiring = "";
}
$word = "<a href='?loan_approve=".$encoder."' class='btn btn-xs btn-success' title='Approve'><i class='fa fa-check'></i></a>";

}
$join = $word." ".$word2;
$title="Payment Made &#8358".$payment_amount.". ".$expiring;
echo '<tr class="'.$class.'" title="'.$words.'">
<td>'.$id.'</td>
<td>'.$fullname.'</td>
<td>'.$username.'</td>
<td>'.$category.'</td>
<td align="right">'.$amount.'</td>
<td align="right">'.$interest_rate.'</td>
<td align="right">'.$interest_amount.'</td>
<td align="right">'.$final_amount.'</td>
<td>'.$date.'</td>
<td title="'.$approved_by.'">'.$join.'</td>
<td title="'.$title.'" align="right">'.$balance_debt.'</td>
<td>'.$pay_in.'</td>
</tr>';
}


echo '</tbody>
                                        <tfoot>
                                            <tr>
											
											<th>ID</th>
											<th>Fullname</th>
											<th>Username</th>
											 
                                                <th>Category</th>
												<th>Amount ( &#8358 )</th>
												<th>Interest Rate (%)</th>
												<th>Interest Amount ( &#8358 )</th>
												<th>Final Amount ( &#8358 )</th>
												<th>Date</th>
												<th>Action</th>
												<th>Debt Remaining ( &#8358 ) </th>
                                            	<th>Status</th>											 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}

//----------------this is the part that will be in the cron job -------------//
function checl_loans_mail(){
$sql = "SELECT * FROM loan_apply_view ORDER BY lapply_id DESC";
$result = query($sql);
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['lapply_id'];
$encoder = encoder($id);
$firstname = $row['firstname'];
$username = $row['username'];
$category = $row['cat_name'];
$surname = $row['surname'];
$othername = $row['othername'];
$fullname = $surname." ".$firstname." ".$othername;
$amount  = $row['amount'];
$interest_rate = $row['interest_rate'];
$interest_amount = $row['interest_amount'];
$final_amount  = $row['final_amount'];
$timestamp = $row['timestamp'];
$date  = date("m M,Y h:ia",$timestamp);
$status = $row['status'];
$balance_debt = $row['balance_debt'];
$date_expire = $row['date_expire'];
$rec = $row['username'];
$subject = "Loan Expiration Alert!";
$payment_amount = $row['payment_amount'];
$phone_number = $row['phone-number'];
$approver = $row['approver'];
$now_date = date('Y-m-d');
$flag = 0;
$filepath = "";
$timestamp = time();
if($date_expire==$now_date){
$message= "Loan payment will expire today";
send_message_to("john","Ojetunde John Oluwadamilare",$rec,$subject,$message,$filepath,$flag,$timestamp);
send_sms($phone_number,$message);
}
else if($date_expire<$now_date){
$message= "Loan payment has expired on ".$date_expire;

send_message_to("john","Ojetunde John Oluwadamilare",$rec,$subject,$message,$filepath,$flag,$timestamp);
send_sms($phone_number,$message);
}

}
}
function loan_look_up($username){

$sql = "SELECT * FROM  `loan_apply_view` WHERE `username`= '{$username}'";
echo '<div class="box-header" style="width:95% !important;margin:0 auto !important;">
                                    <h3 class="box-title">Loan Look Up <caption><i>(date format is yyyy-mm-dd for loan expiring date)</i></caption></h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:95% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>ID</th>
											<th>Fullname</th>
											<th>Username</th>
											 
                                                <th>Category</th>
												<th>Amount ( &#8358 )</th>
												<th>Interest Rate (%)</th>
												<th>Interest Amount ( &#8358 )</th>
												<th>Final Amount ( &#8358 )</th>
												<th>Date</th>
												<th>Approval Status</th>
												<th>Debt Remaining ( &#8358 )</th>
												<th>Payment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
$result = query($sql);
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['lapply_id'];
$encoder = encoder($id);
$firstname = $row['firstname'];
$username = $row['username'];
$category = $row['cat_name'];
$surname = $row['surname'];
$othername = $row['othername'];
$fullname = $surname." ".$firstname." ".$othername;
$amount  = $row['amount'];
$interest_rate = $row['interest_rate'];
$interest_amount = $row['interest_amount'];
$final_amount  = $row['final_amount'];
$timestamp = $row['timestamp'];
$date  = date("m M,Y h:ia",$timestamp);
$status = $row['status'];
$balance_debt = $row['balance_debt'];
$date_expire = $row['date_expire'];
$payment_amount = $row['payment_amount'];
$approver = $row['approver'];
$now_date = date('Y-m-d');
if($date_expire==$now_date){
$expiring= "Loan payment will expire today";
}
else if($date_expire<$now_date){
$expiring= "Loan payment has expired on ".$date_expire;
}
else{
$expiring = "Loan payment will expire on ".$date_expire;
}
if($balance_debt<=0){
$pay_in = "Loan Cleared";
}else{
$pay_in = "Servicing";

}
$title = "";
$approved_by = "";
if($status=="approve"){
$class= "success";
$word = "Approved";
$approved_by = "Approved by: ".$approver;
$title = "Loan expires on ".$date_expire;
}

else {
 if($status=="pending"){
$class = "warning";
$word = "Pending";
$pay_in = "Not Approved";
$expiring = "";
}
else if($status=="decline"){
$class = "danger";
$word = "Declined";
$pay_in = "Not Approved";
$expiring = "";
}
}
echo '<tr class='.$class.'>
<td>'.$id.'</td>
<td>'.$fullname.'</td>
<td>'.$username.'</td>
<td>'.$category.'</td>
<td align="right">'.$amount.'</td>
<td align="right">'.$interest_rate.'</td>
<td align="right">'.$interest_amount.'</td>
<td align="right">'.$final_amount.'</td>
<td>'.$date.'</td>
<td title="'.$approved_by.'">'.$word.'</td>
<td title="'.$expiring."' Payment Made &#8358 '".$payment_amount.'" align="right">'.$balance_debt.'</td>
<td>'.$pay_in.'</td>
</tr>';
}


echo '</tbody>
                                        <tfoot>
                                            <tr>
											
											<th>ID</th>
											<th>Fullname</th>
											<th>Username</th>
											 
                                                <th>Category</th>
												<th>Amount ( &#8358 )</th>
												<th>Interest Rate (%)</th>
												<th>Interest Amount ( &#8358 )</th>
												<th>Final Amount ( &#8358 )</th>
												<th>Date</th>
												<th>Approval Status</th>
												<th>Debt Remaining ( &#8358 )</th>
												<th>Payment Status</th>								 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function view_interest_rate(){
$sql  = "SELECT rate_id,amount,interest_rate,cat_name FROM loan_interest_rate left join `loan_categ` on loan_cat_id=loan_categid ";
$result = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box-header" style="width:95% !important;margin:0 auto !important;">
                                    <h3 class="box-title">View Interest Rate</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:95% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Category Name</th>
											<th>Amount ( &#8358 )</th>
											<th>Interest Rate (%)</th>
											 
                                                <th>Edit</th>
												<th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$amount = $row['amount'];
$rate_id = $row['rate_id'];
$interest_rate = $row['interest_rate'];
$cat_name = $row['cat_name'];
$encoded = encoder($rate_id);
$del = "<a href='?del_rate=".$encoded."' onclick='return sure_del_cat_rate();'>Delete</a>";
$edit = "<a href='?edit_rate=".$encoded."'>Edit</a>";
echo '<tr>
<td>'.$cat_name.'</td>
<td align="right">'.number_format($amount).'</td>
<td align="right">'.$interest_rate.'</td>
<td>'.$edit.'</td>
<td>'.$del.'</td>

</tr>';
}

echo '</tbody>
                                        <tfoot>
                                            <tr>
											
											<th>Category Name</th>
											<th>Amount ( &#8358 )</th>
											<th>Interest Rate (%)</th>
											 
                                                <th>Edit</th>
												<th>Delete</th>
                                            												 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';

}
function is_student_email($email){
$sql = "SELECT * FROM `users` WHERE `email`='{$email}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function check_amount_id($cat_id,$amount){
$sql = "SELECT * FROM `loan_interest_rate` WHERE `amount`='{$amount}' && `loan_categid`='{$cat_id}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function is_student_reg_before($matric){
$sql = "SELECT * FROM `users` WHERE `surname`!='' && `firstname`!=''  && `email`!='' && `matric`='{$matric}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function check_if_category($cat){
$sql = "SELECT * FROM `loan_categ` WHERE `cat_name`='{$cat}' ";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function check_if_category_id($cat,$id){
$sql = "SELECT * FROM `loan_categ` WHERE `cat_name`='{$cat}' && `loan_cat_id`!='{$id}' ";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function check_id_loan_cat($id){
$sql = "SELECT * FROM `loan_categ` WHERE `loan_cat_id`='{$id}' ";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function update_category_name($id,$cat_name,$description){
$sql = "UPDATE `loan_categ` SET 
`cat_name`='{$cat_name}',
`description`='{$description}' WHERE `loan_cat_id`='{$id}'";
$result = query($sql);
return $result;
}
function delete_cat($id){
$sql = "DELETE FROM `loan_categ` WHERE `loan_cat_id`='{$id}'";
$result = query($sql);
return $result;
}
function insert_new_loan_cat($cat,$description,$timestamp){
$sql = "INSERT INTO `loan_categ` SET 
`cat_name`='{$cat}',
`description`='{$description}',
`timestamp`='{$timestamp}'";
$result = query($sql);
return $result;
}
function forgot_pass_check($username,$email){
$sql = "SELECT * FROM `users` WHERE `username`='{$username}' && `email`='{$email}'";
$result = query($sql);
return($result->num_rows > 0 ) ? true : false;
}
function update_record_email($username,$pass){
$sql = "UPDATE `users` SET `password`='{$pass}' WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}
function check_user_log_in_him($username,$password){
$sql = "SELECT * FROM `users` WHERE `username`='{$username}' && `password`='{$password}'";
$result = query($sql);
return($result->num_rows > 0 ) ? true : false;

}

function update_student_reg($surname,$firstname,$other_name,$gender,$phone_number,$username,$pass,$email,$timestamp){
$sql = "INSERT INTO `users` SET
`surname`='{$surname}',
`firstname`='{$firstname}',
`othername`='{$other_name}',
`gender`='{$gender}',
`phone_number`='{$phone_number}',
`username`='{$username}',
`password`='{$pass}',
`email`='{$email}',
`status`='activate',
`presence`='false',
`timestamp`='{$timestamp}'";
$result = query($sql);
return $result;

}
function is_student_username($username){
$sql = "SELECT * FROM `users` WHERE  `username`='{$username}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function is_user_exists($username,$pword){
$sql = "SELECT * FROM `users` WHERE `username`='{$username}' && `password`='{$pword}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
		
		//---------------------------------------------- this is the form section---------------------------------------------//

		
		function forgot_password(){
		echo ' <div class="form-box" id="login-box">
            <div class="header">E-Library Forgot Password</div>
            <form action="" method="post" id="pass_reset" onsubmit="submitform (document.getElementById(\'pass_reset\'), \'catacata.php\', \'response\'); return false;" name="pass_reset">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" required class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" required class="form-control" placeholder="Email"/>
                    </div> 
					
                  
                </div>
                <div class="footer">                                                               
                    <button type="submit" name="resetp_email" class="btn bg-light-blue btn-block">Reset Password</button>  
                    
                    <p><a href="index.php">Log In</a> | &nbsp;&nbsp;&nbsp;&nbsp; <a href="">Admin</a></p> 
                    
                    <a href="?register" class="text-center">Register a new membership</a>
                </div>
            </form>

            <div class="margin text-center">
                

            </div>
        </div>
';	
		}
	function user_general_log_in_form(){
	echo ' <div class="form-box" id="login-box">
            <div class="header">Cop App Sign In</div>
            <form action="" method="post" id="log_in" onsubmit="submitform (document.getElementById(\'log_in\'), \'catacata.php\', \'response\'); return false;" name="log_in">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" required class="form-control" placeholder="Username"/>
                    </div>
					
                    <div class="form-group">
                        <input type="password" name="password" required class="form-control" placeholder="Password"/>
                    </div> 

                    			
                    
                </div>
                <div class="footer">                                                               
                    <button type="submit" name="sign_in_me" class="btn bg-light-blue btn-block">Sign me in</button>  
                    
                    <p><a href="?forgot_pass">I forgot my password</a> | &nbsp;&nbsp;&nbsp;&nbsp; <a href="admin">Admin</a></p> 
                    
                    <a href="?register" class="text-center">Register a new membership</a>
                </div>
            </form>

            <div class="margin text-center">
                

            </div>
        </div>
';	
		
		}
		
		function formatSMSNumber($tel){
			$first_numbers = substr($tel,0,3);
if($first_numbers!='234'){
$tel = '234'.substr($tel,1,11);
			}
			return $tel;
		}
		
		
		function sendSMS($sender_id,$tel,$message){
			$id = '18012676';
			$password = 'damilaregrace';
			$sender_id = urlencode($sender_id);
            $password = $password;
            $id = urlencode($id);
			$tel = formatSMSNumber($tel);
            $message = urlencode($message);
//echo $word;
//$word = urlencode($word);
 //header("Location: http://developers.cloudsms.com.ng/api.php?userid=$id&password=$password&type=5&destination=$word&sender=$sender_id&message=$message");
$file = @file_get_contents("http://developers.cloudsms.com.ng/api.php?userid=$id&password=$password&type=5&destination=$tel&sender=$sender_id&message=$message");

$new_answer = trim($file);

//echo $new_answer;
if($new_answer=="101"){
return true;
}else{
return false;
}
$new_message = urldecode($message);
			}
		function the_registeration_form(){
		echo ' <div class="form-box" id="login-box">
            <div class="header">Register New Membership</div>
            <form action="" method="post" id="reg_form" onsubmit="submitform (document.getElementById(\'reg_form\'), \'catacata.php\', \'response\'); return false;" name="reg_form" enctype="multipart/form-data">
                <div class="body bg-gray">
				<details>
				<summary>Personal Information</summary>
                    <div class="form-group">
                        <input type="text" name="surname" required class="form-control" placeholder="Surname"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="firstname" required class="form-control" placeholder="First Name"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="other_name" required class="form-control" placeholder="Other Name"/>
                    </div>
					 <div class="form-group">
         <input type="radio" name="gender" value="Male"  required/> Male
		<input type="radio" name="gender" value="Female"  required/> Female
                    </div>
                  
					<span id="mat_id"></span>
					 <div class="form-group">
                        <input type="text" name="phone_number" class="form-control" required  placeholder="Phone Number"/>
                    </div>
					
					
					</details>
					<details>
				<summary>Log In Information</summary>
				<div class="form-group">
                        <input type="text" name="username" id="username"  onkeyup="check_function(\'username\',\'user_id\', \'catacata.php?check_username=\');" class="form-control" required placeholder="Username"/>
                    </div>
					<span id="user_id"></span>
					<div class="form-group">
                        <input type="email" name="email" id="email" onkeyup="check_function(\'email\',\'email_id\', \'catacata.php?check_email=\');" class="form-control" required placeholder="Email"/>
                    </div>
					<span id="email_id"></span>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" required placeholder="Password" id="pass" onkeyup="pmatch();"/>
                    </div>
					
                    <div class="form-group">
                        <input type="password" name="password2" class="form-control" required placeholder="Retype password" id="cpass" onkeyup="pmatch();"/>
                    </div>
					
					<span id="beside_pword"></span>
					
				</details>
                </div>
				
                <div class="footer">                    

                    <button type="submit" class="btn bg-olive btn-block" id="submit_button" name="sign_me_up">Create Account</button>
<button type="reset" class="btn bg-olive btn-block" id="reset_button" name="sign_me_up">Reset</button>

                    <a href="index.php" class="text-center">I already have a membership</a>  &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp; <a href="">Admin</a>
                </div>
            </form>

            <div class="margin text-center">
              

            </div>
        </div>
';
		}
		
		
		
		function forgot_pform(){
echo '
 <div class="form-box" id="login-box" style="opacity:1.0;">
            <div class="header" >PMS User Forgot Password</div>
            <form action="index.php" method="post" name="">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" required/>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required/>
                    </div>          
                   
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="forgot_p">Reset Password</button>  
                    
                     <p><a href="index.php">Student Log In</a></p>
                    <a href="admin/">Admin</a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="supervisor">Supervisor</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="register.php" class="text-center">Student Registration</a>
                </div>
            </form>

            
        </div>
';

}
function view_all_admin(){
$sql = "SELECT * FROM `admin` ORDER BY `adminid` DESC";
$result  = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box" style="width:95% !important;margin:0 auto !important;">
                                <div class="box-header">
                                    <h3 class="box-title">View Admin</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:95% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fullname</th>
                                                <th>Username</th>
                                                <th>Access Level</th>
												<th>Edit</th>
                                                                                            </tr>
                                        </thead>
                                        <tbody>';
for($i=0;$i<$mysql_rows;$i++){
$row  = $result->fetch_array();
$id = $row['adminid'];
$encoded = encoder($id);
$fullname = $row['fullname'];
$username = $row['username'];
$access_level = $row['access_level'];

echo '<tr>
                                                <td>'.$fullname.'</td>
                                                <td>'.$username.'</td>
                                                <td>'.$access_level.'</td>
                                                
                                                <td><a href="?edit_admin='.$encoded.'">Edit Profile</a></td>
                                            </tr>';
}
echo '</tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Fullname</th>
                                                <th>Username</th>
                                                <th>Access Level</th>
												<th>Edit</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function insert_new_admin($fullname,$username,$pword,$access_level,$time){
$sql = "INSERT INTO `admin` SET 
`fullname`='{$fullname}',
`username`='{$username}',
`password`='{$pword}',
`access_level`='{$access_level}',
`logged_in`='false',
`timestamp`='{$time}'";
$result = query($sql);
return $result;
}

function ucword($surname){
    $surname = strtolower($surname);
	$surname = ucfirst($surname);
	return $surname;
}
function admin_edit_details($id){
$sql = "SELECT * FROM `admin` WHERE `adminid`='{$id}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
return $row;
}
function is_admin_logged(){
if(isset($_SESSION['pms_admin_user']) && isset($_SESSION['pms_admin_role'])){
return true;
}
else{
return false;
}

}
function insert_updated_admin_record($adminid,$fullname,$username,$access_level,$pword){
$sql = "UPDATE `admin` SET 
`fullname`='{$fullname}',
`username`='{$username}',
`password`='{$pword}',
`access_level`='{$access_level}' WHERE `adminid`='{$adminid}'";
$result = query($sql);
return $result;
}
function student_book_view(){
$sql = "SELECT * FROM `book`";
$result = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">View Books</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Book\'s Name</th>
											<th>Book\'s Author</th>
											<th>Book\'s Print Year</th>
											 <th>Book\'s ISBN/ISSN</th>
                                                <th>Book\'s Location</th>
												<th>Book\'s Copies</th>
												<th>Book\'s State</th>
												
												</tr>
                                        </thead>
                                        <tbody>';
										
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['bk_id'];
$book_name = stripslashes($row['book_name']);
$book_author = stripslashes($row['book_author']);
$book_print_year = stripslashes($row['book_print_year']);
$book_isbn = stripslashes($row['book_isbn']);
$book_location = stripslashes($row['book_location']);
$book_copies = stripslashes($row['book_copies']);
$book_state = stripslashes($row['book_status']);
$timestamp = stripslashes($row['timestamp']);
$date =  date("F j, Y",$timestamp);
$encoded = encoder($id);


echo '<tr>
<td>'.$book_name.'</td>
<td>'.$book_author.'</td>
<td>'.$book_print_year.'</td>
<td>'.$book_isbn.'</td>
<td>'.$book_location.'</td>
<td>'.$book_copies.'</td>
<td>'.$book_state.'</td>


</tr>';


}

echo '</tbody>
                                        <tfoot>
                                             <tr>
											<th>Book\'s Name</th>
											<th>Book\'s Author</th>
											<th>Book\'s Print Year</th>
											 <th>Book\'s ISBN/ISSN</th>
                                                <th>Book\'s Location</th>
												<th>Book\'s Copies</th>
												<th>Book\'s State</th>
												
												</tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function access_books(){
$sql = "SELECT * FROM `book`";
$result = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">View All Books</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Book\'s Name</th>
											<th>Book\'s Author</th>
											<th>Book\'s Print Year</th>
											 <th>Book\'s ISBN/ISSN</th>
                                                <th>Book\'s Location</th>
												<th>Book\'s Copies</th>
												<th>Book\'s State</th>
												<th>Date Stocked</th>
												<th>Edit</th>
												</tr>
                                        </thead>
                                        <tbody>';
										
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['bk_id'];
$book_name = stripslashes($row['book_name']);
$book_author = stripslashes($row['book_author']);
$book_print_year = stripslashes($row['book_print_year']);
$book_isbn = stripslashes($row['book_isbn']);
$book_location = stripslashes($row['book_location']);
$book_copies = stripslashes($row['book_copies']);
$book_state = stripslashes($row['book_status']);
$timestamp = stripslashes($row['timestamp']);
$date =  date("F j, Y",$timestamp);
$encoded = encoder($id);


echo '<tr>
<td>'.$book_name.'</td>
<td>'.$book_author.'</td>
<td>'.$book_print_year.'</td>
<td>'.$book_isbn.'</td>
<td>'.$book_location.'</td>
<td>'.$book_copies.'</td>
<td>'.$book_state.'</td>
<td>'.$date.'</td>
<td><a href="?edit_book='.$encoded.'">Edit</a</td>
</tr>';


}

echo '</tbody>
                                        <tfoot>
                                             <tr>
											<th>Book\'s Name</th>
											<th>Book\'s Author</th>
											<th>Book\'s Print Year</th>
											 <th>Book\'s ISBN/ISSN</th>
                                                <th>Book\'s Location</th>
												<th>Book\'s Copies</th>
												<th>Book\'s State</th>
												<th>Date Stocked</th>
												<th>Edit</th>
												</tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function update_parse_data($username,$surname,$firstname,$othername,$phone_number,$address){
$sql = "UPDATE `users` SET
`surname`='{$surname}',
`firstname`='{$firstname}',
`othername`='{$othername}',
`phone_number`='{$phone_number}',
`address`='{$address}' WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}
function format_phone($phone_number){

$first_numbers = substr($phone_number,0,3);
if($first_numbers!='234'){
$phone_number = '234'.substr($phone_number,1,11);
}
return $phone_number;
}

function get_passport_username($username){
$sql = "SELECT passport FROM `users` WHERE `username`='{$username}' ";
$result = query($sql);
$row = $result->fetch_array();
$passport  = $row['passport'];
return $passport;
}

function getTotalSavingsCategory($username){
$savings = get_all_from_savings_cat();
$count  = 0;
$userDetails = get_details_user($username);
foreach($savings as $save_name){
if($userDetails[''.$save_name.''] > 0){
$count++;
}
}
return $count;
}

function select_drop_down(){
$sql = "SELECT * FROM `loan_categ` ORDER BY `cat_name` DESC";
$result = query($sql);
echo '<select name="loan_cat" required class="form-control">
<option value="">-- choose --</option>
';
$mysql_num_rows = $result->num_rows;
for($i=0;$i<$mysql_num_rows;$i++){
$row = $result->fetch_array();
$cat_name = stripslashes($row['cat_name']);
$id = stripslashes($row['loan_cat_id']);
echo '<option value="'.$id.'">'.$cat_name.'</option>';

}
echo '</select>';
}
function bring_other_part($id){
$sql = "SELECT * FROM `loan_interest_rate` WHERE `loan_categid`='{$id}'";
$result = query($sql);
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$rate_id = $row['rate_id'];
$amount = $row['amount'];
$interest_rate = $row['interest_rate'];
$rate = $amount.":".$interest_rate;
echo '<option value="'.$rate.'">  '.number_format($amount).'----@'.$interest_rate.'%</option>';
}

}

function insert_new_loan_apply($username,$loan_category,$amount,$interest_rate,$interest,$expected_amount,$timestamp){
$sql = "INSERT INTO `loan_apply` SET 
`username`='{$username}',
`loan_categid`='{$loan_category}',
`amount`='{$amount}',
`interest_rate`='{$interest_rate}',
`interest_amount`='{$interest}',
`final_amount`='{$expected_amount}',
`timestamp`='{$timestamp}',
`status`='pending',
`balance_debt`='{$expected_amount}'";
$result = query($sql);
return $result;

}
function decline_this_loan($id){
$sql = "UPDATE loan_apply SET `status`='decline' WHERE `lapply_id`='{$id}'";
$result = query($sql);
return $result;
}
function  select_return_id($id){
$sql = "SELECT * FROM `loan_apply_view` WHERE lapply_id='{$id}'";

$result = query($sql);
$row = $result->fetch_array();
return $row;
}
function select_drop_down_user(){
$sql = "SELECT * FROM `loan_categ` ORDER BY `cat_name` DESC";
$result = query($sql);
echo '<select name="loan_cat" required class="form-control" onchange="on_select_here(\'categ\',\'amount_loan\',\'catacata.php\')" id="categ">
<option value="">-- choose --</option>
';
$mysql_num_rows = $result->num_rows;
for($i=0;$i<$mysql_num_rows;$i++){
$row = $result->fetch_array();
$cat_name = stripslashes($row['cat_name']);
$id = stripslashes($row['loan_cat_id']);
echo '<option value="'.$id.'">'.$cat_name.'</option>';

}
echo '</select>';
}
function select_drop_down_new(){
$sql = "SELECT * FROM `loan_categ` ORDER BY `cat_name` DESC";
$result = query($sql);
echo '<select name="loan_cat" required class="form-control" required onchange="on_select_here(\'categ\',\'amount_loan\',\'../catacata.php\')" id="categ">
<option value="">-- choose --</option>
';
$mysql_num_rows = $result->num_rows;
for($i=0;$i<$mysql_num_rows;$i++){
$row = $result->fetch_array();
$cat_name = stripslashes($row['cat_name']);
$id = stripslashes($row['loan_cat_id']);
echo '<option value="'.$id.'">'.$cat_name.'</option>';

}
echo '</select>';
}

function view_cat(){
$sql = "SELECT * FROM `loan_categ` ORDER BY `timestamp` DESC";
$result  = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Loan Categories</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Category</th>
											<th>Description</th>
										
												 <th>Edit</th>
												 <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
for($i=0;$i<$mysql_rows;$i++){
$row  = $result->fetch_array();
$id = $row['loan_cat_id'];
$encoded = encoder($id);

$cat_name  = $row['cat_name'];
$description= $row['description'];

$timestamp = $row['timestamp'];

$time = time();
$date =  date("F j, Y",$timestamp);
$w_link = "<a href='?bush_cat_loan=".$encoded."&res=kusdgure8874&token=msjhj786438934'>Edit</a>"; 
$del_link = "<a href='?cat_delete=".$encoded."&res=kusdgure8874&token=msjhj786438934' onclick='return sure_del_cat();'>Delete</a>";
echo '<tr >

                                              <td>'.$cat_name.'</td>
											<td>'.$description.'</td>
											
												 <td>'.$w_link.'</td>
												 <td>'.$del_link .'</td>
										   </tr>';
}
echo '</tbody>
                                        <tfoot>
                                            <tr>
											<th>Category</th>
											<th>Description</th>
										
												 <th>Edit</th>
												 <th>Delete</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function view_users(){
$sql = "SELECT * FROM `users` ORDER BY `timestamp` DESC";
$result  = query($sql);
$mysql_rows = $result->num_rows;
echo '<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Registered Members</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered  table-hover">
                                        <thead>
                                            <tr>
											<th>Passport</th>
											<th>Surname</th>
											<th>Firstname</th>
											 
                                                <th>Gender</th>
												<th>Username</th>
												
												<th>Phone Number</th>
												<th>Address</th>
												<th>Email</th>
												<th>Status</th>
                                                 <th>Date of Reg</th>
												 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
for($i=0;$i<$mysql_rows;$i++){
$row  = $result->fetch_array();
$id = $row['std_id'];
$encoded = encoder($id);

$surname  = $row['surname'];
$firstname= $row['firstname'];
$othername = $row['othername'];
$gender = $row['gender'];
$fullname = $surname." ".$firstname." ".$othername;
$phone = $row['phone_number'];
$address = $row['address'];
$passport = $row['passport'];
$username = $row['username'];
$email = $row['email'];
$status  = $row['status'];
$presence = $row['presence'];
$timestamp = $row['timestamp'];
if($status=="deactivate"){
$w_link  = '<a href="">Activate</a>'; 
}else{
$w_link  = '<a href="">Deactivate</a>'; 
}
$time = time();
$date =  date("F j, Y",$timestamp);
if($presence=="true"){
$img = "online.png";
$beside = "online";
}else{
$img = "offline.png";
$beside = "offline";
}
echo '<tr >

                                              <td><img src="../dp/'.$passport.'" width="50" height="50" title="'.$fullname.'" alt="'.$fullname.'"  /></td>
											<td>'.$surname.'</td>
											<td>'.$firstname.'</td>
											 
                                                <td>'.$gender.'</td>
												<td>'.$username.'</td>
												
												<td>'.$phone.'</td>
												<td>'.$address.'</td>
												<td>'.$email.'</td>
												<td> '.$beside.' <img src="../img/'.$img.'"</td>
                                                 <td>'.$date.'</td>
												 <td>'.$w_link.'</td>
										   </tr>';
}
echo '</tbody>
                                        <tfoot>
                                            <tr>
											<th>Passport</th>
											<th>Surname</th>
											<th>Firstname</th>
											 
                                                <th>Gender</th>
												<th>Username</th>
												
												<th>Phone Number</th>
												<th>Address</th>
												<th>Email</th>
												<th>Status</th>
                                                 <th>Date of Reg</th>
												 <th>Action</th>
												 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}

function edit_form_admin($fullname,$username,$access_level,$id){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add New Admin</h3>
                                </div>
								<input type="hidden" name="editMode" id="editMode" value="true"/>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">

									<div class="form-group">
                                            <label for="Full Name">Full Name</label>
                                            <input type="text" class="form-control" value="'.$fullname.'"  name="fullname" required placeholder="Full name">
                                         
                                        </div>
										
										<div class="form-group">
                                            <label for="Username">Username</label>
                                            <input type="text" class="form-control" readonly="readonly" value="'.$username.'" name="username" required placeholder="Username">
                                         
                                        </div>
										<div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control"  name="password" required placeholder="Password">
                                         <input type="hidden" value="'.$id.'" name="adminid" required />
                                        </div>
										<div class="form-group">
                                            <label for="access level">Access Level</label>
                                            <select name="access_level" required="required" class="form-control">
										';
										?>
										<option value="admin" <?php if($access_level=="admin"){echo 'selected="selected"';} ?>>Admin</option>
											<option value="manager" <?php if($access_level=="manager"){echo 'selected="selected"';} ?>>Manager</option>
											<?php
											echo '</select>
                                        </div>
										
									

									 <div class="box-footer">
                                        <input type="submit" name="edit_admin" value="Update Admin Details" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function change_password_form(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Change Password</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">

									<div class="form-group">
                                            <label for="Old Password">Old Password</label>
                                            <input type="password" class="form-control" name="old_password" required placeholder="Old Password">
                                         
                                        </div>
										<div class="form-group">
                                            <label for="New Password">New Password</label>
                                            <input type="password" class="form-control" name="new_password" required placeholder="New Password">
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Confirm password">Confirm New Password</label>
                                            <input type="password" class="form-control"  name="confirm_password" required placeholder="Confirm New Password">
                                         
                                        </div>
										
									

									 <div class="box-footer">
                                        <input type="submit" name="change_password" value="Change Password" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function add_admin($fullname,$username){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add New Admin</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">

									<div class="form-group">
                                            <label for="Full Name">Full Name</label>
                                            <input type="text" class="form-control" value="'.$fullname.'"  name="fullname" required placeholder="Full name">
                                         
                                        </div>
										
										<div class="form-group">
                                            <label for="Username">Username</label>
                                            <input type="text" class="form-control" value="'.$username.'" name="username" required placeholder="Username">
                                         
                                        </div>
										<div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control"  name="password" required placeholder="Password">
                                         
                                        </div>
										<div class="form-group">
                                            <label for="access level">Access Level</label>
                                            <select name="access_level" required="required" class="form-control">
											<option value="admin">Admin</option>
											<option value="manager">Manager</option>
											</select>
                                        </div>
										
									

									 <div class="box-footer">
                                        <input type="submit" name="add_admin" value="Add Admin" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}


function register_matric_xls(){

echo '<div class="box box-primary" style="width:50%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Students</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">
<div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <input type="file" name="matric" id="exampleInputFile" required >
                                             <p class="help-block">File Format must be .xls (i.e an xls excel file)</p>
                                        </div>
									

									 <div class="box-footer">
                                        <input type="submit" name="upload_matric_xls" value="Upload Matric" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}

function add_books_xls(){
echo '<div class="box box-primary" style="width:50%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Books</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">
<div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <input type="file" name="book" id="exampleInputFile" required >
                                             <p class="help-block">File Format must be .xls (i.e an xls excel file)</p>
                                        </div>
									

									 <div class="box-footer">
                                        <input type="submit" name="upload_matric_xls" value="Upload Books" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function dealing_with_modal($username,$fullname){
if(isset($_POST['send_message'])){
					$flag = 0;
					$timestamp = time();
					$receivers = array();
					$email_toc = stripslashes(trim(strtolower($_POST['email_toc'])));
					$email_tocc = stripslashes(trim(strtolower($_POST['email_tocc'])));
					$email_tobcc = stripslashes(trim(strtolower($_POST['email_tobcc'])));
					array_push($receivers,$email_toc);
					if($email_tobcc!=""){
					array_push($receivers,$email_tobcc);
					}
					if($email_tocc!=""){
					array_push($receivers,$email_tocc);
					}
					$receivers = array_unique($receivers);
					//print_r($receivers);
					
					$subject = $_POST['subject'];
					$subject = htmlspecialchars($subject,ENT_QUOTES);
					$subject = mysql_real_escape_string($subject);
					
					$message = $_POST['message'];
					$message = htmlspecialchars($message,ENT_QUOTES);
					$message = mysql_real_escape_string($message);
if(isset($_FILES['attachment'])){

$filename = $_FILES['attachment']['tmp_name'];
$filetype = $_FILES['attachment']['type'];
$filesize = $_FILES['attachment']['size'];
$filepath = "";
if($filename!=""){
$result = filetypes($filetype);
if($result!=false){
$filepath = $result;
if($filesize>10485760){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> File size must not be greater then 10 Mega byte
                                    </div>';

}else{
define ("FILEREPOSITORY","xva29f2et07334eo3tyhd115ft507g90phjfg/");
$result = move_uploaded_file($_FILES['attachment']['tmp_name'],FILEREPOSITORY."/$filepath");
if($result){
foreach($receivers as $rec){
$final = send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);
}
if($final){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message has been sent
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message Not sent, try again later...
                                    </div>';
}
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> File upload not successful
                                    </div>';
}

}
}
else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> The FIle type you are uploaded is not supported by this platform
                                    </div>';
}



}else{
$filepath = "";
foreach($receivers as $rec){
$final = send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);
}
if($final){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message has been sent
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message Not sent, try again later...
                                    </div>';
}
}
}
}
else if(isset($_POST['forward'])){
$flag = 0;
					$timestamp = time();
					$receivers = array();
					$email_toc = stripslashes(trim(strtolower($_POST['email_toc'])));
					$email_tocc = stripslashes(trim(strtolower($_POST['email_tocc'])));
					$email_tobcc = stripslashes(trim(strtolower($_POST['email_tobcc'])));
					array_push($receivers,$email_toc);
					if($email_tobcc!=""){
					array_push($receivers,$email_tobcc);
					}
					if($email_tocc!=""){
					array_push($receivers,$email_tocc);
					}
					$receivers = array_unique($receivers);
					//print_r($receivers);
					
					$subject = $_POST['subject'];
					$subject = htmlspecialchars($subject,ENT_QUOTES);
					$subject = mysql_real_escape_string($subject);
					
					$message = $_POST['message'];
					$message = htmlspecialchars($message,ENT_QUOTES);
					$message = mysql_real_escape_string($message);



$filepath = stripslashes($_POST['attachment']);
foreach($receivers as $rec){
$final = send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp);


}
if($final){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message has been sent
                                    </div>';
$id = stripslashes($_POST['pushpush']);
$tablename = "drafts";
$id_row = "draftsid";
$real_id = decoder($id);
delete_messages($tablename,$id_row,$real_id);
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message Not sent, try again later...
                                    </div>';
}
}
else if(isset($_POST['save_as'])){
$flag = 0;
					$timestamp = time();
$subject = $_POST['subject'];
					$subject = htmlspecialchars($subject,ENT_QUOTES);
					$subject = mysql_real_escape_string($subject);
					
					$message = $_POST['message'];
					$message = htmlspecialchars($message,ENT_QUOTES);
					$message = mysql_real_escape_string($message);
					
					
					
					if(isset($_FILES['attachment'])){

$filename = $_FILES['attachment']['tmp_name'];
$filetype = $_FILES['attachment']['type'];
$filesize = $_FILES['attachment']['size'];
$filepath = "";
if($filename!=""){
$result = filetypes($filetype);
if($result!=false){
$filepath = $result;
if($filesize>10485760){
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> File size must not be greater then 10 Mega byte
                                    </div>';

}else{
define ("FILEREPOSITORY","../xva29f2et07334eo3tyhd115ft507g90phjfg/");
$result = move_uploaded_file($_FILES['attachment']['tmp_name'],FILEREPOSITORY."/$filepath");
if($result){

$final = save_as_draft($username,$subject,$message,$filepath,$flag,$timestamp);

if($final){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message has been saved to drafts
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message was not saved, try again later...
                                    </div>';
}
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> File upload not successful
                                    </div>';
}

}
}
else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> The FIle type you are uploaded is not supported by this platform
                                    </div>';
}



}else{
$filepath = "";

$final = save_as_draft($username,$subject,$message,$filepath,$flag,$timestamp);

if($final){
echo '<div class="alert alert-success alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message has been saved to drafts
                                    </div>';
}else{
echo '<div class="alert alert-danger alert-dismissable" style="width:60%; margin: 0 auto;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> Message was not saved, try again later...
                                    </div>';
}
}
}
}
}

function save_as_draft($username,$subject,$message,$filepath,$flag,$timestamp){
$sql = "INSERT INTO `drafts` SET 
`drafter_username`='{$username}',
`subject`='{$subject}',
`message`='{$message}',
`attachment`='{$filepath}',
`flag`=0,
`timestamp`='{$timestamp}'";
$result  = query($sql);
return $result;

}
function set_as_read($tablename,$id_row,$flag,$real_id){
$sql = "UPDATE `$tablename` SET `flag`='{$flag}' WHERE 
`$id_row`='{$real_id}'";
$result = query($sql);
return $result;
}
function get_unread_messages($username){
$sql = "SELECT * FROM `inbox` WHERE `receiver_username`='{$username}' && `flag`=0";
$result = query($sql);
$mysql_rows = $result->num_rows;
echo $mysql_rows;
}
function bring_searched_inbox_listing($username,$currpage,$back_page,$mixedval){
echo '<form name="checkerboxes" action="inbox.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href=""><button type="submit" name="mark_as_read" class="btn btn-link">Mark as read</button></a></li>
                                                           <li><a href=""><button type="submit" name="mark_as_unread" class="btn btn-link">Mark as unread</button></a></li>
                                                            <li class="divider"></li>
                                                           <li><a href=""><button type="submit" name="move_junk" class="btn btn-link">Move to Junk</button></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="inbox.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" class="form-control input-sm" name="mixedval"  placeholder="Search Inbox">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                    
					</div><!-- /.row -->';
	
	if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
$sql = "SELECT * FROM `inbox` WHERE `receiver_username`='{$username}' && (`subject` LIKE '%$mixedval%' || `sender_fullname`='%$mixedval%' || `message` LIKE '%$mixedval%') ORDER BY `inboxid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;
$delimeter = 12;


$sqls = "SELECT * FROM `inbox` WHERE `receiver_username`='{$username}' && (`subject` LIKE '%$mixedval%' || `sender_fullname`='%$mixedval%' || `message` LIKE '%$mixedval%')";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}
$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}
echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$inboxid = $row['inboxid'];
$encoded = encoder($inboxid);
$fullname = $row['sender_fullname'];
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$flag = $row['flag'];
if($flag==0){
$class= "unread";
}else{
$class = "";
}
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}
$fullnames= explode(" ",$fullname);
$real_name =$fullnames[0].' '.$fullnames[1];
$rand = random_password();
$link = "?token=$rand&shakiJEG=$encoded";
echo ' <tr class="'.$class.'">
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$real_name.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$prev.'&search='.$mixedval.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$next.'&search='.$mixedval.'"><i class="fa fa-caret-right"></i></a>
                                    
									</div>
                                </div><!-- box-footer -->';
}
function bring_searched_sent_listing($username,$currpage,$back_page,$mixedval){
echo '<form name="checkerboxes" action="sent.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            
                                                           <li><a href=""><button type="submit" name="move_junk" class="btn btn-link">Move to Junk</button></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="sent.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Sent">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->';
if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
	
$sql = "SELECT * FROM `sent` WHERE `sender_username`='{$username}' && (`receiver_username` LIKE '%$mixedval%' || `subject` LIKE '%$mixedval%' || `message` LIKE '%$mixedval%' ) ORDER BY `sentid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;

$delimeter = 12;


$sqls = "SELECT * FROM `sent` WHERE `sender_username`='{$username}' && (`receiver_username` LIKE '%$mixedval%' || `subject` LIKE '%$mixedval%' || `message` LIKE '%$mixedval%' )";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}
$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}

echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$sentid = $row['sentid'];
$encoded = encoder($sentid);
$username_accepter = ucword($row['receiver_username']);
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}

$rand = random_password();
$link = "?token=$rand&shakisendkey=$encoded";
echo ' <tr>
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$username_accepter.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$prev.'&search='.$mixedval.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$next.'&search='.$mixedval.'"><i class="fa fa-caret-right"></i></a>
                                    
									</div>
                                </div><!-- box-footer -->';
}

function bring_searched_junk_listing($username,$currpage,$back_page,$mixedval){
echo '<form name="checkerboxes" action="junk.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                           
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="junk.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Junk">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                    
					</div><!-- /.row -->';
	
	if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
$sql = "SELECT * FROM `junk` WHERE `junker_username`='{$username}' && (`junker_subject` LIKE '%$mixedval%' || `junker_message` LIKE '%$mixedval%') ORDER BY `junkid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;
$delimeter = 12;


$sqls = "SELECT * FROM `junk` WHERE `junker_username`='{$username}' && (`junker_subject` LIKE '%$mixedval%' || `junker_message` LIKE '%$mixedval%')";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}
$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}
echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['junkid'];
$encoded = encoder($id);
$fullname = ucword($row['junker_username']);
$subject = htmlspecialchars_decode($row['junker_subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$flag = $row['flag'];

$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}

$rand = random_password();
$link = "?token=$rand&shakijunkJEG=$encoded";
echo ' <tr>
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$fullname.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                         <a class="btn btn-xs btn-primary" href="?current_pages='.$prev.'&search='.$mixedval.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$next.'&search='.$mixedval.'"><i class="fa fa-caret-right"></i></a>
                                    
								   </div>
                                </div><!-- box-footer -->';

}
function bring_searched_drafts_listing($username,$currpage,$back_page,$mixedval){
echo '<form name="checkerboxes" action="draft.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            
                                                           <li><a href=""><button type="submit" name="move_junk" class="btn btn-link">Move to Junk</button></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="draft.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Draft">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->';
											
											if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
	
$sql = "SELECT * FROM `drafts` WHERE `drafter_username`='{$username}' && (`subject` LIKE '%$mixedval%' || `message` LIKE '%$mixedval%') ORDER BY `draftsid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;

$delimeter = 12;


$sqls = "SELECT * FROM `drafts` WHERE `drafter_username`='{$username}' && (`subject` LIKE '%$mixedval%' || `message` LIKE '%$mixedval%')";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}

$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}


echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['draftsid'];
$encoded = encoder($id);
$username_accepter = ucword($row['drafter_username']);
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}

$rand = random_password();
$link = "?token=$rand&shakidraftkey=$encoded";
echo ' <tr>
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$username_accepter.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$prev.'&search='.$mixedval.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_pages='.$next.'&search='.$mixedval.'"><i class="fa fa-caret-right"></i></a>
                                    
									</div>
                                </div><!-- box-footer -->';

}
function bring_drafts_listing($username,$currpage,$back_page){
echo '<form name="checkerboxes" action="draft.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            
                                                           <li><a href=""><button type="submit" name="move_junk" class="btn btn-link">Move to Junk</button></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="draft.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Draft">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->';
											
											if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
	
$sql = "SELECT * FROM `drafts` WHERE `drafter_username`='{$username}' ORDER BY `draftsid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;

$delimeter = 12;


$sqls = "SELECT * FROM `drafts` WHERE `drafter_username`='{$username}'";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}

$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}


echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['draftsid'];
$encoded = encoder($id);
$username_accepter = ucword($row['drafter_username']);
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}

$rand = random_password();
$link = "?token=$rand&shakidraftkey=$encoded";
echo ' <tr>
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$username_accepter.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$prev.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$next.'"><i class="fa fa-caret-right"></i></a>
                                    </div>
                                </div><!-- box-footer -->';
}

function filetypes($filetype){
$time = time();
if($filetype=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
$name = $time.'.xlsx';
}
else if($filetype=="application/vnd.ms-powerpoint"){
$name = $time.'.ppt';
}
else if($filetype=="application/octet-stream"){
$name = $time.'.zip';
}
else if($filetype=="application/pdf"){
$name = $time.'.pdf';
}
else if($filetype=="text/plain"){
$name = $time.'.txt';
}
else if($filetype=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
$name = $time.'.docx';
}
else if($filetype=="application/msword"){
$name = $time.'.doc';
}
else if($filetype=="image/jpeg"){
$name = $time.'.jpg';
}
else if($filetype=="image/png"){
$name = $time.'.png';
}
else if($filetype=="image/gif"){
$name = $time.'.gif';
}
else{
$name = false;
}
return $name;
}

function bring_sent_listing($username,$currpage,$back_page){
echo '<form name="checkerboxes" action="sent.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            
                                                           <li><a href=""><button type="submit" name="move_junk" class="btn btn-link">Move to Junk</button></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="sent.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Sent">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->';
if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
	
											$sql = "SELECT * FROM `sent` WHERE `sender_username`='{$username}' ORDER BY `sentid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;

$delimeter = 12;


$sqls = "SELECT * FROM `sent` WHERE `sender_username`='{$username}'";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}
$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}

echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$sentid = $row['sentid'];
$encoded = encoder($sentid);
$username_accepter = ucword($row['receiver_username']);
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}

$rand = random_password();
$link = "?token=$rand&shakisendkey=$encoded";
echo ' <tr>
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$username_accepter.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$prev.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$next.'"><i class="fa fa-caret-right"></i></a>
                                    </div>
                                </div><!-- box-footer -->';
}

function bring_junk_listing($username,$currpage,$back_page){
echo '<form name="checkerboxes" action="junk.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                           
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="junk.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Junk">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                    
					</div><!-- /.row -->';
	
	if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
$sql = "SELECT * FROM `junk` WHERE `junker_username`='{$username}' ORDER BY `junkid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;
$delimeter = 12;


$sqls = "SELECT * FROM `junk` WHERE `junker_username`='{$username}'";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}
$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}
echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$id = $row['junkid'];
$encoded = encoder($id);
$fullname = ucword($row['junker_username']);
$subject = htmlspecialchars_decode($row['junker_subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$flag = $row['flag'];

$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}

$rand = random_password();
$link = "?token=$rand&shakijunkJEG=$encoded";
echo ' <tr>
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$fullname.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$prev.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$next.'"><i class="fa fa-caret-right"></i></a>
                                    </div>
                                </div><!-- box-footer -->';
}
function is_id_before_deletion($tablename,$id_row,$real_id){
$sql = "SELECT * FROM `$tablename` WHERE `$id_row`='{$real_id}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function move_to_junk($username,$tablename,$id_row,$real_id){
$timestamp = time();
$sql = "SELECT * FROM `$tablename` WHERE `$id_row`='{$real_id}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
$subject = $row['subject'];
$message = $row['message'];
$attachment = $row['attachment'];
$sqq = "INSERT INTO `junk` SET
`junker_username`='{$username}',
`junker_subject`='{$subject}',
`junker_message`='{$message}',
`attachment`='{$attachment}',
`flag`=0,
`timestamp`='{$timestamp}'";
$res= query($sqq);
return $res;
}
function get_latest_four($username){
$sql = "SELECT * FROM `inbox` WHERE `receiver_username`='{$username}' && `flag`=0 ORDER BY `inboxid` DESC LIMIT 4";
$result = query($sql);
$mysql_rows = $result->num_rows;
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$sender = $row['sender_username'];
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,30);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$month = date("d M Y",$timestamp);
$attachment = $row['attachment'];
$inboxid = $row['inboxid'];
$encoded = encoder($inboxid);
$fullname = $row['sender_fullname'];
$fullnames= explode(" ",$fullname);
$real_name =$fullnames[0].' '.$fullnames[1];
$date = date("h:i A, M j, Y",$timestamp);

$rand = random_password();
$link = "?token=$rand&shakiJEG=$encoded";
$time = date("h:i A",$timestamp);
echo '<li><!-- start message -->
                                            <a href="inbox.php'.$link.'">
                                                <div class="pull-left">
                                                    <img src="img/members.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    '.$real_name.'
                                                    <small><i class="fa fa-clock-o"></i> '.$time.'</small>
                                                </h4>
                                                <p>'.$subject.'</p>
                                            </a>
                                        </li>';
}

}
function base_url(){
	
    $base_url  = $_SERVER['SERVER_NAME'];
	//$folder = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
	//$base_url = $_SERVER['HTTP_HOST'];
	echo 'This is the servername '.$base_url;
	return "http://".$base_url."/cop";
}
function individual_sent($id,$back_page){
	
$sql = "SELECT * FROM `sent` WHERE `sentid`='{$id}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
$fullname = ucword($row['receiver_username']);
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$message = htmlspecialchars_decode($row['message'],ENT_QUOTES);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$month = date("d M Y",$timestamp);
$attachment = $row['attachment'];
$time = date("h:i A",$timestamp);
echo '<div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="sent.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Sent">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->

                                            <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
            '.$month.'
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> '.$time.'</span>

            <h3 class="timeline-header"><a href="#">'.$fullname.' | '.$subject.'</a> ...</h3>

            <div class="timeline-body">
                '.$message.'
            </div>';

if($attachment!=""){           
		  echo ' <div class=\'timeline-footer\'>
                <a href="'.base_url().'/xva29f2et07334eo3tyhd115ft507g90phjfg/'.$attachment.'" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> Download Attachment</a>
            </div>';
			}
       echo ' </div>
    </li>
    <!-- END timeline item -->

    ...

</ul>
											
											</div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->
                                   ';
}
function individual_draft($id,$back_page){
$sql = "SELECT * FROM `drafts` WHERE `draftsid`='{$id}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();
$encoded = encoder($id);
$fullname = ucword($row['drafter_username']);
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$message = htmlspecialchars_decode($row['message'],ENT_QUOTES);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$month = date("d M Y",$timestamp);
$attachment = $row['attachment'];
$time = date("h:i A",$timestamp);
echo '<div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#forward" class="btn btn-success btn-xs" onclick="show_forward();"><i class="fa fa-mail-forward"></i> Forward</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="draft.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Drafts">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->

                                            <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
            '.$month.'
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> '.$time.'</span>

            <h3 class="timeline-header"><a href="#">'.$fullname.' | '.$subject.'</a> ...</h3>

            <div class="timeline-body">
                '.$message.'
            </div>';

if($attachment!=""){           
		  echo ' <div class=\'timeline-footer\'>
                <a href="'.base_url().'/xva29f2et07334eo3tyhd115ft507g90phjfg/'.$attachment.'" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> Download Attachment</a>
            </div>';
			}
       echo ' </div>
    </li>
    <!-- END timeline item -->

    ...

</ul>
											
											</div><!-- /.table-responsive -->
<div id="forward">
<div class="modal-content">
                    <div class="modal-header">
                        <a type="button" class="close" data-dismiss="modal" aria-hidden="true" href="#" onclick="hide_forward();">&times;</a>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
                    </div>
                    <form action="'.$_SERVER['PHP_SELF'].'" method="post" autocomplete="on" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
							
                                <div class="input-group">
								
                                    <span class="input-group-addon">TO:</span>
                                    <input name="email_toc" type="text" class="form-control" required placeholder="Username TO">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">CC:</span>
                                    <input name="email_tocc" type="text" class="form-control" placeholder="Username CC">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">BCC:</span>
                                    <input name="email_tobcc" type="text" class="form-control" placeholder="Username BCC">
                                </div>
                            </div>
							<div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">SUBJECT:</span>
                                    <input name="subject" type="text" value="'.$subject.'" class="form-control" placeholder="Subject" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="message" id="email_message"  required class="form-control" placeholder="Message" style="height: 120px;">'.$message.'</textarea>
                            </div><input type="hidden" name="pushpush" value="'.$encoded.'" /> <input type="hidden" name="attachment" value="'.$attachment.'"/>';
							
							if($attachment!=""){
							echo '<div class="form-group">                                
                                       <p class="help-block"> <i class="fa fa-download"></i> '.$attachment.'
                                   
                                </p>
								                               
                            </div>';
							}
                            

                        echo '</div>
                        <div class="modal-footer clearfix">
 
                            <button type="button" onclick="hide_forward();" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                          
							<button type="submit" class="btn btn-primary pull-left" name="forward"><i class="fa fa-envelope"></i> Send Message</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
</div>                          
									   </div><!-- /.col (RIGHT) -->
                                   ';
}
function individual_junk($junkid,$back_page){
$sql = "SELECT * FROM `junk` WHERE `junkid`='{$junkid}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();

$update = "UPDATE `junk` SET `flag`=1 WHERE `junkid`='{$junkid}'";
$resulter = query($update);
$fullname = ucword($row['junker_username']);
$subject = htmlspecialchars_decode($row['junker_subject'],ENT_QUOTES);
$message = htmlspecialchars_decode($row['junker_message'],ENT_QUOTES);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$month = date("d M Y",$timestamp);
$attachment = $row['attachment'];
$time = date("h:i A",$timestamp);
echo '<div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="junk.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Junk">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->

                                            <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
            '.$month.'
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> '.$time.'</span>

            <h3 class="timeline-header"><a href="#">'.$fullname.' | '.$subject.'</a> ...</h3>

            <div class="timeline-body">
                '.$message.'
            </div>';

if($attachment!=""){           
		  echo ' <div class=\'timeline-footer\'>
                <a href="'.base_url().'/xva29f2et07334eo3tyhd115ft507g90phjfg/'.$attachment.'" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> Download Attachment</a>
            </div>';
			}
       echo ' </div>
    </li>
    <!-- END timeline item -->

    ...

</ul>
											
											</div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->
                                   ';
}
function individual_inbox($inboxid,$back_page){
$sql = "SELECT * FROM `inbox` WHERE `inboxid`='{$inboxid}' LIMIT 1";
$result = query($sql);
$row = $result->fetch_array();

$update = "UPDATE `inbox` SET `flag`=1 WHERE `inboxid`='{$inboxid}'";
$resulter = query($update);
$fullname = $row['sender_fullname'];
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$message = htmlspecialchars_decode($row['message'],ENT_QUOTES);
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$month = date("d M Y",$timestamp);
$attachment = $row['attachment'];
$time = date("h:i A",$timestamp);
echo '<div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="inbox.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" name="mixedval"  class="form-control input-sm" placeholder="Search Inbox">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->

                                            <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
            '.$month.'
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> '.$time.'</span>

            <h3 class="timeline-header"><a href="#">'.$fullname.' | '.$subject.'</a> ...</h3>

            <div class="timeline-body">
                '.$message.'
            </div>';

if($attachment!=""){           
		  echo ' <div class=\'timeline-footer\'>
                <a href="'.base_url().'/xva29f2et07334eo3tyhd115ft507g90phjfg/'.$attachment.'" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> Download Attachment</a>
            </div>';
			}
       echo ' </div>
    </li>
    <!-- END timeline item -->

    ...

</ul>
											
											</div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->
                                   ';
}

function delete_messages($tablename,$id_row,$real_id){
$sql = "DELETE FROM `$tablename` WHERE `$id_row`='{$real_id}'";
$result = query($sql);
return $result;
}
function bring_inbox_listing($username,$currpage,$back_page){
echo '<form name="checkerboxes" action="inbox.php" method="post">
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
											
                                                <div class="col-sm-6">
												
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button  type="submit" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href=""><button type="submit" name="mark_as_read" class="btn btn-link">Mark as read</button></a></li>
                                                           <li><a href=""><button type="submit" name="mark_as_unread" class="btn btn-link">Mark as unread</button></a></li>
                                                            <li class="divider"></li>
                                                           <li><a href=""><button type="submit" name="move_junk" class="btn btn-link">Move to Junk</button></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href=""><button type="submit" name="delete_mail" class="btn btn-link">Delete</button></a></li>
                                                        </ul>
                                                    </div>
 <a href="'.$back_page.'" class="btn btn-info btn-xs"><i class="fa fa-level-up"></i> Go Back</a>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="inbox.php" class="text-right" method="post">
                                                        <div class="input-group">                                                            
                                                            <input type="text" class="form-control input-sm" name="mixedval"  placeholder="Search Inbox">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                    
					</div><!-- /.row -->';
	
	if($currpage==0){
	$limit = 0;
	}else{
	$limit = ($currpage * 12);
	}
	
	$tester = $limit + 12;
$sql = "SELECT * FROM `inbox` WHERE `receiver_username`='{$username}' ORDER BY `inboxid` DESC LIMIT $limit,12";
$result = query($sql);
$mysql_rows = $result->num_rows;
$delimeter = 12;


$sqls = "SELECT * FROM `inbox` WHERE `receiver_username`='{$username}'";
$resulter = query($sqls);
$total = $resulter->num_rows;

$collector = ceil($mysql_rows/$delimeter);   

$prev = $currpage - 1;
if($prev<=0){
$prev = 0;
}

if($prev>$collector){
$prev = $collector;
}
$next = $currpage + 1;
if($next>=$collector){
$next = $collector;
}
echo '<div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">';
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$inboxid = $row['inboxid'];
$encoded = encoder($inboxid);
$fullname = $row['sender_fullname'];
$subject = htmlspecialchars_decode($row['subject'],ENT_QUOTES);
$subject = substr($subject,0,20);
$flag = $row['flag'];
if($flag==0){
$class= "unread";
}else{
$class = "";
}
$timestamp = $row['timestamp'];
$date = date("h:i A, M j, Y",$timestamp);
$attachment = $row['attachment'];
if($attachment!=""){
$front = '<i class="fa fa-download"></i>';
}else{
$front = "";
}
$fullnames= explode(" ",$fullname);
$secondPart = "";
if(isset($fullnames[1])){
$secondPart = $fullnames[1];
}
$real_name =$fullnames[0].' '.$secondPart;
$rand = random_password();
$link = "?token=$rand&shakiJEG=$encoded";
echo ' <tr class="'.$class.'">
                             <td class="small-col"><input type="checkbox" name="checkbox[]" value="'.$encoded.'"/></td>
                              <td class="small-col"><i class="fa fa-star"></i></td>
                             <td class="name"><a href="'.$link.'">'.$real_name.'</a></td>
                         <td class="subject"><a href="'.$link.'">'.$subject.'</a> '.$front.'</td>
                          <td class="time">'.$date.'</td>
                                                    </tr>';
}
echo ' </table>
                                            </div><!-- /.table-responsive -->';

                                            
                                                                                                      
                                               
                                       echo ' </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                
								</div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        <small>Showing '.$limit.' - '.$tester.'/'.$total.'</small>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$prev.'"><i class="fa fa-caret-left"></i></a>
                                        <a class="btn btn-xs btn-primary" href="?current_page='.$next.'"><i class="fa fa-caret-right"></i></a>
                                    </div>
                                </div><!-- box-footer -->';
}

function send_message_to($username,$fullname,$rec,$subject,$message,$filepath,$flag,$timestamp){
$result1 = false;
$result2 = false;
$sql1 = "INSERT INTO `inbox` SET 
`sender_username`='{$username}',
`sender_fullname`='{$fullname}',
`receiver_username`='{$rec}',
`subject`='{$subject}',
`message`='{$message}',
`attachment`='{$filepath}',
`flag`='{$flag}',
`timestamp`='{$timestamp}'";
$result1 = query($sql1);
if($result1){
$sql2 = "INSERT INTO `sent` SET 
`sender_username`='{$username}',
`receiver_username`='{$rec}',
`subject`='{$subject}',
`message`='{$message}',
`attachment`='{$filepath}',
`flag`='{$flag}',
`timestamp`='{$timestamp}'";
$result2 = query($sql2);
} 

if($result1 && $result2){
return true;
}
else{
return false;
}
}

function show_me_form_ledger_bf(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">View Ledger by Period</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="add_cat_int"  name="add_cat_int" >

									<div class="form-group">
                                            <label for="Ledger Period">Select Period</label>
                                         ';
$periods = select_distinct_dates();

echo '<input type="text" list="period" name="period" required class="form-control" placeholder="--choose--" autocomplete="off" />';
echo '<datalist id="period" autocomplete="off">
<option value="--choose--">

';
foreach($periods as $period){
echo '<option value="'.$period.'">';
}
echo '</datalist>';
echo '</div>
										
										
										
										 <div class="box-footer">
                                        <input type="submit" name="view_ledger_bf_push" value="Balance Push" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function show_me_the_form_generator(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">View Ledger by Period</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="add_cat_int"  name="add_cat_int" >

									<div class="form-group">
                                            <label for="Ledger Period">Select Period</label>
                                         ';
$periods = select_distinct_dates();

echo '<input list="period" name="period" required class="form-control" placeholder="--choose--" style="width:30% !important" autocomplete="off"/></label>';
echo '<datalist id="period">
<option value="annual">
<option value="biannual">
<option value="5_years">
<option value="so_far">

';
foreach($periods as $period){
echo '<option value="'.$period.'">';
}
echo '</datalist>';


echo '</div>


										
										
										
										 <div class="box-footer">
                                        <input type="submit" name="view_ledger_period" value="View Ledger" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function month_name_getter($var){
$array =array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
return $array[$var];
}
function insert_into__new_bf($username,$bfs,$year_next,$month_next,$timestamp){
$sql = "INSERT INTO `bf` SET
`username`='{$username}',
`year`='{$year_next}',
`month`='{$month_next}',
`bf_amount`='{$bfs}',
`timestamp`='{$timestamp}'";
$result = query($sql);
return $result;
}

function method_for_put_in_val($year,$var,$usernamer=""){
$period = explode("/",$year);
$year = $period[1];
$year2 = "";
$month = $period[0];
$usernames = select_all_users_username();
$savings =  get_all_from_savings_cat();
$timestamp = time();
echo '<form name"" method="post" action="" onsubmit="return sure_bf();">';
echo '<input type="hidden" name="month" value="'.$month.'" required/>';
echo '<input type="hidden" name="year" value="'.$year.'" required />';
echo '<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title" align="center">Deficit Outstanding</h3>                                    
                                </div><!-- /.box-header -->
								<button type="submit" class="btn btn-success" name="forward_push" style="float:right;">Save</button><br/>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered  table-hover" border="1px" align="center">
                                        <thead>
                                            <tr>
											<th>Full Name</th>
											<th>Username</th>
											<th>Loan</th>';
											foreach($savings as $save_name){
											echo '<th>'.$save_name.'</th>';
											}
												echo '<th>SUM</th>';
												if($month!=""){
												echo'<th title="Balance Brought being pushed to next month to serve as deficit outstanding forward">Balance Being Pushed to Coming Month</th>';
											
												}
												echo '</tr>
                                        </thead>
                                        <tbody>';

$data_period = array();
foreach($usernames as $username){
$details =  get_details_user($username);
$fullname = ucword($details['surname']).' '.ucword($details['firstname']).' '.ucfirst(substr($details['othername'],0,1));
$save_name = "loan";
echo '<tr>
<td>'.$fullname.'</td>
<td>'.$username.'</td>';
$loan = get_values_for_ledger($username,$year2,$year,$save_name,$month);
$data_period[$username]['loan'] = $loan;
echo '<td>'.$loan.'</td>';
foreach($savings as $save_name){
$save_name = "".$save_name."";
$saver = get_values_for_ledger($username,$year2,$year,$save_name,$month);
$data_period[$username][$save_name] = $saver;

echo '<td>'.$saver.'</td>';
}
$total_user = array_sum($data_period[$username]);
$data_period[$username]['sum_total'] = $total_user;
echo '<td>'.$total_user.'</td>';
if($month!=""){


echo '<td><input type="number" name="bf['.$username.']" value="0" required /></td>';

}
echo '</tr>';
}
//print_r($data_period);
echo '</tbody>
                                        <tfoot>
                                            <tr>
											<th>Full Name</th>
											<th>Username</th>
											<th>Loan</th>';
											foreach($savings as $save_name){
											echo '<th>'.$save_name.'</th>';
											}
												echo '<th>SUM</th>';
												if($month!=""){
												echo'<th title="Balance Brought being pushed to next month to serve as balance brought forward">Balance Being Pushed to Coming Month</th>';
												
												}
												echo '</tr>
                                        </tfoot>
                                    </table>
									<button type="submit" class="btn btn-success" style="float:left;" name="forward_push">Save</button>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
							
							echo '</form>';
}
function get_annual_period_ledger($year,$var,$usernamer=""){
$month = "";
if($var==1){
$year2 = $year;
$caption = "Year $year";
}
else if($var==2){
$year2 = $year - 2;
$caption  = "Period $year2 to $year";
}
else if($var==3){
$year2 = $year - 5;
$caption  = "Period $year2 to $year";
}
else if($var==4){
$year2 = "";
$caption  = "So Far";
}
else if($var==5){

$period = explode("/",$year);
$year = $period[1];
$year2 = "";
$month = $period[0];

$monthname = month_name_getter($month);
$caption  = "Month $monthname,$year";
}
if($usernamer){
$usernames[] = $usernamer;
}else{
$usernames = select_all_users_username();
}
$savings =  get_all_from_savings_cat();
$timestamp = time();
$date  = date("m M,Y h:ia",$timestamp);
echo '<div class="box">
                                <div class="box-header" style="width:90% !important;margin:0 auto !important;">
                                    <h3 class="box-title" align="center">Ledger Generated For The '.$caption.'.  Generated on '.$date.'</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="width:90% !important;margin:0 auto !important;">
                                    <table id="example1" class="table table-bordered  table-hover" border="1px" align="center">
                                        <thead>
                                            <tr>
											<th>Full Name</th>
											<th>Username</th>
											<th>Loan</th>';
											foreach($savings as $save_name){
											echo '<th>'.$save_name.'</th>';
											}
												echo '<th>SUM</th>';
												if($month!=""){
												
												echo'<th title="Amount Deducted">Amount Deducted</th>';
												
												}
												echo '</tr>
                                        </thead>
                                        <tbody>';

$data_period = array();
foreach($usernames as $username){
$details =  get_details_user($username);
$fullname = ucword($details['surname']).' '.ucword($details['firstname']).' '.ucfirst(substr($details['othername'],0,1));
$save_name = "loan";
echo '<tr>
<td>'.$fullname.'</td>
<td>'.$username.'</td>';
$loan = get_values_for_ledger($username,$year2,$year,$save_name,$month);
$data_period[$username]['loan'] = $loan;
echo '<td align="right">'.number_format($loan).'</td>';
foreach($savings as $save_name){
$save_name = "".$save_name."";
$saver = get_values_for_ledger($username,$year2,$year,$save_name,$month);
$data_period[$username][$save_name] = $saver;

echo '<td align="right">'.number_format($saver).'</td>';
}
$total_user = array_sum($data_period[$username]);
$data_period[$username]['sum_total'] = $total_user;
echo '<td align="right">'.number_format($total_user).'</td>';
if($month!=""){
$bf = "0";
$bf = get_balance_brought_forward($year,$month,$username);
$final_total = $total_user  + $bf;
// echo '<td align="right">'.$bf.'</td>';
echo '<td align="right">'.number_format($final_total).'</td>';
}
echo '</tr>';
}
//print_r($data_period);
echo '</tbody>
                                        <tfoot>
                                            <tr>
											<th>Full Name</th>
											<th>Username</th>
											<th>Loan</th>';
											foreach($savings as $save_name){
											echo '<th>'.$save_name.'</th>';
											}
												echo '<th>SUM</th>';
												if($month!=""){
												// echo'<th title="Balance Brought Forward From Previous Month">Balance Brought Forward</th>';
												echo'<th title="Amount Deducted">Amount Deducted</th>';
												
												}
												echo '</tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->';
}
function get_balance_brought_forward($year,$month,$username){
$sql = "SELECT * FROM `bf` WHERE `year`='{$year}' AND `month`='{$month}' AND `username`='{$username}' ";
$result = query($sql);
$row = $result->fetch_array();
$bf_amount = $row['bf_amount'];
return $bf_amount;
}
function get_values_for_ledger($username,$year,$year2,$save_name,$month){
if($month!=""){
$sql = "SELECT SUM(`$save_name`) as `sum` FROM ledger WHERE  `year`='{$year2}' AND `month`='{$month}' AND `username`='{$username}'";

} else if($year==""){
$sql = "SELECT SUM(`$save_name`) as `sum` FROM ledger	 WHERE  `year`<='{$year2}' AND `username`='{$username}'";

}else{
$sql = "SELECT SUM(`$save_name`) as `sum` FROM ledger	 WHERE `year`>='{$year}' AND `year`<='{$year2}' AND `username`='{$username}'";

}
//echo $sql;
$result = query($sql);

$row = $result->fetch_array();
$sum = $row['sum'];
return $sum;

}
function select_all_users_username(){
$sql = "SELECT * FROM users";
$result = query($sql);
$mysql_rows = $result->num_rows;
$usernames = array();
for($i=0;$i<$mysql_rows;$i++){
$row = $result->fetch_array();
$username = $row['username'];
$usernames[] = $username;
}
$usernames = array_unique($usernames);
return $usernames;
}
function add_loan_interest_rate(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Interest Rate</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form role="form" action="'.$_SERVER['PHP_SELF'].'" method="post"  id="add_cat_int" onsubmit="submitform (document.getElementById(\'add_cat_int\'), \'../catacata.php\', \'response\'); return false;" name="add_cat_int" >

									<div class="form-group">
                                            <label for="Loan Category">Select loan Category</label>
                                         ';
                                         select_drop_down();
                                        echo '</div>
										<div class="form-group">
                                            <label for="Amount">Amount </label>
                                           <input type="number" class="form-control" style="width:30% !important;" min="0" name="amount"  placeholder="Amount" min="0" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Interest Rate">Interest Rate %</label>
                                           <input type="number" class="form-control" style="width:30% !important;" name="interest_rate"  placeholder="Interest Rate" min="0" max="100" />
                                         
                                        </div>
										
										
										 <div class="box-footer">
                                        <input type="submit" name="add_interest_rate" value="Add Interest rate" class="btn btn-primary"/>
                                    </div>

</form></div></div>';

}

function add_books(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Books</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">

									<div class="form-group">
                                            <label for="Book\'s Name">Book\'s Name</label>
                                            <input type="text" class="form-control" name="book_name" required placeholder="Book\'s Name" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Book\'s Author">Book\'s Author</label>
                                            <textarea cols="3" rows="5" class="form-control" name="book_author" required placeholder="Book\'s Author"></textarea>
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Book\'s Print Year">Book\'s Print Year (optional)</label>
                                            <input type="text" class="form-control" name="book_print_year"  placeholder="Book\'s Print Year" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Book\'s ISBN">Book\'s ISBN/ ISSN (optional)</label>
                                            <input type="text" class="form-control" name="book_isbn"  placeholder="Book\'s ISBN" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Book\'s Location">Book\'s Location</label>
                                            <textarea cols="3" rows="5" class="form-control" name="book_location" required placeholder="Book\'s Location"></textarea>
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Book\'s ISBN">Book\'s Copies</label>
                                            <input type="number" class="form-control" min="0" name="book_copies"  placeholder="Book\'s Copies" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="Book\'s Status">Book\'s State</label><br/>
                                            <input type="radio"  value="Poor" class="form-control" name="book_state"  required/> Poor
											  <input type="radio"  value="Fair" class="form-control" name="book_state"  required/> Fair
											    <input type="radio"  value="Good" class="form-control" name="book_state"  required/> Good
												<input type="radio"  value="Very Good" class="form-control" name="book_state"  required/> Very Good
                                         
                                        </div>
										
									

									 <div class="box-footer">
                                        <input type="submit" name="add_book_submit" value="Add Book" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function update_image_enter($username,$name_file){
$sql = "UPDATE `users` SET 
`passport`='{$name_file}' WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}
function update_image(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Update Profile Picture</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'"  name="update_pix_form" method="post" enctype="multipart/form-data">

									<div class="form-group">
                                            <label for="surname">Select File</label>
                                            <input type="file" class="form-control"  name="filename" required accept="image/png, image/jpg, image/jpeg" />
                                         
                                        </div>
										
										
									 <div class="box-footer">
                                        <input type="submit" name="update_profilepix" value="Update Profile Pix" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function add_loan_cat_form_update($id){
$sql = "SELECT * FROM `loan_categ` WHERE `loan_cat_id`='{$id}' LIMIT 1";
$encoded = encoder($id);
$result = query($sql);
$row = $result->fetch_array();
$name = $row['cat_name'];
$description = $row['description'];
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Edit Loan\'s Category</h3>
                                </div>
                               <input type="hidden" name="editMode" id="editMode" value="true"/>
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" id="add_cat" onsubmit="submitform (document.getElementById(\'add_cat\'), \'../catacata.php\', \'response\'); return false;" name="add_cat" method="post" >

									<div class="form-group">
                                            <label for="surname">Loan Category Name</label>
                                            <input type="text" class="form-control"  value="'.$name.'" name="cat_name" required placeholder="Category Name" />
                                         
                                        </div>
										<input type="hidden" name="id" value="'.$encoded.'" required/>
										<div class="form-group">
                                            <label for="address">Description</label>
                                            <textarea cols="3" rows="5" class="form-control" name="description" required placeholder=" Description ">'.$description.'</textarea>
                                         
                                        </div>
										
									 <div class="box-footer">
                                        <input type="submit" name="loan_cat_update" value="Update Category" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function add_savings_categories(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Savings Category</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" id="add_cat" onsubmit="submitform (document.getElementById(\'add_cat\'), \'../catacata.php\', \'response\'); return false;" name="add_cat" method="post" >

									<div class="form-group">
                                            <label for="surname">Savings Category Name</label>
                                            <input type="text" class="form-control"  name="cat_name" required placeholder="Category Name" />
                                         
                                        </div>
										
										<div class="form-group">
                                            <label for="address">Description</label>
                                            <textarea cols="3" rows="5" class="form-control" name="description" required placeholder=" Description "></textarea>
                                         
                                        </div>
										<div class="form-group">
                                            <label for="address">Default Deduction Amount per Month</label>
                                            <input type="number" class="form-control"  style="width:30% !important;" name="def_amount" required placeholder="Default Amount" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="address">Start Date</label>
                                            <input type="date" class="form-control"  style="width:30% !important;" name="start_date" format="mm/dd/yyyy" required placeholder="mm/dd/yyyy" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="address">End Date</label>
                                            <input type="date" class="form-control"  style="width:30% !important;" name="end_date" format="mm/dd/yyyy" required placeholder="mm/dd/yyyy" />
                                         
                                        </div>
										
									 <div class="box-footer">
                                        <input type="submit" name="savings_cat" value="Add Category" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function edit_savings_id($id,$save_name,$save_description,$save_def_amount,$save_start_date,$save_end_date){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Edit Saving\'s Category</h3>
                                </div>
								<input type="hidden" name="editMode" id="editMode" value="true"/>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" id="add_cat" name="add_cat" method="post" >

									<div class="form-group">
                                            <label for="surname">Savings Category Name</label>
                                            <input type="text" class="form-control" value="'.$save_name.'" readonly="readonly" name="cat_name" required placeholder="Category Name" />
                                         
                                        </div>
										
										<div class="form-group">
                                            <label for="address">Description</label>
                                            <textarea cols="3" rows="5" class="form-control" name="save_description" required placeholder=" Description ">'.$save_description.'</textarea>
                                         
                                        </div>
										<input type="hidden" name="save_id" value="'.$id.'" required/>
										<div class="form-group">
                                            <label for="address">Default Deduction Amount per Month</label>
                                            <input type="number" class="form-control" value="'.$save_def_amount.'" name="save_def_amount" required placeholder="Default Amount" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="address">Start Date</label>
                                            <input type="date" class="form-control"  value="'.$save_start_date.'" name="save_start_date" format="mm/dd/yyyy" required placeholder="mm/dd/yyyy" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="address">End Date</label>
                                            <input type="date" class="form-control"  value="'.$save_end_date.'" name="save_end_date" format="mm/dd/yyyy" required placeholder="mm/dd/yyyy" />
                                         
                                        </div>
										
									 <div class="box-footer">
                                        <input type="submit" name="edit_savings_cat" value="Edit Category" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function update_existing_savings($save_id,$save_description,$save_def_amount,$save_start_date,$save_end_date){
$sql = "UPDATE savings SET 
`save_description`='{$save_description}',
`save_def_amount`='{$save_def_amount}',
`save_start_date`='{$save_start_date}',
`save_end_date`='{$save_end_date}' WHERE `save_id`='{$save_id}'";
$result  = query($sql);
return $result;
}
function add_loan_cat_form(){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Loan\'s Category</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" id="add_cat" onsubmit="submitform (document.getElementById(\'add_cat\'), \'../catacata.php\', \'response\'); return false;" name="add_cat" method="post" >

									<div class="form-group">
                                            <label for="surname">Loan Category Name</label>
                                            <input type="text" class="form-control"  name="cat_name" required placeholder="Category Name" />
                                         
                                        </div>
										
										<div class="form-group">
                                            <label for="address">Description</label>
                                            <textarea cols="3" rows="5" class="form-control" name="description" required placeholder=" Description "></textarea>
                                         
                                        </div>
										
									 <div class="box-footer">
                                        <input type="submit" name="loan_cat" value="Add Category" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function update_user_content($all_details){
echo '<div class="box box-primary" style="width:80%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Edit Profile</h3>
                                </div>
                               <input type="hidden" name="editMode" id="editMode" value="true"/>
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" id="update_form" onsubmit="submitform (document.getElementById(\'update_form\'), \'catacata.php\', \'response\'); return false;" name="update_form" method="post" enctype="multipart/form-data">

									<div class="form-group">
                                            <label for="surname">Surname</label>
                                            <input type="text" class="form-control" value="'.stripslashes($all_details['surname']).'" name="surname" required placeholder="Surname" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control" value="'.stripslashes($all_details['firstname']).'" name="firstname" required placeholder="firstname" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="othername">Othername</label>
                                            <input type="text" class="form-control" value="'.stripslashes($all_details['othername']).'" name="othername" required placeholder="Othername" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="phonenumber">Phone Number</label>
                                            <input type="tel" class="form-control" name="phonenumber" value="'.stripslashes($all_details['phone_number']).'" required placeholder="Phone number" />
                                         
                                        </div>
										<div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea cols="3" rows="5" class="form-control" name="address" placeholder=" Address ">'.stripslashes($all_details['address']).'</textarea>
                                         
                                        </div>
										
									 <div class="box-footer">
                                        <input type="submit" name="update_profile" value="Update Profile" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function add_matric($matric){
$sql = "INSERT INTO `users` SET 
`matric`='{$matric}'";
$result = query($sql);
return $result;
}
function set_admin_logged_in_status($username,$status){
$sql = "UPDATE `admin` SET `logged_in`='$status' WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}
function is_user_logged_in_already($username){
$sql = "SELECT * FROM `admin` WHERE `username`='{$username}' &&`logged_in`='true'";
$result = query($sql);
return($result->num_rows > 0 ) ? true : false;
}

function delete_chat($username){
$sql = "DELETE FROM `frei_session` WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}

function is_student_user_in_already($username){
$sql = "SELECT * FROM `users` WHERE `username`='{$username}' &&`presence`='true'";
$result = query($sql);
return($result->num_rows > 0 ) ? true : false;
}
function check_if_user_is_activated($username){
$sql = "SELECT * FROM `users` WHERE `username`='{$username}' &&  `status`='activate'";
$result = query($sql);
return($result->num_rows > 0 ) ? true : false;
}
function check_for_month_year($month,$year){
$sql = "SELECT * FROM `ledger` WHERE `month`='{$month}' AND `year`='{$year}'";
$result  = query($sql);
return($result->num_rows > 0 ) ? true : false;
}


function reset_user_student($username,$presence){
$sql = "UPDATE `users` SET `presence`='{$presence}' WHERE `username`='{$username}'";
$result = query($sql);
return $result;
}
function is_matric_student($matric){
$sql = "SELECT * FROM `users` WHERE `matric`='{$matric}'";
$result = query($sql);
	return($result->num_rows > 0 ) ? true : false;
}
function register_matric_txt(){

echo '<div class="box box-primary" style="width:50%;margin: 0 auto;">
                                <div class="box-header" style="width:70%;margin: 0 auto;">
                                    <h3 class="box-title">Add Students</h3>
                                </div>
                               
                                    <div class="box-body" style="width:80%; margin: 0 auto;">
									<form name="" role="form" action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">
<div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <input type="file" name="matric" id="exampleInputFile" required>
                                             <p class="help-block">File Format must be .txt (i.e a text file)</p>
                                        </div>
									

									 <div class="box-footer">
                                        <input type="submit" name="upload_matric_txt" value="Upload Matric" class="btn btn-primary"/>
                                    </div>

</form></div></div>';
}
function form_modal(){
echo '<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
                    </div>
                    <form action="'.$_SERVER['PHP_SELF'].'" method="post" autocomplete="on" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
							
                                <div class="input-group">
								
                                    <span class="input-group-addon">TO:</span>
                                    <input name="email_toc" type="text" class="form-control" required placeholder="Username TO">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">CC:</span>
                                    <input name="email_tocc" type="text" class="form-control" placeholder="Username CC">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">BCC:</span>
                                    <input name="email_tobcc" type="text" class="form-control" placeholder="Username BCC">
                                </div>
                            </div>
							<div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">SUBJECT:</span>
                                    <input name="subject" type="text" class="form-control" placeholder="Subject" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="message" id="email_message"  required class="form-control" placeholder="Message" style="height: 120px;"></textarea>
                            </div>
                            <div class="form-group">                                
                                <div class="btn btn-success btn-file">
                                    <i class="fa fa-paperclip"></i> Attachment
                                    <input type="file" name="attachment"/>
                                </div>
                                <p class="help-block">Max. 10MB</p>
                            </div>

                        </div>
                        <div class="modal-footer clearfix">
<button type="submit" class="btn btn-success " name="save_as"><i class="fa  fa-archive"></i> Save as Draft</button>
   
                            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                          
							<button type="submit" class="btn btn-primary pull-left" name="send_message"><i class="fa fa-envelope"></i> Send Message</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
';
}



?>