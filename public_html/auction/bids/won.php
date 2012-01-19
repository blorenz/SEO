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
# $srp: godealertodealer.com/htdocs/auction/bids/won.php,v 1.6 2002/09/03 00:40:32 steve Exp $
#

include('../../../include/session.php');
extract(defineVars( "q", "page_title", "no_menu"));    // Added by RJM 1/4/10


if (!has_priv('buy', $privs)) {
	header('Location: ../menu.php');
	exit;
}

include('../../../include/db.php');
db_connect();

$sql = "SELECT COUNT(*) FROM auctions, bids WHERE auctions.status='closed' " .
    "AND auctions.chaching=1 AND bids.dealer_id='$dealer_id' AND " .
    "auctions.id=bids.auction_id AND auctions.winning_bid=bids.id";

$help_page = "chp5_check.php";

include('../../../include/list.php');
include('../header.php');

$result = db_do("SELECT bids.id, auctions.id, auctions.title, " .
    "users.username, auctions.winning_bid, auctions.status, " .
    "bids.current_bid, bids.opening_bid, bids.maximum_bid, auctions.vehicle_id FROM auctions, " .
    "bids, users WHERE auctions.status='closed' AND auctions.chaching=1 AND " .
    "bids.dealer_id='$dealer_id' AND auctions.id=bids.auction_id AND " .
    "auctions.winning_bid=bids.id AND bids.user_id=users.id " .
    "ORDER BY auctions.id DESC, auctions.id LIMIT $_start, $limit");
?>
  <br />
  <p align="center" class="big"><b>Bids for Auctions Won</b></p>
<?php include('_links.php'); ?>
  <table align="center" border="0" cellpadding="5" cellspacing="0" width="95%">
<?php
if (db_num_rows($result) <= 0) {
?>
   <tr>
    <td align="center" class="big">No bids found.</td>
   </tr>
<?php
} else {
?>
   <tr><td colspan="9"><?php echo $nav_links; ?></td></tr>
   <tr>
   	<td>&nbsp;</td>
    <td class="header">Auction Name</td>
    <td class="header">Bidder</td>
    <td class="header">Winning Bid</td>
   </tr>
<?php
	$bgcolor = '#FFFFFF';
	while (list($bid, $aid, $title, $un, $winning_bid, $status,
	    $current_bid, $opening_bid, $maximum_bid, $vid) = db_row($result)) {
		$bgcolor = ($bgcolor == '#FFFFFF') ? '#E6E6E6' : '#FFFFFF';

		$r = db_do("SELECT photo_id FROM vehicles WHERE id='$vid'");
		list($photo_id) = db_row($r);
		db_free($r);

		$r = db_do("SELECT id FROM photos WHERE vehicle_id='$vid'");
		list($photoid) = db_row($r);
		db_free($r);

		if ($photo_id == 0)
			$photo_id = $photoid;

		if ($photo_id > 0)
			$pic = '<img src="../uploaded/thumbnails/'.$photo_id.'.jpg" alt="Click here to view photo" border="0">';
		else
			$pic = '';

		$current_bid = number_format($current_bid, 2);

		if ($status == 'open') {
			if ($bid == $winning_bid)
				$status = 'winning';
			else
				$status = 'losing';
		} elseif ($status == 'closed') {
			if ($bid == $winning_bid)
				$status = 'won';
			else
				$status = 'lost';
		}
?>
   <tr bgcolor="<?php echo $bgcolor; ?>">
   	<td align="center" valign="middle"><a href="../auction.php?id=<?php echo $aid; ?>"><?=$pic?></a></td>
    <td class="normal"><a href="../auction.php?id=<?php echo $aid; ?>"><?php echo $title; ?></a></td>
    <td class="normal"><?php echo $un; ?></td>
    <td align="right" class="normal">US $<?php echo $current_bid; ?></td>
   </tr>
<?php
	}
}

db_free($result);
db_disconnect();
?>
  </table>
<?php include('../footer.php'); ?>
