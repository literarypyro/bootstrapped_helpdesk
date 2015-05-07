<?php
session_start();
?>
<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
require("form functions.php");
require("db_page.php");
?>
<?php
$_SESSION['helpdesk_page']="task_printout.php";
?>
<?php
$updated=0;
if(isset($_POST['accid'])){
	$loginDay=date("Y-m-d",strtotime($_POST['accomplishment_date']));;
	$login_date=$loginDay." ".$_POST['accomplishment_time'];
	$actionTaken2=$_POST['action_taken'];
	$recommendation2=$_POST['recommendation'];
	$status2=$_POST['request_status'];
	
//	$db=new mysqli("localhost","root","","helpdesk_backup");
	$db=retrieveHelpdeskDb();
	$sql="update accomplishment set action_taken='".$actionTaken2."',recommendation='".$recommendation2."',accomplishment.status='".$status2."',accomplish_time='".$login_date."' where id='".$_POST['accid']."'"; 
	$rs=$db->query($sql);
	$updated++;
	
	}
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
	<link href="css/jquery-timepicker.css" rel="stylesheet" />






<script language='javascript'>
function selectOption(elementName,elementValue){
	var elm=document.getElementById(elementName);

	for(i=0;i<elm.options.length;i++){
		if((elm.options[i].value)==(elementValue)){
			elm.options[i].selected=true;
		}
	}

}
</script>
<title>Update Helpdesk Staff Status</title>
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
						<h2><i class="icon-tasks"></i><span class="break"></span>Print Out Task</h2>
						<div class="box-icon">
							<a href="#" id='filterResults'><i class="icon-share-alt"></i></a>
							<a href="#" id=''  onclick="alert('Generating printout... Press okay to proceed.');window.open('print_outline3.php'); self.focus();"><i class="icon-print"></i></a>

						</div>

					</div>				
					<div class="box-content">		
					
					
										
						<?php	
						if($updated>0){
							echo "<font color=red>Accomplishment was updated. Resubmit to view changes.";
						}
						?>
						<?php
						if(isset($_POST['task_id'])){
							$tsk=$_POST['task_id'];
							
							$_SESSION['helpdesk_printout']=$_POST['task_id'];
							
							$db=retrieveHelpdeskDb();
							$sql2="select *,accomplishment.status as task_stat,accomplishment.id as accid from task inner join accomplishment on task.id=accomplishment.task_id where task.id='".$tsk."'";

							
							
							$rs2=$db->query($sql2);
							$nm2=$rs2->num_rows;
							if($nm2>0){
							$row2=$rs2->fetch_assoc();
							$referenceNumber=$row2['reference_number'];
							
							$sql3="select * from computer where id='".$row2['unit_id']."'";
							$rs3=$db->query($sql3);
							$row3=$rs3->fetch_assoc();
						
					?>
						<form action='task_printout.php' method='post'>
						<table  class="table table-striped table-bordered bootstrap-datatable"  width=100%>
						<tr>
						<th colspan=5><h2><?php echo $referenceNumber; ?></h2></th>
						</tr>
						<tr>
						<th>Client Name</th>
						<th>Dispatch Time</th>
						<th>Problem Details</th>
						<th>From Office</th>
						<th>Unit Type</th>
						</tr>
						<tr>
						<td align=center><?php echo $row2['client_name']; ?></td>
						<td align=center><?php echo date("F d, Y h:ia",strtotime($row2['dispatch_time'])); ?></td>
						<td align=center><?php echo $row2['problem_details']; ?></td>
						<td align=center><?php echo $row2['division_id']; ?></td>
						<td align=center><?php echo $row3['unit']; ?></td>
						</tr>
						</table>
						<?php
						$actionTaken=$row2['action_taken'];
						$recommendation=$row2['recommendation'];
						$status=$row2['task_stat'];
						$amorpm=date("A",strtotime($row2['accomplish_time']));
						$hour=date("h",strtotime($row2['accomplish_time']));

						$minute=date("i",strtotime($row2['accomplish_time']));
						$day=date("d",strtotime($row2['accomplish_time']));
						$month=date("m",strtotime($row2['accomplish_time']));
						$year=date("Y",strtotime($row2['accomplish_time']));


						?>
						<table align=center class="table table-striped table-bordered bootstrap-datatable" >
						<tr><th colspan=4>Fill-in Accomplishment</th></tr>
						<tr>
							<td valign=top>
							Action Taken:
							</td>
							<td><textarea name='action_taken'  cols=30 rows=5><?php echo $actionTaken; ?></textarea>
							</td>
							<td valign=top>
							Recommendation:
							</td>
							<td><textarea name='recommendation' cols=30 rows=5><?php echo $recommendation; ?></textarea>
							</td>

						</tr>	
						<tr>
							<td>
							Date:
							</td>
							<td>
								<input type="text" name='accomplishment_date' class="input-xlarge datepicker" value="<?php echo date("m/d/Y"); ?>" />
							

							</td>
							<td align=right>
							Time:
							</td>
							<td>
								<input type='text' id='accomplishment_time' name='accomplishment_time' value='<?php echo date("H:i"); ?>' />
							</td>
						</tr>
						<tr>
							<td align=center colspan=4>Status of Request: <input type='text' name='request_status' size=30 value='<?php echo $status; ?>' /></td>
						</tr>
						<tr>
							<td colspan=4 align=center><input <?php if($count==0){ ?> disabled=true <?php } ?>type=submit class='btn btn-primary' value='Edit' /><input type=hidden name='accid' value='<?php echo $row2['accid']; ?>' /><input type=hidden name='taskid' value='<?php echo $row2['task_id']; ?>' /></td>
						</tr>
						</table>
						</form>	
										
										
										
										
					
<?php

							}
						}
	
	
	?>						
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
		
		<div class="modal hide fade" id="retrieveTaskPrintout">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Prepare Printout of Task</h3>
			</div>
			<form class="form-horizontal" id='checkForm' name='checkForm' action='task_printout.php' method='post'/>

			<div class="modal-body">	
				<div class="control-group">
				  <label class="control-label">Retrieve Task</label>
				  <div class="controls">
					<select name='task_id'>
						<?php
						//$db=new mysqli("localhost","root","","helpdesk_backup");
						$db=retrieveHelpdeskDb();
						$sql="select * from task inner join accomplishment on task.id=accomplishment.task_id where dispatch_staff='".$_SESSION['username']."' and printed='false' order by task_id desc";

						$rs=$db->query($sql);
						$nm=$rs->num_rows;
						$count=$nm;
						for($i=0;$i<$nm;$i++){
							$row=$rs->fetch_assoc();
					?>	
						<option value='<?php echo $row['task_id']; ?>' <?php if($_POST['taskid']==$row['task_id']){ echo "selected"; } ?>  <?php if($_POST['task_id']==$row['task_id']){ echo "selected"; } ?>><?php echo $row['reference_number']; ?></option>
						<?php	
						}
					?>	
					</select>
					<input type=hidden name='user_name' value='<?php echo $_POST['login_user']; ?>' />
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
		<script src='js/jquery-ui-timepicker-addon.js'></script>

		<script src="js/additional_function5.js"></script>
