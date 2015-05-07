<?php
session_start();
?>
<?php
//$pc_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);

$urlAdd="";
if(isset($_GET['bP'])){
	$pc_name="chix";
	$urlAdd="?bP=".$_GET['bP'];
	
}

if($pc_name=="chix"){
	require("helpdesk/db_page.php");
	if(isset($_POST['username'])){
//		$db=localOnlyDb();
		$db=new mysqli("localhost","root","","helpdesk_system");
		$sql="select * from login where username='".trim($_POST['username'])."' and password='".trim($_POST['password'])."'";

		$rs=$db->query($sql);
		$nm=$rs->num_rows;
		if($nm>0){
			$row=$rs->fetch_assoc();
			$usertype=$row['type'];
			$loginSQL="insert into log_history(username, time, action) values ('".$_POST['username']."','".date("Y-m-d H:i:s")."','login')";
			$loginrs=$db->query($loginSQL);
			$loginnm=$loginrs->num_rows;
			$_SESSION['username']=$_POST['username'];
			
			if($row['type']=="Administrator"){
				header("Location: admin/taskmonitor.php");
			}
			else {
				header("Location: helpdesk/taskmonitor.php");
			}
		}
		else {
			header("Location: index.php".$urlAdd);	
		
		}
	
	
	}
	else {
?>
<style type="text/css">
#cssTable {
background-color: #062e56;
color: white;


}
a:link {
text-decoration: none;
}

#exception a{
text-decoration: none;
color: #ffffff;
}

#alterTable td{
background-color: #062e56;
color: white;
	
}
table {
	font: bold 14px "Trebuchet MS", Arial, sans-serif;
}	


#alterTable th{
background-color: #0066cb;
color: #ffcc35;
	}
	
	#menuh
	{
	padding-left: 0;
	width: 100%; 
	font-size: small;
		font: bold 14px "Trebuchet MS", Arial, sans-serif;

	//	font: Times New Roman;
	//width:50%;
//BACKGROUND-COLOR: #4b5ed7;

//background-color: #172caf;
	float:left;
//	margin:
	//margin-top: 1em;
	
	}

	#menuh a
	{
	//This is the formatting of the links
	text-align: center;
	display:block;
	border: 1px solid #555;
	white-space:nowrap;
	margin:0;
	padding: 0.3em;
	}
	#menuh a:link, #menuh a:visited, #menuh a:active	/* menu at rest */
	{
	color: #bd2031;
	background-color: #00cc66;
//	background-color: royalblue;
	text-decoration:none;
	}
	

	#menuh a:hover	/* menu on mouse-over  */
	{
	color: black;
		background-color: #ed5214;
/**The color of the links */

	text-decoration:none;
	}	
	#menuh a.active {
	color: black;
		background-color: #ed5214;
	}
	
	#menuh a.top_parent, #menuh a.top_parent:hover  /* attaches down-arrow to all top-parents */
	{
	//background-image: url(http://62.0.5.133/sperling.com/examples/menuh/navdown_white.gif);
	background-position: right center;
	background-repeat: no-repeat;
	}
	#menuh a.parent, #menuh a.parent:hover 	/* attaches side-arrow to all parents */
	{
//	background-image: url(http://62.0.5.133/sperling.com/examples/menuh/nav_white.gif);
	background-position: right center;
	background-repeat: no-repeat;
	}
	#menuh ul
	{
	/**This places the overall menu to the straight line*/
	
	list-style:none;
	margin:0;
	padding:0;
	float:bottom;
//	width:9em;	/* width of all menu boxes */
	/* NOTE: For adjustable menu boxes you can comment out the above width rule.
	However, you will have to add padding in the "#menh a" rule so that the menu boxes
	will have space on either side of the text -- try it */
	}	
	
		#menuh ul ul
	{
	/**This places the submenu to minimize before hover*/
	
	position:absolute;
	z-index:500;
	top:0;
	left:100%;
	display:none;
	padding: 1em;
	margin:-1em 0 0 -1em;
	}
		#menuh ul ul ul
	{
	top:0;
	left:100%;
	}
	
	
	
		#menuh li
	{
	position:relative;
	min-height: 1px;		/* Sophie Dennis contribution for IE7 */
	vertical-align: bottom;		/* Sophie Dennis contribution for IE7 */
	}
	

	div#menuh li:hover
	{
	cursor:pointer;
	z-index:100;
	}

	div#menuh li:hover ul ul,
	div#menuh li li:hover ul ul,
	div#menuh li li li:hover ul ul,
	div#menuh  li li li li:hover ul ul
	{display:none;}

	div#menuh  li:hover ul,
	div#menuh  li li:hover ul,
	div#menuh  li li li:hover ul,
	div#menuh  li li li li:hover ul
	{display:block;}


</style>
<body>

	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="css/style.min.css" rel="stylesheet" />
	<link href="css/style-responsive.min.css" rel="stylesheet" />
	<link href="css/retina.css" rel="stylesheet" />

<form enctype="multipart/form-data" action='index.php<?php echo $urlAdd; ?>' method='post'>


		<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="login-box">
					<h2>Login to your account</h2>
					<form class="form-horizontal" action="index.php" method="post" />
						<fieldset>
							<select name='username' class='span12'>
							<option>&nbsp;</option>
							<?php
							$db=new mysqli("localhost","root","","helpdesk_system");
							$sql="select * from login inner join dispatch_staff on login.username=dispatch_staff.id";
							$rs=$db->query($sql);
							$nm=$rs->num_rows;
							for($i=0;$i<$nm;$i++){
								$row=$rs->fetch_assoc();
							?>
								<option value='<?php echo $row['username']; ?>'><?php echo $row['staffer']; ?></option>
							<?php
							
							}
							
							?>
							</select>							
<!--
							<input class="input-large span12" name="username" id="username" type="text" placeholder="type username" />
-->
							<input class="input-large span12" name="password" id="password" type="password" style='color:black;'  />

							<div class="clearfix"></div>
							
							<button type="submit" class="btn btn-primary span12">Login</button>
						</fieldset>	
	
					</form>
					<hr />
					<h3>A Client?</h3>
					<p>
						No problem, <a href="client/index.php">click here</a> to go to Client Page.
					</p>
				</div>
			</div><!--/row-->
			
				</div><!--/fluid-row-->
				
	</div><!--/.fluid-container-->






</body>
<?php			
	}	
}
else {
header("Location: client/index.php");


}

?>
