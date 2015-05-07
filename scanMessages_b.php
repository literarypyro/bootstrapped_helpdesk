<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="prototype.js"></script>
<style type="text/css">
#alterTable {
background-color: #0066cb;
color: #ffcc35;

}
a:link {
text-decoration: none;
}

#exception a{
text-decoration: none;
color: #ffffff;
}

#cssTable td{
background-color: #0066cb;
color: #ffcc35;
	
}

#cssTable th{
background-color: #0066cb;
color: #ffcc35;
	
}

</style>
<body>
<table id='cssTable' width=100%>
<tr>
<th colspan=6><h2>Tasks needing answer</h2></th>
</tr>
<tr>
<th>Reference Number</th>
<th>Client Name</th>
<th>Office</th>
<th>Unit Type</th>
<th>Problem Concern</th>
<th>Dispatch Time</th>
</tr>
<?php
$db=new mysqli('localhost','root','','helpdesk');
$sql="select * from task order by dispatch_time desc";

$rs=$db->query($sql);
$nm=$rs->num_rows;

$routing_Option="<select name='change_task'>";
for($i=0;$i<$nm;$i++){
	$row=$rs->fetch_assoc();
	
	$sql2="select * from computer where id='".$row['unit_id']."'";
	$rs2=$db->query($sql2);
	$row2=$rs2->fetch_assoc();
	
	$sql3="select * from classification where id='".$row['classification_id']."'";
	$rs3=$db->query($sql3);
	$row3=$rs3->fetch_assoc();
		
?>
<tr>
	<td><font color="white"><b><?php echo $row['reference_number']; ?></b></font></td>
	<td><?php echo $row['client_name']; ?></td>
	<td><?php echo $row['division_id']; ?></td>
	<td><?php echo $row2['unit']; ?></td>
	<td><?php echo $row3['type']; ?></td>
	<td><?php echo date("F d, Y h:ia",strtotime($row['dispatch_time'])); ?></td>
</tr>
<?php
	$routing_Option.="<option value='".$row['id']."'>".$row['reference_number']."</option>";
}
$routing_Option.="</select>";
?>

</table>
<form action='submitAccomplishment.php' method=post>
<?php

	echo "<table>";
	echo "<tr>";
	echo "<th>Submit Accomplishment:</th>";
	echo "<td>";
	echo $routing_Option;
	echo "</td>";
	
	echo "<td><input type=submit value='Process' /></td>";
	

	echo "</tr>";
	echo "</table>";
?>
</form>


<script type="text/javascript">
var Comet = Class.create();
Comet.prototype = {

  timestamp: 0,
  url: './newMessages_b.php',
  noerror: true,

  initialize: function() { },

  connect: function()
  {
    this.ajax = new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'timestamp' : this.timestamp },
      onSuccess: function(transport) {
        // handle the server response
        var response = transport.responseText.evalJSON();
        this.comet.timestamp = response['timestamp'];
        this.comet.handleResponse(response);
        this.comet.noerror = true;
      },
      onComplete: function(transport) {
        // send a new ajax request when this request is finished
        if (!this.comet.noerror)
          // if a connection problem occurs, try to reconnect each 5 seconds
          setTimeout(function(){ comet.connect() }, 5000); 
        else
          this.comet.connect();
        this.comet.noerror = false;
      }
    });
    this.ajax.comet = this;
  },

  disconnect: function()
  {
  },

  handleResponse: function(response)
  {
    alert("You have a new message!");
	window.location.href='scanMessages_b.php';

	
//	$('content').innerHTML += '<div>' + response['msg'] + '</div>';
  },

  doRequest: function(request)
  {
    new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'msg' : request }
    });
  },
  
  refresh: function()
  {
	comet.doRequest($('word').value);return false;
	//alert("A");
  }
  
  
  
}
var comet = new Comet();
comet.connect();
</script>
</body>