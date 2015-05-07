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
<th colspan=6><h2>Online Client Requests</h2></th>
</tr>
<tr>
<th>Reference Number</th>
<th>Client Name</th>
<th>Office</th>
<th>Unit Type</th>
<th>Problem Concern</th>
<th>Dispatch Time</th>
</tr>
<?php
$db=new mysqli('nea','hdesk','123456','helpdesk_system');
$sql="select (select count(*) from forward_task where id=task.id) as forward_count,task.* from task where (select count(*) from accomplishment where task_id=id)=0 order by dispatch_time desc";
$rs=$db->query($sql);
$nm=$rs->num_rows;

$routing_Option="<select name='change_task'>";
for($i=0;$i<$nm;$i++){
	$row=$rs->fetch_assoc();
	
	$sql2="select * from computer where id='".$row['unit_id']."'";
	$rs2=$db->query($sql2);
	$row2=$rs2->fetch_assoc();
	
	$sql3="select * from classification where id='".$row['classification_id']."'";
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
	<td <?php echo $tableStyle; ?>><font color="white"><b><?php echo $row['reference_number']; ?></b></font></td>
	<td <?php echo $tableStyle;  ?>><?php echo $row['client_name']; ?></td>
	<td <?php echo $tableStyle;  ?>><?php echo $row['division_id']; ?></td>
	<td <?php echo $tableStyle;  ?>><?php echo $row2['unit']; ?></td>
	<td <?php echo $tableStyle;  ?>><?php echo $row3['type']; ?></td>
	<td <?php echo $tableStyle;  ?>><?php echo date("F d, Y h:ia",strtotime($row['dispatch_time'])); ?></td>
</tr>
<?php
	$routing_Option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
}
$routing_Option.="</select>";
?>

</table>
</body>