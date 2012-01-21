
<?php
#
# Copyright (c) 2002 Steve Price
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
# $srp: godealertodealer.com/htdocs/aes/index.php,v 1.21 2002/10/08 05:42:49 steve Exp $
#

$page_title = 'Send a Message';
$no_menu = 1;

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();
extract(defineVars("sendmessage"));


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

$result = db_do("SELECT id FROM users WHERE username='$username'");
list($ae_uid) = db_row($result);
$from_user = $ae_uid;
$page_link = '../docs/chp3.php#Chp3_SendMessage';

if ($sendmessage && count($to_users)>0) {
	for ($i = 0; $i < count($to_users); $i++) {
		$to_user = $to_users[$i];
		db_do("INSERT INTO alerts SET to_user='$to_user', from_user='$from_user',
				title='$title', description='$description', modified=NOW()");
	}
?>
		<html><head><title>Account Executive Summary: <?= $page_title ?></title>
		<link rel="stylesheet" type="text/css" href="../../site.css" title="site" /></head>
		<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<?php include('../header.php'); ?>
		<?php include('_links.php'); ?>
		<p align="center" class="big"><b><?= $page_title ?></b></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">

		<!-- Left Column -->
		<td bgcolor="#EEEEEE" width="20%">
		<?php include('../_alerts.php'); ?>
		</td>
		<td width="60%" align="center" class="header"><br><br>Message Sent.</td>
		<td width="20%">&nbsp;</td>
	</tr>
</table>

<?php } else { ?>

<html>
 <head>
  <title>Account Executive Summary: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?><?php include('_links.php'); ?>
<p align="center" class="big"><b><?= $page_title ?></b></p>
<?php if ($sendmessage && !isset($to_users)) { ?>
	<font class="header" color="#FF0000"><p align="center">Error: Message Needs a Sender.</p></font><p>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">

		<!-- Left Column -->
	  <td bgcolor="#EEEEEE" width="20%">
		<?php include('../_alerts.php'); ?>
	  </td>

		<?php if (!isset($did) && !isset($submit)) { ?>
		<!-- Middle Column -->
		<td width="60%" valign="top">
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="500">
			<form action="index.php" method="post">
				<tr class="header">
					<td><br>District Manager</td>
					<td><br>Account Executives</td>
					<td><br>Dealerships</td>
				</tr>
				<tr valign="top">
					<td class="normal">
			<?php $result = db_do("SELECT dms.id, dms.user_id, CONCAT(dms.first_name, ' ', dms.last_name) FROM dms, aes WHERE aes.id='$ae_id' AND aes.dm_id=dms.id");
			list($dmid, $dm_uid, $dm_name) = db_row($result); ?>
				<input type="checkbox" value="<?=$dm_uid?>" name="send_alert[]"><?=$dm_name?><br>
				</td>
				<td class="normal">
			<?php $result = db_do("SELECT user_id, CONCAT(first_name, ' ', last_name) FROM aes WHERE dm_id='$dmid' AND status='active'");
			while (list($ae_uid, $ae_name) = db_row($result)) {
				if ($ae_uid!=$dm_uid) { ?>
					<input type="checkbox" value="<?=$ae_uid?>" name="send_alert[]"><?=$ae_name?><br>
			<?php } } ?>
					</td>
					<td class="normal">
			<?php $result = db_do("SELECT dealers.id, dealers.name FROM aes, dealers, users WHERE users.username='$username'
				AND aes.user_id=users.id AND dealers.ae_id = aes.id AND dealers.status='active' ORDER BY dealers.name");
			while (list($dealer_id, $name) = db_row($result)) { ?>
				<a href="index.php?did=<?=$dealer_id?>"><?=$name?></a><br>
			<?php } ?>
				<br><br>
					</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3" align="center">
				<input type="hidden" name="ae_id" value="<?=$ae_id?>">
				<input type="hidden" name="dmid" value="<?=$dmid?>">
				<input type="submit" name="submit" value="Submit"></td></tr>
			</form>
			</table>
		</td>

		<!-- Right Column -->
		<td width="20%" valign="top">
			<table border="0" cellpadding="5" cellspacing="5" width="100%">
				<tr><td align="left" class="normal">&nbsp;</td></tr>
			</table>
		</td>
	<?php } else { ?>
			<!-- Middle Column -->
		<td width="5%" valign="top"></td>
		<td width="25%" valign="top">
		<form action="<?php echo $PHP_SELF; ?>" method="post">
			<table border="0" cellpadding="0" cellspacing="5" width="100%">

				<tr><td align="left" class="header">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Send to Who</u><br></td></tr>
				<tr><td align="left" class="normal">

			<?php
			if (isset($submit) && is_array($send_alert)) {
				$result = db_do("SELECT dms.id, dms.user_id, CONCAT(dms.first_name, ' ', dms.last_name) FROM dms, aes WHERE aes.id='$ae_id' AND aes.dm_id=dms.id");
				list($dm_id, $dm_uid, $dm_name) = db_row($result);
				if (in_array($dm_uid, $send_alert)) { ?>
					<input checked type="checkbox" value="<?=$dm_uid?>" name="to_users[]"><?=$dm_name?><br>
				<?php }
				else { ?>
					<input type="checkbox" value="<?=$dm_uid?>" name="to_users[]"><?=$dm_name?><br>
				<?php }

				$result = db_do("SELECT user_id, CONCAT(first_name, ' ', last_name) FROM aes WHERE dm_id='$dm_id' AND status='active'");
				while(list($ae_uid, $ae_name) = db_row($result)) {
					if ($ae_uid!=$dm_uid) {
						if (in_array($ae_uid, $send_alert)) { ?>
							<input checked type="checkbox" value="<?=$ae_uid?>" name="to_users[]"><?=$ae_name?><br>
						<?php }
						else { ?>
							<input type="checkbox" value="<?=$ae_uid?>" name="to_users[]"><?=$ae_name?><br>
						<?php } } } }
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
		<td align="center" valign="top" width="50%">
				<input type="hidden" name="to_user" value="<?php echo $to_user; ?>" />
				<?php if (isset($send_alert)) { ?>
				<input type="hidden" name="send_alert" value="<?=$send_alert?>" />
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