<?php

$lastmodif= $_GET['timestamp'];

$db=new mysqli("localhost","root","","test_push");
$sql="select * from table1 order by modify_time desc";
$rs=$db->query($sql);
$row=$rs->fetch_assoc();

$currentmodif = strtotime($row['modify_time']);

while ($currentmodif <= $lastmodif) // check if the data file has been modified
{
  usleep(10000); // sleep 10ms to unload the CPU
  clearstatcache();
//  $currentmodif = filemtime($filename);
}

// return a json array
$response = array();
//$response['msg']       = $row['test'];
$response['msg']       = $lastmodif." = ".$currentmodif;
$response['timestamp'] = $currentmodif;
echo json_encode($response);
flush();


?>
