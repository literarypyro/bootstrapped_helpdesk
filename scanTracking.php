<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
<meta http-equiv="refresh" content="5;url=scanMessages.php" />
-->
<script type="text/javascript" src="prototype.js"></script>
<style type="text/css">
#alterTable {
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

#cssTable td{
background-color: #0066cb;
color: #ffcc35;
	
}

#cssTable th{
background-color: #0066cb;
color: #ffcc35;
	
}

</style>
<body>
<table id='cssTable' width=100%>
<tr>
<th colspan=6><h2>Online Dispatch Staff Tracking</h2></th>
</tr>
<tr>
<th>Dispatch Staffer</th>
<th>Login Time</th>
<th>Login Date</th>
<th>Reference Number</th>
</tr>
<?php
$db=new mysqli('localhost','root','123456','helpdesk');
$sql="select * from dispatch_track order by login_time desc";
$rs=$db->query($sql);
$nm=$rs->num_rows;

//$routing_Option="<select name='change_task'>";
for($i=0;$i<$nm;$i++){
	$row=$rs->fetch_assoc();
	
	$sql2="select * from dispatch_staff where id='".$row['dispatch_staffer']."'";
	$rs2=$db->query($sql2);
	$row2=$rs2->fetch_assoc();
	
	$sql3="select * from task where id='".$row['task_id']."'";
	$rs3=$db->query($sql3);
	$row3=$rs3->fetch_assoc();
		
?>
<tr>
	
	<?php
	if($row['forward_count']>0){
		$tableStyle=" style='background-color:red;' ";
	}
	else {
		$tableStyle="";
	}
	?>
	<td <?php echo $tableStyle; ?>><font color="white"><b><?php echo strtoupper($row2['staffer']); ?></b></font></td>
	<td <?php echo $tableStyle;  ?>><?php echo date("h:ia",strtotime($row['login_time'])); ?></td>
	<td <?php echo $tableStyle;  ?>><?php echo date("F d, Y",strtotime($row['login_time'])); ?></td>
	<td <?php echo $tableStyle;  ?>><?php echo $row3['reference_number']; ?></td>
</tr>
<?php
//	$routing_Option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
}
//$routing_Option.="</select>";
?>

</table>
</body>