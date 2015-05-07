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
$_SESSION['helpdesk_page']="dispatchTrack.php";

?>

<?php
if((isset($_POST['location']))&&(isset($_POST['task_id']))){
	if($_POST['location']==""){
		$loginMinute=$_POST['loginMinute'];
		$loginHour=adjustTime($_POST['loginamorpm'],$_POST['loginHour']);
		$loginDay=$_POST['loginYear']."-".$_POST['loginMonth']."-".$_POST['loginDay'];
		$login_date=$loginDay." ".$loginHour.":".$loginMinute.":00";
		
		//$db=new mysqli("localhost","root","","helpdesk_backup");
		$db=retrieveHelpdeskDb();
		$sql="insert into dispatch_track(dispatch_staffer,login_time,location,task_id) values ('".$_SESSION['username']."','".$login_date."',\"".$_POST['location']."\",'".$_POST['task_id']."')";
		$rs=$db->query($sql);

		$update="update task set status='Work Undergoing' where id='".$_POST['task_id']."'";
		$rs2=$db->query($update);
		
		
		echo "Dispatch staffer has updated his status.<br>";	
	}

}

?>
<?php
//$db=new mysqli("localhost","root","","helpdesk_backup");
$db=retrieveHelpdeskDb();
$sql="select * from dispatch_staff inner join login  on dispatch_staff.id=login.username where dispatch_staff.id='".$_SESSION['username']."'";
$rs=$db->query($sql);
$userRow=$rs->fetch_assoc();

//from cssTable
//background-color: black;
//color:yellow;

?>
<script language="javascript">
function markLocation(elementa){
	if(elementa.value=="OTHER"){
	document.getElementById('location').disabled=false;	
	}
	else {
	//document.getElementById('location').disabled=true;	
	document.getElementById('location').value=elementa.value;
	}
//	alert(document.getElementById('location').value);
	//	=elementa.value;
}


</script>
<link rel="stylesheet" type="text/css" href="helpdesk_staff2.css" />
<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/style-responsive.min.css" rel="stylesheet" />
	<link href="css/retina.css" rel="stylesheet" />


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
						<h2><i class="icon-tasks"></i><span class="break"></span>Report Staff Location</h2>

					</div>				
					<div class="box-content">	
						<form class="form-horizontal" id='checkForm' name='checkForm' action='dispatchTrack.php' method='post'/>

							<div class="control-group">
							  <label class="control-label">Log-in Date</label>
							  <div class="controls">
								<input type="text" name='login_date' class="input-xlarge datepicker" value="<?php echo date("m/d/Y"); ?>" />
							  </div>
							</div>	
							
							<div class="control-group">
							  <label class="control-label">Log-in Time</label>
							  <div class="controls">
								<input type='text' id='task_time' name='task_time' value='<?php echo date("H:i"); ?>' />
							  </div>
							</div>			
							<div class="control-group">
							  <label class="control-label">Enter Current Location</label>
							  <div class="controls">
								<input name='location' id='location' type='text' size=40 />
							  </div>
							</div>	
							
							<div class="control-group">
							  <label class="control-label"></label>
							  <div class="controls">
								<select name='presetLocation' id='presetLocation' onchange='markLocation(this)'>
								<?php
									$db=retrieveHelpdeskDb();
									$sql="select * from division";
									$rs=$db->query($sql);
									$nm=$rs->num_rows;
									for($i=0;$i<$nm;$i++){
										$row=$rs->fetch_assoc();
								?>	
									<option value="<?php echo $row['division_short']; ?>"><?php echo $row['division_name']; ?></option>	
									
								<?php	
									}
								?>
								<option value="OTHER" selected>OTHER</option>
								</select>
							  </div>
							</div>		
							<div class="control-group">
							  <label class="control-label">Enter Task</label>
							  <div class="controls">
								<select name='task_id'>
								<?php
								//$db=new mysqli("localhost","root","","helpdesk_backup");
								$db=retrieveHelpdeskDb();
								$sql="select (select count(*) from forward_task where id=task.id) as forward_count,task.* from task where (select count(*) from accomplishment where task_id=task.id)=0 and dispatch_staff='".$_SESSION['username']."' order by dispatch_time desc";

								$rs=$db->query($sql);
								$nm=$rs->num_rows;
								$count=$nm;
								for($i=0;$i<$nm;$i++){
									$row=$rs->fetch_assoc();
							?>	
								<option value='<?php echo $row['id']; ?>'><?php echo $row['reference_number']; ?></option>
								<?php	
								}
							?>	
								</select>
								<input type=hidden name='user_name' value='<?php echo $_POST['login_user']; ?>' />
							  </div>
							</div>	
							<div class="control-group">
							  <div class="controls">
								<input type='submit' value='Submit' class='btn btn-primary' />
							  </div>
							</div>										
						</form>
					
					
					
					
					</div>
				</div>
			</div>
		</div>
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
		<script src='js/additional_function.js'></script>
