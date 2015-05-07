<?php
function retrieveHelpdeskDb(){
	$db=new mysqli("localhost","root","","helpdesk_php");
	//if(isNullDb($db)=="false"){
		//$db=new mysqli("","root","123456","helpdesk_backup");
	//}
	return $db;

}
function localOnlyDb(){
	$db=new mysqli("localhost","root","","helpdesk_php");
	//if(isNullDb($db)=="false"){
		//$db=new mysqli("localhost","root","123456","helpdesk_backup");
//	}
	return $db;
}


?>