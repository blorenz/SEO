 <?php

$PHP_SELF = $_SERVER['PHP_SELF'];


$page_title = "Online Documents & Support";

include('../../include/session.php');
include('../../include/db.php');
db_connect();
extract(defineVars("no_menu", "help_page", "q"));


include('../auction/header.php');
extract(defineVars("no_menu", "help_page", "q"));


?><br>

	<table align="center" border="0" cellpadding="3" cellspacing="0" class="normal">
				<tr><td width="258" align="center" class="big"><b><?=$page_title?></b></td></tr>
				<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
				<tr>
					<td><li><a href="http://gdtd.safesecuredemo.com/tutorialspage.php" target="_blank">Online Video Tutorials</a> <b><font color="#FF0000">"NEW"</font></b></li></td>
				</tr>
				<tr>
					<td><li><a href="index.php" target="_blank">Online Help Document</a></li></td>
				</tr>
				<tr>
					<td><li><a href="support" target="_blank">Online Support: Desktop Stream</a></li></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><li><a href="useragreement.htm" target="_blank">User Agreement</a> (modified
					    06/22/06)</li>
					  <li><a href="ua_changes_list.htm" target="_blank">User Agreement Changes</a> </li></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><li><a href="privacy_policy.html" target="_blank">Privacy Policy</a> (modified 08/01/05)</li>
						<li><a href="refund_policy.html" target="_blank">Refund Policy</a> (modified
						  04/17/05)</li>
						<li><a href="arbitration_policy.htm" target="_blank">Arbitration Policy</a> (modified 06/22/06) </li></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table><br><br><br><br><br>&nbsp;

<?php include('../auction/footer.php'); ?>