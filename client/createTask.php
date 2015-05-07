<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
require("form functions.php");
require("db_page.php");
?>
<?php
$_SESSION['helpdesk_page']="createTask.php";
?>
<?php
//POST Variables

if((isset($_POST['client_name']))&&($_POST['client_name']!=="")){

	$receiveHour=0;
	$receiveMinute=0;
	$receiveMinute=$_POST['documentMinute'];

	$receiveHour=adjustTime($_POST['docamorpm'],$_POST['documentHour']);
	$receiveDay=$_POST['documentYear']."-".$_POST['selectMonth']."-".$_POST['selectDay'];
	$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";
	
	$reference_number="HD-".date("Y")."".date("m")."".date("d")."-".date("H")."".date("i")."-";

	$db=retrieveHelpdeskDb("primary");

	$sql="insert into task(client_name,division_id,unit_id,classification_id,dispatch_time,problem_details,reference_number,status) values (\"".$_POST['client_name']."\",'".$_POST['office_name']."','".$_POST['unit_type']."','".$_POST['problem_concern']."','".$received_date."',\"".$_POST['details']."\",'".$reference_number."','Pending')";
	$rs=$db->query($sql);
	$taskID=$db->insert_id;

	$reference_number="HD-".date("Y")."".date("m")."".date("d")."-".date("H")."".date("i")."-".$taskID;
	
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
<title>Submit New Helpdesk Issue</title>
<style type="text/css">
#cssTable {
background-color: #062e56;
color: white;

}
table {
	font: bold 14px "Trebuchet MS", Arial, sans-serif;
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
	
	#menuh
	{
	padding-left: 0;
	width: 100%; 
	font-size: small;
		font: bold 14px "Trebuchet MS", Arial, sans-serif;


	float:right;
	
	}

			#menuh li
	{
	position:relative;
	min-height: 1px;		
	vertical-align: bottom;		
	margin-bottom:0px;
	}
	
	
	#menuh a
	{
	text-align: left;
	display:block;
	border: 1px solid #555;
	white-space:nowrap;
	margin:0px;
	padding: 0.3em;
	}
	#menuh a:link, #menuh a:visited, #menuh a:active	/* menu at rest */
	{
	color: white;
	background-color: #00cc66;
	text-decoration:none;
	}
	

	#menuh a:hover	/* menu on mouse-over  */
	{
	color: black;
		background-color: #ed5214;
/**The color of the links */

	text-decoration:none;
	}	
	#menuh ul li a.active {
	color: black;
		background-color: #ed5214;
	}
	
	#menuh a.top_parent, #menuh a.top_parent:hover 
	{
	background-position: right center;
	background-repeat: no-repeat;
	}
	#menuh a.parent, #menuh a.parent:hover 	
	{
	background-position: right center;
	background-repeat: no-repeat;
	}
	#menuh ul
	{
	
	list-style:none;
	margin:0;
	padding:0;
	float:bottom;

	}	
	
		#menuh ul ul
	{
	position:absolute;
	z-index:500;
	top:0;
	left:100%;
	display:none;
	padding: 1em;
	margin:-1em 0 0 -1em;
	}
		#menuh ul ul ul
	{
	top:0;
	left:100%;
	}
	
	
	


	div#menuh li:hover
	{
	cursor:pointer;
	z-index:100;
	}

	div#menuh li:hover ul ul,
	div#menuh li li:hover ul ul,
	div#menuh li li li:hover ul ul,
	div#menuh  li li li li:hover ul ul
	{display:none;}

	div#menuh  li:hover ul,
	div#menuh  li li:hover ul,
	div#menuh  li li li:hover ul,
	div#menuh  li li li li:hover ul
	{display:block;}


</style>
<body style="background-image:url('body background.jpg');">
	<?php 
	require("web_header.php");
	?>
<!--
<div align=right><a href="#">Back to Main Page</a></div>
-->

<table  width="100%"  bgcolor="#FFFFFF" cellpadding="5px" bordercolor="#CCCCCC" style="border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px">
<tr>
	<?php 
	require("client_sidebar.php");
	//background-color:#66ceae; 
	?>
	<td width="85%" rowspan=2 valign="top"  style="background-color:#66ceae; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black;" bordercolor="#FF6600">
<form enctype="multipart/form-data" action='createTask.php' method='post'>
<table id='cssTable' align=center style='border: 1px solid gray'>
<tr><th colspan=2>Report New Issue</th></tr>
<tr>
	<td>Enter Client Name:</td>
	<td><input type='text' name='client_name' size=40 /></td>
</tr>
<tr>
	<td>Division/Office:</td>
	<td>
	<select name='office_name'>
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
	</td>
</tr>
<tr>
	<td>Problem Concern:</td>
	<td>
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
	</td>
</tr>
<tr>
	<td>Type of Unit:</td>
	<td>
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
	</td>
</tr>
	<tr>
	<td>
	Problem Details:
	</td>
	<td>
	<textarea name='details' cols=70 rows=5></textarea>
	</td>
</tr>
<tr>
	<td>
	Request Time:
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
	<td colspan=2 align=center><input type=submit value='Submit' /></td>
</tr>
</table>
</form>
<?php
echo $prompt;
?>
</td>
</tr>
</table>
</body>