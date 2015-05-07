<?php
//background-color:#66ceae;
?>
<td width="15%" align=center valign="top"  style="background-color:#66ceae;border-left-style: solid; border-left-width: 1px; border-left-color:black; border-right-style: none; border-right-width: 1px; border-top-style: none; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black; border-color:#FF600;" bordercolor="#FF6600">
<table width=100% >
<tr>
<td>

<div id="menuh" align=left>
<ul id="">
<li><a id="USERMANAGE" <?php if($_SESSION['helpdesk_page']=="userManagement.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="userManagement.php">Configure Helpdesk Staff</a></li>
<li><a id="ASSIGN" <?php if($_SESSION['helpdesk_page']=="taskmonitor.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="taskmonitor.php">Incoming Client Requests</a></li>
<li><a id="PENDING" <?php if($_SESSION['helpdesk_page']=="pendingRequests.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="pendingRequests.php">Pending Requests</a></li>
<li><a id="STAFF_REPORT" <?php if($_SESSION['helpdesk_page']=="dispatch monitor report.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="dispatch monitor report.php">Dispatcher Status Report</a></li>
<li><a id="CLIENT_REPORT" <?php if($_SESSION['helpdesk_page']=="task monitor report.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="task monitor report.php">Monthly Requests Report</a></li>
</ul>

	
</div>	<!-- end the menuh div --> 
</td>
</td>
</table>
</td>






<?php

?>
