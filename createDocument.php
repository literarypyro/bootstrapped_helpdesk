<?php
session_start();
?>
<?php	
require("header.php");
require('db_page.php');
require("functions/form functions.php");
require("functions/general functions.php");
$_SESSION['page']="createDocument.php";

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

function checkAlternate(a,v,alter){
	if(a.value==v){
		document.getElementById(alter).disabled=false;
	}
	else {
		document.getElementById(alter).disabled=true;
	
	}

}
</script>
<title>Receive/Issue New Document</title>
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
<body style="background-image:url('body background.jpg');">
<div align=right><a href="receiveDocument.php">Back to Main Page</a></div>
<form enctype="multipart/form-data" action='submit.php' method='post'>
<table align=center style='border: 1px solid gray'>
<tr><th colspan=2>Receive/Issue New Document</th></tr>
<tr>
	<td>Subject of Document:</td>
	<td><input type='text' name='doc_subject' size=40 /></td>
</tr>
<tr>
	<td>Classification of Document:</td>

<!--
	<td><input type=text name='classification' size=40 /></td>
</tr>
	<tr>
	
	<td  align=right>-or- Select from the list<input type=checkbox name='chooseList' value='on' ></td>
	-->

	<td>
	<?php
		$db=retrieveRecordsDb();
		retrieveClassListHTML($db,"class_list",'classification');	
	?>
	</td>
</tr>
<tr>
	<td>
	Date of Document:
	</td>
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
	<td>Date/Time 
		<?php
		if($_SESSION['document_type']=="OUT"){
		?>
		Sent for Approval: 
		<?php
		}
		else {
		?>
		Received:  
		<?php
		}
		?>
	</td>
	<td>
	<?php
	retrieveMonthListHTML("receiveMonth");
	retrieveDayListHTML("receiveDay");
	retrieveYearListHTML("receiveYear");
	retrieveHourListHTML("receiveHour");
	retrieveMinuteListHTML("receiveMinute");
	retrieveShiftListHTML("amorpm");
	?>
	</td>
</tr>
<tr>
	<td>Originating Office:</td>
<!--
	<td><input type=text name='origInput' /></td>
</tr>
<tr>
	<td  align=right>-or- Select from the list<input type=checkbox name='origList' value='on' ></td>
	-->
	<td>
	<?php
	
	$db=retrieveRecordsDb();
	$departmentName=getDepartment($db,$_SESSION['department']);
	$sql="select * from originating_office where department_name='".$departmentName."'";
	$rs=$db->query($sql);
	$row=$rs->fetch_assoc();
	
	retrieveOfficeListHTML($db,$row['department_code'],'originating_office','origInput');
	?>
	</td>
</tr>
<tr>
	<td>Originating Officer:</td>
	<td>
	<?php
	$db=retrieveRecordsDb();
	retrieveOfficerListHTML($db,"originating_officer");
	?>
	</td>
</tr>
<tr>
	<td>Security Level</td>
	<td>
		<select name='security'>
		<option value='unsecured'>Accessible to All Divisions</option>
		<option value='GMsecured'>GM Level</option>
		<option value='divSecured'>Division Level</option>
		</select>
	</td>
</tr>
<tr>
	<td colspan=2 align=center><input type=submit value='Submit' /></td>
</tr>
</table>
</form>
</body>