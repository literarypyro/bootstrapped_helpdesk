<?php
session_start();
?>
<?php
require("form functions.php");
require("db_page.php");
?>
<?php
$_SESSION['helpdesk_page']="pendingRequests.php";

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
	<title>Pending Requests</title>
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
			$staffClause=" (dispatch_staff is not null and dispatch_staff not in ('')) ";
			$m++;
			if($m>1){
				$conditionClause.=" and ".$staffClause;
			}
			else {
				$conditionClause.=$staffClause;
			
			}

		}
		else {
			$staffClause=" dispatch_staff='".$_POST['dispatch_staffer']."'";
			$m++;
			if($m>1){
				$conditionClause.=" and ".$staffClause;
			}
			else {
				$conditionClause.=$staffClause;
			
			}

		}

		if($_POST['date_filter']==""){
			$periodMonth=date("Y-m");
		
			$periodClause=" dispatch_time like '".$periodMonth."%%'";



			$m++;
			
			if($m>1){
				$conditionClause.=" and ".$periodClause;
				
			}
			else {
				$conditionClause.=$periodClause;
			
			}
			

		}
		else {
			if($_POST['date_filter']=="dRange"){
				$periodMonthbeginning=date("Y-m-d",strtotime($_POST['from_date']));
				$periodMonthend=date("Y-m-d",strtotime($_POST['to_date']));
				
				$periodClause=" dispatch_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
			}
			else if($_POST['date_filter']=="daily"){
				$periodMonth=date("Y-m-d");

				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}
			else if($_POST['date_filter']=="weekly"){
				$periodMonthbeginning=date("Y-m-d",strtotime($_POST['from_date']));
				$periodMonthend=date("Y-m-d",date("Y-m-d",strtotime($_POST['date'])."+6 days"));

				$periodClause=" dispatch_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
			}
			else if($_POST['date_filter']=="monthly"){
				$periodMonth=date("Y-m",strtotime($_POST['from_date']));
				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}

			else {
				$periodMonth=date("Y-m-d");
				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}

			$m++;

			
			if($m>1){
				$conditionClause.=" and ".$periodClause;
			}
			else {
				$conditionClause.=$periodClause;
			
			}
//			echo $conditionClause;

		}
		$_SESSION['clause']=$conditionClause;
		//$db=new mysqli("localhost","root","","helpdesk_backup");
		$db=retrieveHelpdeskDb();
//		$db=localOnlyDb();
		$noClause=" (select count(*) from accomplishment where task_id=task.id)=0";
		if($conditionClause==""){
			$taskClause="where ".$noClause;
		}
		else {
			$taskClause=$conditionClause." and ".$noClause; 
		}
		$new_sql="select * from task ".$taskClause." order by dispatch_time desc";

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
	<!--Heading Table-->
			<div id="content" class="span10">
			
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tasks"></i><span class="break"></span>Needing Accomplishments</h2>
						<div class="box-icon">
							<a href="#" id='filterResults'><i class="icon-calendar"></i></a>

						</div>

					</div>				
					<div class="box-content">

			<br>
				<?php
				$new_rs=$db->query($new_sql);
				$nm=$new_rs->num_rows;
				$count=$nm;
				if($nm>0)
				?>
				<table class="table table-striped table-bordered bootstrap-datatable datatable2" width=100% >
				<thead>
				<tr>
					<th>Client Request Id</th>
					<th>Request Time</th>
					<th>Problem Details</th>
					<th>Dispatch Staff</th>
					<th>Status of Request</th>	
				</tr>	
				</thead>
				<tbody>
				<?php
					for($i=0;$i<$nm;$i++){
					$row=$new_rs->fetch_assoc();
					
					
					$sql2="select * from dispatch_staff where id='".$row['dispatch_staff']."'";

					$rs2=$db->query($sql2);
					$row2=$rs2->fetch_assoc();
				
					$sql3="select * from task where id='".$row['task_id']."'";
					$rs3=$db->query($sql3);
					$row3=$rs3->fetch_assoc();
				/**
					$sql4="select * from computer where id='".$row['unit_id']."'";
					$rs4=$db->query($sql4);
					$row4=$rs4->fetch_assoc();
			*/
					
					$_SESSION['sql_printout']=$new_sql;
					
					
					
				
				?>	
				<tr>
					<td><?php echo $row['reference_number']; ?></td>
					<td><?php echo "<span style='display:none;'>".date("Ymd",strtotime($row['dispatch_time']))."</span>"; echo date("F d, Y h:ia",strtotime($row['dispatch_time'])); ?></td>
					<td><?php echo $row['problem_details']; ?></td>
					<td><?php echo trim($row2['staffer']); ?></td>
					<td><?php echo $row['status']; ?></td>

				</tr>
				<?php
					}
				?>
				</tbody>
				</table>
					<br>
				<?php
				$printClause=$_SESSION['clause'];

				if($printClause==""){
					$clause=" where printed='false'";
					
				}
				else {
					$clause=$printClause." and printed='false'";
				}
				
				$sql="select *,task.id as task_id from task inner join accomplishment on task.id=accomplishment.task_id ".$clause;
				$rs=$db->query($sql);
				$nm=$rs->num_rows;
				?>
			</div>
			</div>
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tasks"></i><span class="break"></span>Accomplishments not Printed</h2>
						<div class="box-icon">
							<a href="#" id='filterResults2'><i class="icon-calendar"></i></a>

						</div>

					</div>				
					<div class="box-content">

			
	<table class="table table-striped table-bordered bootstrap-datatable datatable2" width=100% >
	<thead>
	<tr>
		<th>Client Request Id</th>
		<th>Request Time</th>
		<th>Problem Details</th>
		<th>Action Taken</th>
		<th>Dispatch Staff</th>
