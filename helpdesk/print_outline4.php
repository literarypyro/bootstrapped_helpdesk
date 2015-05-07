<?php
session_start();
?>
<script language="javascript">
function openPage(url){
window.open(url,"_self");

}

</script>
<?php
require_once("Classes/PHPExcel.php");
require("excel functions.php");

// require("functions/routing process.php");
// require("functions/general functions.php");
// require("functions/form functions.php");
// require("functions/document functions.php");

require("db_page.php");

if(isset($_SESSION['sql_printout'])){

	$new_sql=$_SESSION['sql_printout'];
	$db=retrieveHelpdeskDb();
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
	<th colspan=6><h2>Client Requests List</h2></th>
	</tr>

	<tr>
		<th>Reference Number</th>
		<th>Request Time</th>

		<th>Unit Type</th>
		<th>Problem Concern</th>
		<th>Dispatch Staff Assigned</th>	
	</tr>	
	<?php
		for($i=0;$i<$nm;$i++){
		$row=$new_rs->fetch_assoc();
		
		
		$sql2="select * from dispatch_staff where id='".$row['dispatch_staff']."'";
		$rs2=$db->query($sql2);
		$row2=$rs2->fetch_assoc();
	
		$sql3="select * from classification where id='".$row['classification_id']."'";
		$rs3=$db->query($sql3);
		$row3=$rs3->fetch_assoc();
	
		$sql4="select * from computer where id='".$row['unit_id']."'";
		$rs4=$db->query($sql4);
		$row4=$rs4->fetch_assoc();


		
		
	
	?>	
	<tr>
		<td><?php echo trim($row['reference_number']); ?></td>
		<td><?php echo date("F d, Y H:ia",strtotime($row['dispatch_time'])); ?></td>
		<td><?php echo $row4['unit']; ?></td>
		<td><?php echo $row3['type']; ?></td>
		<td><?php echo $row2['staffer']; ?></td>

	</tr>
	<?php
		}
	?>
	</table>
	<div align=center><a href='print_outline4.php?print=1'>Generate Print Out</a></div>
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
		$workbookname="Client Requests or Tasks - Generated ";
		$workbookname.=date("Y-m-d H.i.s").".xls";
		$fileName=$workbookname;
		$workbookname=$folder.$workbookname;		

		
		$excel=startCOMGiven();
		
		
		
		$workSheetName="Client Requests or Tasks";		
		//$ExWb=createWorkbook($excel,$workbookname,"create");
		$ExWs=createWorksheet($excel,$workSheetName,"create");
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
		addContent(setRange("A1","B6"),$excel,"","true",$ExWs);
		$i=getRowNumber(7);

		//LEFT SIDE
		styleCellArea(setRange("C3","G3"),"true","false",$ExWs,$excel);
		styleCellArea(setRange("C4","G4"),"true","false",$ExWs,$excel);

		addContent(setRange("C2","G2"),$excel,"Republic of the Philippines","true",$ExWs);
		addContent(setRange("C3","G3"),$excel,"DEPARTMENT OF TRANSPORTATION","true",$ExWs);
		addContent(setRange("C4","G4"),$excel,"AND COMMUNICATION","true",$ExWs);
		addContent(setRange("C5","G5"),$excel,"METRO RAIL TRANSIT III EDSA LINE","true",$ExWs);
		addContent(setRange("C6","G6"),$excel,"(DOTC-MRT3)","true",$ExWs);

		//RIGHT SIDE
		styleCellArea(setRange("H3","J3"),"true","false",$ExWs,$excel);


		$rr[0]="A".$i;
		$rr[1]="J".$i;
	
		setHeadingArea("large",$rr,"true",$excel,$ExWs);
	//addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
		addContent($rr,$excel,"Client Requests List","true",$ExWs);
//		setCellArea($rr,$excel,$ExWs,$excel);

		$new_rs=$db->query($new_sql);
		$nm=$new_rs->num_rows;

		if($nm>0){
	
			$i=getRowNumber($i);

			$rr[0]="A".$i;
			$rr[1]="B".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Reference Number","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);
			
			
			$rr[0]="C".$i;
			$rr[1]="D".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Dispatch Time","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);
			
			$rr[0]="E".$i;
			$rr[1]="F".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Unit Type","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

			$rr[0]="G".$i;
			$rr[1]="H".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Problem Concern","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

			$rr[0]="I".$i;
			$rr[1]="J".$i;
			setHeadingArea("minor",$rr,"true",$excel,$ExWs);
			addContent($rr,$excel,"Dispatch Staff Assigned","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
			styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

			$new_sql=$_SESSION['sql_printout'];
			
			$db=retrieveHelpdeskDb();
			$new_rs=$db->query($new_sql);
			$nm=$new_rs->num_rows;

			for($m=0;$m<$nm;$m++){
	
				$row=$new_rs->fetch_assoc();
				
				
				$sql2="select * from dispatch_staff where id='".$row['dispatch_staff']."'";
				$rs2=$db->query($sql2);
				$row2=$rs2->fetch_assoc();
			
				$sql3="select * from classification where id='".$row['classification_id']."'";
				$rs3=$db->query($sql3);
				$row3=$rs3->fetch_assoc();
			
				$sql4="select * from computer where id='".$row['unit_id']."'";
				$rs4=$db->query($sql4);
				$row4=$rs4->fetch_assoc();

				$i=getRowNumber($i);

				$rr[0]="a".$i;
				$rr[1]="b".$i;
				addContent($rr,$excel,$row['reference_number'],"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);
				
				$rr[0]="c".$i;
				$rr[1]="d".$i;
				addContent($rr,$excel,date("F d, Y H:ia",strtotime($row['dispatch_time'])),"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

				$rr[0]="e".$i;
				$rr[1]="f".$i;
				addContent($rr,$excel,$row4['unit'],"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);
				
				$rr[0]="g".$i;
				$rr[1]="h".$i;
				addContent($rr,$excel,$row3['type'],"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

				$rr[0]="i".$i;
				$rr[1]="j".$i;
				addContent($rr,$excel,$row2['staffer'],"true",$ExWs);
				setCellArea($rr,$excel,$ExWs,$excel);
				styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);
				



			}

		}
		//close the Page
		save($ExWb,$excel,$workbookname);

		copy($workbookname, "printout/report/".$fileName);	
	//	copy("c:/report/a.xls","'printout/report/".$fileName);
		echo "A Print Out has been generated!  Press right click and Save As: <a href='printout/report/".$fileName."'>Here</a>";
	
	}
	

}
?>