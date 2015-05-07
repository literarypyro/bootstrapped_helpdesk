<?php
session_start();
?>
<?php
$_SESSION['helpdesk_page']="taskmonitor.php";
?>
<?php
require("db_page.php");
if(isset($_POST['change_task'])){

	
	//$db=new mysqli("localhost","root","","helpdesk_backup");
	$db=retrieveHelpdeskDb();
	$sql="update task set status='Acknowledged' where id='".$_POST['change_task']."'";
	$rs=$db->query($sql);	
	
	$_SESSION['service_call']=$_POST['change_task'];
 	echo "
	<script language='javascript'>
	window.open('print_outline2.php');
	</script>"; 
}
?>
<?php
$db=retrieveHelpdeskDb();

//$db=new mysqli("localhost","root","","helpdesk_backup");
$sql="select * from dispatch_staff inner join login  on dispatch_staff.id=login.username where dispatch_staff.id='".$_SESSION['username']."'";
$rs=$db->query($sql);
$userRow=$rs->fetch_assoc();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/style-responsive.min.css" rel="stylesheet" />
	<link href="css/retina.css" rel="stylesheet" />
<!--
<meta http-equiv="refresh" content="5;url=scanMessages.php" />
-->
	<body style="background-image:url('body background.jpg');">

	<div id='alert_sound'></div>


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
									<span class="hello">Computer Section Personnel: </span>
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
<!--	

	-->
	<!--Heading Table-->
		<div class="container-fluid-full" style='height:200%'>
		<div class="row-fluid">
				
			<!-- start: Main Menu -->

			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				
				
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a id="ASSIGN_REQUEST" <?php if($_SESSION['helpdesk_page']=="taskmonitor.php"){ echo "class='active'";  } ?> href="taskmonitor.php"><i class="icon-user"></i><span class="hidden-tablet">Assigned Client Requests</span></a></li>
						<li><a id="UPDATE" <?php if($_SESSION['helpdesk_page']=="dispatchTrack.php"){ echo "class='active'";  } ?> href="dispatchTrack.php"><i class="icon-pushpin"></i><span class="hidden-tablet">Update Staff Location</span></a></li>
						<li><a id="ACCOMPLISH" <?php if($_SESSION['helpdesk_page']=="submitAccomplishment.php"){ echo "class='active'";  } ?> href="submitAccomplishment.php"><i class="icon-edit"></i><span class="hidden-tablet">Submit an Accomplishment</span></a></li>
						<li><a id="FOR_PRINTOUT" <?php if($_SESSION['helpdesk_page']=="task_printout.php"){ echo "class='active'"; } ?> href="task_printout.php"><i class="icon-print"></i><span class="hidden-tablet">Prepare Request Printout</span></a></li>
						<li><a id="CLIENT_REPORT" <?php if($_SESSION['helpdesk_page']=="task monitor report.php"){ echo "class='active'";  } ?> href="task monitor report.php"><i class="icon-dashboard"></i><span class="hidden-tablet">Monitoring Report</span></a></li>






					</ul>
				</div>
			</div>	
			<div id="content" class="span10">
			
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tasks"></i><span class="break"></span>Online Client Requests</h2>
						<div class="box-icon">
							<a href="#" id='takeResults' title='Take Request'><i class="icon-bookmark"></i></a>

						</div>

					</div>				
					<div class="box-content">		
					
						<table class="table table-striped table-bordered bootstrap-datatable datatable2"  width=100%>
						<thead>
						<tr>
						<th>Reference Number</th>
						<th>Client Name</th>
						<th>Office</th>
						<th>Unit Type</th>
						<th>Problem Concern</th>
						<th>Request Time</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$db=retrieveHelpdeskDb();
						//$db=new mysqli('localhost','root','','helpdesk_backup');
						$sql="select (select count(*) from forward_task where id=task.id) as forward_count,task.* from task where (select count(*) from accomplishment where task_id=task.id)=0 and dispatch_staff='".$_SESSION['username']."' order by dispatch_time desc";

						$rs=$db->query($sql);
						$nm=$rs->num_rows;
						$count=$nm;
						$routing_Option="<select name='change_task'>";
						for($i=0;$i<$nm;$i++){
							$row=$rs->fetch_assoc();
							
							$sql2="select * from computer where id='".$row['unit_id']."'";
							$rs2=$db->query($sql2);
							$row2=$rs2->fetch_assoc();
							
							$sql3="select * from classification where id='".$row['classification_id']."'";
							$rs3=$db->query($sql3);
							$row3=$rs3->fetch_assoc();
								
						?>
						<tr>
							
							<?php
							if($row['forward_count']>0){
								$tableStyle=" style='background-color:red;color:white;' ";
							}
							else {
								$tableStyle=" style='color:black;'";
							}
							?>
							<td <?php echo $tableStyle; ?>><b><?php echo $row['reference_number']; ?></b></font></td>
							<td <?php echo $tableStyle;  ?>><?php echo $row['client_name']; ?></td>
							<td <?php echo $tableStyle;  ?>><?php echo $row['division_id']; ?></td>
							<td <?php echo $tableStyle;  ?>><?php echo $row2['unit']; ?></td>
							<td <?php echo $tableStyle;  ?>><?php echo $row3['type']; ?></td>
							<td <?php echo $tableStyle;  ?>><?php echo date("F d, Y h:ia",strtotime($row['dispatch_time'])); ?></td>
						</tr>
						<?php
							$routing_Option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
						}
						$routing_Option.="</select>";
						?>
						</tbody>
						</table>
					
					
					</div>
				</div>
			</div>
			</div>
	
	

		<div class="modal hide fade" id="takeCall">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Take Request</h3>
			</div>
			<form class="form-horizontal" id='checkForm' name='checkForm' action='taskmonitor.php' method='post'/>

			<div class="modal-body">	
				<div class="control-group">
				  <label class="control-label">Take Task/Generate Service Call</label>
				  <div class="controls">
						<?php echo $routing_Option; ?>
				  </div>
				</div>	
				
			</div>	
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<button type='submit' class="btn btn-primary" value='Process'>Process </button>
			</div>
			  </form>
	
		</div>				



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
		<script src="js/additional_function.js"></script>

</html>