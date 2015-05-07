<?php
session_start();
?>
<script language="javascript">
function openPage(url){
window.open(url,"_self");

}

</script>
<?php
require_once("Classes/PHPExcel/IOFactory.php");
require("excel functions.php");
// require("functions/routing process.php");
// require("functions/general functions.php");
// require("functions/form functions.php");
// require("functions/document functions.php");

require("db_page.php");

if(isset($_SESSION['sql_printout'])){

	$new_sql=$_SESSION['sql_printout'];
	// $db=new mysqli("localhost","root","","helpdesk_backup");
	$db=retrieveHelpdeskDb();
//	$db=localOnlyDb();
	$new_rs=$db->query($new_sql);
	$nm=$new_rs->num_rows;
	$routingHeading="
	<table width=100%>
	<tr >
	<td valign=center align=center rowspan=4>
	<img align=center valign=top src='dotc.jpg' height=80 width=80  ></img>
	</td>
	<td colspan=2 valign=top>
	Republic of the Philippines
	</td>
	</tr>
	<tr>
	<td colspan=2><b>DEPARTMENT OF TRANSPORTATION AND COMMUNICATIONS</b></td>
	<td valign=top align=center>&nbsp;</td>
	</tr>
	<tr>
	<td >
	METRO RAIL TRANSIT III EDSA LINE (DOTC-MRT3)
	</td>
	<td >
	&nbsp;</td>
	</tr>
	</table>";
	echo $routingHeading;
?>
<br>
	<table border=1 id='cssTable' width=100% >
	<tr>
	<th colspan=4><h2>Dispatcher Update List</h2></th>
	</tr>

	<tr>
	<tr>
		<th>Dispatch Staff</th>
		<th>Login Time</th>

		<th>Location</th>
		<th>Client Request Id</th>
<!--
		<th>Status of Request</th>	
-->
	</tr>	
	</tr>	
	<?php
		for($i=0;$i<$nm;$i++){
		$row=$new_rs->fetch_assoc();
		
		
		$sql2="select * from dispatch_staff where id='".$row['dispatch_staffer']."'";
		$rs2=$db->query($sql2);
		$row2=$rs2->fetch_assoc();
	
		$sql3="select * from task where id='".$row['task_id']."'";
		$rs3=$db->query($sql3);
		$row3=$rs3->fetch_assoc();


		
		
	
	?>	
	<tr>
		<td><?php echo trim($row2['staffer']); ?></td>
		<td><?php echo date("F d, Y h:ia",strtotime($row['login_time'])); ?></td>
		<td><?php echo $row['location']; ?></td>
		<td><?php echo $row3['reference_number']; ?></td>

	</tr>
	<?php
		}
	?>
	</table>
	<div align=center><a href='print_outline2.php?print=1'>Generate Print Out</a></div>
	<?php
	if(isset($_GET['print'])){

		if(is_dir("c:/report/")){
		}
		else {
			mkdir("c:/report/");
		}

		if(is_dir("printout/report/")){
		}
		else {
			mkdir("printout/report/");
		}
		
		
		$folder="c:/report/";
		$workbookname="Dispatcher Update List - Generated ";
		$workbookname.=date("Y-m-d H.i.s").".xls";
		$fileName=$workbookname;
		$workbookname=$folder.$workbookname;		
		$excel=startCOMGiven();
		$workSheetName="Client Requests or Tasks";		

//		$excelClass=createExcelApplication($excel);
//		$ExWb=createWorkbook($excel,$workbookname,"create",$excelClass);
	//	$ExWb=createWorkbook($excel,$workbookname,"create");
		$ExWs=createWorksheet($excel,$workSheetName,$ExWb,"create");
		/**
		$verify=$excel->fileExists($workbookname);
		if($verify=="true"){
			$excel->deleteFile($workbookname);
		}
		*/
		// if(file_exists("c:/report/dotc.jpg")){
		// }
		// else {
			// copy("dotc.jpg","c:/report/dotc.jpg");
		
		// }



	
		
		

		

	


		addImage(setRange("a1","b6"),$excel,"c:/report/records picture2.jpg","true",$ExWs);
	
		$i=0;
	
	
		//Create the Header
		addContent(setRange("a1","b6"),$excel,"","true",$ExWs);
		$i=getRowNumber(7);

		//LEFT SIDE
		styleCellArea(setRange("c3","g3"),"true","false",$ExWs,$excel);
		styleCellArea(setRange("c4","g4"),"true","false",$ExWs,$excel);

		addContent(setRange("c2","g2"),$excel,"Republic of the Philippines","true",$ExWs);
		addContent(setRange("c3","g3"),$excel,"DEPARTMENT OF TRANSPORTATION","true",$ExWs);
		addContent(setRange("c4","g4"),$excel,"AND COMMUNICATION","true",$ExWs);
		addContent(setRange("c5","g5"),$excel,"METRO RAIL TRANSIT III EDSA LINE","true",$ExWs);
		addContent(setRange("c6","g6"),$excel,"(DOTC-MRT3)","true",$ExWs);

		//RIGHT SIDE
		styleCellArea(setRange("h3","j3"),"true","false",$ExWs,$excel);

		//addContent(setRange("h3","j3"),$excel,"ROUTING/ACTION SLIP","true",$ExWs);
		//addContent(setRange("h4","j4"),$excel,"(Please Attach this form","true",$ExWs);
		//addContent(setRange("h5","j5"),$excel,"To All Communications)","true",$ExWs);

		$rr[0]="A".$i;
		$rr[1]="J".$i;
	
		setHeadingArea("large",$rr,"true",$excel,$ExWs);
	//addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
		addContent($rr,$excel,"Dispatcher Update List","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);

		$new_rs=$db->query($new_sql);
		$nm=$new_rs->num_rows;

		if($nm>0){
	
			$i=getRowNumber($i);
		
			$rr[0]="A".$i;
			$rr[1]="C".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Dispatch Staff","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);
			
			
			$rr[0]="D".$i;
			$rr[1]="E".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Login Time","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);
			
			$rr[0]="F".$i;
			$rr[1]="H".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Location","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);


			$rr[0]="I".$i;
			$rr[1]="J".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Client Request Id","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);
			

			
			
			
			$new_sql=$_SESSION['sql_printout'];
			$db=retrieveHelpdeskDb();
			$new_rs=$db->query($new_sql);
			$nm=$new_rs->num_rows;
			
			for($m=0;$m<$nm;$m++){
	
				$row=$new_rs->fetch_assoc();
				
				$sql2="select * from dispatch_staff where id='".$row['dispatch_staffer']."'";
				$rs2=$db->query($sql2);
				$row2=$rs2->fetch_assoc();
			
				$sql3="select * from task where id='".$row['task_id']."'";
				$rs3=$db->query($sql3);
				$row3=$rs3->fetch_assoc();


				$i=getRowNumber($i);
				

				$rr[0]="a".$i;
				$rr[1]="c".$i;
				addContent($rr,$excel,trim($row2['staffer']),"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);
				
				$rr[0]="d".$i;
				$rr[1]="e".$i;
				addContent($rr,$excel,date("F d, Y h:ia",strtotime($row['login_time'])),"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

				$rr[0]="f".$i;
				$rr[1]="h".$i;
				addContent($rr,$excel,$row['location'],"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);
				
				$rr[0]="i".$i;
				$rr[1]="j".$i;
				addContent($rr,$excel,$row3['reference_number'],"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);


			}

		}
		//close the Page
		// try{
		 save($ExWb,$excel,$workbookname);
		// }
		// catch(Error $ex){
			// echo $ex->getMessage();
		// }
		
//		save($ExWb,$excel,"C:/sample.xls");
		copy($workbookname, "printout/report/".$fileName);	
	//	copy("c:/report/a.xls","'printout/report/".$fileName);
		echo "A Print Out has been generated!  Press right click and Save As: <a href='printout/report/".$fileName."'>Here</a>";
	
	}
	

}
?>