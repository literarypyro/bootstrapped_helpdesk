<?php
session_start();
?>
<?php
require("db_page.php");
require_once("Classes/PHPExcel.php");
require_once("Classes/PHPExcel/IOFactory.php");
require("excel functions.php");

if(isset($_SESSION['service_call'])){
	$filename="manual/helpdesk online request.xls";
 	$db=retrieveHelpdeskDb();
	$sql="select * from task_view where task_id='".$_SESSION['service_call']."'";
	$rs=$db->query($sql);
	$row=$rs->fetch_assoc();
	$referenceNumber=$row['reference_number'];
	$task_id=$row['task_id'];
	$client_name=$row['client_name'];
	$probConcern=$row['class'];
	$unitType=$row['unit_name'];	
	$division=$row['division'];	
	$dispatch_time=$row['dispatch_time'];
	$dispatch_staff=$row['staff_name'];
	$problem_details=$row['problem_details'];

	$newFilename="printout/Service Call_".$referenceNumber."_".$task_id.".xls";
	copy($filename,$newFilename);
	$workSheetName="Service Sheet";	
	$workbookname=$newFilename;
	$excel=loadExistingWorkbook($workbookname);

//	$ExWb=createWorkbook($excel,$workbookname,"open",$excelClass);
	
//	$ExWb=createWorkbook($excel,$workbookname,"open");\

  	$ExWs=createWorksheet($excel,$workSheetName,"openActive");

    if ($probConcern == "Network")
	{
		addContent(setRange("c70","c70"),$excel,"x","true",$ExWs);
    }
    else if ($probConcern == "Software")
    {
 		addContent(setRange("b70","b70"),$excel,"x","true",$ExWs);
    }
    else if ($probConcern == "Hardware")
    {
 		addContent(setRange("a70","a70"),$excel,"x","true",$ExWs);
    }

	addContent(setRange("a8","e8"),$excel,"NAME: ".$client_name,"false",$ExWs);
	addContent(setRange("f8","j8"),$excel,"DATE: ".date("F d, Y",strtotime($dispatch_time)),"false",$ExWs);
	addContent(setRange("a9","e9"),$excel,"DIVISION/SECTION: ".$division,"false",$ExWs);
	addContent(setRange("f9","j9"),$excel,"TIME OF CALL: ".date("H:ia",strtotime($dispatch_time)),"false",$ExWs);
	addContent(setRange("a10","j10"),$excel,"PROBLEMS: ".$probConcern,"false",$ExWs);

	
	addContent(setRange("c25","e26"),$excel,$problem_details,"true",$ExWs);

	
	save($ExWb,$excel,$newFilename); 	
	echo "A Service Call Printout has been generated!  Press right click and Save As: <a href='".$newFilename."'>Here</a>";
	unset($_SESSION['service_call']);

?>
<script language='javascript'>
//self.close();
</script>
<?php
}

?>