<!--
		<th>Status of Request</th>	
-->
	</tr>
	</thead>
	<tbody>
	<?php	
	for($i=0;$i<$nm;$i++){
	$row=$rs->fetch_assoc();
	$sql2="select * from dispatch_staff where id='".$row['dispatch_staff']."'";
		$rs2=$db->query($sql2);
		$row2=$rs2->fetch_assoc();
	?>
	<tr>
		<td><a target='_blank' style='text-decoration:none;color:#e84c8a' href='print_outline3.php?adminPrint=<?php echo $row['task_id']; ?>'><?php echo $row['reference_number']; ?></a></td>
		<td><?php echo "<span style='display:none;'>".date("Ymd",strtotime($row['dispatch_time']))."</span>";echo date("F d, Y h:ia",strtotime($row['dispatch_time'])); ?></td>
		<td><?php echo $row['problem_details']; ?></td>
		<td><?php echo $row['action_taken']; ?></td>
		<td><?php echo trim($row2['staffer']); ?></td>
	</tr>	
	
	
	<?php
	}
	?>
	</tbody>
	</table>
<!--
	<div align=center><input type=button value='Prepare Print Out' 
	<?php 
	//if($count==0){ 
	?> //disabled="true" 
	<?php //} ?> onclick='openPrint("print_outline2.php")' /></div>
-->
	<br>
	</div>
	</div>
	</div>
	</div>
		

	
		<div class="modal hide fade" id="datafilterModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Filter Results</h3>
			</div>
			<form class="form-horizontal" id='checkForm' name='checkForm' action='pendingRequests.php' method='post'/>

			<div class="modal-body">
<!--				 
				 <fieldset>
-->
				 <?php 

				$headingTable="
				<table align=center width=100%>
				<tr><th colspan=2><h2>UNPROCESSED REQUESTS</h2></th>
				</tr>
				</table>";	
//				echo $headingTable;

				?>
				<div class="control-group">
				  <label class="control-label">Period Covered</label>
				  <div class="controls">
					<select name='date_filter'>
						<option <?php if(($_POST['date_filter']=="dRange")||($_POST['date_filter']=="")) { echo "selected=true"; } ?> value='dRange'>Date Range:</option> 
						<option <?php if($_POST['date_filter']=="daily") { echo "selected=true"; } ?> value='daily'>Daily</option> 
						<option <?php if($_POST['date_filter']=="weekly") { echo "selected=true"; } ?>  value='weekly'>Weekly</option> 
						<option <?php if(($_POST['date_filter']=="monthly")) { echo "selected=true"; } ?> value='monthly' >Monthly</option> 
						<option <?php if($_POST['date_filter']=="yearly") { echo "selected=true"; } ?> value='yearly'>Annually</option> 
					</select>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">From</label>
					  <div class="controls">
						<input type="text" class="input-xlarge datepicker" name='from_date' value="<?php echo date("m/d/Y"); ?>" />
					  </div>
				</div>					

				<div class="control-group">
				  <label class="control-label">To</label>
					  <div class="controls">
						<input type="text" class="input-xlarge datepicker" name='to_date' value="<?php echo date("m/d/Y"); ?>" />
					  </div>
				</div>					
				<div class="control-group">
				  <label class="control-label">Filter Dispatch Staff</label>
					  <div class="controls">
						<select name='dispatch_staffer'>
							<option value=''>All Dispatch Staff</option>
						<?php
					//		$db=new mysqli("localhost","root","","helpdesk_backup");
							$db=retrieveHelpdeskDb();
							//$db=localOnlyDb();
							$sql="select * from dispatch_staff";
							$rs=$db->query($sql);
							$nm=$rs->num_rows;
							for($i=0;$i<$nm;$i++){
								$row=$rs->fetch_assoc();
						?>	
								<option <?php if($_POST['dispatch_staffer']==$row['id']){ echo "selected=true"; } ?> value='<?php echo $row['id']; ?>'><?php echo $row['staffer']; ?></option>
						<?php	
							}
						?>		
						</select>
					  </div>
				</div>					

				
<!--
				  </fieldset>
-->
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<button type='submit' class="btn btn-primary" value='Submit'>Submit </button>
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
		<script src="js/additional_function2.js"></script>
