<?php
//background-color:#66ceae;
?>
<td width="15%"  align=center valign="top"  style="height:100%;background-color:#66ceae;border-left-style: solid; border-left-width: 1px; border-left-color:black; border-right-style: none; border-right-width: 1px; border-top-style: none; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black; border-color:#FF600;" bordercolor="#FF6600">
<table width=100% >
<tr>
<td>

<div id="menuh" align=left>
<ul id=""><li><a id="CREATE" <?php if($_SESSION['helpdesk_page']=="createTask.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="createTask.php">Submit Issue/Problem</a></li><li><a id="MONITOR" <?php if($_SESSION['helpdesk_page']=="trackTasks.php"){ echo "class='active'"; echo " style='color: black;background-color: #ed5214;'"; } ?> href="trackTasks.php">Monitor Current Requests</a></li>
</ul>

	
</div>	<!-- end the menuh div --> 
</td>
</td>
</table>
</td>






<?php

?>
