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
<?php
	if(isset($_POST['officerList'])){
	$db=new mysqli("localhost","root","","helpdesk");
		switch($_POST["officerAction"]){
			case "name":
				$sql="update dispatch_staff set staffer='".$_POST['updateText']."' where id='".$_POST['officerList']."'";
				$rs=$db->query($sql);
					
			break;
			
			case "delete":
				$sql="delete from dispatch_staff where id='".$_POST['officerList']."'";
				$rs=$db->query($sql);
			break;
		}
		$_POST['changeView']="staff";
	}	

	if(isset($_POST['concernList'])){
	$db=new mysqli("localhost","root","","helpdesk");
		switch($_POST["officerAction"]){
			case "name":
				$sql="update classification set type='".$_POST['updateText']."' where id='".$_POST['concernList']."'";
				$rs=$db->query($sql);
					
			break;
			
			case "delete":
				$sql="delete from classification where id='".$_POST['concernList']."'";
				$rs=$db->query($sql);
			break;
		}
		$_POST['changeView']="probs";

	}	

	if(isset($_POST['unitList'])){
	$db=new mysqli("localhost","root","","helpdesk");
		switch($_POST["officerAction"]){
			case "name":
				$sql="update computer set unit='".$_POST['updateText']."' where id='".$_POST['unitList']."'";
				$rs=$db->query($sql);
					
			break;
			
			case "delete":
				$sql="delete from computer where id='".$_POST['officerList']."'";
				$rs=$db->query($sql);
			break;
		}
		$_POST['changeView']="units";

	}		
	if(isset($_POST['addOfficerName'])){
		$db2=new mysqli("localhost","root","","helpdesk");
		$sql="insert into dispatch_staff(staffer) values ('".$_POST['addOfficerName']."')";
		$rs=$db2->query($sql);
		$_POST['changeView']="staff";

	}
	
	if(isset($_POST['addProblemConcern'])){
		$db2=new mysqli("localhost","root","","helpdesk");
		$sql="insert into classification(type) values ('".$_POST['addProblemConcern']."')";
		$rs=$db2->query($sql);
		$_POST['changeView']="probs";

	}
	
	if(isset($_POST['addUnitType'])){
		$db2=new mysqli("localhost","root","","helpdesk");
		$sql="insert into computer(unit) values ('".$_POST['addUnitType']."')";
		$rs=$db2->query($sql);
		$_POST['changeView']="units";

	}
	

?>
	<form action="helpdesk_staff.php" method=post>

	<table id='cssTable'>
	<tr>
		<td>Change View:</td>
		<td>
			<select name='changeView'>
			<option value='staff'>Helpdesk Staff</option>
			<option value='probs'>Possible Problem Concerns</option>
			<option value='units'>Types of Unit</option>
			</select>
			<input type='submit' value='Change' />
		</td>
	</tr>

	<tr><td align=center colspan=3></td></tr>
</table>
</form>

<form action="helpdesk_staff.php" method="post" >
<table id='alterTable' width=55%>
		<tr>
			<th colspan=2>
			<?php 
			if(isset($_POST['changeView'])){
				if(($_POST['changeView']=="staff")||($_POST['changeView']=="")){
				?>
				<h2>Helpdesk Staff Masterlist</h2>
				<?php
				}	
				else if($_POST['changeView']=="probs"){
				?>
				<h2>Possible Problem Concerns</h2>
				<?php
				}	
				else if($_POST['changeView']=="units"){
				?>
				<h2>Types of Unit</h2>
				<?php
				}
			}
			else {
			?>
			
					<h2>Helpdesk Staff Masterlist</h2>
			<?php

			}
				?>

			
			</th>
		</tr>
		<tr>
			<th>Id</th>
			<th>
			<?php 
			if(isset($_POST['changeView'])){
				if(($_POST['changeView']=="staff")||($_POST['changeView']=="")){
					echo "Staffer Name";
				
				}	
				else if($_POST['changeView']=="probs"){
					echo "Problem Concerns";
				}	
				else if($_POST['changeView']=="units"){
					echo "Types of Unit";
				}
			}
			else {
				echo "Staffer Name";
			}
			
			?>	
			</th>
		</tr>
