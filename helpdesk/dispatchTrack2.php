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
	$loginHour=adjustTime($_POST['loginamorpm'],$_POST['loginHour']);
	$loginDay=$_POST['loginYear']."-".$_POST['loginMonth']."-".$_POST['loginDay'];
	$login_date=$loginDay." ".$loginHour.":".$loginMinute.":00";
	
	$db=new mysqli("localhost","root","","helpdesk_backup");
	//$db=retrieveHelpdeskDb();
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

	#menuh
	{
	padding-left: 0;
	width: 100%; 
	font-size: small;
	font: bold 14px "Trebuchet MS", Arial, sans-serif;
	float:left;
	}

	#menuh a
	{
	text-align: left;
	display:block;
	border: 1px solid #555;
	white-space:nowrap;
	margin:0;
	padding: 0.3em;
	}
	#menuh a:link, #menuh a:visited, #menuh a:active	/* menu at rest */
	{
	color: #bd2031;
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
	#menuh a.active {
	color: black;
		background-color: #ed5214;
	}
	
	#menuh a.top_parent, #menuh a.top_parent:hover  /* attaches down-arrow to all top-parents */
	{
	background-position: right center;
	background-repeat: no-repeat;
	}
	#menuh a.parent, #menuh a.parent:hover 	/* attaches side-arrow to all parents */
	{
	background-position: right center;
	background-repeat: no-repeat;
	}
	#menuh ul
	{
	/**This places the overall menu to the straight line*/
	
	list-style:none;
	margin:0;
	padding:0;
	float:bottom;
	/* NOTE: For adjustable menu boxes you can comment out the above width rule.
	However, you will have to add padding in the "#menh a" rule so that the menu boxes
	will have space on either side of the text -- try it */
	}	
	
		#menuh ul ul
	{
	/**This places the submenu to minimize before hover*/
	
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
	
		#menuh li
	{
	position:relative;
	min-height: 1px;		/* Sophie Dennis contribution for IE7 */
	vertical-align: bottom;		/* Sophie Dennis contribution for IE7 */
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
<title>Update Helpdesk Staff Status</title>
	<body style="background-image:url('body background.jpg');">

	<div align=center><img src="helpdesk Header.jpg" style="width:80%; height:200;" /></div>
<div align="right" width=100%><a style='color:red' href="logout.php">Log Out</a></div>


<table  width="100%"  bgcolor="#FFFFFF" cellpadding="5px" bordercolor="#CCCCCC" style="border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px">


<tr>
	<?php 
	require("helpdesk_sidebar.php");
	//background-color:#66ceae; 
	?>
	<td width="85%" rowspan=2 valign="top"  style="background-color:#66ceae; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black;" bordercolor="#FF6600">

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
			$db=new mysqli("localhost","root","","helpdesk_backup");
			//$db=retrieveHelpdeskDb();
			$sql="select (select count(*) from forward_task where id=task.id) as forward_count,task.* from task where (select count(*) from accomplishment where task_id=id)=0 and dispatch_staff='".$_SESSION['username']."' order by dispatch_time desc";
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
		<table id='cssTable' align=center style='border: 1px solid gray'>
		<tr><th colspan=2><h3>Helpdesk Login:</h3></th></tr>
		<tr>
			<td>
			Log as Dispatch Staffer:
			</td>
			<td>
				<select name="login_user">
				<?php	
				$db=retrieveHelpdeskDb();

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
	<table  align=center id='cssTable' style='border: 1px solid gray'>
	<tr><th colspan=2><h3>Helpdesk Login:</h3></th></tr>
	<tr>
		<td>
		Log as Dispatch Staffer:
		</td>
		<td>
			<select name="login_user">
			<?php	
			$db=retrieveHelpdeskDb();

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
</td>
</tr>
</table>
</body>