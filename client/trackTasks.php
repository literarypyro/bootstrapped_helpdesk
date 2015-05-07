<?php
session_start();
?>
<?php
$_SESSION['helpdesk_page']="trackTasks.php";
?>
<?php
require("db_page.php");
?>
<?php
/**
background-color: #0066cb;
color: #ffcc35;
*/
?>
<title>Monitor Current Client Requests</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/style-responsive.min.css" rel="stylesheet" />
	<link href="css/retina2.css" rel="stylesheet" />
	<link href="css/jquery-timepicker.css" rel="stylesheet" />

	
	<?php 
	$db=retrieveHelpdeskDb("primary");
	
	$yearLast=date("Y-m-d",strtotime(date("Y-m-d")."-2 months"));
	
	$sql="select *,(select count(*) from forward_admin where id=task.id) as forward_count,(select staffer from dispatch_staff where id=task.dispatch_staff) as dispatch_name from task where dispatch_time>'".$yearLast."' order by dispatch_time desc";

	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	
?>
<?php
//POST Variables

if((isset($_POST['client_name']))&&($_POST['client_name']!=="")){

	$receiveHour=0;
	$receiveMinute=0;
//	$receiveMinute=$_POST['documentMinute'];

//	$receiveHour=adjustTime($_POST['docamorpm'],$_POST['documentHour']);
//	$receiveDay=$_POST['documentYear']."-".$_POST['selectMonth']."-".$_POST['selectDay'];
//	$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";
	
	$receiveDay=date("Y-m-d",strtotime($_POST['task_date']));
	
	$received_date=date("Y-m-d H:i:s",strtotime($receiveDay." ".$_POST['task_time']));
	
	
	$reference_number="HD-".date("Ymd-Hi-",strtotime($received_date));
	$property_no=$_POST['property_no'];
	
	$db=retrieveHelpdeskDb("primary");

	$sql="insert into task(client_name,division_id,unit_id,classification_id,dispatch_time,problem_details,reference_number,status,property_no) values (\"".$_POST['client_name']."\",'".$_POST['office_name']."','".$_POST['unit_type']."','".$_POST['problem_concern']."','".$received_date."',\"".$_POST['details']."\",'".$reference_number."','Pending','".$property_no."')";
	$rs=$db->query($sql);
	$taskID=$db->insert_id;

	$reference_number="HD-".date("Ymd-Hi-",strtotime($received_date)).$taskID;

//	$reference_number="HD-".date("Y")."".date("m")."".date("d")."-".date("H")."".date("i")."-".$taskID;
	
	$sql="update task set reference_number='".$reference_number."' where id='".$taskID."'";
	$rs=$db->query($sql);
	
	
	
	$sql="insert into forward_admin(id,client_name,division_id,unit_id,classification_id) values ('".$taskID."',\"".$_POST['client_name']."\",'".$_POST['office_name']."','".$_POST['unit_type']."','".$_POST['problem_concern']."')";
	$rs=$db->query($sql);

	$prompt="<div align=center>".strtoupper("Thank you for using HDC Online System!")."</div>";

	$prompt.="<div align=center>".strtoupper('We received your concern and we will attend to you shortly.')."</div><br>";
//	if ($handle = opendir('../admin/data')) {
		$msg=$_POST['client_name'];
		$filename  = "../admin/data/helpdesk_file.txt";
		
		if(file_exists($filename)){
		}
		else {
			fopen($filename,'w');	
		}
		file_put_contents($filename,$msg);
	//	closedir($handle);
//	}
	
}




