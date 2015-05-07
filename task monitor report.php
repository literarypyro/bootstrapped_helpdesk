<?php
session_start();
?>
<?php
require("form functions.php");
?>

<style type="text/css">

#cssTable td {
	border: 1px solid gray;
	background-color: #95cbe9;

	}

th {
	border: 1px solid gray;
	background-color: #00cc66;
	color: #bd2031;
}

#viewlink {
	background-color: white;

}


</style>
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
			$issueClause=" classification_id='".$_POST['issue_filter']."'";
			$conditionClause.=$issueClause;
		}
		
		$staffClause=" ";
		if($_POST['dispatch_staffer']==""){
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
				$periodMonthbeginning=$_POST['fromYear']."-".(date("m",strtotime(date("Y")."-".$_POST['fromMonth'])))."-".$_POST['fromDay'];
				$periodMonthend=$_POST['toYear']."-".(date("m",strtotime(date("Y")."-".$_POST['toMonth'])))."-".$_POST['toYear'];
				
				$periodClause=" dispatch_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
			}
			else if($_POST['date_filter']=="daily"){
				$periodMonth=date("Y-m-d");

				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}
			else if($_POST['date_filter']=="weekly"){
				$periodMonthbeginning=$_POST['fromYear']."-".(date("m",strtotime(date("Y")."-".$_POST['fromMonth'])))."-".$_POST['fromDay'];
				$periodMonthend=$_POST['toYear']."-".(date("m",strtotime(date("Y")."-".$_POST['toMonth'])))."-".($_POST['toDay']*1+6);

				$periodClause=" dispatch_time between '".$periodMonthbeginning." 00:00:00' and '".$periodMonthend." 23:59:59'";
			}
			else if($_POST['date_filter']=="monthly"){
				$periodMonth=date("Y")."-".(date("m",strtotime(date("Y")."-".$_POST['fromMonth'])));
				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}

			else {
				$periodMonth=date("Y");
				$periodClause=" dispatch_time like '".$periodMonth."%%'";
			}

			$m++;

			
			if($m>1){
				$conditionClause.=" and ".$periodClause;
			}
			else {
				$conditionClause.=$periodClause;
			
			}

		}
		
		$db=new mysqli("localhost","root","","helpdesk");
		$new_sql="select * from task ".$conditionClause." order by dispatch_time desc";
		

		
		
		?>
	<script language="javascript">
	
	function openPrint(url){
		window.open(url);
	
	}
	</script>
	<body style="background-image:url('body background.jpg');">
<div align=center><img src="helpdesk Header.jpg" style="width:80%; height:200;" /></div>



	<!--Heading Table-->
	<form action='task monitor report.php' method=post>

	<?php 

	$headingTable="
	<table align=center width=100%>
	<tr><th colspan=2><h2>CLIENT REQUEST/TASKS REPORT</h2></th>
	</tr>
	</table>";	
	echo $headingTable;

	?>
	<b>Period Covered:</b>
	<select name='date_filter'>
		<option <?php if($_POST['date_filter']=="dRange") { echo "selected=true"; } ?> value='dRange'>Date Range:</option> 
		<option <?php if($_POST['date_filter']=="daily") { echo "selected=true"; } ?> value='daily'>Daily</option> 
		<option <?php if($_POST['date_filter']=="weekly") { echo "selected=true"; } ?>  value='weekly'>Weekly</option> 
		<option <?php if(($_POST['date_filter']=="monthly")||($_POST['date_filter']=="")) { echo "selected=true"; } ?> value='monthly' >Monthly</option> 
		<option <?php if($_POST['date_filter']=="yearly") { echo "selected=true"; } ?> value='yearly'>Annually</option> 
	</select>
	<b>From:</b> 	
		<?php
		retrieveMonthListHTML("fromMonth");
		retrieveDayListHTML("fromDay");
		retrieveYearListHTML("fromYear");
		?>
	
	<b>To:</b> 
		<?php
		retrieveMonthListHTML("toMonth");
		retrieveDayListHTML("toDay");
		retrieveYearListHTML("toYear");
		?>
	
	<br>
	<b>Filter Issue:</b> 
	<select name='issue_filter'>
		<option value=''>All Issues</option>
	<?php
		$db=new mysqli("localhost","root","","helpdesk");
		$sql="select * from classification";
		$rs=$db->query($sql);
		$nm=$rs->num_rows;
		for($i=0;$i<$nm;$i++){
			$row=$rs->fetch_assoc();
	?>	
			<option <?php if($_POST['issue_filter']==$row['id']){ echo "selected=true"; } ?> value='<?php echo $row['id']; ?>'><?php echo $row['type']; ?></option>
	<?php	
		}
		
		
		
	?>	
	</select>
<!--
	<br>	
-->	
	<b>Filter Unit (Laptop/Desktop)</b>
	<select name='unit_filter'>
		<option value=''>All Units</option>
	<?php
		$db=new mysqli("localhost","root","","helpdesk");
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
<!--
	<br>	-->
	<b>Filter Dispatch Staff</b>
	<select name='dispatch_staffer'>
		<option value=''>All Dispatch Staff</option>
	<?php
		$db=new mysqli("localhost","root","","helpdesk");
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
	<br>
	<input type=submit value='Submit' />
	</form>
<br>
	<form action='submit.php' method=post>
	<?php
	$new_rs=$db->query($new_sql);
	$nm=$new_rs->num_rows;
	
	if($nm>0)
	?>
	<table id='cssTable' width=100% >
	<tr>
	<th colspan=6><h2>Client Requests List</h2></th>
	</tr>

	<tr>
		<th>Reference Number</th>
		<th>Dispatch Time</th>

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
	</table>
	
	<div align=center><input type=button value='Prepare Print Out' onclick='openPrint("print_outline.php")' /></div>
	<br>
	</body>
