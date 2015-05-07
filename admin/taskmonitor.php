<?php
session_start();
?>
<?php
$_SESSION['helpdesk_page']="taskmonitor.php";
?>
<?php
require("db_page.php");
?>
<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
if(isset($_POST['change_task'])){
	$msg=$_POST['client_name'];
	$msg="You have a new message";

	$filename  = "../helpdesk/data/helpdesk_".$_POST['change_staffer'].".txt";
		
	if(file_exists($filename)){
	}
	else {
		fopen($filename,'w');	
	}
	file_put_contents($filename,$msg);		
	
//	$db=new mysqli("localhost","root","","helpdesk_backup");
	$db=retrieveHelpdeskDb();
	$sendTime=date("Y-m-d H:i:s");
	
	$sql="update task set dispatch_staff='".$_POST['change_staffer']."',admin_time='".$sendTime."', status='Dispatched' where id='".$_POST['change_task']."'";
	$rs=$db->query($sql);	
	
	//$sql2="insert into forward_task (select id,client_name,division_id,unit_id,classification_id  from task where id='".$_POST['change_task']."')";
	//$rs=$db->query($sql2);	
	
	$sql3="insert into taskadmin(task_id,admin_id) values ('".$_POST['change_task']."','".$_SESSION['username']."')";
	$rs=$db->query($sql3);	
}

if(isset($_POST['delete_task'])){
	$db=retrieveHelpdeskDb();
	$sql="delete from task where id='".$_POST['delete_task']."'";
	$rs=$db->query($sql);
	$msg="Task deleted.";
}






if(isset($_POST['reassign_task'])){
	$msg=$_POST['client_name'];
	$msg="You have a new message";

	$filename  = "../helpdesk/data/helpdesk_".$_POST['reassign_staffer'].".txt";
		
	if(file_exists($filename)){
	}
	else {
		fopen($filename,'w');	
	}
	file_put_contents($filename,$msg);		
	
	$db=retrieveHelpdeskDb();
	$sendTime=date("Y-m-d H:i:s");
	
	$sql="update task set dispatch_staff='".$_POST['reassign_staffer']."',admin_time='".$sendTime."', status='Dispatched' where id='".$_POST['reassign_task']."'";
	$rs=$db->query($sql);
	


}


?>
<?php
//$db=new mysqli("localhost","root","","helpdesk_backup");
$db=retrieveHelpdeskDb();
$sql="select * from dispatch_staff inner join login  on dispatch_staff.id=login.username where dispatch_staff.id='".$_SESSION['username']."'";
$rs=$db->query($sql);
$userRow=$rs->fetch_assoc();
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta http-equiv="refresh" content="120;url=taskmonitor.php" />

<!--
<meta http-equiv="refresh" content="5;url=scanMessages.php" />
-->
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/style-responsive.min.css" rel="stylesheet" />
	<link href="css/retina.css" rel="stylesheet" />
	
