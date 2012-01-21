<?php



if(!empty($_REQUEST['sendmessage']))
	$sendmessage = $_REQUEST['sendmessage'];
else
	$sendmessage = "";


?>

<?php
#
# Copyright (c) Go DEALER to DEALER
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/dms/index.php,v 1.21 2002/10/08 05:42:49 steve Exp $
#

$page_title = 'Send a Message';

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (isset($id)) {
	$ae_array = findAEforDM($dm_id);
	if (!in_array($id, $ae_array)) {
		header('Location: https://www.godealertodealer.com');
		exit;
	}
}

if (isset($did) && $did!=-1) {
	$dealers_array = findDEALERforAE($id);
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
list($dm_uid) = db_row($result);
$from_user = $dm_uid;

if ($sendmessage && count($to_users)>0) {
	for ($i = 0; $i < count($to_users); $i++) {
		$to_user = $to_users[$i];
		db_do("INSERT INTO alerts SET to_user='$to_user', from_user='$from_user',
				title='$title', description='$description', modified=NOW()");
	}
?>
		<html><head><title><?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../site.css" title="site" /></head>
		<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><?php include('../header.php'); ?>
		<?php include('_links.php'); ?><p align="center" class="big"><b><?= $page_title ?></b></p>
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
					<td><a href="alerts.php">Alerts From Other DMs</a></td><td><?=$alert_dm;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="alerts.php">Alerts From AEs</a></td><td><?=$alert_ae;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="alerts.php">Alerts From Dealerships</a></td><td><?=$alert_dl;?></td>
				</tr>
			</table>
		</td>
		<td width="60%" align="center" class="header"><br><br>Message Sent.</td>
		<td width="20%">&nbsp;</td>
	</tr>
</table>

<?php } else { ?>

<html>
 <head>
  <title><?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>
<?php include('_links.php'); ?>
<p align="center" class="big"><b><?=$page_title?></b></p>
<?php if ($sendmessage && !isset($to_users)) { ?>
	<font class="header" color="#FF0000"><p align="center">Error: Message Needs a Sender.</p></font><p>
<?php } ?><br>
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
					<td><a href="alerts.php?id=dm">Alerts From Other DMs</a></td><td><?=$alert_dm;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="alerts.php?id=ae">Alerts From AEs</a></td><td><?=$alert_ae;?></td>
				</tr>
				<tr valign="top" class="normal">
					<td><a href="alerts.php">Alerts From Dealerships</a></td><td><?=$alert_dl;?></td>
				</tr>
			</table>
		</td>

		<?php if (!isset($did) && !isset($id) && !isset($dmid) && !isset($aeid)) { ?>
		<!-- Middle Column -->
		<td width="60%" valign="top">
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="350">
				<tr valign="top">






					<td class="normal">&nbsp;<br>
			<?php $result = db_do("SELECT id, CONCAT(last_name, ', ', first_name) FROM aes
									WHERE dm_id='$dm_id' AND status='active' ORDER BY last_name");
			while (list($ae_id, $ae_name) = db_row($result)) { ?>
				&bull;&nbsp;&nbsp <a href="index.php?id=<?=$ae_id?>"><?=$ae_name?></a><br>
			<?php } ?>
				<br><br>&nbsp;
					</td>
				</tr>
			</table>
		</td>

		<!-- Right Column -->
		<td width="20%" valign="top">
			<table border="0" cellpadding="5" cellspacing="5" width="100%">
				<tr><td align="left" class="normal">&nbsp;</td></tr>
			</table>
		</td>
	<?php }
	elseif (isset($id) && !isset($dmid) && !isset($aeid) && !isset($did)) { ?>
		<!-- Middle Column -->

		<td width="60%" valign="top">
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="350">
				<tr>
					<td class="normal">
			<?php $result = db_do("SELECT user_id, CONCAT(last_name, ', ', first_name) FROM aes
									WHERE dm_id='$dm_id' AND status='active' AND id='$id' ORDER BY last_name");
			list($ae_user_id, $ae_name) = db_row($result); ?>
				&bull;&nbsp;&nbsp <a href="index.php?id=<?=$id?>&aeid=<?=$ae_user_id?>"><?=$ae_name?></a><br><br>

			<?php $result = db_do("SELECT id, name FROM dealers WHERE ae_id='$id' AND status='active' ORDER BY name");
			while (list($did, $dname) = db_row($result)) { ?>
				&bull;&nbsp;&nbsp <a href="index.php?id=<?=$id?>&did=<?=$did?>"><?=$dname?></a><br>
			<?php } ?>
				<br><br>&nbsp;

					</td>
				</tr>
			</table>
		</td>

		<!-- Right Column -->
		<td width="20%" valign="top">
			<table border="0" cellpadding="5" cellspacing="5" width="100%">
				<tr><td align="left" class="normal">&nbsp;</td></tr>
			</table>
		</td>
	<?php }
	else { ?>
			<!-- Middle Column -->
		<td width="5%" valign="top"></td>
		<td width="25%" valign="top">
		<form action="<?php echo $PHP_SELF; ?>" method="post">
			<table border="0" cellpadding="0" cellspacing="5" width="100%">

				<tr><td align="left" class="header">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Send to Who</u><br></td></tr>
				<tr><td align="left" class="normal">

			<?php
			if (isset($dmid)) {
				$result = db_do("SELECT users.id, CONCAT(users.first_name, ' ', users.last_name), users.username FROM dms, users
					WHERE dms.id='$dmid' and dms.user_id=users.id");
			list($uid, $name, $uname) = db_row($result) ?>
				<input checked type="checkbox" name="to_users[]" value="<?=$uid?>"><?=$name?><br>
			<?php }
			elseif (isset($aeid)) {
				$result = db_do("SELECT user_id, CONCAT(first_name, ' ', last_name) FROM aes WHERE id='$id'");
			list($uid, $name) = db_row($result) ?>
				<input checked type="checkbox" name="to_users[]" value="<?=$uid?>"><?=$name?><br>
			<?php }
			elseif (isset($did)) {
				$result = db_do("SELECT id, CONCAT(first_name, ' ', last_name), username FROM users
					WHERE dealer_id='$did' ORDER BY last_name");
			while (list($uid, $name, $uname) = db_row($result)) { ?>
				<input type="checkbox" name="to_users[]" value="<?=$uid?>"><?=$name." (".$uname.")"?><br>
			<?php } } ?>
				</td></tr>
				<tr><td>&nbsp;</td></tr>
        	</table>
		</td>

		<!-- Right Column -->
		<td valign="top" width="50%">
			<input type="hidden" name="to_user" value="<?php echo $to_user; ?>" />
				<?php if (isset($id)) { ?>
				<input type="hidden" name="id" value="<?=$id?>" />
				<?php } if (isset($dmid)) { ?>
				<input type="hidden" name="dmid" value="<?=$dmid?>" />
				<?php } if (isset($aeid)) { ?>
				<input type="hidden" name="aeid" value="<?=$aeid?>" />
				<?php } if (isset($did)) { ?>
				<input type="hidden" name="did" value="<?=$did?>" />
				<?php } ?>
			<table align="left" border="0" cellpadding="1" cellspacing="0">
			   <tr>
				<td valign="top" class="header">Subject: </td>
				<td class="normal"><input name="title" size="40" value="<?=$title?>">
				</td>
			  </tr>
			  <tr>
				<td valign="top" class="header">Message: </td>
				<td class="normal"><textarea name="description" cols="40" rows="15" wrap="VIRTUAL"><?=$description?></textarea>
				</td>
			  </tr>
			  <tr align="center" >
				<td valign="top" class="header"></td>
				<td class="normal"><input type="submit" name="sendmessage" value="Send Message" />
				</td>
			  </tr>
			</table>
			</form>
		</td>
	<?php } ?>

	</tr>
</table>

<?php }
db_disconnect();
include('../footer.php');
?>