<?php
if(isset($_GET['term'])){

$db=new mysqli("localhost","root","","inventory");

$sql="select * from supply where property_no like '".$_GET['term']."%%'";
$rs=$db->query($sql);


while($row = $rs->fetch_assoc())
{
	$results[] = array('label' => $row['property_no']);
}

$sql="select * from component where property_no like '".$_GET['term']."%%'";
$rs=$db->query($sql);


while($row = $rs->fetch_assoc())
{
	$results[] = array('label' => $row['property_no']);
}

$sql="select * from external where property_no like '".$_GET['term']."%%'";
$rs=$db->query($sql);


while($row = $rs->fetch_assoc())
{
	$results[] = array('label' => $row['property_no']);
}

$sql="select * from accessory where property_no like '".$_GET['term']."%%'";
$rs=$db->query($sql);


while($row = $rs->fetch_assoc())
{
	$results[] = array('label' => $row['property_no']);
}


echo json_encode($results);

}

if(isset($_GET['type'])){
$db=new mysqli("localhost","root","","inventory");

	
	switch($_GET['type']){
		case "unit":
			$sql="select property_no from supply";
			$rs=$db->query($sql);
			
		
			
		break;
		
		case "component":
			$sql="select property_no from component";
			$rs=$db->query($sql);
	
		break;

		case "external":
			$sql="select property_no from external";
			$rs=$db->query($sql);
	
		break;

		case "accessory":
			$sql="select property_no from accessory";
			$rs=$db->query($sql);
		
		break;
	
	}

	$nm=$rs->num_rows;
	$data['count']=$nm;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		$data['property_no'][$i]=$row['property_no'];
	}
	echo json_encode($data);

}
?>