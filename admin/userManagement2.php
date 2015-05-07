<?php
session_start();
?>
<?php
require("db_page.php");
?>
<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
$_SESSION['helpdesk_page']="userManagement.php";

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin_staff.css" />
<?php
	if(isset($_POST['submitValue'])){
		$db=new mysqli("nea","hdesk","123456","helpdesk_system");
		if($_POST['submitValue']=="Add"){
			$sql="insert into dispatch_staff(staffer,position) values (\"".$_POST['name']."\",\"".$_POST['position']."\")";
			$rs=$db->query($sql);
			
			$Id=$db->insert_id;
			
			$sql="insert into login(username,password,type) values (\"".$Id."\",\"".$_POST['password']."\",\"".$_POST['type']."\")";
			$rs=$db->query($sql);
		
		}
		else if($_POST['submitValue']=="Delete"){
			$sql="delete from login where username='".$_POST['pageNumber']."'";
			$rs=$db->query($sql);
			

			$sql2="delete from dispatch_staff where id='".$_POST['pageNumber']."'";
			$rs2=$db->query($sql2);


		}
		else {

			$sql="update dispatch_staff set staffer=\"".$_POST['name']."\",	position=\"".$_POST['position']."\" where id='".$_POST['pageNumber']."'";
			$rs=$db->query($sql);
			
		
			$sql="update login set password=\"".$_POST['password']."\", type=\"".$_POST['type']."\" where username='".$_POST['pageNumber']."'";
			$rs=$db->query($sql);

		
		
		}
	
	
	
	}






?>
<?php
$db=new mysqli("nea","hdesk","123456","helpdesk_system");
$sql="SELECT * FROM dispatch_staff inner join login on dispatch_staff.id=login.username order by dispatch_staff.id";
$rs=$db->query($sql);
$nm=$rs->num_rows;
?>

<?php
echo "<script language='javascript'>";
echo "var userStaff=new Array;";

for($i=1;$i<=$nm;$i++){
$row=$rs->fetch_assoc();

	if($i==1){
		$firstStaffer=$row['staffer'];
		$firstPosition=$row['position'];
		$firstType=$row['type'];
		$firstPassword=$row['password'];
	
	
	}

	echo "userStaff[".$i."]=new Array();";
	echo "userStaff[".$i."]['name']='".$row['staffer']."';";
	echo "userStaff[".$i."]['position']='".$row['position']."';";
	echo "userStaff[".$i."]['type']='".$row['type']."';";
	echo "userStaff[".$i."]['password']='".$row['password']."';";



}

echo "</script>";


?>
<script language="javascript">
function iterate(pgindex,action){
	if(action=="prev"){
		if(pgindex==1){
			alert("You have reached the end of the record");	
		
		}
		else if(pgindex==""){
			var iterator=1;
			document.getElementById("name").value=userStaff[iterator]['name'];
			document.getElementById("position").value=userStaff[iterator]['position'];
			document.getElementById("type").value=userStaff[iterator]['type'];
			document.getElementById("password").value=userStaff[iterator]['password'];
		document.getElementById("pageNumber").value=1;
		}
		else {
			document.getElementById("pageNumber").value=pgindex*1-1;
			
			var iterator=pgindex*1-1;
			document.getElementById("name").value=userStaff[iterator]['name'];
			document.getElementById("position").value=userStaff[iterator]['position'];
			document.getElementById("type").value=userStaff[iterator]['type'];
			document.getElementById("password").value=userStaff[iterator]['password'];
			
		}
		document.getElementById("submitValue").value="Edit";
		document.getElementById("labelData").innerHTML="Edit Helpdesk Data";

	}
	else if(action=="next"){
		var userCount=userStaff.length*1-1;
		if(pgindex==userCount){
			alert("You have reached the end of the record");	
		}
		else{
			document.getElementById("pageNumber").value=pgindex*1+1;
			var iterator=pgindex*1+1;
			document.getElementById("name").value=userStaff[iterator]['name'];
			document.getElementById("position").value=userStaff[iterator]['position'];
			document.getElementById("type").value=userStaff[iterator]['type'];
			document.getElementById("password").value=userStaff[iterator]['password'];

		}
		document.getElementById("submitValue").value="Edit";
		document.getElementById("labelData").innerHTML="Edit Helpdesk Data";
	}
	else if(action=="add"){
		document.getElementById("pageNumber").value="";
		document.getElementById("submitValue").value="Add";
		document.getElementById("labelData").innerHTML="Add Helpdesk Staff";
		
		document.getElementById("name").value="";
		document.getElementById("position").value="";
		document.getElementById("type").value="";
		document.getElementById("password").value="";
		
		
		
	}
	else if(action=="remove"){
		if(document.getElementById('pageNumber').value==""){
			alert("No record indicated.");
		}
		else {
			document.getElementById("submitValue").value="Delete";
			document.getElementById("labelData").innerHTML="Marked for Deletion";
		}
	}
	
	else {
		document.getElementById("submitValue").value="Edit";
		document.getElementById("labelData").innerHTML="Edit Helpdesk Data";
	
	}

}

