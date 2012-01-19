<?php

include('../../../include/session.php');
include('../../../include/db.php');
db_connect();

if (isset($delete) || isset($return)) {
	if (isset($delete))
		db_do("DELETE FROM alerts WHERE id='$alert'" );
	header('Location: alerts.php');
	exit;
	
}
elseif (isset($reply)) {
	$title = "RE: ".$title;
	$description = "\n\n\n--------------------------------------------\n> From: $from_user_info\n> $modified\n>\n> $description";
	$page_title = "Reply to Message";
}
elseif (isset($send)) {
	$result = db_do("SELECT id FROM users WHERE username='$username'");
	list($to_user) = db_row($result);
	db_do("INSERT INTO alerts SET to_user='$from_user', from_user='$to_user', 
				title='$title', description='$description', modified=NOW()");
		header('Location: alerts.php?sent=1');
		exit;
}
else {
	$result_offer = db_do("SELECT from_user, title, description, DATE_FORMAT(modified, '%W, %M %e %Y %l:%i %p') 
							FROM alerts WHERE to_user='$userid' AND id='$alert'");
	if (db_num_rows($result_offer) <= 0){
		header('Location: alerts.php');
		exit;	
	} else {
		list($from_user, $title, $description, $modified) = db_row($result_offer);
		$page_title = "Read Message";
	}
}

$result_from_user = db_do("SELECT CONCAT(first_name, ' ', last_name), username, dba FROM users u, dealers d WHERE u.id='$from_user' AND d.id = u.dealer_id");
list($from_user_info, $uname, $dealership) = db_row($result_from_user);
?>
<html>
 <head>
  <title>Account Executive Summary: <?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php'); ?>

<br>
<p align="center" class="big"><u><b><?=$page_title?></b></u></p><br>
<form action="<?php echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="alert" value="<?=$alert?>" />
<input type="hidden" name="from_user" value="<?=$from_user?>" />
<input type="hidden" name="title" value="<?=$title?>" />
<input type="hidden" name="description" value="<?=$description?>" />
<input type="hidden" name="modified" value="<?=$modified?>" />
<input type="hidden" name="from_user_info" value="<?=$from_user_info?>" />
<table align="center" border="0" cellspacing="0" cellpadding="2">
	<tr>
	<?php if(isset($reply)) { ?>
		<td align="right" class="header">To:</td>
	<? } else { ?>
		<td align="right" class="header">From:</td>
	<? } ?>
		<td align="left" class="normal"><?=$from_user_info." (".$uname.") - $dealership"?></td>
	</tr>
	<?php if(!isset($reply)) { ?>
	<tr>
		<td align="right" class="header">Time:</td>
		<td align="left" class="normal"><?=$modified?></td>
	</tr>
	<?php } ?>
	<tr>
		<td align="right" class="header">Subject:</td>
		<td align="left" class="normal">
	<?php if(isset($reply)) { ?>
		<input type="text" name="title" value="<?=$title?>">
	<?php } else { ?>
		<?=$title?>
	<?php } ?></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="header">Message:</td>
		<td width="250" align="left" class="normal">
		<textarea name="description" rows="10" cols="50" wrap="virtual" <?php if(!isset($reply)) { ?>readonly<?php } ?>><?=$description?></textarea></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
	  <td colspan="2" align="center" class="header">
	<?php if(isset($reply)) { ?>
		<input type="submit" name="send" value="Send Message">
	<? } else { ?>
		<input type="submit" name="reply" value="Reply">
		<input type="submit" name="delete" value="Delete">
		<input type="submit" name="return" value="Main Menu">
	<?php } ?></td>
	</tr>
</table>
</form>
  
<?php include('../footer.php');
db_disconnect();
?>
