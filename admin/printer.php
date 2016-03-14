<html>
<?php require("../inc/show_time.php"); ?>
<head>
<title>Print Out Page</title>
</head>
<body onload="window.print();">
<?php 

 if(isset($_GET['period'])){

$period = $_GET['period'];
echo '<p align="right"><a  href="admin.php?view_generated_ledger">Go Back</a></p>';
$year = date('Y');

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
else{
get_annual_period_ledger($period,5);
}
}
?>
</body>
</html>