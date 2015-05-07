<?php

function retrieveHelpdeskDb($user){
	if($user=="primary"){
//		$db=new mysqli("localhost","root","123456","helpdesk");
		$db=new mysqli("localhost","root","","helpdesk_php");

		return $db;
	

	}
	else if($user=="secondary"){
	$db=new mysqli("localhost","root","","helpdesk_php");
		return $db;
	
	
	}
	else if($user=="client"){
		$pc_name=$_SERVER['HTTP_HOST'];
		$db=new mysqli($pc_name,"root","","helpdesk_php");
		if(isNullDb($db)=="false"){
			$db=new mysqli($pc_name,"root","","helpdesk_php");
		}
		return $db;
	}
	else {
		$pc_name=$_SERVER['HTTP_HOST'];
		$db=new mysqli($pc_name,"root","","helpdesk_php");
		if(isNullDb($db)=="false"){
			$db=new mysqli($pc_name,"root","123456","helpdesk_backup");
		}
		return $db;
	}
}

function isNullDb($forTestDb){
	$sql="select * from task limit 1";
	$rs=$forTestDb->query($sql);

	$connect="true";
	if($rs==null){
		$connect="false";
	}
	return $connect;

}

function identifyHost($hostName){
	$host="client";
	if(strtolower($hostName)=="nea"){
		$host="primary";
	}
	else if(strtolower($hostName)=="aida") {
		$host="secondary";
	}
	else {
		$host="client";
	}
}

?>