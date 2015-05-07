<?php

// $filename  = dirname(__FILE__).'/data.txt';

// store new message in the file
// $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
// if ($msg != '')
// {
  // file_put_contents($filename,$msg);
  // die();
// }

$db=new mysqli("localhost","root","","helpdesk");
$sql="select * from forward_task";
$rs=$db->query($sql);
$nm=$rs->num_rows;

// infinite loop until the data file is not modified
// $lastmodif    = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
// $currentmodif = filemtime($filename);
//while ($currentmodif <= $lastmodif) // check if the data file has been modified
while($nm<=0)
{
  usleep(10000); // sleep 10ms to unload the CPU
  clearstatcache();
//  $currentmodif = filemtime($filename);
$db=new mysqli("localhost","root","","helpdesk");
$sql="select * from forward_task";
$rs=$db->query($sql);
$nm=$rs->num_rows;
}


//This is for the display

// $db=new mysqli("localhost","root","","test_push");
// $sql="select * from table1 order by modify_time desc";
// $rs=$db->query($sql);
// $row=$rs->fetch_assoc();
$db=new mysqli("localhost","root","","helpdesk");
$sql="delete from forward_task";
$rs=$db->query($sql);


// return a json array
$response = array();
//$response['msg']       = file_get_contents($filename);
$response['msg']       = "This is a test message";

$response['timestamp'] = $currentmodif;
echo json_encode($response);
flush();

?>