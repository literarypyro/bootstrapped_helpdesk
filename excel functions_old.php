<?php
function startCOMObject($full_class_name)
{
	//Name of the Namespace and Class 
	$excelApplication=new COM($full_class_name);
	return $excelApplication;
}

function startCOMGiven()
{
	$full_class_name="ExcelModule.Workbook";
	//Name of the Namespace and Class 
	$excelApplication=new COM($full_class_name);
	return $excelApplication;
}

function createWorkbook($excelAPI,$workBookName,$action)
{
	$workbook=null;
	if($action=="create"){
		$workbook=$excelAPI->createWorkbook($workBookName);	
	}
	else if($action=="open"){
		$workbook=$excelAPI->openWorkbookNoParams($workBookName);	
	}
	else {
	}
	return $workbook;
}


function createWorksheet($excelAPI,$workSheetName,$workBook,$action){
	$worksheet=null;
	if($action=="create"){
		$worksheet=$excelAPI->createWorksheet($workSheetName,$workBook);
	}
	else if($action=="open"){
		$worksheet=$excelAPI->selectExistingWorksheet($workSheetName,$workBook);		
	}

	else if($action=="openActive"){
		$worksheet=$excelAPI->setActiveWorksheet($workBook);		
	}
	
	return $worksheet;

}

function setRange($rangeStart, $rangeEnd)
{
	$range[0]=$rangeStart;
	$range[1]=$rangeEnd;
	return $range;
}

function addContent($range,$excelAPI,$content,$merged,$excelWorksheet)
{
	$excelAPI->setWorkSheetContent($content,$range[0],$range[1],$merged,$excelWorksheet);
}

function addImage($range,$excelAPI,$imageName,$merged,$excelWorksheet){
	$excelAPI->insertImage($imageName,$range[0],$range[1],$merged,$excelWorksheet);
}

function getContent($range,$excelAPI,$excelWorksheet){
	$content=$excelAPI->getWorksheetContent($range[0],$range[1],$excelWorksheet);		
	return $content;	
}

function setCellSize($range,$height,$width,$sheet,$excelAPI){
	$excelAPI->setRangeSize($height,$width,$sheet,$range[0],$range[1]);
}

function setHeadingArea($type,$range,$merged,$excelAPI,$excelWorksheet){
	if($type=="minor"){
		$excelAPI->setMinorHeading($range[0],$range[1],$excelWorksheet,$merged);
	}
	else {
		$excelAPI->setLargeHeading($range[0],$range[1],$excelWorksheet);

	}
}

function setCellArea($range,$excelAPI,$excelWorksheet,$excelAPI){
	$excelAPI->setTableCell($range[0],$range[1],$excelWorksheet);
}


function styleCellArea($range,$outlined,$bold,$excelWorksheet,$excelAPI){
	if($outlined=="true"){
		$excelAPI->boldFaceContent($range[0],$range[1],$excelWorksheet);
	}
	if($bold=="true"){
		$excelAPI->tableContent($range[0],$range[1],$excelWorksheet);
	}
}
function save($workbook,$excelAPI,$workbookName)
{
	if($workbookName==""){
		$excelAPI->saveWorkbook($workbook);
	}
	else {
		$excelAPI->saveWorkbookCopy($workbookName,$workbook);
	}
}

function printCopy($workSheet,$excelAPI){
	$notification="";
	$notification=$excelAPI->printWorksheet($worksheet);
	return $notification;
}


function getRowNumber($i){
	$pageBreak=52;
	if((($i%52)==0)&&($i>0)){
		$i=$i+3;
	}
	else {
		$i=$i+1;
	}
	return $i;

}



?>