    <script type="text/javascript" src="prototype.js"></script>
	<body>
<script type="text/javascript">

var Comet = Class.create();
Comet.prototype = {

  timestamp: 0,
  url: './newMessages1.php',
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
        this.comet.timestamp = timestamp;
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
//	window.location.href='receiveDocument.php';
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
	//alert(\"A\");
  }
  
  
  
}
var comet = new Comet();
comet.connect();
</script>
</body>