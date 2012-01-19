
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

$PHP_SELF = $_SERVER['PHP_SELF'];

include('../../include/session.php');
include('../../include/db.php');
db_connect();
extract(defineVars("no_menu", "q", "pic","delbox", "sent", "page_title", "help_page","delete","submit"));



if (count($delbox) > 0) {
	$count=count($delbox);
	for ($i=0;$i<$count;$i++)
		db_do("UPDATE alerts SET status='delete' WHERE id='$delbox[$i]'" );
}

include('header.php');

$sql = "SELECT id, from_user, title, auction_id, DATE_FORMAT(modified, '%c/%e/%y %H:%i'), vehicle_id
FROM alerts WHERE ((alerts.to_user='$userid' AND alerts.from_user!='0') OR ((alerts.to_user='$userid' OR alerts.from_user = '$userid') AND alerts.auction_id > '0' AND title IS NULL AND offer_value > 0) OR
      (alerts.to_user='$userid' AND alerts.vehicle_id is not null AND title = 'Auction Request'))
                  and status='pending'";

	$result = db_do($sql);
?>
  <br><p align="center" class="big"><b>My Alerts</b></p><br>
  <table align="center" border="0" cellpadding="5" cellspacing="0">
<?php
if ($sent==1)
	echo "<p align='center'><font class='header'>Your Last Message was Sent Successfully.</font></p>.";

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
   	<td>&nbsp;</td>
	<td class="header" align="center">Select <br>to Delete</td>
	<td class="header">Time</td>
	<td class="header">From</td>
    <td class="header">Subject</td>
   </tr>
   <form action="alerts.php?delete=1" method="POST">
<?php
	$bgcolor = '#FFFFFF';
	while (list($alert_id, $from_user, $title, $auction_id, $timesent, $vehicle_id) = db_row($result)) {

		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$result_from_user = db_do("SELECT CONCAT(first_name, ' ', last_name) FROM users WHERE id='$from_user' ORDER BY last_name");
		list($from_user) = db_row($result_from_user);

      $link = "message.php?alert=$alert_id";
      $show_del = true;

	if ($auction_id > 0) {
		$title = "Counter Offer for Auction #$auction_id";
		$from_user = "Dealership";
		$link = "bids/makeoffer.php?id=$auction_id";
      $show_del = false;
	}

   if($auction_id == 0 && $vehicle_id != null) {
      $from_user = 'Dealership';
      $link = "vehicles/auction_requested.php?vid=$vehicle_id";
      $show_del = false;
   }

   if($vehicle_id != null) {
      $photo_res = db_do("SELECT photo_id FROM vehicles WHERE id=$vehicle_id");
      list($photo_id) = db_row($photo_res);
      db_free($photo_res);

      $r = db_do("SELECT id FROM photos WHERE vehicle_id='$vehicle_id'");
      list($photoid) = db_row($r);
      db_free($r);

      if($photo_id == 0) {
         $photo_id = $photoid;
      }

      if ($photo_id > 0) {
         $pic = '<a href="' . $link . '"><img src="uploaded/thumbnails/'.$photo_id.'.jpg height = 60" alt="Click here to view alert." border="0" /></a>';
      } else {
         $pic = '';
      }
   }

?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
      <td class="normal"><?php echo $pic ?></td>
   	<td class="normal"><a href="<?=$link?>"><font color="#FF0000">view</font></a></td>

      <td align="center" class="normal">
         <?php if($show_del) { ?>
         <input type="checkbox" name="delbox[]" value=<?=$alert_id?> />
         <?php } else { ?>
         N/A
         <?php } ?>
      </td>
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
include('footer.php');
?>
