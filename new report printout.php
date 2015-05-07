<?php
session_start();
?>
<?php
// require("functions/excel functions.php");
// require("functions/routing process.php");
// require("functions/general functions.php");
// require("functions/form functions.php");
// require("functions/document functions.php");
// require("db_page.php");
?>
<?php
if($_SESSION['page']=="end of the month report.php"){
	$excel=startCOMGiven();
	
	$workSheetName="Monthly Summary";
	
	$workbookname=$_SESSION['file'];

	$ExWb=createWorkbook($excel,$workbookname,"create");
	$ExWs=createWorksheet($excel,$workSheetName,$ExWb,"create");

	$i=0;
	
	
	//Create the Header
//	addImage(setRange("a1","b6"),$excel,"c:/report/records picture2.jpg","true",$ExWs);

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

addContent(setRange("h3","j3"),$excel,"ROUTING/ACTION SLIP","true",$ExWs);
addContent(setRange("h4","j4"),$excel,"(Please Attach this form","true",$ExWs);
addContent(setRange("h5","j5"),$excel,"To All Communications)","true",$ExWs);

	$rr[0]="a".$i;
	$rr[1]="j".$i;
	
	setHeadingArea("large",$rr,"true",$excel,$ExWs);
	//addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
	addContent($rr,$excel,"End of the Month Report","true",$ExWs);
	setCellArea($rr,$excel,$ExWs,$excel);

	$db=retrieveRecordsDb();

	//prepare the queries
	if($_SESSION['filterDocument']=='SENT'){
		$sentNM=1;
		$unsentNM=0;
		$ordersNM=0;
	}
	else if($_SESSION['filterDocument']=='AWAIT'){
		$sentNM=0;
		$unsentNM=1;
		$ordersNM=0;
	}
	else if($_SESSION['filterDocument']=='ORDER'){
		$sentNM=0;
		$unsentNM=0;
		$ordersNM=1;
	}
	else {
		$sentNM=1;
		$unsentNM=1;
		$ordersNM=1;
	}
	
	if(isset($_SESSION['filterMonth'])){ 
		$filterMonth=$_SESSION['filterMonth'];
		$filterYear=$_SESSION['filterYear'];
		$setM=$_SESSION['filterMonth'];
		$setY=$_SESSION['filterYear'];

		$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".$_SESSION['filterMonth']."%%'";
	
	}

	$sentClause=" (status in ('SENT','FORWARDED') or status like '%CLOSED%%') ";
	if(isset($_SESSION['sentClause'])){ $sentClause=$_SESSION['sentClause']; }
	if(isset($_SESSION['sentMonth'])){
		$setM=date("F",strtotime($_SESSION['sentYear']."-".$_SESSION['sentMonth']));
		$setY=date("Y",strtotime($_SESSION['sentYear']));
		$dateClause="  and receive_date like '%".$_SESSION['sentYear']."-".$_SESSION['sentMonth']."%%'";
	}
	
	else {
		if(isset($_SESSION['filterMonth'])){
			$filterMonth=$_SESSION['filterMonth'];
			$filterYear=$_SESSION['filterYear'];
			$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
			$setM=date("F",$filterYear."-".$filterMonth);
			$setY=date("Y",strtotime($filterYear));
		}
		else {
			$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
			$setM=date("F");
			$setY=date("Y");
		}
	}

	
		
		
	//Documents Sent	
	$sql="select * from document where ".$sentClause." ".$dateClause." order by receive_date desc";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	if($sentNM==0){
		$nm=$sentNM;
	}

	if($nm>0){
 		$i=getRowNumber($i);
		$i=getRowNumber($i);

		$rr[0]="a".$i;
		$rr[1]="j".$i;
		
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		//addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
		addContent($rr,$excel,"Documents Sent, ".date("F",strtotime($setM))." ".date("Y",strtotime($setY)),"true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$i=getRowNumber($i);

		$rr[0]="a".$i;
		$rr[1]="b".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Originating Office","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="c".$i;
		$rr[1]="d".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Subject","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="e".$i;
		$rr[1]="f".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Reference Number","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="g".$i;
		$rr[1]="g".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Type","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="h".$i;
		$rr[1]="i".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Date","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="j".$i;
		$rr[1]="j".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Status","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		for($m=0;$m<$nm;$m++){
		$row=$rs->fetch_assoc();
		$i=getRowNumber($i);

			$rr[0]="a".$i;
			$rr[1]="b".$i;
			addContent($rr,$excel,getOriginatingOffice($db, $row['originating_office']),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="c".$i;
			$rr[1]="d".$i;
			addContent($rr,$excel,$row['subject'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="e".$i;
			$rr[1]="f".$i;
			addContent($rr,$excel,calculateReferenceNumber($db,$row,adjustControlNumber($row['ref_id'])),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="g".$i;
			$rr[1]="g".$i;
			addContent($rr,$excel,$row['document_type'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="h".$i;
			$rr[1]="i".$i;
			addContent($rr,$excel,date("Y-m-d", strtotime($row['document_date'])),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="j".$i;
			$rr[1]="j".$i;
			addContent($rr,$excel,$row['status'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

		}
	
	}
	
	//Documents Awaiting Reply
	$awaitClause=" status in ('INCOMPLETE','FOR: ROUTING','AWAITING REPLY','FOR: CLARIFICATION','FOR: GM APPROVAL') ";
	if(isset($_SESSION['awaitClause'])){ $awaitClause=$_SESSION['awaitClause']; }

	if(isset($_SESSION['awaitMonth'])){
		$setM=date("F",strtotime($_SESSION['awaitYear']."-".$_SESSION['awaitMonth']));
		$setY=date("Y",strtotime($_SESSION['awaitYear']));
		$dateClause="  and receive_date like '%".$_SESSION['awaitYear']."-".$_SESSION['awaitMonth']."%%'";
	}
	else {
		if(isset($_SESSION['filterMonth'])){
			$filterMonth=$_SESSION['filterMonth'];
			$filterYear=$_SESSION['filterYear'];
			$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
			$setM=date("F",$filterYear."-".$filterMonth);
			$setY=date("Y",strtotime($filterYear));
		}
		else {
			$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
			$setM=date("F");
			$setY=date("Y");
		}
	}

	$sql="select * from document where ".$awaitClause."  ".$dateClause." order by receive_date desc";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	if($unsentNM==0){
		$nm=$unsentNM;
	}
	if($nm>0){
		$i=getRowNumber($i);
		$i=getRowNumber($i);
		$rr[0]="a".$i;
		$rr[1]="j".$i;
		
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		//addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
		addContent($rr,$excel,"Documents Awaiting Reply/Unsent, ".date("F",strtotime($setY."-".$setM))." ".date("Y",strtotime($setY."-".$setM)),"true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);
		$i=getRowNumber($i);

		$rr[0]="a".$i;
		$rr[1]="b".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Originating Office","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="c".$i;
		$rr[1]="d".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Subject","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="e".$i;
		$rr[1]="f".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Reference Number","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="g".$i;
		$rr[1]="g".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Type","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="h".$i;
		$rr[1]="i".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Date","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="j".$i;
		$rr[1]="j".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Status","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		for($m=0;$m<$nm;$m++){
		$row=$rs->fetch_assoc();
		$i=getRowNumber($i);

			$rr[0]="a".$i;
			$rr[1]="b".$i;
			addContent($rr,$excel,getOriginatingOffice($db, $row['originating_office']),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="c".$i;
			$rr[1]="d".$i;
			addContent($rr,$excel,$row['subject'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="e".$i;
			$rr[1]="f".$i;
			addContent($rr,$excel,calculateReferenceNumber($db,$row,adjustControlNumber($row['ref_id'])),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="g".$i;
			$rr[1]="g".$i;
			addContent($rr,$excel,$row['document_type'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="h".$i;
			$rr[1]="i".$i;
			addContent($rr,$excel,date("Y-m-d", strtotime($row['document_date'])),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="j".$i;
			$rr[1]="j".$i;
			addContent($rr,$excel,$row['status'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

		}
		
	}
	
	$orderClause=" and status in ('ISSUED AND SENT','ISSUED') ";
	if(isset($_SESSION['orderClause'])){ $orderClause=$_SESSION['orderClause']; }
	if(isset($_SESSION['orderMonth'])){
		$dateClause="  and receive_date like '%".$_SESSION['orderYear']."-".$_SESSION['orderMonth']."%%'";
		$setM=date("F",strtotime($_SESSION['orderYear']."-".$_SESSION['orderMonth']));
		$setY=date("Y",strtotime($_SESSION['orderYear']));
	
	
	}
	else {
		if(isset($_SESSION['filterMonth'])){
			$filterMonth=$_SESSION['filterMonth'];
			$filterYear=$_SESSION['filterYear'];
			$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
			$setM=date("F",$filterYear."-".$filterMonth);
			$setY=date("Y",strtotime($filterYear));
		}
		else {
			$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
			$setM=date("F");
			$setY=date("Y");
		}
	}
	
	$sql="select * from document where document_type='ORD' ".$orderClause." ".$dateClause;
	$rs=$db->query($sql);
	
	$nm=$rs->num_rows;
	if($ordersNM==0){
		$nm=$ordersNM;
	}

	if($nm>0){
		$i=getRowNumber($i);
		$i=getRowNumber($i);
		$rr[0]="a".$i;
		$rr[1]="j".$i;
		
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		//addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
		addContent($rr,$excel,"Office Orders, ".date("F",strtotime($setY."-".$setM))." ".date("Y",strtotime($setY."-".$setM)),"true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$i=getRowNumber($i);

		$rr[0]="a".$i;
		$rr[1]="b".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Subject","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="c".$i;
		$rr[1]="d".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Classification","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="e".$i;
		$rr[1]="f".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Date","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="g".$i;
		$rr[1]="h".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Originating Office","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		$rr[0]="i".$i;
		$rr[1]="j".$i;
		setHeadingArea("minor",$rr,"true",$excel,$ExWs);
		addContent($rr,$excel,"Status","true",$ExWs);
		setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"true","true",$ExWs,$excel);

		for($m=0;$m<$nm;$m++){
			$row=$rs->fetch_assoc();
			$i=getRowNumber($i);	
			$rr[0]="a".$i;
			$rr[1]="b".$i;
			addContent($rr,$excel,$row['subject'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="c".$i;
			$rr[1]="d".$i;
			addContent($rr,$excel,"Office Order","true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="e".$i;
			$rr[1]="f".$i;
			addContent($rr,$excel,date("Y-m-d h:ia",strtotime($row['document_date'])),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="g".$i;
			$rr[1]="h".$i;
			addContent($rr,$excel,getOriginatingOffice($db,$row['originating_office']),"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);

			$rr[0]="i".$i;
			$rr[1]="j".$i;
			addContent($rr,$excel,$row['status'],"true",$ExWs);
			setCellArea($rr,$excel,$ExWs,$excel);
		styleCellArea(setRange($rr[0],$rr[1]),"false","true",$ExWs,$excel);
		
		}
	}
	
	//close the Page
	save($ExWb,$excel,"");


}

?>