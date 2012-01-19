<?php

$page_title = 'Online Tools';

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (isset($did)) {
	$dealers_array = findDEALERforAE($ae_id);
	if (!in_array($did, $dealers_array)) {
		header('Location: https://www.godealertodealer.com');
		exit;
	}
}

$alert_ds = 0;
$alert_dm = 0;
$alert_ae = 0;
$alert_dl = 0;

$dm_user_ids = findDMuserids();
$ae_user_ids = findAEuserids();

$result_alerts = db_do("SELECT from_user FROM alerts WHERE to_user='$userid' AND from_user!='0'");
while (list($from_user) = db_row($result_alerts)) {
	if(in_array($from_user, $dm_user_ids))
		$alert_dm++;
	elseif(in_array($from_user, $ae_user_ids))
		$alert_ae++;
	else
		$alert_dl++;
}

$total_alerts = $alert_ds + $alert_dm + $alert_ae + $alert_dl;

$result = db_do("SELECT id FROM users WHERE username='$username'");
list($ae_uid) = db_row($result);
$from_user = $ae_uid;
?>

<html><head><title>Account Executive: <?= $page_title ?></title>
<link rel="stylesheet" type="text/css" href="../../site.css" title="site" /></head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><br>
<p align="center" class="big"><b><?= $page_title ?></b></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
	
		<!-- Left Column -->
		<td bgcolor="#EEEEEE" width="20%">
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
					<td><a href="../message/alerts.php">Alerts From District Manager</a></td><td><?=$alert_dm;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="../message/alerts.php">Alerts From Other AEs</a></td><td><?=$alert_ae;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="../message/alerts.php">Alerts From Dealerships</a></td><td><?=$alert_dl;?></td>					
				</tr>
			</table>
		</td>
		
		<!-- Middle Column -->
		<td width="60%" align="center" class="header">
			<br><br>
			<table border="0" cellspacing="0" cellpadding="0" class="header">
				<tr>
					<td><li><a href="calculator.php">Pbysical Auction Cost Calculator</a></li> </td>
				</tr>
				<tr>
					<td><li><a href="documents.php">Online Library</a></li> </td>
				</tr>
				<tr>
					<td><li><a href="reset_pass.php">Change Your Password</a></li> </td>
				</tr>
			</table>
			<br><br><br><br><br>&nbsp;
		</td>
		
		<!-- Right Column -->
		<td width="20%"></td>
	</tr>		
</table>

<?php
db_disconnect();
include('../footer.php');
?>