?>
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
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>

		<div class="container-fluid-full">
		<div class="row-fluid">
	<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="../helpdesk/"><i class="icon-dashboard"></i><span class="hidden-tablet"> Admin</span></a></li>
						<li><a href="../admin/"><i class="icon-edit"></i><span class="hidden-tablet"> Helpdesk</span></a></li>
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			<?php	
				$db=retrieveHelpdeskDb("primary");
				
				$yearLast=date("Y-m-d",strtotime(date("Y-m-d")."-2 months"));
				
				$sql="select *,(select count(*) from forward_admin where id=task.id) as forward_count,(select staffer from dispatch_staff where id=task.dispatch_staff) as dispatch_name from task where dispatch_time>'".$yearLast."' order by dispatch_time desc";
				$rs=$db->query($sql);
				$nm=$rs->num_rows;
			?>
	
	
			<div id="content" class="span10">	
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-user"></i><span class="break"></span>Client Request List</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="icon-wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

	
					<table id=''  class="table table-striped table-bordered bootstrap-datatable datatable2" width=100% >
					<thead>
					<tr>
						<th>Client Name</th>

						<th>Office Name</th>
						<th>Problem Details</th>
						<th>Reference Number</th>
						<th>Request Time</th>	
						<th>Client Status</th>	
						<th>Assigned Staff</th>
					</tr>
					</thead>
					<tbody>

					<?php
					for($i=0;$i<$nm;$i++){
						$row=$rs->fetch_assoc();
						
						$sql2="select * from division where division_code='".$row['division_id']."'";
						$rs2=$db->query($sql2);
						$row2=$rs2->fetch_assoc();
					
				?>	
					<?php
					if($row['forward_count']>0){
						$tableStyle=" style='background-color:red;' ";
					}
					else {
						$tableStyle="";
					}
					if($row['dispatch_name']==""){
						$label="Not yet available";
					}
					else {
						$label=$row['dispatch_name'];
					
					}
					?>
					
					
					
					<tr>
						<td <?php echo $tableStyle; ?> ><?php echo $row['client_name']; ?></td>
						<td <?php echo $tableStyle; ?> ><?php echo $row2['division_name']; ?></td>
						<td <?php echo $tableStyle; ?> ><?php echo $row['problem_details']; ?></td>
						<td <?php echo $tableStyle; ?> ><?php echo $row['reference_number']; ?></td>
						<td <?php  echo $tableStyle; ?> ><?php echo "<span style='display:none;'>".date("Ymd",strtotime($row['dispatch_time']))."</span>"; echo $row['dispatch_time']; ?></td>	
						<td <?php echo $tableStyle; ?> ><?php echo $row['status']; ?></td>	
						<td <?php echo $tableStyle; ?> ><?php echo $label; ?></td>	
					</tr>
				<?php
					}
				?>
					</tbody>
					</table>
					</td>
				</tr>
				</table>	
			</div>
			</div>
		</div>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Report New Issue</h3>
			</div>
			<form class="form-horizontal" action='trackTasks.php' method='post' />

			<div class="modal-body">
				  <fieldset>
							<div class="control-group">
							  <label class="control-label">Enter Client Name: </label>
							  <div class="controls">
								<input type='text' name='client_name' size=40 />
							  </div>
							</div>				  
				  			
							<div class="control-group">
							  <label class="control-label" for="office_name">Division/Office: </label>
							  <div class="controls">
								  <select name='office_name' id="office_name">
									<?php
										$db=retrieveHelpdeskDb("primary");
										$sql="select * from division";
										$rs=$db->query($sql);
										$nm=$rs->num_rows;
										for($i=0;$i<$nm;$i++){
											$row=$rs->fetch_assoc();
									?>	
										<option value='<?php echo $row['division_code']; ?>'><?php echo strtoupper($row['division_name']); ?></option>

									<?php	
										}
									?>	
								  </select>		
										
							  </div>
							</div>						

							<div class="control-group">
							  <label class="control-label" for="selectError3">Problem Concern: </label>
							  <div class="controls">
								<select name='problem_concern'>
							<?php
								$db=retrieveHelpdeskDb("primary");
								$sql="select * from classification";
								$rs=$db->query($sql);
								$nm=$rs->num_rows;
								for($i=0;$i<$nm;$i++){
									$row=$rs->fetch_assoc();
							?>	
								<option value='<?php echo $row['id']; ?>'><?php echo strtoupper($row['type']); ?></option>

							<?php	
								}
							?>	
								</select>	
										
							  </div>
							</div>				  
							<div class="control-group">
							  <label class="control-label">Problem Type</label>
							  <div class="controls">
									<select name='prob_type' id='prob_type'>
										<option></option>
										<option value='unit'>Unit</option>
										<option value='component'>Component</option>
										<option value='external'>Externals</option>
										<option value='accessory'>Accessory</option>
									</select>
							  </div>
							</div>					
							<div class="control-group">
							  <label class="control-label">Property No: </label>
							  <div class="controls">
									<select name='property_no' id='property_no'>
									</select>
							  </div>
							</div>				  
				  			
							<div class="control-group">
							  <label class="control-label">Type of Unit: </label>
							  <div class="controls">
								<select name='unit_type'>
							<?php
								$db=retrieveHelpdeskDb("primary");
								$sql="select * from computer order by sequence";
								$rs=$db->query($sql);
								$nm=$rs->num_rows;
								for($i=0;$i<$nm;$i++){
									$row=$rs->fetch_assoc();
							?>	
								<option value='<?php echo $row['id']; ?>'><?php echo strtoupper($row['unit']); ?></option>

							<?php	
								}
							?>	
								</select>
							  </div>
							</div>				  
				  			
							<div class="control-group">
							  <label class="control-label">Problem Details: </label>
							  <div class="controls">
								<textarea name='details' cols=70 rows=5></textarea>
							  </div>
							</div>				  
				  			
							<div class="control-group">
							  <label class="control-label">Date</label>
							  <div class="controls">
								<input type="text" name='task_date' class="input-xlarge datepicker" value="<?php echo date("m/d/Y"); ?>" />
							  </div>
							</div>				  
							<div class="control-group">
							  <label class="control-label">Time </label>
							  <div class="controls">
								<input type='text' id='task_time' name='task_time' value='<?php echo date("H:i"); ?>' />
							  </div>
							</div>				  
				  

				
				</fieldset>

			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<button type='submit' class="btn btn-primary">Save changes</button>
			</div>
			</form>
		</div>

		</div>
		</div>


	<!-- start: JavaScript-->
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/jquery.searchabledropdown-1.0.8.min.js"></script>

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
		<script src='js/additional_function3.js'></script>
		
		<!-- end: JavaScript-->

</body>