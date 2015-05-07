<?php
function retrieveMonthListHTML($monthName){
	?>
	<select id='<?php echo $monthName; ?>' name='<?php echo $monthName; ?>'>
	<option <?php if(date('m')=='1'){ echo "selected"; } ?> value='1'>January</option>
	<option <?php if(date('m')=='2'){ echo "selected"; } ?> value='2'>February</option>
	<option <?php if(date('m')=='3'){ echo "selected"; } ?> value='3'>March</option>
	<option <?php if(date('m')=='4'){ echo "selected"; } ?> value='4'>April</option>
	<option <?php if(date('m')=='5'){ echo "selected"; } ?> value='5'>May</option>
	<option <?php if(date('m')=='6'){ echo "selected"; } ?> value='6'>June</option>
	<option <?php if(date('m')=='7'){ echo "selected"; } ?> value='7'>July</option>
	<option <?php if(date('m')=='8'){ echo "selected"; } ?> value='8'>August</option>
	<option <?php if(date('m')=='9'){ echo "selected"; } ?> value='9'>September</option>
	<option <?php if(date('m')=='10'){ echo "selected"; } ?> value='10'>October</option>
	<option <?php if(date('m')=='11'){ echo "selected"; } ?> value='11'>November</option>
	<option <?php if(date('m')=='12'){ echo "selected"; } ?> value='12'>December</option>
	</select>
	<?php
}

function retrieveDayListHTML($dayName){
	?>
	<select id='<?php echo $dayName; ?>' name='<?php echo $dayName; ?>'>
	<?php

	for($i=1;$i<32;$i++){
			
	?>
		<option <?php if(date("d")==$i){ echo "selected"; }	?> value='<?php echo $i; ?>'><?php echo $i; ?></option>

	<?php
	}
	?>
		</select>
	<?php
	
	
}

function retrieveYearListHTML($yearName){
	?>
	<select id='<?php echo $yearName; ?>' name='<?php echo $yearName; ?>'>
	<?php
	
	$yearNow=date("Y");
	$yearSet=$yearNow*1-10;
	$yearEnd=$yearNow*1+10;	
	
	for($i=$yearSet;$i<$yearEnd;$i++){
	?>
		<option <?php if((date("Y"))==$i){ echo "selected"; } ?>><?php echo $i; ?></option>
	<?php
	
	}
	?>
		</select>
	<?php	
}

function retrieveHourListHTML($hourName){
	?>
	<select id='<?php echo $hourName; ?>' name='<?php echo $hourName; ?>' >
	<?php
		for($i=1;$i<=12;$i++){
	?>
	<option <?php if(date("g")==$i){ echo "selected"; } ?>><?php echo $i; ?></option>
	<?php
	}
?>
	</select>
	<?php
}

function retrieveMinuteListHTML($minuteName){
	?>
	<select id='<?php echo $minuteName; ?>' name='<?php echo $minuteName; ?>'>
	<?php
	for($i=0;$i<60;$i++){
	?>
		<option <?php if(date("i")*1==$i){ echo "selected"; } ?>><?php echo $i; ?></option>
	<?php
	}
	?>
	</select>
	<?php
}

function retrieveShiftListHTML($shiftName){
	?>
	<select id='<?php echo $shiftName; ?>' name='<?php echo $shiftName; ?>' >
	<option <?php if(date("A")=='AM'){ echo "selected"; } ?>>AM</option>
	<option <?php if(date("A")=='PM'){ echo "selected"; } ?>>PM</option>
	</select>	
	<?php

}

function retrieveClassListHTML($db,$className,$alternClass){
	?>
	<select id='<?php echo $className; ?>' name='<?php echo $className; ?>' onchange='checkAlternate(this,5,"<?php echo $alternClass; ?>")'>
	<?php
	$sql="select * from classification";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>
		<option value='<?php echo $row['id']; ?>'><?php echo $row['classification_desc']; ?></option>

	<?php
	}
	?>
	</select>
	<input type=text id='<?php echo $alternClass; ?>' name='<?php echo $alternClass; ?>' disabled=true size=33 />
	<?php
	}

function retrieveOfficeListHTML($db,$selected,$officeName,$alternate){
	?>
	<select id='<?php echo $officeName; ?>' name='<?php echo $officeName; ?>' onchange='checkAlternate(this,13,"<?php echo $alternate; ?>")'>
	<?php
	$sql="select * from originating_office";
	$result=$db->query($sql);
	$number_of_results=$result->num_rows;

	for($i=0;$i<$number_of_results;$i++){
	$row=$result->fetch_assoc();
		if($row['department_name']==""){
		}
		else {
	
	?>
	<option 
		<?php if($selected==$row['department_code']){ ?> 
		selected 
		<?php } ?>
		value='<?php echo $row['department_code']; ?>'>
		<?php echo $row['department_name']; ?>
	</option>
	<?php
		}
	}
	?>
	</select>
	<input type=text id='<?php echo $alternate; ?>'  name='<?php echo $alternate; ?>' disabled=true />
	<?php
}	
	
	
function retrieveDepartmentListHTML($db,$selected,$officeName){
	?>
	<select id='<?php echo $officeName; ?>' name='<?php echo $officeName; ?>'>
	<?php
	$sql="select * from department";
	$result=$db->query($sql);
	$number_of_results=$result->num_rows;

	for($i=0;$i<$number_of_results;$i++){
	$row=$result->fetch_assoc();
		if($row['department_name']==""){
		}
		else {
	
	?>
	<option 
		<?php if($selected==$row['department_code']){ ?> 
		selected 
		<?php } ?>
		value='<?php echo $row['department_code']; ?>'>
		<?php echo $row['department_name']; ?>
	</option>
	<?php
		}
	}
	?>
	</select>
	<?php
}		
	
function retrieveOfficerList($db){
	$sql="select * from originating_officer";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	
	$select="<select name='officer'>";
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		$select.="<option value='".$row['id']."'>".$row['name']."</option>";
	}
	$select.="</select>";
	
	return $select;
}

function retrieveOfficerListHTML($db,$officer_name){
	$sql="select * from originating_officer";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	?>
	<select id='<?php echo $officer_name; ?>' name='<?php echo $officer_name; ?>'>
	<?php
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		?>
		<option value='<?php echo $row['id']; ?>'><?php echo $row['name']; ?></option>
		<?php
	}
	?>	
	</select>
	<?php
}

function dateLimit($month,$year){
	if(($month=="4")||($month=="6")||($month=="9")||($month=="11"))
	{
		$datelimit="30";
	}

	else if($month=="2")
	{
	   if((($year/4) == round($year/4))&&(($year/100) == round($year/100))){
		$datelimit="29";
	   }
	   else {
		$datelimit="28";	
	   }		
	}

	else {
	   $datelimit="31";
	}
	return $datelimit;
}

function adjustTime($shift,$hour){
	$newHour=0;
	if($shift=='PM'){
		if($hour<12){
			$newHour=$hour*1+12;
		}
		else {
			$newHour=12;
		}
	}
	else if($shift=="AM"){
		if($hour<12){
			$newHour=$hour;
		}
		else {
			$newHour=0;
		}
	}
	return $newHour;
}
?>