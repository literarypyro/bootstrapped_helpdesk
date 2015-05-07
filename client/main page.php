<?php
session_start();
?>
<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<?php
require("form functions.php");
require("db_page.php");
?>
<?php
$_SESSION['helpdesk_page']="main page.php";

?>

<?php
if((isset($_POST['location']))&&(isset($_POST['task_id']))){
	$loginHour=adjustTime($_POST['loginamorpm'],$_POST['loginHour']);
	$loginDay=$_POST['loginYear']."-".$_POST['loginMonth']."-".$_POST['loginDay'];
	$login_date=$loginDay." ".$loginHour.":".$loginMinute.":00";
	
	$db=retrieveHelpdeskDb();
	$sql="insert into dispatch_track(dispatch_staffer,login_time,location,task_id) values ('".$_POST['user_name']."','".$login_date."',\"".$_POST['location']."\",'".$_POST['task_id']."')";
	$rs=$db->query($sql);

	echo "Dispatch staffer has updated his status.<br>";	
	

}

?>
<style type="text/css">
#cssTable {
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

#alterTable td{
background-color: #0066cb;
color: #ffcc35;
	
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
<title>Update Helpdesk Staff Status</title>
	<body style="background-image:url('body background.jpg');">

	<div align=center><img src="helpdesk Header.jpg" style="width:80%; height:200;" /></div>
<div align="right" width=100%><a style='color:red' href="logout.php">Log Out</a></div>


<table height=100% width="100%"  bgcolor="#FFFFFF" cellpadding="5px" bordercolor="#CCCCCC" style="border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px">


<tr>
	<?php 
	require("client_sidebar.php");
	//background-color:#66ceae; 
	?>
	<td style="background-image:url('body background1.jpg')" width="85%" rowspan=2 valign="top"  style="background-color:#66ceae; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black;" bordercolor="#FF6600">
	<font size="5" face="Verdana" color="#172caf">
		<div style='background-color:gold;'>
		<b>
		Welcome To Helpdesk Center!</b>
		</div>
	</font>
	<font size="3" face="Verdana" color="#bd2031">
		<p align="justify" style='vertical-align:top; '>
			The Online Helpdesk Center is designed to make your issuing requests and computer troubleshooting a whole lot easier.  Please, feel free to navigate through the tabs to the left.
			


		</p> 	
	</font>
	<font size="3" face="Verdana" color="#bd2031">
		<p align="justify" style='vertical-align:top; '>
			* The Helpdesk Center is on a first-come, first serve basis.<br>
			* To begin, simply click on your tab to the left, and fill the form on the next page.<br>
			* Be sure to click the Submit button when you're done.<br>
			* You can monitor the progress of your request on one of the tabs to the left<br>


		</p> 	
	</font>
	
	
	</td>
</tr>
</table>
</body>