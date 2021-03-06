<?php
session_start();
?>
<?php
require("form functions.php");
require("db_page.php");
?>
<?php
$_SESSION['helpdesk_page']="task monitor report.php";

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
	<title>Client Requests Report</title>
	<?php
		
		$conditionClause=" where ";
		
		$m=0;
		$unitClause="";
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
			$m++;
			$issueClause=" classification_id='".$_POST['issue_filter']."'";
			if($m>1){
				$conditionClause.=" and ".$issueClause;
			}
			
			else {
				$conditionClause.=$issueClause;
			
			}

		}
		
		
		$staffClause=" dispatch_staff='".$_SESSION['username']."'";
		$m++;
		if($m>1){
			$conditionClause.=" and ".$staffClause;
		}
		else {
			$conditionClause.=$staffClause;
		
		}
		

		if($_POST['date_filter']==""){
			$periodMonth=date("Y-m-d");
		
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
				$periodMonthbeginning=$_POST['fromYear']."-".(date("m",strtotime(date("Y")."-".$_POST['fromMonth'])))."-".$_POST['fromDay'];
				$periodMonthend=$_POST['toYear']."-".(date("m",strtotime(date("Y")."-".$_POST['toMonth'])))."-".$_POST['toDay'];
				
				$fromYear=$_POST['fromYear'];
				$fromMonth=$_POST['fromMonth'];
				$fromDay=date("d",$periodMonthbeginning);
				$toYear=$_POST['toYear'];
				$toMonth=$_POST['toMonth'];
				$toDay=date("d",$periodMonthend);
				
				$periodClause=" dispatch_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
			}
			else if($_POST['date_filter']=="daily"){
				$periodMonth=date("Y-m-d");
				$fromYear=date("Y");
				$fromMonth=date("m");
				$fromDay=date("d");
				$toYear=$fromYear;
				$toMonth=$fromMonth;
				$toDay=$fromDay;
				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}
			else if($_POST['date_filter']=="weekly"){
				$periodMonthbeginning=$_POST['fromYear']."-".(date("m",strtotime(date("Y")."-".$_POST['fromMonth'])))."-".$_POST['fromDay'];
				$periodMonthend=date("Y-m-d",strtotime($periodMonthbeginning." +6 days"));
				
				$periodClause=" login_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
				$fromYear=$_POST['fromYear'];
				$fromMonth=$_POST['fromMonth'];
				$fromDay=$_POST['fromDay'];
				$toYear=date('Y',strtotime($periodMonthend))*1;
				$toMonth=date('m',strtotime($periodMonthend))*1;
				$toDay=date('d',strtotime($periodMonthend))*1;
				
				$periodClause=" dispatch_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
			}
			else if($_POST['date_filter']=="monthly"){
				$periodMonth=date("Y")."-".(date("m",strtotime(date("Y")."-".$_POST['fromMonth'])));
				$periodClause=" dispatch_time like '".$periodMonth."%%'";

//				$periodClause=" login_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
				$fromYear=$_POST['fromYear'];
				$fromMonth=$_POST['fromMonth'];
				$fromDay=$_POST['fromDay'];
				$toYear=$_POST['toYear'];
				$toMonth=$fromMonth;
				$toDay=30;
			}

			else {
//				$periodMonth=date("Y");
				$periodMonth=date("Y");
				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			
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
		// $db=new mysqli("localhost","root","","helpdesk_backup");
		$db=retrieveHelpdeskDb();

		$new_sql="select * from task ".$conditionClause." order by dispatch_time desc";

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
						<h2><i class="icon-tasks"></i><span class="break"></span>Client Requests List</h2>
						<div class="box-icon">
							<a href="#" id='filterResults'><i class="icon-calendar"></i></a>
							<a href="#" id='' onclick='openPrint("print_outline4.php")'><i class="icon-print"></i></a>

						</div>

					</div>				
					<div class="box-content">		
					<?php
					$new_rs=$db->query($new_sql);
					$nm=$new_rs->num_rows;

					$count=$nm;
					if($nm>0)
					?>
					<table  class="table table-striped table-bordered bootstrap-datatable datatable"  width=100% >
					<thead>
					<tr>
					<th colspan=6><h2>Client Requests List</h2></th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<th>Reference Number</th>
						<th>Request Time</th>

						<th>Unit Type</th>
						<th>Problem Concern</th>
						<th>Dispatch Staff Assigned</th>	
					</tr>	
					<?php
						for($i=0;$i<$nm;$i++){
						$row=$new_rs->fetch_assoc();
						
						
						$sql2="select * from dispatch_staff where id='".$row['dispatch_staff']."'";
						$rs2=$db->query($sql2);
						$row2=$rs2->fetch_assoc();
					
						$sql3="select * from classification where id='".$row['classification_id']."'";
						$rs3=$db->query($sql3);
						$row3=$rs3->fetch_assoc();
					
						$sql4="select * from computer where id='".$row['unit_id']."'";
						$rs4=$db->query($sql4);
						$row4=$rs4->fetch_assoc();

						
						$_SESSION['sql_printout']=$new_sql;
						
						
						
					
					?>	
					<tr>
						<td><?php echo trim($row['reference_number']); ?></td>
						<td><?php echo date("F d, Y H:ia",strtotime($row['dispatch_time'])); ?></td>
						<td><?php echo $row4['unit']; ?></td>
						<td><?php echo $row3['type']; ?></td>
						<td><?php echo $row2['staffer']; ?></td>

					</tr>
					<?php
						}
					?>
					</tbody>
					</table>

					</div>
				</div>
			</div>
		</div>
	</div>	
	</div>



		<div class="modal hide fade" id="datafilterModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">�</button>
				<h3>Filter Results</h3>
			</div>
			<form class="form-horizontal" id='checkForm' name='checkForm' action='task monitor report.php' method='post'/>

			<div class="modal-body">	
				<div class="control-group">
				  <label class="control-label">Period Covered</label>
				  <div class="controls">
					<select name='date_filter'>
						<option <?php if(($_POST['date_filter']=="dRange")||($_POST['date_filter']=="")) { echo "selected=true"; } ?> value='dRange'>Date Range:</option> 
						<option <?php if($_POST['date_filter']=="daily") { echo "selected=true"; } ?> value='daily'>Daily</option> 
						<option <?php if($_POST['date_filter']=="weekly") { echo "selected=true"; } ?>  value='weekly'>Weekly</option> 
						<option <?php if($_POST['date_filter']=="monthly") { echo "selected=true"; } ?> value='monthly' >Monthly</option> 
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
				  <label class="control-label">Filter Issue</label>
					  <div class="controls">
						<select name='issue_filter'>
							<option value=''>All Issues</option>
						<?php
							// $db=new mysqli("localhost","root","","helpdesk");
							$db=retrieveHelpdeskDb();

							$sql="select * from classification";
							$rs=$db->query($sql);
							$nm=$rs->num_rows;
							$count=$nm;
							for($i=0;$i<$nm;$i++){
								$row=$rs->fetch_assoc();
						?>	
								<option <?php if($_POST['issue_filter']==$row['id']){ echo "selected=true"; } ?> value='<?php echo $row['id']; ?>'><?php echo $row['type']; ?></option>
						<?php	
							}
							
							
							
						?>	
						</select>					
	  				</div>
				</div>					
						
				<div class="control-group">
				  <label class="control-label">Filter Unit (Laptop/Desktop)</label>
					  <div class="controls">
						<select name='unit_filter'>
							<option value=''>All Units</option>
						<?php
							$db=retrieveHelpdeskDb();
							$sql="select * from computer";
							$rs=$db->query($sql);
							$nm=$rs->num_rows;
							for($i=0;$i<$nm;$i++){
								$row=$rs->fetch_assoc();
						?>	
								<option <?php if($_POST['unit_filter']==$row['id']){ echo "selected=true"; } ?> value='<?php echo $row['id']; ?>'><?php echo $row['unit']; ?></option>
						<?php	
							}
							
							
							
						?>		
						</select>				
	  				</div>
				</div>								
				
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
		<!--
		<script src="js/additional_function2.js"></script>
		-->