</script>
<!--
<meta http-equiv="refresh" content="5;url=scanMessages.php" />
-->
<script type="text/javascript" src="prototype.js"></script>
	<body style="background-image:url('body background.jpg');">
	<?php 
	require("web_header.php");
	?>
	<!--Heading Table-->
	<table width="100%"  bgcolor="#FFFFFF" cellpadding="5px" bordercolor="#CCCCCC" style="border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px">
<tr>
	<th colspan=2 align=right>Administrator: <font color=black><?php echo $userRow['staffer']; ?></font></th>
</tr>

<tr>
	<?php 
	require("admin_sidebar.php");
	//background-color:#66ceae; 
	?>
	<td width="85%" rowspan=2 valign="top"  style="background-color:#66ceae; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black;" bordercolor="#FF6600">
	<form action="userManagement.php" method="post">
	<table  id='cssTable' >
		<tr><th id='labelData' colspan=2>Edit Helpdesk Data</th></tr>
		<tr>
			<td>
			Name
			</td>
			<td>
			<input type=text id='name' name='name' value="<?php echo $firstStaffer; ?>" size=30 />
			</td>
		</tr>	
		<tr>
			<td>
			Type of Access
			</td>
			<td>
				<input type=text id='type' name='type' value="<?php echo $firstType; ?>" size=30 />
			</td>
		</tr>
		<tr>
			<td>Position</td>
			<td><input type='text' id='position' name='position' value="<?php echo $firstPosition; ?>" size=30 /></td>
		</tr>
		<tr>
			<td>Password</td>
			<td>
				<input type="text" id='password' name="password" value="<?php echo $firstPassword; ?>" size=15 />
	
			</td>
		</tr>
		<tr>
			<td align=center colspan=2 style='background-color: #ed5214;'>
			<a href='#labelData' style='color:white; text-decoration:none;' onclick="iterate('','remove')" ><<<</a><font color="#ed5214">|</font>
			<a href='#labelData' style='color:white;text-decoration: none;' onclick="iterate(document.getElementById('pageNumber').value,'prev');"><</a>
			<input id='pageNumber' style="text-align:center" type="text" name="pageNumber" size=4 value='1' onkeyup="iterate(document.getElementById('pageNumber').value,'index');" />	
			<a href='#labelData' style='color:white;text-decoration: none;'  onclick="iterate(document.getElementById('pageNumber').value,'next');">></a><font color="#ed5214">|</font>
			<a href='#labelData' style='color:white; text-decoration:none;' onclick="iterate('','add')" >>>></a>
			</td>
	
		</tr>
		<tr>
		<td style="background-color:#66ceae; border:0;" align=center colspan=2><input id='submitValue' name='submitValue' type=submit value='Edit' /></td>
		</tr>
	</table>

	</form>
	</td>
</tr>
</table>