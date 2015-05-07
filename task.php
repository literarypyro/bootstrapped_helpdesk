<?php
if(isset($_POST['task'])){
	$db=new mysqli('localhost','root','','hdesk');
	$sql="insert into htable(taskname) values (\"".$_POST['task']."\")";
	$rs=$db->query($sql);

}

?>
<form action="task.php" method=post>
<input type=text name='task' />
<input type=submit value="Submit" />
</form>