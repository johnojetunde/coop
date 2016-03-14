<?php
include("inc/show_time.php");


if(isset($_GET['check_matric'])){
$matric = stripslashes($_GET['check_matric']);
$is_matric = is_matric_student($matric);
if($is_matric){
echo "<span style='color:green;'> <i class='fa fa-check'></i> Matric Number registered </span>";
}else{
echo "<span style='color:red;'> <i class='fa fa-ban'></i> Matric is Not Registered </span>";
}
}


?>