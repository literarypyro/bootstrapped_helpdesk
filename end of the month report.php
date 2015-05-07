<?php
session_start();
?>
<?php
	require("db_page.php");
	require("functions/routing process.php");
	require("functions/general functions.php");
	require("functions/document functions.php");
	require("header.php");
	$_SESSION['page']="end of the month report.php";
	
	
	if($_SESSION['filterDocument']=='SENT'){
		$sentNM=1;
		$unsentNM=0;
		$ordersNM=0;
	}
	else if($_SESSION['filterDocument']=='AWAIT'){
		$sentNM=0;
		$unsentNM=1;
		$ordersNM=0;
	}
	else if($_SESSION['filterDocument']=='ORDER'){
		$sentNM=0;
		$unsentNM=0;
		$ordersNM=1;
	}
	else {
		$sentNM=1;
		$unsentNM=1;
		$ordersNM=1;
	}


	
	if(isset($_SESSION['filterMonth'])){ 
		$filterMonth=$_SESSION['filterMonth'];
		$filterYear=$_SESSION['filterYear'];
		$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";

		$month=$filterMonth;
		$year=$filterYear;
	}
	else {
	
	
	$month=date("m");
	$year=date("Y");
	}
	
?>

	<LINK href="css/program design 2.css" rel="stylesheet" type="text/css">

	<script language="javascript">
	
	function openPrint(url){
		window.open(url);
	
	}
	</script>
	<body style="background-image:url('body background.jpg');">


	<div align=right><a href='receiveDocument.php'>Go Back to Main Page</a></div>
	<br>

	<!--Heading Table-->
	<form action='submit.php' method=post>

	<?php 

	$headingTable="
	<table align=center width=100%>
	<tr><th colspan=2><h2>END OF THE MONTH REPORT</h2></th>
	</tr>
	</table>";	
	echo $headingTable;

	?>
	<select name='filterDocument'>
	<option <?php if($_SESSION['filterDocument']=="ALL"){ echo "selected"; } ?> value='ALL'>All Documents</option>
	<option <?php if($_SESSION['filterDocument']=="SENT"){ echo "selected"; } ?> value='SENT'>Documents Sent This Month</option>
	<option <?php if($_SESSION['filterDocument']=="AWAIT"){ echo "selected"; } ?> value='AWAIT'>Documents Unsent/Awaiting Reply</option>
	<option <?php if($_SESSION['filterDocument']=="ORDER"){ echo "selected"; } ?> value='ORDER'>Office Order Issued this month</option>
	</select>
	<select name='filterMonth'>
	<?php
	for($i=1;$i<13;$i++){
	
	
	$month=$month*1;
	$date="2010-".$i."-01";
	$monthLabel=date("F",strtotime($date));
	?>
		<option <?php if($month==$i){ echo "selected"; } ?> value='<?php echo $i; ?>'><?php echo $monthLabel; ?></option>
	<?php
	}
	?>
	</select>
	<select name='filterYear'>
	<?php
	for($i=6;$i<25;$i++){
		$yy=2000+$i*1;
	?>
		<option 
		<?php 
		if($year==$yy){ echo "selected"; } 
		?>
		><?php echo $yy; ?>
		</option>
	<?php
		}
	?>
	</select>
	<input type=submit value='Filter' />
	</form>
	<form action='submit.php' method=post>
	<?php
		$sentClause=" (status in ('SENT','FORWARDED') or status like '%CLOSED%%') ";
		if(isset($_SESSION['sentClause'])){ $sentClause=$_SESSION['sentClause']; }
		if(isset($_SESSION['sentMonth'])){
			$month=date("m",strtotime($_SESSION['sentYear']."-".$_SESSION['sentMonth']));
			$dateClause="  and receive_date like '%".$_SESSION['sentYear']."-".$month."%%'";

			$year=$_SESSION['sentYear'];
		}
		else {
			if(isset($_SESSION['filterMonth'])){
				$filterMonth=$_SESSION['filterMonth'];
				$filterYear=$_SESSION['filterYear'];
				$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
				$month=$filterMonth;
				$year=$filterYear;
			}
			else {
				$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
				$month=date("m");
				$year=date("Y");
			}
		}
	
		$db=retrieveRecordsDb();
		$sql="select * from document where ".$sentClause." ".$dateClause." order by receive_date desc";

		$rs=$db->query($sql);
		$nm=$rs->num_rows;
		
		if($sentNM==0){
			$nm=$sentNM;
		}
	if(($nm>0)||(($nm==0)&&(($_SESSION['filterDocument']=="SENT")||($_SESSION['filterDocument']=="ALL")))){
		?>
	<table id='cssTable' width=100% >
	<tr>
	<th colspan=6><h2>Documents Sent This Month</h2></th>
	</tr>

	<tr>
		<th>Originating Office</th>
		<th>Subject</th>
		<th>Reference Number</th>
		<th>Document Type</th>
		<th>Document Date</th>
		<th>Last Status</th>	
	</tr>	
	<?php
		for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>	
	<tr>
		<td><?php echo getOriginatingOffice($db, $row['originating_office']); ?></td>
		<td><?php echo $row['subject']; ?></td>
		<td><?php echo calculateReferenceNumber($db,$row,adjustControlNumber($row['ref_id'])); ?></td>
		<td><?php echo $row['document_type']; ?></td>
		<td><?php echo date("Y-m-d", strtotime($row['document_date'])); ?></td>
		<td><?php echo $row['status']; ?></td>

	</tr>
	<?php
		}
	?>
	</table>
	
	<select name='sentDocumentFilter'>
	<option value='ALL'>All Documents Sent</option>
	<option value='CLOSED'>Sent and Closed Documents</option>
	<option value='FORWARD'>Sent and Forwarded as Outgoing</option>
	<option value='SENT'>Sent without Action</option>
	</select>
	<select name='sentMonth'>
	<?php
	for($i=1;$i<13;$i++){
	
	
	
	$date="2010-".$i."-01";
	$monthLabel=date("F",strtotime($date));
	?>
		<option <?php if($month==$i){ echo "selected"; } ?>><?php echo $monthLabel; ?></option>
	<?php
	}
	?>
	</select>
	<select name='sentYear'>
	<?php
	for($i=6;$i<25;$i++){
		$yy=2000+$i*1;
	?>
		<option <?php if($year==$yy){ echo "selected"; } ?>><?php echo $yy; ?>
		</option>
	<?php
		}
	?>
	</select>
	<input type=submit value='Filter' />
	</form>
	<form action='submit.php' method=post>
	<?php
	}
		$db=retrieveRecordsDb();
		
	//	$month=$_SESSION['filterMonth'];
	//	$year=$_SESSION['filterYear'];
		
		$awaitClause=" status in ('INCOMPLETE','FOR: ROUTING','AWAITING REPLY','FOR: CLARIFICATION','FOR: GM APPROVAL') ";
		if(isset($_SESSION['awaitClause'])){ $awaitClause=$_SESSION['awaitClause']; }

		if(isset($_SESSION['awaitMonth'])){
			$dateClause="  and receive_date like '%".$_SESSION['awaitYear']."-".$_SESSION['awaitMonth']."%%'";
			$month=date("m",strtotime($_SESSION['awaitYear']."-".$_SESSION['awaitMonth']));
			$year=$_SESSION['awaitYear'];
		}
		else {
			if(isset($_SESSION['filterMonth'])){
				$filterMonth=$_SESSION['filterMonth'];
				$filterYear=$_SESSION['filterYear'];
				$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
				$month=$filterMonth;
				$year=$filterYear;

			
			}
			else {
				$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
				$month=date("m");
				$year=date("Y");
			}
		}

		$sql="select * from document where ".$awaitClause."  ".$dateClause." order by receive_date desc";

		$rs=$db->query($sql);
		$nm=$rs->num_rows;


		if($unsentNM==0){
			$nm=$unsentNM;
		}
		
		if(($nm>0)||(($nm==0)&&(($_SESSION['filterDocument']=="AWAIT")||($_SESSION['filterDocument']=="ALL")))){
	?>

	<table id='cssTable' width=100% >
	<tr>
	<th colspan=6><h2>Documents Still Awaiting Reply/Unsent This Month</h2></th>
	</tr>

	<tr>
		<th>Originating Office</th>
		<th>Subject</th>
		<th>Reference Number</th>
		<th>Document Type</th>
		<th>Document Date</th>
		<th>Last Status</th>	
	</tr>	
	<?php

		for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>	
	<tr>
		<td><?php echo getOriginatingOffice($db, $row['originating_office']); ?></td>
		<td><?php echo $row['subject']; ?></td>
		<td><?php echo calculateReferenceNumber($db,$row,adjustControlNumber($row['ref_id'])); ?></td>
		<td><?php echo $row['document_type']; ?></td>
		<td><?php echo date("Y-m-d", strtotime($row['document_date'])); ?></td>
		<td><?php echo $row['status']; ?></td>

	</tr>
	<?php
		}
	?>
	</table>	
	<select name='awaitDocsFilter'>
	<option value='ALL'>All Documents Awaiting Reply</option>
	<option value='NR'>Documents Not Routed</option>
	<option value='IN'>Documents with No Upload</option>
	<option value='AR'>Documments Awaiting Reply</option>
	<option value='GM'>Documments Awaiting GM Approval</option>
	</select>
	<select name='awaitMonth'>
	<?php
	for($i=1;$i<13;$i++){
	
	
	
	$date="2010-".$i."-01";
	$monthLabel=date("F",strtotime($date));
	?>
		<option <?php if($month==$i){ echo "selected"; } ?> value='<?php echo $i; ?>'><?php echo $monthLabel; ?></option>
	<?php
	}
	?>
	</select>
	<select name='awaitYear'>
	<?php
	for($i=6;$i<25;$i++){
		$yy=2000+$i*1;
	?>
		<option <?php if($year==$yy){ echo "selected"; } ?>><?php echo $yy; ?>
		</option>
	<?php
		}
	?>
	</select>
	<input type=submit value='Filter' />
	</form>

	<?php
	}
	$db=retrieveRecordsDb();
	
	$orderClause=" and status in ('ISSUED AND SENT','ISSUED') ";
	if(isset($_SESSION['orderClause'])){ $orderClause=$_SESSION['orderClause']; }
	if(isset($_SESSION['orderMonth'])){
		$dateClause="  and receive_date like '%".$_SESSION['orderYear']."-".$_SESSION['orderMonth']."%%'";
		$month=date("m",strtotime($_SESSION['orderYear']."-".$_SESSION['orderMonth']));
		$year=$_SESSION['orderYear'];
	
	
	}
	else {
		if(isset($_SESSION['filterMonth'])){
			$filterMonth=$_SESSION['filterMonth'];
			$filterYear=$_SESSION['filterYear'];
			$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
			$month=$filterMonth;
			$year=$filterYear;
			
		}
		else {
			$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
			$month=date("m");
			$year=date("Y");

		}
	}

	
	$sql="select * from document where document_type='ORD' ".$orderClause." ".$dateClause;
	$rs=$db->query($sql);
	
	$nm=$rs->num_rows;
	if($ordersNM==0){
		$nm=$ordersNM;
	}
		if(($nm>0)||(($nm==0)&&(($_SESSION['filterDocument']=="ORDER")||($_SESSION['filterDocument']=="ALL")))){
	?>
	<form action='submit.php' method=post>

	<table id='cssTable' width=100% >
	<tr>
	<th colspan=5><h2>Office Orders Issued This Month</h2></th>
	</tr>
	<tr>
	<th>Subject</th>
	<th>Classification</th>
	<th>Document Date</th>
	<th>Originating Office</th>
	<th>Last Status</th>
	</tr>
	<?php

	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>
	<tr>
		<td><?php echo $row['subject']; ?></td>
		<td>Office Order</td>
		<td><?php echo date("Y-m-d h:ia",strtotime($row['document_date'])); ?></td>
		<td><?php echo getOriginatingOffice($db,$row['originating_office']); ?></td>
		<td><?php echo $row['status']; ?></td>
	</tr>
	<?php
	}
	?>
	</table>
	<select name='ordersDocsFilter'>
	<option value='ALL'>All Office Orders</option>
	<option value='NS'>Office Orders Not Sent</option>
	<option value='IS'>Office Orders Issued and Sent</option>
	</select>
	<select name='orderMonth'>
	<?php
	for($i=1;$i<13;$i++){
	
	
	
	$date="2010-".$i."-01";
	$monthLabel=date("F",strtotime($date));
	?>
		<option <?php if($month==$i){ echo "selected"; } ?> value='<?php echo $i; ?>'><?php echo $monthLabel; ?></option>
	<?php
	}
	?>
	</select>
	<select name='orderYear'>
	<?php
	for($i=6;$i<25;$i++){
		$yy=2000+$i*1;
	?>
		<option <?php if($year==$yy){ echo "selected"; } ?>><?php echo $yy; ?>
		</option>
	<?php
		}
	?>
	</select>
	<input type=submit value='Filter' />
	</form>
	<br>
	
	<?php
	}

	?>
	<div align=center><input type=button value='Prepare Print Out' onclick='openPrint("print_outline.php")' /></div>
	<br>
	</body>
