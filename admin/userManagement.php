<?php
session_start();
?>
<?php
require("form functions.php");
require("db_page.php");
?>
<?php
$_SESSION['helpdesk_page']="dispatch monitor report.php";

?>
<?php
//$db=new mysqli("localhost","root","","helpdesk_backup");
$db=retrieveHelpdeskDb();
$sql="select * from dispatch_staff inner join login  on dispatch_staff.id=login.username where dispatch_staff.id='".$_SESSION['username']."'";

$rs=$db->query($sql);
$userRow=$rs->fetch_assoc();
?>
<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/style-responsive.min.css" rel="stylesheet" />
	<link href="css/retina.css" rel="stylesheet" />
<script language='javascript'>
function selectOption(elementName,elementValue){
	var elm=document.getElementById(elementName);

	for(i=0;i<elm.options.length;i++){
		if(elm.options[i].value==elementValue){
			elm.options[i].selected=true;
		}
	}

}
</script>
	<title>Dispatcher Monitoring Report</title>
	<?php
		
		$conditionClause=" where ";
		
		$m=0;
		//$unitClause="";
		/**
		if($_POST['unit_filter']==""){
		}
		
		
		else {
			$unitClause=" unit_id='".$_POST['unit_filter']."'";
			$m++;
			
			if($m>1){
				$conditionClause.=" and ".$unitClause;
			}
			
			else {
				$conditionClause.=$unitClause;
			
			}
			
		}
		
		$issueClause="";
		if($_POST['issue_filter']==""){
		}
		else {
			$issueClause=" classification_id='".$_POST['issue_filter']."'";
			$conditionClause.=$issueClause;
		}
		*/
		$staffClause=" ";
		if($_POST['dispatch_staffer']==""){
		}
		else {
			$staffClause=" dispatch_staffer='".$_POST['dispatch_staffer']."'";
			$m++;
			if($m>1){
				$conditionClause.=" and ".$staffClause;
			}
			else {
				$conditionClause.=$staffClause;
			
			}

		}

		if($_POST['date_filter']==""){
			$periodMonth=date("Y-m-d");
		
			$periodClause=" login_time like '".$periodMonth."%%'";
			$m++;
			
			if($m>1){
				$conditionClause.=" and ".$periodClause;
			}
			else {
				$conditionClause.=$periodClause;
			
			}
			$fromYear=date("Y");
			$toYear=$fromYear;
		}
		else {
			if($_POST['date_filter']=="dRange"){
				$periodMonthbeginning=date("Y-m-d",strtotime($_POST['from_date']));
				$periodMonthend=date("Y-m-d",strtotime($_POST['to_date']));
				
				$periodClause=" login_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";

				$fromYear=$_POST['fromYear'];
				$fromMonth=$_POST['fromMonth'];
				$fromDay=$_POST['fromDay'];
				$toYear=$_POST['toYear'];
				$toMonth=$_POST['toMonth'];
				$toDay=$_POST['toDay'];
			}
			else if($_POST['date_filter']=="daily"){
				$periodMonth=date("Y-m-d");


				$periodClause=" login_time like '".$periodMonth."%%'";
			}
			else if($_POST['date_filter']=="weekly"){
				$periodMonthbeginning=date("Y-m-d",strtotime($_POST['from_date']));
				$periodMonthend=date("Y-m-d",date("Y-m-d",strtotime($_POST['date'])."+6 days"));

				$periodClause=" login_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
				$fromYear=$_POST['fromYear'];
				$fromMonth=$_POST['fromMonth'];
				$fromDay=$_POST['fromDay'];
				$toYear=date('Y',strtotime($periodMonthend))*1;
				$toMonth=date('m',strtotime($periodMonthend))*1;
				$toDay=date('d',strtotime($periodMonthend))*1;

			}
			else if($_POST['date_filter']=="monthly"){
				$periodMonth=date("Y-m",strtotime($_POST['from_date']));
				$periodClause=" login_time like '".$periodMonth."%%'";
				
				$fromYear=$_POST['fromYear'];
				$fromMonth=$_POST['fromMonth'];
				$fromDay=$_POST['fromDay'];
				$toYear=$_POST['toYear'];
				$toMonth=$fromMonth;
				$toDay=30;
			}

			else {
				$periodMonth=date("Y");
				$periodClause=" login_time like '".$periodMonth."%%'";
				
				
				$fromYear=$_POST['fromYear'];
				$fromMonth=1;
				$fromDay=1;
				$toYear=$fromYear;
				$toMonth=12;
				$toDay=31;
				
			}

			$m++;

			
			if($m>1){
				$conditionClause.=" and ".$periodClause;
			}
			else {
				$conditionClause.=$periodClause;
			
			}

		}
