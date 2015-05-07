$(function(){

	$('#prob_type').change(function(){
//		alert("A");
	//	$('#property_no').html("<option></option>");

	
		$.getJSON('inventory_list.php?type='+$('#prob_type').val(),function(data){

		
			var propertyHTML="<option></option>";
		//	for(int i=0;i<data.count;i++){
			$.each(data.property_no, function (i, app) {
				propertyHTML+="<option value='"+app+"'>"+app+"</option>";
			});		
			//	propertyHTML+="<option value='"+data.property_no[i]+"'>"+data.property_no[i]+"</option>";
		//	}
//			propertyHTML+="<option>"+data.property+"</option>";
			$('#property_no').html(propertyHTML);

		});
		

	});
	
	$('#property_no').searchable();


});