<?php
session_start();
?>
<?php
require('db_page.php');
//$db=localOnlyDb();
$db=retrieveHelpdeskDb();
//$db=new mysqli("nea","hdesk","123456","helpdesk_system");
$loginSQL="insert into log_history(username, time, action) values ('".$_SESSION['username']."','".date("Y-m-d H:i:s")."','logout')";
$loginrs=$db->query($loginSQL);
$loginnm=$loginrs->num_rows;

session_destroy();

header('Location: ../index.php?bP=1a8o990dDm13d3lC35');


?>