//		$db=new mysqli("localhost","root","","helpdesk_backup");
		$db=retrieveHelpdeskDb();
		$new_sql="select * from dispatch_track ".$conditionClause." order by login_time desc";
		?>
	<script language="javascript">
	
	function openPrint(url){
		window.open(url);
	
	}
	</script>
	<body style="background-image:url('body background.jpg');">

	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a id="main-menu-toggle" class="hidden-phone open"><i class="icon-reorder"></i></a>		
				<div class="row-fluid">
				<a class="brand span2" href="index.html"><span>Helpdesk System</span></a>
				</div>		
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">

						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
								<div class="user">
									<span class="hello">Administrator: </span>
									<span class="name"><?php echo $userRow['staffer']; ?></span>
								</div>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title">
									
								</li>
								<!--
								<li><a href="#"><i class="icon-user"></i> Profile</a></li>
								<li><a href="#"><i class="icon-cog"></i> Settings</a></li>
								<li><a href="#"><i class="icon-envelope"></i> Messages</a></li>
								-->
								<li><a href="logout.php"><i class="icon-off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
		
	
	
		<div class="container-fluid-full" style='height:200%'>
		<div class="row-fluid">
				
			<!-- start: Main Menu -->

			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				
				
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">

						<li><a href="userManagement.php"><i class="icon-dashboard"></i><span class="hidden-tablet">Configure Helpdesk Staff</span></a></li>
						<li><a href="taskmonitor.php"><i class="icon-eye-open"></i><span class="hidden-tablet">Incoming Client Requests</span></a></li>
						<li><a href="pendingRequests.php"><i class="icon-tasks"></i><span class="hidden-tablet">Pending Requests</span></a></li>
						<li><a href="dispatch monitor report.php"><i class="icon-tasks"></i><span class="hidden-tablet">Dispatcher Status Report</span></a></li>
						<li><a href="task monitor report.php"><i class="icon-bar-chart"></i><span class="hidden-tablet">Monthly Requests Report</span></a></li>
						<li><a href="equipment statistics report.php"><i class="icon-bar-chart"></i><span class="hidden-tablet">Equipment Statistics Report</span></a></li>

					</ul>
				</div>
			</div>	
			<div id="content" class="span10">
			
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tasks"></i><span class="break"></span>Edit Helpdesk Staff</h2>
						<div class="box-icon">
							<a href="#" id='filterResults'><i class="icon-calendar"></i></a>
							<a href="#" id='' onclick='openPrint("print_outline2.php")'><i class="icon-print"></i></a>

						</div>

					</div>				
					<div class="box-content">		
						Under Construction.  Check in later for updates.
					</div>
				</div>
			</div>	
		</div>
		</div>
	<?php
	echo "
	<script language='javascript'>
	selectOption('fromYear','".$fromYear."');
	selectOption('fromMonth','".$fromMonth."');
	selectOption('fromDay','".$fromDay."');
	selectOption('toYear','".$toYear."');
	selectOption('toMonth','".$toMonth."');
	selectOption('toDay','".$toDay."');
	</script>
	";
	?>
	</body>
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/jquery-migrate-1.2.1.min.js"></script>	
			<script src="js/jquery-ui-1.10.3.custom.min.js"></script>	
			<script src="js/jquery.ui.touch-punch.js"></script>	
			<script src="js/modernizr.js"></script>	
			<script src="js/bootstrap.min.js"></script>	
			<script src="js/jquery.cookie.js"></script>	
			<script src='js/fullcalendar.min.js'></script>	
			<script src='js/jquery.dataTables.min.js'></script>
			<script src="js/excanvas.js"></script>
		<script src="js/jquery.flot.js"></script>
		<script src="js/jquery.flot.pie.js"></script>
		<script src="js/jquery.flot.stack.js"></script>
		<script src="js/jquery.flot.resize.min.js"></script>
		<script src="js/jquery.flot.time.js"></script>
		
		<script src="js/jquery.chosen.min.js"></script>	
		<script src="js/jquery.uniform.min.js"></script>		
		<script src="js/jquery.cleditor.min.js"></script>	
		<script src="js/jquery.noty.js"></script>	
		<script src="js/jquery.elfinder.min.js"></script>	
		<script src="js/jquery.raty.min.js"></script>	
		<script src="js/jquery.iphone.toggle.js"></script>	
		<script src="js/jquery.uploadify-3.1.min.js"></script>	
		<script src="js/jquery.gritter.min.js"></script>	
		<script src="js/jquery.imagesloaded.js"></script>	
		<script src="js/jquery.masonry.min.js"></script>	
		<script src="js/jquery.knob.modified.js"></script>	
		<script src="js/jquery.sparkline.min.js"></script>	
		<script src="js/counter.min.js"></script>	
		<script src="js/raphael.2.1.0.min.js"></script>
		<script src="js/justgage.1.0.1.min.js"></script>	
		<script src="js/jquery.autosize.min.js"></script>	
		<script src="js/retina.js"></script>
		<script src="js/jquery.placeholder.min.js"></script>
		<script src="js/wizard.min.js"></script>
		<script src="js/core.min.js"></script>	
		<script src="js/charts.min.js"></script>	
		<script src="js/custom.min.js"></script>
		<script src="js/additional_function4.js"></script>
