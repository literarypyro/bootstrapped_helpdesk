<?php
session_start();
?>
<?php
$_SESSION['helpdesk_page']="report generation.php";
?>
<?php
require_once("phpexcel/Classes/PHPExcel.php");
require_once("phpexcel/Classes/PHPExcel/IOFactory.php");
require("db_page.php");
require("excel functions.php");
?>
<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
	$timestamp=date("Y-m-d His");

	$newFilename="printout/assigned/Assigned Client Requests ".$timestamp.".xls";
	$workSheetName="Client Requests";
	$workbookname=$newFilename;
	$excel=startCOMGiven();
	$ExWb=$workbookname;	

	
 	$ExWs=createWorksheet($excel,$workSheetName,"create");		

	
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(14);	
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);	
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(14);

	
	
	$rowCount=2;

	addContent(setRange("A".$rowCount,"G".$rowCount),$excel,"CLIENT REQUESTS","true",$ExWs);
	$excel->getActiveSheet()->getStyle("A".$rowCount.":G".$rowCount)->getFont()->setBold(true);
	$excel->getActiveSheet()->getStyle("A".$rowCount.":G".$rowCount)->getFont()->setSize(14);		
	$excel->getActiveSheet()->getStyle("A".$rowCount.":G".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$rowCount++;
	
	$rowCount++;
	
	addContent(setRange("A".$rowCount,"A".$rowCount),$excel,"Reference Number","true",$ExWs);
	$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->getFont()->setBold(true);	
	$styleArray = array(
		'borders' => array(
			'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			),
		),
	);
	$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->applyFromArray($styleArray);
	
	addContent(setRange("A".$rowCount,"A".$rowCount),$excel,"Reference Number","true",$ExWs);
	$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->getFont()->setBold(true);	

	addContent(setRange("B".$rowCount,"B".$rowCount),$excel,"Client Name","true",$ExWs);
	$excel->getActiveSheet()->getStyle("B".$rowCount,"B".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("B".$rowCount,"B".$rowCount)->getFont()->setBold(true);	

	addContent(setRange("C".$rowCount,"C".$rowCount),$excel,"Office","true",$ExWs);
	$excel->getActiveSheet()->getStyle("C".$rowCount,"C".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("C".$rowCount,"C".$rowCount)->getFont()->setBold(true);	

	addContent(setRange("D".$rowCount,"D".$rowCount),$excel,"Unit Type","true",$ExWs);
	$excel->getActiveSheet()->getStyle("D".$rowCount,"D".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("D".$rowCount,"D".$rowCount)->getFont()->setBold(true);	

	addContent(setRange("E".$rowCount,"E".$rowCount),$excel,"Problem Concern","true",$ExWs);
	$excel->getActiveSheet()->getStyle("E".$rowCount,"E".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("E".$rowCount,"E".$rowCount)->getFont()->setBold(true);	

	addContent(setRange("F".$rowCount,"F".$rowCount),$excel,"Request Time","true",$ExWs);
	$excel->getActiveSheet()->getStyle("F".$rowCount,"F".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("F".$rowCount,"F".$rowCount)->getFont()->setBold(true);	

	addContent(setRange("G".$rowCount,"G".$rowCount),$excel,"Dispatch Staff","true",$ExWs);
	$excel->getActiveSheet()->getStyle("G".$rowCount,"G".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$excel->getActiveSheet()->getStyle("G".$rowCount,"G".$rowCount)->getFont()->setBold(true);	
	
	$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->applyFromArray($styleArray);
	$excel->getActiveSheet()->getStyle("B".$rowCount,"B".$rowCount)->applyFromArray($styleArray);
	$excel->getActiveSheet()->getStyle("C".$rowCount,"C".$rowCount)->applyFromArray($styleArray);
	$excel->getActiveSheet()->getStyle("D".$rowCount,"D".$rowCount)->applyFromArray($styleArray);
	$excel->getActiveSheet()->getStyle("E".$rowCount,"E".$rowCount)->applyFromArray($styleArray);
	$excel->getActiveSheet()->getStyle("F".$rowCount,"F".$rowCount)->applyFromArray($styleArray);
	$excel->getActiveSheet()->getStyle("G".$rowCount,"G".$rowCount)->applyFromArray($styleArray);

	$rowCount++;

	$db=retrieveHelpdeskDb();
	$sql="select (select staffer from dispatch_staff where id=task.dispatch_staff) as staffer,(select count(*) from forward_admin where id=task.id) as forward_count,task.* from task inner join dispatch_staff on task.dispatch_staff=dispatch_staff.id where (select count(*) from accomplishment where task_id=task.id)=0 and (dispatch_staff is not null) and (dispatch_staff not in ('')) order by dispatch_time desc";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();

		$sql2="select * from computer where id='".$row['unit_id']."'";
		$rs2=$db->query($sql2);
		$row2=$rs2->fetch_assoc();
		
		$sql3="select * from classification where id='".$row['classification_id']."'";
		$rs3=$db->query($sql3);
		$row3=$rs3->fetch_assoc();


		addContent(setRange("A".$rowCount,"A".$rowCount),$excel,$row['reference_number'],"true",$ExWs);
		addContent(setRange("B".$rowCount,"B".$rowCount),$excel,$row['client_name'],"true",$ExWs);
		addContent(setRange("C".$rowCount,"C".$rowCount),$excel,$row['division_id'],"true",$ExWs);
		addContent(setRange("D".$rowCount,"D".$rowCount),$excel,$row2['unit'],"true",$ExWs);
		addContent(setRange("E".$rowCount,"E".$rowCount),$excel,$row3['type'].", ".$row['problem_details'],"true",$ExWs);
		addContent(setRange("F".$rowCount,"F".$rowCount),$excel,date("F d, Y h:ia",strtotime($row['dispatch_time'])),"true",$ExWs);
		addContent(setRange("G".$rowCount,"G".$rowCount),$excel,$row['staffer'],"true",$ExWs);
		$rowCount++;

		$styleArray = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_HAIR,
				),
			),
		);
		$excel->getActiveSheet()->getStyle("A".$rowCount,"A".$rowCount)->applyFromArray($styleArray);
		$excel->getActiveSheet()->getStyle("B".$rowCount,"B".$rowCount)->applyFromArray($styleArray);
		$excel->getActiveSheet()->getStyle("C".$rowCount,"C".$rowCount)->applyFromArray($styleArray);
		$excel->getActiveSheet()->getStyle("D".$rowCount,"D".$rowCount)->applyFromArray($styleArray);
		$excel->getActiveSheet()->getStyle("E".$rowCount,"E".$rowCount)->applyFromArray($styleArray);
		$excel->getActiveSheet()->getStyle("F".$rowCount,"F".$rowCount)->applyFromArray($styleArray);

		$excel->getActiveSheet()->getStyle("G".$rowCount)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
		$excel->getActiveSheet()->getStyle("G".$rowCount)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
		$excel->getActiveSheet()->getStyle("G".$rowCount)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
		
		
	}
	


	save($ExWb,$excel,$newFilename); 
	echo "Report has been generated!  Click Here: <a href='".$newFilename."' style='text-decoration:none;color:red;'>".str_replace("printout/assigned/","",$newFilename)."</a>";
		


?>