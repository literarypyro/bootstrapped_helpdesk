<?php
session_start();
?>
<?php

// store new message in the file
// $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
// if ($msg != '')
// {
	// $modify=date("Y-m-d H:i:s");
	// $db=new mysqli("localhost","root","","test_push");
	// $sql="insert into table1(test,modify_time) values (\"".$_GET['msg']."\",'".$modify."')";
	// $rs=$db->query(sql);

// }

$filename  = dirname(__FILE__).'/data.txt';

// store new message in the file
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
if ($msg != '')
{
  file_put_contents($filename,$msg);
  die();
}
$db=new mysqli("localhost","root","","test_push");
$sql="select * from table1 order by modify_time desc";
$rs=$db->query($sql);
$nm=$rs->num_rows;
// infinite loop until the data file is not modified
$lastmodif    = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
$currentmodif = filemtime($filename);
while ($nm<=0) // check if the data file has been modified
{
  usleep(1); // sleep 10ms to unload the CPU
  clearstatcache();
  $db=new mysqli("localhost","root","","test_push");
$sql="select * from table1 order by modify_time desc";


  $rs=$db->query($sql);
	$nm=$rs->num_rows;
  $currentmodif = filemtime($filename);
}


$row=$rs->fetch_assoc();
// $modify=strtotime(row['modify_time']);



// infinite loop until the data file is not modified
// $lastmodif    = $_GET['timestamp'];
// $currentmodif = $_SESSION['modify'];
// while ($currentmodif <= $lastmodif) // check if the data file has been modified
// while($nm==0)
// {
  // usleep(10000); // sleep 10ms to unload the CPU
  // clearstatcache();
 // $currentmodif = $modify;
// }


//This is for the display


// if(isset($_POST['chat'])){
	// $db=new mysqli("localhost","root","","test_push");
	// $modify=date("Y-m-d H:i:s");
	// $sql="insert into table2(test,modify_time) values (\"".$_POST['chat']."\",'".$modify."')";
	// $rs=$db->query($sql);


// }



// $_SESSION['modify']=$currentmodif;
// return a json array
$response = array();
// $response['msg']       = file_get_contents($filename);
$response['msg']       = $row['test'];

// $response['oldSQL']=$lastmodif;
// $response['newSQL']="";

$response['timestamp'] = $currentmodif;

$db=new mysqli("localhost","root","","test_push");
$sql="delete from table1";
$rs=$db->query($sql);
echo json_encode($response);
flush();

?>