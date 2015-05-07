<?php
//background-color:#66ceae;
?>
<td width="15%" height="100%" align=center valign="top"  style="background-color:#66ceae;border-left-style: solid; border-left-width: 1px; border-left-color:black; border-right-style: none; border-right-width: 1px; border-top-style: none; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black; border-color:#FF600;" bordercolor="#FF6600">
<table width=100% >
<tr>
<td>

<div id="menuh" align=left>
<ul id=""><li><a id="ASSIGN_REQUEST" <?php if($_SESSION['helpdesk_page']=="taskmonitor.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="taskmonitor.php">Assigned Client Requests</a></li><li><a id="UPDATE" <?php if($_SESSION['helpdesk_page']=="dispatchTrack.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="dispatchTrack.php">Update Staff Location</a></li><li><a id="ACCOMPLISH" <?php if($_SESSION['helpdesk_page']=="submitAccomplishment.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="submitAccomplishment.php">Submit an Accomplishment</a></li><li><a id="FOR_PRINTOUT" <?php if($_SESSION['helpdesk_page']=="task_printout.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="task_printout.php">Prepare Request Printout</a></li><li><a id="CLIENT_REPORT" <?php if($_SESSION['helpdesk_page']=="task monitor report.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="task monitor report.php">Monitoring Report</a></li>
</ul>

	
</div>	<!-- end the menuh div --> 
</td>
</td>
</table>
</td>






<?php

?>