<!--	
<script type="text/javascript" src="prototype.js"></script>
	-->
	<body style="background-image:url('body background.jpg');height:100%;">

	<div id='alert_sound'></div>
	<!--Heading Table-->
		<!-- start: Header -->
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
	<!-- start: Header -->

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
			<!-- end: Main Menu -->
						


			<div id="content" class="span10">
			
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tasks"></i><span class="break"></span>Online Client Requests</h2>
						<div class="box-icon">
							<a href="#" id='assign_task'><i class="icon-user"></i></a>
							<a href="#" id='delete_task'><i class="icon-minus-sign"></i></a>

						</div>

					</div>				
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">

						
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
				//$db=new mysqli('localhost','root','','helpdesk_backup');
				$db=retrieveHelpdeskDb();
				$sql="select (select count(*) from forward_admin where id=task.id) as forward_count,task.* from task where (select count(*) from accomplishment where task_id=task.id)=0 and (dispatch_staff is null or dispatch_staff='') order by dispatch_time desc";
				$rs=$db->query($sql);


				$sql2="update task set status='Administrator' where (select count(*) from accomplishment where task_id=task.id)=0 and (dispatch_staff is null or dispatch_staff='')";

				$rs2=$db->query($sql2);



				$nm=$rs->num_rows;
				$count=$nm;
				$routing_Option="<select name='change_task'>";
				$delete_option="<select name='delete_task'>";
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
						$tableStyle=" style='background-color:red;' ";
					}
					else {
						$tableStyle="";
					}
					?>
					<td <?php echo $tableStyle; ?>><font color=""><b><?php echo $row['reference_number']; ?></b></font></td>
					<td <?php echo $tableStyle;  ?>><font color=""><?php echo $row['client_name']; ?></font></td>
					<td <?php echo $tableStyle;  ?>><font color=""><?php echo $row['division_id']; ?></font></td>
					<td <?php echo $tableStyle;  ?>><font color=""><?php echo $row2['unit']; ?></font></td>
					<td <?php echo $tableStyle;  ?>><font color=""><?php echo $row3['type'].", ".$row['problem_details']; ?></font></td>
					<td <?php echo $tableStyle;  ?>><font color=""><?php echo date("F d, Y h:ia",strtotime($row['dispatch_time'])); ?></font></td>
				</tr>
				<?php
					$routing_Option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
					$delete_option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
					
				}
				$routing_Option.="</select>";
				$delete_option.="</select>";
				
				
				$routing_assign=$routing_Option;
				$delete_assign=$delete_option;
				?>
				</tbody>
				</table>
				
				</div>	
				</div>
			</div>


			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tasks"></i><span class="break"></span>Re-Assign Client Requests</h2>
						<div class="box-icon">
							<a href="#" id="reassign_task"><i class="icon-user"></i></a>
							<a href="#" id='delete_task2'><i class="icon-minus-sign"></i></a>
							<a href="#" title="Print" onclick='window.open("report generation.php")'><i class="icon-print"></i></a>

						</div>

					</div>				
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">

						
						<thead>						
						<tr>
						<th>Reference Number</th>
						<th>Client Name</th>
						<th>Office</th>
						<th>Unit Type</th>
						<th>Problem Concern</th>
						<th>Dispatch Time</th>
						<th>Dispatch Staff</th>

						</tr>
						</thead>
				<tbody>
				<?php
				//$db=new mysqli('localhost','root','','helpdesk_backup');
						$yearDate=date("Y-m-d",strtotime(date("Y-m-d")."-1 year"));


						$db=retrieveHelpdeskDb();
						$sql="select (select staffer from dispatch_staff where id=task.dispatch_staff) as staffer,(select count(*) from forward_admin where id=task.id) as forward_count,task.* from task inner join dispatch_staff on task.dispatch_staff=dispatch_staff.id where (select count(*) from accomplishment where task_id=task.id)=0 and (dispatch_staff is not null) and (dispatch_staff not in ('')) and dispatch_time>'".$yearDate."' order by dispatch_time desc ";

						$rs=$db->query($sql);
						$nm=$rs->num_rows;
						$count=$nm;
						
						
						
						
						
				$routing_Option="<select name='reassign_task'>";
				$delete_option="<select name='delete_task'>";
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
							<td ><font color=""><b><?php echo $row['reference_number']; ?></b></font></td>
							<td ><font color=""><?php echo $row['client_name']; ?></font></td>
							<td ><font color=""><?php echo $row['division_id']; ?></font></td>
							<td ><font color=""><?php echo $row2['unit']; ?></font></td>
							<td ><font color=""><?php echo $row3['type'].", ".$row['problem_details']; ?></font></td>
							<td ><font color=""><?php echo date("F d, Y h:ia",strtotime($row['admin_time'])); ?></font></td>
							<td ><font color=""><?php echo $row['staffer']; ?></font></td>

						</tr>
				<?php
					$routing_Option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
					$delete_option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
					
				}
				$routing_Option.="</select>";
				$delete_option.="</select>";

				$routing_reassign=$routing_Option;
				$delete_reassign=$delete_option;

				?>
				</tbody>
				</table>
				
				</div>	
				</div>
			</div>

			
			
			</div><!--/row-->
						
			</div>			

			</div>

		</div>
		</div>


		<div class="modal hide fade" id="assignModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Assign Task</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal"  action='taskmonitor.php' method='post'/>
				  <fieldset>
							<div class="control-group">
							  <label class="control-label">Task</label>
							  <div class="controls">
								<?php echo $routing_assign; ?>
							  </div>
							</div>				  
				  			
							<div class="control-group">
							  <label class="control-label" for="office_name">Staffer</label>
							  <div class="controls">
									<select name='change_staffer'>
									<?php
									//$db=new mysqli('localhost','root','','helpdesk_backup');
									$db=retrieveHelpdeskDb();
									$sql="select * from dispatch_staff inner join login on dispatch_staff.id=login.username";

									$rs=$db->query($sql);
									$nm=$rs->num_rows;
									for($i=0;$i<$nm;$i++){

									$row=$rs->fetch_assoc();
									?>
										<option value='<?php echo $row['id']; ?>'><?php echo $row['staffer']; ?></option>
									<?php

									}

									?>
									</select>
							  </div>
							</div>						
	  

				
				</fieldset>

				</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>



		<div class="modal hide fade" id="assignModal2">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Re-assign Task</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action='taskmonitor.php' method='post'/>
				  <fieldset>
							<div class="control-group">
							  <label class="control-label">Task</label>
							  <div class="controls">
								<?php echo $routing_reassign; ?>
							  </div>
							</div>				  
				  			
							<div class="control-group">
							  <label class="control-label" for="office_name">Staffer</label>
							  <div class="controls">
									<select name='change_staffer'>
									<?php
									//$db=new mysqli('localhost','root','','helpdesk_backup');
									$db=retrieveHelpdeskDb();
									$sql="select * from dispatch_staff inner join login on dispatch_staff.id=login.username";

									$rs=$db->query($sql);
									$nm=$rs->num_rows;
									for($i=0;$i<$nm;$i++){

									$row=$rs->fetch_assoc();
									?>
										<option value='<?php echo $row['id']; ?>'><?php echo $row['staffer']; ?></option>
									<?php

									}

									?>
									</select>
							  </div>
							</div>						
	  

				
				</fieldset>

				</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		
		<div class="modal hide fade" id="deleteModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Task</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action='taskmonitor.php' method='post'/>
				  <fieldset>
							<div class="control-group">
							  <label class="control-label">Task</label>
							  <div class="controls">
								<?php echo $delete_assign; ?>
							  </div>
							</div>				  
				  			
  

				
				</fieldset>

				</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>		


		<div class="modal hide fade" id="deleteModal2">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Task</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action='taskmonitor.php' method='post' />
				  <fieldset>
							<div class="control-group">
							  <label class="control-label">Task</label>
							  <div class="controls">
								<?php echo $delete_reassign; ?>
							  </div>
							</div>				  
				  			
  

				
				</fieldset>

				</form>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>		

		<!-- start: JavaScript-->
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
		<!-- end: JavaScript-->


</body>

<style type='text/css'>
.fa-rotate-45 {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg);
}


</style>
</html>