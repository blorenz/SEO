<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$no_menu = 1;
$page_title = "Change Password";

$ae_id = findAEid($username);
if (!isset($ae_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
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

if (isset($submit)) {
	$result = db_do("SELECT password FROM users WHERE id='$userid'");
	list($pass) = db_row($result);
	
	if ($pass != $old_pass)
		$errors = "<li>Your Current Password does not match the one you typed in</li>";
		
	if ($new_pass != $confirm_pass)
		$errors .= "<li>New Password did not equal Confirm Password</li>";
		
	if (strlen($new_pass) < 4)
		$errors .= "<li>Your New Password must be at least 4 characters long</li>";
		
	if (!isset($errors))
		db_do("UPDATE users SET password='$new_pass' WHERE id='$userid'");
		
	
}

?>
<html>
 <head>
  <title>Account Executive Summary: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><br>
<p align="center" class="big"><b><?=$page_title?></b></p>
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
					<td><a href="message/alerts.php">Alerts From District Manager</a></td><td><?=$alert_dm;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="message/alerts.php">Alerts From Other AEs</a></td><td><?=$alert_ae;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="message/alerts.php">Alerts From Dealerships</a></td><td><?=$alert_dl;?></td>					
				</tr>
			</table>
		</td>
		
		<!-- Middle Column -->
		<td valign="top" width="60%"><form method="post" action="<?=$PHP_SELF?>">
			<table align="center" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php if (isset($errors)) { ?>
				<tr>
					<td class="error" colspan="2"><?=$errors?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php } ?>
				<?php if ( (isset($submit) && isset($errors)) || (!isset($submit) && !isset($errors)) ) { ?>
				<tr>
					<td align="right" class="header">Old Password:</td>
					<td class="normal"><input name="old_pass" type="password" size="25"></td>
				</tr>
				<tr>
					<td align="right" class="header">New Password:</td>
					<td class="normal"><input name="new_pass" type="password" size="25"></td>
				</tr>
				<tr>
					<td align="right" class="header">Confirm Password:</td>
					<td class="normal"><input name="confirm_pass" type="password" size="25"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input type="submit" name="submit" value="Submit"></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php }
				else { ?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center" class="error" colspan="2">Password Saved.</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php } ?>
			</table></form><br><br><br><br><br>
		</td>
		
		<!-- Right Column -->
		<td width="20%" valign="top" bgcolor="#EEEEEE">		
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<td align="center" bgcolor="#000066"><font color="#FFFFFF" size="-1"><b>Internal News</b></font></td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<?php
db_disconnect();
include('../footer.php');
?>