<?php
session_start();
?>
<?php
require("db_page.php");
require_once("Classes/PHPExcel/IOFactory.php");
require("excel functions.php");

 if(isset($_GET['print'])){
	$db=retrieveHelpdeskDb();
	$sql="update accomplishment set printed='true' where task_id='".$_GET['print']."'";
	$rs=$db->query($sql);
	echo "
	<script language='javascript'>
	self.close();
	</script>";

 }

if(isset($_GET['adminPrint'])){
	$_SESSION['helpdesk_printout']=$_GET['adminPrint'];

} 
 
if(isset($_SESSION['helpdesk_printout'])){
//	$filename="manual/stock studies.xls";
	$filename="manual/Help Desk Center Form.xls";

	//$db=new mysqli("localhost","root","","helpdesk_backup");
	$db=retrieveHelpdeskDb();
	$sql="select *,accomplishment.status as accomplishment_status,(select staffer from dispatch_staff where id=task.dispatch_staff limit 1) as staff_name,(select division_name from division where division_code=task.division_id limit 1) as division_name,(select unit from computer where id=task.unit_id limit 1) as unit_name,(select type from classification where id=task.classification_id limit 1) as classification_name from task inner join accomplishment on task.id=accomplishment.task_id where task_id='".$_SESSION['helpdesk_printout']."'";
	$rs=$db->query($sql);
	$row=$rs->fetch_assoc();
	$referenceNumber=$row['reference_number'];
	$task_id=$row['task_id'];
	$client_name=$row['client_name'];
	$probConcern=$row['classification_name'];
	$unitType=$row['unit_name'];	
	$division=$row['division_name'];	
	$dispatch_time=$row['admin_time'];
	$dispatch_staff=$row['staff_name'];
	$divId=$row['division_id'];
	
	$accomplish_time=$row['accomplish_time'];
	$status=$row['accomplishment_status'];
	$action_details=$row['action_taken'];
	$recommendation=$row['recommendation'];
	$problem_details=$row['problem_details'];
	
	$sql2="select * from taskadmin inner join dispatch_staff on taskadmin.admin_id=dispatch_staff.id where task_id='".$_SESSION['helpdesk_printout']."' ";
	$rs2=$db->query($sql2);
	$row2=$rs2->fetch_assoc();
	$administrator=$row2['staffer'];	
	$adminposition=$row2['position'];
	
	$sql3="select * from adminofficer where division_id='".$row['division_id']."' ";
	$rs3=$db->query($sql3);
	$row3=$rs3->fetch_assoc();
	$head=$row3['admin'];	
	$position=$row3['position'];
	
	$newFilename="printout/Helpdesk Request_".$referenceNumber."_".$task_id.".xls";
	copy($filename,$newFilename);
	$workSheetName="Helpdesk Form";	
	$workbookname=$newFilename;
	$excel=loadExistingWorkbook($workbookname);

//	$ExWb=createWorkbook($excel,$workbookname,"open",$excelClass);
	
//	$ExWb=createWorkbook($excel,$workbookname,"open");\

 	$ExWs=createWorksheet($excel,$workSheetName,"openActive");
	addContent(setRange("c13","f13"),$excel,$client_name,"true",$ExWs);
	addContent(setRange("a45","e45"),$excel,strtoupper($client_name),"true",$ExWs);
	addContent(setRange("i13","j13"),$excel,$referenceNumber,"true",$ExWs);
	addContent(setRange("c14","f14"),$excel,$division,"true",$ExWs);
	addContent(setRange("c16","d16"),$excel,$unitType,"true",$ExWs);
	addContent(setRange("i16","j16"),$excel,$probConcern,"true",$ExWs);
	addContent(setRange("d19", "j22"),$excel,$problem_details,"true",$ExWs);
	addContent(setRange("d24", "f24"),$excel,date("F d, Y",strtotime($dispatch_time)),"true",$ExWs);
	addContent(setRange("i24", "j24"),$excel,date("h:ia",strtotime($dispatch_time)),"true",$ExWs);
	addContent(setRange("f45", "j45"),$excel,strtoupper($dispatch_staff),"true",$ExWs);
	addContent(setRange("a52", "e52"),$excel,strtoupper($head),"true",$ExWs);
	addContent(setRange("a53", "e55"),$excel,$position,"true",$ExWs);
	
	addContent(setRange("f52", "j52"),$excel,strtoupper($administrator),"true",$ExWs);
	addContent(setRange("f53", "j53"),$excel,$adminposition,"true",$ExWs);

	addContent(setRange("d28", "j31"),$excel,$action_details,"true",$ExWs);
	addContent(setRange("d32", "j35"),$excel,$recommendation,"true",$ExWs);
	addContent(setRange("d37","d37"),$excel,$status,"true",$ExWs);
	addContent(setRange("d38","d38"),$excel,date("h:ia",strtotime($accomplish_time)),"true",$ExWs);
	addContent(setRange("d39","d39"),$excel,date("F d, Y",strtotime($accomplish_time)),"true",$ExWs);

	save($ExWb,$excel,$newFilename); 
	
	echo "A Print Out has been generated!  Press right click and Save As: <a href='".$newFilename."'>Here</a>";
	echo "<br>Confirm your printing <a href='print_outline3.php?print=".$_SESSION['helpdesk_printout']."'>Here</a>";
	unset($_SESSION['helpdesk_printout']);

?>
<script language='javascript'>
//self.close();
</script>
<?php
}

?>