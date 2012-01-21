<?php
#
# $srp: godealertodealer.com/htdocs/aes/_alerts.php
#

$alert_ds = 0;
$alert_dm = 0;
$alert_ae = 0;
$alert_dl = 0;
$alert_rating = 0;

$dm_user_ids = findDMuserids();
$ae_user_ids = findAEuserids();

$result_alerts = db_do("SELECT from_user FROM alerts WHERE to_user='$userid'");
while (list($from_user) = db_row($result_alerts)) {
	if ($from_user==0) 
		$alert_rating++;
	elseif(in_array($from_user, $dm_user_ids))
		$alert_dm++;
	elseif(in_array($from_user, $ae_user_ids))
		$alert_ae++;
	else
		$alert_dl++;
}

$total_alerts = $alert_ds + $alert_dm + $alert_ae + $alert_dl+$alert_rating;

?>
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<?php if ($total_alerts > 0) { ?>
					<td colspan="2" align="center" bgcolor="#CC0000"><font color="#FFFFFF" size="-1"><b>You have <?=$total_alerts?> Alerts</b></font></td>
					<?php } else { ?>
					<td colspan="2" align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>No Alerts</b></font></td>
					<?php } db_free($result_alerts); ?>
				</tr>
				<tr valign="top" class="normal">
					<td></td>
				</tr>
				<tr valign="top" class="normal">
					<td>New Dealer Signup</td><td><?=$alert_ds;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="http://test.godealertodealer.com/aes/message/alerts.php">Alerts From DM</a></td><td><?=$alert_dm;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="http://test.godealertodealer.com/aes/message/alerts.php">Alerts From Other AEs</a></td><td><?=$alert_ae;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="http://test.godealertodealer.com/aes/message/alerts.php">Alerts From Dealerships</a></td><td><?=$alert_dl;?>
					</td>					
				</tr>
								<tr valign="top" class="normal">
					<td><a href="http://test.godealertodealer.com/aes/message/alerts.php">Alerts From Rating</a></td><td><?=$alert_rating;?>
					</td>					
				</tr>
			</table>
		