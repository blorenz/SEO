

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
# $srp: godealertodealer.com/htdocs/auction/bids/closed.php,v 1.9 2002/09/03 00:40:32 steve Exp $
#

$page_title = "District Manager: Alerts";

include('../../../include/session.php');
include('../../../include/db.php');
extract(defineVars(""sent",  "delbox"));    // Added by RJM 1/1/10


db_connect();

$dm_id = findDMid($username);
if (!isset($dm_id)) {
	header('Location: https://www.godealertodealer.com');
	exit;
}

if (count($delbox) > 0) {
	$count=count($delbox);
	for ($i=0;$i<$count;$i++)
		db_do("DELETE FROM alerts WHERE id='$delbox[$i]'" );
}

$dm_user_ids = findDMuserids();
$ae_user_ids = findAEuserids();

?>
<html>
 <head>
  <title><?= $page_title ?></title>
  <link rel="stylesheet" type="text/css" href="../../site.css" title="site" />
 </head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../header.php');

	$result = db_do("SELECT id, from_user, title, auction_id, DATE_FORMAT(modified, '%c/%e/%y %H:%i')
						FROM alerts WHERE to_user='$userid' AND from_user!='0'");
?>
  <br><p align="center" class="big"><b>My Alerts</b></p><br>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if ($sent==1)
	echo "<tr><td align='center' class='big' colspan='9'><font class='header'>Your Last Message was Sent Successfully.<br></font></td></tr>";

if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="left" class="big" colspan="6">&nbsp;No Alerts found.</td>
   </tr>
<?php
} else {
?>
   <tr>
   	<td>&nbsp;</td>
	<td class="header" align="center">Delete</td>
	<td class="header">&nbsp;</td>
	<td class="header">Time</td>
	<td class="header">From</td>
    <td class="header">Subject</td>
   </tr>
   <form action="alerts.php" method="POST">
<?php
	$bgcolor = '#FFFFFF';
	while (list($alert_id, $from_user, $title, $auction_id, $timesent) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		if(in_array($from_user, $dm_user_ids))
			$from_type = "<b><font color='#CC0000'>District Manager</font></b>";
		elseif(in_array($from_user, $ae_user_ids))
			$from_type = "<b><font color='#009900'>Account Executive</font></b>";
		else
			$from_type = "<b><font color='#0000CC'>Dealership</font></b>";

		$result_from_user = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM users WHERE id='$from_user' ORDER BY last_name");
		list($from_user) = db_row($result_from_user);

	if ($auction_id > 0) {
		$title = "Counter Offer for Auction #$auction_id";
		$from_user = "Seller";
		$link = "bids/makeoffer.php?id=$aid";
	}
	else
		$link = "message.php?alert=$alert_id";
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
   	<td class="normal"><a href="<?=$link?>"><font color="#FF0000">view</font></a></td>
	<td align="center" class="normal"><input type="checkbox" name="delbox[]" value=<?=$alert_id?> /></td>
	<td class="normal"><?=$from_type?></td>
	<td class="normal"><?=$timesent?></td>
	<td class="normal"><?=$from_user?></td>
    <td class="normal"><?=$title?></td>
   </tr>
<?php 	} ?>
	<tr><td colspan="1"></td><td colspan="7" align="left">
	<input type="submit" name="submit" value="Delete"></td></tr></form>
<?php } ?>
</table>
<?php
db_free($result);
db_disconnect();
include('../footer.php');
?>
