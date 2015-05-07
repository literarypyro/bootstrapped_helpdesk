<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Comet demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="prototype.js"></script>
  <?php
	$db=new mysqli("localhost","root","","test_push");
	$sql="select * from table1 order by modify_time desc";
	$rs=$db->query($sql);
	$row=$rs->fetch_assoc();

	$currentmodif = strtotime($row['modify_time']);
  
  ?>  
	</head>

  <body onload="comet.connect('<?php echo $currentmodif; ?>')">

<div id="content">
</div>

<p>
<!--	
  <form action="" method="get" onsubmit="comet.doRequest($('word').value);$('word').value='';return false;">
	-->
  <form action="" method="get" onsubmit="">

	<input type="text" name="word" id="word" value="s" />
    <input type="submit" name="submit" value="Send" />
  </form>
</p>

<script type="text/javascript">
var Comet = Class.create();
Comet.prototype = {

//  timestamp: 0,
  url: './test_push.php',
  noerror: true,

  initialize: function() { },

  connect: function(timestamp)
  {
	
    this.ajax = new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'timestamp' : timestamp },
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
//	if(this.comet.timestamp==response['timestamp']){
		$('content').innerHTML += '<div>' + response['msg'] + '</div>';
//	}
//	comet.refresh();
	comet.doRequest(response['timestamp']);
  },

  doRequest: function(request)
  {
    new Ajax.Request(this.url+"?timestamp="+request, {
      //method: 'get',
      //parameters: { 'timestamp' : request }
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
</html>