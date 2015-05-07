<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
require("form functions.php");
?>
<?php
if((isset($_POST['location']))&&(isset($_POST['task_id']))){
	$loginHour=adjustTime($_POST['loginamorpm'],$_POST['loginHour']);
	$loginDay=$_POST['loginYear']."-".$_POST['loginMonth']."-".$_POST['loginDay'];
	$login_date=$loginDay." ".$loginHour.":".$loginMinute.":00";
	
	$db=new mysqli('patricksilva-pc','root','123456','helpdesk');
	$sql="insert into dispatch_track(dispatch_staffer,login_time,location,task_id) values ('".$_POST['user_name']."','".$login_date."',\"".$_POST['location']."\",'".$_POST['task_id']."')";
	$rs=$db->query($sql);

	echo "Dispatch staffer has updated his status.<br>";	
	

}

?>
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
<body>
<div align=center><img src="helpdesk Header.jpg" style="width:1200; height:300;" /></div>

<?php
//POST Variables
if(isset($_POST['login_user'])){
	if($_POST['login_password']=="123456"){
?>
		<form action='dispatchTrack.php' method='post'>
		<table id='cssTable' align=center style='border: 1px solid gray'>
		<tr><th colspan=2>Report New Issue</th></tr>
		<tr>
			<td>
			Log-in Date:
			</td>
			<td>
			<?php
			retrieveMonthListHTML("loginMonth");
			retrieveDayListHTML("loginDay");
			retrieveYearListHTML("loginYear");
			?>
			</td>
		</tr>	
		<tr>
			<td>
			Time:
			</td>
			<td>
			<?php
			retrieveHourListHTML("loginHour");
			retrieveMinuteListHTML("loginMinute");
			retrieveShiftListHTML("loginamorpm");
			?>
			</td>
		</tr>
		<tr>
			<td>Enter Current Location:</td>
			<td><input type='text' name='location' size=40 /></td>
		</tr>
		<tr>
			<td>Enter Task:</td>
			<td>
			<select name='task_id'>
			<?php
			$db=new mysqli('patricksilva-pc','root','123456','helpdesk');
			$sql="select (select count(*) from forward_task where id=task.id) as forward_count,task.* from task where (select count(*) from accomplishment where task_id=id)=0 order by dispatch_time desc";
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
		</tr>
		<tr>
			<td colspan=2 align=center><input type=submit value='Submit' /><input type=hidden name='user_name' value='<?php echo $_POST['login_user']; ?>' /></td>
		</tr>
		</table>
		</form>	
<?php
	}
	else {
?>
		<form action='dispatchTrack.php' method='post'>
		<table id='cssTable' style='border: 1px solid gray'>
		<tr><th colspan=2><h3>Helpdesk Login:</h3></th></tr>
		<tr>
			<td>
			Log as Dispatch Staffer:
			</td>
			<td>
				<select name="login_user">
				<?php	
				$db=new mysqli('patricksilva-pc','root','123456','helpdesk');
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
			<td>
			Password:
			</td>
			<td><input type='password' name='login_password' size=20 /></td>
		</tr>
		<tr>
			<td colspan=2 align=center><input type=submit value='Submit' /><input type=hidden name='user_name' value='<?php echo $_POST['login_user']; ?>' /></td>
		</tr>
		</table>
		</form>	
<?php	
	}
}
else {
?>
	<form action='dispatchTrack.php' method='post'>
	<table id='cssTable' style='border: 1px solid gray'>
	<tr><th colspan=2><h3>Helpdesk Login:</h3></th></tr>
	<tr>
		<td>
		Log as Dispatch Staffer:
		</td>
		<td>
			<select name="login_user">
			<?php	
			$db=new mysqli('patricksilva-pc','root','123456','helpdesk');
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
		<td>
		Password:
		</td>
		<td><input type='password' name='login_password' size=20 /></td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type=submit value='Submit' /></td>
	</tr>
	</table>
	</form>	
<?php
}
?>

</body>