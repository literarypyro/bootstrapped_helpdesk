<?php

//$filename  = dirname(__FILE__).'/data.txt';


$db=new mysqli("localhost","root","","hdesk");
$sql="select * from htable";
$rs=$db->query($sql);
$nm=$rs->num_rows;

while ($nm<=0) // check if the data file has been modified
{
	usleep(10000); // sleep 10ms to unload the CPU
	clearstatcache();
	$db=new mysqli("localhost","root","","hdesk");
	$sql="select * from htable";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
}

$db=new mysqli("localhost","root","","hdesk");
$sql="delete from htable";

$response = array();
//$response['msg']       = file_get_contents($filename);
//$response['msg']       = $_GET['department'];
$response['msg']       = "A message";

$response['timestamp'] = 0;
echo json_encode($response);
flush();

?>