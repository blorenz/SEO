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
# $srp: godealertodealer.com/htdocs/auction/highest.php,v 1.6 2002/09/03 00:37:29 steve Exp $
#

$page_title = 'Highest Bids';
$help_page = "chp2.php";


include('../../include/session.php');
include('../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM auctions WHERE status='open' AND current_bid > 0";

include('../../include/list.php');
include('header.php');

$result = db_do("SELECT auctions.id, auctions.title, auctions.current_bid, " .
    "auctions.ends, categories.name, vehicles.photo_id, vehicles.id FROM auctions, categories, vehicles " .
    "WHERE auctions.status='open' AND auctions.current_bid > 0 AND auctions.vehicle_id=vehicles.id AND " .
    "auctions.category_id=categories.id ORDER BY auctions.current_bid DESC " .
    "LIMIT $_start, $limit");
?>

  <br>
  <p align="center" class="big"><b><?php echo $page_title; ?></b></p>
  <table align="center" border="0" cellspacing="0" cellpadding="5">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No open auctions found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="5"><?php echo $nav_links; ?></td></tr>
   <tr>
    <td class="header"></td>
    <td class="header"></td>
    <td class="header"><b>Auction Name</b></td>
    <td align="center" class="header"><b>High Bid (US)</b></td>
    <td align="center" class="header"><b># of Bids</b></td>
    <td class="header"><b>Time Left</b></td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($id, $title, $current_bid, $ends, $category, $photo_id, $vid)
	    = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';

		$timeleft = timeleft($ends);
		if (empty($timeleft) || $timeleft < 0)
			$timeleft = '<font color="#FF0000">closed</font>';

		if (empty($current_bid) || $current_bid <= 0)
			$current_bid = '--';
		else
			$current_bid = number_format($current_bid, 2);

		$r = db_do("SELECT COUNT(*) FROM bids WHERE auction_id='$id'");
		list($num_bids) = db_row($r);
		db_free($r);
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
    <td class="normal"><?php tshow($category); ?></td>
	<td class="normal" align="center"><a href="auction.php?id=<?php echo $id; ?>"><?php tshow($pic); ?></a></td>
    <td class="normal"><a href="auction.php?id=<?php echo $id; ?>"><?php tshow($title); ?></a></td>
    <td align="center" class="normal">$<?php tshow($current_bid); ?></td>
    <td align="center" class="normal"><?php tshow($num_bids); ?></td>
    <td class="normal"><?php tshow($timeleft); ?></td>
   </tr>
<?php
	}
}

db_free($result);
?>
  </table>

<?php
db_disconnect();
include('footer.php');
?>
