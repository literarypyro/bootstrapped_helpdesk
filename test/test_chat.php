<?php
if(isset($_POST['chat'])){
	$db=new mysqli("localhost","root","","test_push");
	$modify=date("Y-m-d H:i:s");
	$sql="insert into table1(test,modify_time) values (\"".$_POST['chat']."\",'".$modify."')";
	echo $sql;
	$rs=$db->query($sql);


}
?>
<form action='test_chat.php' method='post'>

<input type=text name='chat'>


<input type=submit value='Submit' />

</form>

