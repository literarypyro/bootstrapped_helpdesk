<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
require("form functions.php");
?>
<?php
//POST Variables
if(isset($_POST['change_task'])){
	$task=$_POST['change_task'];

}

?>
<?php
//POST Variables

if((isset($_POST['taskId']))&&($_POST['taskId']!=="")){
	$receiveHour=0;
	$receiveMinute=0;
	$receiveMinute=$_POST['documentMinute'];

	$receiveHour=adjustTime($_POST['docamorpm'],$_POST['documentHour']);
	$receiveDay=$_POST['documentYear']."-".$_POST['selectMonth']."-".$_POST['selectDay'];
	$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";

	
	$reference_number="HD-".date("Y")."".date("m")."".date("d")."-".date("H")."".date("i")."-".date("s");
	
	$db=new mysqli('localhost','root','','helpdesk');
	$sql="insert into accomplishment(task_id,action_taken,recommendation,status,accomplish_time) values (\"".$_POST['taskId']."\",\"".$_POST['action_taken']."\",\"".$_POST['recommendations']."\",'".$_POST['status']."','".$received_date."')";
	$rs=$db->query($sql);

	echo "Accomplishment has been submitted.<br>";
}
?>
<script language='javascript'>
function disableForm(a){
	if(a.checked==true){
		document.getElementById("to_department").disabled=true;
		document.getElementById("to_name").disabled=true;
	
	}
	else {
		document.getElementById("to_department").disabled=false;
		document.getElementById("to_name").disabled=false;
	
	
	}
}
</script>
<title>Submit Accomplishment</title>
<style type="text/css">
#cssTable {
background-color: #0066cb;
color: #ffcc35;

}
a:link {
text-decoration: none;
}

#exception a{
text-decoration: none;
color: #ffffff;
}

#alterTable td{
background-color: #0066cb;
color: #ffcc35;
	
}

#alterTable th{
background-color: #0066cb;
color: #ffcc35;
	
}

</style>
<body style="background-image:url('body background.jpg');">
<div width=70% align=right><a href="scanMessages_b.php">Go Back To New Helpdesk Tasks</a></div>

<br>
<?php
$db=new mysqli("localhost","root","","helpdesk");
$sql="select * from task where id='".$task."'";
$rs=$db->query($sql);

$row=$rs->fetch_assoc();

$client=$row['client_name'];
$ref=$row['reference_number'];
$problem=$row['problem_details'];


?>

<table width=60% id='alterTable' align=center >
<tr><th colspan=2><font align=center>Submit Accomplishment</font></th></tr>
<tr>
	<td>Client Name: <b><font color=white><?php echo $client; ?></font></b> </td>
	<td>Reference Number: <b><font color=white><?php echo $ref; ?></font></b> </td>
</tr>

<tr>
	<td colspan=2>Problem Details: <b><font color=white><?php echo $problem; ?></font></b></td>
</tr>

</table>
<form action="submitAccomplishment.php" method="post">
<table id='cssTable' align=center>
<tr>
<th>Change Task</th>
<td>
	<select name='change_task'>
<?php
	$db=new mysqli('localhost','root','','helpdesk');
	$sql="select id,reference_number from task";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
?>	
	<option value='<?php echo $row['id']; ?>'><?php echo $row['reference_number']; ?></option>

<?php	
	}
?>	
	</select>
</td>
<td><input type=submit value='Change' /></td>
</tr>
</table>

</form>
<br>
<form enctype="multipart/form-data" action='submitAccomplishment.php' method='post'>
<table id='cssTable' align=center>
<tr>
	<td>Select Dispatch Staff</td>
	<td>
	<select name='office_name'>
<?php
	$db=new mysqli('localhost','root','','helpdesk');
	$sql="select * from dispatch_staff";
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
	</td>
</tr>
<tr>
	<td>Action Taken:</td>
	<td>
	<textarea name='action_taken' cols=70 rows=5></textarea>
	</td>
</tr>
<tr>
	<td>Accomplishment Time:</td>
	<td>
	<?php
	retrieveMonthListHTML("selectMonth");
	retrieveDayListHTML("selectDay");
	retrieveYearListHTML("documentYear");
	retrieveHourListHTML("documentHour");
	retrieveMinuteListHTML("documentMinute");
	retrieveShiftListHTML("docamorpm");
	?>
	</td>
</tr>
	<tr>
	<td>
	Recommendations:
	</td>
	<td>
	<textarea name='recommendations' cols=70 rows=5></textarea>
	</td>
</tr>
<tr>
	<td>
	Status:
	</td>
	<td>
	<input type=text name='status' /><input type=hidden name='taskId' value='<?php echo $task; ?>' />
	</td>
</tr>
<tr>
	<td colspan=2 align=center><input type=submit value='Submit' /></td>
</tr>
</table>
</form>
</body>