<?php
	$officerList="<select name='officerList'>";
	$db=new mysqli("localhost","root","","helpdesk");

	$sql="select * from dispatch_staff";			

	if(isset($_POST['changeView'])){

		if(($_POST['changeView']=="staff")||($_POST['changeView']=="")){
			$sql="select id,staffer from dispatch_staff";	
			$officerList="<select name='officerList'>";
			$manageCaption="Manage Officer";
			$officerCaption="Officer";
			$optionCaption="Change Officer Name";
			
			
		}	
		else if($_POST['changeView']=="probs"){
			$sql="select id,type as staffer from classification";			
			$officerList="<select name='concernList'>";
			$manageCaption="Manage Concern";
			$officerCaption="Problem Concern";
			$optionCaption="Modify Concern Name";


			
			
		}	
		else if($_POST['changeView']=="units"){
			$sql="select id,unit as staffer from computer";			
			$officerList="<select name='unitList'>";
			$manageCaption="Manage Unit Type";
			$officerCaption="Unit Type";
			$optionCaption="Modify Unit Name";
			
			


		}	
	}
	else {
		$sql="select id,staffer from dispatch_staff";	
		$officerList="<select name='officerList'>";
		$manageCaption="Manage Officer";
		$officerCaption="Officer";
		$optionCaption="Change Officer Name";
	
	
	}
		
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		$officerList.="<option value='".$row['id']."'>".$row['staffer']."</option>";	
?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['staffer']; ?></td>
		</tr>

<?php
	}
	$officerList.="</select>";

	?>
	
	</table>
	</form>

	<form action="helpdesk_staff.php" method=post>

	<table id='cssTable'>
	<tr>
	<th colspan=2><?php echo $manageCaption; ?></th>
	</tr>
	<tr>
		<td>
		<?php echo $officerCaption; ?></td>
		<td>
		<?php
		echo $officerList;
		?>
		</td>
	</tr>
	<tr>
		<td>Action to Take:</td>
		<td>
			<select name='officerAction'>
			<option value='name'><?php echo $optionCaption; ?></option>
			<option value='delete'>Delete Account</option>
			</select>
			<input type='text' name='updateText' />
		</td>
	</tr>
	<tr><td align=center colspan=3><input type='submit' value='Modify' /></td></tr>
</table>
</form>
<?php 
	if(isset($_POST['changeView'])){

		if(($_POST['changeView']=="staff")||($_POST['changeView']=="")){
			$addCaption="Add Officer";
			$nameCaption="Officer Name";

		}	
		else if($_POST['changeView']=="probs"){
			$addCaption="Add Problem Concern";
			$nameCaption="Problem Concern";
		}	
		else if($_POST['changeView']=="units"){
			$addCaption="Add Unit Type";
			$nameCaption="Type of Unit";
		}	
	}
	else {
		$addCaption="Add Officer";
		$nameCaption="Officer Name";

	}	
?>
<form action="helpdesk_staff.php" method=post>
<table id='cssTable'>
<tr>
<th colspan=2><b><?php echo $addCaption; ?></b></th>
</tr>
<tr>
<td><?php echo $nameCaption; ?></td>
<td>
	<?php 
	if(isset($_POST['changeView'])){

		if(($_POST['changeView']=="staff")||($_POST['changeView']=="")){
		?>
			<input type=text name='addOfficerName' />
		<?php
		}	
		else if($_POST['changeView']=="probs"){
		?>
			<input type=text name='addProblemConcern' />
		<?php
		}	
		else if($_POST['changeView']=="units"){
		?>
			<input type=text name='addUnitType' />
		<?php
		}	
	}
	else {
?>	
		<input type=text name='addUnitType' />
<?php	
	}
	?>
</td>
</tr>
<tr>
<tr><td align=center colspan=2><input type='submit' value='Add' /></td></tr>

</table>
</form>