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
            <a href="admin.php" class="logo">
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

      <!-- Content Wrapper. Contains page content -->
        <!-- Right side column. Contains the navbar and content of the page -->
           
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo adminSelectLoanStatuses("pending"); ?></h3>
                  <p>Pending Loan Application</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios7-infinite"></i>
                </div>
                <a href="admin.php?app_loan" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>&#8358;<?php echo number_format(adminSelectAllSavingsHere(), 0, '.', ','); ?></h3>
                  <p>Total Savings</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="admin.php?view_generated_ledger" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>&#8358;<?php echo  number_format(adminLoanAmountPaid(), 0, '.', ','); ?></h3>
                  <p>Loans Payable</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="admin.php?app_loan" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo count(selectAllUsername());?></h3>
                  <p>Total Members</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="admin.php?view_user" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                 
                  <li class="active"><a href="#container" data-toggle="tab">Pie</a></li>
                  <li class="pull-left header"><i class="fa fa-inbox"></i> Deductions</li>
                </ul>
                <div class="tab-content no-padding">
                  <!-- Morris chart - Sales -->
                  
                 
                  <div class="chart tab-pane active" id="container" style="position: relative; height: 440px; width:100% "></div>
                </div>
              </div><!-- /.nav-tabs-custom -->

           
               
                     <?php 
					 $data = deductionsDisplay();
					 $all_sav_cat = get_all_from_savings_cat();
					 $all_sav_cat[] = "loan";					 
                     ?>
              
              
          
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                  <li class="active"><a href="#containerLine" data-toggle="tab">Bar</a></li>
                 
                  <li class="pull-left header"><i class="fa fa-inbox"></i> Deductions</li>
                </ul>
                <div class="tab-content no-padding">
                  <!-- Morris chart - Sales -->
                  
                  <div class="chart tab-pane active" id="containerLine" style="position: relative; height: 440px;width:100% "></div>
                
                </div>
              </div><!-- /.nav-tabs-custom -->

           <?php 
					 $data = deductionsDisplay();
					 $all_sav_cat = get_all_from_savings_cat();
					 $all_sav_cat[] = "loan";					 
                     ?>
              
              
              
          
            </section><!-- /.Left col -->
            
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
        </aside>
      </div><!-- /.content-wrapper -->
      

    
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

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

.highcharts-container{
	
	position:relative;
	width:100% !important;
	overflow-x:scroll;

	}
</style>

       
		 <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- Page script -->
      
		<link rel="stylesheet" href="../freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
                
                <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
   <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.../js/2.10.2/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 --> 
    
    
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    
    
    
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
   
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/../js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    
         <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script src="../js/HighchartsAdapter.js"></script>
<script src="../js/HighchartsAdapter.src.js"></script>
<script src="../js/runOnLoad.js"></script>
<script src="../js/runOnLoad.src.js"></script>
   
    <style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
                    // Build the chart
        runOnLoad(function(){
  new Highcharts.Chart({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                renderTo : 'container',
                type: 'pie'
            },
            title: {
                text: 'Monthly Ledger of <?php echo date("F, Y", strtotime(dateData())); ?>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
					size:'100%',
                    allowPointSelect: true,
                    cursor: 'pointer',
                    
					dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                     }
					},
                    showInLegend: true
                }
            },
            series: [{
                name: 'Category',
                colorByPoint: true,
                data: [
                    <?php
                      foreach($all_sav_cat as $save){
                      $name = $save;
                        $value = $data[''.$save.''];
                        echo "{ name: '$name' ,y: $value  },";
                     }
                  
                    ?>
                        ]
            }]
        });
        
		 new Highcharts.Chart({   
        chart: {
            type: 'column',
            renderTo : 'containerLine',
        },
        title: {
            text: 'Monthly Ledger of <?php echo date("F, Y", strtotime(dateData())); ?>'
        },
        subtitle: {
            text: 'Source: Co-operative monthly ledger '
        },
        xAxis: {
            categories: [
                'Deductions Categories',
                
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Amount  (Naira)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} Naira</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
			width:'100%',
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
  <?php
                      foreach($all_sav_cat as $save){
                      $name = $save;
                        $value = $data[''.$save.''];
                        echo "{ name: '$name' ,data: [$value]  },";
                     }
                  
                    ?>
]
    });
    
		
		
		});
    
    
        
        
   
        
        
         
  
		</script>
                 <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
                
                 
                 
                 
                 
                  <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
		<script src="../js/xmlhttps.js" type="text/javascript"></script>
        
         <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
     
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chart../js/Chart.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js"></script>
    <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    <script src="../js/xmlhttps.js" type="text/javascript"></script>
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
 




        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        
        <!-- AdminLTE App -->
		
     
<style type="text/css">
input[type="text"]{
min-height:25px;
}
</style>

      <link rel="stylesheet" href="../freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
        
  </body>
</html>




